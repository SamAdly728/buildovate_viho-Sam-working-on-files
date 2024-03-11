<style scoped>
 .nav2{
  padding:10px !important;
 }
</style>
<template>
  <!-- Container-fluid starts-->
  <div class="container-fluid p-15">
    <div class="email-wrap bookmark-wrap">
      <div class="row">
        
        <div  class=" col-md-12 box-col-12 xl-70">
          <div class="email-right-aside bookmark-tabcontent contacts-tabs">
            <div class="card email-body radius-left">
              <div class="ps-0">
                <div class="tab-content">
                  <div class="tab-pane fade active show" id="pills-personal" role="tabpanel"
                       aria-labelledby="pills-personal-tab">
                    <div class="card mb-0">
                      <div class="card-header d-flex">
                        <h5>Templates</h5><span class="f-14 pull-right mt-0">5 Templates</span>
                      </div>
                      <div class="card-body p-0">
                        <div class="row list-persons" id="addcon">
                          <div class="col-xl-2 xl-50 col-md-4 col-lg-3 box-col-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">

                              <template v-for="t in templateList" :key="t.name">
                                <a @click="loadTemplate(t)" class="contact-tab-0 nav-link" href="javascript:void(0)">
                                  <div class="media">
                                    <i :class="t.icon" class="fs-2 me-4 text-success"></i>
                                    <div class="media-body">
                                      <h6>{{ t.name }}</h6>
                                    </div>
                                  </div>
                                </a>
                              </template>

                            </div>
                          </div>
                          <div class="col-xl-10 xl-50 col-md-8 col-lg-9 box-col-9">
                            <div class="tab-content" id="v-pills-tabContent">
                              <div class="tab-pane contact-tab-0 tab-content-child fade show active" id="v-pills-user"
                                   role="tabpanel" aria-labelledby="v-pills-user-tab">
                                <div class="profile-mail">
                                  <div class="media align-items-center">
                                    <i :class="template_icon" class="fs-1 me-4"></i>
                                    <div class="media-body mt-0">
                                      <div class="pull-right me-4 mt-0">
                                        <select class="form-control">
                                          <option value="">Select...</option>
                                          <option value="1">Template 1</option>
                                          <option value="2">Template 2</option>
                                          <option value="3">Template 3</option>
                                        </select>
                                      </div>
                                      <h5>{{ template_title }}</h5>
                                      <ul>
                                        <li><a href="javascript:void(0)" onclick="editContact(0)">Edit</a></li>
                                        <li><a href="javascript:void(0)" onclick="history(0)">New</a></li>
                                        <li><a href="javascript:void(0)" onclick="deleteContact(0)">Delete</a></li>
                                        <li><a href="javascript:void(0)" onclick="printContact(0)"
                                               data-bs-toggle="modal" data-bs-target="#printModal">Print</a></li>
                                      </ul>
                                    </div>

                                  </div>

                                  <div>
                                    <hr>
                                    <ul class="nav nav-tabs" id="icon-tab" role="tablist">
                                      <li class="nav-item"><a class="nav-link active" id="icon-home-tab" data-bs-toggle="tab" href="#icon-home" role="tab" aria-controls="icon-home" aria-selected="true"><i class="icofont icofont-envelope"></i>General</a></li>
                                      <li class="nav-item"><a class="nav-link" id="icon-home-tab" data-bs-toggle="tab" href="#icon-home" role="tab" aria-controls="icon-home" aria-selected="true"><i class="icofont icofont-envelope"></i>Email</a></li>
                                      <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-bs-toggle="tab" href="#profile-icon" role="tab" aria-controls="profile-icon" aria-selected="false"><i class="icofont icofont-ui-text-chat"></i>Text Message</a></li>
                                    </ul>
                                    <div class="tab-content" id="icon-tabContent">
                                      <div class="tab-pane fade show active" id="icon-home" role="tabpanel" aria-labelledby="icon-home-tab">
                                        <!-- <p class="mb-0 m-t-30">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p> -->
                                        <div class="row">
                                          <div class="col-sm-3 tabs-responsive-side">
                                            <div class="nav flex-column nav-pills border-tab nav-left" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                              <a class="nav-link nav2 active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
                                              <a class="nav-link nav2" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                                              <a class="nav-link nav2" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Inbox</a>
                                              <a class="nav-link nav2" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
                                            </div>
                                          </div>
                                          <div class="col-sm-9">
                                            <div class="tab-content" id="v-pills-tabContent">
                                              <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                              </div>
                                              <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                              </div>
                                              <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                              </div>
                                              <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                      </div>
                                      <div class="tab-pane fade" id="profile-icon" role="tabpanel" aria-labelledby="profile-icon-tab">
                                        <p class="mb-0 m-t-30">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="email-general" v-html="template_body"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade modal-bookmark" id="printModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Print preview</h5>
                          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body list-persons">
                          <div class="profile-mail pt-0" id="DivIdToPrint">
                            <div class="media">
                              <i :class="template_icon" class="fs-1 me-4 text-success"></i>
                              <div class="media-body mt-0 text-success">
                                <h5>{{ template_title }}</h5>
                                <!-- <p id="printmail">barnes@gmail.com</p> -->
                              </div>
                            </div>
                            <div class="email-general">
                              <div v-html="template_body"></div>
                            </div>
                          </div>
                          <button class="btn btn-secondary" id="btnPrint" type="button" onclick="printDiv();">Print
                          </button>
                          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Cancel</button>
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
  </div>
  <!-- Container-fluid Ends-->
</template>
<script setup>
import {usePage} from '@inertiajs/vue3';
const page = usePage();
</script>

<script>
import {usePage} from '@inertiajs/vue3';

const page = usePage();

export default {
  name: 'templates',
//   props: ['tasks'],
//   components: {
//       draggable,
//   },
  data() {

    const templateList = [
      {'name': 'Leads', 'icon': 'icofont icofont-tasks'},
      {'name': 'Plans and Permits', 'icon': 'icofont icofont-license'},
      {'name': 'Proposals', 'icon': 'icofont icofont-attachment'},
      {'name': 'Inbox', 'icon': 'icofont icofont-ui-email'},
      {'name': 'Calendar', 'icon': 'icofont icofont-ui-calendar'},
      {'name': 'Crew Management', 'icon': 'icofont icofont-worker-group'},
      {'name': 'Forms and Checklists', 'icon': 'icofont icofont-list'},
    ];

    return {
      templateList: templateList,
      template_icon: templateList[0].icon,
      template_title: templateList[0].name,
      template_body: ''
    }
  },
  methods: {
    loadTemplate(t) {
      this.template_icon = t.icon;
      this.template_title = t.name;
      this.template_body = '';
    }
  }
}

</script>