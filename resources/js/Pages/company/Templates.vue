<template>
    <div class="row px-4 py-3" style="height: calc(100vh - 92px); overflow: hidden;">
        <div class="col-md-12 p-3 row m-0 p-0">
            <div class="col-md-3 m-0 p-0 b-primary d-flex align-items-center bg-primary" style="border-radius: 5px; overflow: hidden;">
                <i class="icon-search f-18 px-2"></i>
                <input type="text" class="form-control f-18" placeholder="Explore Templates..." style="border-radius: 0px;">
            </div>
            <div class="col-md-9 d-flex align-items-center justify-content-end">
                <span class="d-flex align-items-center gap-3 px-3 py-2" >
                    <label class="m-0 p-0"> Sort By: </label>
                    <label class="m-0 p-0 f-w-500 cursor-pointer"> Most Popular <i class="icon-angle-down"></i> </label>
                </span>
            </div>
        </div>
        <div class="col-md-2 mt-3 b-r-primary" style="height: 100%;">
            <div class="row px-2 px-2 mt-4">
                <div class="col-md-12 mb-3">
                    <label for="custom-file-upload" class="w-100" id="file-upload-label" style="display: inline">
                    <div class="card mb-0 rounded" id="custom-dropzone" style="border: solid black;">
                        <div class="card-body p-0" style="text-align: center;">
                            <label class="col-md-12 text-muted mb-3">Virtual Business Card</label>
                            <input type="file" id="custom-file-upload" hidden>
                            <img id="upload-image" :src="'/assets/images/image-upload.png'" alt="" style="display: block; margin-left: auto; margin-right: auto;">
                        </div>
                    </div>
                    </label>
                    <div id="image-container">
                    </div>
                </div>
            </div>

            <div class="row px-2">
                <label class="col-md-12 text-muted mb-3">Type</label>
                <template v-for="template in templateTypes">
                    <div class="checkbox checkbox-primary m-0 p-0 pb-2" style="margin-left: 15px !important;">
                        <input :id="template" type="checkbox" class="f-12">
                        <label :for="template" class="text-muted f-12 m-0 p-0 px-3">{{template}}</label>
                    </div>
                </template>
            </div>
            <div class="row px-2 mt-4">
                <label class="col-md-12 text-muted mb-3">Industry</label>
                <template v-for="industry in industries">
                    <div class="checkbox checkbox-primary m-0 p-0 pb-2" style="margin-left: 15px !important;">
                        <input :id="industry" type="checkbox" class="f-12">
                        <label :for="industry" class="text-muted f-12 m-0 p-0 px-3">{{industry}}</label>
                    </div>
                </template>
            </div>
        </div>
        <div class="col-md-10 mt-3 px-4">
            <h4 class="col-md-12 mb-3 f-w-700">2 templates</h4>
            <div class="d-flex flex-wrap gap-4 p-3" style="overflow: auto; max-height: calc(100vh - 242px);" id="template-table">
                <template v-for="card in cards">
                    <div class="d-flex flex-column">
                        <a class="shadow-md cursor-pointer" 
                            id="image-thumbnail" 
                            style="height: 200px; width: 400px; border-radius: 5px; overflow: hidden;"
                            @click="handlePreviewTemplate">
                            <img :src="card.img"/>
                        </a>
                        <label class="f-w-60 mb-2 mt-1 f-24">{{ card.title }}</label>
                        <p class="f-12" style="width: 400px;">{{ card.sub_title }}</p>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <TemplateModal />
</template>
<script setup>
import { ref } from 'vue';
import TemplateModal from '../../components/modals/TemplateModal.vue';

const templateTypes = ref([
    'Leads',
    'Plans and Permits',
    'Proposals',
    'Inbox',
    'Invoices',
    'Calendar',
    'Installers',
    'Forms and Checklists',
    'Testimonial Requests'
]);

const industries = ref([
    'General Construction',
    'Subcontractor',
    'Landscaping',
    'Pool Contractor',
    'Solar Installation',
    'Elevators and Escalators',
    'Handyman',
    'Electrical',
    'Roofing',
    'HVAC',
    'Painting',
    'Pluming',
    'Iron Worker'
]);

const cards = ref([
    { 
        title: 'Leads', 
        sub_title: 'Introduce yourself to clients, outline your services, and gather information prior to a discovery call.',
        img: 'https://res.cloudinary.com/honeybook/image/upload/f_auto,fl_lossy,q_auto/c_crop,h_1135,w_1730,x_0,y_0/c_fill,dpr_2.0,h_302,w_438/v1/companies/5fcf70304895500520ad101e/cover/Screen_Shot_2023-01-18_at_3.51.10_PM_ep2dlb'
    },
    { 
        title: 'Plans and Permits', 
        sub_title: 'Introduce yourself to clients, outline your services, and gather information prior to a discovery call.',
        img: 'https://res.cloudinary.com/honeybook/image/upload/f_auto,fl_lossy,q_auto/c_fill,dpr_2.0,h_302,w_438/v1/companies/5fcf704c2bbcf8008d6f1c99/cover/Screen_Shot_2022-08-01_at_11.49.10_AM_bprsyu.png'
    },
    { 
        title: 'Proposals', 
        sub_title: 'Introduce yourself to clients, outline your services, and gather information prior to a discovery call.',
        img: 'https://res.cloudinary.com/honeybook/image/upload/f_auto,fl_lossy,q_auto/c_fill,dpr_2.0,h_302,w_438/v1/companies/5fcf704c2bbcf8008d6f1c99/cover/Frame_1_6__cmg5hi.png'
    },
    { 
        title: 'Invoices', 
        sub_title: 'Introduce yourself to clients, outline your services, and gather information prior to a discovery call.',
        img: 'https://res.cloudinary.com/honeybook/image/upload/f_auto,fl_lossy,q_auto/c_fill,dpr_2.0,h_302,w_438/v1/template_gallery/planner_proposal.png'
    },
    { 
        title: 'Calendar', 
        sub_title: 'Introduce yourself to clients, outline your services, and gather information prior to a discovery call.',
        img: 'https://res.cloudinary.com/honeybook/image/upload/f_auto,fl_lossy,q_auto/c_fill,dpr_2.0,h_302,w_438/v1/companies/5fcf704c2bbcf8008d6f1c99/cover/Frame_1_8__qnqjmb.png'
    }
])


function handlePreviewTemplate(){
    var modal = document.querySelector('#templatePreview');
        var bootstrapModal = new bootstrap.Modal(modal, {backdrop: 'static', keyboard: false});
        bootstrapModal.show();
}


</script>
<style scoped>

#template-table::-webkit-scrollbar {
    width: 4px; /* Adjust to make it slim */
    height: 4px; /* Adjust to make it slim */
}

#template-table::-webkit-scrollbar-thumb {
    background-color: #888; /* Customize the thumb color */
    border-radius: 3px; /* Rounded corners for the thumb */
}

#template-table::-webkit-scrollbar-track {
    background-color: #ccc; /* Customize the track color */
}

#image-thumbnail:hover{
    box-shadow: 0px 0px 15px 5px rgba(128, 128, 128, 0.185);
}

</style>