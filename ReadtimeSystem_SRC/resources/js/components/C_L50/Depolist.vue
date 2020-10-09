<template>
  <div>
    <div class="row my-3">
      <div class="col text-center">
        <p v-if="ismulti">デポ複数選択</p>
        <p v-else>デポ選択</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <p>都道府県</p>
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <select class="form-control" v-model="selectPref">
            <option value="">全県</option>
            <option value="0">---</option>
            <option v-for="item in preflist" :key="item.pref" :value="item.pref">
              {{ item.prefName }}
            </option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <p>表示グループ区分</p>
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <select class="form-control" v-model="selectDisp">
            <option value="">すべて</option>
            <option v-for="(value, key) in dispgrouptypelist" :key="key" :value="key">
              {{ value }}
            </option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col sticky-table">
        <table class="table-striped table-hover">
          <thead>
            <tr>
              <th class="t-check align-middle" scope="col" v-if="ismulti">
                <input type="checkbox" v-model="allSelected" @click="allSelectedFunc"/>
              </th>
              <th class="t-depo align-middle" scope="col">デポ名</th>
              <th class="t-pref align-middle" scope="col">都道府県</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="depo in filteredTasks" :key="depo.depocd" @click="select(depo)" class="list-row" v-bind:class="{'selected': depo.isSelect}">
              <td class="align-middle" v-if="ismulti">
                <input type="checkbox" :value="true" v-model="depo.isSelect">
              </td>
              <td>{{ '【' + depo.depocd + '】' + depo.deponame }}</td>
              <td>{{ depo.depoPref }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row my-4">
      <div class="col-md-12 text-center">
        <a class="btn btn-primary mr-5" href="#" v-on:click.prevent.self="depoRegist" role="button">決定</a>
        <a class="btn btn-primary" href="#" v-on:click.prevent.self="close" role="button">キャンセル</a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    preflist: Object,
    dispgrouptypelist: Object,
    depolist: Array,
    ismulti: Boolean
  },
  data: function () {
    return {
      mDepoList: this.depolist,
      allSelected: false,
      selectPref: '',
      selectDisp: '',
      oneSelectedFlg: false,
    }
  },
  methods: {
    isSelectDepo: function(depo) {
      var result = false;
      if("isSelect" in depo) {
        result = depo.isSelect;
      }
      return result;
    },
    depoRegist: function() {
      if(this.selectDepoList.length > 0) {
        if(!window.opener || !Object.keys(window.opener).length) {
          window.alert('親画面が存在しません')
        } else {
          // 値の反映
          if(this.ismulti) {
            // 複数選択用
            var depoList = this.selectDepoList;
            window.opener.depoListReflect(depoList);
          } else {
            // 単一選択用
            var depo = this.selectDepoList[0];
            window.opener.depoReflect(
                depo
            );
          }
          // クローズ
          close();
        }
      } else {
        alert('デポを選択してください');
      }
    },
    close: function() {
      window.close();
    },
    select: function (depo) {
      var oldIsSelect = this.isSelectDepo(depo);
      // 単一選択の場合は全て解除
      if(!this.ismulti) {
        var app = this;
        this.mDepoList.filter(function($depo) {
          return $depo.isSelect;
        })
        .forEach(function(depo){
          app.$set(depo,"isSelect",false);
        });
      }
      // 選択/解除
      this.oneSelectedFlg = true;
      if(oldIsSelect) {
        this.$set(depo,"isSelect",false);
      } else {
        this.$set(depo,"isSelect",true);
      }
    },
    allSelectedFunc: function () {
      this.oneSelectedFlg = false;
      this.allSelected = this.allSelected ? false : true;
    }
  },
  computed: {
    selectDepoList: function() {
      return this.mDepoList.filter(function(depo){
        return depo.isSelect;
      });
    },
    filteredTasks: function () {
      var app = this;
      var data = this.mDepoList;
      
      // 都道府県絞り込み
      var filterPref = this.selectPref && Number(this.selectPref);
      if(filterPref || filterPref === 0) {
        data = data.filter(function (depo) {
          if (depo.depoPref !== filterPref) {
            app.$set(depo,"isSelect",false);
            return false;
          }

          return depo;
        });
      }

      // デポ表示タイプ
      var filterDisp = this.selectDisp && Number(this.selectDisp);
      if(filterDisp || filterDisp === 0) {
        data = data.filter(function (depo) {
          if (depo.displayGroupType !== filterDisp) {
            app.$set(depo,"isSelect",false);
            return false;
          }

          return depo;
        });
      }

      // 選択状態の確認
      if(data.length != 0) {
        this.allSelected = data.every(function(depo){
          return depo.isSelect;
        });
      } else {
        this.allSelected = false;
      }
      return data;
    }
  },
  watch: {
    allSelected: function(val) {
      var app = this;
      var isSelect = val;
      if (!this.oneSelectedFlg) {
        this.filteredTasks.forEach(function(depo){
          app.$set(depo,"isSelect",isSelect);
        });
      }
    }
  }
}
</script>