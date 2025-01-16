<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const isAdmin = computed(() => page.props.auth.isAdmin);

const props = defineProps({ 
  course: Object,
});

const deleteCourse = (id) => {
  if (confirm('Are you sure you want to delete this course?')) {
    router.delete(`/courses/${id}`);
  }
};
</script>

<template>
  <div class="card">
    <div class="card-body">
      <div class="row justify-content-between align-items-center">
        <div class="col" style="position: relative;">
          <Link :href="`/courses/${course.id}`" class="card-title fs-4 stretched-link">{{ course.name }}</Link>
          <p class="card-text text-muted">{{ course.school_year }}</p>        
        </div>
        <div class="col-auto">
          <div class="btn-group">
            <Link
              class="btn btn-outline-secondary" 
              :href="`/courses/${course.id}/edit`"
            >
              <i class="ri ri-pencil-line"></i>
              <span class="visually-hidden">Edit course</span>
            </Link>
            <button
              class="btn btn-outline-danger" 
              @click="deleteCourse(course.id)"
            >
              <i class="ri ri-delete-bin-line"></i>
              <span class="visually-hidden">Delete course</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
