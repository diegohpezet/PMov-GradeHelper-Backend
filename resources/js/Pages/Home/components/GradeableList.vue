<script setup>
import { shortDateFormat } from '@/Utils/dates';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps({
  gradeables: { type: Array, required: true },
});
</script>

<template>
  <div v-if="gradeables.length" class="mt-3">
    <h4>{{ t('grades.history') }}</h4>
    <ul class="list-group">
      <li
        class="list-group-item list-group-item-action"
        v-for="gradeable in gradeables"
        :key="gradeable.id"
      >
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">{{ t('grade') }}: {{ gradeable.gradable.value }}</h5>
          <small>{{ shortDateFormat(new Date(gradeable.created_at)) }}</small>
        </div>
        <p>{{ gradeable.gradable.comment || t('grades.no_comment') }}</p>
      </li>
    </ul>
  </div>
</template>
