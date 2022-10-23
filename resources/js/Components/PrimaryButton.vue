<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-white border border-red-500 rounded-md font-semibold text-xs text-red-500 uppercase tracking-widest hover:bg-red-500 hover:text-white active:bg-red-900 focus:outline-none border-red-500 focus:shadow-outline-red transition ease-in-out duration-150">
        <slot />
    </button>
</template>
