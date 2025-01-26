<script setup>
import { Link } from '@inertiajs/vue3';

const toggleTheme = () => {
  const currentTheme = document.documentElement.dataset?.bsTheme || 'light';
  const newTheme = currentTheme === 'light' ? 'dark' : 'light';
  document.documentElement.dataset.bsTheme = newTheme;
};

</script>

<template>
  <div class="list-group list-group-flush">
    <Link class="list-group-item" href="/courses">
      <i class="ri-file-list-3-line me-2"></i>
      Courses
    </Link>
    <Link class="list-group-item" href="/exercises">
      <i class="ri-question-answer-line me-2"></i>
      Exercises
    </Link>
    <Link class="list-group-item" href="/students">
      <i class="ri-graduation-cap-line me-2"></i>
      Students
    </Link>
    <Link class="list-group-item" href="/grades">
      <i class="ri-numbers-line me-2"></i>
      Grades
    </Link>
    <hr/>
    <button class="list-group-item text-start" @click="toggleTheme">
      <i class="ri-sun-line me-2"></i>Switch theme
    </button>
    <Link class="list-group-item text-start" href="/logout" method="post">
      <i class="ri-logout-circle-line me-2"></i>Log out
    </Link>
  </div>
</template>

<style scoped>
  .list-group-item {
    background: transparent;
    border: none;
    border-radius: .5rem;
  }
  .list-group-item:hover {
    background-color: coral;
    color: white;
  }
</style>