<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({ student: Object });

const userList = ref([]);
const linkedUser = ref(props.student.user_id);

const loadUserList = async () => {
  const response = await fetch('/api/users');
  const data = await response.json();

  userList.value = data;
};

const toggleUserLink = async(user) => {
  const method = linkedUser.value === user.id ? 'DELETE' : 'PUT'
  const response = await fetch(`/api/students/${props.student.id}/users/${user.id}`, { method });

  if (!response.ok) {
    console.error('Failed to link user');
  }

  linkedUser.value = method === 'PUT' ? user.id : null;
}

onMounted(() => {
  loadUserList();
});
</script>

<template>
  <ul class="list-group">
    <li v-for="user in userList" :key="user.id" class="list-group-item d-flex justify-content-between">
      <div>
        <h2 class="card-title fs-5">{{ user.name }}</h2>
        <p class="card-text text-muted fst-italic">{{ user.email }}</p>
      </div>

      <div class="btn-group text-end my-auto">
        <button v-if="linkedUser == user.id" class="btn btn-outline-danger" @click="toggleUserLink(user)">
          <i class="ri ri-delete-bin-line"></i>
        </button>
        <button v-else class="btn btn-outline-primary" @click="toggleUserLink(user)">
          <i v-if="linkedUser" class="ri ri-arrow-left-right-line"></i>
          <i v-else class="ri ri-add-line"></i>
        </button>
      </div>
    </li>
  </ul>
</template>