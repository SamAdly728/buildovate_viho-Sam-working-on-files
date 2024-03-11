<template>
    <div class="px-4 py-3">
        <div class="d-flex flex-column mb-2">
            <label class="f-16 mb-0 pb-0" v-if="!props.data.hideLabel">{{ props.data.label }}</label>
            <small class="f-12" v-if="props.data.instruction != '' && !props.data.hideInstruction">{{ props.data.instruction }}</small>
        </div>
        <div class="d-flex gap-3 flex-wrap" v-if="props.type != 'builder'">
            <template v-for="option in props.data.options" :key="option.value">
                <a class="option f-w-500 f-16 cursor-pointer" :class="{'active': selectOption === option.value}" @click="handleSelect(option.value)">{{ option.label }}</a>
            </template>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';

const selectOption = ref(null);
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

function handleSelect(key){
    const field = props.data;
    if(field.estimate_field_id){
        if(selectOption.value !== key){
            selectOption.value = key;
            emit('onChange', {
                estimate_field_id: field.estimate_field_id,
                label: field.label,
                value: key,
                type: 'Radio Style 2'
            });
        }else{
            selectOption.value = null;
            emit('onChange', {
                estimate_field_id: field.estimate_field_id,
                label: field.label,
                value: null,
                type: 'Radio Style 2'
            });
        }
    }
}

</script>
<style scoped>
    .option{
        border: 4px solid #989a99;
        padding: 10px 20px;
    }
    .option.active{
        border: 4px solid #24695C;
    }
</style>