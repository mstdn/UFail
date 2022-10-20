<template>
    <div>
        <article v-for="post in posts.data" :key="post.id" class="my-6 pl-4">
            <div class="card compact w-full bg-base-200">
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
                    <div class="flex mt-4 ml-4">
                        Posted in <div class="badge badge-outline ml-1 mt-1">{{ post.category }}</div>
                    </div>
                    <div class="flex mt-4 mr-4">
                        <div class="badge badge-outline">{{ post.time }}</div>
                    </div>
                </div>
                <div class="card-body">
                    <p>{{ post.description }}</p>
                    <div class="card-actions justify-between mt-2">
                        <Vote :post="post" />
                        <div>
                            <button class="btn btn-sm btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</template>
<script setup>
import Vote from './Vote.vue';
defineProps({
    posts: Object,
})

</script>