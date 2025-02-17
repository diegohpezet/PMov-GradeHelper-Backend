<script setup>
import { ref, watchEffect } from 'vue';
import GradesHistoryItem from './GradesHistoryItem.vue';

const props = defineProps({ student: Object, assessment: Object });

const gradeables = ref([]);

function removeGrade(gradeId) {
  gradeables.value = gradeables.value.filter(grade => grade.id !== gradeId);
}

watchEffect(() => {
  if (props.student && props.assessment) {
    gradeables.value = props.student.gradeables.filter(grade => grade.assessment_id === props.assessment.id);
  }
});
</script>

<template>
  <details v-if="student && assessment" class="mb-3">
    <summary role="button">
      <span>History</span>
    </summary>
    <ul class="list-group list-group-flush">
      <GradesHistoryItem 
        v-for="grade in gradeables" 
        :key="grade.created_at"
        :grade="grade"
        @delete-grade="removeGrade"
      />
    </ul>
  </details>
</template>
