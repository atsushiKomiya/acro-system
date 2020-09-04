<script>
  export default {
    props: {
      errorMsgList: {
        type: Array,
        required: false,
        default: () => []
      }
    },
    data: function(){
      return {
        mErrorMsgList: this.errorMsgList.length != 0 ? this.errorMsgList : []
      }
    }
  }
</script>