<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SimplePagination from '../Shared/SimplePagination.vue';
import Card from '../Shared/Card.vue';
import Empty from '../Shared/Empty.vue';

defineProps({
    posts: Object,
})
</script>
<template>
    <AppLayout title="Home">
        <Empty v-if="posts.meta.total === 0" />

        <Card :posts="posts" />

        <SimplePagination class="pt-4" v-if="posts.meta.total >= 5" :data="posts.links" />

    </AppLayout>
</template>
