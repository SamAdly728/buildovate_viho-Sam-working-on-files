<template>
  <section>
    <div class="container-fluid p-0">
      <div class="row m-0">
        <div class="col-xl-5" style="padding: 100px; background: #24695c !important; color: #fff;">
        </div>
        <div class="col-xl-7 p-0">
          <div class="login-card">
            <form class="theme-form login-form" method="POST" @submit.prevent="resetPassword" style="border-radius: 5px">
              <h4>Reset Password</h4>
              <div class="form-group">
                <label>New Password</label>
                <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                  <input class="form-control" :type="typePassword" name="password" required="" placeholder="*********" v-model="formData.password">
                  <div class="show-hide"><span class="show" @click="togglePasswordVisibility('password')"></span></div>
                </div>
              </div>
              <div class="form-group">
                <label>Confirm Password</label>
                <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                  <input class="form-control" :type="typeConfirmPassword" name="confirm_password" required="" placeholder="*********" v-model="formData.confirm_password">
                  <div class="show-hide"><span class="show" @click="togglePasswordVisibility('confirmPassword')"></span></div>
                </div>
              </div>
              <div class="form-group">
                <button class="btn btn-primary btn-block w-100">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

</template>
<script>
import GuestLayout from "@/components/GuestLayout.vue";
import axios from "axios";
import Swal from "sweetalert2";

export default {
  layout: GuestLayout,
  props: ['user_id'],
  data() {
    return {
      formData: {
        // first_name: this.user.first_name,
        // last_name: this.user.last_name,
        username: '',
        user_id: this.user_id,
        password: '',
        confirm_password: ''
      },
      showPassword: false,
      showConfirmPassword: false
    }
  },
  methods: {
    resetPassword() {

    },
    createAccount() {
      if (this.formData.password == this.formData.confirm_password) {
        axios.post('/invitation/accept', this.formData).then((res) => {
          if (res.status == 200) {
            window.location.href = '/'
          }
        })
      }else{
        Swal.fire({
          text: 'Password mismatch!!!',
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Close",
          closeOnClickOutside: false,
          customClass: {
            confirmButton: "btn btn-danger-v2"
          }
        })
      }
    },
    togglePasswordVisibility(key) {
      if (key == 'password') {
        this.showPassword = !this.showPassword;
      }
      this.showConfirmPassword = !this.showConfirmPassword
    }
  },
  computed: {
    typePassword() {
      return this.showPassword ? 'text' : 'password';
    },
    typeConfirmPassword() {
      return this.showConfirmPassword ? 'text' : 'password';
    }
  }
};

</script>
