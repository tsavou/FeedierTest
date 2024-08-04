<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FeedbackCard from '@/Components/FeedbackCard.vue';

defineProps({
    feedbacks: Array,
})

</script>


<template>

    <AppLayout title="Feedbacks">


        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Feedbacks
            </h2>
        </template>


        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div v-if="$page.props.flash.success"
                class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert"> {{
                    $page.props.flash.success }}</div>


            <div class="grid lg:grid-cols-2 gap-4 ">
                <FeedbackCard v-for="feedback in feedbacks" :feedback="feedback" />
            </div>

        </div>

    </AppLayout>


</template>
