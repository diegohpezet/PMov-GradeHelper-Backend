<script setup>
import { Link } from '@inertiajs/vue3';
import GradesStudentsMatrix from '../Grades/Index.vue';

const props = defineProps({ student: Object, exercises: [Object] });
</script>

<template>
  <header class="mb-3 text-center">
    <h1 class="h2">{{ student.last_name + ' ' + student.first_name }}</h1>
    <sub class="text-muted fs-5">
      <p class="mb-4">@{{ student.githubUsername }}</p>
      <!-- <p>Course: <Link :href="`/courses/${student.course.id}`">{{ student.course.name }}</Link></p> -->
    </sub>
  </header>

  <main>
    <GradesStudentsMatrix :students="[student]" :exercises="exercises" />
  </main>
</template>