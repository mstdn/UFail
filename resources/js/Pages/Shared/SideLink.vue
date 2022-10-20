<script setup>
    import { computed } from 'vue';
    import { Link } from '@inertiajs/inertia-vue3';
    
    const props = defineProps({
        href: String,
        active: Boolean,
    });
    
    const classes = computed(() => {
        return props.active
            ? 'flex items-center justify-center xl:justify-start text-blue-500 mb-8 transition duration-350 ease-in-out'
            : 'flex items-center justify-center xl:justify-start text-gray-100 dark:text-white hover:text-blue-500 dark:hover:text-blue-500 mb-8 transition duration-350 ease-in-out';
    });
    </script>
    
    <template>
        <Link :href="href" :class="classes">
            <slot />
        </Link>
    </template>
