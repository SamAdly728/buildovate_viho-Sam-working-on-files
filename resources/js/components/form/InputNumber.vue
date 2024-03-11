<template>
    <div class="px-4 py-3">
        <div class="d-flex flex-column mb-2">
            <label class="f-16 mb-0 pb-0" v-if="!props.data.hideLabel">{{ props.data.label }}</label>
            <small class="f-12" v-if="props.data.instruction != '' && !props.data.hideInstruction">{{ props.data.instruction }}</small>
        </div>
        <input class="form-control b-primary text-right" type="number" style="width: 200px;" v-if="props.type != 'builder'" v-model="fieldValue">
    </div>
</template>
<script setup>
import { ref, watch } from 'vue';

const emit = defineEmits(['onChange']);
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

const fieldValue = ref('');
watch(fieldValue, (newValue) => {
    const field = props.data;
    emit('onChange', {
        estimate_field_id: field.estimate_field_id,
        label: field.label,
        value: newValue,
        type: 'Input Number'
    });
});
</script>