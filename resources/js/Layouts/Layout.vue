<script setup>
import { Head } from '@inertiajs/vue3';
import MainSidebar from './components/MainSidebar.vue';
import MainNavbar from './components/MainNavbar.vue';
import FooterComponent from './components/FooterComponent.vue';
</script>

<template>
  <Head title="Grade Helper" />
  
  <div class="m-3">
    <div class="row g-3">
      <aside class="d-none d-md-block col-4 col-lg-3 col-xxl-2">
        <MainSidebar />
      </aside>

      <div class="col-12 col-md-8 col-lg-9 col-xxl-10">
        <MainNavbar class="mb-3 p-3" />

        <main class="bg-light border rounded p-3">
          <slot>
            <!-- Page content -->
          </slot>
        </main>

        <FooterComponent />
      </div>
    </div>
  </div>
</template>

<style scoped>
aside {
  min-height: calc(100vh - 2rem);
}
</style>