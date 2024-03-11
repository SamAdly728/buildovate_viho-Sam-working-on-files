<style scoped>
html,
body {
  height: 100%;
}

.contact-btns {
  border: 1px solid;
  border-radius: 50%;
  padding: 7px 10px;
}

.contact-btns:hover {
  background-color: #24695c;
  color: #ffffff;
}

.com-links {
  width: 18px;
  height: 18px;
}

#ql-editor {
  height: 300px !important;
  overflow: scroll !important;
  border: 1px solid !important;
  overflow-x: hidden;
}

.message-data-time {
  font-size: 11px !important;
//font-weight: 400px; font-style: italic;
}

.my-message {
  background-color: aliceblue;
  color: #000000 !important;
}

.other-message {
  background-color: #e6edef;
  color: #000000 !important;
}

/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}

/* 
.bounce-enter-active {
  animation: bounce-in 0.5s;
}
.bounce-leave-active {
  animation: bounce-in 0.5s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.25);
  }
  100% {
    transform: scale(1);
  }
} */

.chat-box .people-list ul {
  max-height: 650px !important;
}

.email-subject {
  font-size: 12px !important;
  font-weight: 400 !important;
}

.media {
  border-bottom: 1px solid #cccc !important;
  padding-bottom: 15px !important;
}

.show {
  visibility: visible !important
}

.thread-header {
  font-weight: 500 !important;
  font-size: 12px !important;
  text-align: left !important;
  width: 85%;
  padding-left: 0px;
}

.thread-body {
  border-top: 1px solid #eee;
}

.thread-total {
  font-size: 10px;
}

.btn-link2 {
  border: 1px solid #ccc !important;
  border-radius: 50px !important;
  color: #555 !important;
}

.chat-box .chat-right-aside .chat .chat-message {
  width: 93% !important;
}

#laterTable, thead, tbody, tfoot, tr, td, th {
  border: none !important;
}

#laterTable tr:hover {
  background-color: #eeeeee !important;
}

.snippets {
  font-size: 12px;
  font-style: italic;
}

.fixedDivs {
  position: fixed;
  top: 103px;
  z-index: 100;
}

.card-headers {
  border: none;
  cursor: pointer;
}

.ctitles {
  font-size: x-small;
}

.cvalues {
  font-size: 12px;
}

.add-btn {
  padding: 1px 3px 1px 5px;
  border-radius: 50px;
}

.add-btn-icon {
  font-size: 12px !important;
  padding: 0px;
  margin: 0px;
}

.col-form-label {
  font-weight: 400 !important;
}

.relation-badge {
  border-radius: 50%;
}

.table th, .table td {
  padding: 5px !important;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #1E5BB2 !important;
  border-radius: 10px !important;
}

#custom-datepicker-inbox {
//width: 267px !important; border-radius: 0 !important;
  -webkit-box-shadow: none !important;
  -moz-box-shadow: none !important;
  box-shadow: none !important;
  z-index: 999999;
  position: fixed;
}

.vuejs3-datepicker__calendar {
  width: 400px !important;
  box-shadow: none !important;
}

.flatpickr-input {
  display: none !important;
}

/*.flatpickr-calendar .animate .inline {
  width: auto !important;
  box-shadow: none !important;
  border-radius: 0 !important;
  -webkit-box-shadow: none !important;
}*/

/* CSS for zoom-in animation */
@keyframes zoomIn {
  from {
    transform: scale(0);
  }
  to {
    transform: scale(1);
  }
}

.modal.fade .modal-dialog {
  animation: zoomIn 0.1s ease-out;
}

#mini-calendar {
  width: 200px;
  margin: 0 auto;
  font-size: 10px;
}

.fc-toolbar {
  font-size: .9em;
}

.fc-toolbar h2 {
  font-size: 12px;
  white-space: normal !important;
}

/* click +2 more for popup */
.fc-more-cell a {
  display: block;
  width: 85%;
  margin: 1px auto 0 auto;
  border-radius: 3px;
  background: grey;
  color: transparent;
  overflow: hidden;
  height: 4px;
}

.fc-more-popover {
  width: 100px;
}

.fc-view-month .fc-event, .fc-view-agendaWeek .fc-event, .fc-content {
  font-size: 0;
  overflow: hidden;
  height: 2px;
}

.fc-view-agendaWeek .fc-event-vert {
  font-size: 0;
  overflow: hidden;
  width: 2px !important;
}

.fc-agenda-axis {
  width: 20px !important;
  font-size: .7em;
}

.fc-button-content {
  padding: 0;
}

.grey-background {
  background-color: #F6F5F5 !important;
}

.custom-overflow {
  overflow-y: scroll;
  overflow-x: hidden;
}

.ontop.nav-link.active {
  background-color: transparent;
  border-color: transparent;
  color: #000;
}
</style>

