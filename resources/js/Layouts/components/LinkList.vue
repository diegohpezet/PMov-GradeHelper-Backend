<script setup>
import { Link } from '@inertiajs/vue3';

const toggleTheme = () => {
  const currentTheme = document.documentElement.dataset?.bsTheme || 'light';
  const newTheme = currentTheme === 'light' ? 'dark' : 'light';
  document.documentElement.dataset.bsTheme = newTheme;
  localStorage.setItem('userTheme', newTheme);
};
</script>

<template>
  <div class="list-group list-group-flush">
    <Link
      class="list-group-item list-group-item-action rounded border-0 mb-1"
      href="/courses"
      :class="{ active: $page.url.startsWith('/courses') }"
    >
      <i class="ri-file-list-3-line me-2"></i>
      {{ $t('courses') }}
    </Link>

    <Link
      class="list-group-item list-group-item-action rounded border-0 mb-1"
      href="/exercises"
      :class="{ active: $page.url.startsWith('/exercises') }"
    >
      <i class="ri-question-answer-line me-2"></i>
      {{ $t('exercises') }}
    </Link>

    <Link
      class="list-group-item list-group-item-action rounded border-0 mb-1"
      href="/students"
      :class="{ active: $page.url.startsWith('/students') }"
    >
      <i class="ri-graduation-cap-line me-2"></i>
      {{ $t('students') }}
    </Link>

    <hr />
    <button class="list-group-item text-start" @click="toggleTheme">
      <i class="ri-sun-line me-2"></i>
      {{ $t('switch_theme') }}
    </button>
    <Link
      class="list-group-item list-group-item-action rounded border-0 mb-1"
      href="/logout"
      method="post"
    >
      <i class="ri-logout-circle-line me-2"></i>
      {{ $t('logout') }}
    </Link>
  </div>
</template>
