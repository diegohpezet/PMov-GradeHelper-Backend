<script setup>
import { ref, watchEffect } from 'vue';
import GradeablesHistoryItem from './GradeablesHistoryItem.vue';

const props = defineProps({ student: Object, assessment: Object });

const gradeables = ref([]);

function removeGradeable(gradeableId) {
  gradeables.value = gradeables.value.filter(
    (gradeable) => gradeable.id !== gradeableId,
  );
}

watchEffect(() => {
  if (props.student && props.assessment) {
    gradeables.value = props.student.gradeables.filter(
      (grade) => grade.assessment_id === props.assessment.id,
    );
  }
});
</script>

<template>
  <details v-if="student && assessment" class="mb-3">
    <summary role="button">
      <span>{{ $t('grades.history') }}</span>
    </summary>
    <ul class="list-group list-group-flush">
      <GradeablesHistoryItem
        v-for="gradeable in gradeables"
        :key="gradeable.created_at"
        :gradeable="gradeable"
        @delete-gradeable="removeGradeable"
      />
    </ul>
  </details>
</template>
