<template>
  <div class="row my-3">
    <div class="col-md-2">
        <p>ログイン - </p>
    </div>
    <div class="col-md-10" v-if="authinfo">
        <p v-if="authinfo.AUTH_CLS == '1'">{{ authinfo.D_NAME }}</p>
        <p v-if="authinfo.AUTH_CLS == '2'">【{{ authinfo.DEPO_CD }}】 {{ authinfo.DEPO_NAME }}</p>
    </div>
  </div>
</template>
<script>
    export default {
        props: {
            authinfo: Object
        }
    }
</script>