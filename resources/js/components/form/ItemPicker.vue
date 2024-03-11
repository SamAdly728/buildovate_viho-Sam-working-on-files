<template>
    <div class="px-4 py-3">
        <div class="d-flex flex-column mb-2">
            <label class="f-16 mb-0 pb-0" v-if="!props.data.hideLabel">{{ props.data.label }}</label>
            <small class="f-12" v-if="props.data.instruction != '' && !props.data.hideInstruction">{{ props.data.instruction }}</small>
        </div>
        <div class="d-flex gap-3 flex-wrap" v-if="props.type != 'builder'">
            <template v-for="option in props.data.options" :key="option.value">
                <a class="option f-w-500 f-16 cursor-pointer" :class="{'active': selectOption === option.value}" @click="handleSelect(option.value, itemData[option.value])">
                    <div style="width: 180px; height: 180px;" class="d-flex flex-column p-2 pb-0">
                                <div class="flex-grow-1 b-primary" style="width: 100%; max-height: 120px; overflow: hidden;">
                                    <img :src="option.img_url" alt="Option Image" style="width: 100%; height: auto;">
                                </div>
                                <div class="d-flex flex-column py-2" style="overflow: hidden;">
                                    <a class="f-12 f-w-700 truncate"> {{ loading[option.value] ? 'Loading...' : (itemData[option.value]) ? itemData[option.value].title : option.label }}</a>
                                    <a class="f-12">Builder Cost: {{ loading[option.value] ? 'Loading...' : builderCost[option.value] }}</a>
                                    <a class="f-12">Client Price: {{ loading[option.value] ? 'Loading...' : ownerPrice[option.value] }}</a>
                                </div>
                            </div>
                </a>
            </template>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';

const page = usePage();
const loading = ref({});
const selectOption = ref(null);
const itemData = ref({});
const builderCost = ref({});
const ownerPrice = ref({});

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

function handleSelect(key, data){
    const field = props.data;
    if(field.estimate_field_id){
        if(selectOption.value !== key){
            selectOption.value = key;
            emit('onChange', {
                estimate_field_id: field.estimate_field_id,
                label: field.label,
                value: key,
                type: 'Item Picker',
                data: data
            });
        }else{
            selectOption.value = null;
            emit('onChange', {
                estimate_field_id: field.estimate_field_id,
                label: field.label,
                value: null,
                type: 'Item Picker',
                data: data
            });
        }
    }
}

onMounted(async () => {
    props.data.options.forEach(item => {
        fetchCostItem(item.value);
    });
});

async function fetchCostItem(id) {
    loading.value[id] = true;
    try {
        const response = await axios.get(`/api/costItems/${id}`, {
            params: {},  // Pass the page as a query parameter
            headers: {
                'Authorization': 'Bearer ' + page.props.csrf_token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        if(response.data.status === 'success'){
            const data = response.data.data;
            loading.value[id] = false;

            itemData.value[id] = data;
            builderCost.value[id] = formatCurrency(getBuilderPrice(data));
            ownerPrice.value[id] = getOwnerPrice(data);
        }else{
            console.error("Error fetching cost item:", response.data);
            loading.value[id] = false;
        }
    } catch (error) {
        console.error("Error fetching cost item:", error);
        loading.value[id] = false;
    }
}

function getBuilderPrice(costitem){
        let unit_cost = costitem.unit_cost;
        let unit_quantity = costitem.unit_quantity;

        if(!unit_cost){
               unit_cost = 0; 
        }

        if(!unit_quantity){
                unit_quantity = 1;
        }

        return (unit_cost * unit_quantity);
}

    function getOwnerPrice(costitem){
        const builder_cost = getBuilderPrice(costitem);
        const markup = costitem.unit_mark_up;
        const markup_type = costitem.unit_mark_up_type;
        const unit_quantity = costitem.unit_quantity;
        let totalMarkup = 0;

        if(markup_type){
                if(markup_type === '%'){
                        totalMarkup =  builder_cost + ((builder_cost) * (markup/100));
                }else if(markup_type === '$/'){
                        totalMarkup = (markup * unit_quantity) + builder_cost;
                }else{
                        totalMarkup = markup + builder_cost;
                }
        }
        
        return formatCurrency(totalMarkup);
    }

    function formatCurrency(amount) {
        if(amount){
            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });
            return formatter.format(parseFloat(amount).toFixed(2));
        }else{
            return '$0.0';
        }
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