<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import CreateExerciseForm from './components/CreateExerciseForm.vue';
import { useI18n } from 'vue-i18n'

const { t } = useI18n() ;
defineProps({ exercises: [Object] });

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

const deleteExercise = (id) => {
  if (confirm(t('exercises.delete_confirm'))) {
    router.delete(`/exercises/${id}`);
  }
}
</script>

<template>
  <h1 class="h2">{{ $t('exercises') }}</h1>

  <details v-if="isAdmin" class="my-3">
    <summary role="button" class="btn btn-primary text-white">
      <span><i class="ri-add-line"></i>{{ $t('exercises.add') }}</span>
    </summary>
    <CreateExerciseForm />
  </details>

  <p v-if="!exercises.length" class="text-muted">{{ $t('exercises.empty') }}</p>

  <ul v-else class="list-group">
    <li v-for="exercise in exercises" :key="exercise.id" class="list-group-item d-flex justify-content-between">
      <div>
        <h2 class="card-title fs-4">{{ exercise.title }}</h2>
        <p class="card-text text-muted fst-italic">/{{ exercise.path }}</p>
        <p v-if="exercise.courses.length > 0" class="card-text text-muted">
          {{ $t('exercises.assigned') }} {{ exercise.courses.map(c => c.name).join(', ') }}
        </p>
      </div>

      <div v-if="isAdmin" class="btn-group text-end my-auto">
        <Link
          :href="`/exercises/${exercise.id}/edit`"
          class="btn btn-outline-secondary"
          :title="$t('exercises.edit')"
        >
          <i class="ri ri-pencil-line"></i>
        </Link>

        <button
          class="btn btn-outline-danger"
          :title="$t('exercises.delete')"
          @click="deleteExercise(exercise.id)"
        >
          <i class="ri ri-delete-bin-line"></i>
        </button>
      </div>
    </li>
  </ul>
</template>
