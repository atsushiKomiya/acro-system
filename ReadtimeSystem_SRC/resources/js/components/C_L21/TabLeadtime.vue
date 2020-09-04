<template>
  <div class="tab-leadtime p-2" v-if="searchParam.searchDepocd">
    <div v-if="mIsFirst" :onLoad="init()"></div>
    <div class="row">
      <div class="col-md-12 btn-right">
        <button type="button" class="btn btn-primary" @click="downloadSetup">CSV出力</button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 p-0 form-inline">
        <label class="control-label">都道府県</label>
        &nbsp;
        <select class="form-control" v-model="mSelectPref">
          <option value="">全件</option>
          <option v-for="item in mPrefList" :key="item.prefCd" :value="item.prefCd">
              {{ item.prefName }}
          </option>
        </select>
      </div>
      <div class="col-md-3 p-0 form-inline">
        <label class="control-label">市区郡</label>
        &nbsp;
        <input class="form-control" type="text" v-model="mInputSiku" />
      </div>
      <div class="col-md-6 text-right">
        <label class="control-label">検索結果</label>
        <label class="control-label mr-3 ml-3">{{ searchCountComputed }}</label>
        <label class="control-label">件</label>
      </div>
    </div>
    <div class="row">
      <div class="sticky-table" style="height: 300px">
        <table class="table-striped table-responsive-stack">
          <thead>
            <tr>
              <th class="th-aria">住所コード</th>
              <th class="th-aria">郵便番号</th>
              <th class="th-aria">都道府県コード</th>
              <th class="th-aria">市区郡</th>
              <th class="th-aria">町名</th>
              <th>翌日時間指定</th>
              <th>エリア<br/>当日配送可否</th>
              <th>翌日配送<br/>締切時間</th>
              <th>当日配送<br/>締切時間１</th>
              <th>当日配送<br/>締切時間２</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="model in filterLeadtimeList" :key="model.depoAddressLeadtimeId">
              <td>{{ model.jiscode }}</td>
              <td>{{ model.zipCd }}</td>
              <td>{{ model.prefCd }}</td>
              <td>{{ model.siku }}</td>
              <td>{{ model.tyou }}</td>
              <td style="padding:0">
                <select
                  class="form-control"
                  v-model="model.nextDayTimeType"
                  @change="rowDataChange(model)"
                >
                  <option v-for="(value, key) in timeSelectList" :key="key" :value="key">{{ value }}</option>
                </select>
              </td>
              <td class="toggle-div">
                <apptoggle
                  v-bind:is-class="true"
                  v-bind:is-active.sync="model.isAreaTodayDeliveryFlg"
                  @click="rowDataChange(model)"
                />
              </td>
              <td style="padding:0">
                <select
                  class="form-control"
                  v-model="model.nextDayTimeDeadline"
                  @change="rowDataChange(model)"
                >
                  <option
                    v-for="(value, key) in deadlineTimeList"
                    :key="key"
                    :value="key"
                  >{{ value }}</option>
                </select>
              </td>
              <td style="padding:0">
                <select
                  class="form-control"
                  v-model="model.todayTimeDeadline1"
                  @change="rowDataChange(model)"
                >
                  <option
                    v-for="(value, key) in deadlineTimeList"
                    :key="key"
                    :value="key"
                  >{{ value }}</option>
                </select>
              </td>
              <td style="padding:0">
                <select
                  class="form-control"
                  v-model="model.todayTimeDeadline2"
                  @change="rowDataChange(model)"
                >
                  <option
                    v-for="(value, key) in deadlineTimeList"
                    :key="key"
                    :value="key"
                  >{{ value }}</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row pt-5 pb-3">
      <div class="col-md-4" />
      <div class="col-md-5 btn-right">
        <form class="form-inline">
          <label class="input-group-btn control-label mr-2">
            <span class="btn btn-primary" v-if="!mUploadfile">
              ファイル選択
              <input
                type="file"
                id="file"
                name="uploadfile"
                @change="selectedFile"
                style="display:none"
              />
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
        <button type="button" @click="upload(uploadLeadtimeUrl,mUploadfile,uploadAfter)" v-bind:disabled="!mUploadfile" class="btn btn-primary">CSV取込</button>
        <button type="button" @click="register" class="btn btn-primary">登録</button>
      </div>
    </div>
  </div>
