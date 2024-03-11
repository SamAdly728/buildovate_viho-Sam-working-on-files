<style scoped>
.nav-tabs .nav-link.active {
  background-color: #739bd4 !important;
  color: white !important;
}

*::-webkit-scrollbar {
  display: none !important;
}
</style>
<template>
  <div class="modal fade" id="addCrew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg zoomIn modal-dialog-centered modal-dialog-scrollable" role="document" style="max-width: 1000px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            New {{isStaffOrPro == 'staff' ? 'Staff' : 'Pro'}} Member
          </h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" @click="clearModal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="b-primary-v2 b-radius-10 shadow-sm">
            <div class="pt-4 p-l-25 p-r-25">
              <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#new-staff-tab" role="tab" aria-controls="new-staff-tab" aria-selected="false">{{isStaffOrPro == 'staff' ? 'Staff' : 'Pro'}} Information</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#permissions-tab" role="tab" aria-controls="permissions-tab" aria-selected="true">Permissions</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#calendar-tab" role="tab" aria-controls="calendar-tab" aria-selected="false">Calendar</a></li>
                <li class="nav-item" v-if="isStaffOrPro == 'staff'"><a class="nav-link" data-bs-toggle="tab" href="#pay-rate-tab" role="tab" aria-controls="pay-rate-tab" aria-selected="false">Pay Rate</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#notifications-tab" role="tab" aria-controls="notifications-tab" aria-selected="false">Notifications</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#job-access-tab" role="tab" aria-controls="job-access-tab" aria-selected="false">Job Access</a></li>
<!--                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#security-tab" role="tab" aria-controls="security-tab" aria-selected="false">Security / Login</a></li>-->
              </ul>
              <div class="tab-content" id="content">
                <div class="tab-pane fade show active" id="new-staff-tab" role="tabpanel" aria-labelledby="edit-user-tab">
                  <newUser :isStaffOrPro="isStaffOrPro" :roles="roles"></newUser>
                </div>
                <div class="tab-pane fade" id="permissions-tab">
                  <permissions :roles="roles" :isStaffOrPro="isStaffOrPro" :newUser="true"></permissions>
                </div>
                <div class="tab-pane fade" id="calendar-tab">
                  <calendar></calendar>
                </div>
                <div class="tab-pane fade" id="pay-rate-tab" v-if="isStaffOrPro == 'staff'">
                  <payRate :userData="[]" :newUser="true" ></payRate>
                </div>
                <div class="tab-pane fade" id="notifications-tab">
                  <notifications></notifications>
                </div>
                <div class="tab-pane fade" id="job-access-tab">
                  <jobaccess></jobaccess>
                </div>
                <div class="tab-pane fade" id="security-tab">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import Swal from "sweetalert2";
import axios from "axios";
import {router} from "@inertiajs/vue3";
import calendar from "@/components/user_management/slider_tabs/Calendar.vue";
import permissions from "@/components/user_management/slider_tabs/Permissions.vue";
import notifications from "@/components/user_management/slider_tabs/Notifications.vue";
import editUser from "@/components/user_management/slider_tabs/EditUser.vue";
import jobaccess from "@/components/user_management/slider_tabs/JobAccess.vue";
import securityAndLogin from "@/components/user_management/slider_tabs/SecurityAndLogin.vue";
import payRate from "@/components/user_management/slider_tabs/PayRate.vue";
import newUser from "@/components/user_management/add_user/NewUserForm.vue"
export default {
  components: {
    newUser,
    payRate,
    securityAndLogin,
    jobaccess,
    editUser,
    notifications,
    permissions,
    calendar
  },
  props: ['roles', 'isStaffOrPro'],

  methods: {

  }
}
</script>