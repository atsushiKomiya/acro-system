<template>
  <div>
    <div class="row my-3">
      <div class="col text-center">
        <p>日付指定</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label><input type="radio" v-model="selectType" value="1" v-on:change="selectTypeChange">&nbsp;日付</label>
        </div>
        <div class="pl-3">
          <app-date-pulldown
            v-bind:select-year.sync="selectYear"
            v-bind:select-month.sync="selectMonth"
            v-bind:select-day.sync="selectDate"
          ></app-date-pulldown>
        </div>
      </div>
    </div>

    <br />

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label><input type="radio" v-model="selectType" value="3" v-on:change="selectTypeChange">&nbsp;曜日</label>
        </div>
        <div class="d-flex flex-row mb-3 pl-3">
           <div class="div-day"><div v-bind:class="{backSun:activeSun}" @click="activeSun=!activeSun">日</div></div>
           <div class="div-day"><div v-bind:class="{backMon:activeMon}" @click="activeMon=!activeMon">月</div></div>
           <div class="div-day"><div v-bind:class="{backTue:activeTue}" @click="activeTue=!activeTue">火</div></div>
           <div class="div-day"><div v-bind:class="{backWed:activeWed}" @click="activeWed=!activeWed">水</div></div>
           <div class="div-day"><div v-bind:class="{backThu:activeThu}" @click="activeThu=!activeThu">木</div></div>
           <div class="div-day"><div v-bind:class="{backFri:activeFri}" @click="activeFri=!activeFri">金</div></div>
           <div class="div-day"><div v-bind:class="{backSat:activeSat}" @click="activeSat=!activeSat">土</div></div>
        </div>

        <br />
        <div class="d-flex flex-row mb-3 pl-3">
           <div class="div-day"><div v-bind:class="{backBeforePublic:activeBeforePublic}" @click="activeBeforePublic=!activeBeforePublic">祝前</div></div>
           <div class="div-day"><div v-bind:class="{backPublic:activePublic}" @click="activePublic=!activePublic">祝日</div></div>
           <div class="div-day"><div v-bind:class="{backAfterPublic:activeAfterPublic}" @click="activeAfterPublic=!activeAfterPublic">祝後</div></div>
        </div>
      </div>
    </div>

    <br />

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label><input type="radio" v-model="selectType" value="2" v-on:change="selectTypeChange">&nbsp;期間</label>
        </div>
        <div class="d-flex flex-row mb-3 pl-3">
          <app-date-pulldown
            v-bind:select-year.sync="selectStartYear"
            v-bind:select-month.sync="selectStartMonth"
            v-bind:select-day.sync="selectStartDate"
          ></app-date-pulldown>

          <div class="div-date dash"><label>~</label></div>

          <app-date-pulldown
            v-bind:select-year.sync="selectEndYear"
            v-bind:select-month.sync="selectEndMonth"
            v-bind:select-day.sync="selectEndDate"
          ></app-date-pulldown>
        </div>
      </div>
    </div>

    <div class="row my-4">
      <div class="col-md-12 text-center">
        <button class="btn btn-primary mr-5" href="#" v-on:click.prevent.self="dateReflect" v-bind:disabled="!isActive" role="button">決定</button>
        <button class="btn btn-primary" href="#" v-on:click.prevent.self="close" role="button">キャンセル</button>
      </div>
    </div>

  </div>
