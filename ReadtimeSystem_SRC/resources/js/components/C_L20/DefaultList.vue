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
            <button type="button" class="btn btn-primary" @click="depolistOpen" v-bind:disabled="!mSearchIsActive">デポ選択</button>
          </div>
        </div>
        <div class="col-md-3 form-inline">
          <div class="col-md-6" style="vertical-align: middle">商品</div>
          <div class="col-md-6">
            <button type="button" class="btn btn-primary" @click="productlistOpen" v-bind:disabled="!mSearchIsActive">選択</button>
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
          <button type="button" class="btn btn-primary" @click="downloadSetup" v-bind:disabled="!mSearchIsActive">CSV出力</button>
          <button type="button" class="btn btn-primary ml-4 mr-4" @click="reset" v-bind:disabled="!mSearchIsActive">リセット</button>
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
      <div class="sticky-table div-calendar-table">
        <c-grid
          :data="mDefaultList"
          :frozen-col-count="6"
          :theme="userTheme"
        >

          <template slot="layout-header">
            <c-grid-layout-row>
              <c-grid-header
                width="60" rowspan="2"
              >
              住所コード
              </c-grid-header>
              <c-grid-header width="60" rowspan="2">
                郵便番号
              </c-grid-header>
              <c-grid-header width="60" rowspan="2">
                都道府県
              </c-grid-header>
              <c-grid-header width="100" rowspan="2">
                市区郡
              </c-grid-header>
              <c-grid-header width="80" rowspan="2">
                町名
              </c-grid-header>
              <c-grid-header width="150" rowspan="2">
                デポ名
              </c-grid-header>

              <c-grid-header
                :headerStyle="{textAlign: 'center'}"
                width="80" rowspan="2"
              >
                翌日時間指定
              </c-grid-header>
              <c-grid-header
                :headerStyle="{textAlign: 'center'}"
                width="80" rowspan="2"
              >
                当日配達可否
              </c-grid-header>
              <c-grid-header
                :headerStyle="{textAlign: 'center'}"
                width="80" rowspan="2"
              >
                翌日締切時間
              </c-grid-header>
              <c-grid-header
                :headerStyle="{textAlign: 'center'}"
                width="100" rowspan="2"
              >
                当日配送締切時間1
              </c-grid-header>
              <c-grid-header
                :headerStyle="{textAlign: 'center'}"
                width="100" rowspan="2"
              >
                当日配送締切時間2
              </c-grid-header>
              <template v-for="(list, i) in nameList">
                <c-grid-header
                  :headerStyle="{textAlign: 'center'}"
                  colspan="2"
                  :key="list[0] + i"
                >
                  {{  list[1] }}
                </c-grid-header>
              </template>
              <c-grid-header
                :headerStyle="{textAlign: 'center'}"
                rowspan="2"
              >
                個人宅可否
              </c-grid-header>
              <c-grid-header
                :headerStyle="{textAlign: 'center'}"
                width="100" rowspan="2"
              >
                手持ちお届け可否
              </c-grid-header>
              <c-grid-header
                :headerStyle="{textAlign: 'center'}"
                rowspan="2"
              >
                慶弔区分
              </c-grid-header>
              <c-grid-header
                :headerStyle="{textAlign: 'center'}"
                rowspan="2"
              >
                振替先郵便デポ
              </c-grid-header>
              <c-grid-header
                :headerStyle="{textAlign: 'center'}"
                width="100" rowspan="2"
              >
                振替先郵便デポ名
              </c-grid-header>
              <c-grid-header
                :headerStyle="{textAlign: 'center'}"
                width="100" rowspan="2"
              >
                デポリードタイム
              </c-grid-header>
            </c-grid-layout-row>
            <c-grid-layout-row>
              <template v-for="list of nameList" >
                <c-grid-header
                  :headerStyle="{textAlign: 'center'}"
                  width="50" :key="'before_' + list[0]"
                >
                  前日締切
                </c-grid-header>
                <c-grid-header
                  :headerStyle="{textAlign: 'center'}"
                  width="50" :key="'today_' + list[0]"
                >
                  当日締切
                </c-grid-header>
              </template>
            </c-grid-layout-row>

          </template>

          <template slot="layout-body">
            <c-grid-layout-row>
              <c-grid-column field="addrcd" />
              <c-grid-column field="zipcode" />
              <c-grid-column field="pref" />
              <c-grid-column field="siku" />
              <c-grid-column field="tyou" />
              <c-grid-column
                :columnStyle="{color: '#3490dc'}"
                field="deponame1"
                @click-cell="depoLink($event)"
              />

              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="timeSelectTrans"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCross"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="getNextDayTimeDeadlineTrans"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="getTodayTimeDeadline1Trans"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="getTodayTimeDeadline2Trans"
              />

              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForMonDeadline"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForMonDelivery"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForTueDeadline"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForTueDelivery"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForWedDeadline"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForWedDelivery"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForThuDeadline"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForThuDelivery"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForFriDeadline"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForFriDelivery"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForSatDeadline"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForSatDelivery"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForSunDeadline"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForSunDelivery"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForHoliBeforeDeadline"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForHoliBeforeTodayDelivery"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForHoliDeadline"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForHoliTodayDelivery"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForHoliAfterDeadline"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForHoliAfterTodayDelivery"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForPrivateHome"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="dispRoundCrossForHanding"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                :field="keichoKbn"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                field="transfer_post_depo_cd"
              />
              <c-grid-column
                field="deponame2"
              />
              <c-grid-column
                :columnStyle="{textAlign: 'center'}"
                field="depo_lead_time"
              />
            </c-grid-layout-row>
          </template>
        </c-grid>
      </div>
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
    deadlineTimeList: Object,
  },
  data: function() {
    return {
      mIsSearch: false,
      mSearchParam: this.searchParam.searchDepocd !== null
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
      mSearchIsActive: false,
      columnTheme: {
        font: '20rem',
      },
      nameList: [
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
      ],
      userTheme: {
        color: 'black',
        borderColor: '#35495e',
        frozenRowsBgColor(args) {
          const { row, grid: {frozenRowColor} } = args;
          if (args.col >= 6 && args.row <= 1) {
            if (
              (args.col == 23 || args.col == 24) // 日
              || (args.col == 27 || args.col == 28) // 祝日
            ) {
              return '#FFA500';
            } else {
              return '#84D383'
            }
          } else {
            return '#b0c4de';
          }
        },
        font: '0.75rem',
      }
    };
  },
  mounted: function () {
    // デフォルト設定でデポを選択後に「一覧」から遷移してきた場合
    if (this.searchParam.searchDepocd !== null) {
      // デポ選択を予め設定
      var depo = {
        'depocd': this.searchParam.searchDepocd,
        'deponame': this.searchParam.searchDeponame
      }
      this.searchDepoRegist(depo);
    }
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
          // this.betterRender('mDefaultList',result.data);
          this.mDefaultList = result.data;
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
      // 検索
      this.$root.$refs.appProgress.busy(true);
      await Repository.countDefaultList(
        this.mSearchParam.searchPrefCd,
        this.mSearchParam.searchDepocd,
        this.mSearchParam.searchItemCategoryLargecd,
        this.mSearchParam.searchItemCategoryMediumcd,
        this.mSearchParam.searchItemCd,
        this.mSearchParam.searchIsConfig
      ).then(response => {
        var result = response.data;
        if(result.isSuccess) {
          this.mDefaultListCount = result.data;
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
      if(this.mDefaultListCount == 0) {
        alert('検索結果が0件のため、ダウンロードできません。');
        return false;
      }
      var fileName = "DefaultList";
      var request = {
        'prefCd': this.mSearchParam.searchPrefCd,
        'itemCategoryLargecd': this.mSearchParam.searchItemCategoryLargecd,
        'itemCategoryMediumcd': this.mSearchParam.searchItemCategoryMediumcd,
        'depoCd': this.mSearchParam.searchDepocd,
        'itemCd': this.mSearchParam.searchItemCd,
        'isConfig': this.mSearchParam.searchIsConfig,
      };
      var url = Repository.downloadDefaultListUrl();
      this.download(fileName,request,url);
    },
    /** デポ名リンク */
    depoLink: function (rec) {
      var row = rec.row - 2;
      var depo_cd = this.mDefaultList[row].depo_cd;
      if(depo_cd != null) {
        this.$root.$refs.appProgress.busy(true);
        location.href = this.$root.URL_CONST.C_L21 + '/search?searchDepocd=' + depo_cd;
      }
    },
    keichoKbn: function(data) {
      var congratulation_kbn_flg = data.congratulation_kbn_flg;
      var result = this.mKeichoTypeList.filter(function(keicho){
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
    timeSelectTrans: function(data) {
      var nextDayTimeDeadline = data.next_day_time_type;
      if(nextDayTimeDeadline === NaN) return '';
      var returnDate = this.timeSelectList[nextDayTimeDeadline];
      return returnDate;
    },
    getNextDayTimeDeadlineTrans: function(data) {
      var nextDayTimeDeadline = data.next_day_time_deadline;
      if(nextDayTimeDeadline === null) return '';
      var returnDate = this.deadlineTimeList[nextDayTimeDeadline];
      return returnDate;
    },
    getTodayTimeDeadline1Trans: function(data) {
      var date = data.today_time_deadline1;
      if(date === null) return '';
      var returnDate = this.deadlineTimeList[date];
      return returnDate;
    },
    getTodayTimeDeadline2Trans: function(data) {
      var date = data.today_time_deadline2;
      if(date === null) return '';
      var returnDate = this.deadlineTimeList[date];
      return returnDate;
    },
    dispRoundCross: function(data) {
      var isFlg = data.is_area_today_delivery_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForMonDeadline: function(data) {
      var isFlg = data.mon_before_deadline_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForMonDelivery: function(data) {
      var isFlg = data.mon_today_delivery_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForTueDeadline: function(data) {
      var isFlg = data.tue_before_deadline_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForTueDelivery: function(data) {
      var isFlg = data.tue_today_delivery_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForWedDeadline: function(data) {
      var isFlg = data.wed_before_deadline_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForWedDelivery: function(data) {
      var isFlg = data.wed_today_delivery_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForThuDeadline: function(data) {
      var isFlg = data.thu_before_deadline_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForThuDelivery: function(data) {
      var isFlg = data.thu_today_delivery_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForFriDeadline: function(data) {
      var isFlg = data.fri_before_deadline_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForFriDelivery: function(data) {
      var isFlg = data.fri_today_delivery_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForSatDeadline: function(data) {
      var isFlg = data.sat_before_deadline_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForSatDelivery: function(data) {
      var isFlg = data.sat_today_delivery_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForSunDeadline: function(data) {
      var isFlg = data.sun_before_deadline_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForSunDelivery: function(data) {
      var isFlg = data.sun_today_delivery_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForHoliBeforeDeadline: function(data) {
      var isFlg = data.holi_deadline_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForHoliBeforeTodayDelivery: function(data) {
      var isFlg = data.holi_before_today_delivery_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForHoliDeadline: function(data) {
      var isFlg = data.holi_deadline_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForHoliTodayDelivery: function(data) {
      var isFlg = data.holi_today_delivery_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForHoliAfterDeadline: function(data) {
      var isFlg = data.holi_after_deadline_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForHoliAfterTodayDelivery: function(data) {
      var isFlg = data.holi_after_today_delivery_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForPrivateHome: function(data) {
      var isFlg = data.private_home_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
    dispRoundCrossForHanding: function(data) {
      var isFlg = data.handing_flg;
      var ret = '';
      if(isFlg == null) {
        ret = '';
      } else {
        ret = isFlg ? '○' : '×';
      }
      return ret;
    },
  },
  computed: {
    searchCountComputed: function() {
      return this.mDefaultListCount;
    },
    dayOfWeekNameComputed: function() {
      var dispDayNameList = Array();
      for (var i = 0;i < this.nameList.length; i++){
        var obj = {
          key: this.nameList[i][0],
          name: this.nameList[i][1],
          isHoliday: this.nameList[i][2],
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
        if(this.mSearchParam.searchPrefCd == "99") {
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