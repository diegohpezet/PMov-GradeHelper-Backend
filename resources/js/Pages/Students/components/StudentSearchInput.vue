<script setup>
const emit = defineEmits(['search']);

const handleInput = (event) => {
  emit('search', event.target.value);
};
</script>

<template>
  <div class="mb-3">
    <input
      type="text"
      :placeholder="$t('students.find')"
      class="form-control"
      @input="handleInput"
    />
  </div>
</template>
