<template>
   <div id="chat">
      <!-- Your chat component code here -->
      <!-- Messenger Chat Plugin Code -->
      <div id="fb-root"></div>

      <!-- Your Chat Plugin code -->
      <div id="fb_customer_chat" class="fb-customerchat" page_id="147159478470782" attribution="biz_inbox">
      </div>
   </div>
</template>

<script setup>
//   var chatbox = document.getElementById('fb_customer_chat');
//   console.log('chatbox',chatbox);

//   chatbox.setAttribute("page_id", "147159478470782");
//   chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v18.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>

<!-- <script>
export default {
name: 'Chat',
data() {
   return {
      // Your data properties here
   };
},
methods: {
   // Your methods here
},
};
</script> -->

<style scoped>
/* Your CSS styles here */
</style>