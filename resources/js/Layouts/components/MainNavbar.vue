<script setup>
import { usePage } from '@inertiajs/vue3';
import LinkList from './LinkList.vue';

const page = usePage();
const user = page.props.auth.user;
const isAdmin = page.props.auth.isAdmin;

</script>

<template>
  <nav class="navbar navbar-expand-md bg-light rounded border">
    <div class="d-flex w-100 flex-wrap justify-content-between text-align-middle">
      <!-- Header -->
      <div class="d-flex align-items-center">
        <button class="navbar-toggler me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"
          aria-controls="offcanvasMenu" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <h2 class="fs-4 m-0">Dashboard</h2>
      </div>
      <div class="d-flex align-items-center">
        <i v-if="isAdmin" class="ri-presentation-fill fs-4 me-2"></i>
        <i v-else class="ri-graduation-cap-line fs-4 me-2"></i>
        <span class="fs-5 d-none d-md-inline">{{ user.name }}</span>
      </div>

      <!-- Links (for smaller devices) -->
      <div class="offcanvas offcanvas-start d-block d-md-none" tabindex="-1" id="offcanvasMenu"
        aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <LinkList />
        </div>
      </div>

    </div>
  </nav>
</template>

<style scoped>
.dropdown-menu li:hover .dropdown-item {
  background-color: coral;
  color: white
}
</style>