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
  <div class="row g-2">
    <!-- Grade Type -->
    <div class="col-12 col-md">
      <div class="form-floating">
        <select
          :id="`grade-type-${formKey}`"
          v-model="model['grade_type']"
          class="form-select"
        >
          <option
            v-for="gradeType in GRADE_TYPES"
            :key="gradeType"
            :value="gradeType"
          >
            {{ $t(`grades.grade_types.${gradeType}`) }}
          </option>
        </select>
        <label :for="`grade-type-${formKey}`">
          {{ $t('grades.field.gradeable_type') }}
        </label>
      </div>
    </div>

    <!-- Grade Result -->
    <div class="col-12 col-md">
      <!-- Numeric Grade -->
      <div
        v-if="model['grade_type'] === GRADE_TYPES.NUMERIC"
        class="form-floating"
      >
        <input
          :id="`grade-number-${formKey}`"
          v-model="model['grade_value']"
          class="form-control"
          type="number"
          :placeholder="$t('grades.field.gradeable_value')"
          min="0"
          max="10"
          step="1"
        />
        <label :for="`grade-number-${formKey}`">
          {{ $t('grades.field.gradeable_value') }}
        </label>
      </div>

      <!-- Pass/Fail -->
      <!-- Pass/Fail -->
      <div v-if="model['grade_type'] === GRADE_TYPES.PASS_FAIL">
        <div class="btn-group btn-group-custom-h w-100" role="group">
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
        <div class="btn-group btn-group-custom-h w-100" role="group">
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
              {{ teOption.name }}
            </label>
          </template>
        </div>
      </div>
    </div>

    <!-- Comment -->
    <div class="col-12">
      <div class="form-floating">
        <textarea
          :id="`comment-${formKey}`"
          v-model="model['comment']"
          class="form-control"
          rows="3"
          :placeholder="$t('grades.field.comment')"
        ></textarea>
        <label :for="`comment-${formKey}`">
          {{ $t('grades.field.comment') }}
        </label>
      </div>
    </div>
  </div>
</template>

<style scoped>
.btn-group-custom-h {
  height: calc(3.5rem + calc(var(--bs-border-width) * 2));
  min-height: calc(3.5rem + calc(var(--bs-border-width) * 2));

  label {
    line-height: 2.8rem;
  }
}
</style>
