<template>
  <div>
    <div class="row my-3">
      <div class="span4">
        <a class="btn btn-primary" :href="$root.URL_CONST.C_L11" role="button">{{ titles.C_L11.title }}</a>
      </div>
    </div>
    <template v-if="authinfo.AUTH_CLS == '1'">
      <div class="row my-3">
        <div class="span4">
          <a class="btn btn-primary" :href="$root.URL_CONST.C_L10" role="button">{{ titles.C_L10.title }}</a>
        </div>
      </div>
      <div class="row my-3">
        <div class="span4">
          <a class="btn btn-primary" :href="$root.URL_CONST.C_L21" role="button">{{ titles.C_L21.title }}</a>
        </div>
      </div>
      <div class="row my-3">
        <div class="span4">
          <a class="btn btn-primary" :href="$root.URL_CONST.C_L20" role="button">{{ titles.C_L20.title }}</a>
        </div>
      </div>
      <div class="row my-3">
        <div class="span4">
          <a class="btn btn-primary" :href="$root.URL_CONST.C_L31" role="button">{{ titles.C_L31.title }}</a>
        </div>
      </div>
      <div class="row my-3">
        <div class="span4">
          <a class="btn btn-primary" :href="$root.URL_CONST.C_L30" role="button">{{ titles.C_L30.title }}</a>
        </div>
      </div>
    </template>
  </div>
</template>
<script>
  export default {
    props: {
      authinfo: Object,
      titles: Object
    }
  }
</script>