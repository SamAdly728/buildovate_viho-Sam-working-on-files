<style>
.divider{
   /* margin-top: -10px;
   background-color: #ffffff; */
}
</style>
<template>
   <div class="container-fluid p-20">
      <Breadcrumb />

      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header pb-0">
                  <h5>New Inbox Settings</h5>
                  <hr>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col">
                        <div class="mb-3 row">
                           <label class="col-sm-3 col-form-label">Inbox Name</label>
                           <div class="col-sm-9">
                           <input v-model="form.name" class="form-control" type="text" placeholder="Name">
                           </div>
                        </div>
                        <div class="mb-3 row">
                           <label class="col-sm-3 col-form-label">Phone number</label>
                           <div class="col-sm-9">
                           <input v-model="form.phone_number" class="form-control" type="text" placeholder="Phone number"> (Edit)
                           </div>
                        </div>
                        <div class="mb-3 row text-success">
                           CALL SETTINGS
                        </div>
                        <div class="mb-3 row">
                           <label class="col-sm-3 col-form-label">Call Routing</label>
                           <div class="col-sm-9">
                              <table class="table table-bordered">
                                 <thead>
                                    <td>Team Member</td>
                                    <td>Ring Desktop</td>
                                    <td>Ring Mobile</td>
                                    <td>Press 1 to Answer</td>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td colspan="4" class="text-muted">No team members selected. Add one or more using the button below.</td>
                                    </tr>
                                 </tbody>
                              </table>
                              
                              <button class="btn btn-primary mt-4 mb-4"><i class="fa fa-plus"></i>&nbsp;Add Team Member</button>

                           </div>
                        </div>
                        <div class="mb-3 row">
                           <label class="col-sm-3 col-form-label">Voicemail</label>
                           <div class="col-sm-9">
                              <span class="text-muted">Please save this team inbox before recording a voicemail</span>
                           </div>
                        </div>
                        <div class="mb-3 row">
                           <label class="col-sm-3 col-form-label">Do not disturb</label>
                           <div class="col-sm-9">
                              <label  for="chkani">
                                 <input v-model="form.do_not_disturb" @click="check" class="checkbox_animated" id="chkani" name="do_not_disturb" type="checkbox">
                                 <span v-if="!form.do_not_disturb">If enabled, n</span>
                                 <span v-else>N</span>o team members will be called.
                              </label>
                           </div>
                        </div>
                        <div  v-if="!form.do_not_disturb" class="mb-3 row">
                           <label class="col-sm-3 col-form-label">If outside office hours ( Edit )</label>
                           <div class="col-sm-9">
                              <span class="text-muted">You can set rules for incoming calls to be forwarded outside of office hours. First, set your company's office hours by following the edit link above.</span>
                           </div>
                        </div>
                        <div class="mb-3 row">
                           <label class="col-sm-3 col-form-label">
                              <span v-if="!form.do_not_disturb">If there's no answer</span>
                           </label>
                           <div class="col-sm-9">
                              <div v-if="form.do_not_disturb">All calls will:</div>
                              <div class="mt-2">
                                 <label  for="aca1">
                                    <input  v-model="form.call_forwarding" value="voicemail" class="radio_animated" id="aca1" name="all_calls_action" type="radio" checked>
                                    Go to inbox voicemail
                                 </label><br>
                                 <label  for="aca2">
                                    <input  v-model="form.call_forwarding" value="number" class="radio_animated" id="aca2" name="all_calls_action" type="radio">
                                    Forward to number
                                 </label>
                              </div>
                           </div>
                        </div>
                        <div class="mb-3 row text-success text-center">
                           <!-- <hr> -->
                           <div class="col-sm-12 text-center divider">EMAIL</div>
                        </div>
                        <div class="mb-3 row">
                           <div class="col-sm-12 text-center">
                              You will be able to connect an email address to this team inbox after it is created.
                           </div>
                        </div>
                        <div class="mb-3 row">
                           <hr>
                        </div>
                        <div class="row">
                           <div class="col-sm-12 text-right p-4">
                              <button type="button" class="">Cancel</button>&nbsp;&nbsp;
                              <button @click="saveTeamInbox" type="button" class="btn btn-primary ">Save </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script setup>
import Breadcrumb from '@/components/Breadcrumb.vue';
</script>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';

export default{
   data() {
      return {
         form: {
            id: 0,
            name: '',
            phone_number: '',
            do_not_disturb: false,
            call_forwarding: 'voicemail',
         }
      }
   },
   methods:{
      saveTeamInbox(){
         axios.post('/inbox/settings/save-team-inbox', this.form )
            .then((result) => {
              if (result.data.status) {

               Swal.fire({
                  text: result.data.message,
                  icon: "success",
                  buttonsStyling: false,
                  confirmButtonText: "Close",
                  customClass: {
                    confirmButton: "btn btn-success"
                  }
               })

              }else{

               Swal.fire({
                  text: result.data.message,
                  icon: "error",
                  buttonsStyling: false,
                  confirmButtonText: "Close",
                  customClass: {
                     confirmButton: "btn btn-danger"
                  }
               });

              }
            })
      }
   }
}
</script>

