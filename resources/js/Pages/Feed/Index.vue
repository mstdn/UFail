<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SimplePagination from '../Shared/SimplePagination.vue';
import Card from '../Shared/Card.vue';

defineProps({
    posts: Object,
})
</script>
<template>
    <AppLayout title="Home">
        <!-- <template #header>
            Dashboard
        </template> -->

        <Card :posts="posts" />

        <SimplePagination class="pt-4" v-if="posts.meta.total >= 1" :data="posts.links" />

    </AppLayout>
</template>
