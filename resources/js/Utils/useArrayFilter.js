import { ref, computed, watchEffect } from 'vue';

export function useArrayFilter({ array = [], filter = null, field = 'id' }) {
    const initialArray = ref(array);
    const currentFilter = ref(filter);

    // update our initialArray if original array changes
    watchEffect(() => {
        initialArray.value = array;
    });

    const filteredArray = computed(() =>
        currentFilter.value
            ? initialArray.value.filter((e) => e[field] === currentFilter.value)
            : initialArray.value,
    );

    const applyFilterFunction = (filterToApply) => {
        currentFilter.value =
            currentFilter.value === filterToApply ? null : filterToApply;
    };

    return [filteredArray, applyFilterFunction, currentFilter];
}
