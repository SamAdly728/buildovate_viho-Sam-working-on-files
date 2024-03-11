<template>
    <div id="gmail_menu">
        <div class="media">
            <div class="media-size-email"><img class="me-3 rounded-circle" src="https://dev2.buildovate.io/assets/images/user/user.png" alt=""></div>
            <div class="media-body">
            <h6 class="f-w-600">MARKJENCO</h6>
            <p>Markjecno@gmail.com</p>
            <!-- <p><a href="javscript:void(0)" @click="logoutGmail" id="signout_button">Signout</a></p> -->
            </div>
        </div>
        <ul class="nav main-menu" role="tablist">
            <li class="nav-item">
            <a class="btn-primary btn-block btn-mail w-100" id="pills-darkhome-tab" href="javascript:void(0)">
                <i class="icofont icofont-envelope me-2"></i> NEW MAIL
            </a>
            </li>
            <li class="nav-item">
                <Link 
                    class=""
                    preserve-scroll 
                    href="/inbox/gmail"
                    >
                    <span class="title">
                    <i class="icon-email"></i> Inbox</span>
                    <span class="badge pull-right" v-if="unread">( {{ unread }} )</span>
                </Link>
            </li>
            <li>
                <Link 
                    class=""
                    preserve-scroll 
                    href="/inbox/gmail/assigned"
                    >
                    <span class="title">
                    <i class="icon-user"></i> Assigned</span>
                    <span class="badge pull-right" v-if="assigned">( {{ assigned }} )</span>
                </Link>
            </li>
            <li>
                <Link 
                    class=""
                    preserve-scroll 
                    href="/inbox/gmail/drafts"
                    >
                    <span class="title">
                    <i class="icon-pencil-alt"></i> Drafts</span>
                    <span class="badge pull-right" v-if="drafts">( {{ drafts }} )</span>
                </Link>
            </li>
            <li>
                <Link 
                    class=""
                    preserve-scroll 
                    href="/inbox/gmail/closed"
                    >
                    <span class="title">
                    <i class="icon-import"></i> Closed</span>
                    <span class="badge pull-right" v-if="closed">( {{ closed }} )</span>
                </Link>
            </li>
            
            <li>
            <hr>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<script>

import axios from 'axios';

export default {
//   name: 'app',
  mounted(){
    this.getUnreadTotal();
  },
//   props: ['inbox_channel'],
  data() {
      
      return {
        unread: 0,
        drafts:0,
        assigned:0,
        closed:0
      }
  },
  methods:{
    getUnreadTotal(){
      axios.post('/inbox/gmail/get-mail-totals', {} )
      .then((res) => {
        if(res.data)
        {
          this.unread = res.data.unread;
          this.drafts = res.data.drafts;
        }
      })
      .catch((error) => {
        console.log('error',error.message);
      });
      
    }

    

  }
}

</script>
