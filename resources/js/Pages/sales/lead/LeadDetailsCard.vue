<template>
    <div class="email-sidebar inter-font no-border">
        <div class="email-left-aside">
            <div class="card m-0  no-border">
                <div class="card-body" v-if="fetchingData">
                    <div class="mt-5 d-flex flex-column align-items-center">
                        <div style="height: 40px;">
                            <LoadingStyleMetric></LoadingStyleMetric>
                        </div>
                        <a class="f-w-600 mt-1 mb-5">Reloading Lead Details...</a>
                    </div>
                </div>
                <div class="card-body m-0 p-3" v-else>
                    <div class="email-app-sidebar d-flex flex-column">
                        <div class="media">
                            <!-- <div class="img-50"> -->
                            <div>
                                <img class="me-3 rounded-circle" src="../../../../assets/test-images/user/2.jpg" alt="">
                            </div>
                            <div class="media-body ml-3 mt-1">
                                <div class="row">
                                    <h6 class="f-w-600"> Lead Opportunity Name {{ customer.display_name }}</h6>
                                    <p>{{ customer.email }}</p>
                                </div>
                                <span class="badge badge-primary">SOLD</span>
                            </div>
                        </div>
                        
                        <!-- <div class="row pt-3" style="font-size:10px">
                            <div class="col-md-4 p-0">Current Total: <b>$0.00</b></div>
                            <div class="col-md-4 p-0">Open Balance: <b>$0.00</b></div>
                            <div class="col-md-4 p-0">Estimated Cost: <b>$0.00</b></div>
                        </div> -->
                        <div class="pt-3">
                            <p style="font-size:12px">Current Total: <b>$0.00</b> Open Balance: <b>$0.00</b> <br> Estimated Cost: <b>$0.00</b></p>
                        </div>
                    </div>

                    <div class="rounded-3 bg-gray p-3">
                        <ul class="icon-lists border navs-icon default-according style-1 p-1 inter-font"
                            v-for="accordion in leftAccordions" 
                            :key="accordion" 
                            :style="{ border: '0px !important' }">
                            <li>
                                <div class="d-flex flex-column">
                                    <button class="btn btn-link text-muted py-2" @click="toggleAccordion(accordion.title)">
                                        <i :class="accordion.icon" :style="{ width: '20px' }"></i><span>&nbsp;&nbsp;{{ accordion.title }}</span>
                                        <i :class="getChevronClass(accordion.title)" :style="{ float: 'right' }"></i>
                                    </button>
                                    <transition name="fade">
                                        <div v-if="isOpen[accordion.title]" 
                                            class="m-0 p-0" 
                                            style="
                                                width: 1000px;
                                                max-width: 100% !important; 
                                                height: auto;
                                                overflow: hidden;
                                            "
                                            v-html="accordion.content"
                                            :key="componentKey">
                                        </div>
                                    </transition>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
    import LoadingStyleMetric from "../../../components/LoadingStyleMetric.vue";
    import { usePage } from "@inertiajs/vue3";
    import { ref, reactive, watch } from 'vue';
    import axios from 'axios';

    const page = usePage();
    const componentKey = ref(0);
    const fetchingData = ref(false);
    const lead = ref({}); 
    const customer = ref({});
    const tagsData = ref(null);
    const sourcesData = ref(null);
    const jobTypesData = ref(null);
    const salesPeople = ref({});

    const props = defineProps({
        jobsite_id: { 
            type: Number,
            default: () => 0
        },
    });

    const leftAccordions = ref([
        {title: 'Lead Details', icon: 'fa fa-list m-0', content: getDetailsContent()},
        {title: 'Description', icon: 'fa fa-info-circle m-0', content: getDescriptionContent()},
        {title: 'Customer Contact', icon: 'fa fa-phone-square m-0', content: getCustomerContent()},
        {title: 'Salespeople', icon: 'fa fa-users m-0', content: getSalespeopleContent(salesPeople)}
    ]);
    
    const isOpen = reactive({
        'Lead Details': false,
        'Description': false,
        'Customer Contact': false,
        'Salespeople': false,
        'Tasks': false,
        'Calendar': false,
        'Proposals': false,
        'Invoices': false,
        'Automations': false,
        'Files': false,
        'Stage Payments': false
    });

    function toggleAccordion(accordionName){
        isOpen[accordionName] = !isOpen[accordionName];
    }

    function getChevronClass(accordionName) {
        return isOpen[accordionName] ? 'fa fa-caret-down' : 'fa fa-caret-right';
    }

    function getDetailsContent(){
        return `<ul class='mb-3 cursor-default'>
                    <li class="py-1"><p class="small-overflow d-flex"><a class="txt-success f-w-500 mr-2 mb-auto" style="width: 90px;">Title:</a><a class="f-w-100 flex-grow-1 txt-info">${lead.value.opportunity_title}</a></p></li>
                    <li class="py-1"><p class="small-overflow d-flex"><a class="txt-success f-w-500 mr-2 mb-auto" style="width: 90px;">Address:</a><a class="f-w-100 flex-grow-1 txt-info">${lead.value.street_address} ${lead.value.city} ${lead.value.state} ${lead.value.zipcode}</a></p></li>
                    <li class="py-1"><p class="small-overflow d-flex"><a class="txt-success f-w-500 mr-2 mb-auto" style="width: 90px;">Contact:</a><a class="f-w-300 flex-grow-1 txt-secondary cursor-pointer">${ formatPhoneNumber(lead.value.opportunity_phone) }</a></p></li>
                    <li class="py-1"><p class="small-overflow d-flex"><a class="txt-success f-w-500 mr-2 mb-auto" style="width: 90px;">Tags:</a><span class="flex-grow-1">${ getBadgesOfStrings(tagsData.value, 'tags') }</span></p></li>
                    <li class="py-1"><p class="small-overflow d-flex"><a class="txt-success f-w-500 mr-2 mb-auto" style="width: 90px;">Sources:</a><span class="flex-grow-1">${ getBadgesOfStrings(sourcesData.value, 'sources') }</span></p></li>
                    <li class="py-1"><p class="small-overflow d-flex"><a class="txt-success f-w-500 mb-auto" style="width: 100px;">Job Types:</a><span class="flex-grow-1">${ getBadgesOfStrings(jobTypesData.value, 'jobtypes') }</span></p></li>
                </ul>`;
    }

    function getDescriptionContent(){
        return `<ul class='mb-3 cursor-default'><li><p class="small-overflow"><small>${lead.value.description}</small></p></li></ul>`;
    }

    function getCustomerContent(){
        return `<ul class='mb-3 cursor-default'>
                    <li class="py-1"><p class="small-overflow d-flex"><a class="txt-success f-w-500 mr-2 mb-auto">Primary:</a><a class="f-w-300 flex-grow-1 txt-secondary cursor-pointer">${formatPhoneNumber(customer.cell_phone)}</a></p></li>
                    <li class="py-1"><p class="small-overflow d-flex"><a class="txt-success f-w-500 mr-2 mb-auto">Secondary:</a><a class="f-w-300 flex-grow-1 txt-secondary cursor-pointer">${formatPhoneNumber(customer.phone)}</a></p></li>
                    <li class="py-1"><p class="small-overflow d-flex"><a class="txt-success f-w-500 mr-2 mb-auto">Email:</a><a class="f-w-300 flex-grow-1 txt-danger cursor-pointer">${customer.email}</a></p></li>
                </ul>`;
    }

    function getSalespeopleContent(sales_people){
        const arrayOfUser = sales_people.value;
        if (!Array.isArray(arrayOfUser)) return '';
        
        let imagePath = '../../../assets/test-images/user/2.jpg';

        let listItems = arrayOfUser.map(item => 
            `<ul class='mb-3 cursor-default'>
                    <li class="py-1">
                        <div class="media">
                            <div class="img-30 border rounded-circle" style="height: 30px; width: 30px;">
                                <img class="me-3 rounded-circle" src="${imagePath}" alt="">
                            </div>
                            <p class="small-overflow d-flex ml-2">
                                <a class="txt-success f-w-500 mr-2 mb-auto">${item.user.display_name}</a>
                            </p>
                        </div>
                    </li>
                    <li class="py-1"><p class="small-overflow d-flex ml-5"><a class="txt-success f-w-500 mr-2 mb-auto">Primary:</a><a class="f-w-300 flex-grow-1 txt-secondary cursor-pointer">${formatPhoneNumber(item.user.phone)}</a></p></li>
                    <li class="py-1"><p class="small-overflow d-flex ml-5"><a class="txt-success f-w-500 mr-2 mb-auto">Email:</a><a class="f-w-300 flex-grow-1 txt-danger cursor-pointer">${item.user.email}</a></p></li>
                </ul>`
        ).join('');
        
        return `<ul class='mb-3 cursor-default'>${listItems}</ul>`;
    }

    function getBadgesOfStrings(array, type = '') {
        if(array){
            let arrayOfString = '';
            if(type === 'tags'){
                arrayOfString = array.map(tag => tag.tag.tags_name);
            }else if(type === 'sources'){
                arrayOfString = array.map(source => source.source.source_name);
            }else if(type === 'jobtypes'){
                arrayOfString = array.map(jobType => jobType.job_type.job_type_name);
            }

            if (!Array.isArray(arrayOfString)) return '';
            
            return arrayOfString.map(item => 
                `<span class="badge badge-primary" style="height: 20px;">${item}</span>`
            ).join(' ');
        }else{
            return 'N/A';
        }
    }

    function formatPhoneNumber(number) {
        if(number){
            const cleaned = ('' + number).replace(/\D/g, '');
            const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
            if (match) {
                    return '(' + match[1] + ') ' + match[2] + '-' + match[3];
            }
            return number;
        }else{
            return 'N/A';
        }
    }

    const getLeadDetails = async (id) => {
        try {
            fetchingData.value = true;
            const response = await axios.get(`/api/getLeadDetails/${id}`, {}, {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = response.data;
            if(data.status === 'success'){
                const fetchLead = data.data.lead;
                lead.value = fetchLead;
                customer.value = fetchLead.lead_customer;
                tagsData.value = fetchLead.tags;
                sourcesData.value = fetchLead.sources;
                jobTypesData.value = fetchLead.job_types;
                salesPeople.value = fetchLead.sales_people;

                leftAccordions.value = [
                    {title: 'Lead Details', icon: 'fa fa-list m-0', content: getDetailsContent()},
                    {title: 'Description', icon: 'fa fa-info-circle m-0', content: getDescriptionContent()},
                    {title: 'Customer Contact', icon: 'fa fa-phone-square m-0', content: getCustomerContent()},
                    {title: 'Salespeople', icon: 'fa fa-users m-0', content: getSalespeopleContent(salesPeople)}
                ];
                componentKey.value++;
                console.log(lead.value);
            }

            fetchingData.value = false;
        } catch (error) {
            console.error("Error fetching  payment request: ", error);
        }
    }; 

   
   watch(() => props.jobsite_id, (newValue) => {
        if(newValue !== 0){
            getLeadDetails(newValue);
        }
    }, { deep: true });
</script>