<template>
  <table class="table table-bordered toggle-table">
    <thead>
      <tr>
        <th colspan="2" scope="col" :class="{ 'bg-holiday' : isPublicHoliday }">{{ dayofweekname }}</th>
      </tr>
      <tr>
        <th v-if="displayType == 1 || displayType == 3" :class="{ 'bg-holiday' : isPublicHoliday }">前日締切</th>
        <th v-if="displayType == 1 || displayType == 2" :class="{ 'bg-holiday' : isPublicHoliday }">当日配送</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td v-if="displayType == 1 || displayType == 3">
          <apptoggle 
            v-bind:is-class="false"
            v-bind:is-active.sync="isYestadayActive"/>
        </td>
        <td v-if="displayType == 1 || displayType == 2">
          <apptoggle 
            v-bind:is-class="false"
            v-bind:is-active.sync="isTodayActive"/>
        </td>
      </tr>
    </tbody>
  </table>
</template>
<script>
  export default {
    props: {
      isPublicHoliday: {
        type: Boolean,
        required: false,
        default: false
      },
      displayType: Number,
      dayofweekname: String,
      yesterday: Boolean,
      today: Boolean,
    },
    computed: {
      isYestadayActive: {
        get: function() {
          return this.yesterday;
        },
        set: function(newValue) {
          this.$emit("update:yesterday", newValue);
        }
      },
      isTodayActive: {
        get: function() {
          return this.today;
        },
        set: function(newValue) {
          this.$emit("update:today", newValue);
        }
      }
    }
  }
</script>