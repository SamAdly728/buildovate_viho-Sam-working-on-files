<template>
    <Transition name="slide-fade">
        <div class="bg-white manage-people-dropdown shadow-lg d-flex flex-column">
            <a class="text-muted f-w-600 f-12 px-3 py-2">Manage People:</a>
            <a class="text-dark f-14 f-w-600 px-3 py-2 d-flex gap-3 bg-hover-primary-primary align-items-center" style="cursor: pointer;" @click="handleUsersClick">
                <i class="f-20 f-w-700 icon-id-badge"></i>
                <div class="d-flex flex-column">
                    <a>Internal Users</a>
                    <a class="text-muted f-12">View and manage internals users.</a>
                </div>
            </a>
            <a class="text-dark f-14 f-w-600 px-3 py-2 d-flex gap-3 bg-hover-primary-primary align-items-center" style="cursor: pointer;" @click="handleVendorsClick">
                <i class="f-20 f-w-700 icon-home"></i>
                <div class="d-flex flex-column">
                    <a>Subs/Vendors</a>
                    <a class="text-muted f-12">View and manage subs/vendors.</a>
                </div>
            </a>
            <a class="text-dark f-14 f-w-600 px-3 py-2 d-flex gap-3 bg-hover-primary-primary align-items-center" style="cursor: pointer;" @click="handleCustomerClick">
                <i class="f-20 f-w-700 icon-cup"></i>
                <div class="d-flex flex-column">
                    <a>Customers</a>
                    <a class="text-muted f-12">View and manage customer.</a>
                </div>
            </a>
        </div>
    </Transition>
</template>
<script>
import Swal from 'sweetalert2';

export default{
    methods: {
        handleUsersClick(){
            Swal.fire({
                icon: 'info',
                title: 'Temporary closed!',
                text: 'Work in this part next ;)',
            });
        },
        handleVendorsClick(){
            Swal.fire({
                icon: 'info',
                title: 'Temporary closed!',
                text: 'Work in this part next ;)',
            });
        },
        handleCustomerClick(){
            Swal.fire({
                icon: 'info',
                title: 'Temporary closed!',
                text: 'Work in this part next ;)',
            });
        }
    }
}
</script>