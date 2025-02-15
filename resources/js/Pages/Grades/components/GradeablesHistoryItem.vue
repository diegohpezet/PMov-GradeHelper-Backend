<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import { shortDateFormat } from '../../../Utils/dates';

const props = defineProps({ gradeable: Object });
const emit = defineEmits(['delete-gradeable']);

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

const handleGradeableValue = (gradeable) => {
  if (gradeable.gradable_type === 'App\\Models\\PassFailGrade') {
    return gradeable.gradable.value ? 'Passed' : 'Failed';
  }

  return gradeable.gradable.value;
}

function deleteGradeable(gradeableId) {
  if (confirm('Are you sure you want to delete this grade?')) {
    router.delete(`/gradeables/${gradeableId}`, {
      onSuccess: () => emit('delete-gradeable', gradeableId),
    });
  }
}
</script>

<template>
  <li class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <p class="mb-1">
        {{ gradeable.gradable.comment || 'No comment' }}
      </p>
      <small>{{ shortDateFormat(new Date(gradeable.created_at)) }}</small>
    </div>
    <div class="d-flex w-100 justify-content-between">
      <p class="mb-1">
        Grade: {{ handleGradeableValue(gradeable) }}
      </p>
      <div v-if="isAdmin">
        <button class="btn btn-sm btn-outline-danger" @click="deleteGradeable(gradeable.id)">
          <i class="ri ri-delete-bin-line"></i>
        </button>
        <Link :href="`/gradeables/${gradeable.id}/edit`" class="btn btn-sm btn-outline-warning ms-1">
        <i class="ri ri-pencil-line"></i>
        </Link>
      </div>
    </div>
  </li>
</template>
