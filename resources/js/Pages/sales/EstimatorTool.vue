<template>
    <div class="page-header p-3" style="background-color: white;">
        <div class="row">
            <div class="col-sm-3">
                <Breadcrumb :subtitle="selected_jobsite ? selected_jobsite.jobsite_name : ''" :page_title="'Estimate'"/>
            </div>
            <div class="col-sm-9">
                <div class="d-flex align-items-center justify-content-between" style="width: auto; float: right;">
                        <a class="btn btn-outline-light ml-3"><i class="icon-export mr-2"></i>Export</a>
                        <a class="btn btn-outline-light ml-3">Lock Worksheet Editing</a>
                        <a class="btn btn-outline-light ml-3">Format & Share</a>
                        <a class="btn btn-outline-light ml-3">Import From</a>
                        <a class="btn btn-primary ml-2"  href='sales/lead-management/proposal'  style="width: auto;">Add New Cost</a>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <div class="px-3 pb-3" style="width: 100%; height: calc(100vh - 80px); background-color: white;">
        <EstimatesTable :proposal_id="proposal_id" />
    </div>
</template>

<script setup>
    import { selected_jobsite } from '../../globalState';
    import { watch, ref } from 'vue';
    import Breadcrumb from '../../components/Breadcrumb.vue';
    import EstimatesTable from '../../components/tables/EstimatesTable.vue';

    const proposal_id = ref(0);
    const title = ref('');

    watch(() => selected_jobsite, (newValue) => {
        const data = newValue.value;
        if(data){
            proposal_id.value = data.proposal_id;
            title.value = data.jobsite_name;
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

</style>

