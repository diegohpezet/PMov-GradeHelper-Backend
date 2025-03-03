<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import CreateStudentForm from './components/CreateStudentForm.vue';
import LinkStudentList from './components/LinkStudentList.vue';
import StudentListItem from './components/StudentListItem.vue';
import StudentSearchInput from './components/StudentSearchInput.vue';
import BaseModal from '../../Layouts/components/BaseModal.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const { students } = defineProps({
  students: {
    type: Array,
    default: () => [],
  },
});

const SORT_FIELDS = ['first_name', 'last_name'];
const sortField = ref(SORT_FIELDS[0]);
const sortInvert = ref(false);

const sortedList = (list) => {
  return [...list].sort((a, b) => {
    const aValue = a[sortField.value];
    const bValue = b[sortField.value];
    const result = `${aValue}`.localeCompare(`${bValue}`);
    return sortInvert.value ? -result : result;
  });
};

const handleSelectSort = (selected) => {
  if (sortField.value === selected) {
    sortInvert.value = !sortInvert.value;
  } else {
    sortField.value = selected;
    sortInvert.value = false;
  }
};

const filteredStudents = ref([...students]);

const handleSearch = (query) => {
  filteredStudents.value = students.filter((student) => {
    return (
      student.first_name.toLowerCase().includes(query.toLowerCase()) ||
      student.last_name.toLowerCase().includes(query.toLowerCase())
    );
  });
};

const page = usePage();
const isAdmin = page.props.auth.isAdmin;
const course = page.props.course;

const deleteStudent = (student) => {
  if (confirm(t('students.delete_confirm'))) {
    router.delete(`/students/${student.id}`);
  }
};

const isModalOpen = ref(false);
const currentStudent = ref(null);

const openLinkModal = (student) => {
  currentStudent.value = student;
  isModalOpen.value = true;
};
</script>

<template>
  <div class="d-flex align-items-center justify-content-between">
    <h1 class="h2">{{ $t('students') }}</h1>
    <div class="btn-group" role="group">
      <button
        v-for="field in SORT_FIELDS"
        :key="field"
        class="btn btn-sm btn-outline-primary"
        :class="{ active: sortField === field }"
        @click="handleSelectSort(field)"
      >
        <span v-if="sortField === field">
          {{ sortInvert ? '↑' : '↓' }}
        </span>
        {{ $t(`students.field.${field}`) }}
      </button>
    </div>
  </div>

  <details v-if="isAdmin" class="my-3">
    <summary role="button" class="btn btn-primary text-white">
      <span><i class="ri-add-line"></i>{{ $t('students.add') }}</span>
    </summary>
    <CreateStudentForm :course="course" class="my-3" />
  </details>

  <StudentSearchInput @search="handleSearch" />

  <p v-if="!filteredStudents.length" class="text-muted">
    {{ $t('students.empty') }}
  </p>

  <ul v-else class="list-group">
    <StudentListItem
      v-for="student in sortedList(filteredStudents)"
      :key="student.id"
      :student="student"
      :is-admin="isAdmin"
      @link="openLinkModal(student)"
      @delete="deleteStudent(student)"
    />
  </ul>

  <BaseModal v-if="isModalOpen" @close="isModalOpen = false">
    <template #header>
      <h3 class="fs-4">{{ $t('students.link_to_user') }}</h3>
    </template>

    <LinkStudentList :student="currentStudent" />

    <template #footer>
      <div class="d-flex justify-content-end">
        <button class="btn btn-secondary" @click="isModalOpen = false">
          {{ $t('close') }}
        </button>
      </div>
    </template>
  </BaseModal>
</template>
