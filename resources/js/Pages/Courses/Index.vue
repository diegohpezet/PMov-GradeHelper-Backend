<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import CreateCourseForm from './components/CreateCourseForm.vue';
import CourseItemCard from './components/CourseItemCard.vue';

const props = defineProps({ courses: [Object] });

const page = usePage();
const isAdmin = computed(() => page.props.auth.isAdmin);
</script>

<template>
  <h1 class="h2">Courses</h1>

  <details v-if="isAdmin" class="mt-3">
    <summary role="button" class="btn btn-primary text-white">
      <span><i class="ri-add-line"></i>Add new course</span>
    </summary>
    <CreateCourseForm />
  </details>

  <p v-if="!courses.length" class="text-muted">
    There are no courses to show...
  </p>

  <div v-else class="row g-2 mt-2">
    <div v-for="course in courses" :key="course.id" class="col-12 col-lg-6">
      <CourseItemCard :course="course" />
    </div>
  </div>
</template>
