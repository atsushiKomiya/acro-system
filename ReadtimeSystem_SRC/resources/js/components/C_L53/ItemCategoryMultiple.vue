<template>
  <div>
    <div class="row my-3">
      <div class="col text-center">
        <p>商品カテゴリ選択</p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3">
        <p>商品カテゴリ大</p>
      </div>
      <div class="col-md-9">
        <div class="form-group">
          <select class="form-control" v-model="selectItemCategoryLarge">
            <option value="">すべて</option>
            <option v-for="item in itemcategorylargelist" :key="item.itemCategoryLargeCd" :value="item.itemCategoryLargeCd">
              {{ '【' + item.itemCategoryLargeCd + '】' + item.itemCategoryLargeName }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3">
        <p>商品カテゴリ中</p>
      </div>
      <div class="col-md-9">
        <div class="form-group">
          <select class="form-control" v-model="selectItemCategoryMedium">
          <option value="">すべて</option>
          <option v-for="item in changeItemCategoryMedium" :key="item.itemCategoryMediumCd" :value="item.itemCategoryMediumCd">
            {{ '【' + item.itemCategoryMediumCd + '】' + item.itemCategoryMediumName }}
          </option>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3">
        <p>慶弔区分</p>
      </div>
      <div class="col-md-9">
        <div class="form-group">
          <label><input type="checkbox" v-model="checkCelebration">&nbsp;慶のみ</label>
          &nbsp;&nbsp;
          <label><input type="checkbox" v-model="checkFuneral">&nbsp;弔のみ</label>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col sticky-table">
        <table class="table-striped table-hover">
        <thead>
          <tr>
            <th class="t-check align-middle" scope="col"><input type="checkbox" v-model="allSelected"/></th>
            <th class="t-pref align-middle" scope="col">商品カテゴリ大</th>
            <th class="t-pref align-middle" scope="col">商品カテゴリ中</th>
            <th class="t-pref align-middle" scope="col">商品</th>
            <th class="t-pref align-middle" scope="col">慶弔区分</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in filterdItem" :key="item.itemCd" @click="select(item)" class="list-row" v-bind:class="{'selected': item.isSelect}">
            <td class="align-middle" ><input type="checkbox" v-model="item.isSelect"></td>
            <td>{{ '【'+item.itemCategoryLargeCd+'】'+item.itemCategoryLargeName }}</td>
            <td>{{ '【'+item.itemCategoryMediumCd+'】'+item.itemCategoryMediumName }}</td>
            <td>{{ '【'+item.itemCd+'】' + item.itemName }}</td>
            <td>{{ item.keicho }}</td>
          </tr>
        </tbody>
        </table>
      </div>
    </div>

    <div class="row my-4">
      <div class="col-md-12 text-center">
        <button class="btn btn-primary mr-5" href="#" v-on:click.prevent.self="itemReflect" role="button" :disabled="filterdItem.filter(x => x.isSelect).length == 0">決定</button>
        <button class="btn btn-primary" href="#" v-on:click.prevent.self="close" role="button">キャンセル</button>
      </div>
    </div>

  </div>
</template>
<script>
  export default {
    props:{
      itemcategorylargelist: Array,
      itemcategorymediumlist: Array,
      viewitemlist: Array
    },
    data: function(){
      return {
        allSelected: false,
        selectItemCategoryLarge:'',
        selectItemCategoryMedium:'',
        checkCelebration:false,
        checkFuneral:false
      }
    },
    methods:{
      itemReflect:function(){

        if(!window.opener || !Object.keys(window.opener).length){
          window.alert('親画面が存在しません');
        }else{
          //返却値
          var selectItemCategoryLargeCd = 0;
          var selectItemCategoryLargeName = 'すべて';
          var selectItemCategoryMediumCd = 0;
          var selectItemCategoryMediumName = 'すべて';

          //設定
          //カテゴリ大
          if(this.selectItemCategoryLarge!=''){
            selectItemCategoryLargeCd = this.itemcategorylargelist.find(item => item.itemCategoryLargeCd == this.selectItemCategoryLarge).itemCategoryLargeCd;
            selectItemCategoryLargeName = this.itemcategorylargelist.find(item => item.itemCategoryLargeCd == this.selectItemCategoryLarge).itemCategoryLargeName;
          }
          //カテゴリ中
          if(this.selectItemCategoryMedium!=''){
            selectItemCategoryMediumCd = this.itemcategorymediumlist.find(item => item.itemCategoryMediumCd == this.selectItemCategoryMedium).itemCategoryMediumCd;
            selectItemCategoryMediumName = this.itemcategorymediumlist.find(item => item.itemCategoryMediumCd == this.selectItemCategoryMedium).itemCategoryMediumName;
          }
          //商品
          window.opener.itemMultipleReflect(
            selectItemCategoryLargeCd,
            selectItemCategoryLargeName,
            selectItemCategoryMediumCd,
            selectItemCategoryMediumName,
            this.registerItem
          );

          close();
        }
      },
      close:function(){
        window.close();
      },
      select: function (item) {
        // 選択/解除
        if(item.isSelect) {
          this.$set(item,"isSelect",false);
        } else {
          this.$set(item,"isSelect",true);
        }
        this.$forceUpdate();
      }
    },
    computed: {
      //カテゴリ中選択肢変更
      changeItemCategoryMedium: function(){
        var itemcategorymedium　= this.itemcategorymediumlist;
        var itemcategorymediumlist = this.itemcategorymediumlist;
        //親で選択されたカテゴリ
        var filterCategoryLarge = this.selectItemCategoryLarge;
        //リレーションから抽出
        if(filterCategoryLarge){
          itemcategorymedium = itemcategorymediumlist.filter(function(row){
            if(row['itemCategoryLargeCd'] == filterCategoryLarge){
              return row;
            }
            return false;
          });
        }
        return itemcategorymedium;
      },
      //テーブル表示
      filterdItem: function(){
        var data = this.viewitemlist;
        var app = this;

        //カテゴリ大
        var filterItemCategoryLarge = this.selectItemCategoryLarge && Number(this.selectItemCategoryLarge);
        if(this.selectItemCategoryLarge) {
          data = data.filter(function (item) {
            if (item.itemCategoryLargeCd !== filterItemCategoryLarge) {
              app.$set(item,"isSelect",false);
              return false;
            }
            return item;
          });
        }
        //カテゴリ中
        var filterItemCategoryMedium = this.selectItemCategoryMedium && Number(this.selectItemCategoryMedium);
        if(this.selectItemCategoryMedium) {
          data = data.filter(function (item) {
            if (item.itemCategoryMediumCd !== filterItemCategoryMedium) {
              app.$set(item,"isSelect",false);
              return false;
            }
            return item;
          });
        }
        //慶弔どちらかチェックあり
        if((this.checkCelebration && this.checkFuneral) == false){
          //慶弔区分（慶）
          if(this.checkCelebration){
            data = data.filter(function(item){
              if(item.keicho !== '1'){
                app.$set(item,"isSelect",false);
                return false;
              }
              return item;
            });
          }
          //慶弔区分（弔）
          if(this.checkFuneral){
            data = data.filter(function(item){
              if(item.keicho !== '2'){
                app.$set(item,"isSelect",false);
                return false;
              }
              return item;
            });
          }
        }

        //選択状態の確認
        if(data.length != 0) {
          this.allSelected = data.every(function(item){
            return item.isSelect;
          });
        } else {
          this.allSelected = false;
        }

        return data;
      },
      registerItem: function() {
        var result = this.filterdItem.filter(x => x.isSelect);
        return result;
      },
    },
    watch: {
      allSelected: function(val) {
        var app = this;
        var isSelect = val;
        this.filterdItem.forEach(function(item){
          app.$set(item,"isSelect",isSelect);
        });
      },
      selectItemCategoryLarge: function(val) {
        if(val) {
          this.selectItemCategoryMedium = '';
        }
      }
    }
  }
</script>