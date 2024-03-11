<template>
    <div class="modal fade" id="leadDetailModal" tabindex="-1" role="dialog" aria-labelledby="leadDetailModal" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content" style="max-height: 92vh !important; overflow: hidden;">
                <div class="modal-body p-0 m-0">
                    <div class="px-4 py-3 m-0 b-b-primary-v2 d-flex align-items-center bg-white">
                        <h5 class="f-18 f-w-600 text-dark flex-grow-1 m-0 p-0">Lead Details</h5>
                        <span class="bg-hover m-0 p-1 f-w-700 text-dark f-18 close" type="button" data-bs-dismiss="modal" aria-label="Close" @click="store.closeModal()"><i class="icon-close"></i></span>
                    </div>
                    <div class="m-0 p-0 col-md-12">
                        <div class="b-t-light b-l-light p-4">
                                
                            <div class="d-flex flex-column gap-4" v-if="selected">
                                <ul class="d-flex flex-column gap-2">
                                    <li class="f-w-600 row m-0 p-0">
                                        <span class="col-md-3 m-0 p-0 text-dark f-w-600">Lead Title: </span>
                                        <span class="f-w-500 text-muted col-md-9 m-0 p-0">{{ selected.opportunity_title ? selected.opportunity_title : 'N/A' }}</span>
                                    </li>
                                    <li class="d-flex">
                                        <span class="col-md-3 m-0 p-0 text-dark f-w-600">Address: </span>
                                        <span class="f-w-500 text-muted col-md-9 m-0 p-0"> 
                                            {{ selected.street_address ? selected.street_address : '' }} {{ selected.city ? selected.city : '' }} {{ selected.state ? selected.state : '' }} {{ selected.zip_code ? selected.zip_code : '' }}
                                        </span>
                                    </li>
                                    <li class="d-flex">
                                        <span class="col-md-3 m-0 p-0 text-dark f-w-600">Description: </span>
                                        <span class="f-w-500 text-muted col-md-9 m-0 p-0">{{ selected.description ? selected.description : 'N/A' }}</span>
                                    </li>
                                    <li class="d-flex">
                                        <span class="col-md-3 m-0 p-0 text-dark f-w-600">Phone: </span>
                                        <span class="f-w-500 text-muted col-md-9 m-0 p-0">{{ selected.opportunity_phone ? formatPhoneNumber(selected.opportunity_phone) : 'N/A' }}</span>
                                    </li>
                                    <li class=" d-flex">
                                        <span class="col-md-3 m-0 p-0 text-dark f-w-600">Cost of Lead: </span>
                                        <span class="f-w-500 text-muted col-md-9 m-0 p-0">{{ selected.cost_of_lead ? formatCurrency(selected.cost_of_lead) : 'N/A' }}</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <span class="col-md-3 m-0 p-0 text-dark f-w-600">Salespeople: </span>
                                        <span class="f-w-500 col-md-9 m-0 p-0" v-html="getMultipleString(selected.sales_people, 'Salesperson')"></span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <span class="col-md-3 m-0 p-0 text-dark f-w-600">Tags: </span>
                                        <span class="f-w-500 col-md-9 m-0 p-0" v-html="getMultipleString(selected.tags, 'Tags')"></span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <span class="col-md-3 m-0 p-0 text-dark f-w-600">Sources: </span>
                                        <span class="f-w-500 col-md-9 m-0 p-0" v-html="getMultipleString(selected.sources, 'Lead Sources')"></span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <span class="col-md-3 m-0 p-0 text-dark f-w-600">Job Types: </span>
                                        <span class="f-w-500 col-md-9 m-0 p-0" v-html="getMultipleString(selected.job_types, 'Job Types')"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { useLeadDetails } from '../../stores/lead-details-modal';

export default {
    setup(){
        const store = useLeadDetails();

        return { store }
    },
    data(){
        const selected = null;

         return { selected }
    },
    methods: {
        updateModalVisibility() {
            const modalElement = document.getElementById('leadDetailModal');
            const modalInstance = new bootstrap.Modal(modalElement, {backdrop: 'static', keyboard: false});

            if (this.store.isModalOpen) {
                modalInstance.show();
            } else {
                document.querySelector(`#leadDetailModal .close`).click();
            }
        },
        formatPhoneNumber(number) {
            const cleaned = ('' + number).replace(/\D/g, '');
            const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
            if (match) {
                return '(' + match[1] + ') ' + match[2] + '-' + match[3];
            }
            return number;
        },
        formatCurrency(amount) {
            if(amount){
                const formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                });
                return formatter.format(parseFloat(amount).toFixed(2));
            }else{
                return '$0.0';
            }
        },
        getMultipleString(lists, type){
            let listItems = `-`;
            if(lists && lists.length !== 0){
                listItems = lists.map(data => {
                    let name = '-';
                    if(type === 'Job Types'){
                        name = data.job_type.job_type_name;
                    }else if(type === 'Tags'){
                        name = data.tag.tags_name;
                    }else if(type === 'Lead Sources'){
                        name = data.source.source_name;
                    }else if(type === 'Salesperson'){
                        name = data.user.display_name;
                    }
                    return `<small class="bg-primary-v2 px-2 py-1 text-white b-radius-10 f-12">${name}</small>`;
                }).join('');
            }
            return `<a class="d-flex gap-1">${listItems}</a>`;
        }
    },
    computed: {
        isModalOpen() {
            return this.store.isModalOpen;
        },
        leadDetails() {
            return this.store.lead;
        }
    },
    watch: {
        isModalOpen: {
            handler() {
                this.updateModalVisibility();
            }
        },
        leadDetails: {
            handler(lead) {
                this.selected = lead;
                console.log('this.selected', this.selected);
            }
        }
    }
}
</script>