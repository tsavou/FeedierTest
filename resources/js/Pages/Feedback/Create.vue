<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted } from 'vue';


import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
import Rating from '@/Components/Rating.vue';


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
    message: '',
    rating: 3,
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
                New Feedback
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

                    <FormSection @submitted="submit">

                        <template #title>
                            Submit Feedback
                        </template>

                        <template #description>
                            <p>You can submit only one feedback per hour.</p>
                            <div v-if="!user" class="my-2 ">
                                <p>Submit a new feedback with your email or
                                    <Link :href="route('login')" class="underline font-black hover:font-medium ">log in
                                    </Link>
                                </p>
                                <p>You can
                                    <Link :href="route('register')" class="underline font-black hover:font-medium ">
                                    create a new account</Link> if you don't have one.
                                </p>

                            </div>

                            <div v-else class="my-2">

                                <p>Submit a new feedback as <span class="font-bold ">{{ user.name }}</span></p>
                                <p v-if="timer && !$page.props.flash.success"> You can submit feedback again in <span
                                        class="font-bold text-lg  ">{{
                                            formattedTimer }}</span>
                                </p>

                            </div>

                        </template>

                        <template #form>


                            <div v-if="user" class="col-span-6 sm:col-span-4">
                                You are writing a feedback as <span class="font-bold ">{{ user.name }}</span>
                            </div>

                            <!-- Email input for logged-out users -->
                            <div v-else class="col-span-6 sm:col-span-4">
                                <InputLabel for="email" value="Email" />
                                <TextInput id="email" v-model="form.email" type="email" />
                                <InputError :message="form.errors.email" class="mt-2" />
                            </div>

                            <!-- Rating -->

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="rating" value="Rate your experience :" />
                                <Rating id="rating" v-model:value="form.rating" />

                                <InputError :message="form.errors.rating" class="mt-2" />
                            </div>

                            <!-- Message -->
                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="message" value="Message :" />
                                <textarea
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    name="message" id="message" v-model="form.message" rows="10"
                                    placeholder="Write your feedback here..."></textarea>
                                <InputError :message="form.errors.message" class="mt-2" />
                            </div>


                        </template>

                        <template #actions>

                            <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                                Saved.
                            </ActionMessage>

                            <PrimaryButton :class="{ 'opacity-25 cursor-not-allowed': form.processing || timer }"
                                :disabled="form.processing || timer">Submit my feedback</PrimaryButton>

                        </template>

                    </FormSection>

                </div>
            </div>
        </div>

    </AppLayout>

</template>
