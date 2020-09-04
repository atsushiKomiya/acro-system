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

        <div class="row"  v-if="!islist">
            <div class="col-md-3">
                <p>商品</p>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <select class="form-control" v-model="selectItem">
                    <option value="">すべて</option>
                    <option v-for="item in changeItem" :key="item.itemCd" :value="item.itemCd">
                        {{ '【' + item.itemCd + '】' + item.itemName }}
                    </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row my-4">
            <div class="col-md-12 text-center">
                <a class="btn btn-primary mr-5" href="#" v-on:click.prevent.self="itemReflect" role="button">決定</a>
                <a class="btn btn-primary" href="#" v-on:click.prevent.self="close" role="button">キャンセル</a>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        props:{
            itemcategorylargelist: Array,
            itemcategorymediumlist: Array,
            viewitemlist: Array,
            islist: Boolean
        },
        data: function(){
            return {
                selectItemCategoryLarge:'',
                selectItemCategoryMedium:'',
                selectItem:''
            }
        },
        methods:{
            itemReflect:function(){
                var islist = this.islist;
                
                if(!window.opener || !Object.keys(window.opener).length){
                    window.alert('親画面が存在しません');
                }else{
                    //返却値
                    var selectItemCategoryLargeCd = 0;
                    var selectItemCategoryLargeName = 'すべて';
                    var selectItemCategoryMediumCd = 0;
                    var selectItemCategoryMediumName = 'すべて';
                    var selectItemCd = 0;
                    var selectItemName = 'すべて';

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
                    if(islist){
                        //デフォルト設定呼び出し
                        window.opener.itemListReflect(
                            selectItemCategoryLargeCd,
                            selectItemCategoryLargeName,
                            selectItemCategoryMediumCd,
                            selectItemCategoryMediumName,
                            this.changeItem
                        );
                    }else{
                        if(this.selectItem!=''){
                            selectItemCd = this.viewitemlist.find(item => item.itemCd == this.selectItem).itemCd;
                            selectItemName = this.viewitemlist.find(item => item.itemCd == this.selectItem).itemName;
                        }
                         //デフォルト一覧呼び出し
                        window.opener.itemReflect(
                            selectItemCategoryLargeCd,
                            selectItemCategoryLargeName,
                            selectItemCategoryMediumCd,
                            selectItemCategoryMediumName,
                            selectItemCd,
                            selectItemName
                        );
                    }
                }
            close();
            },
            close:function(){
                window.close();
            },
        },
        computed: {
            //カテゴリ中選択肢変更
            changeItemCategoryMedium: function(){
                var itemcategorymedium = this.itemcategorymediumlist;
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
            //商品選択肢変更
            changeItem: function(){
                var viewitem = this.viewitemlist;
                //親で選択されたカテゴリ
                var filterCategoryLarge = this.selectItemCategoryLarge;
                var filterCategoryMedium = this.selectItemCategoryMedium;
                //リレーションから抽出
                if(filterCategoryLarge){
                    //大の抽出
                    viewitem = viewitem.filter(function(row){
                        if(row['itemCategoryLargeCd'] == filterCategoryLarge){
                            return row;
                        }
                        return false;
                    });
                }
                if(filterCategoryMedium){
                    //中の抽出
                    viewitem = viewitem.filter(function(row){
                        if(row['itemCategoryMediumCd'] == filterCategoryMedium){
                            return row;
                        }
                        return false;
                    });
                }
                return viewitem;
            },
        }
    }
</script>