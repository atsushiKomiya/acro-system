<script>
  export default {
    computed: {
      csrf: function(){
          return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      },
    }
  }
</script>