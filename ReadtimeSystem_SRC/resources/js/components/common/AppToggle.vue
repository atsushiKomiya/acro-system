<template>
  <div
    v-bind:class="{ 'toggle-td': isClass }"
    @click="change"
  >
    <template v-if="isActiveComputed"><span>○</span></template>
    <template v-else><span>×</span></template>
  </div>
</template>
<script>
  export default {
    props: {
      model: Object,
      isClass: Boolean,
      isActive: Boolean,
    },
    methods: {
      change: function() {
        this.isActiveComputed = !this.isActiveComputed;
      }
    },
    computed: {
      isActiveComputed: {
        get: function() {
          return this.isActive;
        },
        set: function(newValue) {
          this.$emit("update:isActive", newValue);
          this.$emit('change', this.model);
        }
      },
    }
  }
</script>