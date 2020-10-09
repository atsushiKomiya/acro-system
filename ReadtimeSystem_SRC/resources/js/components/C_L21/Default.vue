<template>
  <div class="mt-3">
    <div class="default-search">
      <div class="row">
        <h4 class="col-md-6">デフォルト設定画面</h4>
      </div>
      <form id="search-form" :action="$root.URL_CONST.C_L21 + '/search'" method="GET">
        <div class="row">
          <div class="col-md-2" style="vertical-align: middle">
            デポ名
            <span class="badge badge-danger">必須</span>
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-primary" @click="depolistOpen">デポ選択</button>
          </div>

        </div>
        <div class="row">
          <div class="col-md-4 under-line" v-html="mSearchParam.searchDeponame"></div>
          <input type="hidden" name="searchDepocd" v-model="mSearchParam.searchDepocd" />
          <div class="col-md-6" />
          <div class="col-md-2 btn-right">
            <button type="button" class="btn btn-primary" @click="reset">リセット</button>
            <button type="button" @click="search" class="btn btn-primary" :disabled="!mSearchParam.searchDepocd">検索</button>
          </div>
        </div>
      </form>
    </div>
    <template v-if="mErrorMsgList.length != 0">
      <div class="error-area">
        <p v-for="msg in mErrorMsgList" :key="msg" v-html="msg"></p>
      </div>
    </template>
    <div class="default-input" v-if="checkDepoInfo">
      <ul id="tabMenu">
        <li
          class="col-md-3"
          v-on:click="change(1)"
          v-bind:class="{'active': tabActive === 1}"
        >カレンダーデフォルト情報</li>

        <li v-if="depoDefaultId === null"
          class="col-md-3 disable"
        >リードタイム情報</li>
        <li v-else
          class="col-md-3"
          v-on:click="change(2)"
          v-bind:class="{'active': tabActive === 2}"
        >リードタイム情報</li>

        <li v-if="depoDefaultId === null"
          class="col-md-3 disable"
        >デポ取扱商品紐付け情報</li>
        <li v-else
          class="col-md-3"
          v-on:click="change(3)"
          v-bind:class="{'active': tabActive === 3}"
        >デポ取扱商品紐付け情報</li>

        <li v-if="depoDefaultId === null"
          class="col-md-3 disable"
        >デポ取扱住所紐付け情報</li>
        <li v-else
          class="col-md-3"
          v-on:click="change(4)"
          v-bind:class="{'active': tabActive === 4}"
        >デポ取扱住所紐付け情報</li>

      </ul>
      <tabcalendar
        v-if="tabActive === 1"
        v-bind:search-param="searchParam"
        v-bind:depo-info="depoInfo"
        v-bind:keicho-type-list="keichoTypeList"
        @changeDepoDefaultId="changeDepoDefaultId"
      />
      <tableadtime
        v-else-if="tabActive === 2"
        v-bind:search-param="searchParam"
        v-bind:pref-list="prefList"
        v-bind:time-select-list="timeSelectList"
        v-bind:deadline-time-list="deadlineTimeList"
        v-bind:error-list.sync="mErrorMsgList"
      />
      <tabdepoitem
        v-else-if="tabActive === 3" 
        v-bind:search-param="searchParam"
        v-bind:error-list.sync="mErrorMsgList"
      />
      <tabdepoaddress v-else-if="tabActive === 4"
        v-bind:search-param="searchParam"
        v-bind:pref-list="prefList"
        v-bind:error-list.sync="mErrorMsgList"
       />
    </div>
    <div class="row my-3">
      <div class="col-md-6">
        <div class="span4">
          <a class="btn btn-primary" href="javascript:" @click="moveDefaultList()" role="button">一覧</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Error from "../mixins/Error";
export default {
  mixins: [Error],
  props: {
    prefList: Object,
    depoInfo: Object,
    searchParam: Object,
    keichoTypeList: Array,
    timeSelectList: Object,
    deadlineTimeList: Object,
  },
  data: function() {
    return {
      mSearchParam: this.searchParam,
      tabActive: 1,
      depoDefaultId: null,
      checkDepoInfo: this.depoInfo
    };
  },
  methods: {
    reset: function() {
      this.mSearchParam.searchDepocd = "";
      this.mSearchParam.searchDeponame = "";
      this.mSearchParam.searchDisplayType = "";
      this.checkDepoInfo = null;
      this.depoDefaultId = null;
    },
    search: function(e) {
      this.mErrorMsgList = [];
      if (this.mSearchParam.searchDepocd == "") {
        alert("デポを選択してください。");
        e.preventDefault();
      } else {
        this.$root.$refs.appProgress.busy(true);
        $("#search-form").submit();
      }
    },
    change: function(num) {
      if(this.tabActive != num) {
        if(confirm('タブを切替えると現在の変更は破棄されます、よろしいですか？')){
          this.tabActive = num;
          this.mErrorMsgList = [];
        }
      }
    },
    depolistOpen: function() {
      childWinOpen(this.$root.URL_CONST.C_L50, undefined, this.searchDepoRegist);
    },
    searchDepoRegist: function(depo) {
      this.mSearchParam.searchDepocd = depo.depocd;
      this.mSearchParam.searchDeponame = depo.deponame;
    },
    changeDepoDefaultId: function(depoDefaultId) {
      this.depoDefaultId = depoDefaultId;
    },
    moveDefaultList: function () {
      var moveUrl = ''
      if (this.searchParam.searchDepocd) {
        moveUrl = this.$root.URL_CONST.C_L20 + "?searchDepocd=" + this.searchParam.searchDepocd;
      } else {
        moveUrl = this.$root.URL_CONST.C_L20;
      }
      location.href = moveUrl;
    }
  }
};
</script>