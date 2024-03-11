<style scoped>
.text-primary{
  color:#24695c !important;
}
</style>

<template>
<div class="p-15">
        <h4 class="fs-3 text-center mb-5">Automatically import leads into your Leads List as they come in from the following areas below:</h4>
        
        <div class="row">
                <div v-for="b in boxes" :key="b.id" class="col-xl-3 col-sm-6 box-col-3">
                    <div class="card income-card card-secondary align-items-cente" style="height:230px;">
                      <div class="card-body align-items-center">
                        <div class="round-progress knob-block text-center">
                          <div class="progress-circle mb-3">
                                <i :class="'fa ' + b.icon +' fs-1 text-primary'"></i>
                          </div>
                          <h6 class="text-primary mb-3" style="height:78px">{{ b.name }}</h6>

                          <div>
                            <template v-if="b.id=='FBL'">
                              <!-- <button v-if="hasFBToken>0"  class="align-items-center">
                                Subscribed
                              </button> -->
                              <button  v-if="hasFBToken>0" id="FBL" class="btn btn-danger btn-md align-items-center" @click="unsubscribe(b.id, b.name)">Un-Subscribed</button>
                              <button v-else id="FBL" class="btn btn-primary btn-md align-items-center" @click="subscribe(b.id)">Subscribe</button>
                              <!-- <fb:login-button id="FBbtn" scope="pages_manage_ads,pages_read_engagement,pages_show_list,leads_retrieval" onlogin="checkLoginState();"></fb:login-button> -->
                              <!-- <button id="FBbtn" scope="pages_manage_ads,pages_read_engagement,pages_show_list,leads_retrieval" onlogin="checkLoginState();">Login</button> -->
                              <!-- <div class="fb-login-button" data-width="" data-size="" data-button-type="" data-layout="" data-auto-logout-link="false" data-use-continue-as="false"></div>
                              <div id="fb-root"></div> -->
                            </template>

                            <template v-else>
                              <button :id="b.id" class="btn btn-primary btn-md align-items-center" disabled @click="subscribe(b.id)">
                                Subscribe
                              </button>
                            </template>
                          </div>

                        </div>
                      </div>
                    </div>
                </div>
        </div>
</div>
</template>

<script setup>
import Swal from 'sweetalert2';
import axios from 'axios';
import { router } from '@inertiajs/vue3';

const props = defineProps(['fb_app_id','hasFBToken']);

const boxes = [
        { id: "FBL", name: "Facebook Leads Ads",  icon: 'icofont icofont-social-facebook fs-1' },
        { id: "IGL", name: "Instagram Leads Ads",  icon: 'icofont icofont-social-instagram' },
        { id: "HAL", name: "Home Advisor",  icon: 'fa-university' },
        { id: "WCL", name: "Website Contact Forms",  icon: 'fa-cog' },
        { id: "ALL", name: "Angis List",  icon: 'icofont icofont-list' },
        { id: "TTL", name: "Thumbtack",  icon: 'fa-cog' },
        { id: "BZL", name: "Buildzoom",  icon: 'fa-cog' },
        { id: "HL", name: "Houzz",  icon: 'fa-cog' },
        { id: "CJL", name: "CraftJack",  icon: 'fa-cog' },
];

window.fbAsyncInit = function() {
  FB.init({
    appId      : props.fb_app_id,
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v18.0' // Specify the Graph API version to use
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  // FB.getLoginStatus(function(response) {
  // statusChangeCallback(response);
  // });
  checkLoginState();
  FB.AppEvents.logPageView();
  console.log('loading FB...')
  
  // document.getElementById('FBL').innerHTML = "Un-Subscribed";

};

// Load the SDK asynchronously
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "https://connect.facebook.net/en_US/sdk.js";
// js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v18.0&appId="+props.fb_app_id;
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


</script>

<script>

function subscribe(boxId)
{
  switch(boxId)
  {
    case "FBL": 
      // var FBbtn = document.getElementById('FBbtn');
      // console.log('FBbtn',FBbtn);
      // FBbtn.click();
      FB.login(function(response) {
          if (response.status === 'connected') {
            // Logged into your app and Facebook.
          } else {
            // The person is not logged into your app or we are unable to tell.
          }
      }, {scope: 'pages_manage_ads,pages_read_engagement,pages_show_list,leads_retrieval'});
      // checkLoginState();
    break;
    case "IGL": alert(boxId); break;
    case "HAL": alert(boxId); break;
    case "WCL": alert(boxId); break;
    case "ALL": alert(boxId); break;
    case "TTL": alert(boxId); break;
    case "BZL": alert(boxId); break;
    case "HL": alert(boxId); break;
    case "CJL": alert(boxId); break;
  }
}


function unsubscribe(boxId, leadName)
{
  switch(boxId)
  {
    case "FBL": 
     //clear access_tokens
    break;
    case "IGL": alert(boxId); break;
    case "HAL": alert(boxId); break;
    case "WCL": alert(boxId); break;
    case "ALL": alert(boxId); break;
    case "TTL": alert(boxId); break;
    case "BZL": alert(boxId); break;
    case "HL": alert(boxId); break;
    case "CJL": alert(boxId); break;
  }

  Swal.fire({
    html: "Are you sure you want to <h5 class='text-danger'>UNSUBSCIBE</h5> from <h5 class='text-success'>"+leadName+"</h5>?",
    icon: "warning",
    showCancelButton: true,
    buttonsStyling: false,
    confirmButtonText: "Yes, unsubscribe me!",
    cancelButtonText: "No, return",
    customClass: {
      confirmButton: "btn btn-danger",
      cancelButton: "btn btn-active-light"
    }
  }).then(function (result) {
    if (result.isConfirmed) {
      
      axios.post('/company/marketing/auto-leads/unsubscribe', { 'lead': boxId } )
        .then((res) => {
            if(res.data.status==1)
            {
              Swal.fire({
                  text: "Success! You have successfully unsubscribed from "+leadName+".",
                  icon: "success",
                  buttonsStyling: false,
                  confirmButtonText: "Ok, got it!",
                  customClass: {
                      confirmButton: "btn btn-success"
                  }
              });

              router.reload();

            }else{

              Swal.fire({
                text: (res.data.status!='') ? res.data.status : "Sorry, looks like there are some errors detected, please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn btn-danger"
                }
              });
            }
        });
    }
  });


}

</script>

