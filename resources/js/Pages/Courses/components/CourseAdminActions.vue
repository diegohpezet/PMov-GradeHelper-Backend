<script setup>
import { Link, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const { course } = defineProps({
  course: {
    type: Object,
    required: true,
  },
});

const deleteCourse = (id) => {
  if (confirm(t('courses.delete_confirm'))) {
    router.delete(`/courses/${id}`);
  }
};
</script>

<template>
  <div class="btn-group">
    <Link
      class="btn btn-outline-secondary"
      :title="$t('courses.edit')"
      :href="`/courses/${course.id}/edit`"
    >
      <i class="ri ri-pencil-line"></i>
    </Link>
    <button
      class="btn btn-outline-danger"
      :title="$t('courses.delete')"
      @click="deleteCourse(course.id)"
    >
      <i class="ri ri-delete-bin-line"></i>
    </button>
  </div>
</template>