</template>
<script>
import moment from "moment";
export default {
  props:{
  },
  data: function(){
    return{
      selectType:'1',
      selectYear:'',
      selectMonth:'',
      selectDate:'',
      selectStartYear:'',
      selectStartMonth:'',
      selectStartDate:'',
      selectEndYear:'',
      selectEndMonth:'',
      selectEndDate:'',
      activeSun:false,
      activeMon:false,
      activeTue:false,
      activeWed:false,
      activeThu:false,
      activeFri:false,
      activeSat:false,
      activeBeforePublic:false,
      activePublic:false,
      activeAfterPublic:false
    }
  },
  methods:{
    dateReflect:function(){
      if(!window.opener || !Object.keys(window.opener).length){
        window.alert('親画面が存在しません');
      } else {
        //日付
        if(this.selectType=='1'){
          //年月日設定済みチェック
          if(!this.isActive){
            window.alert('年月日を選択してください');
            return;
          }
          //設定
          window.opener.dateReflect(
            this.selectType,
            this.selectYear,this.selectMonth,this.selectDate,
            [],
            [],
            null,null,null,
            null,null,null
          );
        //週
        }else if(this.selectType=='3'){
          //未設定チェック
          if(!this.isActive){
            window.alert('曜日を選択してください');
            return;
          }
          //設定
          window.opener.dateReflect(
            this.selectType,
            null,null,null,
            this.getSelectWeek,
            this.getSelectHoliday,
            null,null,null,
            null,null,null
          );
        //期間
        }else if(this.selectType=='2'){
          //通年チェック
          //開始日・終了日設定チェック
          if(!this.isActive){
            window.alert('開始日、終了日を選択してください');
            return;
          }

          // 通年設定
          if(!this.selectStartYear) {
            this.selectStartYear = this.$root.CONFIG.BASE_FROM_YESR;
          }
          if(!this.selectEndYear) {
            this.selectEndYear = this.$root.CONFIG.BASE_TO_YESR;
          }

          //設定
          window.opener.dateReflect(
            this.selectType,
            null,null,null,
            [],
            [],
            this.selectStartYear,this.selectStartMonth,this.selectStartDate,
            this.selectEndYear,this.selectEndMonth,this.selectEndDate
          );
        }
        close();
      }
    },
    close:function(){
      window.close();
    },
    selectTypeChange: function(event) {
      var selectType = event.target.value;

      switch(selectType) {
        case "1":
          this.selectStartYear = '';
          this.selectStartMonth = '';
          this.selectStartDate = '';
          this.selectEndYear = '';
          this.selectEndMonth = '';
          this.selectEndDate = '';
          this.activeSun = false;
          this.activeMon = false;
          this.activeTue = false;
          this.activeWed = false;
          this.activeThu = false;
          this.activeFri = false;
          this.activeSat = false;
          this.activeBeforePublic = false;
          this.activePublic = false;
          this.activeAfterPublic = false;
          break;
        case "2":
          this.selectYear = '';
          this.selectMonth = '';
          this.selectDate = '';
          this.activeSun = false;
          this.activeMon = false;
          this.activeTue = false;
          this.activeWed = false;
          this.activeThu = false;
          this.activeFri = false;
          this.activeSat = false;
          this.activeBeforePublic = false;
          this.activePublic = false;
          this.activeAfterPublic = false;
          break;
        case "3":
          this.selectYear = '';
          this.selectMonth = '';
          this.selectDate = '';
          this.selectStartYear = '';
          this.selectStartMonth = '';
          this.selectStartDate = '';
          this.selectEndYear = '';
          this.selectEndMonth = '';
          this.selectEndDate = '';
          break;
      }
    }
  },
  computed:{
    getSelectWeek:function(){
      var selectWeek = [];
      if(this.activeSun) {
        selectWeek.push(0);
      }
      if(this.activeMon) {
        selectWeek.push(1);
      }
      if(this.activeTue) {
        selectWeek.push(2);
      }
      if(this.activeWed) {
        selectWeek.push(3);
      }
      if(this.activeThu) {
        selectWeek.push(4);
      }
      if(this.activeFri) {
        selectWeek.push(5);
      }
      if(this.activeSat) {
        selectWeek.push(6);
      }
      return selectWeek;
    },
    getSelectHoliday:function(){
      var selectHoliday = [];
      if(this.activeBeforePublic) {
        selectHoliday.push(2);
      }
      if(this.activePublic) {
        selectHoliday.push(1);
      }
      if(this.activeAfterPublic) {
        selectHoliday.push(3);
      }
      return selectHoliday;
    },
    /** ボタン制御 */
    isActive: function() {
      var flg = false;
      if(this.selectType=='1') {
        // 日付
        if( this.selectYear && this.selectMonth && this.selectDate){
          flg = true;
        }
      } else if(this.selectType=='2') {
        // 期間
        if( this.selectStartMonth && 
            this.selectStartDate &&
            this.selectEndMonth &&
            this.selectEndDate){
            // From < to 判定
            // 通年設定
            var startYear = this.selectStartYear;
            var endYear = this.selectEndYear;
            if(!startYear) {
              startYear = this.$root.CONFIG.BASE_FROM_YESR;
            }
            if(!endYear) {
              endYear = this.$root.CONFIG.BASE_TO_YESR;
            }
            var startData = moment([startYear,this.selectStartMonth - 1,this.selectStartDate])
            var endData = moment([endYear,this.selectEndMonth - 1,this.selectEndDate])

            if(endData.isSameOrAfter(startData)) {
              flg = true;
            } else {
              flg = false;
              alert('終了日が開始日より前です。')
            }
        }
      } else {
        // 曜日
        if(this.getSelectWeek.length != 0 || this.getSelectHoliday != 0){
          flg = true;
        }
      }

      return flg;
    }
  }
}
</script>