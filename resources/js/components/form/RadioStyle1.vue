<template>
    <div class="px-4 py-3">
        <div class="d-flex flex-column mb-2">
            <label class="f-16 mb-0 pb-0" v-if="!props.data.hideLabel">{{ props.data.label }}</label>
            <small class="f-12" v-if="props.data.instruction != '' && !props.data.hideInstruction">{{ props.data.instruction }}</small>
        </div>
        <template v-for="option in props.data.options" :key="option.value" v-if="props.type != 'builder'">
            <label class="d-block mx-3 my-3" :for="props.id + '_' + option.value">
                <input class="radio_animated" :id="props.id + '_' + option.value" type="radio" :name="props.id + '_' + props.data.label" :value="option.value" v-model="selectedOption">{{ option.label }}
            </label>
        </template>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const emit = defineEmits(['onChange']);
const props = defineProps({
    id: String,
    data: {
        typeof: Object,
        default: {}
    },
    type: {
        typeof: String,
        default: 'form'
    }
});

const selectedOption = ref(null);

watch(selectedOption, (newValue) => {
    const field = props.data;
    emit('onChange', {
        estimate_field_id: field.estimate_field_id,
        label: field.label,
        value: newValue,
        type: 'Radio Style 1'
    });
});
</script>
