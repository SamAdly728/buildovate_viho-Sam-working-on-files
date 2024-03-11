<template>
   <div class="container-fluid p-20">
<!--      <Breadcrumb />-->
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header pb-0">
                  
                  <div class="pull-right flex align-items-center">
                    <a href="/inbox"><i class="icon-arrow-circle-left mr-2 h4 text-success turn-back" style="cursor: pointer" title="Go Back to Inbox"></i></a>
                     <a href="#" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#howItWorksModal"><i class="icofont icofont-warning-alt"></i> How It Works</a>
                     <Link href="/inbox/settings/new" class="btn btn-sm btn-primary me-1">New Team Inbox</Link>
                     <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#numberModal" class="btn btn-sm btn-primary">Add Number</a>
                  </div>
                  <h5>Manage Inboxes</h5>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="display table table-striped table-bordered">
                        <thead>
                           <th width="50%">Name</th>
                           <th width="25%">Status</th>
                           <th width="25%">Action</th>
                        </thead>
                        <tbody>
                           <tr v-for="s in settings" :key="s.id">
                              <td>
                                Connect {{ s.name }}
                              </td>
                              <td :class="(s.status==1) ? 'text-success' : 'text-secondary'">{{ (s.status==1) ? 'Connected' : 'Not Connected' }}</td>
                              <td>
                                 <button v-if="s.status==0" @click="setStatus(s.id, 1)" class="btn btn-success btn-sm">Connect</button>
                                 <button v-else  @click="setStatus(s.id, 0)" class="btn btn-danger btn-sm">Disconnect</button>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>

   
   <!-- MODALS  -->
   
   <div class="modal fade" id="howItWorksModal" tabindex="-1" role="dialog" aria-labelledby="howItWorksModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title"><i class="icofont icofont-ui-user-group"></i> How It Works</h5>
               <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row text-center">
                  <i class="icofont icofont-brand-youtube text-danger" style="font-size: 100px;margin-top: 40px;margin-bottom: 50px;"></i>
                  <!-- <iframe src=""></iframe> -->
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="modal fade" id="numberModal" tabindex="-1" role="dialog" aria-labelledby="numberModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Add Number</h5>
               <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- <form action="" method="POST"> -->
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="input-group mb-2">
                        <span class="input-group-text text-muted">Title:</span>
                        <input v-model="phone_number" class="form-control" type="text" placeholder="Title...">
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
               <button class="btn btn-secondary">Save changes</button>
            </div>
            <!-- </form> -->
         </div>
      </div>
   </div>

   </div>
</template>

<script setup>
import Breadcrumb from '@/components/Breadcrumb.vue';
import Swal from 'sweetalert2';
import axios from 'axios';
import { router } from '@inertiajs/vue3';

defineProps(['settings']);

function setStatus(id, status)
{
   axios.post( '/inbox/settings/set-status', { id:id, status:status } )
   .then((result) => {
      if (result.data) {
         Swal.fire({
            text: 'Success! Status updated.',
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
               confirmButton: "btn btn-success"
            }
         })

         router.reload();

         // document.getElementById('company_logo').src = URL.createObjectURL(this.companyBaseInfo.logo);
         document.getElementById('company_logo').innerText = this.companyBaseInfo.name;
      }
   })
}
</script>

