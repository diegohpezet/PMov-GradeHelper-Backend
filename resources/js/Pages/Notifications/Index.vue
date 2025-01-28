<script setup>
import moment from 'moment';
import { onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({ notifications: [Object] })

const calculateTimeAgo = (timestamp) => moment(timestamp).fromNow()

onUnmounted(() => {
  router.put('/notifications/markAsRead')
})
</script>

<template>
  <h1 class="h2 mb-3">Notifications</h1>

  <p v-if="notifications.length == 0">There aren't any notifications to show</p>

  <ul v-else class="list-group list-group-flush border-0">
    <li v-for="notification in notifications" class="list-group-item list-group-item-action">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">{{ notification.data.message }}</h5>
        <small>
          {{ calculateTimeAgo(notification.data.timestamp) }}
          <i v-if="!notification.read_at" class="ri-circle-fill text-primary"></i>
        </small>
      </div>
      <p class="text-muted">{{ notification.data.action_by }}</p>
    </li>
  </ul>
</template>