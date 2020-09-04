<template>
  <div class="row my-3">
        <ul>
            <li v-if="authinfo != null && authinfo.AUTH_CLS == '1'">
                <div class="text-danger">{{ unapprovedmsg }}</div>
            </li>
            <li v-for="message in messages" :key="message.messageId">
                <div class="text-danger">{{ message.message }}</div>
            </li>
        </ul>
  </div>
</template>
<script>
    export default {
        props: {
            unapprovedmsg: String,
            authinfo: Object,
            messages: Array
        }
    }
</script>