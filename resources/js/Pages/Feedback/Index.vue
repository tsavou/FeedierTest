<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    feedbacks: Array,
    user: Object
})

</script>


<template>

    <AppLayout title="Feedbacks">

        <div v-for="feedback in feedbacks" :key="feedback.id">
            <div>

                <ul>
                    <li>User: {{ feedback.user_id ? feedback.user.name : feedback.email }} </li>
                    <li>MESSAGE{{ feedback.message }}</li>
                    <li>LE {{ feedback.created_at }}</li>
                    <li>SOURCE: {{ feedback.source }}</li>
                </ul>

            </div>

        </div>

    </AppLayout>


</template>
