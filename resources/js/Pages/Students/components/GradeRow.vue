<script setup>
import { ref } from 'vue';

defineProps({
  grade: { type: Object, required: true, default: () => ({}) },
});

const showTruncated = ref(true);

const dateFormatter = new Intl.DateTimeFormat('es-AR', {
  dateStyle: 'short',
  timeStyle: 'short',
});

const isPassFailGrade = (gradeable) => {
  return gradeable.gradable_type === 'App\\Models\\PassFailGrade';
};
</script>

<template>
  <div class="row align-items-top" @click="showTruncated = !showTruncated">
    <div
      class="col-1"
      :class="{
        'text-danger': isPassFailGrade(grade) && !grade.gradable.value,
        'text-success': isPassFailGrade(grade) && grade.gradable.value,
      }"
    >
      {{
        isPassFailGrade(grade)
          ? (grade.gradable.value && 'Passed') || 'Failed'
          : grade.gradable.value
      }}
    </div>
    <div
      class="col"
      :class="{
        'text-truncate': showTruncated,
      }"
    >
      {{ grade.gradable.comment }}
    </div>
    <div class="col-auto">
      {{ dateFormatter.format(new Date(grade.created_at)) }}
    </div>
  </div>
</template>
