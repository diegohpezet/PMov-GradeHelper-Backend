<script setup>
import MainSidebar from './components/MainSidebar.vue';
import MainNavbar from './components/MainNavbar.vue';
import FooterComponent from './components/FooterComponent.vue';
</script>

<template>
  <div class="row g-0 min-vh-100">
    <aside class="d-none d-md-block col-md-4 col-lg-3 col-xxl-2">
      <MainSidebar />
    </aside>
    
    <div class="col">
      <header>
        <MainNavbar />
      </header>
      
      <main class="bg-light m-2 m-sm-3 p-3 p-lg-5 border rounded">
        <slot>
          <!-- Page content -->
        </slot>
      </main>
      
      <FooterComponent />
    </div>
  </div>
</template>