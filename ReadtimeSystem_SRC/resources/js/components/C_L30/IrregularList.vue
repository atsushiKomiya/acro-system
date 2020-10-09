<template>
  <div class="my-3">
    <!-- 検索エリア -->
    <div class="default-search irregular-search">
      <!-- 行 -->
      <div class="row">
        <h4 class="col-md-6">イレギュラー一覧画面</h4>
      </div>
      <form id="search-form" :action="$root.URL_CONST.C_L30 + '/search'" method="GET">
        <!-- 行 -->
        <div class="row mb-2">
          <!-- イレギュラー設定区分 -->
          <div class="col-md-2">
            <span>イレギュラー設定区分</span>
            <select class="form-control" name='searchIrregularConfig' v-model="mSearchParam.searchIrregularConfig">
              <option value="">すべて</option>
              <option v-for="(value, key) in irregularConfigClassificationList" :key="key" :value="key">{{ value }}</option>
            </select>
          </div>
          <!-- タイトル -->
          <div class="col-md-4">
            <span>タイトル</span>
            <input
              class="form-control"
              name="searchTitle"
              v-model="mSearchParam.searchTitle"
              @keypress.prevent.enter.exact="{}"
              @keydown.prevent.enter.exact="{}"
              @keyup.prevent.enter.exact="{}"
            />
          </div>
          <!-- 用途 -->
          <div class="col-md-2">
            <span>用途</span>
            <select class="form-control" v-model="mSearchParam.searchCUseCd">
              <option value="">すべて</option>
              <optgroup label="お祝い"></optgroup>
              <option v-for="item in cUseCelebList" :key="item.cUse" :value="item.cUse">
              {{ item.cUseName }}
              </option>
              <optgroup label="お悔やみ"></optgroup>
              <option v-for="item in cUseCondolList" :key="item.cUse" :value="item.cUse">
              {{ item.cUseName }}
              </option>
            </select>
          </div>
          <!-- 有効区分 -->
          <div class="col-md-2">
            <span>有効区分</span>
            <select class="form-control" name='searchIsValid' v-model="mSearchParam.searchIsValid">
              <option value="">すべて</option>
              <option v-for="(value, key) in validList" :key="key" :value="key">{{ value }}</option>
            </select>
          </div>
          <!-- 配送時間 -->
          <div class="col-md-2">
            <span>配送時間</span>
            <select class="form-control" name='searchDeliveryTime' v-model="mSearchParam.searchDeliveryTime">
              <option v-for="(value, key) in deliveryDateList" :key="key" :value="key">{{ value }}</option>
            </select>
          </div>
        </div>
        <!-- 行 -->

        <!-- accordion -->
        <transition
          name="accordion"
          @before-leave="beforeLeave"
          @leave="leave"
          @enter="enter"
          @before-enter="beforeEnter"
        >
          <div class="accordion--target" v-if="isAccordionOpen">
            <div class="row mb-2">
              <!-- 不可制御 -->
              <div class="col-md-4">
                <span>不可制御</span>
                <div class="row div-indent">
                  <div class="col-md-6">
                    <input type="checkbox" id="isBeforeDeadlineChecked" name="searchIsBeforeDeadline" v-model="mSearchParam.searchIsBeforeDeadline" />
                    <label class="ml-2" for="isBeforeDeadlineChecked">前日締切不可</label>
                  </div>
                  <div class="col-md-6">
                    <input type="checkbox" id="isTodayDeliveryChecked" name="searchIsTodayDelivery" v-model="mSearchParam.searchIsTodayDelivery" />
                    <label class="ml-2" for="isTodayDeliveryChecked">当日配送不可</label>
                  </div>
                  <div class="col-md-6">
                    <input type="checkbox" id="isTimeSelectChecked" name="searchIsTimeSelect" v-model="mSearchParam.searchIsTimeSelect" />
                    <label class="ml-2" for="isTimeSelectChecked">時間指定不可</label>
                  </div>
                  <div class="col-md-6">
                    <input type="checkbox" id="isPrivateHomeChecked" name="searchIsPrivateHome" v-model="mSearchParam.searchIsPrivateHome" />
                    <label class="ml-2" for="isPrivateHomeChecked">個人宅不可</label>
                  </div>
                </div>
              </div>

              <!-- 商品 -->
              <div class="col-md-5">

                <div class="form-inline">
                  <span>商品</span>
                  <button type="button" class="btn btn-primary ml-5" @click="productlistOpen">選択</button>
                </div>

                <div class="row div-indent">
                  <div class="col-md-3">カテゴリ大</div>
                  <div class="col-md-9 under-line" >{{ dispItemCategoryLargeName }}<span>&nbsp;</span></div>
                  <div class="col-md-3">カテゴリ中</div>
                  <div class="col-md-9 under-line" >{{ dispItemCategoryMediumName }}<span>&nbsp;</span></div>
                  <div class="col-md-3">商品</div>
                  <div class="col-md-9 under-line" >{{ dispItemName }}<span>&nbsp;</span></div>
                </div>
              </div>

              <!-- お届け日 -->
              <div class="col-md-3">

                <div class="form-inline">
                  <span>お届け日</span>
                  <button type="button" class="btn btn-primary ml-5" @click="dateSelectOpen(true)">選択</button>
                </div>

                <div class="row div-indent">
                  <div class="col-md-4">日付</div>
                  <div class="col-md-8 under-line"><span>{{ dispDeliveryDate }}</span><span>&nbsp;</span></div>
                  <div class="col-md-4">期間</div>
                  <div class="col-md-8 under-line"><span>{{ dispDeliveryPeriod }}</span><span>&nbsp;</span></div>
                  <div class="col-md-4">曜日</div>
                  <div class="col-md-8 under-line"><span>{{ dispDeliveryWeek }}</span><span>&nbsp;</span></div>
                </div>
              </div>
            </div>
            <!-- 行 -->
            <div class="row mb-2">
              <div class="col-md-4">
                <!-- デポ名 -->
                <div class="form-inline">
                  <span>デポ名</span>
                  <button type="button" class="btn btn-primary ml-5" @click="depoListOpen(false)">選択</button>
                </div>
                <div class="under-line mb-2">
                  {{ dispDepoName }}<span>&nbsp;</span>
                </div>
                <!-- 振替先配送デポ名 -->
                <div class="form-inline">
                  <span>振替先配送デポ名</span>
                  <button type="button" class="btn btn-primary ml-5" @click="depoListOpen(true)">選択</button>
                </div>
                <div class="under-line">
                  {{ dispTransDepoName }}<span>&nbsp;</span>
                </div>
              </div>

              <!-- 住所 -->
              <div class="col-md-5">
                <div class="form-inline">
                  <span>住所</span>
                  <button type="button" class="btn btn-primary ml-5" @click="addresslistOpen">選択</button>
                </div>
                <div class="row div-indent">
                  <div class="col-md-3">郵便番号</div>
                  <div class="col-md-9 under-line">{{ dispZipCd }}<span>&nbsp;</span></div>
                  <div class="col-md-3">都道府県</div>
                  <div class="col-md-9 under-line">{{ dispPrefName }}<span>&nbsp;</span></div>
                  <div class="col-md-3">市区郡</div>
                  <div class="col-md-9 under-line">{{ dispSiku }}<span>&nbsp;</span></div>
                  <div class="col-md-3">町名</div>
                  <div class="col-md-9 under-line">{{ dispTyou }}<span>&nbsp;</span></div>
                </div>
              </div>

              <!-- 受注日 -->
              <div class="col-md-3">
                <div class="form-inline">
                  <span>受注日</span>
                  <button type="button" class="btn btn-primary ml-5" @click="dateSelectOpen(false)">選択</button>
                </div>
                <div class="row div-indent">
                  <div class="col-md-4">日付</div>
                  <div class="col-md-8 under-line"><span>{{ dispOrderDate }}</span><span>&nbsp;</span></div>
                  <div class="col-md-4">期間</div>
                  <div class="col-md-8 under-line"><span>{{ dispOrderPeriod }}</span><span>&nbsp;</span></div>
                  <div class="col-md-4">曜日</div>
                  <div class="col-md-8 under-line"><span>{{ dispOrderWeek }}</span><span>&nbsp;</span></div>
                </div>
              </div>
            </div>
          </div>
        </transition>
        <!-- // accordion -->

        <div class="accordion-info" @click="accordionToggle">
          <a href="javascript:void(0)">
            <div :class="{'arrow-up': isAccordionOpen, 'arrow-down': !isAccordionOpen}"></div>
            {{ accordionInfo }}
          </a>
        </div>

        <div class="row">
          <div class="col-md-6"></div>
          <div class="col-md-6 text-right">
            <button type="button" class="btn btn-primary" @click="downloadSetup">CSV出力</button>
            <button type="button" class="btn btn-primary ml-4 mr-4" @click="reset">リセット</button>
            <button type="button" class="btn btn-primary" @click="search">検索</button>
          </div>
        </div>
      </form>
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
      <div class="sticky-table div-irregular-table" v-if="this.mIrregularList.length != 0">
        <table class="table-striped table-responsive-stack">
          <thead>
            <tr>
              <th class="th-irregular-id">ID</th>
              <th class="th-irregular-type">イレギュラー<br />設定区分</th>
              <th class="th-title">タイトル</th>
              <th class="th-depo-name">デポ名</th>
              <th class="th-trans-depo-name">振替先配送デポ名</th>
              <th class="th-item-cd">商品CD</th>
              <th class="th-c-use-name">用途</th>
              <th class="th-is-before-deadline-undeliv">前日<br/>締切</th>
              <th class="th-is-today-deadline-undeliv">当日<br/>配送</th>
              <th class="th-time-select">時間指定</th>
              <th class="th-is-personal-delivery">個人宅</th>
              <th class="th-is-area">地域区分</th>
              <th class="th-delivery-date">お届け日・期間</th>
              <th class="th-order-date">受注日・期間</th>
              <th class="th-updated-id">更新者</th>
              <th class="th-updated-at">更新日時</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(model, index) in mIrregularList" :key="index" :class="{'disabled-row': !model.is_valid}">
              <td class="td-irregular-id"><a @click="irregularConfigLink(model)" href="#!">{{ model.irregular_id }}</a></td>
              <td class="td-irregular-type">{{ irregularTypeTrans(model.irregular_type) }}</td>
              <td class="td-title">{{ model.title }}</td>
              <td class="td-depo-name one-line">{{ model.depo_name }}</td>
              <td class="td-trans-depo-name one-line">{{ model.trans_depo_name }}</td>
              <td class="td-item-cd one-line">{{ model.item_cd }}</td>
              <td class="td-c-use-name">{{ model.c_use_name }}</td>
              <td class="td-is-before-deadline-undeliv">{{ flgTrans(model.is_before_deadline_undeliv) }}</td>
              <td class="td-is-today-deadline-undeliv">{{ flgTrans(model.is_today_deadline_undeliv) }}</td>
              <td class="td-time-select">{{ timeSelectTrans(model) }}</td>
              <td class="td-is-personal-delivery">{{ flgTrans(model.is_personal_delivery) }}</td>
              <td class="td-is-area">{{ isAreaTrans(model.is_area) }}</td>
              <td class="td-delivery-date">{{ dispSearchResultDate(true,model) }}</td>
              <td class="td-order-date">{{ dispSearchResultDate(false,model) }}</td>
              <td class="td-updated-id">{{ model.updated_name }}</td>
              <td class="td-updated-at">{{ timestampTrans(model.updated_at) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row my-3">
        <div class="col-md-2">
          <button class="btn btn-primary" href="#" @click="newLink" role="button">新規作成</button>
        </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import Repository from "../../api/Repository";
import Error from "../mixins/Error";
import FileController from '../mixins/FileController'
import DateUtil from "../mixins/DateUtilMixins";
export default {
  mixins: [Error,FileController,DateUtil],
  props: {
    searchParam: {
      type: Object,
      require: false,
      default: () => ({
        searchIrregularConfig: '',
        searchTitle: '',
        searchDepocd: null,
        searchDeponame: null,
        searchChoiceDepoList: [],
        searchChoiceTransDepoList: [],
        searchTransDeponame: null,
        searchTransDepocd: null,
        searchDisplayType: 0,
        searchItemCategoryLargecd: null,
        searchItemCategoryLargename: null,
        searchItemCategoryMediumcd: null,
        searchItemCategoryMediumname: null,
        searchItemCd: null,
        searchItemName: null,
        searchItemList: [],
        searchOrderType: 0,
        searchOrderDate: null,
        searchOrderPeriodStart: null,
        searchOrderPeriodEnd: null,
        searchOrderWeekList: [],
        searchOrderHolidayList: [],
        searchZipcdList: [],
        searchPrefList: [],
        searchPrefNameList: [],
        searchSikuList: [],
        searchTyouList: [],
        searchCUseCd: '',
        searchIsValid: '',
        searchDeliveryTime: '0',
        searchDeliveryDateType: 0,
        searchDeliveryDate: null,
        searchDeliveryPeriodStart: null,
        searchDeliveryPeriodEnd: null,
        searchDeliveryWeekList: [],
        searchDeliveryHolidayList: [],
        searchIsBeforeDeadline: false,
        searchIsTodayDelivery: false,
        searchIsTimeSelect: false,
        searchIsPrivateHome: false
      })
    },
    irregularConfigClassificationList: Object,
    cUseList: Array,
    validList: Array,
    deliveryDateList: Object,
    irregularList: Array,
  },
  data: function() {
    return {
      mIsSearch: false,
      mSearchParam: this.searchParam,
      mIrregularList: this.irregularList,
      mIrregularCount: 0,
      mDeliveryYear: this.getDateSplit(this.searchParam.searchDeliveryDate, 1),
      mDeliveryMonth: this.getDateSplit(this.searchParam.searchDeliveryDate, 2),
      mDeliveryDate: this.getDateSplit(this.searchParam.searchDeliveryDate, 3),
      mDeliveryStartYear: this.getDateSplit(this.searchParam.searchDeliveryPeriodStart, 1),
      mDeliveryStartMonth: this.getDateSplit(this.searchParam.searchDeliveryPeriodStart, 2),
      mDeliveryStartDate: this.getDateSplit(this.searchParam.searchDeliveryPeriodStart, 3),
      mDeliveryEndYear: this.getDateSplit(this.searchParam.searchDeliveryPeriodEnd, 1),
      mDeliveryEndMonth: this.getDateSplit(this.searchParam.searchDeliveryPeriodEnd, 2),
      mDeliveryEndDate: this.getDateSplit(this.searchParam.searchDeliveryPeriodEnd, 3),
      mDeliveryWeekList: this.searchParam.searchDeliveryWeekList,
      mDeliveryHolidayList: this.searchParam.searchDeliveryHolidayList,
      mOrderYear: this.getDateSplit(this.searchParam.searchOrderDate, 1),
      mOrderMonth: this.getDateSplit(this.searchParam.searchOrderDate, 2),
      mOrderDate: this.getDateSplit(this.searchParam.searchOrderDate, 3),
      mOrderStartYear: this.getDateSplit(this.searchParam.searchOrderPeriodStart, 1),
      mOrderStartMonth: this.getDateSplit(this.searchParam.searchOrderPeriodStart, 2),
      mOrderStartDate: this.getDateSplit(this.searchParam.searchOrderPeriodStart, 3),
      mOrderEndYear: this.getDateSplit(this.searchParam.searchOrderPeriodEnd, 1),
      mOrderEndMonth: this.getDateSplit(this.searchParam.searchOrderPeriodEnd, 2),
      mOrderEndDate: this.getDateSplit(this.searchParam.searchOrderPeriodEnd, 3),
      mOrderWeekList: this.searchParam.searchOrderWeekList,
      mOrderHolidayList: this.searchParam.searchOrderHolidayList,
      isAccordionOpen: false,
      accordionInfo: '条件詳細',
      itemNameList: [],
      itemCategoryLargeNameList: [],
      itemCategoryMediumNameList: [],
    };
  },
  methods: {
    /** 検索条件リセット */
    reset: function() {
      this.mSearchParam.searchIrregularConfig = '';
      this.mSearchParam.searchTitle = '';
      this.mSearchParam.searchDepocd = null;
      this.mSearchParam.searchDeponame = null;
      this.mSearchParam.searchChoiceDepoList = [];
      this.mSearchParam.searchChoiceTransDepoList = [];
      this.mSearchParam.searchTransDeponame = null;
      this.mSearchParam.searchTransDepocd = null;
      this.mSearchParam.searchDisplayType = 0;
      this.mSearchParam.searchItemCategoryLargecd = null;
      this.mSearchParam.searchItemCategoryLargename = null;
      this.mSearchParam.searchItemCategoryMediumcd = null;
      this.mSearchParam.searchItemCategoryMediumname = null;
      this.mSearchParam.searchItemCd = null;
      this.mSearchParam.searchItemName = null;
      this.mSearchParam.searchItemList = [];
      this.itemNameList = [];
      this.itemCategoryLargeNameList = [];
      this.itemCategoryMediumNameList = [];
      this.mSearchParam.searchOrderType = 0;
      // 受注日:日付
      this.mOrderYear = null;
      this.mOrderMonth = null;
      this.mOrderDate = null;
      this.mSearchParam.searchOrderDate = null;
      // 受注日:期間
      this.mOrderStartYear = null;
      this.mOrderStartMonth = null;
      this.mOrderStartDate = null;
      this.mOrderEndYear = null;
      this.mOrderEndMonth = null;
      this.mOrderEndDate = null;
      this.mSearchParam.searchOrderPeriodStart = null;
      this.mSearchParam.searchOrderPeriodEnd = null;

      this.mSearchParam.searchOrderWeekList = [];
      this.mOrderWeekList = [];
      this.mSearchParam.searchOrderHolidayList = [];
      this.mOrderHolidayList = [];
      this.mSearchParam.searchZipcdList = [];
      this.mSearchParam.searchPrefList = [];
      this.mSearchParam.searchPrefNameList = [];
      this.mSearchParam.searchSikuList = [];
      this.mSearchParam.searchTyouList = [];
      this.mSearchParam.searchCUseCd = '';
      this.mSearchParam.searchIsValid = '';
      this.mSearchParam.searchDeliveryTime = '0';
      this.mSearchParam.searchDeliveryDateType = 0;
      // お届け日:日付
      this.mDeliveryYear = null;
      this.mDeliveryMonth = null;
      this.mDeliveryDate = null;
      this.mSearchParam.searchDeliveryDate = null;
      // お届け日:期間
      this.mDeliveryStartYear = null;
      this.mDeliveryStartMonth = null;
      this.mDeliveryStartDate = null;
      this.mDeliveryEndYear = null;
      this.mDeliveryEndMonth = null;
      this.mDeliveryEndDate = null;
      this.mSearchParam.searchDeliveryPeriodStart = null;
      this.mSearchParam.searchDeliveryPeriodEnd = null;

      this.mSearchParam.searchDeliveryWeekList = [];
      this.mDeliveryWeekList = [];
      this.mSearchParam.searchDeliveryHolidayList = [];
      this.mDeliveryHolidayList = [];
      this.mSearchParam.searchIsBeforeDeadline = false;
      this.mSearchParam.searchIsTodayDelivery = false;
      this.mSearchParam.searchIsTimeSelect = false;
      this.mSearchParam.searchIsPrivateHome = false;
      this.$forceUpdate();
    },
    /** 検索ボタン */
    search: function(e) {
      this.$root.$refs.appProgress.busy(true);
      Repository.searchIrregularList(
        this.mSearchParam
      ).then(response => {
        var result = response.data;
        if(result.isSuccess) {
          // 検索フラグを立てる
          this.mIsSearch = true;
          this.mIrregularList = result.data;
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
    /** 件数取得 */
    count: async function (e) {
      this.$root.$refs.appProgress.busy(true);
      await Repository.countIrregularList(
        this.mSearchParam
      ).then(response => {
        var result = response.data;
        if(result.isSuccess) {
          this.mIrregularCount = result.data;
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
    /** CSV出力 */
    downloadSetup: async function(e) {
      await this.count();
      if(this.mIrregularCount == 0) {
        alert('検索結果が0件のため、ダウンロードできません。');
        return false;
      }
      var fileName = "IrregularList";
      var request = this.mSearchParam;
      var url = Repository.downloadIrregularListUrl();
      this.download(fileName,request,url);
    },
    /** 新規作成 */
    newLink: function() {
      // イレギュラ設定
      this.$root.$refs.appProgress.busy(true);
      location.href = this.$root.URL_CONST.C_L31;
    },
    /** 日付形式か判定 */
    judgeDate: function(date) {
      var reg = /[0-9]+[-][0-9]+[-][0-9]+/;
      return reg.test(date);
    },
    /** デポ選択画面表示 */
    depoListOpen: function(isTrans) {
      var func = undefined;
      if(isTrans) {
        // 振替先配送デポ
        func = this.searchTransDepoRegist;
      } else {
        // 通常配送デポ
        func = this.searchDepoRegist;
      }
      childWinOpen(this.$root.URL_CONST.C_L51, undefined, func);
      // childWinOpen(this.$root.URL_CONST.C_L50, undefined, func);
    },
    /** デポ選択画面内容反映 */
    searchDepoRegist: function(depoList) {
      // 追加
      this.mSearchParam.searchChoiceDepoList = [];
      depoList.forEach(addDepo => {
        var depoparam = {
          'depocd': addDepo.depocd,
          'deponame': addDepo.deponame,
        }
        this.mSearchParam.searchChoiceDepoList.push(depoparam);
      });
    },
    /** 振替先用デポ選択画面内容反映 */
    searchTransDepoRegist: function(depoList) {
      // 追加
      this.mSearchParam.searchChoiceTransDepoList = [];
      depoList.forEach(addDepo => {
        var depoparam = {
          'depocd': addDepo.depocd,
          'deponame': addDepo.deponame,
        }
        this.mSearchParam.searchChoiceTransDepoList.push(depoparam);
      });
    },
    /** 商品選択画面表示 */
    productlistOpen: function() {
      var params = new Array();
      params['isList'] = [true];
      childWinOpen(this.$root.URL_CONST.C_L53, params, this.searchProductRegist);
      // childWinOpen(this.$root.URL_CONST.C_L52, undefined, this.searchProductRegist);
    },
    /** 商品選択内容反映 */
    searchProductRegist: function(itemCategoryLargeCd,itemCategoryLargeName,itemCategoryMediumCd,itemCategoryMediumName,itemList) {
      this.mSearchParam.searchItemList = [];
      this.itemNameList = [];
      this.itemCategoryLargeNameList = [];
      this.itemCategoryMediumNameList = [];
      itemList.forEach(addItem => {
        if(addItem.itemCd != null) {
          // 商品単位での選択がされた場合
          this.itemNameList.push(addItem.itemName);
        } else {
          // カテゴリ大、カテゴリ中の選択がされた場合
          if(addItem.itemCategoryMediumCd == null) {
            // カテゴリ大
            this.itemCategoryLargeNameList.push(addItem.itemCategoryLargeName)
          } else {
            // カテゴリ中
            this.itemCategoryMediumNameList.push(addItem.itemCategoryMediumName)
          }
        }
        this.mSearchParam.searchItemList.push({ ...addItem });
      });
    },
    /** 日付選択子画面表示 */
    dateSelectOpen:function(isDeliveryDate){
      var func = undefined;
      if(isDeliveryDate) {
        // お届け日
        func = this.searchDeliveryDateRegist;
      } else {
        // 受注日
        func = this.searchOrderDateRegist;
      }
      childWinOpen(this.$root.URL_CONST.C_L54, undefined, func);
    },
    /** 日付選択内容反映（お届け日） */
    searchDeliveryDateRegist: function(
      selectType, 
      selectYear, selectMonth, selectDate,
      selectWeekList,
      selectHolidayList,
      selectStartYear, selectStartMonth, selectStartDate,
      selectEndYear, selectEndMonth, selectEndDate
    ) {
      // データタイプ
      this.mSearchParam.searchDeliveryDateType = selectType;
      // 日付
      this.mDeliveryYear = selectYear;
      this.mDeliveryMonth = selectMonth;
      this.mDeliveryDate = selectDate;
      // 曜日
      this.mDeliveryWeekList = selectWeekList ? selectWeekList : [];
      this.mDeliveryHolidayList = selectHolidayList ? selectHolidayList : [];
      // 期間
      this.mDeliveryStartYear = selectStartYear;
      this.mDeliveryStartMonth = selectStartMonth;
      this.mDeliveryStartDate = selectStartDate;
      this.mDeliveryEndYear = selectEndYear;
      this.mDeliveryEndMonth = selectEndMonth;
      this.mDeliveryEndDate = selectEndDate;
    },
    /** 日付選択内容反映（受注日） */
    searchOrderDateRegist: function(
      selectType, 
      selectYear, selectMonth, selectDate,
      selectWeekList,
      selectHolidayList,
      selectStartYear, selectStartMonth, selectStartDate,
      selectEndYear, selectEndMonth, selectEndDate
    ) {
      // データタイプ
      this.mSearchParam.searchOrderType = selectType;
      // 日付
      this.mOrderYear = selectYear;
      this.mOrderMonth = selectMonth;
      this.mOrderDate = selectDate;
      // 曜日
      this.mOrderWeekList = selectWeekList ? selectWeekList : [];
      this.mOrderHolidayList = selectHolidayList ? selectHolidayList : [];
      // 期間
      this.mOrderStartYear = selectStartYear;
      this.mOrderStartMonth = selectStartMonth;
      this.mOrderStartDate = selectStartDate;
      this.mOrderEndYear = selectEndYear;
      this.mOrderEndMonth = selectEndMonth;
      this.mOrderEndDate = selectEndDate;
    },
    /** 住所選択画面表示 */
    addresslistOpen: function() {
      var params = new Array();
      params['isAddress'] = true;
      childWinOpen(this.$root.URL_CONST.C_L55, params, this.searchAddressRegist);
    },
    /** 住所選択内容反映 */
    searchAddressRegist: function(displayType, address) {
      var zipcdList    = [];
      var prefList     = [];
      var prefNameList = [];
      var sikuList     = [];
      var tyouList     = [];
      
      Object.values(address).forEach((value, i) => {
        if(value.zipcode != null && zipcdList.indexOf(value.zipcode) == -1){
          zipcdList.push(value.zipcode);
        } 
        if(value.pref != null && prefList.indexOf(value.pref) == -1){
          prefList.push(value.pref);
        }
        if(value.prefName != null && prefNameList.indexOf(value.prefName) == -1){
          prefNameList.push(value.prefName);
        }
        if(value.siku != null && sikuList.indexOf(value.siku) == -1){
          sikuList.push(value.siku);
        }
        if(value.tyou != null && tyouList.indexOf(value.tyou) == -1){
          tyouList.push(value.tyou);
        }
      });
      // 検索条件に追加する
      this.mSearchParam.searchZipcdList    = zipcdList;
      this.mSearchParam.searchPrefList     = prefList;
      this.mSearchParam.searchPrefNameList = prefNameList;
      this.mSearchParam.searchSikuList     = sikuList;
      this.mSearchParam.searchTyouList     = tyouList;
      this.$forceUpdate();
    },
    /** イレギュラー設定画面に遷移 */
    irregularConfigLink: function(model){
      location.assign(this.$root.URL_CONST.C_L31 + '?irregularId=' + model.irregular_id);
    },
    timeSelectTrans: function(model){
      if(model == null) return '';
      var returnTimeSelect = null;

      if(model.irregular_type === 1) {
        returnTimeSelect = model.is_time_select_undeliv ? '時間指定不可' : ''; 
      } else if(model.irregular_type === 2) {
        returnTimeSelect = this.deliveryDateList[model.time_select];
      } else {
        returnTimeSelect = '';
      }
      return returnTimeSelect;
    },
    timestampTrans: function(timestamp){
      if(timestamp == null) return '';

      var returnDate = moment(timestamp).format('YYYY/MM/DD HH:mm:ss');
      return returnDate;
    },
    irregularTypeTrans: function(irregularType){
      if(irregularType == null) return '';

      var returnIrregularType = this.irregularConfigClassificationList[irregularType];
      return returnIrregularType;
    },
    flgTrans: function(flg){
      if(flg == null) return '';
      var returnFlg = flg ? '×' : '';
      return returnFlg;
    },
    isAreaTrans: function(flg){
      if(flg == null) return '';
      var returnFlg = flg ? '一部の地域' : '全地域';
      return returnFlg;
    },
    dispSearchResultDate(isDelivery,model) {
      var result = '';
      var dateTypeKey         = isDelivery ? 'delivery_date_type' : 'order_date_type';
      var dateKey             = isDelivery ? 'delivery_date' : 'order_date';
      var dateFromKey         = isDelivery ? 'delivery_date_from' : 'order_date_from';
      var dateToKey           = isDelivery ? 'delivery_date_to' : 'order_date_to';
      var weekHolidayListKey  = isDelivery ? 'delivery_week_holiday_list' : 'order_week_holiday_list';
      if(model[dateTypeKey]) {
        if(model[dateTypeKey] === 1) {
          if(model[dateKey]) {
            result = moment(model[dateKey]).format('YYYY/M/D');
          }
        } else if(model[dateTypeKey] === 2) {
          if(model[dateFromKey] && model[dateToKey]) {
            var from = moment(model[dateFromKey]).format('YYYY/M/D');
            var to   = moment(model[dateToKey]).format('YYYY/M/D');
            result = from + ' 〜 ' + to;
          }

        } else if(model[dateTypeKey] === 3) {
          // 曜日
          if(model[weekHolidayListKey]) {
            result = model[weekHolidayListKey];
          }
        }
      }

      return result;
    },
    accordionToggle: function(){
      this.isAccordionOpen = !this.isAccordionOpen;
    },
    beforeEnter: function(el) {
      el.style.height = '0';
    },
    enter: function(el) {
      el.style.height = '0';
      el.style.height = el.scrollHeight + 'px';
    },
    beforeLeave: function(el) {
      el.style.height = el.scrollHeight + 'px';
    },
    leave: function(el) {
      el.style.height = '0';
    }
  },
  computed: {
    /** デポ名表示 */
    dispDepoName: function() {
      var result = '';
      var deponamelist = [];
      if(this.mSearchParam.searchChoiceDepoList) {
        this.mSearchParam.searchChoiceDepoList.forEach(v => {
          deponamelist.push(v.deponame);
        });
        result = deponamelist.join(',');
      }
      return result;
    },
    /** デポ名表示 */
    dispTransDepoName: function() {
      var result = '';
      var deponamelist = [];
      if(this.mSearchParam.searchChoiceTransDepoList) {
        this.mSearchParam.searchChoiceTransDepoList.forEach(v => {
          deponamelist.push(v.deponame);
        });
        result = deponamelist.join(',');
      }
      return result;
    },
    /** カテゴリ大名表示 */
    dispItemCategoryLargeName: function() {
      return this.itemCategoryLargeNameList.join(',');
    },
    /** カテゴリ中名表示 */
    dispItemCategoryMediumName: function() {
      return this.itemCategoryMediumNameList.join(',');
    },
    /** 商品名表示 */
    dispItemName: function() {
      return this.itemNameList.join(',');
    },
    /** お祝い用途絞り込み */
    cUseCelebList:function(){
      var list = this.cUseList.filter(function(item){
        return item.keichoType == 1;
      })
      return list;
    },
    /** お悔やみ用途絞り込み */
    cUseCondolList:function(){
      var list = this.cUseList.filter(function(item){
        return item.keichoType == 2;
      })
      return list;
    },
    /** 検索結果件数 */
    searchCountComputed: function() {
      return this.mIrregularList.length;
    },
    /** お届け日表示 */
    dispDeliveryDate: function() {
      var result = '';
      if(this.mSearchParam.searchDeliveryDate) {
        result = moment(this.mSearchParam.searchDeliveryDate,'YYYY-MM-DD').format('YYYY/M/D');
      }
      return result;
    },
    /** お届け曜日表示 */
    dispDeliveryWeek: function() {
      var resultList = [];

      if(this.mDeliveryWeekList) {
        for(var i = 0;i < this.mDeliveryWeekList.length; i++) {
          resultList.push(this.judgeWeek(this.mDeliveryWeekList[i]));
        }
      }

      if(this.mDeliveryHolidayList) {
        for(var i = 0;i < this.mDeliveryHolidayList.length; i++) {
          resultList.push(this.judgeHoliday(this.mDeliveryHolidayList[i]));
        }
      }

      return resultList.join(',');
    },
    /** お届け期間表示 */
    dispDeliveryPeriod: function() {
      var result = '';
      if(this.mSearchParam.searchDeliveryPeriodStart && this.mSearchParam.searchDeliveryPeriodEnd) {
        var from = moment(this.mSearchParam.searchDeliveryPeriodStart,'YYYY-MM-DD').format('YYYY/M/D');
        var to = moment(this.mSearchParam.searchDeliveryPeriodEnd,'YYYY-MM-DD').format('YYYY/M/D');
        result = from + '〜' + to;
      }
      return result;
    },
    /** 受注日表示 */
    dispOrderDate: function() {
      var result = '';
      if(this.mSearchParam.searchOrderDate) {
        result = moment(this.mSearchParam.searchOrderDate,'YYYY-MM-DD').format('YYYY/M/D');
      }
      return result;
    },
    /** 受注曜日表示 */
    dispOrderPeriod: function() {
      var result = '';
      if(this.mSearchParam.searchOrderPeriodStart && this.mSearchParam.searchOrderPeriodEnd) {
        var from = moment(this.mSearchParam.searchOrderPeriodStart,'YYYY-MM-DD').format('YYYY/M/D');
        var to = moment(this.mSearchParam.searchOrderPeriodEnd,'YYYY-MM-DD').format('YYYY/M/D');
        result = from + '〜' + to;
      }
      return result;

    },
    /** 受注期間表示 */
    dispOrderWeek: function() {
      var resultList = [];

      if(this.mOrderWeekList) {
        for(var i = 0;i < this.mOrderWeekList.length; i++) {
          resultList.push(this.judgeWeek(this.mOrderWeekList[i]));
        }
      }

      if(this.mOrderHolidayList) {
        for(var i = 0;i < this.mOrderHolidayList.length; i++) {
          resultList.push(this.judgeHoliday(this.mOrderHolidayList[i]));
        }
      }

      return resultList.join(',');

    },
    /** 郵便番号表示 */
    dispZipCd: function() {
      var result = '';
      if(this.mSearchParam.searchZipcdList) {
        result = this.mSearchParam.searchZipcdList.join(',');
      }
      return result;
    },
    /** 都道府県表示 */
    dispPrefName: function() {
      var result = '';
      if(this.mSearchParam.searchPrefNameList) {
        result = this.mSearchParam.searchPrefNameList.join(',');
      }
      return result;
    },
    /** 市区郡表示 */
    dispSiku: function() {
      var result = '';
      if(this.mSearchParam.searchSikuList) {
        result = this.mSearchParam.searchSikuList.join(',');
      }
      return result;
    },
    /** 町名表示 */
    dispTyou: function() {
      var result = '';
      if(this.mSearchParam.searchTyouList) {
        result = this.mSearchParam.searchTyouList.join(',');
      }
      return result;
    },
  },
  created() {
    this.$watch(
      /** お届け日　監視 */
      () => [
        this.$data.mDeliveryYear,
        this.$data.mDeliveryMonth,
        this.$data.mDeliveryDate,
        this.$data.mDeliveryStartYear,
        this.$data.mDeliveryStartMonth,
        this.$data.mDeliveryStartDate,
        this.$data.mDeliveryEndYear,
        this.$data.mDeliveryEndMonth,
        this.$data.mDeliveryEndDate,
        this.$data.mDeliveryWeekList,
        this.$data.mDeliveryHolidayList,
      ],
      (value, oldValue) => {
        // 日付
        if(this.mDeliveryYear && this.mDeliveryMonth && this.mDeliveryDate) {
          this.mSearchParam.searchDeliveryDate = moment([this.mDeliveryYear,this.mDeliveryMonth - 1,this.mDeliveryDate]).format('YYYY-MM-DD');
        } else {
          this.mSearchParam.searchDeliveryDate = null;
        }
        // 期間
        if(this.mDeliveryStartYear && this.mDeliveryStartMonth && this.mDeliveryStartDate && 
           this.mDeliveryEndYear && this.mDeliveryEndMonth && this.mDeliveryEndDate) {
          this.mSearchParam.searchDeliveryPeriodStart = moment([
            this.mDeliveryStartYear,
            this.mDeliveryStartMonth - 1,
            this.mDeliveryStartDate
          ]).format('YYYY-MM-DD');
          this.mSearchParam.searchDeliveryPeriodEnd = moment([
            this.mDeliveryEndYear,
            this.mDeliveryEndMonth - 1,
            this.mDeliveryEndDate
          ]).format('YYYY-MM-DD');
        } else {
          this.mSearchParam.searchDeliveryPeriodStart = null;
          this.mSearchParam.searchDeliveryPeriodEnd = null;
        }
        // 曜日
        if(this.mDeliveryWeekList || this.mDeliveryHolidayList) {
          this.mSearchParam.searchDeliveryWeekList = this.mDeliveryWeekList;
          this.mSearchParam.searchDeliveryHolidayList = this.mDeliveryHolidayList;
        } else {
          this.mSearchParam.searchDeliveryWeekList = [];
          this.mSearchParam.searchDeliveryHolidayList = [];
        }
      },
    );
    this.$watch(
      /** 受注日　期間監視 */
      () => [
        this.$data.mOrderYear,
        this.$data.mOrderMonth,
        this.$data.mOrderDate,
        this.$data.mOrderStartYear,
        this.$data.mOrderStartMonth,
        this.$data.mOrderStartDate,
        this.$data.mOrderEndYear,
        this.$data.mOrderEndMonth,
        this.$data.mOrderEndDate,
        this.$data.mOrderWeekList,
        this.$data.mOrderHolidayList,
      ],
      (value, oldValue) => {
        // 日付
        if(this.mOrderYear && this.mOrderMonth && this.mOrderDate) {
          this.mSearchParam.searchOrderDate = moment([
            this.mOrderYear,
            this.mOrderMonth - 1,
            this.mOrderDate
          ]).format('YYYY-MM-DD');
        } else {
          this.mSearchParam.searchOrderDate = null;
        }
        // 期間
        if(this.mOrderStartYear && this.mOrderStartMonth && this.mOrderStartDate && 
           this.mOrderEndYear && this.mOrderEndMonth && this.mOrderEndDate) {
          this.mSearchParam.searchOrderPeriodStart = moment([
            this.mOrderStartYear,
            this.mOrderStartMonth - 1,
            this.mOrderStartDate
          ]).format('YYYY-MM-DD');

          this.mSearchParam.searchOrderPeriodEnd = moment([
            this.mOrderEndYear,
            this.mOrderEndMonth - 1,
            this.mOrderEndDate
          ]).format('YYYY-MM-DD');
        } else {
          this.mSearchParam.searchOrderPeriodStart = null;
          this.mSearchParam.searchOrderPeriodEnd = null;
        }
        // 曜日
        if(this.mOrderWeekList || this.mOrderHolidayList) {
          this.mSearchParam.searchOrderWeekList = this.mOrderWeekList;
          this.mSearchParam.searchOrderHolidayList = this.mOrderHolidayList;
        } else {
          this.mSearchParam.searchOrderWeekList = [];
          this.mSearchParam.searchOrderHolidayList = [];
        }
      },
    );
  }
};
</script>