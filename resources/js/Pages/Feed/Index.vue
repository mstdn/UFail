<script setup>
import throttle from "lodash/throttle";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SimplePagination from '../Shared/SimplePagination.vue';
import Card from '../Shared/Card.vue';
import Empty from '../Shared/Empty.vue';

let props = defineProps({
    posts: Object,
    filters: Object,
})

let search = ref(props.filters.search);

watch(
    search,
    throttle(function (value) {
        Inertia.get(
            "/",
            { search: value },
            {
                preserveState: true,
                replace: true,
                preserveScroll: true
            }
        );
    }, 1000)
);

const form = useForm();

</script>
<template>
    <AppLayout title="Home">
        <Empty v-if="posts.meta.total === 0" />

        <Card :posts="posts" />

        <SimplePagination class="pt-4" v-if="posts.meta.total >= 5" :data="posts.links" />

    </AppLayout>
</template>