<template>
  <!-- Container-fluid starts-->
  <div class="p-3">

    <div class="row">
      <!-- CONTACT LIST   -->
      <!-- <div class="col call-chat-sidebar"> -->
      <div class="col-md-1" style="margin-right: 0px; padding-right: 0px; width: 130px">
        <div class="card h-100">
          <div class="" style="margin-top: 150px">
            <ul class="nav nav-tabs flex-column" id="myTab" role="tablist">
              <li class="nav-item">
                <a @click="setActiveNav('gmail')" class="nav-link border active rounded-0 pt-3 pb-3" id="gmail-tab"
                   data-bs-toggle="tab" href="#gmail" role="tab" aria-controls="home" aria-selected="true">
                  <div class="d-flex justify-content-between align-items-center">
                    <i class="icofont icofont-social-google-plus mr-0 h1 text-danger"></i>
                    <span class="d-inline span badge rounded-pill"
                          style="margin-top: -5px; background-color: #1E5BB2">{{ gmailCount }}</span>
                  </div>
                </a>
              </li>
              <li class="nav-item">
                <a @click="setActiveNav('facebook')" class="nav-link border rounded-0 pt-3 pb-3" id="facebook-tab"
                   data-bs-toggle="tab" href="#facebook" role="tab" aria-controls="home" aria-selected="true">
                  <div class="d-flex justify-content-between align-items-center">
                    <i class="icofont icofont-social-facebook h2" style="color: #316FF6"></i>
                    <span
                        class="d-inline span badge rounded-pill pill-badge-warning mb-1" style="background-color: #1E5BB2">{{ facebookThreadCount }}</span>
                  </div>
                </a>
              </li>
              <li class="nav-item">
                <a @click="setActiveNav('instagram')" class="nav-link border rounded-0 pt-3 pb-3" id="instagram-tab"
                   data-bs-toggle="tab" href="#instagram" role="tab" aria-controls="home" aria-selected="true">
                  <div class="d-flex justify-content-between align-items-center">
                    <i class="icofont icofont-social-instagram mr-0 h3" style="color: #F56040"></i>
                    <span class="d-inline span badge rounded-pill pill-badge-warning mb-2" style="background-color: #1E5BB2">0</span>
                  </div>
                </a>
              </li>
              <li class="nav-item">
                <a @click="setActiveNav('yelp')" class="nav-link border rounded-0 pt-3 pb-3" id="yelp-tab"
                   data-bs-toggle="tab" href="#yelp" role="tab" aria-controls="home" aria-selected="true">
                  <div class="d-flex justify-content-between align-items-center">
                    <i class="icofont icofont-social-yelp mr-0 h3" style="color: #FF1A1A"></i>
                    <span class="d-inline span badge rounded-pill pill-badge-warning mb-2" style="background-color: #1E5BB2">0</span>
                  </div>
                </a>
              </li>
              <li class="nav-item">
                <a @click="setActiveNav('text-message')" class="nav-link border rounded-0 pt-3 pb-3" id="text-tab"
                   data-bs-toggle="tab" href="#text-message" role="tab" aria-controls="home" aria-selected="true">
                  <div class="d-flex justify-content-between align-items-center">
                    <i class="icofont icofont-ui-text-chat mr-0 h4"></i>
                    <span class="d-inline span badge rounded-pill pill-badge-warning mb-2" style="background-color: #1E5BB2">0</span>
                  </div>
                </a>
              </li>
              <li class="nav-item">
                <a @click="setActiveNav('webchat')" class="nav-link border rounded-0 pt-3 pb-3" id="webchat-tab"
                   data-bs-toggle="tab" href="#webchat" role="tab" aria-controls="home" aria-selected="true">
                  <div class="d-flex justify-content-between align-items-center">
                    <i class="icofont icofont-chat h3 mr-0"></i>
                    <span class="d-inline span badge rounded-pill pill-badge-warning mb-2" style="margin-top: -4px; background-color: #1E5BB2">0</span>
                  </div>
                </a>
              </li>
              <li class="nav-item">
                <a @click="setActiveNav('whatsapp')" class="nav-link border rounded-0 pt-3 pb-3" id="whatsapp-tab"
                   data-bs-toggle="tab" href="#whatsapp" role="tab" aria-controls="home" aria-selected="true">
                  <div class="d-flex justify-content-between align-items-center">
                    <i class="icofont icofont-brand-whatsapp mr-0 h3" style="color: #25D366"></i>
                    <span class="d-inline span badge rounded-pill pill-badge-warning mb-2" style="background-color: #1E5BB2">0</span>
                  </div>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-3"
           style="margin-left: 0px; padding-left: 0px; margin-right: 0px !important;padding-right: 0px;">
        <div class="card h-100">
          <div class="card-body chat-body">
            <div class="chat-box">
              <!-- Chat left side Start-->
              <div class="chat-left-aside">

                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="">Select Conversation</span>
                  <a @click="openSettings"><i class="icofont icofont-gear h4 mt-1" style="cursor: pointer; color: #1E5BB2"
                                              title="Go to Settings"></i></a>
                </div>

                <div class="people-list" id="people-list">
                  <div class="search">
                    <!-- <form class="theme-form" > -->
                    <div class="form-group">
                      <input @keyup.enter="loadPage('search')" v-model="search" class="form-control" type="text">
                      <i class="fa fa-search"></i>
                    </div>
                    <!-- </form> -->
                  </div>
                  <!-- LIST USER MESSAGES -->
                  <div id="listOfMessages" :class="{'custom-scrollbar custom-overflow': !showGmailLoader}"
                       class="tab-content">

                    <ul class="list tab-pane fade show active" id="gmail" role="tabpanel" aria-labelledby="gmail-tab">
                      <TransitionGroup>
                        <li class="clearfix" v-for="m in listOfMessages" :key="m.id" style="cursor: pointer">
                          <div @click="loadMessage(m)" class="media">
                            <!-- <i class="icon-email text-secondary fs-5"></i> -->
                            <div class="media-body">
                              <div class="pull-right text-muted fs-7" style="margin-right: 1rem">
                                <small>{{new Date(m.date).toLocaleDateString('en-us', {month: "short", day: "numeric"})}}</small>
                              </div>
                              <span v-html="trimText(m.from, 23)" class="ml-2 f-w-500"></span><span
                                class="text-muted thread-total">{{ m.threadTotal }}</span>
                              <div class="ml-2 email-subject">
                                <i class="icon-email text-success fs-7"></i>
                                {{ trimText(m.subject, 24) }}
                              </div>
                              <div class="ml-2 mr-2 text-muted snippets mt-1" v-html="trimText(m.snippet, 65)"></div>
                            </div>
                          </div>

                        </li>
                      </TransitionGroup>
                    </ul>
                    <i class="fa fa-spin fa-spinner h1 txt-primary" style="margin-left: 50%; margin-top: 50%"
                       v-if="showGmailLoader"></i>
                    <p class="txt-primary" style="margin-left: 47%;" v-if="showGmailLoader">Loading...</p>
                    <ul class="list tab-pane fade" id="facebook" role="tabpanel" aria-labelledby="facebook-tab">
                      <div v-for="f in facebookThreads">
                        <li class="clearfix">
                          <div @click="getFacebookMessage(f.conId, f.from, f.userId)" class="media mt-2"
                               style="cursor: pointer">
                            <img class="rounded-circle user-image"
                                 src="https://dev2.buildovate.io/assets/images/dashboard/1.png" alt="">
                            <!--                          <div class="status-circle away"></div>-->
                            <div class="media-body">
                              <div class="about">
                                <div class="name mt-2">{{ f.from }}</div>
                                <!--                                <div class="status">Hello Name</div>-->
                              </div>
                            </div>
                          </div>
                        </li>
                      </div>
                    </ul>
                    <ul class="list tab-pane fade" id="instagram" role="tabpanel" aria-labelledby="instagram-tab">
                      instagram
                    </ul>
                    <ul class="list tab-pane fade" id="yelp" role="tabpanel" aria-labelledby="yelp-tab">
                      yelp
                    </ul>
                    <ul class="list tab-pane fade" id="text-message" role="tabpanel" aria-labelledby="text-message-tab">
                      text
                    </ul>
                    <ul class="list tab-pane fade" id="webchat" role="tabpanel" aria-labelledby="webchat-tab">
                      webchat
                    </ul>
                    <ul class="list tab-pane fade" id="whatsapp" role="tabpanel" aria-labelledby="whatsapp-tab">
                      whatsapp
                    </ul>

                  </div>

                  <div class="pt-3 pb-3 text-center" v-if="activeNav === 'gmail' && gmailCount != 0">

                    <button @click="loadPage('previous')" :disabled="prevToken==='' || listLoading"
                            class="btn btn-sm btn-light" style="margin-right: 5px">
                      <i class="fa fa-chevron-left" v-if="!listPrev"></i>
                      <i class="fa fa-spin fa-spinner" v-if="listPrev"></i>
                    </button>

                    <!-- &nbsp;<small v-if="listLoading">loading...</small>&nbsp; -->
                    <!--                    &nbsp;<img :src="'/images/loading-loader.gif'" v-if="listLoading" style="width: 40px;height: 40px;display: inline-block;"/>&nbsp;-->
                    <button @click="loadPage('next')" :disabled="nextToken==='' || listLoading"
                            class="btn btn-sm btn-light">
                      <i class="fa fa-chevron-right" v-if="!listNext"></i>
                      <i class="fa fa-spin fa-spinner" v-if="listNext"></i>
                    </button>

                  </div>
                </div>

              </div>

              <!-- Chat left side Ends-->
            </div>
          </div>
        </div>
      </div>

      <!-- MESSAGE DISPLAY -->

      <!-- <div class="col call-chat-body"> -->
      <div class="col-md-6"
           style="margin-right: 0px !important; padding-right: 0px;margin-left: 0px;padding-left: 0px; width: 48.9333% !important;">
        <div class="card h-100">
          <div class="card-body p-0">
            <div class="row chat-box">
              <div class="col chat-right-aside">
                <div class="chat">
                  <div class="media chat-header clearfix p-0 m-0" style="padding-bottom: 0 !important;">
                    <ul class="nav nav-tabs" id="myTab" role="tablist" >
                      <li class="nav-item" v-for="t in tabs">
                        <a class="nav-link ontop border rounded-0" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                          <i class="icon-email fs-6" style="color: #1E5BB2"></i>
                          {{ emailFrom }}
                          <span @click="removeTab(t.index)" style="margin-left: 10px !important;">&times;</span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link border rounded-0" @click="addTab">
                          <span class="h6" style="cursor: pointer">+</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                  <!-- MESSAGE HEADER -->
                  <div class="media chat-header clearfix" v-if="activeNav === 'gmail' && emailFrom">
                    <div class="media-body" v-if="headerSubject">
                      <div class="about">
                        <div class="name text-success fs-6">
                          <i class="icon-email text-success fs-6"></i>
                          {{ emailFrom }}
                        </div>
                        <div class="status digits"><small>{{ headerSubject }}</small></div>
                      </div>
                    </div>
                    <!--                    <li class="list-inline-item mt-1 mr-0" v-if="!emailFrom">{{ new Date().toLocaleDateString('en-us', { month: 'short', day:"numeric"}) }}</li>-->
                    <ul class="list-inline float-start float-sm-end chat-menu-icons">
                      <li class="list-inline-item mt-1 mr-0">
                        {{ new Date(messageDate).toLocaleDateString('en-us', {month: 'short', day: "numeric"}) }}
                      </li>
                      <li class="list-inline-item toogle-bar ml-0">
                        <i class="icofont icofont-bell-alt h5 me-2 text-primary"></i>
                        <a @click="replyTo" title="Reply">
                          <i class="icofont icofont-reply me-2 text-success"></i>
                        </a>
                        <a @click="replyTo" title="Reply All">
                          <i class="icofont icofont-reply-all me-2 text-success"></i>
                        </a>
                        <a @click="forwardTo" title="Forward">
                          <i class="icofont icofont-share-alt me-2 text-success"></i>
                        </a>
                        <a href="#" title="Delete">
                          <i class="icofont icofont-trash text-danger"></i>
                        </a>
                      </li>
                    </ul>
                  </div>

                  <div class="media chat-header clearfix" v-if="activeNav === 'facebook'">
                    <div class="media-body">
                      <div class="about">
                        <div class="name fs-6">
                          <i class="icofont icofont-social-facebook-messenger h6 "
                             v-if="facebookMessageHeader"></i>
                          {{ facebookMessageHeader }}
                        </div>
                      </div>
                    </div>
                    <li class="list-inline-item mt-1 mr-0">{{new Date().toLocaleDateString('en-us', {month: 'short',day: "numeric"})}}
                    </li>
                  </div>

                  <div class="custom-scrollbar" style="height:800px;overflow-y:scroll" v-if="activeNav === 'gmail'">
                    <!-- MESSAGE BODY -->
                    <div class="tab-content mb-3 " id="myTabContent" v-if="message.length>0">
                      <TransitionGroup>
                        <div class="card m-15" v-for="t in threads" :key="t.id">
                          <!-- THREAD HEADER -->
                          <div class="card-header p-2">
                            <div class="row mb-0">
                              <div class="col-md-9">
                                      <span class="me-2">
                                        <img class="rounded-circle me-2" :src="'/assets/images/dashboard/1.png'" alt="" style="display: inline-block !important;width: 35px;height: 30px;">
                                      </span>
                                        <span @click="loadThreadMessage(t.id, t.threadId)" class="btn text-secondary thread-header" :aria-expanded="(isActive==t.id) ? true : false">
                                        <div class="fs-7">{{ emailFrom }}</div>
                                        <span v-if="isActive==t.id" class="text-secondary"><small>to me <i
                                            class="fa fa-arrow-down"></i></small></span>
                                        <span v-else v-html="trimText(t.snippet, 65)"></span>
                                      </span>
                              </div>
                              <div class="col-md-3 text-right text-muted"><small>{{
                                  (isActive == t.id) ? formatTimestamp(t.internalDate, 'full') : formatTimestamp(t.internalDate, 'short')
                                }}</small></div>
                            </div>
                          </div>
                          <!-- THREAD CONTENT -->
                          <div :class="(isActive==t.id) ? 'collapse show': 'collapse' ">
                            <div :id="'threads'+t.id" class="p-15 thread-body" v-html="t.snippet"></div>
                          </div>
                        </div>
                      </TransitionGroup>
                      <Message :message="message"/>
                    </div>

                    <!-- REPLY BOX  -->
                    <div class="chat-message2 clearfix2" v-if="showMsgBox">
                      <div class="row m-15" style="border: 1px solid #ddd;">
                        <div class="col-xl-12 p-10">
                          <table class="mb-2" v-if="showTo">
                            <tr>
                              <td width="10%">To:</td>
                              <td width="90%"><input v-model="emailTo" type="email" class="form-control text-primary" placeholder="Enter email..."style="border: none;border-bottom: 1px solid #ccc;"></td>
                            </tr>
                            <tr>
                              <td>Subject:</td>
                              <td><input v-model="emailSubject" type="text" class="form-control" placeholder="Enter subject..."style="font-weight: 600;border: none;border-bottom: 1px solid #ccc;"></td>
                            </tr>
                          </table>
                          <div v-if="!showTo" class="p-1 f-w-700 text-secondary mb-1"><i class="icofont icofont-reply"></i> {{ emailFrom }}</div>
                          <input type="hidden" v-model="userName">
                          <QuillEditor
                              theme="snow"
                              v-model:content="message"
                              contentType="html"
                              placeholder="Type a message..."
                              toolbar="essential"
                              style="height: 250px !important;
                                overflow: scroll !important;overflow-x: hidden;"
                          />

                          <div class="mt-2" v-if="showMsgBox">
                            <button @click="sendMessage" class="btn btn-primary btn-sm" type="button">SEND</button>&nbsp;
                            <button @click="openSendLater" class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                    data-original-title="test" data-bs-target="#sendLaterModal"
                                    data-bs-original-title="" title="">SEND LATER
                            </button>&nbsp;
                            <button @click="replyGPT" class="btn btn-primary btn-sm" type="button">REPLY GPT</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--REPLY BOX -->
                  </div>
                  <div v-if="activeNav === 'facebook'">
                    <!-- chat-header end-->
                    <div class="chat-history chat-msg-box custom-scrollbar"
                         :class="{'grey-background': facebookMessageLoader}" v-if="facebookMessage != null"
                         ref="facebookChatContainer">
                      <ul v-if="!facebookMessageLoader">
                        <li class="clearfix" v-for="c in facebookMessage.slice().reverse()">
                          <div class="message"
                               :class="{'my-message' : c.position == 'right', 'other-message pull-right' : c.position == 'left'}">
                            <!--                            <img class="rounded-circle float-start chat-user-img img-30" src="../assets/images/user/3.png" alt="">-->
                            <div class="message-data text-end">
                              <span class="message-data-time">{{ c.date }}</span>
                            </div>
                            {{ c.message }}
                            <!--                            <div v-html="c.message"></div>-->
                          </div>
                        </li>
                      </ul>
                      <i v-if="facebookMessageLoader" class="fa fa-spin fa-spinner h1 text-muted"
                         style="margin-top: 30%; margin-left: 50%"></i>
                    </div>
                    <!-- end chat-history-->
                    <div class="chat-message clearfix" style="width: 97.5% !important" v-if="facebookMessage != null">
                      <div class="row">
                        <div class="col-xl-12 d-flex">
                          <!--                          <div class="smiley-box bg-success">-->
                          <!--                            <div class="picker">-->
                          <!--                              <img src="https://dev2.buildovate.io/assets/images/smiley.png" alt="">-->
                          <!--                            </div>-->
                          <!--                          </div>-->
                          <div class="input-group text-box">
                            <input v-model="facebookReplyMessage" class="form-control input-txt-bx" id="message-to-send"
                                   type="text" name="message-to-send" placeholder="Type a message......">
                            <button class="btn btn-success input-group-text" type="button"
                                    @click="handleFacebookreply(facebookReplyMessage, facebookPSID, facebookUserId)">
                              <i v-if="!facebookReplyLoader" class="fa fa-send" style="margin-top: -7px"></i>
                              <i v-if="facebookReplyLoader" class="fa fa-spin fa-spinner" style="margin-top: -7px"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- CONTACT DETAILS -->
      <!-- <div  v-if="showContact" class="col call-chat-sidebar"> -->
      <div v-if="showContact" class="col-md-2" style="margin-left: 0px;padding-left: 0px; width: 19.06667% !important;">
        <div class="card h-100 custom-scrollbar" style="overflow-y:auto">
          <div class="card-body chat-body" style="padding: 10px 0px 0px 0px !important;">
            <!--            <a href="javascript:void(0)" @click="showContact=false">-->
            <!--              <i class="icofont icofont-error close-card font-primary pull-right" style="margin-right:10px"></i>-->
            <!--            </a>-->
            <div class="chat-box">
              <!-- Chat left side Start-->
              <div class="chat-left-aside text-center pt-4 custom-scrollbar">

                <img class="rounded-circle mb-4" :src="customer.avatar" alt="" style="display:inline-block !important">

                <div class="name f-w-600 mb-3">{{ customer.first_name }} {{ customer.last_name }}</div>
                <div><small>Status: Lead</small></div>

                <!--                <div class="">-->
                <!--                  <a href="#" class="contact-btns"><i class="fa fa-user"></i></a>&nbsp;-->
                <!--                  <a href="#" class="contact-btns"><i class="fa fa-edit"></i></a>&nbsp;-->
                <!--                  <a href="#" class="contact-btns"><i class="fa fa-bars"></i></a>-->
                <!--                </div>-->
                <br>
                <hr class="p-0 m-0">

                <div class="default-according text-left">

                  <TransitionGroup>

                    <!-- CONTACT INFO -->
                    <div class="card" style="border:none;border-bottom:1px solid #ddd;">
                      <!-- <div class="card-header mb-0" id="headingCI" style="border:none;" data-bs-toggle="collapse" data-bs-target="#collapseCI" aria-expanded="true" aria-controls="#collapseCI"> -->
                      <div @click="toggleContact('ci')" class="card-header mb-0 card-headers"
                           :aria-expanded="(isShown=='ci') ? true : false">
                        <i class="fa fa-phone text-success"></i> Customer's Info
                        <!-- <button class="btn btn-rounded btn-sm btn-primary add-btn pull-right"><i class="fa fa-plus add-btn-icon"></i></button> -->
                        <!--                          <a type="button" data-bs-toggle="modal" data-bs-target="#contactInfoModal" data-bs-original-title="" title="Add Contact Information"  class="btn btn-link text-success pull-right">-->
                        <!--                            <i v-if="contact_phone_numbers.length>1 || contact_emails.length>1" class="icofont icofont-pencil-alt-5 text-warning"></i>-->
                        <!--                            <i v-else class="fa fa-plus-circle"></i>-->
                        <!--                          </a>-->
                      </div>
                      <!-- <div class="collapse show p-15" id="collapseCI" aria-labelledby="headingCI" data-bs-parent="#accordion2"> -->
                      <div class="p-15" :class="(isShown=='ci') ? 'collapse show': 'collapse' ">
                        <p>
                          <button @click="editCustomer(customer)" class="btn btn-primary btn-xs pull-right">Edit
                          </button>
                        </p>

                        <div class="mb-2">
                          <div class="ctitles">First Name: <span class="cvalues">{{ customer.first_name }}</span></div>
                        </div>

                        <div class="mb-2">
                          <div class="ctitles">Last Name: <span class="cvalues">{{ customer.last_name }}</span></div>
                        </div>

                        <div class="mb-2">
                          <div class="ctitles">Display Name: <span class="cvalues">{{ customer.display_name }}</span>
                          </div>
                        </div>

                        <div class="mb-2">
                          <div class="ctitles">Email: <span class="cvalues">{{ customer.email }}</span></div>
                        </div>

                        <div class="mb-2">
                          <div class="ctitles">Address: <span class="cvalues">{{ customer.street_address }}</span></div>
                        </div>

                        <div class="mb-2">
                          <div class="ctitles">City: <span class="cvalues">{{ customer.city }}</span></div>
                        </div>

                        <div class="mb-2">
                          <div class="ctitles">State: <span class="cvalues">{{ customer.state }}</span></div>
                        </div>

                        <div class="mb-2">
                          <div class="ctitles">Zip Code: <span class="cvalues">{{ customer.zip_code }}</span></div>
                        </div>

                        <!--                          <div class="ctitles">Address: </div>-->
                        <!--                            <div v-if="customer.biz!=null" class="cvalues">-->
                        <!--                              {{ customer.street_address }}-->
                        <!--                              {{ customer.city }}-->
                        <!--                              {{ customer.state }}-->
                        <!--                              {{ customer.country }}-->
                        <!--                              {{ customer.zip_code }}-->
                        <!--                            </div>-->
                      </div>
                    </div>

                    <!-- JOBSITE INFO -->
                    <div class="card" style="border:none;border-bottom:1px solid #ddd;">
                      <div @click="toggleContact('r')" class="card-header mb-0 card-headers"
                           :aria-expanded="(isShown=='r') ? true : false">
                        <i class="fa fa-users text-primary"></i> Jobsite Info
                        <!--                          <span v-if="relationships.length>0" style="display:inline-block" class=text-muted>({{ relationships.length }})</span>-->
                        <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#relationshipsModal" data-bs-original-title="" title="Add Relationships" class="btn btn-rounded btn-sm btn-primary add-btn pull-right"><i class="fa fa-plus add-btn-icon"></i></button> -->
                        <!--                          <a type="button" data-bs-toggle="modal" data-bs-target="#relationshipsModal" data-bs-original-title="" title="Add Relationships"  class="btn btn-link text-success pull-right">-->
                        <!--                            <i class="fa fa-plus-circle text-info"></i>-->
                        <!--                          </a>-->
                      </div>
                      <div class="p-15" :class="(isShown=='r') ? 'collapse show': 'collapse' ">
                        <p>
                          <button class="btn btn-primary btn-xs float-end" @click="copyAddressInfoFromCx">Copy from
                            customer
                          </button>
                          <button class="btn btn-primary btn-xs float-end mr-1" @click="editJobsiteInfo(customer)">
                            <span v-if="jobsiteData.jobAddress.length > 0">Edit</span>
                            <span v-else>Add</span>
                          </button>
                        </p>
                        <br>
                        <!--                          <div v-for="(r, i) in relationships" :key="i" class="mb-2">-->
                        <!--                            <div class="mb-2" @mouseover="r.editRelation = true" @mouseleave="r.editRelation = false">-->
                        <!--                              <span class="badge badge-secondary relation-badge">{{ r.relation.relationship.charAt(0) }}</span> <b>{{ r.relation.relationship }}</b>-->
                        <!--                              <a v-show="r.editRelation" href="#" class="pull-right"><i class="icofont icofont-pencil-alt-5 text-warning"></i></a>-->
                        <!--                            </div>-->
                        <!--                            -->
                        <!--                            <div v-for="(p, pi) in r.phone_numbers" :key="pi" class="text-info" @mouseover="p.editPhone = true" @mouseleave="p.editPhone = false">-->
                        <!--                              <i class="fa fa-phone text-muted me-1"></i> {{ p.phone_number}} <small v-if="p.label!=''" class="text-muted">({{ p.label }})</small>-->
                        <!--                              <a v-show="p.editPhone" @click="relation_phone_numbers=r.phone_numbers; relation.id=r.relation.id" data-bs-toggle="modal" data-bs-target="#phoneModal" class="pull-right"><i class="fa fa-plus-circle text-info fs-6"></i></a>-->
                        <!--                              <a v-show="p.editPhone" @click="relation_phone_numbers=r.phone_numbers; relation.id=r.relation.id" data-bs-toggle="modal" data-bs-target="#phoneModal" class="pull-right me-1"><i class="icofont icofont-pencil-alt-5 text-warning"></i></a>-->
                        <!--                            </div>-->

                        <!--                            <div v-for="(e, ei) in r.emails" :key="ei" class="text-info" @mouseover="e.editEmail = true" @mouseleave="e.editEmail = false">-->
                        <!--                              <i class="fa fa-envelope text-muted me-1"></i> {{ e.email }} -->
                        <!--                              <a v-show="e.editEmail" @click="relation_emails=r.emails; relation.id=r.relation.id" data-bs-toggle="modal" data-bs-target="#emailModal" type="button" class="pull-right"><i class="fa fa-plus-circle text-info fs-6"></i></a>-->
                        <!--                              <a v-show="e.editEmail" @click="relation_emails=r.emails; relation.id=r.relation.id" data-bs-toggle="modal" data-bs-target="#emailModal" type="button" class="pull-right me-1"><i class="icofont icofont-pencil-alt-5 text-warning"></i></a>-->
                        <!--                            </div>-->

                        <!--                            <div class="text-info" @mouseover="r.editAddress = true" @mouseleave="r.editAddress = false">-->
                        <!--                              <i class="fa fa-home text-muted me-1"></i> Address -->
                        <!--                              <a v-show="r.editAddress" @click="relation.id=r.relation.id" data-bs-toggle="modal" data-bs-target="#addressModal" type="button" class="pull-right"><i class="fa fa-plus-circle text-info fs-6"></i></a>-->
                        <!--                              <a v-show="r.editAddress" @click="relation.id=r.relation.id" data-bs-toggle="modal" data-bs-target="#addressModal" type="button" class="pull-right me-1"><i class="icofont icofont-pencil-alt-5 text-warning"></i></a>-->
                        <!--                            </div>-->

                        <!--                          </div>-->

                        <div class="mb-2">
                          <div class="ctitles">Jobsite Address:
                            <span class="cvalues" id="copied-jobsite">{{ jobsiteData.jobAddress }}</span>
                          </div>
                        </div>

                        <div class="mb-2">
                          <div class="ctitles">City: <span class="cvalues">{{ jobsiteData.jobCity }}</span></div>
                        </div>

                        <div class="mb-2">
                          <div class="ctitles">Postal Code: <span class="cvalues">{{ jobsiteData.jobZipcode }}</span>
                          </div>
                        </div>

                        <div class="mb-2">
                          <div class="ctitles">State: <span class="cvalues">{{ jobsiteData.jobState }}</span></div>
                        </div>

                        <!--                          <div class="mb-3">-->
                        <!--                            <label class="form-label" for="exampleFormControlInput1">Jobsite Address</label>-->
                        <!--                            <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="Address...">-->
                        <!--                          </div>-->

                        <!--                          <div class="mb-3">-->
                        <!--                            <label class="form-label" for="exampleFormControlInput1">City</label>-->
                        <!--                            <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="City...">-->
                        <!--                          </div>-->

                        <!--                          <div class="mb-3">-->
                        <!--                            <label class="form-label" for="exampleFormControlInput1">Postal Code</label>-->
                        <!--                            <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="Postal Code...">-->
                        <!--                          </div>-->

                        <!--                          <div class="mb-3">-->
                        <!--                            <label class="form-label" for="exampleFormControlInput1">State</label>-->
                        <!--                            <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="State...">-->
                        <!--                          </div>-->

                        <!--                          <div class="mb-3 row">-->
                        <!--                            <label class="col-sm-3 col-form-label">Jobsite Address</label>-->
                        <!--                            <div class="col-sm-9">-->
                        <!--                              <input class="form-control" type="text">-->
                        <!--                            </div>-->
                        <!--                          </div>-->

                        <!--                          <div class="mb-3 row">-->
                        <!--                            <label class="col-sm-3 col-form-label">City</label>-->
                        <!--                            <div class="col-sm-9">-->
                        <!--                              <input class="form-control" type="text">-->
                        <!--                            </div>-->
                        <!--                          </div>-->

                        <!--                          <div class="mb-3 row">-->
                        <!--                            <label class="col-sm-3 col-form-label">Zip Code</label>-->
                        <!--                            <div class="col-sm-9">-->
                        <!--                              <input class="form-control" type="text">-->
                        <!--                            </div>-->
                        <!--                          </div>-->

                        <!--                          <div class="mb-3 row">-->
                        <!--                            <label class="col-sm-3 col-form-label">State</label>-->
                        <!--                            <div class="col-sm-9">-->
                        <!--                              <input class="form-control" type="text">-->
                        <!--                            </div>-->
                        <!--                          </div>-->

                      </div>
                    </div>

                    <!-- DETAILS -->
                    <div class="card" style="border:none;border-bottom:1px solid #ddd;">
                      <div @click="toggleContact('d')" class="card-header mb-0 card-headers"
                           :aria-expanded="(isShown=='d') ? true : false">
                        <i class="fa fa-bars text-info"></i> To Do
                      </div>
                      <div class="p-15" :class="(isShown=='d') ? 'collapse show': 'collapse' ">
                        <!--                          <Todo></Todo>-->
                        <!--                          <button class="btn btn-primary btn-xs pull-right">Add</button>-->
                        <!--                          <div class="mb-2">-->
                        <!--                            <div class="ctitles">Stage: <span class="cvalues">Lead</span></div>-->
                        <!--                          </div>-->
                        <!--                          <div class="mb-2">-->
                        <!--                            <div class="ctitles">Agent: <span class="cvalues">Dev Team</span></div>-->
                        <!--                          </div>-->
                      </div>
                    </div>

                    <!-- RECENT CONVO -->
                    <div class="card" style="border:none;border-bottom:1px solid #ddd;">
                      <div @click="toggleContact('c')" class="card-header mb-0 card-headers"
                           :aria-expanded="(isShown=='c') ? true : false">
                        <i class="fa fa-comments text-warning"></i> Sales
                      </div>
                      <div class="p-15" :class="(isShown=='c') ? 'collapse show': 'collapse' ">
                        <div class="mb-2">
                          <div class="ctitles">No Conversations</div>
                        </div>
                      </div>
                    </div>

                    <!-- ACTIVITY -->
                    <div class="card" style="border:none;border-bottom:1px solid #ddd;">
                      <div @click="toggleContact('a')" class="card-header mb-0 card-headers"
                           :aria-expanded="(isShown=='a') ? true : false">
                        <i class="fa fa-calendar text-danger"></i> Appointment Date
                      </div>
                      <div class="p-15 flex justify-content-center"
                           :class="(isShown=='a') ? 'collapse show': 'collapse' ">
                        <!--                          <div id="custom-datepicker-inbox"></div>-->
                        <!--                        <div class="p-15 flex justify-content-center show">-->
                        <!--                          <div class="mb-2">-->
                        <!--                            <div class="ctitles">-->
                        <!--                          <input @change="openScheduleModal" class="form-control digits" type="date">-->
                        <!--                              <div class="digits" id="custom-datepicker-inbox" style="z-index: 99999; position: fixed"></div>-->
                        <!--                              <datepicker :inline="true"></datepicker>-->
                        <!--                            </div>-->
                        <div id="flatpicker" v-if="showMiniCalendar">
                          <flat-pickr @change="openCalendar" :config="config"/>
                        </div>
                        <div v-if="showSchedCalendar == true">
                          <div id="mini-calendar"></div>
                        </div>
                        <!--                              <div class="datepicker-here" id="custom-datepicker-inbox" style="z-index: 9999999"></div>-->
                        <!--                            </div>-->
                        <!--                          <CustomDatepicker></CustomDatepicker>-->
                      </div>
                    </div>


                    <div class="card" style="border:none;border-bottom:1px solid #ddd;">
                      <div @click="toggleContact('qk')" class="card-header mb-0 card-headers"
                           :aria-expanded="(isShown=='qk') ? true : false">
                        <i class="fa fa-floppy-o"></i> Media, Files and Links
                      </div>
                      <div class="p-15 pt-0" :class="(isShown=='qk') ? 'collapse show': 'collapse' ">
                        <!--                        <div class="flex">-->
                        <!--                          <div class="ctitles mr-2">Media</div>-->
                        <!--                          <div class="ctitles mr-2">Files</div>-->
                        <!--                          <div class="ctitles mr-2">Link</div>-->
                        <!--                        </div>-->
                        <ul class="nav nav-tabs border-tab nav-fill" id="top-tab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home"
                               role="tab" aria-controls="top-home" aria-selected="true">
                              <small>Media</small>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab"
                               aria-controls="top-profile" aria-selected="false">
                              <small>Files</small>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab"
                               aria-controls="top-contact" aria-selected="false">
                              <small>Links</small>
                            </a>
                          </li>
                        </ul>
                        <div class="tab-content" id="top-tabContent">
                          <div class="tab-pane fade show active" id="top-home" role="tabpanel"
                               aria-labelledby="top-home-tab">
                            <div class="gallery my-gallery card-body p-1 mb-0 row" itemscope="">
                            </div>
                          </div>
                          <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                            <p>2</p>
                          </div>
                          <div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
                            <p>3</p>
                          </div>
                        </div>
                      </div>
                    </div>

                  </TransitionGroup>

                </div>

              </div>
              <!-- Chat left side Ends-->
            </div>
          </div>
        </div>
      </div>

      <!-- NEW CONTACT -->
      <!-- <div v-if="newContact" class="col call-chat-sidebar"> -->
      <div v-if="newContact" class="col-md-2" style="margin-left: 0px;padding-left: 0px; width: 19.16667% !important;">
        <div class="card h-100" style="overflow-y:auto;">
          <div class="card-body chat-body">
            <!--            <a href="javascript:void(0)" @click="newContact=false">-->
            <!--              <i class="icofont icofont-error close-card font-primary pull-right"></i></a>-->
            <div class="chat-box pt-6">
              <!-- Chat left side Start-->
              <div class="chat-left-aside custom-scrollbar">
                <h5>Add Person</h5>
                <br>
                <input v-model="contact.first_name" type="text" class="form-control mb-2" placeholder="First Name">
                <input v-model="contact.last_name" type="text" class="form-control mb-2" placeholder="Last Name">
                <input v-model="contact.display_name" type="text" class="form-control mb-2"
                       placeholder="First and Last Name">
                <!--                <input v-model="contact.email" type="email" class="form-control mb-2" placeholder="Email">-->
                <!--                <input v-model="contact.company" type="email" class="form-control mb-2" placeholder="Company">-->
                <!--&lt;!&ndash;                <input v-model="contact.last_name" type="text" class="form-control mb-2" placeholder="Address">&ndash;&gt;-->
                <!--                <vue-google-autocomplete-->
                <!--                    id="street_address_new_person"-->
                <!--                    name="street_address_new_person"-->
                <!--                    classname="form-control mb-2"-->
                <!--                    placeholder="Street Address"-->
                <!--                    @input="newPersonAddress"-->
                <!--                    v-on:placechanged="getAddressDataForAddPerson"-->
                <!--                    :country="['us']"-->
                <!--                    :type="['address']">-->
                <!--                </vue-google-autocomplete>-->
                <!--                <input v-model="contact.city" type="text" class="form-control mb-2" placeholder="City">-->
                <!--                <input v-model="contact.zipcode" type="text" class="form-control mb-2" placeholder="Zip Code">-->
                <!--                <input v-model="contact.state" type="text" class="form-control mb-2" placeholder="State">-->
                <button @click="addCustomer" type="button" class="btn btn-success mt-2">Add Person</button>
                <hr>
              </div>
              <!-- Chat left side Ends-->
            </div>
          </div>
        </div>
      </div>


    </div>

    <!-- ======================================= -->
    <!-- MODALS STARTS HERE -->
    <!-- ======================================= -->

    <!-- ADDRESS MODAL -->
    <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter"
         aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-users"></i> Edit Addresses</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="font-size:12px;">
            <div class="row">
              <div class="col-md-12 p-10">
                <table class="table">
                  <tbody>
                  <template v-for="(a, ai) in relation_addresses" :key="ai">
                    <tr>
                      <td colspan="3" class="text-left">Address {{ ai + 1 }}</td>
                      <td class="text-right">
                        <a @click="removeAddress(a, ai, 'relationship')" href="javascript:void(0)" class="btn btn-xs"
                           :disabled="relation_addresses.length==1">
                          <i class="fa fa-trash fs-7"
                             :class="(relation_addresses.length==1) ? 'text-secondary' : 'text-danger'"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3"><input v-model="a.street" class="form-control" type="text"
                                             placeholder="Street Address"/></td>
                      <td><input v-model="a.label" class="form-control" type="text" placeholder="Label e.g. home"/></td>
                    </tr>
                    <tr>
                      <td><input v-model="a.city" class="form-control" type="text" placeholder="City"/></td>
                      <td><input v-model="a.state" class="form-control" type="text" placeholder="State"/></td>
                      <td><input v-model="a.zip" class="form-control" type="text" placeholder="Zip code"/></td>
                      <td>
                        <select v-model="a.country" class="form-control">
                          <option value="">Select Country</option>
                        </select>
                      </td>
                    </tr>
                  </template>
                  </tbody>
                </table>
                <div class="p-10">
                  <a @click="addContactAddress('relationship')" type="button" title="Add Phone"
                     class="btn btn-link text-success p-1">
                    <i class="fa fa-plus-circle"></i> Add another address
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
            <button @click="saveRelationship('address_only')" class="btn btn-primary" type="button">Save</button>
          </div>
        </div>
      </div>
    </div>

    <!-- PHONE MODAL -->
    <div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter"
         aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-users"></i> Edit Phone Numbers</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="font-size:12px;">
            <div class="row">
              <div class="col-md-12">
                <div class="card p-10">
                  <table>
                    <tr>
                      <td>Phone Number</td>
                      <td>Label</td>
                      <td class="text-center">Bad Number</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tbody>
                    <tr v-for="(p, pi) in relation_phone_numbers" :key="pi">
                      <td><input v-model="p.phone_number" class="form-control" type="text" placeholder="555-555-5555"/>
                      </td>
                      <td><input v-model="p.label" class="form-control" type="text" placeholder="Label e.g. Home"/></td>
                      <td class="text-center">
                        <div class="checkbox checkbox-primary mb-3">
                          <input v-model="p.is_bad_number" :id="'checkbox-primary-'+pi" type="checkbox"
                                 :checked="p.is_bad_number">
                          <label :for="'checkbox-primary-'+pi"></label>
                        </div>
                      </td>
                      <td class="text-center">
                        <a @click="removeContactPhone(p, pi, 'relationship')" href="javascript:void(0)"
                           class="btn btn-xs" :disabled="relation_phone_numbers.length==1">
                          <i class="fa fa-remove fs-6"
                             :class="(relation_phone_numbers.length==1) ? 'text-secondary' : 'text-danger'"></i>
                        </a>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                  <div>
                    <a @click="addContactPhone('relationship')" type="button" title="Add Phone"
                       class="btn btn-link text-success p-1">
                      <i class="fa fa-plus-circle"></i> Add another phone
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
            <button @click="saveRelationship('phone_only')" class="btn btn-primary" type="button">Save</button>
          </div>
        </div>
      </div>
    </div>

    <!-- EMAIL MODAL -->
    <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter"
         aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-users"></i> Edit Emails</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="font-size:12px;">
            <div class="row">
              <div class="col-md-12">
                <div class="card p-10">
                  Email
                  <table>
                    <tbody>
                    <tr v-for="(e, ei) in relation_emails" :key="ei">
                      <td><input v-model="e.email" class="form-control" type="email" placeholder="example@email.com"/>
                      </td>
                      <td class="text-center">
                        <a @click="removeContactEmail(e, ei, 'relationship')" href="javascript:void(0)"
                           class="btn btn-xs" :disabled="relation_emails.length==1">
                          <i class="fa fa-remove fs-6"
                             :class="(relation_emails.length==1) ? 'text-secondary' : 'text-danger'"></i></a>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                  <div>
                    <a @click="addContactEmail('relationship')" type="button" title="Add Phone"
                       class="btn btn-link text-success p-1">
                      <i class="fa fa-plus-circle"></i> Add another email
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
            <button @click="saveRelationship('emails_only')" class="btn btn-primary" type="button">Save</button>
          </div>
        </div>
      </div>
    </div>

    <!-- CONTACT INFO MODAL -->
    <div class="modal fade" id="contactInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter"
         aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-phone"></i> Add/Edit Contact Information</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="font-size:12px;">

            <!-- PHONE NUMBERS -->
            <div class="row">
              <div class="col-md-12">
                <div class="card p-10">
                  <table>
                    <tr>
                      <td>Phone Number</td>
                      <td>Label</td>
                      <td class="text-center">Bad Number</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tbody>
                    <tr v-for="(p, pi) in contact_phone_numbers" :key="pi">
                      <td><input v-model="p.phone_number" class="form-control" type="text" placeholder="555-555-5555"/>
                      </td>
                      <td><input v-model="p.label" class="form-control" type="text" placeholder="Label e.g. Home"/></td>
                      <td class="text-center">
                        <div class="checkbox checkbox-primary mb-3">
                          <input v-model="p.is_bad_number" :id="'checkbox-primary-'+pi" type="checkbox"
                                 :checked="p.is_bad_number">
                          <!-- <input v-model="p.is_bad_number" :id="'checkbox-primary-'+pi" type="checkbox" :checked="(p.is_bad_number=='1' || p.is_bad_number) ? true : false"> -->
                          <label :for="'checkbox-primary-'+pi"></label>
                        </div>
                      </td>
                      <td class="text-center">
                        <a @click="removeContactPhone(p, pi, 'contact')" href="javascript:void(0)" class="btn btn-xs"
                           :disabled="contact_phone_numbers.length==1">
                          <i class="fa fa-remove fs-6"
                             :class="(contact_phone_numbers.length==1) ? 'text-secondary' : 'text-danger'"></i>
                        </a>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                  <div>
                    <a @click="addContactPhone('contact')" type="button" title="Add Phone"
                       class="btn btn-link text-success p-1">
                      <i class="fa fa-plus-circle"></i> Add another phone
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <!-- EMAILS -->
            <div class="row">
              <div class="col-md-12">
                <div class="card p-10">
                  Email
                  <table>
                    <tbody>
                    <tr v-for="(e, ei) in contact_emails" :key="ei">
                      <td><input v-model="e.email" class="form-control" type="email" placeholder="example@email.com"/>
                      </td>
                      <td class="text-center">
                        <a @click="removeContactEmail(e, ei, 'contact')" href="javascript:void(0)" class="btn btn-xs"
                           :disabled="contact_emails.length==1">
                          <i class="fa fa-remove fs-6"
                             :class="(contact_emails.length==1) ? 'text-secondary' : 'text-danger'"></i></a>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                  <div>
                    <a @click="addContactEmail('contact')" type="button" title="Add Phone"
                       class="btn btn-link text-success p-1">
                      <i class="fa fa-plus-circle"></i> Add another email
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
            <button @click="saveContactInfo" class="btn btn-primary" type="button">Save Contact Information</button>
          </div>
        </div>
      </div>
    </div>

    <!-- RELATIONSHIP MODAL -->
    <div class="modal fade" id="relationshipsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter"
         aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-users"></i> Add/Edit Relationship</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="font-size:12px;">
            <div class="row">
              <div class="col">

                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-5">
                    <input v-model="relation.first_name" class="form-control" type="text" placeholder="First Name">
                  </div>
                  <div class="col-sm-5">
                    <input v-model="relation.last_name" class="form-control" type="text" placeholder="Last Name">
                  </div>
                </div>

                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Type</label>
                  <div class="col-sm-10">
                    <input v-model="relation.relationship" class="form-control" type="text"
                           placeholder="Type e.g. Spouse">
                  </div>
                </div>

              </div>
            </div>
            <!-- PHONE NUMBERS -->
            <div class="row">
              <div class="col-md-12">
                <div class="card p-10">
                  <table>
                    <tr>
                      <td>Phone Number</td>
                      <td>Label</td>
                      <td class="text-center">Bad Number</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tbody>
                    <tr v-for="(p, pi) in relation_phone_numbers" :key="pi">
                      <td><input v-model="p.phone_number" class="form-control" type="text" placeholder="555-555-5555"/>
                      </td>
                      <td><input v-model="p.label" class="form-control" type="text" placeholder="Label e.g. Home"/></td>
                      <td class="text-center">
                        <div class="checkbox checkbox-primary mb-3">
                          <input v-model="p.is_bad_number" :id="'checkbox-primary-'+pi" type="checkbox"
                                 :checked="p.is_bad_number">
                          <label :for="'checkbox-primary-'+pi"></label>
                        </div>
                      </td>
                      <td class="text-center">
                        <a @click="removeContactPhone(p, pi, 'relationship')" href="javascript:void(0)"
                           class="btn btn-xs" :disabled="relation_phone_numbers.length==1">
                          <i class="fa fa-remove fs-6"
                             :class="(relation_phone_numbers.length==1) ? 'text-secondary' : 'text-danger'"></i>
                        </a>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                  <div>
                    <a @click="addContactPhone('relationship')" type="button" title="Add Phone"
                       class="btn btn-link text-success p-1">
                      <i class="fa fa-plus-circle"></i> Add another phone
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <!-- EMAILS -->
            <div class="row">
              <div class="col-md-12">
                <div class="card p-10">
                  Email
                  <table>
                    <tbody>
                    <tr v-for="(e, ei) in relation_emails" :key="ei">
                      <td><input v-model="e.email" class="form-control" type="email" placeholder="example@email.com"/>
                      </td>
                      <td class="text-center">
                        <a @click="removeContactEmail(e, ei, 'relationship')" href="javascript:void(0)"
                           class="btn btn-xs" :disabled="relation_emails.length==1">
                          <i class="fa fa-remove fs-6"
                             :class="(relation_emails.length==1) ? 'text-secondary' : 'text-danger'"></i></a>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                  <div>
                    <a @click="addContactEmail('relationship')" type="button" title="Add Phone"
                       class="btn btn-link text-success p-1">
                      <i class="fa fa-plus-circle"></i> Add another email
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
            <button @click="saveRelationship('relationships')" class="btn btn-primary" type="button">Save Relationship
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- <pre id="content" style="white-space: pre-wrap;"></pre> -->

    <div class="modal fade" id="sendLaterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Schedule send
              <div style="font-size: 13px;color: #777;">{{ countryStdTime }}</div>
            </h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table id="laterTable" class="table table-hover" style="font-size: 12px;cursor: pointer;">
              <tr @click="sendLater('tomorrow')">
                <td>Tomorrow morning</td>
                <td class="text-right">{{ tomorrowAM }}, 8:00AM</td>
              </tr>
              <tr @click="sendLater('tomOrTodayPM')">
                <td>{{ tomOrTodayTxt }}</td>
                <td class="text-right">{{ tomOrTodayDate }}, 1:00PM</td>
              </tr>
              <tr @click="sendLater('nextMonday')">
                <td>Monday morning</td>
                <td class="text-right">{{ nextMonday }}, 8:00AM</td>
              </tr>
            </table>
          </div>
          <div class="p-10" style="border-top: 1px solid #dee2e6;">
            <a class="btn btn-block" type="button" data-bs-toggle="modal" data-original-title="test"
               data-bs-target="#pickDateTime" data-bs-original-title=""
               style="margin-left: 0px !important;padding-left: 15px !important;font-weight: 400;">
              <i class="icofont icofont-ui-calendar"></i>
              Pick date & time
            </a>
          </div>
        </div>
      </div>
    </div>

    <!--  <div class="text-center mt-0 mb-10">-->
    <!--    <Link href="/privacy-policy">-->
    <!--      <span class="text-muted">-->
    <!--        Privacy Policy-->
    <!--      </span>-->
    <!--    </Link>-->
    <!--    &nbsp;|&nbsp;-->
    <!--    <Link href="/terms-of-service">-->
    <!--      <span class="text-muted">-->
    <!--        Terms of Service-->
    <!--      </span>-->
    <!--    </Link>-->
    <!--  </div>-->

    <div class="modal fade" id="pickDateTime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Pick date & time
            </h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-8">
                <datepicker v-model="todaysDate" :inline="true"></datepicker>
              </div>
              <div class="col-md-4">
                <div class="mb-5 mt-10" style="border-bottom:1px solid #ccc">
                  {{ todaysDate.toLocaleDateString("en-US", {month: 'short', day: 'numeric', year: 'numeric'}) }}
                </div>
                <div class="mb-5 mt-10" style="border-bottom:1px solid #ccc">
                  <input type="time" class="form-control" id="todaysTime" v-model="todaysTime"
                         style="border: none;padding-left: 0px;color: #333;">
                </div>
              </div>
            </div>

          </div>
          <div class="p-10 text-right" style="border-top: 1px solid #dee2e6;">
            <button class="btn btn-default" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>&nbsp;
            <button class="btn btn-primary" @click="sendLater('picker')">Schedule send</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="add-appointment-from-inbox" tabindex="-1" role="dialog"
         aria-labelledby="add-appointment" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title d-flex justify-content-start text-center">
              <h5 class="text-muted">Schedule Appointment</h5>
            </div>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form @submit.prevent="" method="POST">
            <div class="modal-body pt-4 pb-4">
              <div class="row">
                <div class="col">
                  <div class="row g-3" id="body-content">
                    <div class="col-md-1 mt-0"></div>
                    <div class="col-md-4 mt-0">
                      <input @change="" class="checkbox_animated mt-3" id="bindJob" type="checkbox">
                      <span class="text-muted">Job</span>
                    </div>
                    <div class="col-md-4 mt-0">
                      <input @change="" class="checkbox_animated mt-3" id="bindLead" type="checkbox">
                      <span class="text-muted">Lead</span>
                    </div>
                    <div class="col-md-3 mt-0">
                      <input @change="" class="checkbox_animated mt-3" id="unbindLead" type="checkbox">
                      <span class="text-muted">Non-Work</span>
                    </div>
                    <div v-show="" class="col-md-1 text-center">
                      <i class="fa fa-search fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                    </div>
                    <div v-show="" class="col-md-11">
                      <select class="form-control" name="" id=""></select>
                      <!--                    <VueMultiselect-->
                      <!--                        id="select-lead"-->
                      <!--                        placeholder="Select a lead..."-->
                      <!--                        label="opportunity_title"-->
                      <!--                        track-by="lead_id"-->
                      <!--                        :searchable="true"-->
                      <!--                        :close-on-select="true"-->
                      <!--                        v-model="formData.lead"-->
                      <!--                        @select="getLeadId"-->
                      <!--                        :options="leadOptions">-->
                      <!--                    </VueMultiselect>-->
                    </div>

                    <div v-show="" class="col-md-1 text-center">
                      <i class="fa fa-search fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                    </div>
                    <div v-show="" class="col-md-11">
                      <select class="form-control" name="" id=""></select>
                      <!--                    <VueMultiselect-->
                      <!--                        id="select-job"-->
                      <!--                        placeholder="Select a job..."-->
                      <!--                        label="jobsite_name"-->
                      <!--                        track-by="lead_id"-->
                      <!--                        :searchable="true"-->
                      <!--                        :close-on-select="true"-->
                      <!--                        :ref="jobsiteName"-->
                      <!--                        v-model="formData.jobsite"-->
                      <!--                        @select=""-->
                      <!--                        :options="jobsiteOptions">-->
                      <!--                    </VueMultiselect>-->
                    </div>

                    <div class="col-md-1 text-center">
                      <i class="fa fa-pencil-square-o fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                    </div>
                    <div class="col-md-11">
                      <input id="title" type="text" class="form-control" placeholder="Title" name="appointment-title">
                    </div>
                    <div class="col-md-1 text-center">
                      <i class="fa fa-clock-o fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                    </div>
                    <div class="col-md-11">
                      <input class="form-control digits" data-language="en" id="meetingDate" type="text"
                             placeholder="Meeting Date" name="appointment-start-day" readonly>
                    </div>
                    <div class="col-md-1 text-center">
                      <i class="fa fa-location-arrow fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                    </div>
                    <div class="col-md-11">
                      <input id="streetAddress" type="text" class="form-control" placeholder="Street Address"
                             name="appointment-location">
                      <!--                    <vue-google-autocomplete-->
                      <!--                        id="street_address_new_appointment"-->
                      <!--                        name="street_address_new_appointment"-->
                      <!--                        classname="form-control"-->
                      <!--                        placeholder="Street Address"-->
                      <!--                        @input="newAppointmentAddress"-->
                      <!--                        v-on:placechanged="getAddressDataForNewAppointment"-->
                      <!--                        :country="['us']"-->
                      <!--                        :type="['address']">-->
                      <!--                    </vue-google-autocomplete>-->
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                      <input id="city" type="text" class="form-control" placeholder="City">
                    </div>
                    <div class="col-md-4">
                      <input id="state" type="text" class="form-control" placeholder="State">
                    </div>
                    <div class="col-md-3">
                      <input id="zipcode" type="number" class="form-control" placeholder="Zip Code">
                    </div>
                    <div class="col-md-1 text-center">
                      <i class="fa fa-user fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                    </div>
                    <div class="col-md-11">
                      <select class="form-control" name="" id=""></select>
                      <!--                    <VueMultiselect-->
                      <!--                        placeholder="Select a user..."-->
                      <!--                        label="display_name"-->
                      <!--                        track-by="user_id"-->
                      <!--                        id="assignedToUser"-->
                      <!--                        :searchable="true"-->
                      <!--                        :close-on-select="true"-->
                      <!--                        v-model="formData.assignedToUser"-->
                      <!--                        @select="getAssignedToId"-->
                      <!--                        :options="userOptions">-->
                      <!--                    </VueMultiselect>-->
                    </div>
                    <div class="col-md-1 text-center">
                      <i class="fa fa-users fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                    </div>
                    <div class="col-md-11">
                      <select class="form-control" name="" id="appointment_guests" multiple="multiple"
                              title="Include email addresses, separated by commas(,) to send to your guests that are outside your platform."></select>
                    </div>
                    <div class="col-md-1 text-center">
                      <i class="fa fa-clipboard fa-lg" style="opacity: 0.5; margin-top: 5px"></i>
                    </div>
                    <div class="col-md-11">
                      <textarea class="form-control" name="appointment-note" id="description" rows="5"
                                placeholder="Description"></textarea>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <div class="col-md-12">
                    <div class="card mb-3 rounded-2">
                      <div class="card-body justify-content-between align-middle d-flex">
                        <p class="btn btn-secondary btn-xs mt-1" data-bs-toggle="modal" data-original-title="test"
                           data-bs-target="#email-and-sms-preview">Preview</p>
                        <p class="btn btn-secondary btn-xs mt-1" data-bs-toggle="modal" data-original-title="test"
                           data-bs-target="#edit-sms-email">Edit</p>
                        <p class="btn btn-danger btn-xs mt-1" style="cursor: context-menu">SMS</p>
                        <div class="media">
                          <div class="media-body text-end icon-state switch-outline">
                            <label class="switch">
                              <input type="checkbox" checked="">
                              <span class="switch-state"></span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="card mb-3 rounded-2">
                      <div class="card-body justify-content-between d-flex">
                        <p class="btn btn-secondary btn-xs mt-1" data-bs-toggle="modal" data-original-title="test"
                           data-bs-target="#email-and-sms-preview">Preview</p>
                        <p class="btn btn-secondary btn-xs mt-1" data-bs-toggle="modal" data-original-title="test"
                           data-bs-target="#edit-sms-email">Edit</p>
                        <p class="btn btn-danger btn-xs mt-1" style="cursor: context-menu">Email</p>
                        <div class="media">
                          <div class="media-body text-end icon-state switch-outline">
                            <label class="switch">
                              <input type="checkbox" checked="">
                              <span class="switch-state"></span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <label for="custom-file-upload" class="w-100" id="file-upload-label" style="display: inline">
                    <div class="card mb-0 custom-dropzone rounded" id="custom-dropzone">
                      <div class="card-body">
                        <input type="file" id="custom-file-upload" hidden multiple="multiple" @change="">
                        <img id="upload-image" alt="" style="display: block; margin-left: auto; margin-right: auto">
                      </div>
                    </div>
                  </label>
                  <div id="image-container">
                  </div>
                  <button class="btn btn-primary w-100 mt-5">Create</button>
                </div>

              </div>
            </div>
            <!--          <div class="modal-footer">-->
            <!--            <button class="btn btn-primary w-100">Create</button>-->
            <!--          </div>-->
          </form>
        </div>
      </div>
    </div>

    <!--Edit customer info-->
    <div class="modal fade" id="edit-customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
      <div class="modal-dialog modal-lg zoomIn" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Customer's Information</h5>
            <div class="flex justify-content-between align-middle">
              <div class="block mr-10 mt-2">
                <button class="btn btn-primary btn-xs">Select Contact</button>
              </div>
              <div class="block">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row g-3 needs-validation" novalidate="">
              <div class="col-md-4 position-relative">
                <label class="form-label" for="validationTooltip01">First name</label>
                <input v-model="editCustomerData.cusName" class="form-control" id="validationTooltip01" type="text"
                       required="">
              </div>
              <div class="col-md-4 position-relative">
                <label class="form-label" for="validationTooltip02">Last name</label>
                <input v-model="editCustomerData.cusLastName" class="form-control" id="validationTooltip02" type="text"
                       required="">
              </div>
              <div class="col-md-4 position-relative">
                <label class="form-label" for="validationTooltipUsername">Display Name</label>
                <div class="input-group has-validation">
                  <input v-model="editCustomerData.cusDisplayName" class="form-control" id="validationTooltipUsername"
                         type="text" aria-describedby="validationTooltipUsernamePrepend" required="">
                </div>
              </div>
              <div class="col-md-6 position-relative">
                <label class="form-label" for="validationTooltip03">Email</label>
                <input v-model="editCustomerData.cusEmail" class="form-control" id="validationTooltip03" type="text"
                       required="">
              </div>
              <div class="col-md-6 position-relative">
                <label class="form-label" for="street_address_customer">Address</label>
                <!--              <input v-model="editCustomerData.cusAddress" class="form-control" id="validationTooltip03" type="text" required="">-->
                <!--              <vue-google-autocomplete v-if="isShown=='ci'"-->
                <!--                  id="street_address_customer"-->
                <!--                  name="street_address_customer"-->
                <!--                  classname="form-control"-->
                <!--                  placeholder="Street Address"-->
                <!--                  @input="newCustomerAddress"-->
                <!--                  v-on:placechanged="getAddressDataForNewCustomer"-->
                <!--                  :country="['us']"-->
                <!--                  :type="['address']">-->
                <!--              </vue-google-autocomplete>-->
              </div>
              <div class="col-md-4 position-relative">
                <label class="form-label" for="validationTooltip03">City</label>
                <input v-model="editCustomerData.cusCity" class="form-control" id="validationTooltip03" type="text"
                       required="">
              </div>
              <div class="col-md-4 position-relative">
                <label class="form-label" for="validationTooltip04">State</label>
                <input v-model="editCustomerData.cusState" class="form-control" id="validationTooltip03" type="text"
                       required="">
              </div>
              <div class="col-md-4 position-relative">
                <label class="form-label" for="validationTooltip05">Zip</label>
                <input v-model="editCustomerData.cusZip" class="form-control" id="validationTooltip05" type="text"
                       required="">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-secondary" type="button" @click="saveEditedCustomerInfo">Save</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="edit-jobsite" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
      <div class="modal-dialog modal-lg zoomIn" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              <span v-if="jobsiteData.jobAddress.length > 0">Edit Address</span>
              <span v-else>Add Address</span>
            </h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="needs-validation" novalidate="">
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label" for="validationCustom01">Jobsite Address</label>
                  <!--                <input class="form-control" id="validationCustom01" type="text" placeholder="Jobsite Address..." required="">-->
                  <!--                <vue-google-autocomplete-->
                  <!--                    id="street_address_jobsite"-->
                  <!--                    name="street_address_jobsite"-->
                  <!--                    classname="form-control"-->
                  <!--                    placeholder="Street Address..."-->
                  <!--                    @input="newJobsiteAddress"-->
                  <!--                    v-on:placechanged="getAddressDataForJobsite"-->
                  <!--                    :country="['us']"-->
                  <!--                    :type="['address']">-->
                  <!--                </vue-google-autocomplete>-->
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="validationCustom02">City</label>
                  <input v-model="editJobsite.jCity" class="form-control" id="validationCustom02" type="text"
                         placeholder="City..." required="">
                </div>
              </div>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label" for="validationCustom03">Postal</label>
                  <input v-model="editJobsite.jZipcode" class="form-control" id="validationCustom03" type="text"
                         placeholder="Postal..." required="">
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="validationCustom04">State</label>
                  <input v-model="editJobsite.jState" class="form-control" type="text" placeholder="State...">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-secondary" type="button">Save</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Settings Modal -->
    <div class="modal fade" id="settings-inbox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
      <div class="modal-dialog zoomIn modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="card rounded">
            <div class="card-header pb-0">
              <h5>Manage Inboxes</h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="display table table-striped table-bordered">
                  <thead>
                  <th width="50%">Name</th>
                  <th width="25%">Status</th>
                  <th width="25%">Action</th>
                  </thead>
                  <tbody>
                  <!--              <tr v-for="s in settings" :key="s.id">-->
                  <!--                <td>-->
                  <!--                  Connect {{ s.name }}-->
                  <!--                </td>-->
                  <!--                <td :class="(s.status==1) ? 'text-success' : 'text-secondary'">{{ (s.status==1) ? 'Connected' : 'Not Connected' }}</td>-->
                  <!--                <td>-->
                  <!--                  <button type="button" v-if="s.status==0" @click="setStatus(s.id, 1)" class="btn btn-success btn-xs">Connect</button>-->
                  <!--                  <button type="button" v-else  @click="setStatus(s.id, 0)" class="btn btn-danger btn-xs">Disconnect</button>-->
                  <!--                </td>-->
                  <!--              </tr>-->
                  <tr>
                    <td>Connect Google Gmail</td>
                    <td class="text-success" v-if="settings.gmail">Connected</td>
                    <td class="text-secondary" v-if="!settings.gmail">Not Connected</td>
                    <td>
                      <a href="/inbox/settings/set-status" class="btn btn-success btn-xs" v-if="!settings.gmail">Connect</a>
                      <a href="/inbox/settings/disconnect-gmail" class="btn btn-danger btn-xs" v-if="settings.gmail">Disconnect</a>
                    </td>
                  </tr>
                  <tr>
                    <td>Connect Facebook Messenger</td>
                    <td class="text-success" v-if="settings.facebook">Connected</td>
                    <td class="text-secondary" v-if="!settings.facebook">Not Connected</td>
                    <td>
                      <a href="/inbox/settings/fb-login" class="btn btn-success btn-xs" v-if="!settings.facebook">Connect</a>
                      <a href="/inbox/settings/fb-handle-disconnect" class="btn btn-danger btn-xs" v-if="settings.facebook">Disconnect</a>
                    </td>
                  </tr>
                  <tr>
                    <td>Connect Instagram Messages</td>
                    <td class="text-success d-none">Connected</td>
                    <td class="text-secondary ">Not Connected</td>
                    <td>
                      <a class="btn btn-success btn-xs">Connect</a>
                      <a class="btn btn-danger btn-xs d-none">Disconnect</a>
                    </td>
                  </tr>
                  <tr>
                    <td>Connect Yelp Messenger</td>
                    <td class="text-success d-none">Connected</td>
                    <td class="text-secondary ">Not Connected</td>
                    <td>
                      <a href="/inbox/settings/yelp-login" class="btn btn-success btn-xs">Connect</a>
                      <a class="btn btn-danger btn-xs d-none">Disconnect</a>
                    </td>
                  </tr>
                  <tr>
                    <td>Connect Text Messages</td>
                    <td class="text-success d-none">Connected</td>
                    <td class="text-secondary">Not Connected</td>
                    <td>
                      <a class="btn btn-success btn-xs">Connect</a>
                      <a class="btn btn-danger btn-xs d-none">Disconnect</a>
                    </td>
                  </tr>
                  <tr>
                    <td>Connect Website Live Chat</td>
                    <td class="text-success d-none">Connected</td>
                    <td class="text-secondary">Not Connected</td>
                    <td>
                      <a class="btn btn-success btn-xs">Connect</a>
                      <a class="btn btn-danger btn-xs d-none">Disconnect</a>
                    </td>
                  </tr>
                  <tr>
                    <td>Connect WhatsApp Messenger</td>
                    <td class="text-success d-none">Connected</td>
                    <td class="text-secondary">Not Connected</td>
                    <td>
                      <a class="btn btn-success btn-xs ">Connect</a>
                      <a class="btn btn-danger btn-xs d-none">Disconnect</a>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="howItWorksModal" tabindex="-1" role="dialog" aria-labelledby="howItWorksModal"
         aria-hidden="true">
      <div class="modal-dialog zoomIn modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="icofont icofont-ui-user-group"></i> How It Works</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row text-center">
              <i class="icofont icofont-brand-youtube text-danger"
                 style="font-size: 100px;margin-top: 40px;margin-bottom: 50px;"></i>
              <!-- <iframe src=""></iframe> -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="numberModal" tabindex="-1" role="dialog" aria-labelledby="numberModal"
         aria-hidden="true">
      <div class="modal-dialog zoomIn modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Number</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <!-- <form action="" method="POST"> -->
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-2">
                  <span class="input-group-text text-muted">Number:</span>
                  <input v-model="phone_number" class="form-control" type="text" placeholder="number...">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-secondary">Save changes</button>
          </div>
          <!-- </form> -->
        </div>
      </div>
    </div>


  </div>
  <!-- Container-fluid Ends-->

