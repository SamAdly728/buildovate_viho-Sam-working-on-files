<style scoped>
.contact-btns{
  border: 1px solid;
  border-radius: 50%;
  padding: 7px 10px;
}
.contact-btns:hover{
  background-color: #24695c;
  color: #ffffff;
}
.com-links{
  width:18px;
  height:18px;
}
#ql-editor{
  height: 300px !important;
  overflow: scroll !important;
  border: 1px solid !important;
}
.message-data-time{
  font-size: 11px !important;
  font-weight:400px;
  font-style:italic;
}
.my-message{
  background-color: aliceblue;
  color: #000000 !important;
}

.other-message{
  background-color: #e6edef;
  color: #000000 !important;
}
</style>

<template>
  
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
      <!-- CONTACT LIST   -->
      <div class="col call-chat-sidebar">
        <div class="card">
          <div class="card-body chat-body">
            <div class="chat-box">
              <!-- Chat left side Start-->
              <div class="chat-left-aside">
                <div class="media">
                    <img class="rounded-circle user-image" src="https://dev2.buildovate.io/assets/images/dashboard/1.png" alt="">
                  <div class="media-body">
                    <div class="about">
                      <div class="name f-w-600">{{ page.props.auth.user.name }}</div>
                      <div class="status">Status...{{ parseInt(Math.random()*100) }}</div>
                    </div>
                  </div>
                </div>
                <div class="people-list" id="people-list">
                  <div class="search">
                    <form class="theme-form">
                      <div class="form-group">
                        <input class="form-control" type="text" placeholder="search"><i class="fa fa-search"></i>
                      </div>
                    </form>
                  </div>
                  <ul class="list custom-scrollbar">
                    <li class="clearfix" v-for="(c, index) in contactsByRoomID" :key="index">
                      <div class="media"><img @click="openConvo(c.room_id, c.user_id)" class="rounded-circle user-image" :src="c.avatar" alt="">
                        <div class="status-circle online"></div>
                        <div class="media-body">
                          <div class="about">
                            <div class="name">
                                <a href="javascript:void(0)" @click="openConvo(c.room_id, c.user_id)">{{ c.username }}</a>
                            </div>
                            <div class="status">
                              <a href="#" title="Text Message"><vue-feather class="com-links text-success" type="file-text"></vue-feather></a>&nbsp;
                              <a href="#" title="Voice Mail"><vue-feather class="com-links text-danger" type="phone"></vue-feather></a>&nbsp;
                              <a href="#" title="Facebook"><vue-feather class="com-links text-primary" type="facebook"></vue-feather></a>&nbsp;
                              <a href="#" title="Email"><vue-feather class="com-links text-warning" type="mail"></vue-feather></a>&nbsp;
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>

                  </ul>
                </div>
              </div>
              <!-- Chat left side Ends-->
            </div>
          </div>
        </div>
      </div>

      <!-- MAIN CHAT -->

      <div class="col call-chat-body">
        <div class="card">
          <div class="card-body p-0">
            <div class="row chat-box" style="height:750px;">
              <!-- Chat right side start-->
              <div class="col chat-right-aside">
                <!-- chat start-->
                <div class="chat">
                  <!-- chat-header start-->
                  <div class="media chat-header clearfix">
                    <img v-if="currContact.avatar" class="rounded-circle" :src="currContact.avatar" alt="">
                    <div class="media-body">
                      <div class="about">
                        <div class="name">{{ currContact.username }} 
                            <!-- <span class="font-primary f-12">Typing...</span> -->
                        </div>
                        <!-- <div class="status digits">Last Seen 3:55 PM</div> -->
                      </div>
                    </div>
                    <ul class="list-inline float-start float-sm-end chat-menu-icons">
                      <!-- <li class="list-inline-item"><a href="javascript:void(0)"><i class="icon-search"></i></a></li>
                      <li class="list-inline-item"><a href="javascript:void(0)"><i class="icon-clip"></i></a></li>
                      <li class="list-inline-item"><a href="javascript:void(0)"><i class="icon-headphone-alt"></i></a></li>
                      <li class="list-inline-item"><a href="javascript:void(0)"><i class="icon-video-camera"></i></a></li> -->
                      <li class="list-inline-item toogle-bar"><a href="javascript:void(0)"><i class="icon-menu"></i></a></li>
                    </ul>
                  </div>

                  <!-- chat-header end-->
                  <div class="tab-content mb-3 " id="myTabContent" v-if="tabs.length">
                    <div 
                        v-for="channel in tabs" 
                        :class="'chat-history chat-msg-box custom-scrollbar tab-pane fade ' + (channel === getActiveChannel() ? 'show active' : '')"
                        :id="'tab-content-' + channel.formattedName"
                        :key="'tab-content-' + channel.formattedName"
                        style="height:465px;"
                    >
                        <!-- {{ channel.name  }} -->
                        <div class="messageContainer">
                            <ul>
                                <template v-for="msg in channel.messages" :key="msg.time">
                                    <li v-if="msg.user.toLowerCase()===userName.toLowerCase()" class="clearfix">
                                        <div class="message my-message pull-right">
                                          <img class="rounded-circle float-end chat-user-img img-30" :src="myAvatar" alt="">
                                            
                                            <div class="message-data text-end">
                                                <span class="message-data-time">{{ timeSince(msg.time) }} ago</span>
                                            </div>                                                 
                                            <div v-html="msg.content"></div>
                                        </div>
                                    </li>
                                    <li v-else >
                                        <div class="message other-message">
                                            <img class="rounded-circle float-start chat-user-img img-30" :src="currContact.avatar" alt="">
                                            <!-- <div class="float-start text-start">{{ currContact.username }}:</div> -->
                                            <div class="message-data text-start">
                                                <span class="message-data-time">{{ timeSince(msg.time) }} ago</span>
                                            </div>                                              
                                            <div v-html="msg.content"></div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                    
                    
                  </div>
                  <!-- end chat-history-->

                  <!-- chat message  -->
                  <div class="chat-message clearfix">
                      <div class="row">
                        <div class="col-xl-12">
                            <div>
                              <label>Message via:</label>&nbsp;
                              <select v-model="messageVia" style="display:inline-flex" class="text-primary" @change="checkMessageTarget">
                                <option value="default" selected>This Chat</option>
                                <option value="email">Email</option>  
                              </select>
                              <span v-if="messageVia=='email'" class="text-default">| &nbsp;To: <input type="email" class="text-primary" :value="currContact.email" readonly></span><br>
                              <span v-if="messageVia=='email'" class="text-default mb-2">Subject: <input v-model="emailSubject" type="text" class="" style="display: inline-flex;font-size: 16px;padding: 2px 1px 1px 6px;font-weight: 700;width:75%;"></span>
                            </div>
                            <input type="hidden" v-model="userName">
                            <QuillEditor 
                              theme="snow" 
                              v-model:content="message" 
                              contentType="html" 
                              placeholder="Type a message..."
                              toolbar="essential"
                              style="height: 100px !important;
                                      overflow: scroll !important;"
                            />
                            
                            <div class="mt-2">
                              <button v-if="messageVia=='email'" @click="publishMessageOnPrivateChannel" class="btn btn-warning" type="button">SEND VIA EMAIL</button>&nbsp;
                              <button v-else @click="publishMessageOnPrivateChannel" class="btn btn-success" type="button">SEND</button>&nbsp;
                              
                              <button class="btn btn-primary" type="button">SEND LATER</button>&nbsp;
                              <button class="btn btn-primary" type="button">REPLY GPT</button>
                            </div>
                        </div>
                      </div>
                    </div>
                    <!-- chat message  -->
                  
                  <!-- end chat-message-->
                  <!-- chat end-->
                  <!-- Chat right side ends-->
                </div>
              </div>

              
            </div>

          </div>

        </div>
        
      </div>

      <!-- <div v-else 
        class="col call-chat-body">
        <div class="card">
          <div class="card-body p-0">
            <div class="row chat-box" 
              >
              <div class="chat"
                  style="
                      /* background-image: url('/assets/images/inbox/default.jpeg'); */
                      background-size:contain;
                      background-repeat:no-repeat;
                      width:100%;
                      height:700px;
                    "
                  >

              </div>
            </div>
          </div>
        </div>
      </div> -->


      <!-- CONTACT DETAILS -->
      <div class="col call-chat-sidebar" v-if="showContact">
        <div class="card">
          <div class="card-body chat-body">
            <a href="javascript:void(0)" @click="showContact=false"><i class="icofont icofont-error close-card font-primary pull-right"></i></a>
            <div class="chat-box">
              <!-- Chat left side Start-->
              <div class="chat-left-aside text-center pt-4 custom-scrollbar">
                
                <img class="rounded-circle mb-4" :src="currContact.avatar" alt="" style="display:inline-block !important">
                
                <div class="name f-w-600 mb-3">{{ currContact.username }}</div>

                <div class="">
                  <a href="#" class="contact-btns"><i class="fa fa-user"></i></a>&nbsp;
                  <a href="#" class="contact-btns"><i class="fa fa-edit"></i></a>&nbsp;
                  <a href="#" class="contact-btns"><i class="fa fa-bars"></i></a>
                </div>
                <br>
                <hr>
                <div class="text-left">
                  <h6 class="mb-4 fs-7">Contact Info</h6>

                  <div class="mb-4">
                    <div class="" style="font-size: x-small;">Main Email</div>
                    {{ currContact.email }}
                  </div>

                  <div class="mb-4">
                    <div class="" style="font-size: x-small;">Main Phone</div>
                    000-000000
                  </div>

                  <div class="mb-4">
                    <div class="" style="font-size: x-small;">Address</div>
                    <div v-if="currContact.biz!=null">
                      {{ currContact.biz.business_street }}
                      {{ currContact.biz.business_city }}
                      {{ currContact.biz.business_state }}
                      {{ currContact.biz.business_country }}
                      {{ currContact.biz.business_zipcode }}
                    </div>
                  </div>

                  

                </div>
                
                
              </div>
              <!-- Chat left side Ends-->
            </div>
          </div>
        </div>
      </div>
    </div>

  <!-- <button id="authorize_button" onclick="handleAuthClick()">Authorize</button>-->
  <button id="signout_button" @click="logoutGAPI">Sign Out</button>
  <button id="signout_button" @click="loadGAPIProfile">Load Profile</button>
  

  <pre id="content" style="white-space: pre-wrap;"></pre>
