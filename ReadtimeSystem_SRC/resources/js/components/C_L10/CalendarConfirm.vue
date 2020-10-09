<template>
  <div class="mt-3">
    <div class="default-search">
      <div class="row">
        <h4 class="col-md-6">デポ稼働日確認画面</h4>
      </div>
      <div>
        <div class="row">
          <div class="col-md-3 form-inline">
            <label class="control-label mr-2">対象年月</label>
            &nbsp;
            <select class="form-control" name="searchYm" v-model="mSearchParam.searchYm">
              <option v-for="(value, key) in ymList" :key="key" :value="key">{{ value }}</option>
            </select>
          </div>
          <div class="col-md-3 form-inline">
            <label class="control-label mr-2">都道府県</label>
            &nbsp;
            <select class="form-control" name="searchPrefCd" v-model="mSearchParam.searchPrefCd">
              <option value="0">---</option>
              <option v-for="item in prefList" :key="item.pref" :value="item.pref">
                  {{ item.prefName }}
              </option>
              <option value="">全県</option>
            </select>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-md-3" style="vertical-align: middle">表示データ</div>
          <div class="col-md-3" style="vertical-align: middle">表示タイプ</div>
        </div>
        <div class="row">
          <div class="col-md-3 form-inline">
            <input type="checkbox" id="approvalChecked" name="searchIsNotApproval" v-model="mSearchParam.searchIsNotApproval" />
            <label class="ml-2 mr-4" for="approvalChecked">未承認データのみ表示</label>
          </div>
          <div class="col-md-6 form-inline">
            <input
              type="radio"
              id="displayTypeAll"
              value="0"
              v-model="mSearchParam.searchDisplayType"
              name="searchDisplayType"
            />
            <label class="ml-2 mr-4" for="displayTypeAll">すべてのデポ</label>
            <template v-for="(value, key) in displayTypeList">
              <input
                type="radio"
                :key="'displayType-radio-' + key"
                :id="'displayType' + key"
                :value="key"
                v-model="mSearchParam.searchDisplayType"
                name="searchDisplayType"
              />
              <label class="ml-2 mr-4" :for="'displayType' + key" :key="'displayType-lavel-' + key">{{ value }}</label>
            </template>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 form-inline">
            <input type="checkbox" id="confirmChecked" name="searchIsNotConfirm" v-model="mSearchParam.searchIsNotConfirm" />
            <label class="ml-2" for="confirmChecked">未確認データのみ表示</label>
          </div>
          <div class="col-md-3"></div>
          <div class="col-md-6 text-right">
            <button type="button" class="btn btn-primary" @click="downloadSetup">CSV出力</button>
            <button type="button" class="btn btn-primary ml-4 mr-4" @click="reset">リセット</button>
            <button type="button" class="btn btn-primary" @click="search">検索</button>
          </div>
        </div>
      </div>
    </div>
    <template v-if="mErrorMsgList.length != 0">
      <div class="error-area">
        <p v-for="msg in mErrorMsgList" :key="msg" v-html="msg"></p>
      </div>
    </template>
    <div class="default-input" v-if="mIsSearch">
      <div class="row">
        <div class="col-md-12 text-right">
          <label class="control-label">検索結果</label>
          <label class="control-label mr-3 ml-3">{{ mCalendarListCoount }}</label>
          <label class="control-label">件</label>
        </div>
      </div>
      <template v-if="mCalendarListCoount != 0">
        <div class="sticky-table div-calendar-table">
          <table class="table-striped table-responsive-stack">
            <colgroup>
              <col class="th-depo">
              <col class="th-pref">
              <col class="th-approval-first">
              <col class="th-approval-second">
              <col class="th-approval-serde">
              <col class="th-confirm">
            </colgroup>
            <thead>
              <tr>
                <th class="th-depo" rowspan="2">デポ名</th>
                <th class="th-pref" rowspan="2">
                  都道
                  <br />府県
                </th>
                <th class="th-approval" colspan="3">承認</th>
                <th class="th-confirm" rowspan="2">確認</th>
                <!-- ここからループ -->
                <th
                  class="target-date"
                  colspan="2"
                  v-for="model in targetDateListComputed"
                  :key="model.ymd"
                  :class="{ 'bg-holiday' : holidayCheck(model.ymd) }"
                >{{ model.d + '日(' + model.week + ')' }}</th>
              </tr>
              <tr>
                <th class="th-approval-first">承認</th>
                <th class="th-approval-second">日付</th>
                <th class="th-approval-serde">承認者</th>
                <!-- ここからループ -->
                <template v-for="targetDate in targetDateListComputed">
                  <th :class="{ 'bg-holiday' : holidayCheck(targetDate.ymd) }" :key="'before-th-' + targetDate.ymd">
                    前日
                    <br />締切
                  </th>
                  <th :class="{ 'bg-holiday' : holidayCheck(targetDate.ymd) }" :key="'today-th-' + targetDate.ymd">
                    当日
                    <br />配送
                  </th>
                </template>
              </tr>
            </thead>
            <tbody>
              <tr :class="{'tr-is-not-approval' : !model.approvalDate}" v-for="model in mCalendarList" :key="model.depoCalId">
                <td class="td-depo"><a @click="depoLink(model)" href="#">{{ model.deponame }}</a></td>
                <td class="td-pref">{{ model.prefName }}</td>
                <td class="td-approval-first">
                  <template v-if="model.approvalDate">承認済</template>
                  <template v-else>
                    <button type="button" class="btn btn-primary" @click="approval(model)">承認</button>
                  </template>
                </td>
                <td
                  class="td-approval-second"
                >{{ model.approvalDate ? model.approvalDate : '' }}</td>
                <td class="td-approval-serde">{{ model.approvalName ? model.approvalName : '' }}</td>
                <td class="td-confirm">{{ model.confirmFlg ? '確認済み' : '未確認' }}</td>
                <!-- ここからループ -->
                <template v-for="targetDate in targetDateListComputed">
                  <td :class="{'td-surprise' : model.displayGroupType == 3}" :key="'before-td-' + targetDate.ymd">{{ judgeFlg(model,targetDate.ymd,false) }}</td>
                  <td :class="{'td-entertainment' : model.displayGroupType == 2}" :key="'today-td-' + targetDate.ymd">{{ judgeFlg(model,targetDate.ymd,true) }}</td>
                </template>
              </tr>
            </tbody>
          </table>
        </div>
      </template>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import Repository from "../../api/Repository";
