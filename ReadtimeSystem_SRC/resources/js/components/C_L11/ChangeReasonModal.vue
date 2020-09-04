<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper" @click.self="$emit('closeModal')">
        <div class="modal-container">
          <div class="modal-body">
            <slot name="body">
            </slot>
          </div>
          <footer class="modal-footer">
            <slot name="footer">
              <button @click="$emit('closeModal')">Close</button>
            </slot>
          </footer>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
export default {
  data: function () {
      return {
          content: '',
      }
  }
}
</script>
