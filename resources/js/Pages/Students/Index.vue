<script setup>
import { ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import CreateStudentForm from './components/CreateStudentForm.vue';
import LinkStudentList from './components/LinkStudentList.vue';
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

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

const deleteStudent = (id) => {
  if (confirm(t('students.delete_confirm'))) {
    router.delete(`/students/${id}`);
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
        {{ field }}
      </button>
    </div>
  </div>

  <details v-if="isAdmin" class="my-3">
    <summary role="button" class="btn btn-primary text-white">
      <span><i class="ri-add-line"></i>{{ $t('students.add') }}</span>
    </summary>
    <CreateStudentForm />
  </details>

  <p v-if="!sortedStudents.length" class="text-muted">
    {{ $t('students.empty') }}
  </p>

  <ul v-else class="list-group">
    <li
      v-for="student in sortedList(students)"
      :key="student.id"
      class="list-group-item list-group-item-action d-flex justify-content-between"
    >
      <div>
        <Link
          :href="`/students/${student.github_username}`"
          class="card-title fs-4"
        >
          {{ student.last_name + ', ' + student.first_name }}
        </Link>
        <p class="card-text text-muted fst-italic">
          {{ student.course ? student.course.name : 'No course' }} |
          <a :href="`https://github.com/${student.github_username}`"
            >@{{ student.github_username }}</a
          >

          <button
            v-if="isAdmin"
            class="btn btn-sm btn-outline-primary ms-2 rounded-circle"
            @click="openLinkModal(student)"
          >
            <i v-if="!student.user_id" class="ri ri-link"></i>
            <i v-else class="ri-arrow-left-right-line"></i>
          </button>
        </p>
      </div>

      <div v-if="isAdmin" class="btn-group text-end my-auto">
        <Link
          class="btn btn-outline-secondary"
          :href="`/students/${student.id}/edit`"
          :title="$t('students.edit')"
        >
          <i class="ri ri-pencil-line"></i>
        </Link>

        <button
          class="btn btn-outline-danger"
          :title="$t('students.delete')"
          @click="deleteStudent(student.id)"
        >
          <i class="ri ri-delete-bin-line"></i>
        </button>
      </div>
    </li>
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
