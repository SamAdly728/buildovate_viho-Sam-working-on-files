<style scoped>
.half-page-cover {
  height: 100vh;
  max-width: 50.4%;
}
*::-webkit-scrollbar {
  display: none;
}

.exit-slider:hover {
  color: #739bd4 !important;
}

.exit-slider {
  color: #1E5BB2  !important;
  cursor: pointer;
}
.switch {
  position: relative;
  display: inline-block;
  width: 30px;
  height: 16px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider-2 {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: white;
  transition: .4s;
  border: 2px solid #b80000;
  border-radius: 35px;
}

.slider-2:before {
  position: absolute;
  content: "";
  height: 8px;
  width: 8px;
  left: 4px;
  bottom: 2px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
  border: 3px solid #b80000;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: white;
  transition: .4s;
  border: 2px solid #1E5BB2 ;
  border-radius: 35px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 8px;
  width: 8px;
  left: 1px;
  bottom: 2px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
  border: 3px solid #1E5BB2 ;
}


input:checked + .slider {
  background-color: white;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  transform: translateX(12px);
}

.nav-tabs .nav-link.active {
  background-color: #739bd4 !important;
  color: white !important;
}

</style>
<template>
  <div class="container-fluid p-0">
    <div id="slider" class="card top-half half-page-cover">
      <div class="card-body p-3 overflow-auto slim-scroll-light">
        <div class="d-flex justify-content-end">
          <i class="icofont icofont-close-squared-alt h4 exit-slider" @click="closeSlider"></i>
        </div>
        <div class="card p-3 mt-2 b-radius-10 b-primary-v2 shadow-sm">
          <div class="d-flex justify-content-between align-items-center">
            <div><h2 class="f-35 f-w-600 text-dark">{{uData.display_name}}</h2></div>
            <div :class="classForNotValidated">
              <span>Login as [user]</span>
            </div>
            <div>
              <span :class="classForNotValidated">Account Status [
                <span class="badge badge-danger" v-if="accountStatus == 0">Deleted / Inactive</span>
                <span class="badge badge-success" v-if="accountStatus == 1">Active</span>
                <span class="badge badge-warning" v-if="accountStatus == 2">Not Validated</span>
                ]</span>
            </div>
            <div :class="classForNotValidated" class="media">
              <div class="media-body switch-sm mt-1 m-r-5 text-end icon-state">
                <label class="switch">
                  <input @change="revokeAccount(uData.user_id)" type="checkbox" :disabled="uData.account_status != 1 && uData.account_status != 0" :checked="uData.account_status == 1">
                  <span :class="slideButtonClass"></span>
                </label>
              </div>
              <label class="col-form-label mt-1"><span :class="activeUserClass">Active</span> <span class="text-muted">/</span> <span :class="deactivatedUserClass">Inactive</span></label>
            </div>
          </div>
        </div>
        <div class="b-primary-v2 b-radius-10 shadow-sm">
          <div class="pt-4 p-l-25 p-r-25">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#edit-user-tab" role="tab" aria-controls="edit-user-tab" aria-selected="false">User Information</a></li>
              <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#permissions-tab" role="tab" aria-controls="permissions-tab" aria-selected="true">Permissions</a></li>
              <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#calendar-tab" role="tab" aria-controls="calendar-tab" aria-selected="false">Calendar</a></li>
              <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#pay-rate-tab" role="tab" aria-controls="pay-rate-tab" aria-selected="false">Pay Rate</a></li>
              <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#notifications-tab" role="tab" aria-controls="notifications-tab" aria-selected="false">Notifications</a></li>
              <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#job-access-tab" role="tab" aria-controls="job-access-tab" aria-selected="false">Job Access</a></li>
              <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#security-tab" role="tab" aria-controls="security-tab" aria-selected="false">Security / Login</a></li>
            </ul>
            <div class="tab-content" id="content">
              <div class="tab-pane fade show active" id="edit-user-tab" role="tabpanel" aria-labelledby="edit-user-tab">
                <editUser :userData="userData" :roles="roles"></editUser>
              </div>
              <div class="tab-pane fade" id="permissions-tab">
                <permissions :roles="roles" :newUser="false"></permissions>
              </div>
              <div class="tab-pane fade" id="calendar-tab">
                <calendar></calendar>
              </div>
              <div class="tab-pane fade" id="pay-rate-tab">
                <payRate :userData="userData" :newUser="false"></payRate>
              </div>
              <div class="tab-pane fade" id="notifications-tab">
                <notifications></notifications>
              </div>
              <div class="tab-pane fade" id="job-access-tab">
                <jobaccess></jobaccess>
              </div>
              <div class="tab-pane fade" id="security-tab">
                <securityAndLogin :userData="userData"></securityAndLogin>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import editUser from "../user_management/slider_tabs/EditUser.vue"
import permissions from "../user_management/slider_tabs/Permissions.vue"
import calendar from "../user_management/slider_tabs/Calendar.vue"
import securityAndLogin from "../user_management/slider_tabs/SecurityAndLogin.vue"
import jobaccess from "../user_management/slider_tabs/JobAccess.vue"
import payRate from "../user_management/slider_tabs/PayRate.vue"
import notifications from "../user_management/slider_tabs/Notifications.vue"
import axios from "axios";
import {router} from "@inertiajs/vue3";
export default {
  props: ['userData', 'roles', 'userPayRate'],
  components: {editUser, permissions, calendar, payRate, notifications, jobaccess, securityAndLogin},
  data() {
    return {
      uData: this.userData,
      activeUserClass: '',
      deactivatedUserClass: '',
      classForNotValidated: '',
      accountStatus: null,
      slideButtonClass: ''
    }
  },
  methods: {
    revokeAccount(userId) {
      let isChecked = event.target.checked
      let action = null
      if (isChecked) {
        this.activeUserClass = 'text-primary'
        this.deactivatedUserClass = 'text-muted'
        this.slideButtonClass = 'slider'
        action = 1
      }else{
        this.activeUserClass = 'text-muted'
        this.deactivatedUserClass = 'text-danger'
        this.slideButtonClass = 'slider-2'
        action = 0
      }
      axios.post('/company/users/revoke-access', {userId:userId, action:action}).then((res) => {
        if(res.status == 200) {
          this.accountStatus = res.data.account_status
          this.$emit('reload-parent')
        }
      })
    },
    closeSlider() {
      this.$emit('close-slider', false)
    },
    setClassesForAccountStatus() {
      if (this.userData.account_status == 1) {
        this.activeUserClass = 'text-primary'
        this.deactivatedUserClass = 'text-muted'
        this.slideButtonClass = 'slider'
      }

      if (this.userData.account_status == 0) {
        this.activeUserClass = 'text-muted'
        this.deactivatedUserClass = 'text-danger'
        this.slideButtonClass = 'slider-2'
      }

      if (this.userData.account_status != 1 && this.userData.account_status != 0) {
        this.classForNotValidated = 'disabled'
      }
    }
  },
  mounted() {
    this.setClassesForAccountStatus()
    this.accountStatus = this.userData.account_status
  }
}
</script>