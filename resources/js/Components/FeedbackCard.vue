<script setup>

import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Rating from '@/Components/Rating.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';


defineProps({
    feedback: Object,
})

const deleteFeedback = (id) => {
    router.delete(route('feedbacks.destroy', id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

const restoreFeedback = (id) => {
    router.post(route('feedbacks.restore', id), {
        preserveScroll: true,
    })
};

const ConfirmDelete = ref(false);

const ShowConfirmDelete = () => {
    ConfirmDelete.value = true;
};

const closeModal = () => {
    ConfirmDelete.value = false;
};




</script>



<template>


    <div class="bg-white shadow-sm sm:rounded-lg px-6 py-4 flex flex-col justify-between  ">

        <div class="mb-6">

            <div class="flex items-center justify-between">

                <div v-if="feedback.source === 'DASHBOARD'">
                    <div class="text-sm font-medium text-gray-900">
                        {{ feedback.user_id ? feedback.user.name : '' }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ feedback.user_id ? feedback.user.email : feedback.email }}
                    </div>
                </div>

                <div v-else>
                    <div class="text-sm font-medium text-gray-900">
                        Feedback from {{ feedback.source_name }}
                    </div>

                </div>

                <div class="text-sm text-gray-500">
                    {{ new Date(feedback.created_at).toLocaleDateString() }} at {{ new
                        Date(feedback.created_at).toLocaleTimeString() }}
                </div>
            </div>

            <div class="mt-4 ">
                <p class="text-sm text-gray-500 mt-2">
                    {{ feedback.message }}
                </p>
            </div>
        </div>


        <div v-if="feedback.deleted_at" class="text-red-500 font-bold text-right">
            <span>Deleted at {{ new Date(feedback.deleted_at).toLocaleDateString() }}</span>
        </div>


        <div class="flex justify-between border-t border-gray-200 pt-2">

            <Rating :value="feedback.rating" :readonly=true />

            <DangerButton v-if="!feedback.deleted_at" @click="ShowConfirmDelete">
                Delete
            </DangerButton>


            <PrimaryButton v-if="feedback.deleted_at" @click="restoreFeedback(feedback.id)">
                Restore
            </PrimaryButton>

        </div>


    </div>

    <DialogModal :show="ConfirmDelete" @close="closeModal">

        <template #title>
            Delete Feedback
        </template>


        <template #content>
            Are you sure you want to delete this feedback?
        </template>


        <template #footer>

            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <DangerButton class="ms-3" @click="deleteFeedback(feedback.id)">
                Delete
            </DangerButton>
        </template>





    </DialogModal>



</template>
