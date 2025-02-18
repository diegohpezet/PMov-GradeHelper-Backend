<script setup>
import { usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import StudentAssessmentList from './components/StudentAssessmentList.vue';

const { t } = useI18n();

defineProps({
  student: {type: Object, required: false},
});

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
  <h1>
    {{ t('home.greeting', { name: student ? student.first_name : user.name }) }}
  </h1>

  <div v-if="student">
    <a :href="'https://github.com/' + student.github_username + '/plataformas-moviles-entregas'">
      {{ t('home.github_link') }}
    </a>

    <section class="mt-3">
      <StudentAssessmentList :student="student" />
    </section>

    <section class="mt-3">
      
    </section>
  </div>

  <p v-else>{{ t('home.no_student') }}</p>
</template>
