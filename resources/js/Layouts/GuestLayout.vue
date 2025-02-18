<script setup>
import { Link, Head } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Welcome - Grade Helper" />

  <nav class="navbar text-bg-secondary shadow-sm">
    <div class="container-fluid py-2 px-sm-5 d-flex justify-content-between">
      <div>
        <Link class="navbar-brand" href="/">
          <img
            :src="'assets/images/subjectLogo.png'"
            alt="Logo"
            width="30"
            height="30"
            class="d-inline-block align-text-middle"
          />
          Grade Helper
        </Link>
      </div>

      <div>
        <Link class="btn btn-secondary" href="/login">{{ $t('login') }}</Link>
      </div>
    </div>
  </nav>
  <main class="container mt-5">
    <slot>
      <!-- Page content -->
    </slot>
  </main>
</template>
