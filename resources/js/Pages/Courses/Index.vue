<script setup>
import { Link, router } from '@inertiajs/vue3';
import CreateCourseForm from './components/CreateCourseForm.vue';

defineProps({ courses: [Object] });

const editCourse = (id) => {
  
}

const deleteCourse = (id) => {
  if (confirm('Are you sure you want to delete this course?')) {
    router.delete(`/courses/${id}`);
  }
};
</script>

<template>

  <details class="my-3">
    <summary role="button" class="btn btn-primary text-white">
      <span><i class="ri-add-line"></i>Add new course</span>
    </summary>
    <CreateCourseForm />
  </details>

  <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
    <div class="col" v-for="course in courses" :key="course.id">
      <div class="card h-100">
        <div class="card-body row">

          <div class="col">
            <Link :href="`/courses/${course.id}`" class="card-title fs-4">{{ course.name }}</Link>
            <p class="card-text text-muted">{{ course.school_year }}</p>
          </div>

          <div class="col-auto btn-group text-end">
            <button type="button" class="btn dropdown-toggle rounded-circle border my-auto" 
              data-bs-toggle="dropdown" aria-expanded="false">
            </button>

            <ul class="dropdown-menu">
              <li>
                <Link class="dropdown-item" :href="`/courses/${course.id}/edit`">
                  <i class="ri ri-pencil-line"></i>
                  <span>Edit course</span>
                </Link>
              </li>
              <li>
                <button class="dropdown-item" @click="deleteCourse(course.id)">
                  <i class="ri ri-delete-bin-line"></i>
                  <span>Delete course</span>
                </button>
              </li>
            </ul>

          </div>

        </div>
      </div>
    </div>
  </div>
</template>
