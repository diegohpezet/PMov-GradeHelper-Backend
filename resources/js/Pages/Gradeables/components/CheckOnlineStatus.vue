<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
  studentUsername: String,
  exercisePath: String
})

const onlineStatus = ref(undefined)
const address = `https://${props.studentUsername}.github.io/plataformas-moviles-entregas/${props.exercisePath}`

const isOnline = (address) => {
  return fetch(address)
    .then(() => true)
    .catch(() => false)
}

onMounted(async () => {
  onlineStatus.value = await isOnline(address)
})
</script>

<template>
  <span v-if="onlineStatus"><i class="ri-circle-fill found"></i></span>
  <span v-else><i class="ri-circle-fill not-found"></i></span>
</template>

<style scoped>
.not-found {
  color: rgb(202, 79, 79);
}

.found {
  color: rgb(76, 181, 76);
}
</style>