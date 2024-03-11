<template>
  <div class="card b-primary-v2 b-radius-10 shadow-sm mt-3">
    <form class="theme-form pt-4" method="POST" @submit.prevent="sendInvite">
      <div class="card-body pt-0">
        <div class="row">
          <div class="col-sm-6 col-md-6">
            <div class="mb-3">
              <label class="form-label">First Name</label>
              <input class="form-control" type="text" placeholder="" v-model="formData.first_name">
            </div>
          </div>
          <div class="col-sm-6 col-md-6">
            <div class="mb-3">
              <label class="form-label">Last Name</label>
              <input class="form-control" type="text" placeholder="" v-model="formData.last_name">
            </div>
          </div>
          <div class="col-sm-4 col-md-4">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input class="form-control" type="email" placeholder="" v-model="formData.email">
            </div>
          </div>
          <div class="col-sm-4 col-md-4" v-if="isStaffOrPro == 'staff'">
            <div class="mb-3">
              <label class="form-label">User Type</label>
              <select class="form-control rounded" name="" id="" v-model="formData.userType">
                <option value="">Please select...</option>
                <option v-for="r in roles" :key="r.id" :value="r.id">{{ r.role_display_name }}</option>
              </select>
            </div>
          </div>
          <div class="col-sm-4 col-md-4" v-if="isStaffOrPro == 'pros'">
            <div class="mb-3">
              <label class="form-label">Pro Type</label>
              <select class="form-control rounded" name="" id="">
                <option value="" selected>Please select...</option>
                <option value="public">Public</option>
                <option value="private">Private</option>
              </select>
            </div>
          </div>
          <div class="col-sm-4 col-md-4">
            <div class="mb-3">
              <label class="form-label">Mobile Phone</label>
              <input class="form-control" type="number" placeholder="" v-model="formData.cellphone">
            </div>
          </div>
          <div class="col-sm-6 col-md-6">
            <div class="mb-3">
              <label class="form-label">Street Address</label>
              <vue-google-autocomplete
                  id="new_user_address"
                  name="new_user_address"
                  classname="form-control"
                  placeholder="Street Address"
                  @input="newUserAddress"
                  v-on:placechanged="getAddressDataForNewUser"
                  :country="['us']"
                  :type="['address']">
              </vue-google-autocomplete>
            </div>
          </div>

          <div class="col-sm-6 col-md-6">
            <div class="mb-3">
              <label class="form-label">City</label>
              <input class="form-control" type="text" placeholder="" v-model="formData.city">
            </div>
          </div>
          <div class="col-sm-2 col-md-2"></div>
          <div class="col-sm-4 col-md-4">
            <div class="mb-3">
              <label class="form-label">State</label>
              <input class="form-control" type="text" placeholder="" v-model="formData.state">
            </div>
          </div>
          <div class="col-sm-3 col-md-3">
            <div class="mb-3">
              <label class="form-label">Zip Code</label>
              <input class="form-control" type="number" placeholder="" v-model="formData.zip">
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="row">
              <div class="col">
                <label class="form-label">License #</label>
                <input class="form-control" type="text" placeholder="" v-model="formData.license">
              </div>
              <div class="col">
                <label class="form-label">License Expiration</label>
                <input class="form-control" type="text" placeholder="" v-model="formData.license_expiration">
              </div>
              <div class="col">
                <label class="form-label">EIN</label>
                <input class="form-control" type="text" placeholder="" v-model="formData.ein">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="row">
              <div class="col">
                <label class="form-label">General Liability Expiration</label>
                <input class="form-control" type="text" placeholder="" v-model="formData.general_liability_expiration">
              </div>
              <div class="col">
                <label class="form-label">Workers Comp Expiration</label>
                <input class="form-control" type="text" placeholder="" v-model="formData.workers_comp_expiration">
              </div>
              <div class="col">

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-end" style="border-top: none">
        <button class="btn btn-primary-v2">Create & Send Invite</button>
      </div>
    </form>
  </div>


</template>
<script>
import VueGoogleAutocomplete from "vue-google-autocomplete";
import Swal from "sweetalert2";
import axios from "axios";

