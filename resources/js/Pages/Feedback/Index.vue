<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

defineProps({
    feedbacks: Array,
    })



const deleteFeedback = (id) => {
    if (confirm('Are you sure you want to delete this feedback?')) {
        router.delete(route('feedbacks.destroy', id),{
            preserveScroll: true,
        });
    }
}
</script>


<template>

    <AppLayout title="Feedbacks">
 <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert"> {{ $page.props.flash.success }}</div>

        <div v-for="feedback in feedbacks" :key="feedback.id">
            <div>

                <ul>
                    <li v-if="feedback.user_id" >User:{{ feedback.user.name }} </li>
                    <li>Email: {{ feedback.user_id ? feedback.user.email : feedback.email }} </li>
                    <li>MESSAGE{{ feedback.message }}</li>
                    <li>LE {{ feedback.created_at }}</li>
                    <li>SOURCE: {{ feedback.source }}</li>
                </ul>

                <button @click="deleteFeedback(feedback.id)">Delete</button>

            </div>



        </div>

    </AppLayout>


</template>
