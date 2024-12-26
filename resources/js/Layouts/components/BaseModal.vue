<script setup>
import { defineEmits } from 'vue';

const emit = defineEmits(['close']);

const closeModal = () => {
  emit('close');
};
</script>

<template>
  <div class="modal-backdrop mb-3" @click.self="closeModal">
    <div class="modal-content">

      <header>
        <slot name="header"></slot>
      </header>

      <main class="mb-3">
        <slot>
          <p>This is the default modal content</p>
        </slot>
      </main>

      <footer>
        <slot name="footer"></slot>
      </footer>

    </div>
  </div>
</template>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  max-width: 500px;
  width: 100%;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
