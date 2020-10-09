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
        <h4>デポ取扱住所リスト</h4>
      </div>
      <div class="col-md-5 offset-md-2 text-center">
        <h4>住所リスト</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5">
        <div class="row">
          <div class="col-md-5 p-0">
            <label class="control-label">都道府県</label>
            &nbsp;
            <select class="form-control" v-model="mSelectPref">
              <option value="">全県</option>
              <option v-for="item in prefList" :key="item.pref" :value="item.pref">
                  {{ item.prefName }}
              </option>
            </select>
          </div>
          <div class="col-md-7 p-0">
            <label class="control-label">市区郡</label>
            &nbsp;
            <input class="form-control" type="text" v-model="mFilterChiku">
          </div>
        </div>
      </div>
      <div class="col-md-5 offset-md-2">
        <div class="row">
          <div class="col-md-5 p-0">
            <label class="control-label">都道府県</label>
            &nbsp;
            <select class="form-control" v-model="mSelectChoicePref" @change="choicePrefChange($event)">
              <option value="">未選択</option>
              <option v-for="item in prefList" :key="item.pref" :value="item.pref">
                  {{ item.prefName }}
              </option>
            </select>
          </div>
          <div class="col-md-7 p-0">
            <label class="control-label">市区郡</label>
            &nbsp;
            <input class="form-control" type="text" v-model="mChoiceFilterChiku">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5 text-right">
        <label class="control-label">検索結果</label>
        <label class="control-label mr-3 ml-3">{{ searchAddressCountComputed }}</label>
        <label class="control-label">件</label>
      </div>
      <div class="col-md-5 offset-md-2 text-right">
        <label class="control-label">検索結果</label>
        <label class="control-label mr-3 ml-3">{{ searchChoiceAddressCountComputed }}</label>
        <label class="control-label">件</label>
      </div>
    </div>
    <div class="row default-multiple-row">
      <div class="col-md-5">
        <select multiple class="form-control default-multiple-select" v-model="mSelectDelAddressList">
          <option v-for="address in addressComputed" :key="address.addrcd" :value="address">
            {{ address.zipcode + ' ' + address.prefName + address.siku + address.tyou }}
          </option>
        </select>
      </div>
      <div class="col-md-2 d-flex flex-column">
        <button type="button" @click="addAddress" class="btn btn-primary default-top-button">追加</button>
        <button type="button" @click="delAddress" class="btn btn-primary default-bottom-button">削除</button>
      </div>
      <div class="col-md-5">
        <select multiple class="form-control default-multiple-select" v-model="mSelectAddAddressList">
          <option v-for="address in searchChoiceAddressComputed" :key="address.addrcd" :value="address">
            {{ address.zipcode + ' ' + address.prefName + address.siku + address.tyou }}
          </option>
        </select>
      </div>
    </div>
    <div class="row pt-5 pb-3">
      <div class="col-md-4" />
      <div class="col-md-5 btn-right">
        <form class="form-inline">
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
        <button type="button" @click="upload(uploadDepoAddressUrl,mUploadfile,uploadAfter)" v-bind:disabled="!mUploadfile" class="btn btn-primary">CSV取込</button>
        <button type="button" @click="register" class="btn btn-primary">登録</button>
      </div>
    </div>
  </div>
