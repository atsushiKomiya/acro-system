<template>
  <div id="fadeLayer" class="mask" v-if="showProgress">
      <div class="mask-progress" :onLoad="init()">
        <div class="loader" v-text="loading"></div>
      </div>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      showProgress: false,
      loading: ''
    };
  },
  methods: {
    init: function() {
      this.loading = 'Loading...';
    },
    busy: function(isBusy) {
      if (isBusy) {
        this.showProgress = true;
      } else {
        this.showProgress = false;
        this.loading = '';
      }
    },
  },
  watch: {
    /** window size cahnge */
    loading: function(val) {
      if(this.showProgress) {
        var target = document.getElementById("fadeLayer");
        
        var maxheightA = Math.max(document.body.clientHeight, document.body.scrollHeight)
        var maxheightB = Math.max(document.documentElement.scrollHeight, document.documentElement.clientHeight)
        var MaxHeight = Math.max(maxheightA,maxheightB);
        target.style.height = MaxHeight+"px";
        
        var maxwidthA = Math.max(document.body.clientWidth, document.body.scrollWidth)
        var maxwidthB = Math.max(document.documentElement.scrollWidth, document.documentElement.clientWidth)
        var MaxWidth = Math.max(maxwidthA, maxwidthB);
        target.style.width = MaxWidth + "px";
      }
    }
  }
};
</script>
<style lang='scss' scoped>
@import '../../../sass/loading.scss';
</style>