<template>
    <div class="modal fade" id="proposalListModal" tabindex="-1" role="dialog" aria-labelledby="proposalListModal" aria-modal="true" style="overflow: hidden;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0" style="max-height: 93vh !important;">
                    <div class="card p-0 m-0" style="max-height: 93vh !important; overflow: hidden;">
                        <div class="card-header border">
                            <h5>Select Proposal</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="card-body p-0">
                            <div v-if="!loading">
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
                                <a class="f-w-600 mt-3">Retrieving Proposals...</a>
                            </div>
                        </div>
                        <div class="card-footer b-t-light  d-flex justify-content-between" v-if="modalType != 'single'">                          
                            <button class="btn btn-light mr-2" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" @click="handleSelectClick" data-bs-dismiss="modal">SELECT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useProposalListModal } from '../../stores/proposal-list-modal';
import { watch, onMounted, ref } from 'vue';
import RichTable from '../Richtable.vue';
import LoadingStyleMetric from '../LoadingStyleMetric.vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';

const page = usePage();
const store = useProposalListModal();
const loading = ref(false);
const pages = ref(1);
const limit = ref(15);
const rows = ref([]);
const headers = ref([
    { name: "Title", min: '250px'},
    { name: "Customer", min: '200px', max: '200px'},
    { name: 'select_item' }
]);
const modalType = ref('single');

function updateModalVisibility() {
    const modalElement = document.getElementById('proposalListModal');
    const modalInstance = new bootstrap.Modal(modalElement, {backdrop: 'static', keyboard: false});

    if (store.isModalOpen) {
        if(store.proposals.length === 0){
            fetchProposals();
        }
        modalInstance.show();
    } else {
        document.querySelector(`#proposalListModal .btn-close`).click();
    }
}

function handleSelectedRow(selectedRows){
    store.toggleModal();
    store.setSelectedProposals(selectedRows);
}

function handleSelectClick(){
    console.log('Coming soon...');
}

async function fetchProposals() {
    loading.value = true;
    try {
        const response = await axios.get('/api/proposals', {
            params: { 
                page: pages.value,
                limit: limit.value
            },
            headers: {
                'Authorization': 'Bearer ' + page.props.csrf_token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if(response.data.status === 'success'){
            const data = response.data.data;
            const proposals = data.data;
            store.setProposals(proposals);
            rows.value = Object.values(proposals).map(item => {
                return {
                    id: uniqueId(),
                    content: getRowContent(item)
                };
            });

            console.log(rows.value);
        }else{
            console.error("Error fetching leads:", response.data);
        }
        loading.value = false;
    } catch (error) {
        console.error("Error fetching leads:", error);
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
    }else if(headerName === 'Customer'){
        const lead = data['lead'] ? data['lead'] : 'No Lead';
        const customer = lead === 'No Lead' ? lead : lead['lead_customer'] ? lead['lead_customer'] : 'No Customer'; 
        const customer_name = customer === 'No Customer' ? customer : customer['display_name'] ? customer['display_name'] : 'No Display Name';
        content = customer_name;
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
