<template>
    <div class="px-4 py-3 d-flex flex-column">
        <label class="f-26 f-w-700">{{ props.data.label }}</label>
        <small>{{ props.data.instruction  }}</small>
    </div>
</template>
<script setup>
const props = defineProps({
    data: {
        typeof: Object,
        default: {}
    }
});
</script>