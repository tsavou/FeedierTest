<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted } from 'vue';



const props = defineProps({
    user: Object,
    timer: Number,
})

const DynamicTimer = ref(props.timer);
const isTimerActive = ref(false);

// Watch for changes in the timer
watch(() => props.timer, (newVal) => {
    DynamicTimer.value = newVal;

});

// Update timer to display a dynamic timer
const updateTimer = () => {

    if (DynamicTimer.value > 0) {
        setTimeout(() => {
            DynamicTimer.value -= 1;
            updateTimer();
        }, 1000);

        isTimerActive.value = true;

    } else {
        isTimerActive.value = false;
    }
};

// Format the timer
const formattedTimer = computed(() => {
    const minutes = Math.floor(DynamicTimer.value / 60);
    const seconds = DynamicTimer.value % 60;

    return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
})

// Start the timer
onMounted(() => {
    if (DynamicTimer.value > 0) {
        updateTimer();
    }
});


// Next submission time to display for the  logged-out

const nextSubmissionTime = computed(() => {
    const now = new Date().getTime();
    const nextTime = new Date(now + 3600000);

    return nextTime.toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric' });

});

const form = useForm({
    email: '',
    message: ''
});


const submit = () => {
    form.post(route('feedbacks.store'), {
        preserverScroll: true,
        onSuccess: () => {
            form.reset();

            if (DynamicTimer.value > 0 && !isTimerActive.value) {
                updateTimer();
            }

        },
    });

};

</script>


<template>

    <AppLayout title="New Feedback">

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <nav>New Feedback</nav>
            </h2>
        </template>

        <div class="py-6">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


                <div v-if="$page.props.flash.success"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <p>{{ $page.props.flash.success }}</p>
                    <p v-if="user">You can submit feedback again in {{ formattedTimer }}</p>
                    <p v-else> You will be able to submit a new one from {{ nextSubmissionTime }} </p>

                </div>

                <div v-else-if="$page.props.flash.error"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <p>{{ $page.props.flash.error }}</p>
                    <p v-if="user">Try again in {{ formattedTimer }}</p>
                    <p v-else>You've already submitted feedback with this email.</p>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-6">


                    <form @submit.prevent="submit">

                        <!-- Email input for logged-out users -->
                        <div v-if="user">
                            <p>Submit a feedback as {{ user.name }} :</p>
                            <p v-if="timer && !$page.props.flash.success"> You can submit feedback again in {{
                                formattedTimer }}
                            </p>
                        </div>

                        <div v-else>
                            <label for="email" class="block font-medium text-sm text-gray-700">Email* </label>
                            <input type="email" name="email" id="email" v-model="form.email"
                                placeholder="Enter your email">
                            <div v-if="form.errors.email">{{ form.errors.email }}</div>
                        </div>


                        <label for="message" class="block font-medium text-sm text-gray-700">Message * :</label>
                        <textarea name="message" id="message" v-model="form.message" cols="100" rows="10"
                            placeholder="Enter your feedback"></textarea>

                        <div v-if="form.errors.message">{{ form.errors.message }}</div>


                        <div class="flex items-center mt-4">

                            <button type="submit"
                                :class="['text-white font-bold py-2 px-4 rounded', timer ? 'bg-gray-500 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-700']">Submit
                                Feedback</button>
                        </div>

                    </form>



                </div>
            </div>
        </div>



    </AppLayout>

</template>
