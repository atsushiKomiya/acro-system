<template>
  <select
    v-bind:class="className"
    v-model="model[paramName]"
    @change="change(model)"
  >
    <option v-for="(value, key) in options" :key="key" :value="key">{{ value }}</option>
  </select>
</template>
<script>
  export default {
    props: {
      model: Object,
      className: String,
      paramName: String,
      options: Object 
    },
    methods: {
      change: function(model) {
        this.$emit('change', model);
      }
    }
  }
</script>