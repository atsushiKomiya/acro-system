<template>
  <nav class="navbar navbar-expand-sm">
    <div class="collapse navbar-collapse">
      <a class="navbar-brand text-white" :href="$root.URL_CONST.C_L01">{{ appname }}</a>
    </div>
    <ul class="navbar-nav">
      <li class="nav-item">
        <span class="nav-link text-white mr-3" v-if="authinfo">
          <span v-if="authinfo.AUTH_CLS == '1'">{{ authinfo.D_NAME }}&nbsp;&nbsp;&nbsp;{{ authinfo.E_NAME }}</span>
          <span v-if="authinfo.AUTH_CLS == '2'">{{ authinfo.DEPO_NAME }}</span>
        &nbsp;&nbsp;&nbsp;
        様
        </span>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#" @click="logout">ログアウト</a>
      </li>
    </ul>
    <form id="logout-form" :action="$root.URL_CONST.C_L01 + 'logout'" method="POST" style="display: none;">
      <input type="hidden" name="_token" v-bind:value="csrf">
    </form>
  </nav>
</template>
<script>
  export default {
    props: {
      appname: String,
      authinfo: Object
    },
    methods: {
      logout: function() {
        $("#logout-form").submit();
        return false;
      }
    }
  }
</script>