/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.config.devtools = true;

/**
 * Custom Vue
 */
// mixin
import util from './components/common/Util.vue';
Vue.mixin(util);

// component
import Vue from 'vue';
import VueQuillEditor from 'vue-quill-editor';
import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';
Vue.use(VueQuillEditor);

import CGrid from 'vue-cheetah-grid';
Vue.use(CGrid);

// Common Parts
import Datepicker from 'vuejs-datepicker';
import { ja } from "vuejs-datepicker/dist/locale";
Datepicker.props.language.default = () => ja;
Vue.component('datepicker', Datepicker);
Vue.component('appheader', require('./components/common/AppHeader.vue').default);
Vue.component('apptoggletable', require('./components/common/AppToggleTable.vue').default);
Vue.component('apptoggle', require('./components/common/AppToggle.vue').default);
Vue.component('app-date-pulldown', require('./components/common/AppDatePulldown.vue').default);
Vue.component('selectbox', require('./components/common/SelectBox.vue').default);

// TOP
Vue.component('logininfo', require('./components/C_L01/LoginInfo.vue').default);
Vue.component('messages', require('./components/C_L01/Message.vue').default);
Vue.component('top-menu', require('./components/C_L01/TopMenu.vue').default);

// デポ休業等申請画面
Vue.component('depo-request', require('./components/C_L11/DepoRequest.vue').default);
Vue.component('change-reason-modal', require('./components/C_L11/ChangeReasonModal.vue').default);

// デポ選択
Vue.component('depolist', require('./components/C_L50/Depolist.vue').default);
// 商品選択
Vue.component('itemlist', require('./components/C_L52/ItemCategoryList.vue').default);
// 商品複数選択
Vue.component('itemmultiple', require('./components/C_L53/ItemCategoryMultiple.vue').default);
//日付選択
Vue.component('dateselect',require('./components/C_L54/DateSelect.vue').default);
//地域選択
Vue.component('areaselect',require('./components/C_L55/AreaSelect.vue').default);
//メッセージ確認
Vue.component('messagelist',require('./components/C_L56/MessageDuplication.vue').default);

// デポ稼働日確認
Vue.component('calendar-confirm', require('./components/C_L10/CalendarConfirm.vue').default);

// デフォルト設定
Vue.component('default', require('./components/C_L21/Default.vue').default);
Vue.component('tabcalendar', require('./components/C_L21/TabCalendar.vue').default);
Vue.component('tabdepoaddress', require('./components/C_L21/TabDepoAddress.vue').default);
Vue.component('tabdepoitem', require('./components/C_L21/TabDepoItem.vue').default);
Vue.component('tableadtime', require('./components/C_L21/TabLeadtime.vue').default);
//イレギュラー
Vue.component('irregular', require('./components/C_L31/Irregular.vue').default);


// デフォルト一覧
Vue.component('defaultlist', require('./components/C_L20/DefaultList.vue').default);

// イレギュラー一一覧
Vue.component('irregularlist', require('./components/C_L30/IrregularList.vue').default);

// Progress
Vue.component('appprogress', require('./components/common/AppProgress').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import 'moment/locale/ja'
import moment from 'moment';
Vue.use(moment);

// Const
import UrlConst from './action/Action'
import {CONFIG} from './config.js';

const app = new Vue({
  name: 'App',
  el: '#app',
  components: {
    moment
  },
  data: function() {
    return {
      URL_CONST: UrlConst,
      CONFIG: CONFIG
    };
  }
});

