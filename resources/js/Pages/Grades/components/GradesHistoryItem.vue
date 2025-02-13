<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import { shortDateFormat } from '../../../Utils/dates';

const props = defineProps({ grade: Object });
const emit = defineEmits(['delete-grade']);

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

function deleteGrade(gradeId) {
  if (confirm('Are you sure you want to delete this grade?')) {
    router.delete(`/grades/${gradeId}`, {
      onSuccess: () => emit('delete-grade', gradeId),
    });
  }
}
</script>

<template>
  <li class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <p class="mb-1">
        {{ grade.gradable.comment || 'No comment' }}
      </p>
      <small>{{ shortDateFormat(new Date(grade.created_at)) }}</small>
    </div>
    <div class="d-flex w-100 justify-content-between">
      <p class="mb-1">
        Grade: {{ grade.gradable.value }}
      </p>
      <div v-if="isAdmin">
        <button class="btn btn-sm btn-outline-danger" @click="deleteGrade(grade.id)">
          <i class="ri ri-delete-bin-line"></i>
        </button>
        <Link :href="`/grades/${grade.id}/edit`" class="btn btn-sm btn-outline-warning ms-1">
        <i class="ri ri-pencil-line"></i>
        </Link>
      </div>
    </div>
  </li>
</template>
