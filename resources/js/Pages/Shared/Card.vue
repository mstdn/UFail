<template>
    <div>
        <article v-for="post in posts.data" :key="post.id" class="my-6 pl-4">
            <div class="card compact w-full bg-base-300">
                <figure v-if="post.file !== null"><img :src="post.file" class="object-cover w-full" alt="" />
                </figure>
                <div v-if="post.video !== null">
                    <vue-plyr :options="options">
                        <video controls crossorigin playsinline>
                            <source size="720" :src="post.video" type="video/mp4" />
                        </video>
                    </vue-plyr>
                </div>
                <div class="flex justify-between">
                    <div class="flex mt-4 ml-4 text-sm">
                        <span class="hidden lg:block">Posted in</span> <div class="badge badge-outline ml-1">
                            <InertiaLink :href="route('category', { id: post.category_slug })">
                                {{ post.category }}
                            </InertiaLink>
                        </div>
                    </div>
                    <div class="flex mt-4 mr-4">
                        <div class="badge badge-outline">
                            <InertiaLink :href="route('post.show', { id: post.id })">
                                {{ post.time }}
                            </InertiaLink>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>{{ post.description }}</p>
                    <div class="card-actions justify-between mt-2">
                        <Vote :post="post" />
                        <div>
                            <button v-if="post.has.delete" @click="destroy(post.id)" method="post" type="submit"
                                class="btn btn-sm btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path
                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                    </path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>

                            <InertiaLink :href="route('post.show', { id: post.id })" class="btn btn-sm btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                    </path>
                                </svg>
                                <span class="pl-2">{{ post.replycount }}</span>
                            </InertiaLink>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</template>
<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Vote from './Vote.vue';
defineProps({
    posts: Object,
});

const form = useForm();
function destroy(id) {
    if (confirm("Are you sure you want to delete?")) {
        form.delete(`/${id}/delete`, {
            preserveScroll: true,
        });
    }
}

</script>