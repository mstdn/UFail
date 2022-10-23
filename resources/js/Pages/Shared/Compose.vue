<template>
    <div>
        <button type="button" @click="openModal" class="btn btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="#57b55f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 8l-5-5-5 5M12 4.2v10.3" />
            </svg>
        </button>

        <TransitionRoot appear :show="isOpen" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
                <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0"
                    enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black bg-opacity-25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100" leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 p-6 text-left align-middle shadow-xl transition-all">
                                <DialogTitle as="h3"
                                    class="text-lg font-medium leading-6 text-gray-900 dark:text-white pb-2">
                                    Upload a short
                                </DialogTitle>
                                <form @submit.prevent="submit">
                                    <div class="flex justify-between">
                                        <div>
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="image">Image</label>
                                            <input
                                                class="block mb-5 w-full text-xs text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                id="image" @input="form.file = $event.target.files[0]" type="file">
                                        </div>
                                        <div>
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="video">Video</label>
                                            <input
                                                class="block mb-5 w-full text-xs text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                id="video" @input="form.video = $event.target.files[0]" type="file">
                                        </div>
                                    </div>

                                    <div class="form-control py-2">
                                        <textarea v-model="form.description" id="description" name="description"
                                            class="textarea textarea-primary bg-white text-gray-900 dark:bg-gray-900 dark:text-white"
                                            placeholder="Write a description (max 500 characters)"></textarea>
                                        <p class="mt-2 text-sm text-gray-900 dark:text-white">{{ characterCount }}/500
                                        </p>
                                        <div v-if="form.errors.description" v-text="form.errors.description"
                                            class="text-red-500 mt-1">
                                        </div>
                                    </div>
                                    <div v-if="form.errors.status" v-text="form.errors.status"
                                        class="text-red-500 mt-1"></div>

                                    <div class="modal-action mt-2">
                                        <!-- <div class="justify-start">
                                            <div class="form-control">
                                                <label class="label cursor-pointer mt-1">
                                                    <span class="label-text dark:text-white mr-2">NSFW?</span>
                                                    <input v-model="form.nsfw" type="checkbox" name="nsfw" id="nsfw"
                                                        class="checkbox" />
                                                </label>
                                            </div>
                                        </div> -->
                                        <div class="justify-start">
                                            <select v-model="form.category" name="category" id="category"
                                                class="select select-bordered w-full max-w-xs">
                                                <option disabled value="">Category</option>
                                                <option v-for="category in $page.props.categories" :key="category.id"
                                                    :value="category.id" selected>{{ category.name }}</option>
                                            </select>

                                        </div>

                                        <button type="submit" :disabled="form.processing" class="btn btn-success gap-2">
                                            Publish
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                    </div>

                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>
<script setup>
import { ref } from 'vue'
import { useForm } from "@inertiajs/inertia-vue3";
import { computed } from 'vue';
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'

const characterCount = computed(() => {
    return form.description.length
})

let form = useForm({
    description: "",
    video: "",
    file: "",
    category: "",
})

let submit = () => {
    form.post("/upload", {
        forceFormData: true,
        onSuccess: () => [
            form.reset("description", "video", "category", "file"),
            isOpen.value = false
        ],
    });
}

const isOpen = ref(false)

function closeModal() {
    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}
</script>
