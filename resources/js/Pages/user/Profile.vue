<style scoped>
.active {
  background-color: #FFFFFF !important;
}

.nav-link.active {
  color: blue !important;
}

.nav-tabs .nav-link {
  border-bottom: none !important;
}

.centered-on-screen {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 9999;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.5) !important;
}
backdrop {
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.5) !important;
}
</style>
<template>
  <div class="centered-on-screen" v-if="showLoader">
    <div class="backdrop"></div>
    <div class="d-flex flex-column align-items-center">
      <div style="height: 400px; margin-top: 15%">
        <LoadingMetric></LoadingMetric>
      </div>
    </div>
  </div>
  <div class="container-fluid p-20">
    <div class="edit-profile">
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="card-title mb-0 justify-content-between d-flex">
                <span class="h4">My Profile</span>
                <button class="btn btn-primary" data-bs-toggle="modal" data-original-title="test"
                        data-bs-target="#edit-profile">Edit
                </button>
              </div>
<!--              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i-->
<!--                  class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i-->
<!--                  class="fe fe-x"></i></a></div>-->
            </div>
            <div class="card-body">
              <form>
                <div class="row mb-2">
                  <div class="profile-title">
                    <div class="media">
                      <img class="img-70 rounded-circle" alt="" :src="'/assets/images/user/7.jpg'">
                      <div class="media-body">
                        <h3 class="mb-1 f-20 txt-primary">{{ user.first_name + ' ' + user.last_name }}</h3>
                        <p class="f-12">{{ user.role }}</p>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input v-model="email" class="form-control" placeholder="your-email@domain.com" disabled>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <br>
                    <div class="flex">
                    <input v-model="password" :type="(pwd_visible) ? 'text' : 'password'" class="form-control"
                           style=";display:inline-block">
                    <a @click="pwd_visible=!pwd_visible" href="javascript:void(0)" class="btn ps-4"
                       :class="(pwd_visible) ? 'text-success' : 'text-muted'">
                      <i class="fs-5 icofont " :class="(pwd_visible) ? 'icofont-eye' : 'icofont-eye-blocked'"></i>
                    </a>
                    </div>
                  </div>
                </div>
                <div class="form-footer">
                  <button @click="updatePassword" type="button" class="btn btn-primary btn-block"
                          :disabled="password=='password' || password==''">Save
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-xl-12">
          <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#permissions" role="tab" aria-controls="home" aria-selected="true">Permission</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tabs" data-bs-toggle="tab" href="#notifications" role="tab" aria-controls="profile" aria-selected="false">Notifications</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#messaging" role="tab" aria-controls="contact" aria-selected="false">Messaging</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#job-access" role="tab" aria-controls="contact" aria-selected="false">Job Access</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#security-login" role="tab" aria-controls="contact" aria-selected="false">Security & Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#others" role="tab" aria-controls="contact" aria-selected="false">Other</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
              <div class="card rounded-bottom border-top-0">
                <div class="card-body">
                  Permissions
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
              <div class="card rounded-bottom border-top-0">
                <div class="card-body">
                  Notifications
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="messaging" role="tabpanel" aria-labelledby="messaging-tab">
              <div class="card rounded-bottom border-top-0">
                <div class="card-body">
                  Messaging
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="job-access" role="tabpanel" aria-labelledby="job-access-tab">
              <div class="card rounded-bottom border-top-0">
                <div class="card-body">
                  Job Access
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="security-login" role="tabpanel" aria-labelledby="security-login-tab">
              <div class="card rounded-bottom border-top-0">
                <div class="card-body">
                  Security & Login
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="others" role="tabpanel" aria-labelledby="others-tab">
              <div class="card rounded-bottom border-top-0">
                <div class="card-body">
                  Others
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Profile Modal -->
  <div class="modal fade" id="edit-profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="" @submit.prevent="updateProfile" method="POST">
