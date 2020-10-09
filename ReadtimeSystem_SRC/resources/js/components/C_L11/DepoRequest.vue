<template>
  <div class="mt-3">
    <div class="default-search">
      <form id="search-form" class="position-relative" :action="$root.URL_CONST.C_L11 + '/search'" method="GET">
        <div class="row">
          <h4 class="col-md-8">デポ休業等申請画面</h4>
        </div>

        <div class="row">
          <div class="col-md-9">
            <div class="form-inline">
              <label class="control-label mr-5">
                デポ名
                <span class="badge badge-danger">必須</span>
              </label>
              <button v-if="authInfo.AUTH_CLS == 1" type="button" class="btn btn-primary form-label" @click="depolistOpen">デポ選択</button>
            </div>
          </div>
        </div>

        <br />

        <div class="row">
          <div class="col-md-5">
            <div class="under-line">
              {{ mSearchParam.searchDeponame }}
              <input type="hidden" name="searchDepocd" v-model="mSearchParam.searchDepocd" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-inline">
              <label class="control-label mr-2">対象年月</label>
              <select class="form-control" v-model="mSearchParam.searchYm" name="searchYm">
                <option v-for="(value,key) in monthList" :key="key" :value="key">{{ value }}</option>
              </select>
            </div>
          </div>
          <div class="col-md-4 text-right">
            <button type="button" @click="search" class="btn btn-primary">検索</button>
          </div>
        </div>

        <div class="contact-positon">
            <p>
              【お問い合わせ先】<br>
              0570-099-600 (②)<br>
              土日除く9:00～18:30
            </p>
        </div>
      </form>
    </div>
    <template v-if="mErrorMsgList.length != 0">
      <div class="error-area">
        <p v-for="msg in mErrorMsgList" :key="msg" v-html="msg"></p>
      </div>
    </template>
    <form id="calendar-info" :action="$root.URL_CONST.C_L11 + '/input'" method="get">
      <div class="default-input" v-if="this.mDisplayDepoCalInfo">
        <div class="row my-3 pl-2 pr-2">
          <div class="col-md-3 form-inline">
            <label class="mr-2">承認状態：</label>
            <label class="border-bottom" v-html="this.approvalstatus"></label>
          </div>
          <div class="col-md-3 form-inline">
            <label class="mr-2">確認状態：</label>
            <label class="border-bottom" v-html="this.confirmstatus"></label>
          </div>
          <div class="col-md-6 form-inline">
            <span>※表示日付は</span>
            <span class="text-danger" v-html="this.displayDateStr"></span>
            <span>となっております</span>
          </div>
        </div>
        <div class="row my-3">
          <div class="col sticky-table calendar-table">
            <table class="table-striped table-hover">
              <thead>
                <tr>
                  <th v-for="week in weeks" :key="week" colspan="2" class="t-depo align-middle text-center" scope="col">{{week}}</th>
                </tr>
                <tr>
                  <template v-for="i in 7">
                    <th v-if="depoDivisionCheckSpr(depoInfo.displayType)" :colspan="depoDivisionCheckEnt(depoInfo.displayType) ? 1 : 2" :key="'before-' + i">
                      前日締切
                    </th>
                    <th v-if="depoDivisionCheckEnt(depoInfo.displayType)" :colspan="depoDivisionCheckSpr(depoInfo.displayType) ? 1 : 2" :key="'today-' + i">
                      当日配送
                    </th>
                  </template>
                </tr>
              </thead>
              <!-- ここからループ -->
              <tbody>
                <tr v-for="(weekList,index) in targetDateListComputed" :key="index">
                  <template v-for="weekObj in weekList">
                    <td class="t-cal-parent-td" colspan="2" :key="weekObj.ymd">
                      <template v-if="weekObj.isDisp">
                        <tr class="calendar-row">
                          <td colspan="2" class="t-depo align-middle text-center" :class="{ 'bg-holiday' : holidayCheck(mDisplayDepoCalInfo.calendarList,weekObj.ymd) }" :key="weekObj.ymd">{{weekObj.day}}日</td>
                        </tr>
                        <tr class="calendar-row">
                          <!-- 変更可能な場合の表示 -->
                          <td class="t-cal-child-td" v-if="!weekObj.readOnly && depoDivisionCheckSpr(depoInfo.displayType) && calendarPulldownDispCheck(mDisplayDepoCalInfo.calendarList,weekObj.ymd)">
                            <select class="form-control" :value="selectJudgeDeadlineFlg(mDisplayDepoCalInfo.calendarList, weekObj.ymd, true)" @change="changeBeforeDeadlineFlg($event, mDisplayDepoCalInfo.calendarList, weekObj.ymd, true)" :class="{ 'font-change' : mDisplayDepoCalInfo.calendarList[weekObj.ymd].isChangeBefore }">
                              <option :value="true">○</option>
                              <option :value="false">×</option>
                              <option v-for="(deliverydeadline,key) in deliveryDeadlineList" :key="key" :value="key">{{deliverydeadline}}</option>
                            </select>
                          </td>
                          <td class="t-cal-child-td" v-if="!weekObj.readOnly && depoDivisionCheckEnt(depoInfo.displayType) && calendarPulldownDispCheck(mDisplayDepoCalInfo.calendarList,weekObj.ymd)">
                            <select v-bind:readonly="weekObj.readOnly" class="form-control" :value="selectJudgeDeadlineFlg(mDisplayDepoCalInfo.calendarList, weekObj.ymd, false)" @change="changeBeforeDeadlineFlg($event, mDisplayDepoCalInfo.calendarList, weekObj.ymd, false)" :class="{ 'font-change' : mDisplayDepoCalInfo.calendarList[weekObj.ymd].isChangeToday }">
                              <option :value="true">○</option>
                              <option :value="false">×</option>
                              <option v-for="(deliverydeadline,key) in deliveryDeadlineList" :key="key" :value="key">{{deliverydeadline}}</option>
                            </select>
                          </td>
                          <!-- 変更不可の場合の表示 -->
                          <td class="t-cal-child-td font-unchangeable"
                              v-if="weekObj.readOnly && depoDivisionCheckSpr(depoInfo.displayType) && calendarPulldownDispCheck(mDisplayDepoCalInfo.calendarList,weekObj.ymd)">
                                {{selectJudgeDeadlineFlgReadOnlyValue(mDisplayDepoCalInfo.calendarList, weekObj.ymd, true)}}
                          </td>
                          <td class="t-cal-child-td font-unchangeable"
                              v-if="weekObj.readOnly && depoDivisionCheckEnt(depoInfo.displayType) && calendarPulldownDispCheck(mDisplayDepoCalInfo.calendarList,weekObj.ymd)">
                                {{selectJudgeDeadlineFlgReadOnlyValue(mDisplayDepoCalInfo.calendarList, weekObj.ymd, false)}}
                          </td>
                        </tr>
                      </template>
                    </td>
                  </template>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="default-input changeReason annotation-area" v-if="this.mDisplayDepoCalInfo">
        <div class="row my-3">
          <div class="col text-center">
              <p>変更理由記入</p>
          </div>
        </div>
        <div class="row my-3">
          <div class="col-md-2"></div>
          <div class="col-md-5 text-center">変更理由</div>
          <div class="col-md-5 text-center" v-if="authInfo.AUTH_CLS == 1">変更理由（表示）</div>
        </div>
        <div v-for="calendar in changeCalendarList" :key="calendar.deliveryDate" class="row my-3 annotation-row">
          <div class="col-md-2 text-center">{{ calcMomentDate(calendar.deliveryDate, "YYYYMMDD", "D") }}日:</div>
          <div class="col-md-5">
            <div class="content ql-editor border-bottom" v-on:click="editChangeReason(false,mDisplayDepoCalInfo.calendarList[calendar.deliveryDate].annotationDepo, calendar.deliveryDate)" v-html="mDisplayDepoCalInfo.calendarList[calendar.deliveryDate].annotationDepo"></div>
          </div>
          <div class="col-md-5" v-if="authInfo.AUTH_CLS == 1">
            <div class="content ql-editor border-bottom" v-on:click="editChangeReason(true,mDisplayDepoCalInfo.calendarList[calendar.deliveryDate].annotationDisp, calendar.deliveryDate)" v-html="mDisplayDepoCalInfo.calendarList[calendar.deliveryDate].annotationDisp"></div>
          </div>
          <!-- コンポーネント modal -->
          <modal @closeModal="changeReasonModalYmd=0" v-if="changeReasonModalYmd != 0">
            <template slot="body">
              <quill-editor v-model="content"
              ref="quillEditor"
              ></quill-editor>
            </template>
            <template slot="footer">
              <button type="button" @click="modalInput(content,mDisplayDepoCalInfo.calendarList)">登録</button>
            </template>
          </modal>
        </div>
      </div>
      <div class="row my-3">
        <div class="col-md-6">
          <button type="button" class="btn btn-primary" v-on:click.stop.prevent="backList" v-if="authInfo.AUTH_CLS == 1 && listBackUrl">一覧</button>
        </div>
        <div class="col-md-6 text-right">
          <button v-if="authInfo.AUTH_CLS == 1 && this.mDisplayDepoCalInfo" type="button" class="btn btn-primary" @click="duplicateMessage">メッセージ重複確認</button>
          <button v-if="this.mDisplayDepoCalInfo" type="button" class="btn btn-primary" @click="confirm">確認</button>
          <button v-if="this.mDisplayDepoCalInfo" type="button" class="btn btn-primary" @click="application(mDisplayDepoCalInfo,mSearchParam)">申請</button>
          <button v-if="authInfo.AUTH_CLS == 1 && this.mDisplayDepoCalInfo" type="button" class="btn btn-primary" @click="approval(mDisplayDepoCalInfo,mSearchParam)">承認</button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import moment from "moment";
