<template>
    <div class="mx-3 page-header p-3">
	  <div class="row">
		<div class="col-md-6">
		  <Breadcrumb />
		</div>
        <div class="col-md-6">
            <a class="btn btn-outline-light ml-2 px-4 float-right" style="width: auto;">Browse Buildovate Library</a>
        </div>
	  </div>
	</div>
    <div class="px-3 pb-3" style="width: 100%; height: calc(100vh - 208px);">
        <div class="row">
            <div class="col-md-6">
                <div class="card m-2 b-light" style="border-radius: 10px;">
                    <div class="p-4 d-flex justify-content-between align-items-center">
                        <h3 class="m-0 p-0">Favorites</h3>
                    </div>
                    <hr class="m-0 p-0">
                    <div class="card-body m-0 p-0">
                        <div class="list-container" style="height: auto; overflow: auto; max-height: calc(100vh - 322px);">
                            <div class="lists pt-3">
                                <template v-for="estimate in estimates" :key="estimate.estimate_id">
                                    <div class="b-light d-flex m-3 mb-3 mt-0 align-items-center" style="border-radius: 5px;" v-if="estimate.favorite === 1">
                                        <a style="height: 40px; width: 40px; font-size: 25px;" 
                                            class="d-flex align-items-center justify-content-center cursor-pointer m-2"
                                            @click="handleStarClicked(estimate.estimate_id, 0)">
                                            <i class="fa fa-star text-success-primary"></i>
                                        </a>
                                        <div class="flex-grow-1 m-0 f-14 f-w-500">{{ estimate.title }}</div>
                                        <a class="btn btn-outline-primary mr-4" :href="`/sales/smart-estimates/builder/${estimate.estimate_id}`">Edit</a>
                                        <a class="btn btn-primary mr-4" @click="handleSelectClick(estimate.estimate_id)">Select</a>
                                        <!-- <a class="btn btn-primary mr-4" :href="`/sales/smart-estimates/${estimate.estimate_id}`">Select</a> -->
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card m-2 b-light" style="border-radius: 10px;">
                    <div class="p-4 d-flex justify-content-between align-items-center">
                        <h3 class="m-0 p-0">Browse</h3>
                        <a class="btn btn-outline-primary ml-2 px-4" href="/sales/smart-estimates/builder">New Smart Estimate</a>
                    </div>
                    <hr class="m-0 p-0">
                    <div class="card-body m-0 p-0">
                        <input class="form-control m-0" type="text" placeholder="Search smart estimate"/>
                        <div class="list-container" style="height: auto; overflow: auto; max-height: calc(100vh - 358px);">
                            <div class="lists pt-3">
                                <template v-for="estimate in estimates" :key="estimate.estimate_id">
                                    <div class="b-light d-flex m-3 mb-3 mt-0 align-items-center" style="border-radius: 5px;">
                                        <a style="height: 40px; width: 40px; font-size: 25px;" class="d-flex align-items-center justify-content-center cursor-pointer m-2"
                                            @click="handleStarClicked(estimate.estimate_id, 1)">
                                            <i class="fa fa-star" :class="{'text-success-light': estimate.favorite !== 1, 'text-success-primary': estimate.favorite === 1}"></i>
                                        </a>
                                        <div class="flex-grow-1 m-0 f-14 f-w-500">{{ estimate.title }}</div>
                                        <a class="btn btn-outline-primary mr-4" :href="`/sales/smart-estimates/builder/${estimate.estimate_id}`">Edit</a>
                                        <a class="btn btn-primary mr-4" @click="handleSelectClick(estimate.estimate_id)">Select</a>
                                        <!-- <a class="btn btn-primary mr-4" :href="`/sales/smart-estimates/${estimate.estimate_id}`">Select</a> -->
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
    import Breadcrumb from '../../components/Breadcrumb.vue';
    import { usePage } from "@inertiajs/vue3";
    import { ref, onMounted, watch } from 'vue';
    import axios from 'axios';
    import { useProposalListModal } from '../../stores/proposal-list-modal.js';
    import { useSmartEstimateModal } from '../../stores/smart-estimate-modal';
    import { Inertia } from '@inertiajs/inertia';

    const page = usePage();
    const isLoading = ref(false);
    const estimates = ref([]);
    const store = useProposalListModal();
    const estimateStore = useSmartEstimateModal();
    const estimated_id = ref(0);

    function handleStarClicked(id, fav){
        estimates.value = estimates.value.map(estimate => {
            if(estimate.estimate_id == id){
                return {
                    ...estimate,
                    favorite: fav
                }
            }

            return {
                ...estimate
            }
        });
        updateFavorite(id, fav);
    }

    function updateFavorite(id, favoriteValue) {
        try {
            const response = axios.put(`/api/estimates/favorite/${id}`, { favorite: favoriteValue}, {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            console.log(response);
        } catch (error) {
            console.error("Error fetching cost itens:", error);
        }
    }

    function handleSelectClick(id){
        estimated_id.value = id;
        store.toggleModal();
    }

    async function fetchEstimates() {
        isLoading.value = true;
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
                estimates.value = data;
            }else{
                console.error("Error fetching cost items:", response.data);
            }
            
            isLoading.value = false;
        } catch (error) {
            console.error("Error fetching cost itens:", error);
            isLoading.value = false;
        }
    }

    onMounted(() => {
        fetchEstimates()
    });


    watch(() => store.selectedProposals, (newProposals) => {
        if(newProposals){
            localStorage.setItem('estimateId', estimated_id.value);
            const proposal_id = newProposals.proposal_id;
            const lead_id = newProposals.lead_id;
            Inertia.get(`/sales/lead-management/proposal/${proposal_id}/${lead_id}`);
        }
    }, { deep: true });
</script>

<style scoped>

.btn-outline-light:hover{
        background-color: #24695C !important;
        color: white !important;
}    
    
.btn-outline-light{
    border-color: #757575 !important;
    color: #757575 !important;
    height: 37.15px !important;
}

.btn-outline-primary{
    height: 37.15px !important;
}

.text-success-primary{
    color: #24695C;
}

.text-success-light{
    color: #c7c7c7;
}

.list-container::-webkit-scrollbar {
    width: 6px; /* Adjust to make it slim */
    height: 4px; /* Adjust to make it slim */
}

.list-container::-webkit-scrollbar-thumb {
    background-color: #888; /* Customize the thumb color */
    border-radius: 3px; /* Rounded corners for the thumb */
}

.list-container::-webkit-scrollbar-track {
    background-color: #ccc; /* Customize the track color */
}
</style>