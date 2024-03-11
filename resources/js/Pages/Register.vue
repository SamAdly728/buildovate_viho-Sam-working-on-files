<template>
    <div class="container-fluid p-0"> 
       <div class="row m-0">
         <div class="col-12 p-0 ">
           <div class="login-card">
             <form class="theme-form login-form w-75">
                <div class="row mb-3">
                    <div class="col-4 u-steps u-steps-vertical">
                        <h4>Steps</h4>
                        <h6>Complete to create your buildovate account.</h6>
                        <div class="u-step done"><span class="u-step-number">1</span>
                            <div class="u-step-desc"><span class="u-step-title">Credentials</span>
                                <p style="text-align: left;"> Create your credentials</p>
                            </div>
                        </div>
                        <div class="u-step current"><span class="u-step-number">2</span>
                            <div class="u-step-desc"><span class="u-step-title">Contact</span>
                                <p style="text-align: left;"> How do we reach you</p>
                            </div>
                        </div>
                        <div class="u-step"><span class="u-step-number">3</span>
                            <div class="u-step-desc"><span class="u-step-title">Billing</span>
                                <p style="text-align: left;"> Pay for the bill</p>
                            </div>
                        </div>
                        <div class="u-step"><span class="u-step-number">4</span>
                            <div class="u-step-desc"><span class="u-step-title">Validation</span>
                                <p style="text-align: left;"> Validate your account</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <h4>Create your account</h4>
                        <h6>Enter your personal details to create account</h6>
                        <div class="form-group">
                            <label>Your Name</label>
                            <div class="small-group">
                            <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                                <input class="form-control" type="text" required="" placeholder="Fist Name">
                            </div>
                            <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                                <input class="form-control" type="email" required="" placeholder="Last Name">
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                            <input class="form-control" type="email" required="" placeholder="Test@gmail.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                            <input class="form-control" type="password" name="login[password]" required="" placeholder="*********">
                            <div class="show-hide"><span class="show"></span></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                            <input id="checkbox1" type="checkbox">
                            <label class="text-muted" for="checkbox1">Agree with <span>Privacy Policy</span></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Create Account</button>
                        </div>
                        <div class="login-social-title">                
                            <h5>signup with</h5>
                        </div>
                        <div class="form-group">
                            <ul class="login-social">
                            <li><a href="https://www.linkedin.com/login" target="_blank"><i data-feather="linkedin"><vue-feather type="linkedin"></vue-feather></i></a></li>
                            <li><a href="https://www.linkedin.com/login" target="_blank"><i data-feather="twitter"><vue-feather type="twitter"></vue-feather></i></a></li>
                            <li><a href="https://www.linkedin.com/login" target="_blank"><i data-feather="facebook"><vue-feather type="facebook"></vue-feather></i></a></li>
                            <li><a href="https://www.instagram.com/login" target="_blank"><i data-feather="instagram"><vue-feather type="instagram"></vue-feather></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="login-social-title m-0">                
                    <h5>Already have an account?<a class="ms-2" href="/login">Sign in</a></h5>
                </div>
             </form>
           </div>
         </div>
       </div>
     </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { usePage } from '@inertiajs/vue3';

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

</script>
<script>
import GuestLayout from "@/components/GuestLayout.vue";

export default {
    layout: GuestLayout
};

</script>