<!--            <div class="card-header pb-0">-->
<!--              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i-->
<!--                  class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i-->
<!--                  class="fe fe-x"></i></a></div>-->
<!--            </div>-->
            <div class="">
              <div class="row">
                <div class="col-sm-6 col-md-6">
                  <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input class="form-control" type="text" placeholder="First Name" v-model="profileData.first_name">
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input class="form-control" type="text" placeholder="Last Name" v-model="profileData.last_name">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="mb-3">
                    <label class="form-label">Address</label>
                    <vue-google-autocomplete
                        id="profile-street-address"
                        name="profile-street-address"
                        classname="form-control"
                        placeholder="Street Address"
                        @input="newAddress"
                        v-on:placechanged="getAddressData"
                        :country="['us']"
                        :type="['address']">
                    </vue-google-autocomplete>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4">
                  <div class="mb-3">
                    <label class="form-label">City</label>
                    <input class="form-control" type="text" placeholder="City" v-model="profileData.city">
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label">Postal Code</label>
                    <input class="form-control" type="number" placeholder="ZIP Code" v-model="profileData.zipcode">
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="mb-3">
                    <label class="form-label">Country</label>
                    <input class="form-control" type="text" placeholder="Country" v-model="profileData.country">
                  </div>
                </div>
              </div>
            </div>
            <div class="text-end">
              <button class="btn btn-primary" type="submit">Update Profile</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import LoadingMetric from '@/components/LoadingStyleMetric.vue';
</script>
<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import VueGoogleAutocomplete from "vue-google-autocomplete";
import {Inertia} from "@inertiajs/inertia";

export default {
  name: 'UserProfile',
  components: {VueGoogleAutocomplete},
  props: ['user', 'bus'],
  data() {
    return {
      user: this.user,
      bus: this.bus,
      pwd_visible: false,
      email: this.user.email,
      password: 'password',
      profileData: {
        first_name: '',
        last_name: '',
        street: '',
        city: '',
        zipcode: '',
        country: ''
      },
      showLoader: false
    }
  },
  methods: {
    updatePassword() {
      axios.post('/user/update-password', {new_password: this.password})
          .then((res) => {
            if (res.data.success) {
              Swal.fire({
                text: "Success! Password updated.",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn btn-success"
                }
              })
            }
          });
    },
    async updateProfile() {
      let thisInstance = this
      if (this.profileData.street.length == 0) {
        this.profileData.street = $('#profile-street-address').val()
      }
      try {

        await axios.post('/user/update-profile', this.profileData).then(response => {
          if (response.data.success) {
            Swal.fire({
              text: "Success! Profile updated.",
              icon: "success",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn btn-success"
              }
            }).then(function() {
              thisInstance.showLoader = true
              $('#edit-profile').modal('hide')
              Inertia.reload()
            })
          }
        })
      } catch (error) {
        console.log(error)
      }
      finally {
        this.showLoader = false
      }
    },
    newAddress: function () {
      this.profileData.street = event.target.value
    },
    getAddressData: function (addressData, placeResultData, id) {
      const placeAddress = placeResultData.address_components
      console.log(placeAddress)

      let streetAddress = ''

      for (const component of placeAddress) {
        const componentType = component.types[0]
        switch (componentType) {
          case "street_number":
            streetAddress = component.long_name;
            break;
          case "route":
            streetAddress += ' ' + component.long_name;
            break;
          case "postal_code":
            if (id === "profile-street-address")
              this.profileData.zipcode = component.long_name;
            else
              this.profileData.zipcode = component.long_name;
            break;
          case "administrative_area_level_1":
            if (id === "profile-street-address")
              this.profileData.country = component.long_name;
            else
              this.profileData.country = component.long_name
            break;
          case "administrative_area_level_2":
            if (id === "profile-street-address")
              this.profileData.country = component.long_name;
            else
              this.profileData.country = component.long_name
            break;
          case "neighborhood":
            if (id === "profile-street-address")
              this.profileData.city = component.long_name;
            else
              this.profileData.city = component.long_name
            break;
        }
      }

      if (streetAddress) {
        if (id === "profile-street-address") {
          $('#profile-street-address').val(streetAddress);
          this.profileData.street = streetAddress;
        }
      }
    }
  },
  mounted() {
    $('#profile-street-address').val(this.bus.business_street)
    this.profileData.first_name = this.user.first_name
    this.profileData.last_name = this.user.last_name
    this.profileData.city = this.bus.business_city
    this.profileData.zipcode = this.bus.business_zipcode
    this.profileData.country = this.bus.business_country
  }
}
</script>