export default {
  components: {VueGoogleAutocomplete},
  props: ['isStaffOrPro', 'roles'],
  data() {
    return {
      formData: {
        first_name: '',
        last_name: '',
        email: '',
        userType: '',
        street_address: '',
        city: '',
        zip: '',
        state: '',
        cellphone: '',
        license: '',
        license_expiration: '',
        ein: '',
        general_liability_expiration: '',
        workers_comp_expiration: ''
      },
    }
  },
  methods: {
    sendInvite() {
      // if user type is not 3 and 8
      let exceptKeys = [
        'license',
        'license_expiration',
        'ein',
        'general_liability_expiration',
        'workers_comp_expiration'
      ];

      if (this.isValidEmail(this.formData.email) && this.formData.email.length > 0) {
        let validate = this.validateRequiredField(this.formData, exceptKeys, this.formData.userType)

        if (validate.errorCount > 0) {

          let required = ''

          if (validate.requiredFields.length > 1) {
            required = 'These fields ' + validate.requiredFields.join(', ') + ' are required!'
          } else {
            required = 'This field ' + validate.requiredFields + ' is required!'
          }

          Swal.fire({
            html: required,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
              confirmButton: "btn btn-danger-v2"
            }
          });
        } else {
          axios.post('/company/users/send-invite', this.formData)
              .then((res) => {
                if (!res.data.success) {
                  Swal.fire({
                    html: res.data.message,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Close",
                    closeOnClickOutside: false,
                    customClass: {
                      confirmButton: "btn btn-danger-v2"
                    }
                  });
                } else {
                  Swal.fire({
                    html: res.data.message,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Close",
                    closeOnClickOutside: false,
                    customClass: {
                      confirmButton: "btn btn-success-v2"
                    }
                  })
                  //     .then((res) => {
                  //   if (res.isConfirmed) {
                  //     $('#addCrew').modal('hide')
                  //     $('.modal-backdrop').hide()
                  //   }
                  // });
                }
              }).catch((error) => {
            console.log(error.message);
          });
        }
      } else {
        Swal.fire({
          html: 'This field <i class="text-danger-v2">Email</i> is required!',
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Close",
          customClass: {
            confirmButton: "btn btn-danger-v2"
          }
        });
      }
      // console.log('form', this.formData);
    },
    validateRequiredField(fields, exceptKey, userType) {
      //user type that requires license and so on
      let user_type = [3, 8]
      let userTypeCheck = user_type.includes(userType)
      let error = {
        'errorCount': 0,
        'requiredFields': []
      }


      //if user is engineer or installer check all
      if (userTypeCheck) {
        $.each(fields, function (key, value) {
          if (value.length === 0) {
            error.errorCount++
            error.requiredFields.push(`<i class="text-danger-v2">${key.replace(/_/g, ' ').toUpperCase()}</i>`)
          }
        })
      }

      // for users that are not engineer or installers
      if (!userTypeCheck) {
        $.each(fields, function (key, value) {
          let i = $.inArray(key, exceptKey)
          if (i === -1 && value.length === 0) {
            error.errorCount++
            error.requiredFields.push(`<i class="text-danger-v2">${key.replace(/_/g, ' ').toUpperCase()}</i>`)
          }
        })
      }

      return error
    },
    clearModal() {
      for (const key in this.formData) {
        if (this.formData.hasOwnProperty(key)) {
          this.formData[key] = '';
        }
      }

    },
    isValidEmail(email) {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
        return true;
      } else {
        return false;
      }
    },
    getAddressDataForNewUser: function (addressData, placeResultData, id) {
      console.log('test')
      const placeAddress = placeResultData.address_components

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
            if (id === "street_address_new_appointment")
              this.formData.zip = component.long_name;
            else
              this.formData.zip = component.long_name;
            break;
          case "administrative_area_level_1":
            if (id === "street_address_new_appointment")
              this.formData.state = component.long_name;
            else
              this.formData.state = component.long_name
            break;
          case "administrative_area_level_2":
            if (id === "street_address_new_appointment")
              this.formData.state = component.long_name;
            else
              this.formData.state = component.long_name
            break;
          case "neighborhood":
            if (id === "street_address_new_appointment")
              this.formData.city = component.long_name;
            else
              this.formData.city = component.long_name
            break;
        }
      }

      if (streetAddress) {
        if (id === "new_user_address") {
          $('#new_user_address').val(streetAddress);
          this.formData.street_address = streetAddress;
        }
      }
    },
    newUserAddress: function () {
      this.formData.street_address = event.target.value
    },
  }
}
</script>