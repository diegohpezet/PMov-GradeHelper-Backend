<script setup>
import ExerciseRow from './components/ExerciseRow.vue';

const props = defineProps({ 
  student: Object, 
});
</script>

<template>
  <header class="mb-3 text-center">
    <h1 class="fs-4 m-0">{{ student.last_name + ' ' + student.first_name }}</h1>
    <p class="fs-5 text-muted">
      @{{ student.githubUsername }}
    </p>
  </header>
  <main>
    <ExerciseRow
      v-for="exercise in student.course.exercises" 
      :key="exercise.id"
      :exercise="exercise"
    />
  </main>
</template>