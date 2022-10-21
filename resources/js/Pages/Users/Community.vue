<script setup>
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";
import AppLayout from "@/Layouts/AppLayout.vue";
import UserCard from "../Shared/UserCard.vue";
import SimplePagination from "../Shared/SimplePagination.vue";

let props = defineProps({
    users: Object,
    filters: Object,
    usercount: String,
});

let search = ref(props.filters.search);

watch(
    search,
    throttle(function (value) {
        Inertia.get(
            "/community",
            { search: value },
            {
                preserveState: true,
                replace: true,
            }
        );
    }, 500)
);
</script>
<template>
    <AppLayout title="Community">
        <template #header>
            Community ({{ users.meta.total }} users)
        </template>

        <div class="px-4 mx-auto">

            <input v-model="search" type="text"
                class="input input-bordered input-info w-full mt-4"
                placeholder="Search.." />

            <div v-for="user in users.data" :key="user.id"
                class="card mt-5">
                <UserCard :profile="user" />
            </div>

        </div>
        <SimplePagination class="my-6" v-if="users.meta.total >= 11" :data="users.links" />

    </AppLayout>
</template>