<template>
    <div>
        <div class="mx-auto px-4">
            <form @submit.prevent="submit">
                <h3 class="font-bold text-lg dark:text-white">Write a reply {{ $page.props.user.name }}</h3>
                <div class="form-control pt-2">
                    <textarea v-model="form.reply" id="reply" name="reply"
                        class="textarea textarea-primary bg-white text-gray-900 dark:bg-gray-800 dark:text-white"
                        placeholder="Write a reply (max 500 characters)"></textarea>
                    <p class="mt-2 text-sm">{{ characterCount }}/500</p>
                    <div v-if="form.errors.reply" v-text="form.errors.reply" class="text-red-500 mt-1"></div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing" class="btn btn-sm btn-success gap-2">
                        Reply
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { computed } from 'vue';

let props = defineProps({
    post: Object,
});

const characterCount = computed(() => {
    return form.reply.length
})

let form = useForm({
    reply: "",
});

let submit = () => {
    form.post(route('reply', { id: props.post.id }), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => form.reset("reply"),
    });
};

</script>
