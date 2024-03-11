<template>
    <div class="buttons-container shadow-md d-flex flex-column" :class="{'d-none': props.display}" >
        <a class="option-style b-light" @click="handleClick('properties')" v-if="!props.hideProperties"
            data-container="body" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Properties" :data-id="props.id + '_properties'">
             <i class="icofont icofont-settings-alt"></i></a>
        <a class="option-style b-light"  @click="handleClick('delete')"
            data-container="body" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" :data-id="props.id + '_delete'">
            <i class="icofont icofont-ui-delete"></i></a>
        <a class="option-style b-light"  @click="handleClick('duplicate')"
            data-container="body" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Duplicate" :data-id="props.id + '_duplicate'">
            <i class="icofont icofont-ui-copy"></i></a>
    </div>
</template>
<script setup>
import { onMounted } from 'vue';
import { Tooltip } from 'bootstrap';

const props = defineProps({
    display: {
        typeof: Boolean,
        default: false
    },
    id: {
        typeof: String,
        default: ''
    },
    hideProperties: {
        typeof: Boolean,
        default: false
    }
});

const emit = defineEmits(['option']);

onMounted(() => {
  let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl);
  });
});

function handleClick(type){
    const tooltipElement = document.querySelector(`[data-id="${props.id}_${type}"]`);

    if (tooltipElement) {
        const tooltipInstance = Tooltip.getInstance(tooltipElement);
        if (tooltipInstance) {
            tooltipInstance.dispose();
        }
    }

    emit('option', {
        type: type,
        id: props.id
    });
}

</script>
<style scoped>
.buttons-container{
  position: absolute;
  right: 0;
  top: 0;
  background-color: white;
}

.option-style{
  cursor: pointer;
  font-size: 20px;
  padding: 5px 10px;
}
.option-style:hover{
  background-color: #24695c0f;
}

</style>