</template>
<script>
  import Repository from '../../api/Repository';
  import SearchRender from "../mixins/SearchRender"
  import FileController from '../mixins/FileController'
  export default {
    mixins: [SearchRender,FileController],
    props: {
      searchParam: Object,
      prefList: Object,
      errorList: {
        type: Array,
        required: false,
        default: () => []
      }
    },
    data: function () {
      return {
        mIsFirst: true,
        mSelectPref: "",
        mSelectChoicePref: "",
        mAddressList: [],
        mAddressListCount: 0,
        mRegosterItemList: [],
        mChoiceAddressList: [],
        mChoiceAddressListCount: 0,
        mSelectDelAddressList: [],
        mSelectAddAddressList: [],
        mFilterChiku: "",
        mChoiceFilterChiku: "",
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
      /** デポ取扱住所リスト検索 */
      search: async function() {
        this.$root.$refs.appProgress.busy(true);
        this.mRegosterItemList = [];
        await Repository.searchDepoAddressList(
          this.searchParam.searchDepocd,
          null
        ).then(response => {
          var result = response.data;
          if(result.isSuccess) {
            this.mAddressListCount = result.data.length;
            // 100アイテムづつsetTimeoutでレンダリング
            this.betterRender('mAddressList',result.data);
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
      /** 住所リスト プルダウン変更 */
      choicePrefChange: function(event) {
        this.$root.$refs.appProgress.busy(true);
        Repository.searchPrefAddressList(
          this.mSelectChoicePref
        ).then(response => {
          var result = response.data;
          if(result.isSuccess) {
            this.mChoiceAddressListCount = result.data.length;
            // 100アイテムづつsetTimeoutでレンダリング
            this.betterRender('mChoiceAddressList',result.data);
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
      /** デポ取扱住所リストからの削除 */
      delAddress: function(e) {
        var addressList = this.addressList;
        this.mSelectDelAddressList.forEach(delAddress => {
          // 選択されたものを登録対象から削除
          var idx = this.mAddressList.map(function(address){
              return address.addrcd;
          }).indexOf(delAddress.addrcd);
          this.mAddressList.splice(idx,1);

          // 登録リストに追加
          var regIdx = this.mRegosterItemList.map(function(address){
              return address.addrcd
          }).indexOf(delAddress.addrcd);
          if(regIdx == -1) {
            delAddress['mode'] = 'del';
            this.mRegosterItemList.push(delAddress);
          } else {
            if(this.mRegosterItemList[regIdx]['mode'] == 'add') {
              this.mRegosterItemList.splice(regIdx,1);
            }
          }
        });
        this.mSelectDelAddressList = [];
      },
      /** デポ取扱住所リストからへの追加 */
      addAddress: function(e) {
        this.mSelectAddAddressList.forEach(addAddress => {
          // 既に追加されているか判定
          var idx = this.mAddressList.map(function(address){
              return address.addrcd;
          }).indexOf(addAddress.addrcd);
          if(idx == -1) {
            // 存在しない場合のみ追加
            this.mAddressList.push(addAddress);
          }

          // 登録リストに追加
          var regIdx = this.mRegosterItemList.map(function(address){
              return address.addrcd;
          }).indexOf(addAddress.addrcd);
          if(regIdx == -1) {
            addAddress['mode'] = 'add';
            this.mRegosterItemList.push(addAddress);
          } else {
            if(this.mRegosterItemList[regIdx]['mode'] == 'del') {
              this.mRegosterItemList.splice(regIdx,1);
            }
          }
        });
        // 選択状態を解除
        this.mSelectAddAddressList = [];

      },
      /** ダウンロード前準備 */
      downloadSetup: function(e) {
        if(this.mAddressListCount == 0) {
          alert('検索結果が0件のため、ダウンロードできません。');
          return false;
        }
        var fileName = "DepoAddress";
        var request = {
          'depoCd': this.searchParam.searchDepocd,
          'prefCd': null,
        };
        var url = Repository.downloadDepoAddressUrl();
        this.download(fileName,request,url);
      },
      /** upload後の処理 */
      uploadAfter: async function(response) {
        this.$emit('update:errorList', []);
        var result = response.data;
        if(result.isSuccess) {
          await this.search();
          alert(result.message);
        } else {
          alert('アップロードが失敗しました');
          this.$root.$refs.appProgress.busy(false);
          var errorList = result.message.split('<br>');
          this.$emit('update:errorList', errorList);
        }
      },
      /** 登録ボタン */
      register: function(e) {
        if(confirm('デポ取扱住所紐付け情報を登録します、よろしいですか？')) {
          this.$root.$refs.appProgress.busy(true);
          Repository.saveDepoAddress(
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
      /** デポ取扱住所リスト件数計算 */
      searchAddressCountComputed: function(){
        var count = 0;
        if(this.mSelectPref || this.mFilterChiku) {
          count = this.addressComputed.length;
        } else {
          count = this.mAddressListCount;
        }
        return count;
      },
      /** 住所リスト件数計算 */
      searchChoiceAddressCountComputed: function(){
        var count = 0;
        if(this.mChoiceFilterChiku) {
          count = this.searchChoiceAddressComputed.length;
        } else {
          count = this.mChoiceAddressListCount;
        }
        return count;
      },
      /** 住所リストの絞り込み */
      searchChoiceAddressComputed: function(){
        var list = [];
        // 追加済み削除
        var addressList = this.mAddressList;
        list = this.mChoiceAddressList.filter(function (address) {
          return addressList.map(model => 
            model.prefCd + model.siku + model.tyou
          ).indexOf(address.prefCd + address.siku + address.tyou) === -1;
        });

        // 市区郡での絞り込み
        var filterChiku = this.mChoiceFilterChiku;
        if(filterChiku) {
          list = list.filter(function (address) {
            // 商品CD
            if (address.siku.indexOf(filterChiku) > -1) {
              return address;
            }
            return false;
          });
        }

        return list;
      },
      /** デポ取扱住所リストの絞り込み */
      addressComputed: function(){
        var list = this.mAddressList;

        // 都道府県での絞り込み
        var filterPref = this.mSelectPref;
        if(filterPref) {
          list = list.filter(function (address) {
            if (address.prefCd.indexOf(filterPref) > -1) {
              return address;
            }
            return false;
          });
        }

        // 市区郡での絞り込み
        var filterChiku = this.mFilterChiku;
        if(filterChiku) {
          list = list.filter(function (address) {
            if (address.siku.indexOf(filterChiku) > -1) {
              return address;
            }
            return false;
          });
        }

        return list;
      }
    },
  }
  </script>