</template>
<script>
import Repository from "../../api/Repository";
import SearchRender from "../mixins/SearchRender"
import FileController from '../mixins/FileController'
export default {
  mixins: [SearchRender,FileController],
  props: {
    searchParam: Object,
    timeSelectList: Object,
    deadlineTimeList: Object,
    errorList: {
      type: Array,
      required: false,
      default: () => []
    }
  },
  data: function() {
    return {
      mIsFirst: true,
      mPrefList: [],
      mSelectPref: "",
      mInputSiku: "",
      mTabLeadtimeList: [],
      mTabLeadtimeListCount: 0,
      mChangeTabLeadtimeList: []
    };
  },
  methods: {
    /** 初期処理 */
    init: function() {
      if (this.mIsFirst) {
        this.prefSearch();
        this.mIsFirst = false;
      }
    },
    /** デポ住所リードタイム紐付き都道府県一覧取得 */
    prefSearch: function() {
      this.$root.$refs.appProgress.busy(true);
      Repository.searchLeadtimePref(this.searchParam.searchDepocd)
        .then(response => {
          var result = response.data;
          if (result.isSuccess) {
            this.$root.$refs.appProgress.busy(false);
            this.mPrefList = result.data.prefList;
            this.mSelectPref = result.data.selectPref;
          } else {
            alert(result.message);
          }
        }).catch(error => {
          var data = error.response.data;
          alert(data.message)
          this.$root.$refs.appProgress.busy(false);
        }).finally(() => {
        });
    },
    /** デポ住所リードタイムリスト検索 */
    search: function() {
      this.$root.$refs.appProgress.busy(true);
      Repository.searchLeadtimeList(this.searchParam.searchDepocd, this.mSelectPref)
        .then(response => {
          var result = response.data;
          if (result.isSuccess) {
            this.mTabLeadtimeListCount = result.data.length;
            // 100アイテムづつsetTimeoutでレンダリング
            this.betterRender('mTabLeadtimeList',result.data);
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
      if(this.mTabLeadtimeListCount == 0) {
        alert('検索結果が0件のため、ダウンロードできません。');
        return false;
      }
      var fileName = "LeadTime";
      var request = { depoCd: this.searchParam.searchDepocd };
      var url = Repository.downloadLeadtimeUrl();
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
      if(confirm('リードタイム情報を登録します、よろしいですか？')) {
        this.$root.$refs.appProgress.busy(true);
        Repository.saveLeadtime(this.searchParam.searchDepocd,this.filterChangeLeadtimeList)
          .then(response => {
            if (response.data.isSuccess) {
              alert("登録に成功しました。");
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
    /** 登録データ判定／変更 */
    rowDataChange: function(leadtime) {
      var idx = this.mChangeTabLeadtimeList
        .map(function(row) {
          return row.depoAddressLeadtimeId;
        })
        .indexOf(leadtime.depoAddressLeadtimeId);
      if (idx == -1) {
        // 存在しない場合のみ追加
        this.mChangeTabLeadtimeList.push(leadtime);
      }
    },
  },
  computed: {
    /**
     * 検索結果件数計算
     */
    searchCountComputed: function() {
      var count = 0;
      if(this.mInputSiku) {
        count = this.filterLeadtimeList.length;
      } else {
        count = this.mTabLeadtimeListCount;
      }
      return count;
    },
    /**
     * リードタイム一覧フィルター
     */
    filterLeadtimeList: function() {
      var list = this.mTabLeadtimeList;
      // 市区郡の絞り込み
      var filterSiku = this.mInputSiku;
      if (filterSiku) {
        list = list.filter(function(address) {
          if (address.siku.indexOf(filterSiku) > -1) {
            return true;
          }
          return false;
        });
      }
      return list;
    },
    /** 更新データ一覧計算 */
    filterChangeLeadtimeList: function() {
      // 変更があるもののみを抜粋
      return this.mChangeTabLeadtimeList;
    }
  },
  watch: {
    /** 都道府県変更時にAPI実行 */
    mSelectPref: function(val) {
      this.search();
    }
  }
};
</script>