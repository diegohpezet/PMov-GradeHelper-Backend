<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import { shortDateFormat } from '../../../Utils/dates';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const emit = defineEmits(['deleted']);

const { grade } = defineProps({
  grade: {
    type: Object,
    default: () => null,
  },
});

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

const getGradeToDisplay = (grade) => {
  if (grade.gradeable_type === 'App\\Models\\PassFailGrade') {
    return grade.gradeable.value ? 'Passed' : 'Failed';
  }

  return grade.gradeable.value;
};

function handleDelete(gradeId) {
  if (confirm(t('grades.delete_confirm'))) {
    router.delete(`/gradeables/${gradeId}`, {
      onSuccess: () => emit('deleted', gradeId),
    });
  }
}
</script>

<template>
  <li class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <p class="mb-1">
        {{ grade.gradeable.comment || $t('grades.no_comment') }}
      </p>
      <small>{{ shortDateFormat(new Date(grade.created_at)) }}</small>
    </div>
    <div class="d-flex w-100 justify-content-between">
      <p class="mb-1">Grade: {{ getGradeToDisplay(grade) }}</p>
      <div v-if="isAdmin">
        <button
          class="btn btn-sm btn-outline-danger"
          @click="handleDelete(grade.id)"
        >
          <i class="ri ri-delete-bin-line"></i>
        </button>
        <Link
          :href="`/grades/${grade.id}/edit`"
          class="btn btn-sm btn-outline-warning ms-1"
        >
          <i class="ri ri-pencil-line"></i>
        </Link>
      </div>
    </div>
  </li>
</template>
