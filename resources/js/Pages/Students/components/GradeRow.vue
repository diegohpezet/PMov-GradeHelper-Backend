<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const { grade } = defineProps({
  grade: Object,
});

const showTruncated = ref(true);

const dateFormatter = new Intl.DateTimeFormat('es-AR', {
  dateStyle: 'short',
  timeStyle: 'short',
});

const isPassFailGrade = (grade) => {
  return grade.gradeable_type === 'App\\Models\\PassFailGrade';
};

const getGradeValue = (grade) => {
  if (!isPassFailGrade(grade)) {
    return grade.gradeable.value;
  }

  return grade.gradeable.value
    ? t('grades.results.passed')
    : t('grades.results.failed');
};

const gradeClass = (grade) => {
  if (!isPassFailGrade(grade)) {
    return '';
  }

  return grade.gradeable.value ? 'text-success' : 'text-danger';
};
</script>

<template>
  <div class="row align-items-top" @click="showTruncated = !showTruncated">
    <div class="col-auto" :class="gradeClass(grade)">
      {{ getGradeValue(grade) }}
    </div>
    <div
      class="col"
      :class="{
        'text-truncate': showTruncated,
      }"
    >
      {{ grade.gradeable.comment }}
    </div>
    <div class="col-auto">
      {{ dateFormatter.format(new Date(grade.created_at)) }}
    </div>
  </div>
</template>
