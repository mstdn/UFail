<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <!-- <template #header>
            Dashboard
        </template> -->

        <section class="mt-6 pl-4">
            <div class="card w-full bg-base-200">
                <figure><img src="https://placeimg.com/400/225/arch" class="object-cover w-full" alt="Shoes" /></figure>
                <div class="card-body">
                    <h2 class="card-title">
                        Shoes!
                        <div class="badge badge-secondary">NEW</div>
                    </h2>
                    <p>If a dog chews shoes whose shoes does he choose?</p>
                    <div class="card-actions justify-end">
                        <div class="badge badge-outline">Fashion</div>
                        <div class="badge badge-outline">Products</div>
                    </div>
                </div>
            </div>
        </section>

    </AppLayout>
</template>