</div>
<!-- Container-fluid Ends-->

</template>

<script setup>
import VueFeather from 'vue-feather';

</script>

<script>
import Swal from 'sweetalert2';
import { usePage } from '@inertiajs/vue3';
import Echo from '@ably/laravel-echo';
import * as Ably from 'ably';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import axios from 'axios';

// window.Ably = Ably;

// // Create echo client instance around ably-js.
// window.Echo = new Echo({
//     broadcaster: 'ably',
// });

// // Register a callback for listing to connection state change 
// window.Echo.connector.ably.connection.on((stateChange) => {
//     console.log("LOGGER:: Connection event :: ", stateChange);
//     if (stateChange.current === 'disconnected' && stateChange.reason?.code === 40142) { // key/token status expired
//         console.log("LOGGER:: Connection token expired https://help.ably.io/error/40142");
//     }
// });

const page = usePage();

// page.props.auth.user.name

export class Channel {
    constructor(props) {
        this.type = props.type;
        this.name = props.name;
        /** @type {Array<Message>} **/
        this.messages = props.messages || [];
        this.typingNames = props.typingNames || [];
        this.typingStopEvents = props.typingStopEvents || []
    }
    get formattedName() {
        return `${this.type}-${this.name}`;
    }
}

export class Message {
    constructor(props) {
        this.type = props.type;
        this.user = props.user;
        this.content = props.content;
        this.time = props.time ?? new Date();
    }
    get formattedName() {
        return `${this.type}-${this.name}`;
    }
}

