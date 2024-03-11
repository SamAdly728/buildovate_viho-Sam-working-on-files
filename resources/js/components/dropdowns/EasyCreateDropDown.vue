<template>
    <Transition name="slide-fade">
        <div class="bg-white easycreate-dropdown shadow-lg d-flex flex-column">
            <a class="text-muted f-w-600 f-12 px-3 py-2">Easy access to create: </a>
            <a class="text-muted f-w-600 f-12 px-3 py-0 pt-3">Sales: </a>
            <div class="row m-0 p-0">
                <a class="text-dark f-14 f-w-600 px-3 py-2 bg-hover-primary-primary col-md-6" style="cursor: pointer;" 
                    @click="handleLeadClick">
                    <a>Lead</a>
                </a>
                <a class="text-dark f-14 f-w-600 px-3 py-2 bg-hover-primary-primary col-md-6" style="cursor: pointer;" 
                    @click="handleProposalClick">
                    <a>Proposal</a>
                </a>
            </div>
            <a class="text-muted f-w-600 f-12 px-3 py-0 pt-3">People: </a>
            <div class="row m-0 p-0">
                <a class="text-dark f-14 f-w-600 px-3 py-2 bg-hover-primary-primary col-md-6" style="cursor: pointer;" 
                    @click="handleUserClick">
                    <a>User</a>
                </a>
                <a class="text-dark f-14 f-w-600 px-3 py-2 bg-hover-primary-primary col-md-6" style="cursor: pointer;" 
                    @click="handleCustomerClick">
                    <a>Customer</a>
                </a>
            </div>
            <a class="text-muted f-w-600 f-12 px-3 py-0 pt-3">Others: </a>
            <a class="text-dark f-14 f-w-600 px-3 py-2 bg-hover-primary-primary" style="cursor: pointer;" 
                @click="handleInvoiceClick">
                <a>Invoice</a>
            </a>
            <a class="text-dark f-14 f-w-600 px-3 py-2 bg-hover-primary-primary" style="cursor: pointer;" 
                @click="handleServicePlanClick">
                <a>Service Plan</a>
            </a>
            <a class="text-dark f-14 f-w-600 px-3 py-2 bg-hover-primary-primary" style="cursor: pointer;" 
                @click="handleAutomationClick">
                <a>Automation Service</a>
            </a>
        </div>
    </Transition>
</template>
<script>
import Swal from 'sweetalert2';
import { useNewLeadSidebar } from '../../stores/new-lead';

export default{
  setup(){
    const newLeadStore = useNewLeadSidebar();
    
    return {newLeadStore}
  },
    methods: {
        handleLeadClick(){
            // Swal.fire({
            //     icon: 'info',
            //     title: 'Coming soon!',
            //     text: 'Easy Creation of lead is coming very soon ;)',
            // });
            this.newLeadStore.setFormType('lead');
            this.newLeadStore.open();
        },
        handleProposalClick(){
            Swal.fire({
                icon: 'info',
                title: 'Coming soon!',
                text: 'Easy Creation of proposal is coming very soon ;)',
            });
        },
        handleUserClick(){
            Swal.fire({
                icon: 'info',
                title: 'Coming soon!',
                text: 'Easy Creation of user is coming very soon ;)',
            });
        },
        handleCustomerClick(){
            Swal.fire({
                icon: 'info',
                title: 'Coming soon!',
                text: 'Easy Creation of customer is coming very soon ;)',
            });
        },
        handleInvoiceClick(){
            Swal.fire({
                icon: 'info',
                title: 'Coming soon!',
                text: 'Easy Creation of invoice is coming very soon ;)',
            });
        },
        handleServicePlanClick(){
            Swal.fire({
                icon: 'info',
                title: 'Coming soon!',
                text: 'Easy Creation of service plan is coming very soon ;)',
            });
        },
        handleAutomationClick(){
            Swal.fire({
                icon: 'info',
                title: 'Coming soon!',
                text: 'Easy Creation of automation service is coming very soon ;)',
            });
        }
    }
}
</script>