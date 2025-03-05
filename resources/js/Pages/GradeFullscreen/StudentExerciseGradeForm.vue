<script setup>
import { watch } from 'vue';
const { formKey } = defineProps({
  formKey: {
    type: String,
    required: true,
  },
});
const model = defineModel({
  type: Object,
  required: true,
});

// reset grade_value when grade_type changes
watch(
  () => model.value.grade_type,
  () => {
    model.value.grade_value = '';
  },
);

const GRADE_TYPES = {
  PASS_FAIL: 'PassFailGrade',
  NUMERIC: 'NumericGrade',
  TEG: 'TEGrade',
};

const TYPE_TE_OPTIONS = {
  TEA: {
    name: 'TEA',
    label: 'grades.results.tea',
    class: 'btn-outline-success',
  },
  TEP: {
    name: 'TEP',
    label: 'grades.results.tep',
    class: 'btn-outline-warning',
  },
  TED: {
    name: 'TED',
    label: 'grades.results.ted',
    class: 'btn-outline-danger',
  },
};
</script>

<template>
  <!-- Comment -->
  <div class="mb-3">
    <label :for="`comment-${formKey}`" class="form-label">Comment</label>
    <input
      :id="`comment-${formKey}`"
      v-model="model['comment']"
      type="text"
      class="form-control"
    />
  </div>

  <!-- Grade Type -->
  <div class="mb-3">
    <label :for="`grade-type-${formKey}`" class="form-label">Type</label>
    <select
      :id="`grade-type-${formKey}`"
      v-model="model['grade_type']"
      class="form-select"
    >
      <option disabled selected value="">
        {{ $t('grades.select_grade_type') }}
      </option>
      <option
        v-for="gradeType in GRADE_TYPES"
        :key="gradeType"
        :value="gradeType"
      >
        {{ $t(gradeType) }}
      </option>
    </select>
  </div>

  <!-- Grade Value -->
  <div class="mb-3">
    <!-- Pass/Fail -->
    <div v-if="model['grade_type'] === GRADE_TYPES.PASS_FAIL">
      <div class="btn-group w-100" role="group">
        <input
          :id="`grade-passfail-pass-${formKey}`"
          v-model="model['grade_value']"
          type="radio"
          class="btn-check"
          :name="`grade-passfail-${formKey}`"
          :value="true"
          autocomplete="off"
        />
        <label
          class="btn btn-outline-success"
          :for="`grade-passfail-pass-${formKey}`"
        >
          {{ $t('grades.results.passed') }}
        </label>

        <input
          :id="`grade-passfail-fail-${formKey}`"
          v-model="model['grade_value']"
          type="radio"
          class="btn-check"
          :name="`grade-passfail-${formKey}`"
          :value="false"
          autocomplete="off"
        />
        <label
          class="btn btn-outline-danger"
          :for="`grade-passfail-fail-${formKey}`"
        >
          {{ $t('grades.results.failed') }}
        </label>
      </div>
    </div>

    <!-- TE Grade -->
    <div v-if="model['grade_type'] === GRADE_TYPES.TEG">
      <div class="btn-group w-100" role="group">
        <template v-for="teOption in TYPE_TE_OPTIONS" :key="teOption.name">
          <input
            :id="`grade-te-${teOption.name}-${formKey}`"
            v-model="model['grade_value']"
            type="radio"
            class="btn-check"
            :name="`grade-te-${formKey}`"
            :value="teOption.name"
            autocomplete="off"
          />
          <label
            class="btn"
            :class="teOption.class"
            :for="`grade-te-${teOption.name}-${formKey}`"
          >
            {{ $t(teOption.label) }}
          </label>
        </template>
      </div>
    </div>

    <!-- Numeric Grade -->
    <div v-if="model['grade_type'] === GRADE_TYPES.NUMERIC">
      <label :for="`grade-number-${formKey}`" class="form-label">
        {{ $t('grades.result') }}
      </label>
      <input
        :id="`grade-number-${formKey}`"
        v-model="model['grade_value']"
        class="form-control"
        type="number"
        min="0"
        max="10"
        step="1"
      />
    </div>
  </div>
</template>

<style scoped></style>