import { BASE_URL } from '../../common/AppUrl';
import Error from "../mixins/Error";
import SearchRender from "../mixins/SearchRender"
import FileController from '../mixins/FileController'
export default {
  mixins: [Error,SearchRender,FileController],
  props: {
    searchParam: Object,
    calendarList: Array,
    ymList: Object,
    prefList: Object,
    displayTypeList: Object,
    deadlineTimeList: Object,
    authinfo: Object,
  },
  data: function() {
    return {
      mIsSearch: false,
      mSearchParam: this.searchParam
        ? this.searchParam
        : {
            searchYm: "",
            searchPrefCd: "",
            searchIsNotApproval: false,
            searchIsNotConfirm: false,
            searchDisplayType: 0
          },
      mTargetYm: this.searchParam.searchYm,
      mCalendarList: this.calendarList,
      mCalendarListCount: 0,
      mFirstCalendar: null
    };
  },
  mounted: function() {
    /** 初期処理 */
    this.$nextTick(function () {
      if(this.mSearchParam.searchYm && this.mSearchParam.searchPrefCd) {
        this.search();
      }
    })
  },
  methods: {
    /** 検索条件リセット */
    reset: function() {
      var currentYm = moment().format("YYYYMM");
      this.mSearchParam.searchYm = currentYm;
      this.mSearchParam.searchPrefCd = 0;
      this.mSearchParam.searchIsNotApproval = false;
      this.mSearchParam.searchIsNotConfirm = false;
      this.mSearchParam.searchDisplayType = 0;
    },
    /** 検索処理 */
    search: function(e) {
      // 検索
      this.$root.$refs.appProgress.busy(true);
      Repository.searchCalendarConfirm(
        this.mSearchParam.searchYm,
        this.mSearchParam.searchPrefCd,
        this.mSearchParam.searchIsNotApproval,
        this.mSearchParam.searchIsNotConfirm,
        this.mSearchParam.searchDisplayType
      ).then(response => {
        var result = response.data;
        if(result.isSuccess) {
          this.mIsSearch = true;
          this.mCalendarListCoount = result.data.length;
          if( 0 < result.data.length ) {
            this.mFirstCalendar = result.data[0];
          } else {
            this.mFirstCalendar = null;
          }
          this.$forceUpdate()
          // 100アイテムづつsetTimeoutでレンダリング
          this.betterRender('mCalendarList',result.data);
        } else {
          alert(result.message);
        }
      }).catch(error => {
        var data = error.response.data;
        alert(data.message)
      }).finally(() => {
        this.$root.$refs.appProgress.busy(false);
      });
    },
    count: async function(e) {
      this.$root.$refs.appProgress.busy(true);
      await Repository.countCalendarConfirm(
        this.mSearchParam.searchYm,
        this.mSearchParam.searchPrefCd,
        this.mSearchParam.searchIsNotApproval,
        this.mSearchParam.searchIsNotConfirm,
        this.mSearchParam.searchDisplayType
      ).then(response => {
        var result = response.data;
        if (result.isSuccess) {
          this.mCalendarListCount = result.data;
        } else {
          alert(result.message);
        }
      }).catch(error => {
        var data = error.response.data;
        alert(data.message)
      }).finally(() => {
        this.$root.$refs.appProgress.busy(false);
      });
    },
    /** ダウンロード前準備 */
    downloadSetup: async function(e) {
      await this.count();
      if(this.mCalendarListCount == 0) {
        alert('検索結果が0件のため、ダウンロードできません。');
        return false;
      }
      var fileName = "Calendar";
      var request = {
        searchYm: this.mSearchParam.searchYm,
        searchPrefCd: this.mSearchParam.searchPrefCd,
        searchIsNotApproval: this.mSearchParam.searchIsNotApproval,
        searchIsNotConfirm: this.mSearchParam.searchIsNotConfirm,
        searchDisplayType: this.mSearchParam.searchDisplayType
      };
      var url = Repository.downloadCalendarConfirmUrl();
      this.download(fileName,request,url);
    },
    /**
     * デポ名リンク
     */
    depoLink: function(model) {
      // デポ変更申請へ遷移
      this.$root.$refs.appProgress.busy(true);
      location.href = this.$root.URL_CONST.C_L11 + '/search?searchDepocd=' + model.depoCd + '&searchYm=' + this.mTargetYm;
    },
    /**
     * 承認処理
     */
    approval: function(model) {
      this.$root.$refs.appProgress.busy(true);
      Repository.approvalCalendarConfirm(
        this.mTargetYm,
        model.depoCd
      ).then(response => {
        var result = response.data;
        if(result.isSuccess) {
          // 再検索
          alert('承認しました。');
          this.mSearchParam = this.searchParam;
          this.$root.$refs.appProgress.busy(false);
          this.search();
        } else {
          alert(result.message);
        }
      }).catch(error => {
        var data = error.response.data;
        alert(data.message)
      }).finally(() => {
        this.$root.$refs.appProgress.busy(false);
      });
    },
    /**
     * 前日締切／当日配送表示
     */
    judgeFlg: function(model, targetYmd, isToday) {
      // 返却値判定
      var day = moment(targetYmd, "YYYYMMDD").format('D');
      var result = "";
      if (isToday) {
        result = this.getLimitTime(
          model['todayDeliveryFlg' + day],
          model['todayDeadlineLimitTime' + day]
        );
      } else {
        result = this.getLimitTime(
          model['beforeDeadlineFlg' + day],
          model['beforeDeadlineLimitTime' + day]
        );
      }
      return result;
    },
    /**
     * 前日締切／当日配送表示内容判定
     */
    getLimitTime: function(type, limitTime) {
      var result = "";
      if (type == 0) {
        // 不可
        result = "×";
      } else if (type == 1) {
        // 可能
        result = "○";
      } else if (type == 2) {
        // 時間指定
        var val = this.deadlineTimeList[limitTime];
        result = val ? val : '';
      } else {
        result = "";
      }
      return result;
    },
    /** 日・祝日チェック */
    holidayCheck: function(ymd) {
      var flg = false;
      if(this.mFirstCalendar) {
        var day = moment(ymd, "YYYYMMDD").format('D');
        var status = this.mFirstCalendar['publicHolidayStatus' + day];
        var week = this.mFirstCalendar['dayofweek' + day];
        // 日曜日か祝日か否か
        if(status == 1 || week == 0) {
          flg = true;
        }
      }
      return flg;
    }
  },
  computed: {
    targetDateListComputed: function() {
      var lastDay = 0;
      var dispDayList = Array();
      if (this.mTargetYm) {
        var momentDate = moment(this.mTargetYm, "YYYYMM");
        lastDay = Number(momentDate.endOf("month").format("DD"));
      }
      for (var i = 0; i < lastDay; i++) {
        var idx = i + 1;
        var day = ("00" + idx).slice(-2);
        var ymd = this.mTargetYm + day;
        var week = moment(ymd,'YYYYMMDD').format('ddd');
        // 祝日チェック
        if(this.mFirstCalendar) {
          var status = this.mFirstCalendar['publicHolidayStatus' + idx];
          // 日曜日か祝日か否か
          if(status == 1) {
            week = week + '・祝';
          }
        }
        var obj = {
          ymd: ymd,
          d: idx,
          week: week
        };
        dispDayList.push(obj);
      }
      return dispDayList;
    }
  }
};
</script>