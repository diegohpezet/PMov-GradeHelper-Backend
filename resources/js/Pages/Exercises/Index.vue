<script setup>
import { Link, router } from '@inertiajs/vue3';
import CreateExerciseForm from './components/CreateExerciseForm.vue';

defineProps({ exercises: [Object] });

const deleteExercise = (id) => {
  if (confirm('Are you sure you want to delete this exercise?')) {
    router.delete(`/exercises/${id}`);
  }
}
</script>

<template>
  <h1 class="h2">Exercises</h1>

  <details class="my-3">
    <summary role="button" class="btn btn-primary text-white">
      <span><i class="ri-add-line"></i>Add new Exercise</span>
    </summary>
    <CreateExerciseForm />
  </details>

  <ul class="list-group">
    <li v-for="exercise in exercises" :key="exercise.id" class="list-group-item d-flex justify-content-between">
      <div>
        <h2 class="card-title fs-4">{{ exercise.title }}</h2>
        <p class="card-text text-muted fst-italic">/{{ exercise.path }}</p>
      </div>

      <div class="btn-group text-end my-auto">
        <Link :href="`/exercises/${exercise.id}/edit`" class="btn btn-outline-warning">
          <i class="ri ri-pencil-line"></i>
        </Link>

        <button class="btn btn-outline-danger" @click="deleteExercise(exercise.id)">
          <i class="ri ri-delete-bin-line"></i>
        </button>
      </div>
    </li>
  </ul>
</template>