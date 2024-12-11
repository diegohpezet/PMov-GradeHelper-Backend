<script setup>
import { Link, router } from '@inertiajs/vue3';
import CreateStudentForm from './components/CreateStudentForm.vue';

const props = defineProps({ students: [Object] });

const deleteStudent = (id) => {
  if (confirm('Are you sure you want to delete this student?')) {
    router.delete(`/students/${id}`);
  }
}
</script>

<template>
  <h1 class="mb-3">Students</h1>

  <details class="my-3">
    <summary role="button" class="btn btn-primary text-white">
      <span><i class="ri-add-line"></i>Add new Student</span>
    </summary>
    <CreateStudentForm />
  </details>

  <ul class="list-group">
    <li v-for="student in students" :key="student.id" class="list-group-item d-flex justify-content-between">
      <div>
        <h2 class="card-title fs-4"><Link :href="`/students/${student.id}`" class="text-decoration-none text-dark">{{ student.last_name + ' ' + student.first_name }}</Link></h2>
        <p class="card-text text-muted fst-italic">
          {{ student.course.name }} | <a :href="`https://github.com/${student.githubUsername}`">@{{ student.githubUsername }}</a>
        </p>
      </div>

      <div class="btn-group text-end my-auto">
        <Link :href="`/students/${student.id}/edit`" class="btn btn-outline-warning">
          <i class="ri ri-pencil-line"></i>
        </Link>

        <button class="btn btn-outline-danger" @click="deleteStudent(student.id)">
          <i class="ri ri-delete-bin-line"></i>
        </button>
      </div>
    </li>
  </ul>
</template>