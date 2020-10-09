<template>
  <div>
    <div class="row mt-2">
      <div class="col-md-4 form-inline">
        <form id="remake-form" class="form-inline" :action="$root.URL_CONST.C_L31_REMAKE" method="GET">
          <label class="mr-4">イレギュラー設定</label>
          <input type="hidden" name="irregularId" v-if="isEdit" :value="mIrregular.irregularId">
          <button type="button" class="btn btn-primary" v-if="isEdit" @click="remake">複製</button>
        </form>
      </div>
      <div class="col-md-8 text-right">
        <label class="mr-4" v-if="isEdit">更新者：{{mIrregular.name1+" "+mIrregular.name2}}</label>
        <label v-if="isEdit">更新日時：{{mIrregular.updatedAt}}</label>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 p-1">
        <div class="box1">
          <span class="irregular-label">タイトル</span><span class="badge badge-danger">必須</span>
          <input class="form-control" type="text" v-model="mIrregular.title">
        </div>
      </div>
      <div class="col-md-4 p-1">
        <div class="box1">
          <span class="irregular-label">イレギュラー設定区分</span>
          <div class="item-group-control">
            <input class="mr-2" id="typeNo" type="radio" v-model="mIrregular.irregularType" value=1>
            <label class="mr-4" for="typeNo">配送不可</label>
            <input class="mr-2" id="typeControl" type="radio" v-model="mIrregular.irregularType" value=2>
            <label class="mr-4" for="typeControl">受注制御</label>
            <input class="mr-2" id="typeChange" type="radio" v-model="mIrregular.irregularType" value=3>
            <label for="typeChange">配送先振替</label>
          </div>
        </div>
      </div>
      <div class="col-md-2 p-1">
        <div class="box1">
          <span class="irregular-label">用途</span>
          <select class="form-control" v-model="mIrregular.cUse">
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
      </div>
      <div class="col-md-2 p-1">
        <div class="box1">
          <span class="irregular-label">有効区分</span>
          <div class="item-group-control">
            <input class="mr-2" id="isValidTrue" type="radio" v-model="mIrregular.isValid" :value="true">
            <label class="mr-4" for="isValidTrue">有効</label>
            <input class="mr-2" id="isValidFalse" type="radio" v-model="mIrregular.isValid" :value="false">
            <label for="isValidFalse">無効</label>
          </div>
        </div>
      </div>
    </div>
    <div class="row" v-if="mIrregular.irregularType==1 || mIrregular.irregularType==2">
      <div class="col-md-6 p-1">
        <div class="box1">
          <span class="irregular-label">不可制御エリア</span>
          <div class="form-group pl-3 impossible-area">
            <template v-if="mIrregular.irregularType==1">
              <input id="isBeforeDeadlineUndelivCheck" class="mr-2" type="checkbox" v-model="mIrregular.isBeforeDeadlineUndeliv">
              <label class="mr-4" for="isBeforeDeadlineUndelivCheck">前日締切</label>
            </template>
            <template>
              <input id="isTodayDeadlineUndelivCheck" class="mr-2" type="checkbox" v-model="mIrregular.isTodayDeadlineUndeliv">
              <label class="mr-4" for="isTodayDeadlineUndelivCheck">当日配送</label>
            </template>
            <template v-if="mIrregular.irregularType==1">
              <input id="isTimeSelectUndelivCheck" class="mr-2" type="checkbox" v-model="mIrregular.isTimeSelectUndeliv">
              <label class="mr-4" for="isTimeSelectUndelivCheck">時間指定</label>
            </template>
            <template v-if="mIrregular.irregularType==2">
              <label class="mr-2">配送時間</label>
              <select class="form-control mr-4 time-select-control" v-model="mIrregular.timeSelect">
                <option value="">なし</option>
                <option v-for="(value, key) in timeSelectList" :key="'time-' + key" :value="key">
                {{ value }}
                </option>
              </select>
            </template>
            <template>
              <input id="isPersonalDeliveryCheck" class="mr-2" type="checkbox" v-model="mIrregular.isPersonalDelivery">
              <label for="isPersonalDeliveryCheck">個人宅</label>
            </template>
          </div>
        </div>
      </div>
      <!-- 配送不可／受注制御用 -->
      <div class="col-md-6 p-1">
        <div class="box1">
          <span class="irregular-label">お届け日</span>
          <div class="form-group pl-3 pt-3">
            <p>日付：{{ dispDeliveryDate }}</p>
            <p>曜日：{{ dispDeliveryWeek }}</p>
            <p>期間：{{ dispDeliveryPeriod }}</p>
          </div>
          <button type="button" class="btn btn-primary select-btn-position" @click="dateSelectOpen(true)">選択</button>
          <button type="button" class="btn btn-danger select-delete-btn-position" @click="dateSelectDelete(true)" :disabled="!mIrregular.deliveryDateType">削除</button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 p-1" v-if="mIrregular.irregularType==1 || mIrregular.irregularType==2">
        <div class="box1">
          <span class="irregular-label">デポ</span>
          <div class="form-inline pl-3 mb-1">
            <input id="depoAllRadio" class="mr-2" type="radio" v-model="mIrregular.isDepo" :value="false">
            <label for="depoAllRadio" class="mr-2">すべて</label>
            <input id="depoRadio" class="mr-2" type="radio" v-model="mIrregular.isDepo" :value="true">
            <label for="depoRadio" class="mr-2">一部のデポ</label>
            <button type="button" class="btn btn-primary ml-2" @click="depoSelectOpen(true)" v-bind:disabled="!mIrregular.isDepo">選択</button>
          </div>
          <div class="col irregular-sticky-table">
            <table class="table-striped table-hover">
              <thead>
                <tr>
                  <th class="th-check" scope="col"><input type="checkbox" v-model="allDepoSelected"/></th>
                  <th class="th-no" scope="col">No</th>
                  <th class="th-depo" scope="col">デポ</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(depo,index) in mChoiceDepoList" :key="depo.depocd" @click="selectDepo(depo)" class="list-row" v-bind:class="{'selected': depo.isSelect}">
                  <td class="align-middle"><input type="checkbox" v-bind:value="depo" :checked="depo.isSelect" ></td>
                  <td>{{ index + 1 }}</td>
                  <td>{{ '【'+ depo.depocd +'】'+depo.deponame }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="mt-2 mb-2">
            <button type="button" v-if="mChoiceDepoList" @click="delDepo" class="btn btn-danger" v-bind:disabled="checkDepoList.length == 0">削除</button>
          </div>
        </div>
      </div>
      <div class="col-md-8 p-1">
        <div class="box1">
          <span class="irregular-label">商品</span>
          <div class="form-inline pl-3 mb-1">
            <input id="itemAllRadio" class="mr-2" type="radio" v-model="mIrregular.isItem" :value="false">
            <label for="itemAllRadio" class="mr-2">すべて</label>
            <input id="itemRadio" class="mr-2" type="radio" v-model="mIrregular.isItem" :value="true">
            <label for="itemRadio" class="mr-2">一部の商品</label>
            <button type="button" class="btn btn-primary ml-2" @click="itemlistOpen" v-bind:disabled="!mIrregular.isItem">選択</button>
          </div>
          <div class="col irregular-sticky-table">
            <table class="table-striped table-hover">
              <thead>
                <tr>
                  <th class="th-check" scope="col"><input type="checkbox" v-model="allItemSelected"/></th>
                  <th class="th-no" scope="col">No</th>
                  <th class="th-large" scope="col">商品カテゴリ大</th>
                  <th class="th-middle" scope="col">商品カテゴリ中</th>
                  <th class="th-item" scope="col">商品</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in mChoiceItemList" :key="item.itemCd" @click="selectItem(item)" class="list-row" v-bind:class="{'selected': item.isSelect}">
                  <td class="align-middle"><input type="checkbox" :checked="item.isSelect"></td>
                  <td>{{ index + 1 }}</td>
                  <td>{{ '【'+item.itemCategoryLargeCd+'】'+item.itemCategoryLargeName }}</td>
                  <td><span v-if="item.itemCategoryMediumCd">{{ '【'+item.itemCategoryMediumCd+'】'+item.itemCategoryMediumName }}</span></td>
                  <td><span v-if="item.itemCd">{{ '【'+item.itemCd+'】' + item.itemName }}</span></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="mt-2 mb-2">
            <button type="button" v-if="mChoiceItemList" @click="delItem" class="btn btn-danger" v-bind:disabled="checkItemList.length == 0">削除</button>
          </div>
        </div>
      </div>
      <div class="col-md-4 p-1" v-if="mIrregular.irregularType==3">
        <div class="box1">
          <span class="irregular-label">受注日</span>
          <div class="form-group pl-3 pt-3">
            <p>日付：{{ dispOrderDate }}</p>
            <p>曜日：{{ dispOrderWeek }}</p>
            <p>期間：{{ dispOrderPeriod }}</p>
          </div>
          <button type="button" class="btn btn-primary select-btn-position" @click="dateSelectOpen(false)">選択</button>
          <button type="button" class="btn btn-danger select-delete-btn-position" @click="dateSelectDelete(false)" :disabled="!mIrregular.orderDateType">削除</button>
        </div>
      </div>
    </div>
    <div class="row">
      <div :class="{'col-md-12' : isArea,'col-md-8' : !isArea}" class="p-1">
        <div class="box1">
          <span v-if="isArea" class="irregular-label">地域</span>
          <span v-if="!isArea" class="irregular-label">市区郡</span>
          <div class="form-inline pl-3 mb-1">
            <input id="areaAllRadio" class="mr-2" type="radio" v-model="mIrregular.isArea" :value="false">
            <label for="areaAllRadio" class="mr-2">すべて</label>
            <input id="areaRadio" class="mr-2" type="radio" v-model="mIrregular.isArea" :value="true">
            <label for="areaRadio" class="mr-2">一部の地域</label>
            <button type="button" class="btn btn-primary ml-2" @click="arealistOpen(true)" v-if="isArea" v-bind:disabled="!mIrregular.isArea">地域選択</button>
            <button type="button" class="btn btn-primary ml-2" @click="arealistOpen(false)" v-if="!isArea" v-bind:disabled="!mIrregular.isArea">市区郡選択</button>
          </div>
          <div class="col irregular-sticky-table">
            <table class="table-striped table-hover">
              <thead>
                <tr>
                  <th class="th-check" scope="col"><input type="checkbox" v-model="allAreaSelected"/></th>
                  <th class="th-no" scope="col">No</th>
                  <th class="th-zip" scope="col">郵便番号</th>
                  <th class="th-pref" scope="col">都道府県</th>
                  <th class="th-siku" scope="col">市区郡</th>
                  <th class="th-tyou" scope="col" v-if="isArea">町名</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(address,index) in mChoiceAreaList" :key="getAreaKey(address.pref,address.siku,address.tyou)" @click="selectArea(address)" class="list-row" v-bind:class="{'selected': address.isSelect}">
                  <td class="align-middle"><input type="checkbox" :checked="address.isSelect"></td>
                  <td>{{ index + 1 }}</td>
                  <td>{{ address.zipcode }}</td>
                  <td>{{ address.prefName }}</td>
                  <td>{{ address.siku }}</td>
                  <td v-if="isArea">{{ address.tyou }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="mt-2 mb-2">
            <button type="button" v-if="mChoiceDepoList" @click="delArea" class="btn btn-danger" v-bind:disabled="checkAreaList.length == 0">削除</button>
          </div>
        </div>
      </div>
      <!-- 配送先振替用 -->
      <div class="col-md-4 p-1" v-if="mIrregular.irregularType==3">
        <div class="box1">
          <span class="irregular-label">お届け日</span>
          <div class="form-group pl-3 pt-3">
            <p>日付：{{ dispDeliveryDate }}</p>
            <p>曜日：{{ dispDeliveryWeek }}</p>
            <p>期間：{{ dispDeliveryPeriod }}</p>
          </div>
          <button type="button" class="btn btn-primary select-btn-position" @click="dateSelectOpen(true)">選択</button>
          <button type="button" class="btn btn-danger select-delete-btn-position" @click="dateSelectDelete(true)" :disabled="!mIrregular.deliveryDateType">削除</button>
        </div>
      </div>
    </div>
    <div class="row" v-if="mIrregular.irregularType==3">
      <div class="col-md-12 p-1 h-100">
        <div class="box1">
          <span class="irregular-label">振替先配送デポ</span>
          <span class="badge badge-danger">必須</span>
          <button type="button" class="btn btn-primary ml-3" @click="depoSelectOpen(false)">選択</button>
          <div class="pl-3 mt-1">
            <p class="under-line">振替先配送デポ名：<template v-if="mIrregular.transDepoCd">{{'【'+mIrregular.transDepoCd+'】'+mIrregular.transDepoName}}</template></p>
          </div>
          <span class="irregular-label">振替注釈</span>
          <quill-editor v-model="mIrregular.annoTrans" ref="quillEditor"></quill-editor>
        </div>
      </div>
    </div>
    <div class="row"  v-if="mIrregular.irregularType==1 || mIrregular.irregularType==2">
      <div class="col-md-12 p-1">
        <div class="box1">
          <span class="irregular-label">赤文字注釈</span>
          <div class="d-flex flex-row mb-3 pl-3" v-if="mIrregular.irregularType==1 || mIrregular.irregularType==2">
            <span class="irregular-label form-inline mr-3">表示期間</span>
            <app-date-pulldown
              v-bind:select-year.sync="annoStartYear"
              v-bind:select-month.sync="annoStartMonth"
              v-bind:select-day.sync="annoStartDate"
            ></app-date-pulldown>

            <div class="div-date dash"><label>~</label></div>

            <app-date-pulldown
              v-bind:select-year.sync="annoEndYear"
              v-bind:select-month.sync="annoEndMonth"
              v-bind:select-day.sync="annoEndDate"
            ></app-date-pulldown>
          </div>
          <div class="row">
            <div class="col-md-6 h-100">
              <span class="irregular-label">地域注釈</span>
              <quill-editor v-model="mIrregular.annoAddr" ref="quillEditor"></quill-editor>
            </div>
            <div class="col-md-6 h-100">
              <span class="irregular-label">期間注釈</span>
              <quill-editor v-model="mIrregular.annoPeriod" ref="quillEditor"></quill-editor>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 h-100 p-1">
        <div class="box1">
          <span class="irregular-label">エラーメッセージ</span><span class="badge badge-danger">必須</span>
          <quill-editor v-model="mIrregular.errorMessage" ref="quillEditor"></quill-editor>
        </div>
      </div>
      <div class="col-md-6 p-1">
        <div class="box1">
          <span class="irregular-label">備考</span>
          <textarea class="form-control" rows="12" cols="100" v-model="mIrregular.remark"></textarea>
        </div>
      </div>
    </div>
    <div class="row my-3">
        <div class="col-md-1">
          <button class="btn btn-primary" href="#" @click="listLink" role="button">一覧</button>
        </div>
        <div class="col-md-1">
          <button class="btn btn-danger" role="button" v-if="isEdit" @click="deleteIrregular">削除</button>
        </div>
        <div class="col-md-7" />
        <div class="col-md-3 text-right">
          <button class="btn btn-primary" role="button" @click="messagelistOpen" v-bind:disabled="!msgIsActive">メッセージ重複確認</button>
          &nbsp;
          <button class="btn btn-primary" role="button" @click="registerIrregular" v-bind:disabled="!mRegisterIsActive">登録</button>
        </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import Repository from '../../api/Repository';
import Error from "../mixins/Error";
import DateUtil from "../mixins/DateUtilMixins";
export default {
  mixins: [Error,DateUtil],
  props:{
    isEdit:Boolean,
    cUseList:Array,
    timeSelectList:Object,
    irregular:Object,
    irregularAreaList:Array,
    irregularItemList:Array,
    irregularDepoList:Array,
    irregularDeliveryDayofweekList:Array,
    irregularOrderDayofweekList:Array,
  },
  data:function(){
    return{
      mIrregular: this.irregular,
      mChoiceItemList: this.irregularItemList,
      allItemSelected:false,
      mRegisterItemList:[],
      mChoiceDepoList:this.irregularDepoList,
      allDepoSelected: false,
      mRegisterDepoList:[],
      mChoiceAreaList:this.irregularAreaList,
      allAreaSelected:false,
      mRegisterAreaList:[],
      mIrregularDeliveryDayofweekList: this.irregularDeliveryDayofweekList,
      mIrregularOrderDayofweekList: this.irregularOrderDayofweekList,
      mDeliveryYear: this.getDateSplit(this.irregular.deliveryDate, 1),
      mDeliveryMonth: this.getDateSplit(this.irregular.deliveryDate, 2),
      mDeliveryDate: this.getDateSplit(this.irregular.deliveryDate, 3),
      mDeliveryStartYear: this.getDateSplit(this.irregular.deliveryDateFrom, 1),
      mDeliveryStartMonth: this.getDateSplit(this.irregular.deliveryDateFrom, 2),
      mDeliveryStartDate: this.getDateSplit(this.irregular.deliveryDateFrom, 3),
      mDeliveryEndYear: this.getDateSplit(this.irregular.deliveryDateTo, 1),
      mDeliveryEndMonth: this.getDateSplit(this.irregular.deliveryDateTo, 2),
      mDeliveryEndDate: this.getDateSplit(this.irregular.deliveryDateTo, 3),
      mOrderYear: this.getDateSplit(this.irregular.orderDate, 1),
      mOrderMonth: this.getDateSplit(this.irregular.orderDate, 2),
      mOrderDate: this.getDateSplit(this.irregular.orderDate, 3),
      mOrderStartYear: this.getDateSplit(this.irregular.orderDateFrom, 1),
      mOrderStartMonth: this.getDateSplit(this.irregular.orderDateFrom, 2),
      mOrderStartDate: this.getDateSplit(this.irregular.orderDateFrom, 3),
      mOrderEndYear: this.getDateSplit(this.irregular.orderDateTo, 1),
      mOrderEndMonth: this.getDateSplit(this.irregular.orderDateTo, 2),
      mOrderEndDate: this.getDateSplit(this.irregular.orderDateTo, 3),
      annoStartYear: this.getDateSplit(this.irregular.annoFrom, 1),
      annoStartMonth: this.getDateSplit(this.irregular.annoFrom, 2),
      annoStartDate: this.getDateSplit(this.irregular.annoFrom, 3),
      annoEndYear: this.getDateSplit(this.irregular.annoTo, 1),
      annoEndMonth: this.getDateSplit(this.irregular.annoTo, 2),
      annoEndDate: this.getDateSplit(this.irregular.annoTo, 3),
      mDeliveryWeekStr:"",
      mRegisterIsActive: false,
      mAnnoDateValidate: true
    }
  },
  mounted: function() {
    // 編集、複製時
    // 一部のデポ
    if (this.mChoiceDepoList.length > 0) {
      this.mChoiceDepoList.forEach(addDepo => {
        // 追加
        addDepo['mode'] = 'add';
        this.mRegisterDepoList.push({ ...addDepo })
      });
    }
    // 一部のアイテム
    if (this.mChoiceItemList.length > 0) {
      this.mChoiceItemList.forEach(addItem => {
        // 追加
        addItem['mode'] = 'add';
        this.mRegisterItemList.push({ ...addItem });
      });
    }
    // 一部の地域
    if (this.mChoiceAreaList.length > 0) {
      this.mChoiceAreaList.forEach(addArea => {
        // 追加
        addArea['mode'] = 'add';
        this.mRegisterAreaList.push({ ...addArea });
      });
    }
    // 赤文字注釈:From 通年設定対応 「---年」を選択させる
    if (this.annoStartYear == String(this.$root.CONFIG.BASE_FROM_YESR)) {
      this.annoStartYear = '';
    }
    // 赤文字注釈:To 通年設定対応 「---年」を選択させる
    if (this.annoEndYear == String(this.$root.CONFIG.BASE_TO_YESR)) {
      this.annoEndYear = '';
    }
  },
  methods:{
    /** デポ選択子画面表示 */
    depoSelectOpen:function(isList){
      if(isList) {
        childWinOpen(this.$root.URL_CONST.C_L51, undefined, this.transDepoListRegist);
      } else {
        childWinOpen(this.$root.URL_CONST.C_L50, undefined, this.transDepoRegist);
      }
    },
    /** デポ選択子画面内容反映 */
    transDepoRegist:function(depo){
      this.mIrregular.transDepoCd = depo.depocd;
      this.mIrregular.transDepoName = depo.deponame;
    },
    /** デポ複数選択子画面内容反映 */
    transDepoListRegist:function(depoList){
      // 追加
      var app = this;
      depoList.forEach(addDepo => {
        // 既に親画面のリストに追加されているか判定
        var idx = this.mChoiceDepoList.map(function(item){
          return item.depocd
        }).indexOf(addDepo.depocd);
        if(idx == -1) {
          // 存在しない場合のみ追加
          app.$set(addDepo,'isSelect',false);
          this.mChoiceDepoList.push({ ...addDepo });
        }

        // サーバに渡す登録リストに追加
        var regIdx = this.mRegisterDepoList.map(function(item){
          return item.depocd
        }).indexOf(addDepo.depocd);
        if(regIdx == -1) {
          addDepo['mode'] = 'add';
          this.mRegisterDepoList.push({ ...addDepo });
        } else {
          // 存在するかつ削除モードの場合は登録リストに復帰
          if(this.mRegisterDepoList[regIdx]['mode'] == 'del') {
            this.mRegisterDepoList[regIdx]['mode'] = 'add';
          }
        }
      });
    },
    selectDepo: function (depo) {
      var app = this;
      var oldIsSelect = depo.isSelect;
      if(oldIsSelect) {
        this.$set(depo,"isSelect",false);
      } else {
        this.$set(depo,"isSelect",true);
      }
      this.$forceUpdate();
    },
    /** デポ取扱商品リストからの除外 */
    delDepo: function(e) {
      this.checkDepoList.forEach(delDepo => {
        // 選択されたものを登録対象から削除
        var idx = this.mChoiceDepoList.map(function(item){
          return item.depocd
        }).indexOf(delDepo.depocd);
        this.mChoiceDepoList.splice(idx,1);

        // 登録リストに追加
        var regIdx = this.mRegisterDepoList.map(function(item){
          return item.depocd
        }).indexOf(delDepo.depocd);
        if(regIdx == -1) {
          delDepo['mode'] = 'del';
          this.mRegisterDepoList.push({ ...delDepo });
        } else {
          // 存在するかつ追加モードの場合は登録リストから論理削除モードへ
          if(this.mRegisterDepoList[regIdx]['mode'] == 'add') {
            this.mRegisterDepoList[regIdx]['mode'] = 'del';
          }
        }
      });
    },
    /** 商品複数選択子画面表示 */
    itemlistOpen:function(){
      var params = new Array();
      params['isList'] = [true];
      childWinOpen(this.$root.URL_CONST.C_L53, params, this.transItemListRegist);
    },
    /** 商品選択内容反映 */
    transItemListRegist: function(itemCategoryLargeCd,itemCategoryLargeName,itemCategoryMediumCd,itemCategoryMediumName,itemList) {
      var app = this;
      // 追加
      itemList.forEach(addItem => {
        // 既に親画面のリストに追加されているか判定
        if(addItem.itemCd) {
          // 商品単位での選択がされた場合
          var idx = this.mChoiceItemList.map(function(item){
            return item.itemCd
          }).indexOf(addItem.itemCd);
          if(idx == -1) {
            // 存在しない場合のみ追加
            app.$set(addItem,'isSelect',false);
            this.mChoiceItemList.push({ ...addItem });
          }

          // サーバに渡す登録リストに追加
          var regIdx = this.mRegisterItemList.map(function(item){
            return item.itemCd
          }).indexOf(addItem.itemCd);
          if(regIdx == -1) {
            addItem['mode'] = 'add';
            this.mRegisterItemList.push({ ...addItem });
          } else {
            // 存在するかつ削除モードの場合は登録リストに復帰
            if(this.mRegisterItemList[regIdx]['mode'] == 'del') {
              this.mRegisterItemList[regIdx]['mode'] = 'add';
            }
          }
        } else {
          // カテゴリ大、カテゴリ中の選択がされた場合
          var choiceCheck = false;
          [...this.mChoiceItemList].forEach((v, i) => {
            if(
              v.itemCategoryLargeCd == addItem.itemCategoryLargeCd &&
              v.itemCategoryMediumCd == addItem.itemCategoryMediumCd &&
              v.itemCd == addItem.itemCd
            ) {
              choiceCheck = true;
            }
          })
          if (!choiceCheck) {
            // 存在しない場合のみ追加
            app.$set(addItem,'isSelect',false);
            this.mChoiceItemList.push({ ...addItem });
          }
          var regCheck = false;
          var regCheckNo = null;
          [...this.mRegisterItemList].forEach((v, i) => {
            if(
              v.itemCategoryLargeCd == addItem.itemCategoryLargeCd &&
              v.itemCategoryMediumCd == addItem.itemCategoryMediumCd &&
              v.itemCd == addItem.itemCd
            ) {
              regCheck = true;
            } else {
              regCheckNo = i;
            }
          });
          if (!regCheck) {
            addItem['mode'] = 'add';
            this.mRegisterItemList.push({ ...addItem });
          } else {
            // 存在するかつ削除モードの場合は登録リストに復帰
            if(this.mRegisterItemList[regCheckNo]['mode'] == 'del') {
              this.mRegisterItemList[regCheckNo]['mode'] = 'add';
            }
          }
        }
      });
    },
    selectItem: function (item) {
      var app = this;
      var oldIsSelect = item.isSelect;
      if(oldIsSelect) {
        this.$set(item,"isSelect",false);
      } else {
        this.$set(item,"isSelect",true);
      }
      this.$forceUpdate();
    },
    // デポ取扱商品リストからの除外
    delItem: function(e) {
      this.checkItemList.forEach(delItem => {
        // 選択されたものを登録対象から削除
        var idx = this.mChoiceItemList.map(function(item){
          return item.itemCd
        }).indexOf(delItem.itemCd);
        this.mChoiceItemList.splice(idx,1);

        // 登録リストに追加
        var regIdx = this.mRegisterItemList.map(function(item){
          return item.itemCd
        }).indexOf(delItem.itemCd);
        if(regIdx == -1) {
          delItem['mode'] = 'del';
          this.mRegisterItemList.push({ ...delItem });
        } else {
          // 存在するかつ追加モードの場合は登録リストから論理削除モードへ
          if(this.mRegisterItemList[regIdx]['mode'] == 'add') {
            this.mRegisterItemList[regIdx]['mode'] = 'del';
          }
        }
      });
    },
    /** 地域選択Key作成 */
    getAreaKey: function(pref,siku,tyou) {
      var prefKey = pref ? pref : '';
      var sikuKey = siku ? siku : '';
      var tyouKey = tyou ? tyou : '';
      return prefKey + sikuKey + tyouKey;
    },
    /** 市区郡選択子画面表示 */
    arealistOpen:function(isAddress){
      var params = new Array();
      params['isAddress'] = [isAddress];
      childWinOpen(this.$root.URL_CONST.C_L55, params, this.transAreaRegist);
    },
    /** 市区郡選択内容反映 */
    transAreaRegist:function(displayType,areaList){
      var app = this;
      // 追加
      areaList.forEach(addArea => {
        // 既に親画面のリストに追加されているか判定
        var isAdded = false;
        var regIdx = undefined;
        for(var i = 0; i < this.mChoiceAreaList.length; i++) {
          var item = this.mChoiceAreaList[i];
          if(addArea.pref == item.pref && addArea.siku == item.siku && addArea.tyou == item.tyou) {
            isAdded = true;
            break;
          }
        }
        if(isAdded == false) {
          // 存在しない場合のみ追加
          app.$set(addArea,'isSelect',false);
          this.mChoiceAreaList.push({ ...addArea });
        }

        // サーバに渡す登録リストに追加
        for(var i = 0; i < this.mRegisterAreaList.length; i++) {
          var item = this.mRegisterAreaList[i];
          if(addArea.pref == item.pref && addArea.siku == item.siku && addArea.tyou == item.tyou) {
            regIdx = i;
            break;
          }
        }
        if(regIdx === undefined) {
          // 存在しない場合は追加
          addArea['mode'] = 'add';
          this.mRegisterAreaList.push({ ...addArea });
        } else {
          // 存在するかつ削除モードの場合は登録リストに復帰
          if(this.mRegisterAreaList[regIdx]['mode'] == 'del') {
            this.mRegisterAreaList[regIdx]['mode'] = 'add';
          }
        }
      });
    },
    // デポ取扱商品リストからの除外
    delArea: function(e) {
      this.checkAreaList.forEach(delArea => {
        // 既に親画面のリストに追加されているか判定
        var delIdx = undefined;
        var regIdx = undefined;
        for(var i = 0; i < this.mChoiceAreaList.length; i++) {
          var item = this.mChoiceAreaList[i];
          if(delArea.pref == item.pref && delArea.siku == item.siku && delArea.tyou == item.tyou) {
            // 存在する場合は削除
            this.mChoiceAreaList.splice(i,1);
            break;
          }
        }
        // サーバに渡す登録リストに追加
        for(var i = 0; i < this.mRegisterAreaList.length; i++) {
          var item = this.mRegisterAreaList[i];
          if(delArea.pref == item.pref && delArea.siku == item.siku && delArea.tyou == item.tyou) {
            regIdx = i;
            break;
          }
        }
        if(regIdx === undefined) {
          // 存在しない場合は追加
          delArea['mode'] = 'del';
          this.mRegisterAreaList.push({ ...delArea });
        } else {
          // 存在するかつ追加モードの場合は登録リストから論理削除モードへ
          if(this.mRegisterAreaList[regIdx]['mode'] == 'add') {
            this.mRegisterAreaList[regIdx]['mode'] = 'del';
          }
        }
      });
    },
    /** 地域／市区郡削除対象選択 */
    selectArea: function (area) {
      var app = this;
      var oldIsSelect = area.isSelect;
      if(oldIsSelect) {
        this.$set(area,"isSelect",false);
      } else {
        this.$set(area,"isSelect",true);
      }
      this.$forceUpdate();
    },
    /** 日付選択子画面表示 */
    dateSelectOpen:function(isDeliveryDate){
      var func = undefined;
      if(isDeliveryDate) {
        // お届け日
        func = this.transDeliveryDateRegist;
      } else {
        // 受注日
        func = this.transOrderDateRegist;
      }
      childWinOpen(this.$root.URL_CONST.C_L54, undefined, func);
    },
    /** 日付削除 */
    dateSelectDelete: function(isDelivery) {
      if(isDelivery) {
        this.mIrregular.deliveryDateType = null;
        this.mDeliveryYear = '';
        this.mDeliveryMonth = '';
        this.mDeliveryDate = '';
        this.mIrregularDeliveryDayofweekList = [];
        this.mDeliveryStartYear = '';
        this.mDeliveryStartMonth = '';
        this.mDeliveryStartDate = '';
        this.mDeliveryEndYear = '';
        this.mDeliveryEndMonth = '';
        this.mDeliveryEndDate = '';
      } else {
        this.mIrregular.orderDateType = null;
        this.mOrderYear = '';
        this.mOrderMonth = '';
        this.mOrderDate = '';
        this.mIrregularOrderDayofweekList = [];
        this.mOrderStartYear = '';
        this.mOrderStartMonth = '';
        this.mOrderStartDate = '';
        this.mOrderEndYear = '';
        this.mOrderEndMonth = '';
        this.mOrderEndDate = '';
      }
    },
    /** お届け日選択内容反映 */
    transDeliveryDateRegist:function(selectType,selectYear,selectMonth,selectDate,selectWeekList,selectHolidayList,selectStartYear,selectStartMonth,selectStartDate,selectEndYear,selectEndMonth,selectEndDate){
      this.mIrregular.deliveryDateType = selectType;
      // 日付
      this.mDeliveryYear = selectYear;
      this.mDeliveryMonth = selectMonth;
      this.mDeliveryDate = selectDate;
      // 曜日
      this.mIrregularDeliveryDayofweekList = this.generateDayofweekList(1,selectWeekList,selectHolidayList);
      // 期間
      this.mDeliveryStartYear = selectStartYear;
      this.mDeliveryStartMonth = selectStartMonth;
      this.mDeliveryStartDate = selectStartDate;
      this.mDeliveryEndYear = selectEndYear;
      this.mDeliveryEndMonth = selectEndMonth;
      this.mDeliveryEndDate = selectEndDate;

    },
    /** 受注日選択内容反映 */
    transOrderDateRegist:function(selectType,selectYear,selectMonth,selectDate,selectWeekList,selectHolidayList,selectStartYear,selectStartMonth,selectStartDate,selectEndYear,selectEndMonth,selectEndDate){
      this.mIrregular.orderDateType = selectType;
      // 日付
      this.mOrderYear = selectYear;
      this.mOrderMonth = selectMonth;
      this.mOrderDate = selectDate;
      // 曜日
      this.mIrregularOrderDayofweekList = this.generateDayofweekList(2,selectWeekList,selectHolidayList);
      // 期間
      this.mOrderStartYear = selectStartYear;
      this.mOrderStartMonth = selectStartMonth;
      this.mOrderStartDate = selectStartDate;
      this.mOrderEndYear = selectEndYear;
      this.mOrderEndMonth = selectEndMonth;
      this.mOrderEndDate = selectEndDate;
    }, 
    /** 登録ボタン */
    registerIrregular:function(){
      this.$root.$refs.appProgress.busy(true);
      Repository.reflectIrregular(
        this.mIrregular,
        this.mRegisterDepoList,
        this.mRegisterAreaList,
        this.mRegisterItemList,
        this.mIrregularDeliveryDayofweekList,
        this.mIrregularOrderDayofweekList
      ).then(response =>{
        if(response.data.isSuccess){
          alert('登録に成功しました。');
          var resIrregularId = response.data.data;
          location.assign(this.$root.URL_CONST.C_L31 + '?irregularId=' + resIrregularId);
        }else{
          alert(response.data.message);
          this.$root.$refs.appProgress.busy(false);
        }
      }).catch(error=>{
        var data = error.response.data;
        alert(data.message);
        this.$root.$refs.appProgress.busy(false);
      }).finally(() => {
      });
    },
    /** 複製ボタン */
    remake:function(){
      $('#remake-form').submit();
    },
    /** 削除ボタン */
    deleteIrregular:function(){
      this.$root.$refs.appProgress.busy(true);
      Repository.deleteIrregular(
        this.mIrregular.irregularId,
      ).then(response =>{
        if(response.data.isSuccess){
          alert('削除に成功しました。イレギュラー一覧画面に遷移します。');
          location.assign(this.$root.URL_CONST.C_L30);
        }else{
          alert(response.data.message);
          this.$root.$refs.appProgress.busy(false);
        }
      }).catch(error=>{
        var data = error.response.data;
        alert(data.message);
        this.$root.$refs.appProgress.busy(false);
      }).finally(()=>{
      });
    },
    /** 一覧画面 */
    listLink: function() {
      // イレギュラー一覧へ
      this.$root.$refs.appProgress.busy(true);
      location.href = this.$root.URL_CONST.C_L30;
    },
    /** メッセージ重複確認 */
    messagelistOpen:function(){
      var params = new Array();
      params['_token'] = this.$root.csrf;
      params['messageType'] = 2;
      // デポ
      var depoCdList = [];
      var depoCdNameList = [];
      if(this.mIrregular.isDepo) {
        depoCdList = this.mChoiceDepoList.map(x => x.depocd);
        depoCdNameList = this.mChoiceDepoList.map(x => '【' + x.depocd + '】' + x.deponame);
      }
      params['depoCdList[]'] = depoCdList;
      params['depoCdNameList[]'] = depoCdNameList;
      // 商品
      var itemList = [];
      if(this.mIrregular.isItem) {
        itemList = this.mChoiceItemList;
        
      }
      params['itemList'] = JSON.stringify(itemList);
      // 住所
      var addressList = [];
      if(this.mIrregular.isArea) {
        addressList = this.mChoiceAreaList;
      }
      params['addressList'] = JSON.stringify(addressList);
      // 日付・曜日
      params['deliveryDateType'] = this.mIrregular.deliveryDateType;
      params['deliveryDate'] = this.mIrregular.deliveryDate ? moment(this.mIrregular.deliveryDate,'YYYY-MM-DD').format('YYYYMMDD') : '';
      params['deliveryDateFrom'] = this.mIrregular.deliveryDateFrom ? moment(this.mIrregular.deliveryDateFrom,'YYYY-MM-DD').format('YYYYMMDD') : '';
      params['deliveryDateTo'] = this.mIrregular.deliveryDateTo ? moment(this.mIrregular.deliveryDateTo,'YYYY-MM-DD').format('YYYYMMDD') : '';
      var weekList = [];
      var holidayList = [];
      if(this.mIrregularDeliveryDayofweekList.length != 0) {
        this.mIrregularDeliveryDayofweekList.forEach(function(item){
          if(!weekList.includes(item.dayofweek) && item.dayofweek != null) {
            weekList.push(item.dayofweek);
          }
          if(!holidayList.includes(item.publicHolidayStatus) && item.publicHolidayStatus != null) {
            holidayList.push(item.publicHolidayStatus);
          }
        });
      }
      params['dayOfWeekList[]'] = weekList;
      params['publicHolidayStatusList[]'] = holidayList;
      var option = 'width=1200,height=700,toolbar=0,menubar=0,scrollbars=0,resizable=0';
      childWinOpenPost(this.$root.URL_CONST.C_L56 + '/search', params, undefined, option);
    },
    /** 曜日情報リストの作成処理 */
    generateDayofweekList: function(dateType,weekList,holidayList) {
      if(!weekList && holidayList) {
        // どちらも空の場合は空のリストを返却する
        return [];
      }
      var tmpList = [];
      var dayofweekList = [];
      var objBase = {
        'dateType':dateType,
        'dayofweek': null,
        'publicHolidayStatus': null,
      }
      for(var i = 0; i < weekList.length; i++) {
        var obj = { ...objBase };
        obj.dayofweek = weekList[i];
        tmpList.push({ ...obj });
      }

      if(holidayList.length != 0) {
        for(var i = 0; i < holidayList.length; i++) {
          if(weekList.length == 0) {
            var obj = { ...objBase };
            obj.publicHolidayStatus = holidayList[i];
            dayofweekList.push({ ...obj });

          } else {
            for(var j = 0; j < tmpList.length; j++) {
              var dayofweek = { ...tmpList[j] };
              dayofweek.publicHolidayStatus = holidayList[i];
              dayofweekList.push(dayofweek);
            }
          }
        }
      } else {
        dayofweekList = tmpList;
      }

      return dayofweekList;
    }
  },
  computed:{
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
    /** 地域選択か市区郡選択かを判定する */
    isArea: function(){
      if(this.mIrregular.irregularType == 1 || this.mIrregular.irregularType == 2) {
        return true;
      } else {
        return false;
      }
    },
    /** お届け日　日付表示 */
    dispDeliveryDate: function(){
      var result = '-';
      var modelData = '';
      if(this.mDeliveryYear && this.mDeliveryMonth && this.mDeliveryDate) {
        result = this.mDeliveryYear + '/' + this.mDeliveryMonth + '/' + this.mDeliveryDate;
        modelData = moment([this.mDeliveryYear,this.mDeliveryMonth - 1,this.mDeliveryDate]).format('YYYY-MM-DD');
      }
      // Modelへの設定
      this.mIrregular.deliveryDate = modelData;

      return result;
    },
    /** お届け日　曜日表示 */
    dispDeliveryWeek: function(){
      var result = '';
      var weekList = [];
      var holidayList = [];
      var app = this;
      if(this.mIrregularDeliveryDayofweekList.length != 0) {
        this.mIrregularDeliveryDayofweekList.forEach(function(item){
          if(!weekList.includes(item.dayofweek)) {
            weekList.push(item.dayofweek);
          }
          if(!holidayList.includes(item.publicHolidayStatus)) {
            holidayList.push(item.publicHolidayStatus);
          }
        });
        weekList.forEach(function(week){
          if(result) {
            result += ',' + app.judgeWeek(week);
          } else {
            result += app.judgeWeek(week);
          }
        });
        holidayList.forEach(function(holiday){
          if(result) {
            result += ',' + app.judgeHoliday(holiday);
          } else {
            result += app.judgeHoliday(holiday);
          }
        });
      }
      result = result ? result : '-';
      return result;
    },
    /** お届け日　期間表示 */
    dispDeliveryPeriod: function(){
      var result = '';
      var from = '';
      var to = '';
      var startModelData = '';
      var endModelData = '';
      if(this.mDeliveryStartYear && this.mDeliveryStartMonth && this.mDeliveryStartDate) {
        var dispStartYear = this.mDeliveryStartYear == this.$root.CONFIG.BASE_FROM_YESR ? '----' : this.mDeliveryStartYear;
        from = dispStartYear + '/' + this.mDeliveryStartMonth + '/' + this.mDeliveryStartDate;
        startModelData = moment([this.mDeliveryStartYear,this.mDeliveryStartMonth - 1,this.mDeliveryStartDate]).format('YYYY-MM-DD');
      }
      if(this.mDeliveryEndYear && this.mDeliveryEndMonth && this.mDeliveryEndDate) {
        var dispEndYear = this.mDeliveryEndYear == this.$root.CONFIG.BASE_TO_YESR ? '----' : this.mDeliveryEndYear;
        to = dispEndYear + '/' + this.mDeliveryEndMonth + '/' + this.mDeliveryEndDate;
        endModelData = moment([this.mDeliveryEndYear,this.mDeliveryEndMonth - 1,this.mDeliveryEndDate]).format('YYYY-MM-DD');
      }
      // Modelへの設定
      this.mIrregular.deliveryDateFrom = startModelData;
      this.mIrregular.deliveryDateTo = endModelData;

      if(from && to) {
        result = from + ' 〜 ' + to;
      }
      result = result ? result : '-';
      return result;
    },
    /** 受注日　日付表示 */
    dispOrderDate: function(){
      var result = '-';
      var modelData = '';
      if(this.mOrderYear && this.mOrderMonth && this.mOrderDate) {
        result = this.mOrderYear + '/' + this.mOrderMonth + '/' + this.mOrderDate;
        modelData = moment([this.mOrderYear,this.mOrderMonth - 1,this.mOrderDate]).format('YYYY-MM-DD');
      }
      // Modelへの設定
      this.mIrregular.orderDate = modelData;
      return result;
    },
    /** 受注日　曜日表示 */
    dispOrderWeek: function(){
      var result = '';
      var weekList = [];
      var holidayList = [];
      var app = this;
      if(this.mIrregularOrderDayofweekList.length != 0) {
        this.mIrregularOrderDayofweekList.forEach(function(item){
          if(!weekList.includes(item.dayofweek)) {
            weekList.push(item.dayofweek);
          }
          if(!holidayList.includes(item.publicHolidayStatus)) {
            holidayList.push(item.publicHolidayStatus);
          }
        });
        weekList.forEach(function(week){
          if(result) {
            result += ',' + app.judgeWeek(week);
          } else {
            result += app.judgeWeek(week);
          }
        });
        holidayList.forEach(function(holiday){
          if(result) {
            result += ',' + app.judgeHoliday(holiday);
          } else {
            result += app.judgeHoliday(holiday);
          }
        });
      }
      result = result ? result : '-';
      return result;
    },
    /** 受注日　期間表示 */
    dispOrderPeriod: function(){
      var result = '-';
      var from = '';
      var to = '';
      var startModelData = '';
      var endModelData = '';
      if(this.mOrderStartYear && this.mOrderStartMonth && this.mOrderStartDate) {
        // 通年設定
        var dispStartYear = this.mOrderStartYear == this.$root.CONFIG.BASE_FROM_YESR ? '----' : this.mOrderStartYear;
        from = dispStartYear + '/' + this.mOrderStartMonth + '/' + this.mOrderStartDate;
        startModelData = moment([this.mOrderStartYear,this.mOrderStartMonth - 1,this.mOrderStartDate]).format('YYYY-MM-DD');
      }
      if(this.mOrderEndYear && this.mOrderEndMonth && this.mOrderEndDate) {
        // 通年設定
        var dispEndYear = this.mOrderEndYear == this.$root.CONFIG.BASE_TO_YESR ? '----' : this.mOrderEndYear;
        to = dispEndYear + '/' + this.mOrderEndMonth + '/' + this.mOrderEndDate;
        endModelData = moment([this.mOrderEndYear,this.mOrderEndMonth - 1,this.mOrderEndDate]).format('YYYY-MM-DD');
      }

      // Modelへの設定
      this.mIrregular.orderDateFrom = startModelData;
      this.mIrregular.orderDateTo = endModelData;

      if(from && to) {
        result = from + ' 〜 ' + to;
      }
      result = result ? result : '-';
      return result;
    },
    /** 赤文字注釈期間表示 */
    calcDispDatePeriod: function(){
      var fromYear = this.annoStartYear == String(this.$root.CONFIG.BASE_FROM_YESR) ? null : this.annoStartYear;
      var fromMonth = this.annoStartMonth;
      var fromDay = this.annoStartDate;
      var toYear = this.annoEndYear;
      var toMonth = this.annoEndMonth;
      var toDay = this.annoEndDate;

      var fromDate = '';
      var toDate = '';
      var result = true;
      
      // From < to 判定
      // 通年設定
      if(fromMonth && fromDay && toMonth && toDay) {
        if(!fromYear) {
          fromYear = this.$root.CONFIG.BASE_FROM_YESR;
        }
        if(!toYear) {
          toYear = this.$root.CONFIG.BASE_TO_YESR;
        }
        var fromMomentDate = moment([fromYear,fromMonth - 1,fromDay]);
        var toMomentDate = moment([toYear,toMonth - 1,toDay]);

        if(toMomentDate.isSameOrAfter(fromMomentDate)) {
          result = true;
          // 日付設定
          fromDate = fromMomentDate.format('YYYY-MM-DD');
          toDay = toMomentDate.format('YYYY-MM-DD');
        } else {
          result = false;
          alert('表示期間の終了日が開始日より前です。')
        }
      } else {
        if(fromYear || fromMonth || fromDay || toYear ||  toMonth || toDay) {
          // 何かしたら入力されていたらfalse
          result = false
        }
      }

      // Modelへの設定
      this.mIrregular.annoFrom = fromDate;
      this.mIrregular.annoTo = toDay;
      this.mAnnoDateValidate = result;
      return result;
    },
    /** メッセージ重複確認制御 */
    msgIsActive: function() {
      var result = false;
      // デポ
      if(this.mChoiceDepoList.length != 0) {
        result = true;
      }
      // 商品
      if(this.mChoiceItemList.length != 0) {
        result = true;
      }
      // 地域
      if(this.mChoiceAreaList.length != 0) {
        result = true;
      }
      // お届け日
      if(this.mIrregular.deliveryDateType) {
        if(this.mDeliveryDate || this.mIrregularDeliveryDayofweekList.length != 0 || 
        (this.mDeliveryStartYear && this.mDeliveryStartMonth && this.mDeliveryStartDate &&
         this.mDeliveryEndYear && this.mDeliveryEndMonth && this.mDeliveryEndDate)) {
          result = true;
        }
      }

      return result;
    },
    checkDepoList: function() {
      var resultList = [];
      resultList = this.mChoiceDepoList.filter(function(depo){
        return depo.isSelect;
      });
      if(resultList.length == 0) {
        this.allDepoSelected = false;
      }
      return resultList;
    },
    checkItemList: function() {
      var resultList = [];
      resultList = this.mChoiceItemList.filter(function(item){
        return item.isSelect;
      });
      if(resultList.length == 0) {
        this.allItemSelected = false;
      }
      return resultList;
    },
    checkAreaList: function() {
      var resultList = [];
      resultList = this.mChoiceAreaList.filter(function(address){
        return address.isSelect;
      });
      if(resultList.length == 0) {
        this.allAreaSelected = false;
      }
      return resultList;
    },
  },
  watch: {
    /** デポチェックボックス監視 */
    allDepoSelected: function(val){
      var app = this;
      this.mChoiceDepoList.forEach(function(depo){
        app.$set(depo,'isSelect',val);
      });
    },
    /** 商品チェックボックス監視 */
    allItemSelected: function(val){
      var app = this;
      this.mChoiceItemList.forEach(function(item){
        app.$set(item,'isSelect',val);
      });
    },
    /** 地域チェックボックス監視 */
    allAreaSelected: function(val){
      var app = this;
      this.mChoiceAreaList.forEach(function(address){
        app.$set(address,'isSelect',val);
      });
    },
    /** イレギュラーObject監視 */
    mIrregular: {
      handler: function (val, oldVal) {
        var flg = true;
        // タイトル
        if(!this.mIrregular.title) {
          flg = false;
        }
        // エラーメッセージ
        if(!this.mIrregular.errorMessage) {
          flg = false;
        }
        // 赤字注釈
        if(!this.mAnnoDateValidate) {
          flg = false;
        }
        // 配送先振替の場合
        if(this.mIrregular.irregularType == 3) {
          if(!this.mIrregular.transDepoCd) {
            flg = false;
          }
        }
        // ボタン活性／非活性判定
        this.mRegisterIsActive = flg;
      },
      deep: true
    }
  },
  created() {
    this.$watch(
      // 2つのプロパティを含めた値を評価させる
      () => [
        this.$data.annoStartYear,
        this.$data.annoStartMonth,
        this.$data.annoStartDate,
        this.$data.annoEndYear,
        this.$data.annoEndMonth,
        this.$data.annoEndDate,
      ],
      // valueやoldValueの型は上で返した配列になる
      (value, oldValue) => {
        this.calcDispDatePeriod;
      }
    );
  }
}
</script>