<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Link} from '@inertiajs/vue3';
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <ApplicationLogo class="block h-12 w-auto" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900">
                Welcome to Feedier!
            </h1>

            <div class="mt-6 space-y-1">
                <p class="text-gray-500 leading-relaxed">
                    On this platform, you can <Link :href="route('feedbacks.create')" class="underline font-semibold hover:text-gray-900">submit a feedback</Link> every hour as a user logged or not. You can <Link :href="route('register')" class="underline font-semibold hover:text-gray-900">register</Link> or simply provide your email address.
                </p>

                <p class="text-gray-500 leading-relaxed">
                    As a staff member, you can <Link :href="route('feedbacks.index')" class="underline font-semibold hover:text-gray-900">view all feedbacks</Link> received on the platform.
                </p>
                <p class="text-gray-500 leading-relaxed">
                    External feedbacks are collected on the platform every day.
                </p>
            </div>
        </div>
    </div>
</template>
