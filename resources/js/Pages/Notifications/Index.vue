<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from '@inertiajs/inertia-vue3';
import NotificationsCard from "../Shared/NotificationsCard.vue";
import Empty from "../Shared/Empty.vue";
import SimplePagination from "../Shared/SimplePagination.vue";

let props = defineProps({
    notifications: Object,
});



const form = useForm();
function destroy(id) {
    if (confirm("Are you sure you want to delete?")) {
        form.delete(route('post.destroy', id));
    }
};

</script>
<template>
    <AppLayout title="Notifications">
        <template #header>
            <span class="badge badge-lg bg-white">{{ $page.props.unreadNotificationsCount }}</span><span
                class="ml-1 mt-2">Notifications</span>
        </template>

        <div class="py-12 pl-4">

            <Empty v-if="notifications.total === 0" class="w-full mt-20" />

            <div class="w-full">
                <NotificationsCard class="mb-4" v-for="notification in notifications.data" :key="notification.id"
                    :notification="notification" />
            </div>

            <SimplePagination v-if="notifications.next_page_url !== null" :data="notifications.data" />
        </div>

    </AppLayout>
</template>