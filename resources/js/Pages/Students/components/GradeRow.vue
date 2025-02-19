<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const { grade } = defineProps({
  grade: Object,
});

const showTruncated = ref(true);

const translatedGradeResults = {
  failed: t('grades.results.failed'),
  passed: t('grades.results.passed'),
};

const dateFormatter = new Intl.DateTimeFormat('es-AR', {
  dateStyle: 'short',
  timeStyle: 'short',
});
</script>

<template>
  <div class="row align-items-top" @click="showTruncated = !showTruncated">
    <div
      class="col-auto"
      :class="{
        'text-danger': grade.result == 'failed',
        'text-success': grade.result == 'passed',
      }"
    >
      {{ translatedGradeResults[grade.result] }}
    </div>
    <div
      class="col"
      :class="{
        'text-truncate': showTruncated,
      }"
    >
      {{ grade.comment }}
    </div>
    <div class="col-auto">
      {{ dateFormatter.format(new Date(grade.created_at)) }}
    </div>
  </div>
</template>
