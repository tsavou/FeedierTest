<template>

    <div class="flex items-center">

        <div v-for="star in 5" :key="star">

            <svg
        @mouseover="setHoverRating(star)"
        @mouseleave="resetHoverRating"
        @click="setRating(star)"
        :class="[
          readonly ? 'cursor-default' : 'cursor-pointer',
          star <= hoverRating || (!hoverRating && star <= currentRating) ? 'text-yellow-500' : 'text-gray-300'
        ]"
        xmlns="http://www.w3.org/2000/svg"
        fill="currentColor"
        viewBox="0 0 24 24"
        class="h-6 w-6"
      >
        <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.831 1.463 8.259-7.399-3.902-7.399 3.902 1.463-8.259-6.064-5.831 8.332-1.151z" />
      </svg>


        </div>


    </div>

</template>

<script setup>

import { ref } from 'vue';

const props = defineProps({
    readonly: {
        type: Boolean,
        default: false
    },
    value: {
        type: Number,
        default: 0
    },

});


const hoverRating = ref(0);
const currentRating = ref(props.value);

const setHoverRating = (star) => {
    if (!props.readonly) {
        hoverRating.value = star;
    }
};

const resetHoverRating = () => {
    hoverRating.value = 0;
};

const emit = defineEmits(['update:value']);

const setRating = (star) => {
    if (!props.readonly) {
        currentRating.value = star;

        emit('update:value', currentRating.value);
    }
};






</script>


