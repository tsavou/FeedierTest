<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    feedbacks: Array,
    })

</script>


<template>

    <AppLayout title="Feedbacks">


        <div v-for="feedback in feedbacks" :key="feedback.id">
            <div>

                <ul>
                    <li v-if="feedback.user_id" >User:{{ feedback.user.name }} </li>
                    <li>Email: {{ feedback.user_id ? feedback.user.email : feedback.email }} </li>
                    <li>MESSAGE{{ feedback.message }}</li>
                    <li>LE {{ feedback.created_at }}</li>
                    <li>SOURCE: {{ feedback.source }}</li>
                </ul>

            </div>

        </div>

    </AppLayout>


</template>
