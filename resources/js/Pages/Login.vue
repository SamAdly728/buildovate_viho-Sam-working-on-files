<template>

	<section>
      <div class="container-fluid m-0 p-0">
        <div class="row m-0">
          <div class="col-xl-7 position-relative m-0 p-0">
            <img class="position-absolute top-0 left-0 bottom-0 right-0" alt="looginpage" :src="asset_link + 'login/login_background_2.png'" style="width:100%; height:100%;"></div>
          <div class="col-xl-5 p-0">
            <div class="login-card">
              <!-- <img alt="looginpage" src="https://buildovate-development.s3.us-west-1.amazonaws.com/images/login/login_background_2.png" style="width: 100%; height: 100%;" class="position-absolute top-0 left-0 bottom-0 right-0"> -->
              <form class="theme-form login-form card-radious-sm" method="POST" @submit.prevent="form.post('/auth/login')" style="z-index: 2;">
                <input type="hidden" :value="page.props.csrf_token" name="_token">

                <h4>Login</h4>
                <h6>Welcome back! Log in to your account.</h6>
                <div class="form-group">
                  <label>Email Address</label>
                  <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                    <input class="form-control" type="email" v-model="form.email" @input="handleInput($event)" required placeholder="Enter username">
                  </div>
                  <div class="text-danger mt-1" v-if="form.errors.email">{{ form.errors.email }}</div>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                    <input class="form-control" type="password" v-model="form.password" @input="handleInput($event)" required placeholder="*********">
					          <div class="text-danger" v-if="form.errors.password">{{ form.errors.password }}</div>
                    <div class="show-hide"><span class="show"></span></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="checkbox">
                    <input id="checkbox1" type="checkbox">
                    <label class="text-muted" for="checkbox1">Remember password</label>
                  </div><a class="link" href="/forget-password">Forgot password?</a>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary-v2 btn-block" type="submit" :disabled="form.processing">Sign in</button>
                </div>
                <div class="login-social-title">                
                  <h5>Sign in with</h5>
                </div>
                <div class="form-group">
                  <ul class="login-social">
                    <li><a href="https://www.linkedin.com/login" target="_blank"><i class="fi fi-brands-linkedin"></i></a></li>
                    <li><a href="https://www.linkedin.com/login" target="_blank"><i class="fi fi-brands-twitter"></i></a></li>
                    <li><a href="https://www.linkedin.com/login" target="_blank"><i class="fi fi-brands-facebook"></i></a></li>
                    <li><a href="https://www.instagram.com/login" target="_blank"><i class="fi fi-brands-instagram"></i></a></li>
                  </ul>
                </div>
                <p>Don't have account?<a class="ms-2" href="/register">Create Account</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
	
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const asset_link = window.asset_link;

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

</script>

<script>
import GuestLayout from "@/components/GuestLayout.vue";

export default {
    layout: GuestLayout
};

</script>
