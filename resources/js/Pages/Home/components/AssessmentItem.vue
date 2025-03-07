<script setup>
import { shortDateFormat } from '@/Utils/dates';
import { useI18n } from 'vue-i18n';
import CheckOnlineStatus from '../../Gradeables/components/CheckOnlineStatus.vue';
import GradeList from './GradeList.vue';

const { t } = useI18n();

const { student, exercise } = defineProps({
  student: { type: Object, required: true },
  exercise: { type: Object, required: true },
});

const gradesForExercise = (exercise) =>
  student.grades.filter((g) => g.assessment_id === exercise.assessment.id);
</script>

<template>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button
        class="accordion-button collapsed"
        type="button"
        data-bs-toggle="collapse"
        :data-bs-target="`#collapse-${exercise.id}`"
        aria-expanded="false"
        :aria-controls="`collapse-${exercise.id}`"
      >
        <CheckOnlineStatus
          :student-username="student.github_username"
          :exercise-path="exercise.path"
          class="me-2"
        />
        {{ exercise.title }}
      </button>
    </h2>
    <div
      :id="`collapse-${exercise.id}`"
      class="accordion-collapse collapse"
      data-bs-parent="#assessmentsAccordion"
    >
      <div class="accordion-body">
        <span class="fs-italic">
          {{ t('exercises.field.due_at') }}:
          {{ shortDateFormat(new Date(exercise.assessment.due_at)) }}
        </span>

        <GradeList :grades="gradesForExercise(exercise)" />
      </div>
    </div>
  </div>
</template>
