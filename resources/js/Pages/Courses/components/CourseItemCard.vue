<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import CourseAdminActions from './CourseAdminActions.vue';

const page = usePage();
const isAdmin = computed(() => page.props.auth.isAdmin);

const { course } = defineProps({
  course: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div class="card">
    <div class="card-body">
      <div class="row justify-content-between align-items-center">
        <div class="col" style="position: relative">
          <Link
            :href="`/courses/${course.id}`"
            class="card-title fs-4 stretched-link"
            >{{ course.name }}</Link
          >
          <p class="card-text text-muted">
            {{ course.school_year }}
            <span v-if="course.description"> | {{ course.description }}</span>
          </p>
        </div>
        <CourseAdminActions v-if="isAdmin" class="col-auto" :course="course" />
      </div>
    </div>
  </div>
</template>