</template>

<script setup>
// import VueFeather from 'vue-feather';
// import DatePicker from '@/components/DatePicker.vue';
// import {ref} from 'vue';
// import FlatPickr from 'vue-flatpickr-component';
// import VueGoogleAutocomplete from "vue-google-autocomplete";
// import {Link} from "@inertiajs/vue3";

// defineProps(['settings']);
// console.log(this.settings)


// const config = ref({
//   wrap: false,
//   altFormat: 'M j, Y',
//   altInput: false,
//   dateFormat: 'Y-m-d',
//   // defaultDate: new Date(),
//   inline: true
// });
import {usePage} from '@inertiajs/vue3';
import {useSideBar} from "../../stores/sidebar.js";
import {onMounted, onUnmounted} from "vue";

const store = useSideBar();
const page = usePage();

onMounted(() => {
    store.toggle()
})

onUnmounted(() => {
  store.toggle()
})
</script>

<script>
import {Link, router} from "@inertiajs/vue3";
import Swal from 'sweetalert2';
import {usePage} from '@inertiajs/vue3';
// import Echo from '@ably/laravel-echo';
// import * as Ably from 'ably';
import {QuillEditor} from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import axios from 'axios';
import FlatPickr from 'vue-flatpickr-component';
import VueGoogleAutocomplete from "vue-google-autocomplete";
import 'flatpickr/dist/flatpickr.css';
import CustomDatepicker from '@/components/PermanentlyVisible.vue';
import Todo from '@/pages/todo/Todo.vue';
import Datepicker from 'vue3-datepicker';
import {Calendar} from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';

