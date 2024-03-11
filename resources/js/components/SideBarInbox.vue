<style>
/* .fade-enter-active,
.fade-leave-active {
  transition: opacity 2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
} */

/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-fade-enter-active {
  transition: all 0.5s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}

.active{
  text-decoration: none !important;
}
#custom-datepicker .datepicker{
  width: 267px !important;
  border-radius: 0 !important;
  -webkit-box-shadow: none !important;
  -moz-box-shadow: none !important;
  box-shadow: none !important;
}

.dp__outer_menu_wrap {
  width: 289px !important;
}
.dp__action_row {
  display: none;
}
.dp__theme_light {
  border-color: transparent;
}

ul {
   cursor: pointer;
}

.slide-enter-active {
   -moz-transition-duration: 0.3s;
   -webkit-transition-duration: 0.3s;
   -o-transition-duration: 0.3s;
   transition-duration: 0.3s;
   -moz-transition-timing-function: ease-in;
   -webkit-transition-timing-function: ease-in;
   -o-transition-timing-function: ease-in;
   transition-timing-function: ease-in;
}

.slide-leave-active {
   -moz-transition-duration: 0.3s;
   -webkit-transition-duration: 0.3s;
   -o-transition-duration: 0.3s;
   transition-duration: 0.3s;
   -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
   -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
   -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
   transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}

.slide-enter-to, .slide-leave {
   max-height: 100px;
   overflow: hidden;
}

.slide-enter, .slide-leave-to {
   overflow: hidden;
   max-height: 0;
}
</style>

<template>
  <!-- Page Sidebar Start-->
  <Transition name="slide-fade">
    <header v-show="page.props.style.sidebar" class="main-nav" :style="page.props.style.sidebar_opacity">

      <div id="user" class="" >
      
      <!-- <div class="container-fluid"> -->
        <div class="email-wrap">
          <div class="row">
            <!-- <div class="col-xl-12 col-md-12 xl-30"> -->
              <div class="email-sidebar">
                <!-- <a class="btn btn-primary email-aside-toggle" href="javascript:void(0)">email filter</a> -->
                <div class="email-left-aside">
                  <div class="card" style="border:none !important">
                    <div class="card-body">
                      <div class="email-app-sidebar" :style="(page.url.includes('/inbox/gmail')) ? 'height:700px;overflow: hidden;' : 'height:700px;' ">

                        <Transition name="slide">
                          <SidebarGmail  v-if="page.url.includes('/inbox/gmail')" ></SidebarGmail>
                        </Transition>

<!--                        <ul class="nav main-menu">-->
<!--                          <li class="dropdown">-->
<!--                            &lt;!&ndash; <a class="nav-link menu-title" href="javascript:void(0)" @click="channels = !channels">-->
<!--                              <span class="title" style="font-size:x-small"> Connect To:</span>-->
<!--                              <div class="according-menu" style="top: 8px !important;"><i :class="(channels) ? 'fa fa-angle-up' : 'fa fa-angle-down'"></i></div>-->
<!--                            </a> &ndash;&gt;-->
<!--                            <label for="allChannels" class="ms-0 mb-2">-->
<!--                              <input @click="allChannels = !allChannels" v-model="allChannels" class="checkbox_animated" id="allChannels" type="checkbox"> -->
<!--                              <span v-if="allChannels">Uns</span>-->
<!--                              <span v-else>S</span>elect All-->
<!--                            </label>-->
<!--                            <hr>-->
<!--                            &lt;!&ndash; <transition name="slide"> &ndash;&gt;-->
<!--                            <TransitionGroup>-->
<!--                              <ul v-if="channels" class="child">-->
<!--                                <li v-for="(l, index) in channelLinks" :key="index">-->

<!--                                  &lt;!&ndash; <Link :href="l.href"> &ndash;&gt;-->
<!--                                    -->
<!--                                    <label :for="'channel'+index" class=" mb-3">-->
<!--                                      <input v-model="l.checkbox" class="checkbox_animated" :id="'channel'+index" type="checkbox" :checked="(allChannels) ? true : false"> -->
<!--                                      <span class="title fs-7">-->
<!--                                        <i :class="'icofont icofont-'+l.icon"></i> -->
<!--                                        {{ l.name }}-->
<!--                                      </span>-->
<!--                                    </label>-->
<!--                                    -->
<!--                                  &lt;!&ndash; </Link> &ndash;&gt;-->

