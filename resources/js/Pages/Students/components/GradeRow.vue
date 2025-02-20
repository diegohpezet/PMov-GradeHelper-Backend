<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

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

const getGradeValue = (grade) => {
  if (!isPassFailGrade(grade)) {
    return grade.gradable.value;
  }

  return grade.gradable.value
    ? t('grades.results.passed')
    : t('grades.results.failed');
};

const gradeClass = (grade) => {
  if (!isPassFailGrade(grade)) {
    return '';
  }

  return grade.gradable.value ? 'text-success' : 'text-danger';
};
</script>

<template>
  <div class="row align-items-top" @click="showTruncated = !showTruncated">
    <div class="col-1" :class="gradeClass(grade)">
      {{ getGradeValue(grade) }}
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