import Message from '@/components/inbox/Message.vue';
import {Inertia} from "@inertiajs/inertia";
import {toast} from "vue3-toastify";

const page = usePage();

export default {
  // created() {
  //   this.gmailMessagesAndThreads()
  // },
  mounted() {
    this.gmailMessagesAndThreads()
    // this.facebookMessagesAndThreads()
    this.scrollToBottom();
    // console.log(this.getGmailLatestMessage().data)

    // setInterval(() => {
    //   this.refreshGmail();
    //   console.log('refresh gmail')
    // }, 10000);
  if (!this.settings.gmail){
    sessionStorage.removeItem('gmail_data')
    sessionStorage.removeItem('gmail_prevToken')
    sessionStorage.removeItem('gmail_nextToken')
    sessionStorage.removeItem('gmail_count')
    sessionStorage.removeItem('gmail_sizeEstimate')
    sessionStorage.removeItem('gmail_firstMessage')
  }

    // this.loadGmail();
    this.facebookThreads = this.facebook.from

    //
    if (page.props.auth.user) {
      this.userName = page.props.auth.user.name;
      this.userId = page.props.auth.user.user_id;
    }

    this.formatMessageList();

    this.activeNav = 'gmail'

  },
  props: ['status', 'settings', 'facebook'],
  components: {
    QuillEditor,
    FlatPickr,
    VueGoogleAutocomplete,
    // CustomDatepicker
    Datepicker,
    Todo
  },
  data() {

    const m = this.gmailFirstMessage;
    var emailTo = '';
    var emailFrom = '';
    var emailSubject = '';
    var headerSubject = '';
    var threadId = '';
    var messageId = '';
    var message = '';
    var messageDate = '';

    if (m) {
      emailTo = (m.replyto != '') ? m.replyto : m.from2;
      emailFrom = m.from;
      emailSubject = " RE - " + (m.subject != undefined) ? m.subject : '';
      headerSubject = m.subject;
      threadId = m.threadId;
      messageId = m.id;
      messageDate = m.date;
    }

    let todaysTime = new Date();
    todaysTime.toLocaleString('en-US', {hour: 'numeric', minute: 'numeric', hour12: true});

    let theDate = new Date();

    return {
      tabs: [],
      facebookThreadCount: 0,
      showGmailLoader: false,
      gmailCount: 0,
      gmailFirstMessage: null,
      gmailMessages: null,
      facebookThreads: null,
      facebookReplyLoader: false,
      facebookMessageLoader: false,
      facebookReplyMessage: null,
      facebookMessageHeader: null,
      facebookPSID: null,
      facebookUserId: null,
      facebookMessage: null,
      activeNav: null,
      showMiniCalendar: true,
      showSchedCalendar: false,
      config: {
        wrap: false,
        altFormat: 'M j, Y',
        altInput: false,
        dateFormat: 'Y-m-d',
        // defaultDate: new Date(),
        inline: true
      },
      editCustomerData: {
        cusId: '',
        cusName: '',
        cusLastName: '',
        cusDisplayName: '',
        cusEmail: '',
        cusAddress: '',
        cusCity: '',
        cusState: '',
        cusZip: ''
      },
      editing: false,
      editedText: '',
      m: m,
      activeIndex: -1,
      customer: [],
      currentConvoAvatar: '',
      currentConvoName: '',
      userId: null,
      userName: null,
      // message: null,
      throttleTyping: false,
      showContact: false,
      newContact: false,
      contact: {
        first_name: '',
        last_name: '',
        email: '',
        display_name: '',
        company: '',
        address: '',
        city: '',
        state: '',
        zipcode: ''
      },
      items: [],
      search: '',
      listLoading: false,
      listPrev: false,
      listNext: false,
      listOfMessages: '',
      prevToken: null,
      nextToken: null,
      resultSizeEstimate: null,
      pageTokens: [],
      threads: [],
      emailTo: emailTo,
      emailFrom: emailFrom,
      emailSubject: emailSubject,
      headerSubject: headerSubject,
      threadId: threadId,
      messageId: messageId,
      message: message,
      messageDate: messageDate,
      showMsgBox: true,
      showTo: false,
      countryStdTime: '',
      tomorrowAM: theDate,
      _tomorrowAM: '',
      tomOrTodayTxt: '',
      tomOrTodayDate: theDate,
      _tomOrTodayDate: '',
      nextMonday: '',
      _nextMonday: '',
      todaysDate: theDate,
      todaysTime: todaysTime,
      isActive: null,
      isShown: null,
      contact_phone_numbers: [
        {
          phone_number: '',
          label: '',
          is_bad_number: 0
        }
      ],
      contact_emails: [{email: ''}],
      relationships: [],
      relation: {
        id: 0,
        first_name: '',
        last_name: '',
        relationship: ''
      },
      relation_phone_numbers: [
        {
          phone_number: '',
          label: '',
          is_bad_number: 0
        }
      ],
      relation_emails: [{email: ''}],
      relation_addresses: [
        {
          label: '',
          street: '',
          city: '',
          state: '',
          zip: '',
          country: ''
        }
      ],
      jobsiteData: {
        jobAddress: '',
        jobState: '',
        jobCity: '',
        jobZipcode: ''
      },
      editJobsite: {
        jAddress: '',
        jState: '',
        jCity: '',
        jZipcode: ''
      }
    }
  },
  methods: {
    addTab(id, type){
      console.log(id)
      console.log(type)
      console.log(this.tabs)
      let i = 0
      this.tabs.push({ index: i+1, name: `Tab ${this.tabs.length + 1}` });
    },
    removeTab(key) {
      // console.log(this.tabs)
      this.tabs = this.tabs.filter(tab => tab.index !== key);
      // this.tabs.splice(key, 1);
      // let t = this.tabs
      // $.each(this.tabs, function(k,v) {
      //   // console.log(v.index)
      //   if (key == v.index) {
      //     t.splice(key, 1);
      //   }
      // })
    },
    scrollToBottom() {
      this.$nextTick(() => {
        const container = this.$refs.facebookChatContainer;
        container.scrollTop = container.scrollHeight;
      });
    },
    async refreshGmail() {
      const res = await this.getGmailLatestMessage()
      let obj1 = res.data.messages
      let obj2 = JSON.parse(sessionStorage.getItem('gmail_data'))

      if(obj1 !== obj2) {
        sessionStorage.removeItem('gmail_data')
        sessionStorage.removeItem('gmail_prevToken')
        sessionStorage.removeItem('gmail_nextToken')
        sessionStorage.removeItem('gmail_count')
        sessionStorage.removeItem('gmail_sizeEstimate')
        sessionStorage.removeItem('gmail_firstMessage')

        sessionStorage.setItem('gmail_data', JSON.stringify(obj1))
        sessionStorage.setItem('gmail_prevToken', JSON.stringify(res.data.previousPageToken))
        sessionStorage.setItem('gmail_nextToken', JSON.stringify(res.data.nextPageToken))
        sessionStorage.setItem('gmail_count', JSON.stringify(res.data.gmailCount))
        sessionStorage.setItem('gmail_sizeEstimate', JSON.stringify(res.data.resultSizeEstimate))
        sessionStorage.setItem('gmail_firstMessage', JSON.stringify(res.data.messages[0]))

        this.listOfMessages = JSON.parse(sessionStorage.getItem('gmail_data'))
        this.prevToken = JSON.parse(sessionStorage.getItem('gmail_prevToken'))
        this.nextToken = JSON.parse(sessionStorage.getItem('gmail_nextToken'))
        this.gmailCount = JSON.parse(sessionStorage.getItem('gmail_count'))
        this.resultSizeEstimate = JSON.parse(sessionStorage.getItem('gmail_sizeEstimate'))
        this.gmailFirstMessage = JSON.parse(sessionStorage.getItem('gmail_firstMessage'))
      }
    },
    getGmailLatestMessage() {
      return axios.get('/inbox/gmail/get-gmail-messages-and-thread')
    },
    async gmailMessagesAndThreads() {
      try {
        // const res = await this.getGmailLatestMessage()

        // if (sessionStorage.getItem('gmail_data')) {
        //   // let obj1 = res.data.messages
        //   // let obj2 = JSON.parse(sessionStorage.getItem('gmail_data'))
        //   //
        //   // if (obj1 != obj2) {
        //   //   sessionStorage.removeItem('gmail_data')
        //   //   sessionStorage.removeItem('gmail_prevToken')
        //   //   sessionStorage.removeItem('gmail_nextToken')
        //   //   sessionStorage.removeItem('gmail_count')
        //   //   sessionStorage.removeItem('gmail_sizeEstimate')
        //   //   sessionStorage.removeItem('gmail_firstMessage')
        //   //   sessionStorage.setItem('gmail_data', JSON.stringify(obj1))
        //   //   sessionStorage.setItem('gmail_prevToken', JSON.stringify(res.data.previousPageToken))
        //   //   sessionStorage.setItem('gmail_nextToken', JSON.stringify(res.data.nextPageToken))
        //   //   sessionStorage.setItem('gmail_count', JSON.stringify(res.data.gmailCount))
        //   //   sessionStorage.setItem('gmail_sizeEstimate', JSON.stringify(res.data.resultSizeEstimate))
        //   //   sessionStorage.setItem('gmail_firstMessage', JSON.stringify(res.data.messages[0]))
        //   // }
        //
        //   this.listOfMessages = JSON.parse(sessionStorage.getItem('gmail_data'))
        //   this.prevToken = JSON.parse(sessionStorage.getItem('gmail_prevToken'))
        //   this.nextToken = JSON.parse(sessionStorage.getItem('gmail_nextToken'))
        //   this.gmailCount = JSON.parse(sessionStorage.getItem('gmail_count'))
        //   this.resultSizeEstimate = JSON.parse(sessionStorage.getItem('gmail_sizeEstimate'))
        //   this.gmailFirstMessage = JSON.parse(sessionStorage.getItem('gmail_firstMessage'))
        //   this.facebookThreadCount = JSON.parse(sessionStorage.getItem('facebookCount'))
        // } else {
          this.showGmailLoader = true
          const result = await this.getGmailLatestMessage()

          this.listOfMessages = result.data.messages
          this.prevToken = result.data.previousPageToken
          this.nextToken = result.data.nextPageToken
          this.gmailCount = result.data.gmailCount
          this.resultSizeEstimate = result.data.resultSizeEstimate
          this.gmailFirstMessage = result.data.messages[0]


          // if (result.data) {
          //   sessionStorage.setItem('gmail_data', JSON.stringify(result.data.messages))
          //   sessionStorage.setItem('gmail_prevToken', JSON.stringify(result.data.previousPageToken))
          //   sessionStorage.setItem('gmail_nextToken', JSON.stringify(result.data.nextPageToken))
          //   sessionStorage.setItem('gmail_count', JSON.stringify(result.data.gmailCount))
          //   sessionStorage.setItem('gmail_sizeEstimate', JSON.stringify(result.data.resultSizeEstimate))
          //   sessionStorage.setItem('gmail_firstMessage', JSON.stringify(result.data.messages[0]))
          //   sessionStorage.setItem('facebookCount', JSON.stringify(result.data.facebookCount))
          // }
        // }
      } catch (error) {
        console.log(error)
      } finally {
        this.showGmailLoader = false
      }

    },
    async facebookMessagesAndThreads() {
      try {
        // this.showGmailLoader = true
        const result = await axios.get('/inbox/facebook/get-facebook-messages-and-threads');
        this.facebookThreads = result.data.from
      } catch (error) {
        console.log(error)
      } finally {
        // this.showGmailLoader = false
      }
    },
    setActiveNav(val) {
      this.activeNav = val
    },
    async handleFacebookreply(message, psid, id) {
      if (!this.facebookReplyMessage) {
        toast.error('Please type a message...');
      } else {
        try {
          this.facebookReplyLoader = true
          await axios.post("/inbox/facebook/handle-reply", {'message': message, 'psid': id}).then((res) => {
            // console.log(res);
            if (res.data == 200) {
              // router.reload({only:['facebook']})
              // this.refreshThread(this.facebookPSID)
            }
          })
        } catch (error) {
          console.log(error)
        } finally {
          await this.refreshThread(this.facebookPSID)
          this.facebookReplyMessage = ''
          this.facebookReplyLoader = false
        }
      }
    },
    async refreshThread(conversationId, from, id) {
      try {
        this.facebookReplyLoader = true
        await axios.post('/inbox/facebook/get-messages', {'key-id': conversationId}).then((res) => {
          if (res.status == 200) {
            // console.log(res)
            this.facebookMessage = res.data
          }
        })
      } catch (error) {
        console.log(error)
      } finally {
        this.facebookReplyMessage = ''
        this.facebookReplyLoader = false
      }

    },
    async getFacebookMessage(conversationId, from, id) {
      try {
        this.addTab()
        this.facebookMessageLoader = true
        await axios.post('/inbox/facebook/get-messages', {'key-id': conversationId}).then((res) => {
          if (res.status == 200) {
            this.facebookMessage = res.data
            this.facebookMessageHeader = from
            this.facebookPSID = conversationId
            this.facebookUserId = id
          }
        })
      } catch (error) {
        console.log(error)
      } finally {
        this.facebookMessageLoader = false
      }

    },
    openSettings() {
      $('#settings-inbox').modal('show')
    },
    setStatus(id, status) {
      axios.post('/inbox/settings/set-status', {id: id, status: status})
          .then((result) => {
            if (result.data) {
              toast.success('Success! Status updated.')
              // Swal.fire({
              //   text: 'Success! Status updated.',
              //   icon: "success",
              //   buttonsStyling: false,
              //   confirmButtonText: "Close",
              //   customClass: {
              //     confirmButton: "btn btn-success"
              //   }
              // }).then(() => {
              //
              //   $('#settings-inbox').modal('hide')
              //   $(".modal-backdrop").hide()
              //
              //   // Inertia.reload()
              //   // router.reload()
              //
              // })
              router.reload({only: ['settings']});

              // document.getElementById('company_logo').src = URL.createObjectURL(this.companyBaseInfo.logo);
              // document.getElementById('company_logo').innerText = this.companyBaseInfo.name ?? '';
            }
            // $('#settings-inbox').modal('hide')
          })
    },
    copyAddressInfoFromCx() {
      this.jobsiteData.jobAddress = this.customer.street_address
      this.jobsiteData.jobState = this.customer.state
      this.jobsiteData.jobCity = this.customer.city
      this.jobsiteData.jobZipcode = this.customer.zip_code
    },
    editJobsiteInfo(cus) {
      console.log(cus)
      if ($('#copied-jobsite').text() != '') {
        $('#street_address_jobsite').val($('#copied-jobsite').text())
        // this.editJobsite.jAddress = this.jobsiteData.jobAddress
        this.editJobsite.jCity = this.jobsiteData.jobCity
        this.editJobsite.jState = this.jobsiteData.jobState
        this.editJobsite.jZipcode = this.jobsiteData.jobZipcode
        // $('#edit-jobsite').modal('show')
      }
      $('#edit-jobsite').modal('show')
    },
    getAddressDataForAddPerson: function (addressData, placeResultData, id) {
      const placeAddress = placeResultData.address_components

      let streetAddress = ''

      for (const component of placeAddress) {
        const componentType = component.types[0]
        switch (componentType) {
          case "street_number":
            streetAddress = component.long_name;
            break;
          case "route":
            streetAddress += ' ' + component.long_name;
            break;
          case "postal_code":
            if (id === "street_address_new_person")
              this.contact.zipcode = component.long_name;
            else
              this.contact.zipcode = component.long_name;
            break;
          case "administrative_area_level_1":
            if (id === "street_address_new_person")
              this.contact.state = component.long_name;
            else
              this.contact.state = component.long_name
            break;
          case "administrative_area_level_2":
            if (id === "street_address_new_person")
              this.contact.state = component.long_name;
            else
              this.contact.state = component.long_name
            break;
          case "neighborhood":
            if (id === "street_address_new_person")
              this.contact.city = component.long_name;
            else
              this.contact.city = component.long_name
            break;
        }
      }

      if (streetAddress) {
        if (id === "street_address_new_person") {
          $('#street_address_new_person').val(streetAddress);
          this.contact.address = streetAddress;
        }
      }
    },
    newPersonAddress: function () {
      this.contact.address = event.target.value
    },
    getAddressDataForJobsite: function (addressData, placeResultData, id) {
      const placeAddress = placeResultData.address_components

      let streetAddress = ''

      for (const component of placeAddress) {
        const componentType = component.types[0]
        switch (componentType) {
          case "street_number":
            streetAddress = component.long_name;
            break;
          case "route":
            streetAddress += ' ' + component.long_name;
            break;
          case "postal_code":
            if (id === "street_address_jobsite")
              this.editJobsite.jZipcode = component.long_name;
            else
              this.editJobsite.jZipcode = component.long_name;
            break;
          case "administrative_area_level_1":
            if (id === "street_address_jobsite")
              this.editJobsite.jState = component.long_name;
            else
              this.editJobsite.jState = component.long_name
            break;
          case "administrative_area_level_2":
            if (id === "street_address_jobsite")
              this.editJobsite.jState = component.long_name;
            else
              this.editJobsite.jState = component.long_name
            break;
          case "neighborhood":
            if (id === "street_address_jobsite")
              this.editJobsite.jCity = component.long_name;
            else
              this.editJobsite.jCity = component.long_name
            break;
        }
      }

      if (streetAddress) {
        if (id === "street_address_jobsite") {
          $('#street_address_jobsite').val(streetAddress);
          this.editJobsite.jAddress = streetAddress;
        }
      }
    },
    newJobsiteAddress: function () {
      this.editJobsite.jAddress = event.target.value
    },
    getAddressDataForNewCustomer: function (addressData, placeResultData, id) {
      const placeAddress = placeResultData.address_components

      let streetAddress = ''

      for (const component of placeAddress) {
        const componentType = component.types[0]
        switch (componentType) {
          case "street_number":
            streetAddress = component.long_name;
            break;
          case "route":
            streetAddress += ' ' + component.long_name;
            break;
          case "postal_code":
            if (id === "street_address_customer")
              this.editCustomerData.cusZip = component.long_name;
            else
              this.editCustomerData.cusZip = component.long_name;
            break;
          case "administrative_area_level_1":
            if (id === "street_address_customer")
              this.editCustomerData.cusState = component.long_name;
            else
              this.editCustomerData.cusState = component.long_name
            break;
          case "administrative_area_level_2":
            if (id === "street_address_customer")
              this.editCustomerData.cusState = component.long_name;
            else
              this.editCustomerData.cusState = component.long_name
            break;
          case "neighborhood":
            if (id === "street_address_customer")
              this.editCustomerData.cusCity = component.long_name;
            else
              this.editCustomerData.cusCity = component.long_name
            break;
        }
      }

      if (streetAddress) {
        if (id === "street_address_customer") {
          $('#street_address_customer').val(streetAddress);
          this.editCustomerData.cusAddress = streetAddress;
        }
      }
    },
    newCustomerAddress: function () {
      this.editCustomerData.cusAddress = event.target.value
    },
    editCustomer(cus) {
      this.editCustomerData.cusId = cus.cust_id
      this.editCustomerData.cusName = cus.first_name
      this.editCustomerData.cusLastName = cus.last_name
      this.editCustomerData.cusDisplayName = cus.display_name
      this.editCustomerData.cusEmail = cus.email
      this.editCustomerData.cusAddress = cus.street_address
      this.editCustomerData.cusCity = cus.city
      this.editCustomerData.cusState = cus.state
      this.editCustomerData.cusZip = cus.zip_code
      $('#street_address_customer').val(cus.street_address)
      $('#edit-customer').modal('show')
    },
    saveEditedCustomerInfo() {
      if (this.editCustomerData.cusEmail.length == 0) {
        Swal.fire({
          text: 'Email is required!',
          icon: "warning",
          buttonsStyling: false,
          confirmButtonText: "Close",
          customClass: {
            confirmButton: "btn btn-danger"
          }
        })
      } else {
        axios.post('/customers/save-or-edit', this.editCustomerData).then(response => {
          if (response.status) {
            axios.post('/customers/get-customer', {email: this.editCustomerData.cusEmail})
                .then((res) => {
                  this.customer = res.data.customer
                  this.customer.avatar = 'https://dev2.buildovate.io/assets/images/dashboard/1.png';
                })
            $('#edit-customer').modal('hide')
          }
        }).catch((error) => {
          console.log(error)
        })
      }
    },
    startEditing() {
      alert('start')
      // this.editing = true;
      // this.editedText = this.folderInfo.folder_name;
    },
    finishEditing() {
      alert('done')
      // this.editing = false;
      // this.folderName = this.editedText; // Update the text with the edited text
      // if (this.folderName.length == 0) {
      //   this.folderName = this.folderInfo.folder_name
      //   Swal.fire({
      //     text: 'Folder name cannot be empty!.',
      //     icon: "warning",
      //     buttonsStyling: false,
      //     confirmButtonText: "Close",
      //     customClass: {
      //       confirmButton: "btn btn-danger"
      //     }
      //   })
      // }

      // axios.post('/company/portfolio/save-folder-name', {'new-folder-name': this.folderName, 'folder-id': this.folderInfo.file_folder_id})
    },
    openCalendar(val) {
      this.showMiniCalendar = false
      this.showSchedCalendar = true

      if (this.showSchedCalendar) {
        let calendarEl = document.getElementById('mini-calendar')
        let calendar = new Calendar(calendarEl, {
          plugins: [timeGridPlugin, interactionPlugin],
          header: false,
          initialView: 'timeGridWeek'
        })
        calendar.render()
      }
    },
    saveContactInfo() {
      var err = '';
      var phone_numbers = [];
      var emails = [];
      // check phone numbers
      for (var p in this.contact_phone_numbers) {
        var phone = this.contact_phone_numbers[p];
        if (phone.phone_number == '')// || isNaN(phone))
        {
          //   err += 'Invalid Phone Number<br>';
        } else {
          phone_numbers.push(phone);
        }
      }

      // check emails
      for (var ek in this.contact_emails) {
        var email = this.contact_emails[ek].email;
        if (email == '') {
          // err += 'Empty/Invalid Email<br>';
        } else {
          emails.push(email);
        }
      }

      if (err != '') {

        Swal.fire({
          html: 'Please fix the followin issue: ' + err,
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "OK, Got It!",
          customClass: {
            confirmButton: 'btn btn-md btn-danger text-white',
          }
        });

      } else {
        axios.post('/customers/save-contact-info', {
          cust_id: this.customer.cust_id,
          phone_numbers: phone_numbers,
          emails: emails
        })
            .then((res) => {
              if (res.data.success) {
                Swal.fire({
                  html: 'Success! Contact Information Saved.',
                  icon: "success",
                  buttonsStyling: false,
                  confirmButtonText: "OK, Got It!",
                  customClass: {
                    confirmButton: 'btn btn-md btn-success text-white',
                  }
                });

              } else {

                Swal.fire({
                  title: 'Something went wrong. Please try again later.',
                  icon: "error",
                  buttonsStyling: false,
                  confirmButtonText: "OK, Got It!",
                  customClass: {
                    confirmButton: 'btn btn-md btn-danger text-white',
                  }
                });

              }
            })
            .catch((error) => {
              console.log(error.message);
            });
      }
    },
    saveRelationship(mode) {
      var err = '';
      var phone_numbers = [];
      var emails = [];
      var addresses = [];
      // console.log('this.relation',this.relation);

      if (mode == 'relationships' && this.relation.first_name == '' && this.relation.last_name == '') {
        err += '<br>No First name / Last name';
      }

      // check phone numbers
      for (var p in this.relation_phone_numbers) {
        var phone = this.relation_phone_numbers[p];
        if (phone.phone_number == '')// || isNaN(phone))
        {
          //   err += '<br>Invalid Phone Number';
        } else {
          phone_numbers.push(phone);
        }
      }

      // check emails
      for (var ek in this.relation_emails) {
        var email = this.relation_emails[ek].email;
        if (email == '') {
          // err += '<br>Empty/Invalid Email';
        } else {
          emails.push(email);
        }
      }

      // check addresses
      for (var ak in this.relation_addresses) {
        var email = this.relation_addresses[ak].email;
        var address = this.relation_addresses[p];
        if (address.city == '' && address.state == '' && address.country == '' && address.label == '') {
          //   err += '<br>Invalid Address';
        } else {
          addresses.push(address);
        }
      }

      if (err != '') {

        Swal.fire({
          html: 'Please fix the followin issue: ' + err,
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "OK, Got It!",
          customClass: {
            confirmButton: 'btn btn-md btn-danger text-white',
          }
        });

      } else {
        axios.post('/customers/save-relationship', {
          cust_id: this.customer.cust_id,
          relation: this.relation,
          phone_numbers: phone_numbers,
          emails: emails,
          addresses: addresses
        })
            .then((res) => {
              if (res.data.success) {
                Swal.fire({
                  html: 'Success! Relationship Saved.',
                  icon: "success",
                  buttonsStyling: false,
                  confirmButtonText: "OK, Got It!",
                  customClass: {
                    confirmButton: 'btn btn-md btn-success text-white',
                  }
                });

              } else {

                Swal.fire({
                  title: 'Something went wrong. Please try again later.',
                  icon: "error",
                  buttonsStyling: false,
                  confirmButtonText: "OK, Got It!",
                  customClass: {
                    confirmButton: 'btn btn-md btn-danger text-white',
                  }
                });

              }
            })
            .catch((error) => {
              console.log(error.message);
            });
      }
    },
    removeAddress(p, index, target) {

      var relation_address = this.relation_address;

      if (relation_address.length > 1) {
        Swal.fire({
          text: "Are you sure you want to remove this address?",
          icon: "warning",
          showCancelButton: true,
          buttonsStyling: false,
          confirmButtonText: "Yes, remove it!",
          cancelButtonText: "No, return",
          customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-active-light"
          }
        }).then(function (result) {
          if (result.isConfirmed) {

            if (p.id != undefined) {
              axios.delete('/customers/remove-address/' + p.id, {})
                  .then((res) => {
                    if (res.data.success) {
                      relation_address.splice(index, 1);
                    }
                  });
            } else {
              relation_address.splice(index, 1);
            }

          }
        });

        this.relation_address = relation_address;

      }
    },
    removeContactPhone(p, index, target) {
      if (target == 'relationship') {
        var phone_numbers = this.relation_phone_numbers;
      } else {
        var phone_numbers = this.contact_phone_numbers;
      }

      if (phone_numbers.length > 1) {

        Swal.fire({
          text: "Are you sure you want to remove this ?",
          icon: "warning",
          showCancelButton: true,
          buttonsStyling: false,
          confirmButtonText: "Yes, remove it!",
          cancelButtonText: "No, return",
          customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-active-light"
          }
        }).then(function (result) {
          if (result.isConfirmed) {

            if (p.id != undefined) {
              axios.delete('/customers/remove-phone-number/' + p.id, {})
                  .then((res) => {
                    if (res.data.success) {
                      phone_numbers.splice(index, 1);
                    }
                  });
            } else {
              phone_numbers.splice(index, 1);
            }

          }
        });

        if (target == 'relationship') {
          this.relation_phone_numbers = phone_numbers;
        } else {
          this.contact_phone_numbers = phone_numbers;
        }
      }
    },
    removeContactEmail(e, index) {
      if (target == 'relationship') {
        var contact_emails = this.relation_emails;
      } else {
        var contact_emails = this.contact_emails;
      }

      if (contact_emails.length > 1) {

        Swal.fire({
          text: "Are you sure you want to remove this ?",
          icon: "warning",
          showCancelButton: true,
          buttonsStyling: false,
          confirmButtonText: "Yes, remove it!",
          cancelButtonText: "No, return",
          customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-active-light"
          }
        }).then(function (result) {
          if (result.isConfirmed) {

            if (e.id != undefined) {
              axios.delete('/customers/remove-email/' + e.id, {})
                  .then((res) => {
                    if (res.data.success) {
                      contact_emails.splice(index, 1);
                    }
                  });
            } else {
              contact_emails.splice(index, 1);
            }

          }
        });

        if (target == 'relationship') {
          this.relation_emails = contact_emails;
        } else {
          this.contact_emails = contact_emails;
        }
      }
    },
    addContactPhone(target) {
      if (target == 'relationship') {
        this.relation_phone_numbers.push({
          phone_number: '',
          label: '',
          is_bad_number: 0
        });
      } else {
        this.contact_phone_numbers.push({
          phone_number: '',
          label: '',
          is_bad_number: 0
        });
      }
    },
    addContactEmail(target) {
      if (target == 'relationship') {
        this.relation_emails.push({email: ''});
      } else {
        this.contact_emails.push({email: ''});
      }
    },
    addContactAddress(target) {
      this.relation_addresses.push({
        label: '',
        street: '',
        city: '',
        state: '',
        zip: '',
        country: ''
      });
    },
    formatTimestamp(number, mode) {
      var date = new Date(parseInt(number));
      if (mode == 'short') {
        return date.toLocaleDateString("en-US", {month: 'short', day: 'numeric'});
      } else {
        var theDate = date.toLocaleDateString("en-US", {month: 'short', day: 'numeric', year: 'numeric'});
        var theTime = date.toLocaleString('en-US', {hour: 'numeric', minute: 'numeric', hour12: true});
        return theDate + ' ' + theTime;
      }
    },
    formatMessageList() {
      let t = this.listOfMessages.length;
      var msgs = this.listOfMessages;
      var items = this.items;

      var timer = setInterval(function () {
        t--;
        // document.getElementById('msgPrev').innerText = '<div class="alert alert-danger">test</div>';
        items.unshift(msgs[t]);
        this.items = items;
        if (t == 0) {
          clearInterval(timer);
        }
      }, 360);
    },
    toggleContact(index) {
      this.isShown = this.isShown === index ? null : index;
      if (index == 'a') {
        let flat = document.querySelector('.flatpickr-calendar')
        flat.style.boxShadow = 'none'
      }
    },
    loadThreadMessage(id, threadId) {
      // console.log("loadThreadMessage",id);
      // var isEmpty = document.getElementById('threads'+id).innerHTML === "";
      // if(isEmpty)
      // {
      //   document.getElementById('threads'+id).innerHTML = '<center><img src="/assets/images/ajax-loader.gif" class="m-50"></center>';
      // axios.post('/inbox/gmail/get-thread', { id:id } )
      // .then((res) => {
      //   console.log('res',res);
      // if(res.data)
      // {
      // document.getElementById('threads'+id).innerHTML = '<div class="card-body text-muted">' + image + res.data.description + '<br>' + todo + res.data.body + '</div>';
      // }
      // })
      // .catch((error) => {
      //   console.log('error',error.message);
      // });
      // }
      var index = id;
      this.isActive = this.isActive === index ? null : index;
    },
    async loadPage(prev_next) {
      this.listLoading = true;
      var pageToken = '';
      if (prev_next == "previous") {
        this.listPrev = true
        var totalTokens = this.pageTokens.length;
        if (totalTokens > 0) {
          pageToken = this.pageTokens[totalTokens - 1];
          this.prevToken = pageToken;
          this.pageTokens.pop(); // remove last index
        } else {
          this.prevToken = '';
        }

      } else if (prev_next == "next") {
        // console.log('next')
        this.listNext = true
        pageToken = this.nextToken;

        if (this.pageTokens.indexOf(this.nextToken) > -1) {
          //
        } else {
          this.pageTokens.push(this.nextToken);
        }

      }

      await axios.post('/inbox/gmail/list-messages', {prev_next: prev_next, search: this.search, pageToken: pageToken})
          .then((res) => {
            if (res.data.messages.length > 0) {

              sessionStorage.removeItem('gmail_data')
              sessionStorage.removeItem('gmail_prevToken')
              sessionStorage.removeItem('gmail_nextToken')
              sessionStorage.removeItem('gmail_sizeEstimate')

              sessionStorage.setItem('gmail_data', JSON.stringify(res.data.messages))
              sessionStorage.setItem('gmail_prevToken', JSON.stringify(res.data.previousPageToken))
              sessionStorage.setItem('gmail_nextToken', JSON.stringify(res.data.nextPageToken))
              sessionStorage.setItem('gmail_sizeEstimate', JSON.stringify(res.data.resultSizeEstimate))

              this.listOfMessages = JSON.parse(sessionStorage.getItem('gmail_data'))
              this.prevToken = JSON.parse(sessionStorage.getItem('gmail_prevToken'))
              this.nextToken = JSON.parse(sessionStorage.getItem('gmail_nextToken'))
              this.resultSizeEstimate = JSON.parse(sessionStorage.getItem('gmail_sizeEstimate'))

              // this.listOfMessages = res.data.messages;
              // this.prevToken = res.data.previousPageToken;
              // this.nextToken = res.data.nextPageToken;
              // this.resultSizeEstimate = res.data.resultSizeEstimate;

              //reset scroll
              var myDiv = document.getElementById('listOfMessages');
              myDiv.scrollTop = 0;
            }
            this.listLoading = false;
            this.listNext = false
            this.listPrev = false
          })
          .catch((error) => {
            console.log('error', error.message);
            this.listLoading = false;
            this.listNext = false
            this.listPrev = false
          });
    },
    loadGmail() {
      axios.post('/inbox/gmail/messages', {})
          .then((res) => {
            if (res.data.status == 'auth') {
              // show gapi consent form
              window.open(res.data.authUrl, "_self");
            } else {
              this.gmailAuth = true;
              this.loadMessage(this.m);
            }
          })
          .catch((error) => {
            console.log('error', error.message);
          });
    },
    loadMessage(m) {
      this.addTab(m.id, 'gmail')
      this.showMsgBox = false;
      this.threads = [];
      this.emailTo = (m.replyto != '') ? m.replyto : m.from2;
      this.emailSubject = " RE - " + m.subject;
      this.emailFrom = m.from;
      this.headerSubject = m.subject;
      this.threadId = m.threadId;

      this.messageId = m.id;
      this.message = '';
      this.messageDate = m.date;

      axios.post('/inbox/gmail/get-message', {messageId: m.id, threadId: m.threadId})
          .then((res) => {
            // console.log('threads', res.data.threads);
            if (res.data.message) {
              var msg = res.data.message;
              // this.message = msg.replaceAll('<style>','<style scoped>');
              msg = msg.replaceAll('<style', '<div style="display:none" ');
              this.message = msg.replaceAll('</style>', '</div>');

              this.threads = res.data.threads;

            } else {
              console.log(res);
            }
          })
          .catch((error) => {
            console.log(error.message);
          });

      this.loadDCustomerProfile(m.from_email);
    },
    loadDCustomerProfile(email) {

      this.showContact = false;
      this.newContact = false;
      //check customer
      axios.post('/customers/get-customer', {email: email})
          .then((res) => {
            if (res.data.status == 'ok') {
              //contact info
              this.customer = res.data.customer;
              this.contact_phone_numbers = res.data.phone_numbers;
              this.contact_emails = res.data.emails;
              //relationships
              this.relationships = res.data.relationships;
              console.log('relationships', this.relationships);
              console.log('data', res.data.customer);

              this.customer.avatar = 'https://dev2.buildovate.io/assets/images/dashboard/1.png';
              this.showContact = true;
            } else {
              //show add form
              this.customer = [];
              this.contact.email = email;
              this.newContact = true;
              // let calendarEl = document.getElementById('mini-calendar')
              // let calendar = new Calendar(calendarEl, {
              //   plugins: [timeGridPlugin, interactionPlugin]
              // })
              //
              // calendar.render()
            }
            // console.log(res);
          })
          .catch((error) => {
            console.log(error.message);
          });

    },
    addCustomer() {
      axios.post('/customers/add', this.contact)
          .then((res) => {
            if (res.data.status == 'added') {
              this.loadDCustomerProfile(this.contact.email);
            } else {
              // show error
            }

          })
          .catch((error) => {
            console.log(error.message);
          });
    },
    replyTo() {
      this.showTo = false;
      this.showMsgBox = !this.showMsgBox;
    },
    forwardTo() {
      this.showTo = true;
      this.showMsgBox = !this.showMsgBox;
    },
    replyGPT() {

      axios.post('/chatgpt/generate-email-reply', {
        sendToName: this.emailFrom,
        sendToEmail: this.emailTo,
        subject: this.headerSubject,
        message: this.message
      })
          .then((res) => {
            if (res.data.status == 'ok') {
              this.message += res.data.message;
              this.showMsgBox = false;

            } else {

              console.log(res.data.message.error);

              Swal.fire({
                title: 'Something went wrong. Please try again later.',
                buttonsStyling: false,
                confirmButtonText: "OK, Got It!",
                customClass: {
                  confirmButton: 'btn btn-md btn-danger text-white',
                }
              });

            }
          })
          .catch((error) => {
            console.log(error.message);
          });
    },
    sendMessage() {
      if (this.message == null || this.message == '' || this.message == "<p> </p>") {
        Swal.fire({
          title: 'Message is empty.',
          buttonsStyling: false,
          confirmButtonText: "OK, Got It!",
          customClass: {
            confirmButton: 'btn btn-md btn-warning text-white',
          }
        });

      } else {

        axios.post('/inbox/gmail/send-message', {
          messageId: this.messageId,
          threadId: this.threadId,
          to: this.emailTo,
          subject: this.emailSubject,
          message: this.message,
        })
            .then((res) => {
              if (res.data.status == 'ok') {
                this.message = ' ';
                this.showMsgBox = false;

                Swal.fire({
                  title: 'Success! Message sent.',
                  buttonsStyling: false,
                  confirmButtonText: "OK, Got It!",
                  customClass: {
                    confirmButton: 'btn btn-md btn-success text-white',
                  }
                });

              } else {

                Swal.fire({
                  title: 'Something went wrong. Please try again later.',
                  buttonsStyling: false,
                  confirmButtonText: "OK, Got It!",
                  customClass: {
                    confirmButton: 'btn btn-md btn-danger text-white',
                  }
                });

              }
              // console.log(res);
            })
            .catch((error) => {
              console.log(error.message);
            });

      }
    },
    sendLater(src) {
      var d = '';
      var tm = '';
      switch (src) {
        case 'tomorrow':
          d = this._tomorrowAM;
          tm = '08:00';

          break;
        case 'tomOrTodayPM':
          d = this._tomOrTodayDate;
          tm = '13:00';
          break;
        case 'nextMonday':
          d = this._nextMonday;
          tm = '08:00';
          break;
        case 'picker':
          d = this.todaysDate;
          tm = this.todaysTime;
          break;
      }

      if (d == '' || t == '') {
        Swal.fire({
          title: 'Please select Date and time.',
          buttonsStyling: false,
          confirmButtonText: "OK, Got It!",
          customClass: {
            confirmButton: 'btn btn-md btn-danger text-white',
          }
        });

      } else {

        var t = tm.split(':');

        var targetDate = new Date(d.setHours(t[0], t[1], 0));

        axios.post('/inbox/gmail/draft-message', {
          messageId: this.messageId,
          threadId: this.threadId,
          to: this.emailTo,
          subject: this.emailSubject,
          message: this.message,
          targetDate: targetDate
        })
            .then((res) => {
              console.log('draft-res', res);

              if (res.data.status == 'ok') {
                this.message = ' ';
                this.showMsgBox = false;

                Swal.fire({
                  title: 'Success! Message sending scheduled.',
                  buttonsStyling: false,
                  confirmButtonText: "OK, Got It!",
                  customClass: {
                    confirmButton: 'btn btn-md btn-success text-white',
                  }
                });

              } else {

                Swal.fire({
                  title: 'Something went wrong. Please try again later.',
                  buttonsStyling: false,
                  confirmButtonText: "OK, Got It!",
                  customClass: {
                    confirmButton: 'btn btn-md btn-danger text-white',
                  }
                });

              }
              // console.log(res);
            })
            .catch((error) => {
              console.log(error.message);
            });

      }
    },
    openSendLater() {
      this.getCountryTime();
      this.getTimeTodayOrTomorrow();
      this.findNextMonday();
    },
    trimText(str, max) {
      if (str.length > max) {
        return str.substr(0, max) + '...';
      }
      return str;
    },
    getCountryTime() {
      // Offset for Standard Time
      const standardTimeOffset = 8;
      // Current date and time
      const now = new Date();
      // Current timezone offset in hours
      const timezoneOffset = now.getTimezoneOffset() / 60;
      // Convert timezone offset to standard time offset
      const standardTime = (now.getUTCHours() + timezoneOffset) % 24;
      // Return current time in country's Standard Time
      const currentTime = new Date(now.getFullYear(), now.getMonth(), now.getDate(), standardTime + standardTimeOffset, now.getMinutes(), now.getSeconds());

      //get "Philippine Standard Time"
      var timeStr = String(currentTime);
      var matches = timeStr.match(/\(([^)]+)\)/);
      if (matches) {
        this.countryStdTime = matches[1];
      }
    },
    getTimeTodayOrTomorrow() {
      var today = new Date();
      today.getDate();

      //set popup calendar date
      // this.todaysDate = today.toLocaleDateString("en-US", { month: 'short', day: 'numeric', year: 'numeric' });
      // this.todaysTime = today.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });

      if (today.getHours() < 12) {
        //send todayPM
        this.tomOrTodayTxt = 'This afternoon';
        this.tomOrTodayDate = today.toLocaleDateString("en-US", {month: 'short', day: 'numeric'});
        ;

        today.setDate(today.getDate() + 1);
        this._tomorrowAM = today;
        this.tomorrowAM = today.toLocaleDateString("en-US", {month: 'short', day: 'numeric'});

      } else {

        // send tomorrowPM
        this.tomOrTodayTxt = 'Tomorrow afternoon';
        today.setDate(today.getDate() + 1);
        this._tomorrowAM = today;
        this._tomOrTodayDate = today;
        this.tomOrTodayDate = today.toLocaleDateString("en-US", {month: 'short', day: 'numeric'});
        this.tomorrowAM = this.tomOrTodayDate;
      }
    },
    findNextMonday() {
      var now = new Date();
      var currentDay = now.getDay();

      // If today is Monday, add 7 days to find next Monday
      if (currentDay === 1) {
        now.setDate(now.getDate() + 7);
        this.nextMonday = now.toLocaleDateString("en-US", {month: 'short', day: 'numeric'});
      } else {
        // Add enough days to reach next Monday
        var daysUntilMonday = 8 - currentDay;
        now.setDate(now.getDate() + daysUntilMonday);
        this._nextMonday = now;
        this.nextMonday = now.toLocaleDateString("en-US", {month: 'short', day: 'numeric'});
      }
    }
  }

}
// import Vue from "vue";
// import VueSimpleAlert from "vue-simple-alert";

// Vue.use(VueSimpleAlert);
</script>
