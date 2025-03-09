<script setup>
import { shortDateFormat } from '@/Utils/dates';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps({
  grades: { type: Array, required: true },
});
</script>

<template>
  <div v-if="grades.length" class="mt-3">
    <h4>{{ t('grades.history') }}</h4>
    <ul class="list-group">
      <li
        v-for="grade in grades"
        :key="grade.id"
        class="list-group-item list-group-item-action"
      >
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">{{ t('grade') }}: {{ grade.gradeable.value }}</h5>
          <small>{{ shortDateFormat(new Date(grade.created_at)) }}</small>
        </div>
        <p>{{ grade.gradeable.comment || t('grades.no_comment') }}</p>
      </li>
    </ul>
  </div>
</template>
