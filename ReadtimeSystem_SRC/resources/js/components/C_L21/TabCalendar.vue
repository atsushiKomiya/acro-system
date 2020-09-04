<template>
  <div class="tab-calendar" v-if="searchParam.searchDepocd && depoInfo">
    <div v-if="mIsFirst" :onLoad="init()"></div>
    <form id="save-form" :action="$root.URL_CONST.C_L21_CALENDAR + '/save'" method="POST">
      <div class="row">
        <div class="toggle-div week-div">
          <apptoggletable
            v-bind:dayofweekname="'月'"
            v-bind:display-type="depoInfo.displayType"
            v-bind:yesterday.sync="vm.monBeforeDeadlineFlg"
            v-bind:today.sync="vm.monTodayDeliveryFlg"
          />
        </div>
        <div class="toggle-div week-div">
          <apptoggletable
            v-bind:dayofweekname="'火'"
            v-bind:display-type="depoInfo.displayType"
            v-bind:yesterday.sync="vm.tueBeforeDeadlineFlg"
            v-bind:today.sync="vm.tueTodayDeliveryFlg"
          />
        </div>
        <div class="toggle-div week-div">
          <apptoggletable
            v-bind:dayofweekname="'水'"
            v-bind:display-type="depoInfo.displayType"
            v-bind:yesterday.sync="vm.wedBeforeDeadlineFlg"
            v-bind:today.sync="vm.wedTodayDeliveryFlg"
          />
        </div>
        <div class="toggle-div week-div">
          <apptoggletable
            v-bind:dayofweekname="'木'"
            v-bind:display-type="depoInfo.displayType"
            v-bind:yesterday.sync="vm.thuBeforeDeadlineFlg"
            v-bind:today.sync="vm.thuTodayDeliveryFlg"
          />
        </div>
        <div class="toggle-div week-div">
          <apptoggletable
            v-bind:dayofweekname="'金'"
            v-bind:display-type="depoInfo.displayType"
            v-bind:yesterday.sync="vm.friBeforeDeadlineFlg"
            v-bind:today.sync="vm.friTodayDeliveryFlg"
          />
        </div>
        <div class="toggle-div week-div">
          <apptoggletable
            v-bind:dayofweekname="'土'"
            v-bind:display-type="depoInfo.displayType"
            v-bind:yesterday.sync="vm.satBeforeDeadlineFlg"
            v-bind:today.sync="vm.satTodayDeliveryFlg"
          />
        </div>
        <div class="toggle-div week-div">
          <apptoggletable
            v-bind:is-public-holiday="true"
            v-bind:dayofweekname="'日'"
            v-bind:display-type="depoInfo.displayType"
            v-bind:yesterday.sync="vm.sunBeforeDeadlineFlg"
            v-bind:today.sync="vm.sunTodayDeliveryFlg"
          />
        </div>
        <div class="toggle-div week-div">
          <apptoggletable
            v-bind:dayofweekname="'祝前'"
            v-bind:display-type="depoInfo.displayType"
            v-bind:yesterday.sync="vm.holiBeforeDeadlineFlg"
            v-bind:today.sync="vm.holiBeforeTodayDeliveryFlg"
          />
        </div>
        <div class="toggle-div week-div">
          <apptoggletable
            v-bind:is-public-holiday="true"
            v-bind:dayofweekname="'祝日'"
            v-bind:display-type="depoInfo.displayType"
            v-bind:yesterday.sync="vm.holiDeadlineFlg"
            v-bind:today.sync="vm.holiTodayDeliveryFlg"
          />
        </div>
        <div class="toggle-div week-div">
          <apptoggletable
            v-bind:dayofweekname="'祝後'"
            v-bind:display-type="depoInfo.displayType"
            v-bind:yesterday.sync="vm.holiAfterDeadlineFlg"
            v-bind:today.sync="vm.holiAfterTodayDeliveryFlg"
          />
        </div>
      </div>
      <div class="row">
        <div class="col-md-1 toggle-div">
          <div class="toggle-tr">
            個人宅
            <br />可否
          </div>
          <apptoggle v-bind:is-class="true" v-bind:is-active.sync="vm.privateHomeFlg" />
        </div>
        <div class="col-md-1 toggle-div">
          <div class="toggle-tr">
            手持ちお届け
            <br />可否
          </div>
          <apptoggle v-bind:is-class="true" v-bind:is-active.sync="vm.handingFlg" />
        </div>
        <div class="col-md-5 toggle-div">
          <div class="toggle-tr">
            振替先
            <br />配送デポ
          </div>
          <div class="toggle-td deleteContainerParent" @click="depolistOpen">
            <span v-if="vm.transferPostDepoCd">{{ vm.transferPostDepoName }}</span>
            <span v-else>デポ選択</span>
            <div class="deleteButtonContainer" v-if="vm.transferPostDepoCd">
              <button type="button" @click="depoDelete" class="deleteButton">×</button>
            </div>
          </div>
        </div>
        <div class="col-md-1 toggle-div">
          <div class="toggle-tr">
            慶弔区分
            <br />可否
          </div>
          <div class="toggle-td" style="padding:0">
            <select
              class="form-control"
              name="congratulationKbnFlg"
              v-model="vm.congratulationKbnFlg"
            >
              <option
                v-for="keicho in keichoTypeList"
                :key="keicho.type"
                :value="keicho.type"
              >{{ keicho.name }}</option>
            </select>
          </div>
        </div>
        <div class="col-md-1 toggle-div">
          <div class="toggle-tr">
            デポリード
            <br />タイム
          </div>
          <div class="toggle-td" style="padding:0">
            <input
              class="form-control"
              type="number"
              name="depoLeadTime"
              v-model="vm.depoLeadTime"
              placeholder="4"
              min="0"
              max="99"
              maxlength="2"
            />
          </div>
        </div>
      </div>
      <div class="row pt-5 pb-3">
        <div class="col-md-4 offset-md-5">
          <div class="form-inline" v-if="vm.depoDefaultId">
            <label>適用開始日</label>
            <datepicker
              :format="$root.CONFIG.DATE_FMT"
              @closed="pickerClosed"
              name="startDate"
              v-model="mDay"
            >{{ mDay }}</datepicker>
          </div>
        </div>
        <div class="col-md-3 btn-right">
          <button type="button" @click="reflect" class="btn btn-primary" v-if="vm.depoDefaultId" :disabled="!mDay">カレンダーに適用</button>
          <button type="button" @click="save" class="btn btn-primary">登録</button>
        </div>
      </div>
      <input type="hidden" name="_token" v-bind:value="csrf" />
    </form>
    <form id="reflect-form" :action="$root.URL_CONST.C_L21_CALENDAR + '/reflect'" method="POST">
      <input type="hidden" name="_token" v-bind:value="csrf" />
    </form>
  </div>
