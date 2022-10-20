<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import throttle from "lodash/throttle";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";

let props = defineProps({
    categories: Object,
    filters: Object,
});

let search = ref(props.filters.search);

watch(
    search,
    throttle(function (value) {
        Inertia.get(
            "/categories",
            { search: value },
            {
                preserveState: true,
                replace: true,
                preserveScroll: true
            }
        );
    }, 500)
);

</script>
<template>
    <AppLayout title="Categories">
        <template #header>
            {{ categories.total }} Categories
        </template>

            <div v-for="category in categories.data" :key="category.id"
                class="text-blue-400 text-sm font-normal p-3 border-b border-gray-200 dark:border-dim-200 hover:bg-gray-100 dark:hover:bg-dim-300 cursor-pointer transition duration-350 ease-in-out">
                <Link :href="route('category', { id: category.slug })">
                    <h2 class="font-bold text-md text-gray-800 dark:text-white">
                        {{ category.name }}
                    </h2>
                    <p class="text-xs text-gray-400">{{ category.count }} Posts</p>
                </Link>
            </div>


            <div v-if="categories.total >= 21"
                class="text-blue-400 text-sm font-normal p-3 hover:bg-gray-100 dark:hover:bg-dim-300 cursor-pointer transition duration-350 ease-in-out">

                <InertiaLink v-if="categories.prev_page_url !== null" :href="categories.prev_page_url"
                    class="btn font-bold bg-white dark:bg-dim-800 text-blue-400 px-4 py-1 rounded-full border-2 border-blue-400">
                    Previous
                </InertiaLink>
                <button v-else
                    class="btn font-bold bg-white dark:bg-dim-800 text-blue-400 px-4 py-1 rounded-full border-2 border-blue-400 btn-disabled">
                    Previous
                </button>
                <InertiaLink v-if="categories.next_page_url !== null" :href="categories.next_page_url"
                    class="btn font-bold bg-white dark:bg-dim-800 text-blue-400 px-4 py-1 rounded-full border-2 border-blue-400">
                    Next
                </InertiaLink>
                <button v-else
                    class="btn font-bold bg-white dark:bg-dim-800 text-blue-400 px-4 py-1 rounded-full border-2 border-blue-400 btn-disabled">
                    Next
                </button>

                <!-- <Pagination :links="categories.links" /> -->
            </div>

    </AppLayout>
</template>
