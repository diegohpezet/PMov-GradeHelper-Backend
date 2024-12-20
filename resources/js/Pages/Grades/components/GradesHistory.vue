<script setup>
import { Link, router } from '@inertiajs/vue3';
defineProps({ student: Object, exercise: Object })

function getGradesForExercise(student, exercise) {
  if (!student || !exercise) return [];
  
  const exerciseGrades = student.grades.find(grade => grade.exercise_id === exercise.id)?.grades;
  return exerciseGrades || [];
}

function deleteGrade(gradeId) {
  router.delete(`/grades/${gradeId}`);
}
</script>

<template>
  <details v-if="student && exercise" class="mb-3">
    <summary role="button">
      <span>History</span>
    </summary>
    <ul>
      <li v-for="grade in getGradesForExercise(student, exercise)" :key="grade.created_at"
        class="d-flex justify-content-between">
        <p>
          {{ new Date(grade.created_at).toLocaleString() }} | {{ grade.result }} | {{ grade.comment }}
        </p>

        <div>
          <button class="btn btn-sm btn-outline-danger" @click="deleteGrade(grade.id)">
            <i class="ri ri-delete-bin-line"></i>
          </button>
          <Link :href="`/grades/${grade.id}/edit`" class="btn btn-sm btn-outline-warning me-2"><i
            class="ri ri-pencil-line"></i></Link>
        </div>
      </li>
    </ul>
  </details>
</template>
