<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import CreateCourseForm from './components/CreateCourseForm.vue';

const props = defineProps({ courses: [Object] });

const page = usePage();
const isAdmin = computed(() => page.props.auth.isAdmin);

const deleteCourse = (id) => {
  if (confirm('Are you sure you want to delete this course?')) {
    router.delete(`/courses/${id}`);
  }
};
</script>

<template>
  <h1 class="h2">Courses</h1>

  <details v-if="isAdmin" class="mt-3">
    <summary role="button" class="btn btn-primary text-white">
      <span><i class="ri-add-line"></i>Add new course</span>
    </summary>
    <CreateCourseForm />
  </details>

  <p v-if="courses.length == 0" class="text-muted">There are no courses to show...</p>

  <div v-else class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 mt-3 g-3">
    <div class="col" v-for="course in courses" :key="course.id">
      <div class="card h-100">
        <div class="card-body row">

          <div class="col">
            <Link :href="`/courses/${course.id}`" class="card-title fs-4">{{ course.name }}</Link>
            <p class="card-text text-muted">{{ course.school_year }}</p>
          </div>

          <div v-if="isAdmin" class="col-auto btn-group text-end">
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
