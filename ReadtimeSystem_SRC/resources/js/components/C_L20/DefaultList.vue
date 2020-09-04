<template>
  <div class="mt-3">
    <div class="default-search">
      <div class="row">
        <h4 class="col-md-6">デフォルト一覧画面</h4>
      </div>
      <div class="row">
        <div class="col-md-3 form-inline">
          <label class="control-label mr-2">都道府県</label>
          <select class="form-control" name='searchPrefCd' v-model="mSearchParam.searchPrefCd">
            <option value="99">選択してください</option>
            <option v-for="item in prefList" :key="item.pref" :value="item.pref">
                {{ item.prefName }}
            </option>
            <option value="">全県</option>
          </select>
        </div>
        <div class="col-md-3 form-inline">
          <div class="col-md-6" style="vertical-align: middle">デポ名</div>
          <div class="col-md-6">
            <button type="button" class="btn btn-primary" @click="depolistOpen">デポ選択</button>
          </div>
        </div>
        <div class="col-md-3 form-inline">
          <div class="col-md-6" style="vertical-align: middle">商品</div>
          <div class="col-md-6">
            <button type="button" class="btn btn-primary" @click="productlistOpen">選択</button>
          </div>
        </div>
        <div class="col-md-3 form-inline">
          <input type="checkbox" id="configChecked" name="searchIsConfig" v-model="mSearchParam.searchIsConfig" />
          <label class="ml-2 mr-4" for="configChecked">未設定データのみ表示</label>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 form-inline"></div>
        <div class="col-md-3 form-inline">
          <div class="col-md-12 under-line" v-html="mSearchParam.searchDeponame"></div>
          <input type="hidden" name="searchDepocd" v-model="mSearchParam.searchDepocd" />
        </div>
        <div class="col-md-3 form-inline">
          <div class="col-md-12 under-line" >
            {{ mSearchParam.searchItemCategoryLargename }}<br />
            {{ mSearchParam.searchItemCategoryMediumname }}<br />
            {{ mSearchParam.searchItemName }}
          </div>
          <input type="hidden" name="searchItemCategoryLargecd" v-model="mSearchParam.searchItemCategoryLargecd" />
          <input type="hidden" name="searchItemCategoryMediumcd" v-model="mSearchParam.searchItemCategoryMediumcd" />
          <input type="hidden" name="searchItemCd" v-model="mSearchParam.searchItemCd" />
        </div>
      </div>
      <div class="col-md-3 form-inline"></div>
      <br />
      <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 text-right">
          <button type="button" class="btn btn-primary" @click="downloadSetup">CSV出力</button>
          <button type="button" class="btn btn-primary ml-4 mr-4" @click="reset">リセット</button>
          <button type="button" class="btn btn-primary" @click="search" v-bind:disabled="!mSearchIsActive">検索</button>
        </div>
      </div>
    </div>
    <template v-if="mErrorMsgList.length != 0">
      <div class="error-area">
        <p v-for="msg in mErrorMsgList" :key="msg" v-html="msg"></p>
      </div>
    </template>
    <div class="default-input" v-if="this.mIsSearch">
      <div class="row">
        <div class="col-md-12 text-right">
          <label class="control-label">検索結果</label>
          <label class="control-label mr-3 ml-3">{{ searchCountComputed }}</label>
          <label class="control-label">件</label>
        </div>
      </div>
      <template v-if="searchCountComputed != 0">
        <div class="sticky-table div-calendar-table">
          <table class="table-striped table-responsive-stack">
            <thead>
              <tr>
                <th class="th-addrcd" rowspan="2">住所<br/>コード</th>
                <th class="th-zipcode" rowspan="2">郵便番号</th>
                <th class="th-pref" rowspan="2">都道<br/>府県</th>
                <th class="th-siku" rowspan="2">市区群</th>
                <th class="th-tyou" rowspan="2">町名</th>
                <th class="th-deponame" rowspan="2">デポ名</th>
                <th class="th-nextday" rowspan="2">翌日<br />時間指定</th>
                <th class="th-samedayyn" rowspan="2">当日配送<br />可否</th>
                <th class="th-prevdaydeadline" rowspan="2">翌日締切<br />時間</th>
                <th class="th-samedaydeadline1" rowspan="2">当日配送<br />締切時間<br />1</th>
                <th class="th-samedaydeadline2" rowspan="2">当日配送<br />締切時間<br />2</th>
                <!-- ここからループ -->
                <th
                  class="target-dayofname"
                  colspan="2"
                  v-for="model in dayOfWeekNameComputed"
                  :key="model.key"
                  :class="{ 'bg-holiday' : model.isHoliday }"
                >{{ model.name }}</th>
                <th class="th-private_home_flg" rowspan="2">個人宅可否</th>
                <th class="th-congratulation_kbn_flg" rowspan="2">慶弔区分</th>
                <th class="th-transfer_post_depo_cd" rowspan="2">振替先郵便デポ</th>
                <th class="th-transfer_post_deponame" rowspan="2">振替先郵便デポ名</th>
                <th class="th-depo_lead_time" rowspan="2">デポリードタイム</th>
              </tr>
              <tr>
                <!-- ここからループ -->
                <template v-for="model in dayOfWeekNameComputed">
                  <th class="target-dayofname2" :key="model.name + '_before'" :class="{ 'bg-holiday' : model.isHoliday }">
                    前日
                    <br />締切
                  </th>
                  <th class="target-dayofname2" :key="model.name + '_today'" :class="{ 'bg-holiday' : model.isHoliday }">
                    当日
                    <br />配送
                  </th>
                </template>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(model, index) in mDefaultList" :key="index">
                <td class="td-addrcd">{{ model.addrcd }}</td>
                <td class="td-zipcode">{{ model.zipcode }}</td>
                <td class="td-pref">{{ model.pref }}</td>
                <td class="td-siku">{{ model.siku }}</td>
                <td class="td-tyou">{{ model.tyou }}</td>
                <td class="td-deponame"><a @click="depoLink(model)" href="#">{{ model.deponame1 }}</a></td>
                <td class="td-nextday">{{ timeSelectTrans(model.next_day_time_type) }}</td>
                <td class="td-samedayyn">
                  {{ dispRoundCross(model.is_area_today_delivery_flg) }}
                </td>
                <td class="td-prevdaydeadline">{{ deadlineSelectTrans(model.next_day_time_deadline) }}</td>
                <td class="td-samedaydeadline1">{{ deadlineSelectTrans(model.today_time_deadline1) }}</td>
                <td class="td-samedaydeadline2">{{ deadlineSelectTrans(model.today_time_deadline2) }}</td>
                <td class="td-mon_before_deadline_flg">
                  {{ dispRoundCross(model.mon_before_deadline_flg) }}
                </td>
                <td class="td-mon_today_delivery_flg">
                  {{ dispRoundCross(model.mon_today_delivery_flg) }}
                </td>
                <td class="td-tue_before_deadline_flg">
                  {{ dispRoundCross(model.tue_before_deadline_flg) }}
                </td>
                <td class="td-tue_today_delivery_flg">
                  {{ dispRoundCross(model.tue_today_delivery_flg) }}
                </td>
                <td class="td-wed_before_deadline_flg">
                  {{ dispRoundCross(model.wed_before_deadline_flg) }}
                </td>
                <td class="td-wed_today_delivery_flg">
                  {{ dispRoundCross(model.wed_today_delivery_flg) }}
                </td>
                <td class="td-thu_before_deadline_flg">
                  {{ dispRoundCross(model.thu_before_deadline_flg) }}
                </td>
                <td class="td-thu_today_delivery_flg">
                  {{ dispRoundCross(model.thu_today_delivery_flg) }}
                </td>
                <td class="td-fri_before_deadline_flg">
                  {{ dispRoundCross(model.fri_before_deadline_flg) }}
                </td>
                <td class="td-fri_today_delivery_flg">
                  {{ dispRoundCross(model.fri_today_delivery_flg) }}
                </td>
                <td class="td-sat_before_deadline_flg">
                  {{ dispRoundCross(model.sat_before_deadline_flg) }}
                </td>
                <td class="td-sat_today_delivery_flg">
                  {{ dispRoundCross(model.sat_today_delivery_flg) }}
                </td>
                <td class="td-sun_before_deadline_flg">
                  {{ dispRoundCross(model.sun_before_deadline_flg) }}
                </td>
                <td class="td-sun_today_delivery_flg">
                  {{ dispRoundCross(model.sun_today_delivery_flg) }}
                </td>
                <td class="td-holi_before_deadline_flg">
                  {{ dispRoundCross(model.holi_before_deadline_flg) }}
                </td>
                <td class="td-holi_before_today_delivery_flg">
                  {{ dispRoundCross(model.holi_before_today_delivery_flg) }}
                </td>
                <td class="td-holi_deadline_flg">
                  {{ dispRoundCross(model.holi_deadline_flg) }}
                </td>
                <td class="td-holi_today_delivery_flg">
                  {{ dispRoundCross(model.holi_today_delivery_flg) }}
                </td>
                <td class="td-holi_after_deadline_flg">
                  {{ dispRoundCross(model.holi_after_deadline_flg) }}
                  </td>
                <td class="td-holi_after_today_delivery_flg">
                  {{ dispRoundCross(model.holi_after_today_delivery_flg) }}
                </td>
                <td class="td-private_home_flg">
                  {{ dispRoundCross(model.private_home_flg) }}
                </td>
                <td class="td-congratulation_kbn_flg">
                  {{ keichoKbn(mKeichoTypeList, model.congratulation_kbn_flg) }}
                </td>
                <td class="td-transfer_post_depo_cd">{{ model.transfer_post_depo_cd }}</td>
                <td class="td-transfer_post_deponame">{{ model.deponame2 }}</td>
                <td class="td-depo_lead_time">{{ model.depo_lead_time }}</td>
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
import Error from "../mixins/Error";
import SearchRender from "../mixins/SearchRender"
import FileController from '../mixins/FileController'
export default {
  mixins: [Error,SearchRender,FileController],
  props: {
    searchParam: Object,
    prefList: Object,
    timeSelectList: Object,
    keichoTypeList: Array,
    deadlineTimeList: Object
  },
  data: function() {
    return {
      mIsSearch: false,
      mSearchParam: this.searchParam
        ? this.searchParam
        : {
            searchPrefCd: 99,
            searchItemCategoryLargecd: null,
            searchItemCategoryLargename: null,
            searchItemCategoryMediumcd: null,
            searchItemCategoryMediumname: null,
            searchItemCd: null,
            searchItemName: null,
            searchDepocd: null,
            searchDeponame: null,
            searchIsConfig: false,
          },
      mKeichoTypeList: this.keichoTypeList,
      mDefaultList: [],
      mDefaultListCount: 0,
      mSearchIsActive: false
    };
  },
  methods: {
    reset: function() {
      this.mSearchParam.searchPrefCd = "99";
      this.mSearchParam.searchItemCategoryLargecd = null;
      this.mSearchParam.searchItemCategoryLargename = null;
      this.mSearchParam.searchItemCategoryMediumcd = null;
      this.mSearchParam.searchItemCategoryMediumname = null;
      this.mSearchParam.searchItemCd = null;
      this.mSearchParam.searchItemName = null;
      this.mSearchParam.searchDepocd = null;
      this.mSearchParam.searchDeponame = null;
      this.mSearchParam.searchIsConfig = false;
    },
    search: function(e) {
      // 検索
      this.$root.$refs.appProgress.busy(true);
      Repository.searchDefaultList(
        this.mSearchParam.searchPrefCd,
        this.mSearchParam.searchDepocd,
        this.mSearchParam.searchItemCategoryLargecd,
        this.mSearchParam.searchItemCategoryMediumcd,
        this.mSearchParam.searchItemCd,
        this.mSearchParam.searchIsConfig
      ).then(response => {
        var result = response.data;
        if(result.isSuccess) {
          // 検索フラグを立てる
          this.mIsSearch = true;
          this.mDefaultListCount = result.data.length;
          // 100アイテムづつsetTimeoutでレンダリング
          this.betterRender('mDefaultList',result.data);
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
    downloadSetup: function(e) {
      if(this.mDefaultListCount == 0) {
        alert('検索結果が0件のため、ダウンロードできません。');
        return false;
      }
      var fileName = "DefaultList";
      var request = {
        'pref': this.mSearchParam.searchPrefCd,
        'itemCategoryLargecd': this.mSearchParam.searchItemCategoryLargecd,
        'itemCategoryMediumcd': this.mSearchParam.searchItemCategoryMediumcd,
        'depocd': this.mSearchParam.searchDepocd,
        'itemcd': this.mSearchParam.searchItemCd,
        'isConfig': this.mSearchParam.searchIsConfig,
      };
      var url = Repository.downloadDefaultListUrl();
      this.download(fileName,request,url);
    },
    /** デポ名リンク */
    depoLink: function(model) {
      // デポ変更申請へ遷移
      this.$root.$refs.appProgress.busy(true);
      location.href = this.$root.URL_CONST.C_L21 + '/search?searchDepocd=' + model.depo_cd;
    },
    keichoKbn: function(mKeichoTypeList, congratulation_kbn_flg) {
      var result = mKeichoTypeList.filter(function(keicho){
        return keicho.type == congratulation_kbn_flg;
      });
      if (result.length == 0){
        return "";
      }
      return result[0].name;
    },
    depolistOpen: function() {
      childWinOpen(this.$root.URL_CONST.C_L50, undefined, this.searchDepoRegist);
    },
    searchDepoRegist: function(depo) {
     this.mSearchParam.searchDepocd = depo.depocd;
      this.mSearchParam.searchDeponame = depo.deponame;
    },
    productlistOpen: function() {
      childWinOpen(this.$root.URL_CONST.C_L52, undefined, this.searchProductRegist);
    },
    searchProductRegist: function(searchItemCategoryLargecd, searchItemCategoryLargename, searchItemCategoryMediumcd, 
    searchItemCategoryMediumname, searchItemCd, searchItemName) {
      this.mSearchParam.searchItemCategoryLargecd = searchItemCategoryLargecd;
      this.mSearchParam.searchItemCategoryLargename = searchItemCategoryLargename;
      this.mSearchParam.searchItemCategoryMediumcd = searchItemCategoryMediumcd;
      this.mSearchParam.searchItemCategoryMediumname = searchItemCategoryMediumname;
      this.mSearchParam.searchItemCd = searchItemCd;
      this.mSearchParam.searchItemName = searchItemName;
      this.$forceUpdate();
    },
    timeSelectTrans: function(date) {
      if(date === null) return '';
      var returnDate = this.timeSelectList[date];
      return returnDate;
    },
    deadlineSelectTrans: function(date) {
      if(date === null) return '';
      var returnDate = this.deadlineTimeList[date];
      return returnDate;
    },
    dispRoundCross: function(isFlg) {
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
    }
  },
  computed: {
    searchCountComputed: function() {
      return this.mDefaultListCount;
    },
    dayOfWeekNameComputed: function() {
      var dispDayNameList = Array();
      var nameList = [
        ["monday", "月", false], 
        ["tuesday", "火", false],
        ["wednesday", "水", false],
        ["thursday", "木", false],
        ["friday", "金", false],
        ["saturday", "土", false],
        ["sunday", "日", true],
        ["beforePublicHoliday", "祝前", false],
        ["publicHoliday", "祝日", true],
        ["afterPublicHoliday", "祝後", false]
      ];
      for (var i = 0;i < nameList.length; i++){
        var obj = {
          key: nameList[i][0],
          name: nameList[i][1],
          isHoliday: nameList[i][2],
        }
        dispDayNameList.push(obj);
      }
      return dispDayNameList;
    }
  },
  watch: {
    mSearchParam: {
      handler: function (val, oldVal) {
        var flg = true;
        // 都道府県
        if(!this.mSearchParam.searchPrefCd == 99) {
          flg = false;
        }
        // ボタン活性／非活性判定
        this.mSearchIsActive = flg;
      },
      deep: true
    }
  }
};
</script>