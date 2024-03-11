<template>
  <div class="card b-primary-v2 b-radius-10 shadow-sm mt-3">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-6 col-md-6">
          <div class="mb-3">
            <label class="form-label">First Name</label>
            <input class="form-control" type="text" placeholder="" v-model="formDataToEdit.firstname">
          </div>
        </div>
        <div class="col-sm-6 col-md-6">
          <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input class="form-control" type="text" placeholder="" v-model="formDataToEdit.lastname">
          </div>
        </div>
        <div class="col-sm-4 col-md-4">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" placeholder="" v-model="formDataToEdit.email">
          </div>
        </div>
        <div class="col-sm-4 col-md-4">
          <div class="mb-3">
            <label class="form-label">User Type</label>
            <select class="form-control rounded" name="" id="" v-model="formDataToEdit.userType">
              <option value="">Please select...</option>
              <option v-for="r in roles" :key="r.id" :value="r.id">{{ r.role_display_name }}</option>
            </select>
          </div>
        </div>
        <div class="col-sm-4 col-md-4">
          <div class="mb-3">
            <label class="form-label">Mobile Phone</label>
            <input class="form-control" type="number" placeholder="" >
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
                @input=""
                v-on:placechanged=""
                :country="['us']"
                :type="['address']">
            </vue-google-autocomplete>
          </div>
        </div>
        <div class="col-sm-6 col-md-6">
          <div class="mb-3">
            <label class="form-label">City</label>
            <input class="form-control" type="text" placeholder="" >
          </div>
        </div>
        <div class="col-sm-3 col-md-3">
          <div class="mb-3">
            <label class="form-label">State</label>
            <input class="form-control" type="text" placeholder="" >
          </div>
        </div>
        <div class="col-sm-3 col-md-3">
          <div class="mb-3">
            <label class="form-label">Zip Code</label>
            <input class="form-control" type="number" placeholder="" >
          </div>
        </div>
        <div class="col-md-12 mb-3">
          <div class="row">
            <div class="col">
              <label class="form-label">License #</label>
              <input class="form-control" type="text" placeholder="" >
            </div>
            <div class="col">
              <label class="form-label">License Expiration</label>
              <input class="form-control" type="text" placeholder="" >
            </div>
            <div class="col">
              <label class="form-label">EIN</label>
              <input class="form-control" type="text" placeholder="" >
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row">
            <div class="col">
              <label class="form-label">General Liability Expiration</label>
              <input class="form-control" type="text" placeholder="" >
            </div>
            <div class="col">
              <label class="form-label">Workers Comp Expiration</label>
              <input class="form-control" type="text" placeholder="" >
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="pull-right mt-4">
            <button class="btn btn-primary-v2 btn-sm">Save Information</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import VueGoogleAutocomplete from "vue-google-autocomplete";
</script>
<script>
export default {
  props: ['userData', 'roles'],
  data() {
    return {
      formDataToEdit: {
        firstname: '',
        lastname: '',
        email: '',
        userType: '',
        streetAddress: '',
        cellphone: '',
        city: '',
        state: '',
        zip: '',
        license: '',
        license_expiration: '',
        ein: '',
        general_liability_expiration: '',
        workers_comp_expiration: ''
      },
    }
  },
  methods: {
    populateFields() {
      this.formDataToEdit.firstname = this.userData.first_name
      this.formDataToEdit.lastname = this.userData.last_name
      this.formDataToEdit.userType = this.userData.company_roles_id
      this.formDataToEdit.companyName = this.userData.company_name
      this.formDataToEdit.email = this.userData.email
      this.formDataToEdit.primaryContact = this.userData.display_name
    },
  },
  mounted() {
    console.log(this.userData)
    this.populateFields()
  }
}
</script>