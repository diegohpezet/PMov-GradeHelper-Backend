<script setup>
import ExerciseRow from './components/ExerciseRow.vue';

defineProps({ student: { type: Object, required: true, default: () => ({}) } });
</script>

<template>
  <header class="mb-3 text-center">
    <h1 class="fs-4 m-0">{{ student.last_name + ' ' + student.first_name }}</h1>
    <p class="fs-5 text-muted">@{{ student.github_username }}</p>
  </header>
  <main>
    <ExerciseRow
      v-for="assessment in student.course.assessments"
      :key="assessment.id"
      :assessment="assessment"
      :student-id="student.id"
    />
  </main>
</template>
