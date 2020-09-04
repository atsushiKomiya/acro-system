<template>
  <div class="tab-depo-item p-2" v-if="searchParam.searchDepocd">
    <div v-if="mIsFirst" :onLoad="init()"></div>
    <div class="row">
      <div class="col-md-2">
         <button type="button" @click="downloadSetup" class="btn btn-primary">CSV出力</button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5 text-center">
        <h4>デポ取扱商品リスト</h4>
      </div>
      <div class="col-md-5 offset-md-2 text-center">
        <h4>商品リスト</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5 d-flex flex-column">
        <div class="row">
          <div class="col-md-5">
            <label class="control-label">商品カテゴリ大 : </label>
          </div>
          <div class="col-md-7">
            <select class="form-control" v-model="mSelectLargeCategory">
              <option value="">すべて</option>
              <option v-for="large in largeCategoryComputed" :key="large.itemCategoryLargeCd" :value="large.itemCategoryLargeCd">
                  {{ large.itemCategoryLargeName }}
              </option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <label class="control-label">商品カテゴリ中 : </label>
          </div>
          <div class="col-md-7">
            <select class="form-control" v-model="mSelectMediumCategory">
              <option value="">すべて</option>
              <option v-for="large in mediumCategoryComputed" :key="large.itemCategoryMediumCd" :value="large.itemCategoryMediumCd">
                  {{ large.itemCategoryMediumName }}
              </option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <label class="control-label">商品 : </label>
          </div>
          <div class="col-md-7">
            <input class="form-control" type="text" v-model="mInputItemKeyword">
          </div>
        </div>
      </div>
      <div class="col-md-5 offset-md-2 d-flex flex-column">
        <div class="row">
          <div class="col-md-5">
          </div>
          <div class="col-md-7">
            <button type="button" @click="itemListOpen" class="btn btn-primary">商品選択</button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <label class="control-label">商品カテゴリ大 : </label>
          </div>
          <div class="col-md-7">
            <label class="control-label">{{ mChoiceLargeCategory }}</label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <label class="control-label">商品カテゴリ中 : </label>
          </div>
          <div class="col-md-7">
            <label class="control-label">{{ mChoiceMediumCategory }}</label>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5 text-right">
        <label class="control-label">検索結果</label>
        <label class="control-label mr-3 ml-3">{{ searchItemCountComputed }}</label>
        <label class="control-label">件</label>
      </div>
      <div class="col-md-5 offset-md-2 text-right">
        <label class="control-label">検索結果</label>
        <label class="control-label mr-3 ml-3">{{ searchChoiceItemCountComputed }}</label>
        <label class="control-label">件</label>
      </div>
    </div>
    <div class="row default-multiple-row">
      <div class="col-md-5">
        <select multiple class="form-control default-multiple-select" v-model="mSelectDelItemList">
          <option v-for="item in itemComputed" :key="item.itemCd" :value="item">
            {{ '【' + item.itemCd + '】' + item.itemName }}
          </option>
        </select>
      </div>
      <div class="col-md-2 d-flex flex-column">
        <button type="button" @click="addItem" class="btn btn-primary default-top-button">追加</button>
        <button type="button" @click="delItem" class="btn btn-primary default-bottom-button">削除</button>
      </div>
      <div class="col-md-5">
        <select multiple class="form-control default-multiple-select" v-model="mSelectAddItemList">
          <option v-for="item in searchChoiceItemComputed" :key="item.itemCd" :value="item">
            {{ '【' + item.itemCd + '】' + item.itemName }}
          </option>
        </select>
      </div>
    </div>
    <div class="row pt-5 pb-3">
      <div class="col-md-4" />
      <div class="col-md-5 btn-right">
        <form id="upload-form" class="form-inline">
          <label class="input-group-btn control-label mr-2">
              <span class="btn btn-primary" v-if="!mUploadfile">
                  ファイル選択<input type="file" id="file" name="uploadfile" @change="selectedFile" style="display:none">
                  <input type="hidden" name="_token" v-bind:value="csrf" />
              </span>
              <button class="btn btn-danger" v-if="mUploadfile" @click="resetFile">
                ファイル解除
              </button>
          </label>
          <label class="control-label">{{ mUploadfile ? mUploadfile.name : 'ファイルが選択されていません' }}</label>
        </form>
      </div>
      <div class="col-md-3 btn-right">
        <button type="button" @click="upload(uploadDepoItemUrl,mUploadfile,uploadAfter)" v-bind:disabled="!mUploadfile" class="btn btn-primary">CSV取込</button>
        <button type="button" @click="register" class="btn btn-primary">登録</button>
      </div>
    </div>

  </div>
