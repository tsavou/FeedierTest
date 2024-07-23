<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';


const form = useForm({
    email: '',
    message: ''
});

const submit= ()=> {
    form.post(route('feedbacks.store'));
};

</script>


<template>

    <AppLayout title="Submit Feedback">

        <form @submit.prevent="submit">

            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input type="email" name="" id="email" v-model="form.email">

            <label for="message" class="block font-medium text-sm text-gray-700">Message</label>
            <textarea name="message" id="message" v-model="form.message" cols="30" rows="10" placeholder="Enter your feedback"></textarea>


            <button type="submit">Submit Feedback</button>
        </form>



    </AppLayout>

</template>



