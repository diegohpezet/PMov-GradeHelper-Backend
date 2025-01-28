<script setup>
import { ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import CreateStudentForm from './components/CreateStudentForm.vue';
import LinkStudentList from './components/LinkStudentList.vue';
import BaseModal from '../../Layouts/components/BaseModal.vue';

const props = defineProps({ students: [Object] });

const sortedStudents = props.students.sort((a, b) => a.last_name.localeCompare(b.last_name));

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

const deleteStudent = (id) => {
  if (confirm('Are you sure you want to delete this student?')) {
    router.delete(`/students/${id}`);
  }
}

const isModalOpen = ref(false);
const currentStudent = ref(null);

const openLinkModal = (student) => {
  currentStudent.value = student;
  isModalOpen.value = true;
};
</script>

<template>
  <h1 class="fs-2">Students</h1>

  <details v-if="isAdmin" class="my-3">
    <summary role="button" class="btn btn-primary text-white">
      <span><i class="ri-add-line"></i>Add new Student</span>
    </summary>
    <CreateStudentForm />
  </details>

  <ul class="list-group">
    <li v-for="student in sortedStudents" :key="student.id" class="list-group-item d-flex justify-content-between">
      <div>
        <h2 class="card-title fs-4">
          <Link :href="`/students/${student.githubUsername}`" class="text-decoration-none text-dark">
            {{ student.last_name + ' ' + student.first_name }}
          </Link>
        </h2>
        <p class="card-text text-muted fst-italic">
          {{ student.course ? student.course.name : 'No course' }} | <a :href="`https://github.com/${student.githubUsername}`">@{{
            student.githubUsername }}</a>

          <button v-if="isAdmin" class="btn btn-sm btn-outline-primary ms-2 rounded-circle" @click="openLinkModal(student)">
            <i v-if="!student.user_id" class="ri ri-link"></i>
            <i v-else class="ri-arrow-left-right-line"></i>
          </button>
        </p>
      </div>

      <div v-if="isAdmin" class="btn-group text-end my-auto">
        <Link :href="`/students/${student.id}/edit`" class="btn btn-outline-warning">
          <i class="ri ri-pencil-line"></i>
        </Link>

        <button class="btn btn-outline-danger" @click="deleteStudent(student.id)">
          <i class="ri ri-delete-bin-line"></i>
        </button>
      </div>
    </li>
  </ul>

  <BaseModal v-if="isModalOpen" @close="isModalOpen = false">
    <template #header>
      <h3 class="fs-4">Link student to user</h3>
    </template>
    
    <LinkStudentList :student="currentStudent" />

    <template #footer>
      <div class="d-flex justify-content-end">
        <button class="btn btn-secondary" @click="isModalOpen = false">Close</button>
      </div>
    </template>
  </BaseModal>
</template>