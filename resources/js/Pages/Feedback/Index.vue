<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

defineProps({
    feedbacks: Array,
})



const deleteFeedback = (id) => {
    if (confirm('Are you sure you want to delete this feedback?')) {
        router.delete(route('feedbacks.destroy', id), {
            preserveScroll: true,
        });
    }
}

const restoreFeedback = (id) => {
    router.post(route('feedbacks.restore', id), {
        preserveScroll: true,
    })
}
</script>


<template>

    <AppLayout title="Feedbacks">


        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Feedbacks
            </h2>
        </template>


        <div class="px-12">
            <div v-if="$page.props.flash.success"
                class=" m-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert"> {{
                    $page.props.flash.success }}</div>

            <div v-for="feedback in feedbacks" :key="feedback.id"
                class="m-4 bg-white border border-400 text-700 px-4 py-3 rounded relative">

                <ul>
                    <li v-if="feedback.user_id">User:{{ feedback.user.name }} </li>
                    <li>Email: {{ feedback.user_id ? feedback.user.email : feedback.email }} </li>
                    <li>MESSAGE{{ feedback.message }}</li>
                    <li>CREATED AT: {{ new Date(feedback.created_at).toLocaleString() }}</li>
                    <li>SOURCE: {{ feedback.source }}</li>
                    <li v-if="feedback.deleted_at" class="text-red-500 font-bold">DELETED AT: {{ new
                        Date(feedback.deleted_at).toLocaleString() }}</li>
                </ul>

                <button v-if="!feedback.deleted_at" @click="deleteFeedback(feedback.id)"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>

                <button v-if="feedback.deleted_at" @click="restoreFeedback(feedback.id)"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Restore</button>

            </div>



        </div>

    </AppLayout>


</template>
