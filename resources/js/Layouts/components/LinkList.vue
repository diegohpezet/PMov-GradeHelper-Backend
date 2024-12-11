<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <ul class="list-group list-group-flush bg-transparent">
      <Link class="list-group-item" href="/courses">
        <span><i class="ri-file-list-3-line me-2"></i>Courses</span>
      </Link>
      <Link class="list-group-item" href="/exercises">
        <span><i class="ri-question-answer-line me-2"></i>Exercises</span>
      </Link>
      <Link class="list-group-item" href="/students">
        <span><i class="ri-graduation-cap-line me-2"></i>Students</span>
      </Link>
      <Link class="list-group-item" href="/grades">
        <span><i class="ri-numbers-line me-2"></i>Grades</span>
      </Link>
      <hr />
      <button class="list-group-item text-start">
        <span><i class="ri-sun-line me-2"></i>Switch theme</span>
      </button>
      <button class="list-group-item text-start">
        <span><i class="ri-logout-circle-line me-2"></i>Log out</span>
      </button>
    </ul>
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