</template>
<script>
  import Repository from '../../api/Repository';
  import CsvUploadRepository from '../../api/CsvUploadRepository';
  import SearchRender from "../mixins/SearchRender"
  import FileController from '../mixins/FileController'
  export default {
    mixins: [SearchRender,FileController],
    props: {
      searchParam: Object,
      errorList: {
        type: Array,
        required: false,
        default: () => []
      }
    },
    data: function () {
      return {
        mIsFirst: true,
        mItemList: [],
        mRegosterItemList: [],
        mChoiceItemList: [],
        mSelectDelItemList: [],
        mSelectAddItemList: [],
        mSelectLargeCategory: "",
        mSelectMediumCategory: "",
        mChoiceLargeCategoryCd: "",
        mChoiceLargeCategory: "",
        mChoiceMediumCategoryCd: "",
        mChoiceMediumCategory: "",
        mInputItemKeyword: "",
      }
    },
    methods: {
      /** 初期処理 */
      init: function() {
        if(this.mIsFirst) {
          this.search();
          this.mIsFirst = false;
        }
      },
      /** デポ商品住所リスト検索 */
      search: function() {
        this.$root.$refs.appProgress.busy(true);
        this.mRegosterItemList = [];
        Repository.searchDepoItemList(
          this.searchParam.searchDepocd,
          null
        ).then(response => {
          var data = response.data;
          if(data.isSuccess) {
            this.mItemList = data.data;
          } else {
            alert(response.data.message);
          }
        }).catch(error => {
          var data = error.response.data;
          alert(data.message)
        }).finally(() => {
          this.$root.$refs.appProgress.busy(false);
        });
      },
      /** 商品選択子画面表示 */
      itemListOpen: function() {
        var params = new Array();
        params['isList'] = [true];
        childWinOpen(this.$root.URL_CONST.C_L52,params ,this.transItemRegist);
      },
      /** 商品選択子画面反映 */
      transItemRegist: function(itemCategoryLargeCd,itemCategoryLargeName,itemCategoryMediumCd,itemCategoryMediumName,itemList) {
        this.mChoiceItemList = itemList;
        this.mChoiceLargeCategoryCd = itemCategoryLargeCd;
        this.mChoiceLargeCategory = itemCategoryLargeName;
        this.mChoiceMediumCategoryCd = itemCategoryMediumCd;
        this.mChoiceMediumCategory = itemCategoryMediumName;
      },
      /** デポ取扱商品リストからの除外 */
      delItem: function(e) {
        var initList = this.itemList;
        this.mSelectDelItemList.forEach(delItem => {
          // 選択されたものを登録対象から削除
          var idx = this.mItemList.map(function(item){
              return item.itemCd
          }).indexOf(delItem.itemCd);
          this.mItemList.splice(idx,1);

          // 登録リストに追加
          var regIdx = this.mRegosterItemList.map(function(item){
              return item.itemCd
          }).indexOf(delItem.itemCd);
          if(regIdx == -1) {
            delItem['mode'] = 'del';
            this.mRegosterItemList.push(delItem);
          } else {
            if(this.mRegosterItemList[regIdx]['mode'] == 'add') {
              this.mRegosterItemList.splice(regIdx,1);
            }
          }
        });
        this.mSelectDelItemList = [];
      },
      /** デポ取扱商品リストへの追加 */
      addItem: function(e) {
        // 追加
        this.mSelectAddItemList.forEach(addItem => {
          // 既に追加されているか判定
          var idx = this.mItemList.map(function(item){
              return item.itemCd
          }).indexOf(addItem.itemCd);
          if(idx == -1) {
            // 存在しない場合のみ追加
            this.mItemList.push(addItem);
          }

          // 登録リストに追加
          var regIdx = this.mRegosterItemList.map(function(item){
              return item.itemCd
          }).indexOf(addItem.itemCd);
          if(regIdx == -1) {
            addItem['mode'] = 'add';
            this.mRegosterItemList.push(addItem);
          } else {
            if(this.mRegosterItemList[regIdx]['mode'] == 'del') {
              this.mRegosterItemList.splice(regIdx,1);
            }
          }

        });
        // 選択状態を解除
        this.mSelectAddItemList = [];

      },
      /** ダウンロード前準備 */
      downloadSetup: function(e) {
        this.$emit('update:errorList', []);
        if(this.mTabLeadtimeListCount == 0) {
          alert('検索結果が0件のため、ダウンロードできません。');
          return false;
        }
        var fileName = "DepoItem";
        var request = {
          'depoCd': this.searchParam.searchDepocd
        };
        var url = Repository.downloadDepoItemUrl();
        this.download(fileName,request,url);
      },
      /** upload後の処理 */
      uploadAfter: function(response) {
        this.$emit('update:errorList', []);
        var result = response.data;
        if(result.isSuccess) {
          alert(result.message);
        } else {
          alert('アップロードが失敗しました');
          var errorList = result.message.split('<br>');
          this.$emit('update:errorList', errorList);
        }
      },
      /** 登録 */
      register: function(e) {
        if(confirm('デポ取扱商品紐付け情報を登録します、よろしいですか？')) {
          this.$emit('update:errorList', []);
          this.$root.$refs.appProgress.busy(true);
          Repository.saveDepoItem(
            this.searchParam.searchDepocd,
            this.mRegosterItemList
          ).then(response => {
            if(response.data.isSuccess) {
              alert('登録に成功しました。');
              this.search();
            } else {
              alert(response.data.message);
            }
          }).catch(error => {
            var data = error.response.data;
            alert(data.message)
          }).finally(() => {
            this.$root.$refs.appProgress.busy(false);
          });
        }
      },
    },
    computed: {
      /** デポ取扱商品リスト件数算出 */
      searchItemCountComputed: function(){
        return this.mItemList.length;
      },
      /** 商品追加リスト件数算出 */
      searchChoiceItemCountComputed: function(){
        return this.searchChoiceItemComputed.length;
      },
      /** 商品追加リスト絞り込み */
      searchChoiceItemComputed: function(){
        var result = [];
        // 追加済み削除
        var itemList = this.mItemList;
        result = this.mChoiceItemList.filter(function (item) {
          return itemList.map(model => model.itemCd).indexOf(item.itemCd) === -1;
        });

        return result;
      },
      /** カテゴリ大プルダウン　絞り込み */
      largeCategoryComputed: function(){
        var list = this.mItemList;
        // カテゴリ大で集約
        var filterList = list.filter(function (x, i, self) {
          return self.map(function(item){ return item.itemCategoryLargeCd; }).indexOf(x.itemCategoryLargeCd) === i;
        });
        // ソート
        filterList = filterList.sort(function(a,b){
          return a.itemCategoryLargeCd - b.itemCategoryLargeCd;
        });
        return filterList;
      },
      /** カテゴリ中プルダウン　絞り込み */
      mediumCategoryComputed: function(){
        var list = this.mItemList;
        var selectLargeCategory = this.mSelectLargeCategory;
        // カテゴリ中で集約
        var filterList = list.filter(function (x, i, self) {
          var result = self.map(function(item){
            return item.itemCategoryMediumCd;
          }).indexOf(x.itemCategoryMediumCd) === i;
          return result;
        });
        // カテゴリ大でさらに絞り込み
        var filterLarge = this.mSelectLargeCategory;
        if(filterLarge) {
          filterList = filterList.filter(function (item) {
            return item.itemCategoryLargeCd === filterLarge;
          });
        }
        // ソート
        filterList = filterList.sort(function(a,b){
          return a.itemCategoryMediumCd - b.itemCategoryMediumCd;
        });
        return filterList;
      },
      /** デポ取扱商品リスト　絞り込み */
      itemComputed: function(){
        var list = this.mItemList;
        
        // カテゴリ大の絞り込み
        var filterLarge = this.mSelectLargeCategory;
        if(filterLarge) {
          list = list.filter(function (item) {
            if (item.itemCategoryLargeCd !== filterLarge) {
              return false;
            }
            return item;
          });
        }

        // カテゴリ中の絞り込み
        var filterMedium = this.mSelectMediumCategory;
        if(filterMedium) {
          list = list.filter(function (item) {
            if (item.itemCategoryMediumCd !== filterMedium) {
              return false;
            }
            return item;
          });
        }
        
        // 商品CD or 商品名での絞り込み
        var filterItem = this.mInputItemKeyword
        if(filterItem) {
          list = list.filter(function (item) {
            // 商品CD
            if (item.itemCd.indexOf(filterItem) > -1) {
              return item;
            } else if(item.itemName.indexOf(filterItem) > -1){
              return item;
            }
            return false;
          });
        }        

        return list;
      },
    },
  }
</script>