<template>
  <div class="d-flex flex-row">
    <div class="div-date">
      <select class="form-control" v-model="syncSelectYear">
        <option value="">----年</option>
        <option v-for="year in pulldownListYear" :key="'year-' + year" :value="year">
          {{ year }}
        </option>
      </select>
    </div>
    <div class="div-date">
      <select class="form-control" v-model="syncSelectMonth">
        <option value="">--月</option>
        <option v-for="month in pulldownListMonth" :key="'month-' + month" :value="month">
          {{ month }}
        </option>
      </select>
    </div>
    <div class="div-date">
      <select class="form-control" v-model="syncSelectDay">
        <option value="">--日</option>
        <option v-for="day in pulldownListDay" :key="'day-' + day" :value="day">
          {{ day }}
        </option>
      </select>
    </div>
  </div>
</template>
<script>
  import moment from "moment";
  export default {
    props: {
      selectYear: String,
      selectMonth: String,
      selectDay: String,
    },
    data: function(){
      return {
        mBaseToMonth: 12,
        mBaseToDay: 31
      }
    },
    computed: {
      /** 年プルダウン */
      pulldownListYear: function(){
        var list = [];
        var loop = this.$root.CONFIG.BASE_TO_YESR - this.$root.CONFIG.BASE_FROM_YESR;
        for(var i = 1; i < loop; i++) {
          var year = this.$root.CONFIG.BASE_FROM_YESR + i;
          list.push('' + year);
        }
        return list;
      },
      /** 月プルダウン */
      pulldownListMonth: function(){
        var list = [];
        for(var i = 0; i < this.mBaseToMonth; i++) {
          var month = i + 1;
          list.push('' + month);
        }
        return list;
      },
      /** 日プルダウン */
      pulldownListDay: function(){
        var list = [];
        var lastDay = this.mBaseToDay;
        if(this.syncSelectYear != 0 && this.syncSelectMonth != 0) {
          lastDay = moment([this.syncSelectYear,this.syncSelectMonth - 1,1]).endOf('month').format('DD');
        }
        for(var i = 0; i < lastDay; i++) {
          var day = i + 1;
          list.push('' + day);
        }
        return list;
      },
      /** 年同期 */
      syncSelectYear: {
        get: function() {
          return this.selectYear;
        },
        set: function(newValue) {
          // 設定日付チェック
          var lastDay = this.mBaseToDay;
          if(newValue != 0 && this.syncSelectMonth != 0) {
            lastDay = moment([newValue,this.syncSelectMonth - 1,1]).endOf('month').format('DD');
          }

          if(Number(lastDay) < Number(this.syncSelectDay)) {
            this.syncSelectDay = lastDay;
          }

          this.$emit("update:selectYear", newValue);
        }
      },
      /** 月同期 */
      syncSelectMonth: {
        get: function() {
          return this.selectMonth;
        },
        set: function(newValue) {
          // 設定日付チェック
          var lastDay = this.mBaseToDay;
          if(this.syncSelectYear != 0 && newValue != 0) {
            lastDay = moment([this.syncSelectYear,newValue - 1,1]).endOf('month').format('DD');
          }

          if(Number(lastDay) < Number(this.syncSelectDay)) {
            this.syncSelectDay = lastDay;
          }

          this.$emit("update:selectMonth", newValue);
        }
      },
      /** 日同期 */
      syncSelectDay: {
        get: function() {
          return this.selectDay;
        },
        set: function(newValue) {
          this.$emit("update:selectDay", newValue);
        }
      }
    }
  }
</script>