<template>
    <div class="d-flex">
        <div>
            <a class="f-w-700 text-muted">Total Client Price</a>
            <div class="d-flex">
                <h5 class="f-w-500 text-muted f-25 m-0"  v-if="props.discount !== '$0.0'">(</h5>
                <h5 class="f-w-500 text-primary f-25 m-0">{{ props.owner_price }}</h5>
            </div>
        </div>
        <div class="mx-4 mt-4"><h5>-</h5></div>
        <div v-if="props.discount !== '$0.0'">
            <a class="f-w-700 text-muted">Discount</a>
            <div class="d-flex">
                <h5 class="f-w-500 text-primary f-25 m-0">{{ props.discount }}</h5>
                <h5 class="f-w-500 text-muted f-25 m-0">)</h5>
            </div>
        </div>
        <div class="mx-4 mt-4"  v-if="props.discount !== '$0.0'"><h5>-</h5></div>
        <div>
            <a class="f-w-700 text-muted">Total Builder Cost</a>
            <h5 class="f-w-500 text-primary f-25 m-0">{{ props.builder_cost }}</h5>
        </div>
        <div class="mx-4 mt-4 text-muted"><h5>=</h5></div>
        <div>
            <a class="f-w-700 text-muted">Estimated Profit</a>
            <h5 class="f-w-500 text-primary f-25 m-0">{{ props.profit }}</h5>
        </div>
        <div class="mx-4 mt-3 position-relative">
            <a class="break-pop-over f-w-700 f-16 text-primary" @click="toggleBreakDownPopover" style="cursor: pointer !important;">Breakdown <i class="icofont icofont-info-circle"></i></a>
                <!-- Popover Content -->
            <div 
                    v-if="showPopoverBreakDown"
                    @click="toggleBreakDownPopover"
                    class="breakdown-popover d-flex flex-column"
                    >
                    <div class="d-flex">
                        <a style="width: 160px;" class="text-dark f-w-600">Total Builder Cost:</a>
                        <a class="flex-grow-1 text-right text-primary f-w-700">{{ props.builder_cost }}</a>
                    </div>
                    <div class="d-flex">
                        <a style="width: 160px;" class="text-dark f-w-600">Total Markup:</a>
                        <a class="flex-grow-1 text-right text-primary f-w-700">{{ props.markup }}</a>
                    </div>
                    <div class="d-flex" v-if="props.discount !== '$0.0'">
                        <a style="width: 160px;" class="text-success-v2 f-w-700">Discount:</a>
                        <a class="flex-grow-1 text-right text-success-v2 f-w-700">{{ props.discount }}</a>
                    </div>
                    <div class="d-flex">
                        <a style="width: 160px;" class="text-primary f-w-700">Total Client Price:</a>
                        <a class="flex-grow-1 text-right text-primary f-w-700">{{ props.owner_price }}</a>
                    </div>
                    <div class="d-flex">
                        <a style="width: 160px;" class="text-dark f-w-600">Total Margin %:</a>
                        <a class="flex-grow-1 text-right text-primary f-w-700">{{ props.margin }}%</a>
                    </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    owner_price: {
        typeof: String,
        default: '$0.0'
    },
    builder_cost: {
        typeof: String,
        default: '$0.0'
    },
    markup: {
        typeof: String,
        default: '$0.0'
    },
    margin: {
        typeof: String,
        default: '0.0'
    },
    profit: {
        typeof: String,
        default: '$0.0'
    },
    discount: {
        typeof: String,
        default: '$0.0'
    },
    element: {
        type: Object,
        default: () => {}
    }
});
const showPopoverBreakDown = ref(false);

function toggleBreakDownPopover() {
    showPopoverBreakDown.value = !showPopoverBreakDown.value;
}

const handleDocumentClick = (event) => {
    if (!event.target.closest('.break-pop-over')) {
        showPopoverBreakDown.value = false;
    }
                
};

onMounted(async () => {
    document.addEventListener('click', handleDocumentClick);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleDocumentClick);
});

</script>