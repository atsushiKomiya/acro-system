<template>
  <div>
    <div class="row my-3">
      <div class="col text-center">
        <p>地域選択</p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3">
        <p>都道府県</p>
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <select class="form-control" v-model="selectPref" @change="resetPref">
          <option value="">全県</option>
            <option v-for="item in preflist" :key="item.pref" :value="item.pref">
              {{ item.prefName }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3">
        <p>市区郡</p>
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <select class="form-control" v-model="selectCity" @change="changeAddress">
          <option value="">すべて</option>
          <option v-for="item in changeCity" :key="item.jiscode" :value="item.jiscode">
            {{ item.siku }}
          </option>
          </select>
        </div>
      </div>
    </div>

    <div class="row" v-if="isaddress">
      <div class="col sticky-table">
        <table class="table-striped table-hover">
        <thead>
          <tr>
            <th class="t-check align-middle" scope="col"><input type="checkbox" v-model="allSelected"/></th>
            <th class="t-pref align-middle" scope="col">都道府県</th>
            <th class="t-pref align-middle" scope="col">市区郡</th>
            <th class="t-pref align-middle" scope="col">町名</th>
            <th class="t-pref align-middle" scope="col">郵便番号</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in filterdAddress" :key="item.zipcode" @click="select(item)" class="list-row" v-bind:class="{'selected': item.isSelect}">
            <td class="align-middle" ><input type="checkbox" v-model="item.isSelect" value="true"></td>
            <td>{{ item.prefName }}</td>
            <td>{{ item.siku }}</td>
            <td>{{ item.tyou }}</td>
            <td>{{ item.zipcode }}</td>
          </tr>
        </tbody>
        </table>
      </div>
    </div>

    <div class="row my-4">
      <div class="col-md-12 text-center">
        <a class="btn btn-primary mr-5" href="#" v-on:click.prevent.self="addressReflect" role="button">決定</a>
        <a class="btn btn-primary" href="#" v-on:click.prevent.self="close" role="button">キャンセル</a>
      </div>
    </div>

  </div>
</template>
<script>
  import Repository from '../../api/Repository';
  export default {
    props:{
      citylist:Array,
      preflist:Array,
      isaddress: Boolean
    },
    data: function(){
      return {
        mAddresslist:[],
        allSelected: false,
        selectPref:'',
        selectCity:'',
        displayType:1
      }
    },
    methods:{
      addressReflect:function(){

        if(!window.opener || !Object.keys(window.opener).length){
          window.alert('親画面が存在しません');
        }else{
          var reflectList = this.registerAddress;
          if(reflectList.length == 0) {
            window.alert('地域が選択されておりません');
          } else {
            //返却値設定
            if(this.isaddress){
              window.opener.addressReflect(
                this.displayType,
                reflectList
              );
            }else{
              //市区郡設定
              window.opener.cityReflect(
                this.displayType,
                reflectList
              );
            }
            close();
          }
        }
      },
      close:function(){
        window.close();
      },
      resetPref:function(){
        //表示切替
        this.selectCity = '';
        if(!this.selectPref){
          this.displayType = 1;
        }
      },
      changeAddress:function(){
        if(this.selectCity){
          //表示切替
          this.displayType = 3;

          // 複数選択時のみAPI実行して市区郡以下を取得する
          if(this.isaddress) {
            //API実行
            this.$root.$refs.appProgress.busy(true);
            Repository.searchAddressList(this.selectCity)
            .then(response => {
              this.mAddresslist = response.data.data;
            }).catch(error => {
              var data = error.response.data;
              alert(data.message)
            }).finally(() => {
              this.$root.$refs.appProgress.busy(false);
            });
          }
        }else{
          //表示切替(再度すべてを選択した場合)
          this.displayType = 2;
        }
      },
      select: function (address) {
        var app = this;
        // 複数選択のみ実行する
        var oldIsSelect = address.isSelect;

        if(!this.isaddress){
          var lsit = [];
          if(this.displayType==1){
            lsit = this.preflist;
          //市区郡表示
          }else if(this.displayType==2){
            lsit = this.citylist;
          //住所表示
          }else if(this.displayType==3){
            lsit = this.mAddresslist;
          }

          // 単一選択の場合は全て解除
          lsit.filter(function($address) {
            return $address.isSelect;
          }).forEach(function(address){
            app.$set(address,"isSelect",false);
          });

        }
        // 選択/解除
        if(oldIsSelect) {
          this.$set(address,"isSelect",false);
        } else {
          this.$set(address,"isSelect",true);
        }
        this.$forceUpdate();
      }
     },
     computed: {
       changeCity: function(){
        var city;
        var citylist = this.citylist;
        //選択された都道府県
        var filterPref = this.selectPref;
        
        //リレーションから抽出
        if(filterPref){
          //表示切替
          this.displayType = 2
          //絞り込み
          city = citylist.filter(function(address){
            if(address.pref == filterPref){
              return address;
            }
            return false;
          });
        }

        return city;
      },
      registerAddress: function() {
        var resultList = [];
        if(this.isaddress) {
          resultList = this.filterdAddress.filter(x => x.isSelect);
        } else {
          if(this.displayType == 3) {
            var select = this.selectCity;
            resultList.push(this.changeCity.find(city => city.jiscode == select));
          } else {
            resultList = this.filterdAddress;
          }
        }

        return resultList;
      },
      //テーブル表示
      filterdAddress: function(){
        var data = [];
        var app = this;

        //都道府県表示
        if(this.displayType==1){
          data = this.preflist;
        //市区郡表示
        }else if(this.displayType==2){
          data = this.citylist;
          var filterPref = this.selectPref;
          //都道府県絞り込み
          if(filterPref) {
            data = data.filter(function (address) {
              if (address.pref !== filterPref) {
                app.$set(address,"isSelect",false);
                return false;
              }
              return address;
            });
          }
        //住所表示
        }else if(this.displayType==3){
          data = this.mAddresslist;
          var filterCity = this.selectCity;
          //市区郡絞り込み
          if(filterCity) {
            data = data.filter(function (address) {
              if (address.jiscode !== filterCity) {
                app.$set(address,"isSelect",false);
                return false;
              }
              return address;
            });
          }
        }
        

        //選択状態の確認
        if(data.length != 0) {
          this.allSelected = data.every(function(address){
            return address.isSelect;
          });
        } else {
          this.allSelected = false;
        }

        return data;
      }
    },
    watch: {
      displayType: function (newVal, oldVal) {
        var app = this;
        var lsit = [];
        if(oldVal==1){
          lsit = this.preflist;
        //市区郡表示
        }else if(oldVal==2){
          lsit = this.citylist;
        //住所表示
        }else if(oldVal==3){
          lsit = this.mAddresslist;
        }

        // 単一選択の場合は全て解除
        lsit.filter(function($address) {
          return $address.isSelect;
        }).forEach(function(address){
          app.$set(address,"isSelect",false);
        });
      },
      allSelected: function(val) {
        var app = this;
        var isSelect = val;
        this.filterdAddress.forEach(function(address){
          app.$set(address,"isSelect",isSelect);
        });
      }
    }
  }
</script>