</template>
<script>
import moment from "moment";
import Repository from "../../api/Repository";
export default {
  props: {
    searchParam: Object,
    depoInfo: Object,
    keichoTypeList: Array,
  },
  data: function () {
    return {
      mIsFirst: true,
      vm: {
        type: Object,
        default: {
          depoDefaultId: null,
          depoCd: null,
          monBeforeDeadlineFlg: false,
          monTodayDeliveryFlg: false,
          tueBeforeDeadlineFlg: false,
          tueTodayDeliveryFlg: false,
          wedBeforeDeadlineFlg: false,
          wedTodayDeliveryFlg: false,
          thuBeforeDeadlineFlg: false,
          thuTodayDeliveryFlg: false,
          friBeforeDeadlineFlg: false,
          friTodayDeliveryFlg: false,
          satBeforeDeadlineFlg: false,
          satTodayDeliveryFlg: false,
          sunBeforeDeadlineFlg: false,
          sunTodayDeliveryFlg: false,
          holiBeforeDeadlineFlg: false,
          holiBeforeTodayDeliveryFlg: false,
          holiDeadlineFlg: false,
          holiTodayDeliveryFlg: false,
          holiAfterDeadlineFlg: false,
          holiAfterTodayDeliveryFlg: false,
          privateHomeFlg: false,
          handingFlg: false,
          congratulationKbnFlg: false,
          transferPostDepoCd: null,
          transferPostDepoName: null,
          depoLeadTime: 0,
        },
      },
      mDay: null,
    };
  },
  methods: {
    init: function () {
      // 初期処理
      if (this.mIsFirst) {
        this.search();
        this.mIsFirst = false;
      }
    },
    search: function () {
      // デポ取扱住所リスト検索
      this.$root.$refs.appProgress.busy(true);
      Repository.searchCalendar(this.searchParam.searchDepocd)
        .then((response) => {
          var data = response.data;
          if (data.isSuccess) {
            this.vm = data.data;
            this.changeDepoDefaultId(data.data.depoDefaultId);
          } else {
            alert(data.message);
          }
        })
        .catch((error) => {
          var data = error.response.data;
          alert(data.message);
        })
        .finally(() => {
          this.$root.$refs.appProgress.busy(false);
        });
    },
    depolistOpen: function () {
      childWinOpen(this.$root.URL_CONST.C_L50, undefined, this.transDepoRegist);
    },
    transDepoRegist: function (depo) {
      this.vm.transferPostDepoCd = depo.depocd;
      this.vm.transferPostDepoName = depo.deponame;
    },
    depoDelete: function(e) {
      this.vm.transferPostDepoCd = '';
      this.vm.transferPostDepoName = ''
      e.stopPropagation();
    },
    save: function (e) {
      this.$root.$refs.appProgress.busy(true);
      Repository.saveCalendar(this.vm)
        .then((response) => {
          this.$root.$refs.appProgress.busy(false);
          if (response.data.isSuccess) {
            this.changeDepoDefaultId(this.vm.depoDefaultId);
            alert("登録に成功しました。");
            this.search()
          } else {
            alert(response.data.message);
          }
        })
        .catch((error) => {
          var data = error.response.data;
          alert(data.message);
          this.$root.$refs.appProgress.busy(false);
        })
        .finally(() => {
        });
    },
    reflect: function (e) {
      if(confirm('指定された適用開始日にてカレンダー情報を更新します、よろしいですか？')) {
        this.$root.$refs.appProgress.busy(true);
        Repository.reflectCalendar(this.depoInfo.depocd,moment(this.mDay).format("YYYYMMDD"))
          .then((response) => {
            if (response.data.isSuccess) {
              alert("カレンダー適用中です。しばらくお待ちください。");
            } else {
              alert(response.data.message);
            }
          })
          .catch((error) => {
            var data = error.response.data;
            alert(data.message);
          })
          .finally(() => {
            this.$root.$refs.appProgress.busy(false);
          });
      }
    },
    pickerClosed() {
      if (this.mDay) {
        this.mDay = moment(this.mDay).format("YYYY/MM/DD");
      }
    },
    changeDepoDefaultId(depoId) {
      this.$emit('changeDepoDefaultId', depoId)
    }
  },
  computed: {},
};
</script>