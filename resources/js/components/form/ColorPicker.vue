<template>
    <div class="px-4 py-3">
        <div class="d-flex flex-column mb-2">
            <label class="f-16 mb-0 pb-0" v-if="!props.data.hideLabel">{{ props.data.label }}</label>
            <small class="f-12" v-if="props.data.instruction != '' && !props.data.hideInstruction">{{ props.data.instruction }}</small>
        </div>
        <div class="d-flex gap-3 flex-wrap" v-if="props.type != 'builder'">
            <template v-for="option in props.data.options" :key="option.value">
                <a class="option f-w-500 f-16 cursor-pointer" :class="{'active': selectOption === option.value}" @click="handleSelect(option.value)">
                    <div style="width: 25px; height: 25px;" :style="{'background-color' : option.value}">

                    </div>
                </a>
            </template>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';

const selectOption = ref(null)
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
    selectOption.value = key
}
</script>
<style scoped>
    .option{
        border: 1px solid #989a99;
        padding: 5px;
        border-radius: 5px;
    }
    .option.active{
        border: 3px solid #24695C;
    }
</style>