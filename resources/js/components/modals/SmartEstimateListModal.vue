<template>
    <div class="modal fade" id="smartEstimateListModal" tabindex="-1" role="dialog" aria-labelledby="smartEstimateListModal" aria-modal="true" style="overflow: hidden;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0" style="max-height: 93vh !important;">
                    <div class="card p-0 m-0" style="max-height: 93vh !important; overflow: hidden;">
                        <div class="card-header border">
                            <h5>Select Smart Estimate</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="card-body p-0">
                            <div v-if="!loading">
                                <label class="px-3 py-2 f-18">Favorites</label>
                                <RichTable 
                                    :headers="headers"
                                    :rows="favorites"
                                    @onSelectedItem="handleSelectedRow"
                                />
                                <label class="px-3 py-2 f-18">Smart Estimate List</label>
                                <RichTable 
                                    :headers="headers"
                                    :rows="rows"
                                    @onSelectedItem="handleSelectedRow"
                                />
                            </div>
                            <div class="d-flex flex-column align-items-center mt-4 mb-4" style="width: 100%;" v-if="loading">
                                <div style="height: 40px;">
                                    <LoadingStyleMetric></LoadingStyleMetric>
                                </div>
                                <a class="f-w-600 mt-3">Retrieving Smart Estimates...</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useSmartEstimateListModal } from '../../stores/smart-estimate-list-modal';
import { watch, onMounted, ref } from 'vue';
import RichTable from '../Richtable.vue';
import LoadingStyleMetric from '../LoadingStyleMetric.vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';

const page = usePage();
const store = useSmartEstimateListModal();
const loading = ref(false);
const rows = ref([]);
const favorites = ref([]);
const headers = ref([
    { name: "Title", min: '250px'},
    { name: 'select_item' }
]);

function handleSelectedRow(selectedRows){
    store.toggleModal();
    store.setSelectedEstimates(selectedRows);
}

function updateModalVisibility() {
    const modalElement = document.getElementById('smartEstimateListModal');
    const modalInstance = new bootstrap.Modal(modalElement, {backdrop: 'static', keyboard: false});

    if (store.isModalOpen) {
        fetchEstimates();
        modalInstance.show();
    } else {
        document.querySelector(`#smartEstimateListModal .btn-close`).click();
    }
}

async function fetchEstimates() {
    loading.value = true;
    try {
        const response = await axios.get('/api/estimates', {
            headers: {
                'Authorization': 'Bearer ' + page.props.csrf_token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if(response.data.status === 'success'){
            const data = response.data.data;
            favorites.value = Object.values(data)
                .filter(item => item.favorite === 1)
                .map(item => ({
                    id: uniqueId(),
                    content: getRowContent(item)
            }));
            rows.value = Object.values(data).map(item => {
                return {
                    id: uniqueId(),
                    content: getRowContent(item)
                };
            });
        }else{
            console.error("Error fetching cost items:", response.data);
        }
        loading.value = false;
    } catch (error) {    
        console.error("Error fetching cost itens:", error);
        loading.value = false;
    }
}

function getRowContent(proposal){
    let rowCells = [];
    headers.value.forEach(header => {
        const headerName = header.name;
        rowCells[headerName] = getCellContent(proposal, headerName);
    });
    
    return rowCells
}

function getCellContent(data, headerName) {
    let content = '-';
    if(headerName === 'Title'){
        content = data['title'] ? data['title'] : '-';
    }
    
    return {
        className: '',
        content: content,
        style: 'default',
        action: 'none',
        data: data
    }
}

function uniqueId() {
  return 'id-' + Math.random().toString(36).slice(2, 11);
}

watch(() => store.isModalOpen, updateModalVisibility);
onMounted(updateModalVisibility);

</script>