<!--                                  &lt;!&ndash; <a href="javascript:void(0)" @click="openChannel(index)" :class="(page.url==l.url) ? 'btn-primary btn-block btn-mail w-100' : '' ">-->
<!--                                    <span class="title">-->
<!--                                      <i :class="'icofont icofont-'+l.icon"></i> -->
<!--                                      {{ l.name }}-->
<!--                                    </span>-->
<!--                                  </a> &ndash;&gt;-->
<!--                                </li>-->
<!--                              </ul>-->
<!--                            </TransitionGroup>-->
<!--                             &lt;!&ndash; </transition> &ndash;&gt;-->
<!--                          </li>-->
<!--                        </ul>-->
                        
                        <div class="text-center p-20">
                          <Link 
                            href="/inbox/settings"
                            class="btn btn-sm btn-success btn-block">
                            <span class="title">
                              <i class="icon-settings me-2"></i> 
                              Settings
                            </span>
                          </Link>
                        </div>
                      </div>

                    </div>
                  </div>

                </div>

              </div>

              
            <!-- </div> -->
          </div>
        </div>
      <!-- </div> -->

      </div>

      

      
    </header>
    
  </Transition>
  <!-- Page Sidebar Ends-->
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { usePage } from '@inertiajs/vue3';

const page = usePage();

console.log('page side',page.url)

</script>

<script>
import SidebarGmail from "@/components/inbox/SidebarGmail.vue";
// import Link from "@/components/Link.vue";
import axios from 'axios';
import { router } from '@inertiajs/vue3';

export default {
  name: 'app',
  mounted(){

  },
  props: ['inbox_channel'],
  data(props) {
      
      return {
        channels: true,
        allChannels: true,
        gmailAuth: false,
        channelLinks: {
          // "gm": { name:"Gmail", href:"/", icon:"ui-email", url:'/inbox/gmail' },
          // "txt": { name:"TEXT Messages", href:"/", icon:"ui-text-chat", url:''  },
          // "ig": { name:"Instagram", href:"/", icon:"social-instagram", url:''  },
          // "fb": { name:"FB Messenger", href:"/", icon:"social-facebook-messenger", url:''  },
          // "ye": { name:"Yelp", href:"/", icon:"social-yelp", url:''  },
          // "wc": { name:"Website Live Chat", href:"/", icon:"ui-chat", url:''  },
          // "wa": { name:"WhatsApp", href:"/", icon:"social-whatsapp", url:''  },
        
          "gm": { name:"Gmail", href:"/inbox/gmail", icon:"envelope", url:'' },
          "txt": { name:"TEXT Messages", href:"/inbox/text-messages", icon:"ui-text-chat", url:''  },
          "ig": { name:"Instagram", href:"/inbox/instagram", icon:"social-instagram", url:''  },
          "fb": { name:"FB Messenger", href:"/inbox/fb-messenger", icon:"social-facebook-messenger", url:''  },
          "ye": { name:"Yelp", href:"/inbox/yelp", icon:"social-yelp", url:''  },
          "wc": { name:"Website Live Chat", href:"/inbox/website-live-chat", icon:"ui-chat", url:''  },
          "wa": { name:"WhatsApp", href:"/inbox/whatsapp", icon:"social-whatsapp", url:''  },
        },
        unread: 0
      }
  },
  methods:{
    openChannel(index){
        // console.log('channelLinks',this.channelLinks[index]);
        // switch(index){
        //   case 'gm': this.loadGmail(); break;
        //   default:
        //     // this.clearBoxes();
        // }
    },
    // clearBoxes(){
    // },
    getUnreadTotal(){
      axios.post('/inbox/gmail/get-unread-total', {} )
      .then((res) => {
        if(res.data.total)
        {
          this.unread = res.data.total;
        }
      })
      .catch((error) => {
        console.log('error',error.message);
      });
      
      // console.log('messageVia email - this.gmailAuth',this.gmailAuth);
      // if(!this.gmailAuth)
      // {
      //   //call func from views/app.blade.php
      //   // handleAuthClick();
      // }else{

      //   console.log('on-this.gmailAuth',this.gmailAuth);
        
      //   // getProfile();
      // }
    },
    // loadGmail(){
    //   axios.post('/inbox/gmail/messages', {} )
    //   .then((res) => {
    //     if(res.data.status=='auth')
    //     {
    //       // show gapi consent form
    //       window.open(res.data.authUrl, "_self");

    //     }else{

    //       this.gmailAuth = true;
    //       // router.reload();
    //       router.get('/inbox/gmail');
    //       //display messages
    //       // document.getElementById('messageContainer').innerText = res.data.message;

    //     }
        
    //   })
    //   .catch((error) => {
    //     console.log('error',error.message);
    //   });
      
    //   // console.log('messageVia email - this.gmailAuth',this.gmailAuth);
    //   // if(!this.gmailAuth)
    //   // {
    //   //   //call func from views/app.blade.php
    //   //   // handleAuthClick();
    //   // }else{

    //   //   console.log('on-this.gmailAuth',this.gmailAuth);
        
    //   //   // getProfile();
    //   // }
    // },
    logoutGmail(){
      //call func from views/app.blade.php
      handleSignoutClick();
      this.gmailAuth = false;
      console.log('logout-this.gmailAuth',this.gmailAuth);
    },
    testAPP(){
      const resp = getUserMessages();
      const token = getToken();
      if (token !== null) 
      {
        this.gmailAuth = true;
        // listLabels();
        
      }

      // console.log('--token',token);
    }

    

  }
}


</script>