export default {
    mounted() {
        console.log('Component mounted.')
        if(page.props.auth.user){
            this.userName = page.props.auth.user.name;
            this.userId = page.props.auth.user.user_id;
        }
        //check if gmail api is init
        // const isAuthorized = document.getElementById('gmail_authorized').value;
        // this.gmailAuthorized = isAuthorized;
        // console.log('init isAuthorized: ',isAuthorized);
        // console.log('init this.gmailAuthorized: ',this.gmailAuthorized);
        // handleSignoutClick();
    },
    props:['contactsByRoomID','contactsByUID','myAvatar'],
    components: {
      QuillEditor
    },
    data(props) {
        return {
            activeIndex: -1,
            currContact:[],
            currentConvoAvatar:'',
            currentConvoName:'',
            /** @type {Array<Channel>} **/
            tabs: [],
            userId: null,
            userName: null,
            message: null,
            throttleTyping: false,
            showContact:false,
            myAvatar: props.myAvatar,
            contact: {
              name: '',
              avatar:''
            },
            contactsByRoomID:props.contactsByRoomID,
            contactsByUID:props.contactsByUID,
            messageVia:'default',
            emailSubject: page.props.auth.user.name + ' sent you a message',
            gmailAuthorized: 'no',
            
        }
    },

    methods: {
        showDetails(c){
          this.currContact = c;
          this.showContact = true;
        },
        openConvo(room_id, contact_user_id){
            this.activeIndex = room_id;

            const currContact = this.contactsByUID[contact_user_id];
            // console.log('currContact',currContact);
            this.showDetails(currContact);


            this.currentConvoAvatar = this.contactsByRoomID[room_id].avatar;
            console.log('this.currentConvoAvatar',this.currentConvoAvatar);

            this.currentConvoName = this.contactsByRoomID[room_id].username;

            if(this.tabs[room_id]!=undefined)
            {
              this.setActiveChannelIndex(room_id);
              console.log('openConvo setActiveChannelIndex',room_id);
            
            }
            // else{

            //   this.loadChatMessages(room_id);

            // }

                let channelName = 'room-'+room_id;

                // console.log('channelName',channelName);

                if (!channelName?.trim().length) {
                    return;
                }

                channelName = channelName.trim();

                // Register and subscribe to events on the private channel.
                window.Echo.private(channelName)
                    .subscribed(() => {
                        const channel = new Channel({
                            type: 'private',
                            name: channelName
                        });
                        
                        this.tabs.push(channel);

                        // this.contacts[user_id]['channel'] = channel;
                        // this.setActiveChannelIndex(user_id);

                        // this.setActiveChannelIndex(this.tabs.length - 1);
                        this.setActiveChannelIndex(room_id);
                        // this.updateStatusMessageOnUI(channel, "Subscribed to private room " + channelName);
                        // console.log('subscribed',channel);
                        // console.log('tabs',this.tabs);
                        // console.log('contacts',this.contacts);
                        if(this.tabs[room_id]!=undefined)
                        {
                          //
                        }else{
                          this.loadChatMessages(room_id);
                        }
                    })
                    .listenToAll((eventName, data) => {
                        console.log("Event ::  " + eventName + ", data is ::" + JSON.stringify(data));
                    })
                    .listen('PrivateMessageEvent', (data) => {
                        const channel = this.getChannelByName(channelName, 'private');
                        this.updateBroadcastNotificationOnUI(channel, data)
                    })
                    .listenForWhisper('message', (data) => {
                        const channel = this.getChannelByName(channelName, 'private');
                        this.updateUserMessageOnUI(channel, data.message, data.user);
                    })
                    .listenForWhisper('typing', (data) => {
                        let user = data.user;
                        if(!user)
                            return;

                        const channel = this.getChannelByName(channelName, 'private');
                        clearTimeout(channel.typingStopEvents[user]);

                        if(!channel.typingNames.includes(user))
                            channel.typingNames.push(user);

                        channel.typingStopEvents[user] = setTimeout(() => {
                            delete channel.typingStopEvents[user];
                            channel.typingNames = channel.typingNames.filter(e => e !== user);
                        }, 1500);

                    })
                    .error((err) => {
                        
                        alert("An error occurred while trying to join a private room, check the console for details.");

                        console.error(err);
                    });

                // Register and subscribe to presence changes on presence channel.
                window.Echo.join(channelName)
                    .subscribed(()=> {
                        console.log(channelName, "Subscribed to presence room " + channelName);
                    })
                    .here((members) => {
                        const channel = this.getChannelByName(channelName, 'private');

                        // if(members.length <= 1)
                        //     this.updateStatusMessageOnUI(channel, "There are no other users in this room");
                        // else
                        //     this.updateStatusMessageOnUI(channel, "There are " + members.length + " users in this room");

                        channel.memberCount = members.length;
                        console.log("List of members: " + JSON.stringify(members));
                    })
                    .joining((data) => {
                        const channel = this.getChannelByName(channelName, 'private');

                        // if (data?.name)
                        //     this.updateStatusMessageOnUI(channel, data.name + " joined the room");
                        // else
                        //     this.updateStatusMessageOnUI(channel, "User " + data + " joined the room");

                        console.log(data, "joined room");
                    })
                    .leaving((data) => {
                        const channel = this.getChannelByName(channelName, 'private');

                        // if (data?.name)
                        //     this.updateStatusMessageOnUI(channel, data.name + " left the room")
                        // else
                        //     this.updateStatusMessageOnUI(channel, "User " + data + " left the room")

                        console.log(data, "left room");
                    })
                    .listenToAll((eventName, data) => {
                        console.log("Event ::  "+ eventName + ", data is ::" + JSON.stringify(data));
                    })
                    .error((err)=> {
                        console.error(err)
                    })
            // } 
        },
        timeSince(date) {
            var seconds = Math.floor((new Date() - date) / 1000);

            var interval = seconds / 31536000;

            if (interval > 1) {
            return Math.floor(interval) + " years";
            }
            interval = seconds / 2592000;
            if (interval > 1) {
            return Math.floor(interval) + " months";
            }
            interval = seconds / 86400;
            if (interval > 1) {
            return Math.floor(interval) + " days";
            }
            interval = seconds / 3600;
            if (interval > 1) {
            return Math.floor(interval) + " hours";
            }
            interval = seconds / 60;
            if (interval > 1) {
            return Math.floor(interval) + " mins";
            }
            return Math.floor(seconds) + " secs";
        },
        // subscribeToPrivateAndPresenceChannel(event) {
        //     if(!page.props.auth.user)
        //         Swal.fire({
        //             title: 'You are a guest user, please sign up for joining private channels.',
        //             buttonsStyling : false,
        //             showCancelButton : true,
        //             confirmButtonText : "Yes, I want to register",
        //             cancelButtonText : "Stay on the homepage",
        //             customClass: {
        //                 confirmButton: 'btn-alt-confirm btn-confirm-custom-event',
        //                 cancelButton : 'btn-secondary',
        //                 title : 'custom-title'

        //             }}).then(function (result) {
        //             if (result.value) {
        //                 window.location = "/register"
        //             }
        //         });
        //     else
        //     Swal.fire({
        //         input : "text",
        //         title: "Enter the private room name <br>  (e.g. room-1, room-2)",
        //        buttonsStyling : false,
        //        showCancelButton : true,
        //        customClass: {
        //            confirmButton: 'btn-primary',
        //            cancelButton : 'btn-secondary',
        //            title : 'custom-title'

        //        },

        //     }).then(r => {
        //         let channelName = r.value

        //         console.log('channelName',channelName);

        //         if (!channelName?.trim().length) {
        //             return;
        //         }
        //         channelName = channelName.trim();

        //         // Register and subscribe to events on the private channel.
        //         window.Echo.private(channelName)
        //             .subscribed(() => {
        //                 const channel = new Channel({
        //                     type: 'private',
        //                     name: channelName
        //                 });

        //                 this.tabs.push(channel);
        //                 this.setActiveChannelIndex(this.tabs.length - 1);
        //                 // this.updateStatusMessageOnUI(channel, "Subscribed to private room " + channelName);
        //                 console.log('subscribed',channel);
        //                 console.log('tabs',tabs);
        //             })
        //             .listenToAll((eventName, data) => {
        //                 console.log("Event ::  " + eventName + ", data is ::" + JSON.stringify(data));
        //             })
        //             .listen('PrivateMessageEvent', (data) => {
        //                 const channel = this.getChannelByName(channelName, 'private');
        //                 this.updateBroadcastNotificationOnUI(channel, data)
        //             })
        //             .listenForWhisper('message', (data) => {
        //                 const channel = this.getChannelByName(channelName, 'private');
        //                 this.updateUserMessageOnUI(channel, data.message, data.user);
        //             })
        //             .listenForWhisper('typing', (data) => {
        //                 let user = data.user;
        //                 if(!user)
        //                     return;

        //                 const channel = this.getChannelByName(channelName, 'private');
        //                 clearTimeout(channel.typingStopEvents[user]);

        //                 if(!channel.typingNames.includes(user))
        //                     channel.typingNames.push(user);

        //                 channel.typingStopEvents[user] = setTimeout(() => {
        //                     delete channel.typingStopEvents[user];
        //                     channel.typingNames = channel.typingNames.filter(e => e !== user);
        //                 }, 1500);

        //             })
        //             .error((err) => {
                        
        //                 alert("An error occurred while trying to join a private room, check the console for details.");

        //                 console.error(err);
        //             });

        //         // Register and subscribe to presence changes on presence channel.
        //         window.Echo.join(channelName)
        //             .subscribed(()=> {
        //                 console.log(channelName, "Subscribed to presence room " + channelName);
        //             })
        //             .here((members) => {
        //                 const channel = this.getChannelByName(channelName, 'private');

        //                 // if(members.length <= 1)
        //                 //     this.updateStatusMessageOnUI(channel, "There are no other users in this room");
        //                 // else
        //                 //     this.updateStatusMessageOnUI(channel, "There are " + members.length + " users in this room");

        //                 channel.memberCount = members.length;
        //                 console.log("List of members: " + JSON.stringify(members));
        //             })
        //             .joining((data) => {
        //                 const channel = this.getChannelByName(channelName, 'private');

        //                 // if (data?.name)
        //                 //     this.updateStatusMessageOnUI(channel, data.name + " joined the room");
        //                 // else
        //                 //     this.updateStatusMessageOnUI(channel, "User " + data + " joined the room");

        //                 console.log(data, "joined room");
        //             })
        //             .leaving((data) => {
        //                 const channel = this.getChannelByName(channelName, 'private');

        //                 // if (data?.name)
        //                 //     this.updateStatusMessageOnUI(channel, data.name + " left the room")
        //                 // else
        //                 //     this.updateStatusMessageOnUI(channel, "User " + data + " left the room")

        //                 console.log(data, "left room");
        //             })
        //             .listenToAll((eventName, data) => {
        //                 console.log("Event ::  "+ eventName + ", data is ::" + JSON.stringify(data));
        //             })
        //             .error((err)=> {
        //                 console.error(err)
        //             })
        //    });

        // },

        // Uses to send message to other clients using client-events.
        publishMessageOnPrivateChannel(event) {
          
            if(this.currContact.length==0){
              Swal.fire({
                  title: 'No contact selected.',
                  buttonsStyling : false,
                  confirmButtonText : "OK, Got It!",
                  customClass: {
                      confirmButton: 'btn btn-md btn-success text-white',

              }});
              return;
            }

            const userName = this.userName?.trim();
            const message = this.message?.trim();
            if(!message || !userName)
                return;

            const channel = this.getActiveChannel();

            window.Echo.private(channel.name).whisper('message', {
                user: userName,
                message: message
            }, (err) => {

                if(!err && !window.Echo.options.echoMessages) {
                    this.updateUserMessageOnUI(channel, message, userName);
                    // console.log('TO-UPDATE channel',channel);
                    // console.log('TO-UPDATE message',message);
                    // console.log('TO-UPDATE userName',userName);

                    this.logChatMessage(this.activeIndex, this.currContact, message, this.messageVia);
                }
            });
            this.message = null;
            document.querySelector(".ql-editor").innerHTML = '';
            document.querySelector(".ql-editor").focus();
            
            this.scrollToBottom();
        },
        logChatMessage(room_id, currContact, message, messageVia){
          var via_email = messageVia=='email' ? 1 : 0;
          axios.post('/inbox/log-message', { room_id:room_id, sender_id:this.userId, via_email:via_email, message:message });
        },
        loadChatMessages(room_id){
          axios.post('/inbox/get-room-messages', { room_id:room_id })
          .then((res) => {    
            
            const channel = this.getActiveChannel();

            if(res.data.messages.length>0)
            {
              const messages = res.data.messages;
              for(var i in messages)
              {
                var message = messages[i];

                 console.log('time', new Date(message.time));
                
                channel.messages.push(new Message({
                    type: 'user',
                    user: message.user,
                    content: message.content,
                    time: new Date(message.time)
                }));

              }

              this.scrollToBottom();

            }
          })
          .catch((error) => {
              console.log(error.message);
          });
        },
        /**
         * @param event KeyboardEvent
         */
        // publishTypingEvent(event) {
        //     if (this.throttleTyping || event.key.length !== 1)
        //         return;

        //     this.throttleTyping = true;

        //     const userName = this.userName?.trim();
        //     const channel = this.getActiveChannel();
        //     window.Echo.private(channel.name)
        //         .whisper('typing', { user: userName });

        //     setTimeout(() => {
        //         this.throttleTyping = false;
        //     }, 1000);
        // },

        // Message is published/broadcasted using laravel public API endpoint - /api/public-event
        // broadcastMessageOnPublicChannel() {
        //     const message = this.message?.trim();
        //     if(!message)
        //         return;

        //     const publicChannelName = this.getActiveChannel().name;

        //     const broadcastUrl = window.location.origin + "/api/public-event";
        //     axios.post(broadcastUrl, { channelName : publicChannelName , message });

        //     this.message = null;
        // },

        // Unsubscribe and leaves the channel
        leaveChannel(event) {
            const channel = this.getActiveChannel();
            window.Echo.leave(channel.name);

            this.tabs.splice(this.activeIndex, 1);

            if (this.tabs.length) {
                if (this.activeIndex === 0) {
                    this.setActiveChannelIndex(0);
                } else
                    this.setActiveChannelIndex(this.activeIndex - 1);
            }
        },
        updateStatusMessageOnUI(channel, message) {
            channel.messages.push(new Message({
                type: 'status',
                content: message
            }))

            this.scrollToBottom();
        },
        updateUserMessageOnUI(channel, message, user) {
            channel.messages.push(new Message({
                type: 'user',
                user: user,
                content: message
            }));

            this.scrollToBottom();
        },
        updateBroadcastNotificationOnUI(channel, data) {
            channel.messages.push(new Message({
                type: 'broadcast',
                content: data.message
            }));

            this.scrollToBottom();
        },
        getChannelByName(channelName, type) {
            return this.tabs.find(obj => {
                return obj.name === channelName && obj.type === type;
            });
        },
        getActiveChannel() {
            console.log('getActiveChannel index',this.activeIndex);
            console.log('getActiveChannel tabs',this.tabs);
            var room = 'room-'+this.activeIndex;
            for(var k in this.tabs)
            {
              if(this.tabs[k].name == room)
              {
                return this.tabs[k];
              }
                // console.log('targettab',this.tabs[k].name);
            }
            // return this.tabs[this.activeIndex];
        },
        setActiveChannelIndex(index) {
            this.activeIndex = index;
            console.log('setActiveChannelIndex index',this.activeIndex);
            this.focusMessageInput();
        },
        scrollToBottom() {
            this.$nextTick(() => {
                let msgCon = document.querySelector('.messageContainer');
                msgCon.scrollIntoView({behavior: "smooth", block: "end"});
                console.log('scroll to view');
            });
        },
        focusMessageInput() {
          document.querySelector(".ql-editor").focus();
            // this.$nextTick(() => {
            //     const input = this.$el.querySelector("#myTabContent > .tab-pane.active .messageInput");
            //     console.log(input);
            //     if (input) {
            //         input.focus();
            //     }
            // });
        },
        // checkMessageTarget(){
        //   if (this.messageVia=='email')
        //   {
        //     console.log('messageVia email - this.gmailAuthorized',this.gmailAuthorized);
        //     if(this.gmailAuthorized==='no')
        //     {
        //       //call func from views/app.blade.php
        //       handleAuthClick();
        //     }else{
        //       console.log('this.gmailAuthorized',this.gmailAuthorized);
        //       // getProfile();
        //     }
        //   }
        // },
        // logoutGAPI(){
        //   //call func from views/app.blade.php
        //   handleSignoutClick();
        //   this.gmailAuthorized = 'no';
        //   console.log('this.gmailAuthorized',this.gmailAuthorized);
        // },
        // loadGAPIProfile(){
        //   loadGAPIProfile();
        // }
    }

}
// import Vue from "vue";
// import VueSimpleAlert from "vue-simple-alert";

// Vue.use(VueSimpleAlert);
</script>
