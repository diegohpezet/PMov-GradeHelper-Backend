<script setup>
import { Link } from '@inertiajs/vue3';
import { defineEmits } from 'vue';

const emit = defineEmits(['link', 'edit', 'delete']);

const { student } = defineProps({
  student: {
    type: Object,
    required: true,
  },
  isAdmin: {
    type: Boolean,
    default: false,
  },
});

const handleLink = () => {
  emit('link', student);
};
const handleDelete = () => {
  emit('delete', student);
};
</script>

<template>
  <li
    class="list-group-item list-group-item-action d-flex justify-content-between"
  >
    <div class="row">
      <div class="col align-self-center">
        <img
          v-if="student.github_username"
          :src="
            'https://avatars.githubusercontent.com/' + student.github_username
          "
          class="profile-picture me-2"
        />
        <i
          v-else
          class="ri-user-3-line profile-picture fs-2 p-2 me-2 border"
        ></i>
      </div>
    </div>
    <div class="col">
      <Link
        :href="`/students/${student.github_username}`"
        class="card-title fs-4"
      >
        {{ student.last_name + ', ' + student.first_name }}
      </Link>
      <p class="card-text text-muted fst-italic">
        <span>{{ student.course ? student.course.name : 'No course' }}</span>

        <template v-if="student.github_username">
          |
          <a :href="`https://github.com/${student.github_username}`"
            >@{{ student.github_username }}</a
          >
        </template>

        <button
          v-if="isAdmin"
          class="btn btn-sm btn-outline-primary ms-2 rounded-circle"
          @click="handleLink"
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
        @click="handleDelete"
      >
        <i class="ri ri-delete-bin-line"></i>
      </button>
    </div>
  </li>
</template>

<style scoped>
.profile-picture {
  width: 50px;
  height: 50px;
  border-radius: 50%;
}
</style>
