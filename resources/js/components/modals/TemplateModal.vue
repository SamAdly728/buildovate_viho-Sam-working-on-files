<template>
    <div class="modal fade" id="templatePreview" tabindex="-1" role="dialog" aria-labelledby="templatePreview" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content"  style="height: 85vh !important;">
                <div class="modal-body p-0 m-0" style="max-height: 93vh !important; background-color: rgb(228, 228, 228);">
                    <div class="d-flex flex-column" style="height: 100% !important;">
                        <div class="col-md-12 d-flex justify-content-between p-3">
                            <div>
                                <i class="icon-desktop p-3 f-28 cursor-pointer view-icon" @click="handleSwitch('desktop')" :class="{'selected': selected === 'desktop'}"></i>
                                <i class="icon-mobile p-3 f-28 cursor-pointer view-icon" @click="handleSwitch('mobile')" :class="{'selected': selected === 'mobile'}"></i>
                            </div>
                            <i class="icon-close f-22 pr-3 cursor-pointer"  data-bs-dismiss="modal"></i>
                        </div>
                        <div class="col-md-12 d-flex justify-content-between align-items-center flex-grow-1">
                            <div class="p-1">
                                <i class="icon-angle-left f-30"></i>
                            </div>
                            <div class="flex-grow-1 p-3" style="height: 100% !important;">
                                <div class="desktop-container p-3" style="height: 100% !important; width: 100% !important;">
                                    
                                    <div class="shadow-md d-flex device flex-column" v-if="selected === 'desktop'">
                                        <div class="bg-white shadow-sm d-flex align-items-center px-3" style="height: 30px; width: 100% !important;">
                                            <div class="small-circle mr-1"></div><div class="small-circle mr-1"></div><div class="small-circle"></div>
                                        </div>
                                        <div class="flex-grow-1" style="overflow: auto; max-height: 73vh; background-color: #cecdcd;">
                                            <ProposalStyle1 />
                                        </div>
                                    </div>

                                    <div class="d-flex mobile-device pb-4 pt-1 justify-content-center" v-if="selected === 'mobile'">
                                        <div class="mobile-frame shadow">
                                            <div class="bg-white shadow-sm d-flex align-items-center px-3" style="height: 30px; width: 460px !important;">
                                                <div class="small-circle mr-1"></div><div class="small-circle mr-1"></div><div class="small-circle"></div>
                                            </div>
                                            <div class="flex-grow-1" style="overflow: auto; max-height: 73vh; background-color: #cecdcd;">
                                                <ProposalStyle1 />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="p-1">
                                <i class="icon-angle-right f-30"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import ProposalStyle1 from '../web_forms/ProposalStyle1.vue';

const selected = ref('desktop');

function handleSwitch(value){
    selected.value = value;
}

</script>
<style scoped>
.view-icon:hover{
    color: #24695C !important;
}

.view-icon.selected{
    border-bottom: #24695C 4px solid;
}

.modal-xl{
    margin: 3% 10%;
    max-width: 80vw !important;
}

.small-circle{
    height: 10px !important; 
    width: 10px !important; 
    background-color: rgb(87, 87, 87); 
    border-radius: 50%;
}

.device{
    height: 100% !important; 
    width: 100% !important;
    border-radius: 10px; 
    overflow: hidden;
}

.mobile-device{
    height: 100% !important; 
    width: 100% !important;
    border-radius: 10px; 
    overflow: hidden;
}

.mobile-frame{
    height: 100% !important; 
    width: 400px !important; 
    border: white 5px solid;
    border-radius: 20px;
    overflow: hidden;
}
</style>