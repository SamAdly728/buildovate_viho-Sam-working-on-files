<style scoped>
.active {
  background-color: #F6FBFD !important;
  border: 1px solid rgb(232, 236, 240);
  color: black;
  border-left: 3px solid #24695C;
}

.active:hover {
  color: black;
}

.message-item-background {
  background-color: #FFFFFF !important;
  padding-top: 20px;
  padding-bottom: 20px;
}

.light-blue-text-color {
  color: #4EADDD !important;
}
</style>
<template>
  <!-- <br> -->
  <!-- <chat-component :contactsByRoomID="contactsByRoomID" :contactsByUID="contactsByUID" :myAvatar="myAvatar"></chat-component> -->
<!--  <div class="row mt-10 p-20">-->
<!--    <div v-for="(ch, index) in channelLinks" :key="index" class="col-sm-6 col-xl-4 col-lg-6">-->
<!--      <Link :href="ch.href">-->
<!--        <div class="card browser-widget">-->
<!--          <div class="media card-body">-->
<!--            <div class="media-img">-->
<!--              <i :class="'icofont icofont-'+ch.icon" style="font-size:60px"></i>-->
<!--            </div>-->
<!--            <div class="p20 text-center" style="padding: 22px 0px 0px 17px;">-->
<!--              <h4>{{ ch.name }}</h4>-->
<!--            </div>-->
<!--          </div>-->
<!--          <div class="ml-9 mb-10 mr-9">{{ ch.desc }}</div>-->
<!--        </div>-->
<!--      </Link>-->
<!--    </div>-->
<!--  </div>-->

  <div class="p-3 overflow-hidden">
    <div class="card rounded" style="border: 1px solid rgb(232, 236, 240); height: 88vh;box-shadow: 0px 0px 1px 0px rgba(0,0,0,0.19); -webkit-box-shadow: 0px 0px 1px 0px rgba(0,0,0,0.19);-moz-box-shadow: 0px 0px 1px 0px rgba(0,0,0,0.19);">
      <div class="row">
        <div class="col-md-3" style="border-right: 1px solid rgb(232, 236, 240); height: 88vh; padding-right: 0 ">
          <div class="position-relative flex flex-column" style="height: 88vh">
            <div class="mb-auto">
              <div class="list-group-item pt-3 pb-3 message-item-background flex justify-content-between align-items-center">
                <span class="light-blue-text-color">Select conversation</span>
                <button class="btn btn-info btn-xs float-end">Filter</button>
              </div>
              <div class="list-group rounded-0 " id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action message-item-background" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">
                  Message 1
                </a>
                <a class="list-group-item list-group-item-action message-item-background" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">Message 2</a>
                <a class="list-group-item list-group-item-action message-item-background" id="list-messages-list" data-bs-toggle="list" href="#list-messages" role="tab" aria-controls="list-messages">Message 3</a>
                <a class="list-group-item list-group-item-action message-item-background" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings">Message 4</a>
              </div>
            </div>
            <div class="list-group-item pt-3 pb-3 message-item-background flex justify-content-between align-items-center">
              <a href="/inbox/settings">
                <i class="icofont icofont-gear h6 mt-1 txt-primary" data-bs-toggle="modal" data-original-title="test" data-bs-target="#calendar-settings"></i>
                <span>Settings</span>
              </a>
            </div>
          </div>
        </div>
        <div class="col" style="border-right: 1px solid rgb(232, 236, 240); height: 88vh">
          <div class="">
            <p>test</p>
          </div>
        </div>
        <div class="col-md-3">

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<script>

import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
// import ChatComponent from '@/components/ChatComponent.vue';

const page = usePage();

export default {
  name: 'app',
  props: [],//['contactsByRoomID','contactsByUID','myAvatar'],
  components:{
    // 'chat-component':ChatComponent
  },
  data(props) {
    return {
      channelLinks: {
        "gm": { name:"Gmail", href:"/inbox/gmail", icon:"ui-email", url:'', desc: 'Sync with your Gmail account to manage and send emails directly from the Buildovate platform.' },
        "txt": { name:"TEXT Messages", href:"/inbox/text-messages", icon:"ui-text-chat", url:'', desc: 'Connect your phone number to send, receive, and manage text messages within the Buildovate platform.'  },
        "ig": { name:"Instagram", href:"/inbox/instagram", icon:"social-instagram", url:'', desc: 'Integrate your Instagram account to manage DMs, post notifications, and respond to comments.'  },
        "fb": { name:"FB Messenger", href:"/inbox/fb-messenger", icon:"social-facebook-messenger", url:'', desc: 'Sync your Facebook Messenger to directly chat with your Facebook contacts through the Buildovate platform.'  },
        "ye": { name:"Yelp", href:"/inbox/yelp", icon:"social-yelp", url:'', desc: 'Integrate Yelp to manage reviews, respond to user feedback, and enhance your business\'s online reputation.'  },
        "wc": { name:"Website Live Chat", href:"/inbox/website-live-chat", icon:"ui-chat", url:'', desc: 'Enable a live chat feature on your website and handle customer queries in real-time directly from Buildovate.'  },
        "wa": { name:"WhatsApp", href:"/inbox/whatsapp", icon:"social-whatsapp", url:'', desc: 'Connect your WhatsApp business account to chat, share files, and manage conversations directly from Buildovate.'  },
      },
      // editor: ClassicEditor,
      form: {
        message: '',
        _token: page.props.csrf_token,
      },
      contact: {
        name: '',
        avatar:''
      },
      showContact:true,
      username: page.props.auth.user.name,

      message:null,
      pusher:null,
      channel:null,
      // contactsByRoomID:props.contactsByRoomID,
      // contactsByUID:props.contactsByUID,
      // _token: page.props.csrf_token,
    }
  },
  mounted(){

    $('html, body').css({
      overflow: 'hidden',
      height: '100%'
    });

    // this.showDetails(contacts[0]);

    // // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    // const pusher = new Pusher('76097a322ca0e7b8e110', {
    //   encrypted:true,
    //   cluster: 'us2'
    // });

    // let that = this;
    // const channel = pusher.subscribe('chat');
    // channel.bind("App\\Events\\MessageSent", function(data) {
    //   // Method to be dispatched on trigger.
    //   // app.messages.push(JSON.stringify(data));
    //   this.messages.push(data);
    //   console.log('dtako',data);
    //   // that.$emit('incoming_chat', data);
    // });

    // // this.$on('incoming_chat', function(chatMessage){
    // //   // this.incoming
    // // });
    // // channel.bind('message', data => {
    // //   app.messages.push(JSON.stringify(data));
    // //   messages.push(data);
    // //   console.log('dtako',data);

    // // });
  },
  methods:{
    submitIt(){
      axios.post('/messages/send', this.form )
          .then((res) => {
            console.log('res',res);
            this.form.message = '';
          })
          .catch((error) => {
            console.log('error',error.message);
          });
    },
    // showDetails(c){
    //   this.contact.name = c.name;
    //   this.contact.avatar = c.avatar;
    //   this.showContact = true;
    // },
    // incomingChat(chatMessage){
    //   console.log('chatMessage',chatMessage);
    // }
  },
}
</script>

  
  