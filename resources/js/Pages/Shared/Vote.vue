<template>
    <div>
        <div v-if="$page.props.auth.user !== null" class="btn-group">
            <Link :href="route('upvote', { id: post.id })" preserveScroll preserveState method="post" as="button"
                :class="post.has.voted.has_upvoted === true ? 'btn btn-sm btn-active' : 'btn btn-sm'">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 19V6M5 12l7-7 7 7" />
            </svg>
            <span class="pl-2">{{ post.upvoters }}</span>
            </Link>
            <Link :href="route('downvote', { id: post.id })" preserveScroll preserveState method="post" as="button"
                :class="post.has.voted.has_downvoted === true ? 'btn btn-sm btn-active' : 'btn btn-sm'">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v13M5 12l7 7 7-7" />
            </svg>
            <span class="pl-2">{{ post.downvoters }}</span>
            </Link>
        </div>

        <div v-if="$page.props.auth.user === null" class="btn-group">
            <Link :href="route('upvote', { id: post.id })" preserveScroll preserveState method="post" as="button"
                class="btn btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 19V6M5 12l7-7 7 7" />
            </svg>
            <span class="pl-2">{{ post.upvoters }}</span>
            </Link>
            <Link :href="route('downvote', { id: post.id })" preserveScroll preserveState method="post" as="button"
                class="btn btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v13M5 12l7 7 7-7" />
            </svg>
            <span class="pl-2">{{ post.downvoters }}</span>
            </Link>
        </div>
    </div>
</template>
<script setup>
import { Link } from '@inertiajs/inertia-vue3'
defineProps({
    post: Object,
})

</script>