import Repository from "../../api/Repository";
Vue.component("modal", {
  template: "#change-reason-modal"
});
import modal from './ChangeReasonModal.vue';
import Error from "../mixins/Error";
export default {
  mixins: [Error],
  name: 'DepoRequest',
  components: {
    modal
  },
  props: {
    authInfo: Object,
    monthList: Object,
    deliveryDeadlineList: Object,
    searchParam: Object,
    depoInfo: Object,
    displayDepoCalInfo: Object,
    approvalstatus: String,
    confirmstatus: String,
    displayDateStr: String,
    listBackUrl: String,
    depoUnchangeableDays: String,
  },
  data: function () {
    return {
      mSearchParam: this.searchParam
      ? this.searchParam
      : {
          searchYm: "",
          searchDepocd: "",
          searchDeponame: ""
        },
      weeks:["月","火","水","木","金","土","日"],
      content: '',
      isContentModeDisp: false,
      editorOption: {
        theme: 'snow'
      },
      mTargetYm: this.searchParam.searchYm,
      calendarAprInfo: '',
      mDisplayDepoCalInfo: this.displayDepoCalInfo,
      changeReasonModalYmd: 0,
      changeCount: 0,
    }
  },
  methods: {
    /** デポ子画面表示 */
    depolistOpen: function() {
      childWinOpen(this.$root.URL_CONST.C_L50, undefined, this.searchDepoRegist);
    },
    /** デポ子画面選択内容反映 */
    searchDepoRegist: function(depo) {
      this.mSearchParam.searchDepocd = depo.depocd;
      this.mSearchParam.searchDeponame = depo.deponame;
    },
    /** 検索 */
    search: function(e) {
      this.$root.$refs.appProgress.busy(false);
      if (this.mSearchParam.searchDepocd == "" || this.mSearchParam.searchDepocd == null) {
        alert("デポを選択してください。");
        e.preventDefault();
      } else if(this.mSearchParam.searchYm == "" || this.mSearchParam.searchYm == null) {
        alert("年月を選択してください。");
        e.preventDefault();
      } else {
        this.$root.$refs.appProgress.busy(true);
        $("#search-form").submit();
      }
    },
    /** 一覧へ */
    backList: function() {
      if(confirm('遷移すると現在の変更は破棄されます。よろしいですか？')){
        this.$root.$refs.appProgress.busy(true);
        location.href = this.listBackUrl;
      }
    },
    /** 前日締切表示判定 */
    depoDivisionCheckSpr:function(depoDivision) {
      if(depoDivision === 1 || depoDivision === 3){
        return true;
      }else{
        return false;
      }
    },
    /** 当日配送表示判定 */
    depoDivisionCheckEnt:function(depoDivision) {
      if(depoDivision === 1 || depoDivision === 2){
        return true;
      }else{
        return false;
      }
    },
    /** ドロップダウン表示判定 */
    calendarPulldownDispCheck:function(list, ymd) {
      if(list[ymd]){
        return true;
      }else{
        return false;
      }
    },
    /** メッセージ重複確認子画面表示 */
    duplicateMessage: function(e) {
      if (this.mSearchParam.searchDepocd == "" || this.mSearchParam.searchDepocd == null) {
        alert("デポを選択してください。");
        e.preventDefault();
      } else if(this.mSearchParam.searchYm == "" || this.mSearchParam.searchYm == null) {
        alert("年月を選択してください。");
        e.preventDefault();
      } else {
        var params = new Array();
        params['_token'] = this.$root.csrf;
        var messageType = 1;
        params['messageType'] = messageType;
        params['depoCdList[]'] = this.mSearchParam.searchDepocd;
        params['depoCdNameList[]'] = ['【' + this.mSearchParam.searchDepocd + '】' + this.mSearchParam.searchDeponame];
        params['depoCalInfoList'] = JSON.stringify(this.changeCalendarList.filter(x => x.annotationDisp));
        var option = 'width=1200,height=700,toolbar=0,menubar=0,scrollbars=0,resizable=0';
        childWinOpenPost(this.$root.URL_CONST.C_L56 + '/search', params, undefined, option);
      }
    },
    /** 変更理由リッチテキストモーダル表示 */
    editChangeReason: function(isDispEdit,text,ymd) {
      this.isContentModeDisp = isDispEdit;
      this.content = text;
      this.changeReasonModalYmd = ymd;
    },
    /** 変更理由リッチテキストモーダル記入内容反映 */
    modalInput :function(inputVal,calendarList){
      var calendar = calendarList[this.changeReasonModalYmd];
      if(this.isContentModeDisp) {
        this.$set(calendar,"annotationDisp", inputVal);
      } else {
        this.$set(calendar,"annotationDepo", inputVal);
      }
      this.closeModal();
    },
    /** 変更理由リッチテキストモーダル閉じる */
    closeModal:function() {
      this.changeReasonModalYmd = 0;
    },
    /** 確認ボタン */
    confirm: function(e) {
      if (this.mSearchParam.searchDepocd == "" || this.mSearchParam.searchDepocd == null) {
        alert("デポを選択してください。");
        e.preventDefault();
      } else if(this.mSearchParam.searchYm == "" || this.mSearchParam.searchYm == null) {
        alert("年月を選択してください。");
        e.preventDefault();
      } else {
        this.$root.$refs.appProgress.busy(true);
        Repository.confirmDepoRequest(
          this.mDisplayDepoCalInfo.depoCd,
          this.mDisplayDepoCalInfo.dateYm
        ).then(response => {
          var result = response.data;
          if(result.isSuccess) {
            alert("確認を行いました。");
            this.search();
          } else {
            alert(result.message);
            this.$root.$refs.appProgress.busy(false);
          }
        }).catch(error => {
          var data = error.response.data;
          alert(data.message);
          this.$root.$refs.appProgress.busy(false);
        }).finally(() => {
        });
      }
    },
    /** 申請ボタン */
    application: function(mDisplayDepoCalInfo,mSearchParam) {
      var paramCalendarList = this.changeCalendarList;
      if (this.mSearchParam.searchDepocd == "" || this.mSearchParam.searchDepocd == null) {
        alert("デポを選択してください。");
      } else if(this.mSearchParam.searchYm == "" || this.mSearchParam.searchYm == null) {
        alert("年月を選択してください。");
      } else if(paramCalendarList.length === 0) {
        alert("データの更新がありません。");
      } else {
        this.$root.$refs.appProgress.busy(true);
        // 送信データの絞り込み
        Repository.applicationDepoRequest(
          this.mDisplayDepoCalInfo.depoCd,
          this.mDisplayDepoCalInfo.dateYm,
          paramCalendarList
        ).then(response => {
          var result = response.data;
          if(result.isSuccess) {
            alert("申請しました。");
            this.search();
          } else {
            alert(result.message);
            this.$root.$refs.appProgress.busy(false);
          }
        }).catch(error => {
          var data = error.response.data;
          alert(data.message);
          this.$root.$refs.appProgress.busy(false);
        }).finally(() => {
        });
      }
    },
    /** 承認ボタン */
    approval: function(mDisplayDepoCalInfo,mSearchParam) {
      var paramCalendarList = this.changeCalendarList;
      if (this.mSearchParam.searchDepocd == "" || this.mSearchParam.searchDepocd == null) {
        alert("デポを選択してください。");
      } else if(this.mSearchParam.searchYm == "" || this.mSearchParam.searchYm == null) {
        alert("年月を選択してください。");
      } else if(paramCalendarList.length === 0) {
        alert("データの更新がありません。");
      } else {
        this.$root.$refs.appProgress.busy(true);
        Repository.approvalDepoRequest(
          this.mDisplayDepoCalInfo.depoCd,
          this.mDisplayDepoCalInfo.dateYm,
          paramCalendarList
        ).then(response => {
          var result = response.data;
          if(result.isSuccess) {
            alert("承認しました。");
            this.search();
          } else {
            alert(result.message);
            this.$root.$refs.appProgress.busy(false);
          }
        }).catch(error => {
          var data = error.response.data;
          alert(data.message);
          this.$root.$refs.appProgress.busy(false);
        }).finally(() => {
        });
      }
    },
    /** 前日締切/当日配送プルダウン表示内容判定 */
    selectJudgeDeadlineFlg: function(displayDepoCalInfo,ymd,isBefore){
      var flag = isBefore ? displayDepoCalInfo[ymd].beforeDeadlineFlg : displayDepoCalInfo[ymd].todayDeliveryFlg;
      if(flag == "1"){
        var value = "true";
      }else if(flag == "0"){
        var value = "false"
      }else{
        var value = isBefore ? displayDepoCalInfo[ymd].beforeDeadlineLimitTime : displayDepoCalInfo[ymd].todayDeadlineLimitTime;
      }
      return value;
    },
    /** 前日締切/当日配送プルダウン変更不可時の表示内容 */
    selectJudgeDeadlineFlgReadOnlyValue: function(displayDepoCalInfo,ymd,isBefore){
      // selectJudgeDeadlineFlg()がtrue/falseの場合に○×に変換するだけ
      var selectValue = this.selectJudgeDeadlineFlg(displayDepoCalInfo, ymd, isBefore);
      if(selectValue === "true"){
        return "○";
      }else if(selectValue === "false"){
        return "×"
      }else{
        return selectValue;
      }
    },
    /** 前日締切/当日配送プルダウン表示内容反映 */
    changeBeforeDeadlineFlg: function(event,depoCalInfo,ymd,isBefore){
      var flgKeyName = isBefore ? 'beforeDeadlineFlg' : 'todayDeliveryFlg';
      var limitTimeKeyName = isBefore ? 'beforeDeadlineLimitTime' : 'todayDeadlineLimitTime';
      var flgOldKeyName = isBefore ? 'oldBeforeDeadlineFlg' : 'oldTodayDeliveryFlg';
      var limitOldTimeKeyName = isBefore ? 'oldBeforeDeadlineLimitTime' : 'oldTodayDeadlineLimitTime';
      var changeVal = event.target.value;
      var isChange = true;
      if(changeVal == 'true'){
        this.$set(depoCalInfo[ymd],flgKeyName, 1);
        this.$set(depoCalInfo[ymd],limitTimeKeyName, null);
      }else if(changeVal == 'false'){
        this.$set(depoCalInfo[ymd],flgKeyName, 0);
        this.$set(depoCalInfo[ymd],limitTimeKeyName, null);
      }else{
        this.$set(depoCalInfo[ymd],flgKeyName, 2);
        this.$set(depoCalInfo[ymd],limitTimeKeyName,changeVal);
      }

      //デポカレンダー情報と際がない場合、変更フラグをfalseにする
      if(Number(depoCalInfo[ymd][flgKeyName]) == Number(depoCalInfo[ymd][flgOldKeyName])) {
        if(depoCalInfo[ymd][flgKeyName] == 2) {
          // 時間指定の場合は時間も見る
          if(depoCalInfo[ymd][limitTimeKeyName] == depoCalInfo[ymd][limitOldTimeKeyName]) {
            isChange = false;
          }
        } else {
          isChange = false;
        }
      }
      
      // 変更フラグの判定
      if(isBefore) {
        this.$set(depoCalInfo[ymd],'isChangeBefore', isChange);
      } else {
        this.$set(depoCalInfo[ymd],'isChangeToday', isChange);
      }
      this.changeCount +=1;
    },
    /** 日付データ処理 */
    calcMomentDate: function(date,formatBefor,formatAfter) {
      var momentDate = moment(date, formatBefor);
      return momentDate.format(formatAfter);
    },
    /** 日曜日、祝日判定 */
    holidayCheck: function(calendarList, ymd) {
      if(calendarList[ymd] && (calendarList[ymd].publicHolidayStatus == 1 || calendarList[ymd].dayofweek == 0)) {
        return true;
      } else {
        return false;
      }
    }
  },
  computed: {
    /**
     * カレンダーの作成を行う
     */
    targetDateListComputed: function() {
      // 5 * 5のリストを作成する
      var firstWeek = 0;
      var lastDay = 0;
      var dispDayList = Array();
      var weekCount = 5;
      // デポの場合に変更可能な最小の日付
      var minChangeableDate = moment().add(Number(this.depoUnchangeableDays), 'days');

      if (this.mTargetYm) {
        //moment 日付関係のスクリプト
        var momentDate = moment(this.mTargetYm, "YYYYMM");
        //月初、月末を取得
        firstWeek = Number(momentDate.startOf("day").format("E"));
        lastDay = Number(momentDate.endOf("month").format("DD"));
        weekCount = Math.ceil((lastDay + (firstWeek - 1)) / 7)
      }
      // 月初の曜日を取得
      var row = 0;
      var baseWeekNo = 1;
      var baseDay = 1;
      for(var i=0 ; i < weekCount ; i++) {
      var weekList = Array();
      // カレンダー行数
        for(var j=1;j<8;j++) {
          var ymd = j;
          var day = "";
          var isDisp = false;
          // 曜日
          if( (i==0 && j >= firstWeek) || (i!=0 && baseDay <= lastDay) ) {
            // 先頭行の場合は１日より以前の曜日は表示しない
            isDisp = true;
            day = ("00" + baseDay).slice(-2);
            ymd = this.mTargetYm + day;
            baseDay += 1;
          }

          // 変更の可/不可判定
          var readOnly = this.authInfo.AUTH_CLS == 2 // デポの場合、
                            ? moment(ymd, "YYYYMMDD").isBefore(minChangeableDate, 'day') // 変更可能な日付より前は変更不可
                            : false; // デポ以外は制限なし
          var obj = {
            isDisp: isDisp,
            row: i,
            weekNo: j,
            ymd: ymd,
            day: Number(day),
            readOnly: readOnly,
          }
          weekList.push(obj);
        }
        dispDayList.push(weekList);
      }
      return dispDayList;
    },
    changeCalendarList: function() {
      var ct = this.changeCount;
      var list = this.mDisplayDepoCalInfo.calendarList;
      var result = [];
      Object.keys(list).forEach(function(key) {
        if((list[key].isChangeBefore || list[key].isChangeToday) || (list[key].annotationDepo || list[key].annotationDisp)) {
          result.push(list[key]);
        }
      });
      return result;
    }
  }
}
</script>