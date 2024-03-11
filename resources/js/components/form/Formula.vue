<template>
    <div class="px-4 py-3">
        <div class="d-flex flex-column mb-2">
            <label class="f-16 mb-0 pb-0" v-if="!props.data.hideLabel">{{ props.data.label }}</label>
            <small class="f-12" v-if="props.data.instruction != '' && !props.data.hideInstruction">{{ props.data.instruction }}</small>
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
    data: {
        typeof: Object,
        default: {}
    },
    type: {
        typeof: String,
        default: 'form'
    }
});
</script>