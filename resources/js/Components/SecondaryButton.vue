<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="btn btn-secondary disabled:opacity-25 transition">
        <slot />
    </button>
</template>
