<template>
  <div>
    <div class="row my-3">
      <div class="col text-center">
        <p>メッセージ重複確認</p>
      </div>
    </div>

    <div class="row">
      <!-- デポ -->
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12"><p>デポ</p></div>
          <div class="col-md-1"></div>
          <div class="col-md-3">デポ名</div>
          <div class="col-md-8 under-line">{{depoNameList.join(',')}}</div>
        </div>
      </div>
      <!-- 期間 -->
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12"><p>期間</p></div>
          <div class="col-md-1"></div>
          <div class="col-md-3">日付</div>
          <div class="col-md-8 under-line"> {{deliveryDate}}</div>

          <div class="col-md-1"></div>
          <div class="col-md-3">期間</div>
          <div class="col-md-8 under-line"> {{deliveryPeriod}}</div>

          <div class="col-md-1"></div>
          <div class="col-md-3">曜日</div>
          <div class="col-md-8 under-line"> {{deliveryDayofweekList.join(',')}}</div>
        </div>
      </div>

      <!-- 商品 -->
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12"><p>商品</p></div>
          <div class="col-md-1"></div>
          <div class="col-md-3">カテゴリ（大）</div>
          <div class="col-md-8 under-line">{{itemCategoryLargeCdNameList.join(',')}}</div>

          <div class="col-md-1"></div>
          <div class="col-md-3">カテゴリ（中）</div>
          <div class="col-md-8 under-line">{{itemCategoryMediumCdNameList.join(',')}}</div>

          <div class="col-md-1"></div>
          <div class="col-md-3">商品</div>
          <div class="col-md-8 under-line">{{itemCdNameList.join(',')}}</div>
        </div>
      </div>

      <!-- 住所 -->
      <div class="col-md-6">
        <div class="row">

          <div class="col-md-12"><p>住所</p></div>

          <div class="col-md-1"></div>
          <div class="col-md-3">都道府県</div>
          <div class="col-md-8 under-line">{{prefCdNameList.join(',')}}</div>

          <div class="col-md-1"></div>
          <div class="col-md-3">市区郡</div>
          <div class="col-md-8 under-line"> {{sikuList.join(',')}}</div>

          <div class="col-md-1"></div>
          <div class="col-md-3">町名</div>
          <div class="col-md-8 under-line"> {{tyouList.join(',')}}</div>
        </div>
      </div>
    </div>

    <br />

    <div class="row">
      <div class="sticky-table">
        <div class="count">検索結果 {{messageList.length}} 件</div>
        <table class="message-table">
        <thead>
          <tr>
            <th class="th-id" scope="col">ID</th>
            <th class="th-date-type" scope="col">データ区分</th>
            <th class="th-message" scope="col">変更理由・注釈</th>
            <th class="th-error-message" scope="col">エラーメッセージ</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="message in messageList">
            <template v-if="message.messageType == 1">
              <tr :key="getMessageKey(message)" class="list-row">
                <td><a @click="pageTransition(message)" href="#">{{ '-' }}</a></td>
                <td>{{ getMessageTypeStr(message) }}</td>
                <td class="text-left">{{ getGepoReqMessage(message) }}</td>
                <td class="text-left"></td>
              </tr>
            </template>
            <template v-if="message.messageType == 2 && message.irregularType != 3">
              <tr :key="'addr-' + getMessageKey(message)" class="list-row">
                <td rowspan="2"><a @click="pageTransition(message)" href="#">{{ message.irregularId }}</a></td>
                <td rowspan="2">{{ getMessageTypeStr(message) }}</td>
                <td class="text-left">{{ '地域注釈：' + message.annoAddr }}</td>
                <td class="text-left" rowspan="2">{{ message.errorMessage }}</td>
              </tr>
              <tr :key="'period-' + getMessageKey(message)" class="list-row">
                <td class="text-left">{{ '期間注釈：' + message.annoPeriod }}</td>
              </tr>
            </template>
            <template v-if="message.messageType == 2 && message.irregularType == 3">
              <tr :key="'addr-' + getMessageKey(message)" class="list-row">
                <td><a @click="pageTransition(message)" href="#">{{ message.irregularId }}</a></td>
                <td>{{ getMessageTypeStr(message) }}</td>
                <td class="text-left">{{ '振替注釈：' + message.annoTrans }}</td>
                <td class="text-left">{{ message.errorMessage }}</td>
              </tr>
            </template>
          </template>
        </tbody>
        </table>
      </div>
    </div>

    <div class="row my-4">
      <div class="col-md-12 text-center">
        <a class="btn btn-primary" href="#" v-on:click.prevent.self="close" role="button">閉じる</a>
      </div>
    </div>

  </div>
</template>
<script>
  import DateUtil from "../mixins/DateUtilMixins";
  export default {
    mixins: [DateUtil],
    props:{
      messageList:Array,
      depoNameList:Array,
      itemCategoryLargeCdNameList:Array,
      itemCategoryMediumCdNameList:Array,
      itemCdNameList:Array,
      prefCdNameList:Array,
      sikuList:Array,
      tyouList:Array,
      deliveryDate:String,
      deliveryPeriod:String,
      deliveryDayofweekList:Array,
    },
    data: function(){
      return {
      }
    },
    methods:{
      /** 閉じる */
      close:function(){
        window.close();
      },
      /** デポ休業等申請の場合の注釈部分の見出し作成 */
      getGepoReqMessage: function(model) {
        var result = '';
        var ymd = this.dateForDefaultFormat(model.deliveryDate);
        var week = this.judgeWeek(Number(model.dayofweek));
        var holiday = this.judgeHoliday(Number(model.publicHolidayStatus));
        var weekAndHoliday = '';
        if(week) {
          weekAndHoliday = '(' + week;
          if(holiday) {
            weekAndHoliday += '・' + holiday;
          }
          weekAndHoliday += ')'
        }
        var result = ymd + weekAndHoliday + '：' + model.annotationDisp
        return result;
      },
      /** リストのkeyを一意に特定する */
      getMessageKey: function(model) {
        var result = '';
        var id = model.messageType == 1 ? model.depoCalId : model.irregularId;
        result = model.messageType + '-' + id;
        return result;
      },
      /** リストのkeyを一意に特定する */
      getMessageTypeStr: function(model) {
        var result = '';
        if(model.messageType == 1) {
          result = '休業等申請';
        } else {
          if(model.irregularType == 1) {
            result = '配送不可';
          } else if(model.irregularType == 2) {
            result = '受注制御';
          } else if(model.irregularType == 3) {
            result = '配送先振替';
          }
        }
        return result;
      },
      pageTransition:function(model){
        
        if(!window.opener || !Object.keys(window.opener).length){
          window.alert('親画面が存在しません');
        }else{
          var url = '';
          if(model.messageType == 1) {
            url = this.$root.URL_CONST.C_L11 + '/search?searchDepocd=' + model.depoCd + '&searchYm=' + model.dateYm;
          } else {
            url = this.$root.URL_CONST.C_L31 + '?irregularId=' + model.irregularId;
          }

          window.opener.pageTransition(url);
          }
      },
    },
    computed:{
    }
  }
</script>