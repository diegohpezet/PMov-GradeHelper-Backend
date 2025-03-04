<script setup>
const { formKey } = defineProps({
  formKey: {
    type: String,
    required: true,
  },
});
const model = defineModel({
  type: Object,
  required: true,
});
</script>

<template>
  <div class="mb-3">
    {{ model }}
    <label :for="`comment-${formKey}`" class="form-label">Comment</label>
    <input
      :id="`comment-${formKey}`"
      v-model="model['comment']"
      type="text"
      class="form-control"
    />
  </div>
</template>

<style scoped></style>
