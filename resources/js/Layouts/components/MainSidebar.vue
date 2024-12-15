<script setup>
import { Link } from '@inertiajs/vue3';
import LinkList from './LinkList.vue';
</script>

<template>
  <nav class="bg-light rounded border h-100 p-3">
    <Link class="navbar-brand fs-4" href="/">
      <img :src="'assets/images/subjectLogo.png'" alt="Logo" width="30" height="30"
        class="d-inline-block align-text-middle">
      Grade Helper
    </Link>
    <LinkList />
  </nav>
</template>