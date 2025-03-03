<script setup>
import { ref, watchEffect } from 'vue';
import GradeablesHistoryItem from './GradeablesHistoryItem.vue';

const { student, exercise } = defineProps({
  student: {
    type: Object,
    default: () => null,
  },
  exercise: {
    type: Object,
    default: () => null,
  },
});

const grades = ref([]);

function handleDeleteGrade(gradeId) {
  grades.value = grades.value.filter((gradeable) => gradeable.id !== gradeId);
}

watchEffect(() => {
  if (student && exercise) {
    grades.value = student.grades.filter(
      (grade) => grade.assessment_id === exercise.assessment.id,
    );
  }
});
</script>

<template>
  <details v-if="student && exercise" class="mb-3">
    <summary role="button">
      <span>{{ $t('grades.history') }}</span>
    </summary>
    <ul class="list-group list-group-flush">
      <GradeablesHistoryItem
        v-for="grade in grades"
        :key="grade.id"
        :grade="grade"
        @deleted="handleDeleteGrade"
      />
    </ul>
  </details>
</template>
