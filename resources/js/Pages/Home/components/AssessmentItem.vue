<script setup>
import { shortDateFormat } from '@/Utils/dates';
import { useI18n } from 'vue-i18n';
import CheckOnlineStatus from '../../Gradeables/components/CheckOnlineStatus.vue';
import GradeableList from './GradeableList.vue';

const { t } = useI18n();

defineProps({
  student: { type: Object, required: true },
  assessment: { type: Object, required: true },
});
</script>

<template>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button
        class="accordion-button"
        type="button"
        data-bs-toggle="collapse"
        :data-bs-target="`#collapse-${assessment.id}`"
        aria-expanded="false"
        :aria-controls="`collapse-${assessment.id}`"
      >
        <CheckOnlineStatus
          :studentUsername="student.github_username"
          :exercisePath="assessment.exercise.path"
          class="me-2"
        />
        {{ assessment.exercise.title }}
      </button>
    </h2>
    <div
      :id="`collapse-${assessment.id}`"
      class="accordion-collapse collapse show"
      data-bs-parent="#assessmentsAccordion"
    >
      <div class="accordion-body">
        <span class="fs-italic">
          {{ t('exercises.field.due_at') }}:
          {{ shortDateFormat(new Date(assessment.due_at)) }}
        </span>

        <GradeableList :gradeables="assessment.gradeables" />
      </div>
    </div>
  </div>
</template>
