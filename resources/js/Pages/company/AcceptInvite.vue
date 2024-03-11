<template>
<section>         
  <div class="container-fluid p-0"> 
    <div class="row m-0">
      <div class="col-xl-5" style="padding: 100px; background: #24695c !important; color: #fff;">
        
        <h4 style="margin-top: 30%;">What's Buildovate?</h4>
        <p>Buildovate is a software that helps service businesses with scheduling, invoicing, team tracking, and customer management</p>

        <h4 class="mt-5">Why am I getting this invite?</h4>
        <p>{{user.company}} uses Buildovate to run their business and you've been added to the team.</p>
      </div>
      <div class="col-xl-7 p-0">
        <div class="login-card">
          <form class="theme-form login-form" method="POST" @submit.prevent="createAccount" style="border-radius: 5px">
            <h4>Hello {{ user.first_name }}</h4>
            <h6>You have received an invitation to join the <br><b>{{user.company}}</b> team on Buildovate.</h6>
            <h6>Start by creating your Buildovate account</h6>
<!--            <div class="form-group">-->
<!--              <label>Your Name</label>-->
<!--              <div class="small-group">-->
<!--                <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>-->
<!--                  <input class="form-control" type="text" required="" placeholder="First Name" v-model="formData.first_name">-->
<!--                </div>-->
<!--                <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>-->
<!--                  <input class="form-control" type="text" required="" placeholder="Last Name" v-model="formData.last_name">-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--              <label>Email Address</label>-->
<!--              <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>-->
<!--                <input class="form-control" type="email" required="" placeholder="Enter email" v-model="formData.email">-->
<!--              </div>-->
<!--            </div>-->
            <div class="form-group">
              <label>Username</label>
              <div class="small-group">
                <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                  <input class="form-control" type="text" required="" placeholder="Username" v-model="formData.username"></div>
              </div>
            </div>
            <div class="form-group">
              <label>Password</label>
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
              <div class="checkbox">
                <input id="checkbox1" type="checkbox">
                <label class="text-muted" for="checkbox1">Agree with <a href="/privacy-policy">Privacy Policy</a></label>
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-block w-100">Create Account</button>
            </div>
            <!-- <div class="login-social-title">
              <h5>Sign in with</h5>
            </div> -->
            <!-- <div class="form-group">
              <ul class="login-social">
                <li><a href="https://www.linkedin.com/login" target="_blank"><i data-feather="linkedin"></i></a></li>
                <li><a href="https://www.linkedin.com/login" target="_blank"><i data-feather="twitter"></i></a></li>
                <li><a href="https://www.linkedin.com/login" target="_blank"><i data-feather="facebook"></i></a></li>
                <li><a href="https://www.instagram.com/login" target="_blank"><i data-feather="instagram">                  </i></a></li>
              </ul>
            </div> -->
            <p>Already have an account?<a class="ms-2" href="/">Sign in</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
	
</template>

<!--<script setup>
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { usePage } from '@inertiajs/vue3';

defineProps(['user']);

const page = usePage();

const form = useForm({
	email: "",
    password: "",
	// _token: this.$page.props.csrf_token
    _token: page.props.csrf_token,
	// processing: false,
});

function handleInput(e)
{
	form.clearErrors(e.target.name); 
}
</script>-->

<script>
import GuestLayout from "@/components/GuestLayout.vue";
import axios from "axios";
import Swal from "sweetalert2";

export default {
  layout: GuestLayout,
  props: ['user'],
  data() {
    return {
      formData: {
        // first_name: this.user.first_name,
        // last_name: this.user.last_name,
        email: this.user.email,
        username: '',
        user_id: this.user.user_id,
        password: '',
        confirm_password: ''
      },
      showPassword: false,
      showConfirmPassword: false
    }
  },
  methods: {
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
