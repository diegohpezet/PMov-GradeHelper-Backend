<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="list-group list-group-flush">
    <Link 
      class="list-group-item list-group-item-action rounded border-0 mb-1" 
      href="/courses"
      :class="{ 'active': $page.url.startsWith('/courses') }"
    >
      <i class="ri-file-list-3-line me-2"></i>
      Courses
    </Link>

    <Link 
      class="list-group-item list-group-item-action rounded border-0 mb-1" 
      href="/exercises"
      :class="{ 'active': $page.url.startsWith('/exercises') }"
    >
      <i class="ri-question-answer-line me-2"></i>
      Exercises
    </Link>

    <Link 
      class="list-group-item list-group-item-action rounded border-0 mb-1"
      href="/students"
      :class="{ 'active': $page.url.startsWith('/students') }"
    >
      <i class="ri-graduation-cap-line me-2"></i>
      Students
    </Link>

    <Link 
      class="list-group-item list-group-item-action rounded border-0 mb-1" 
      href="/grades"
      :class="{ 'active': $page.url.startsWith('/grades') }"
    >
      <i class="ri-numbers-line me-2"></i>
      Grades
    </Link>
    <hr/>
    <button class="list-group-item list-group-item-action rounded border-0 mb-1 text-start">
      <i class="ri-sun-line me-2"></i>Switch theme
    </button>
    <Link class="list-group-item list-group-item-action rounded border-0 mb-1" href="/logout" method="post">
      <i class="ri-logout-circle-line me-2"></i>Log out
    </Link>
  </div>
</template>