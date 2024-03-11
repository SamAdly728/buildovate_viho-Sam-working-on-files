<style>
.main-menus li.has-more-link {
    display: none;
}
.main-menus li.has-more-link ul.notification-dropdown li{
    display: none !important;
}

.top-menus .active-state {
  /* background-color: #0047AB !important; */
  /* border-bottom: 4px solid #FF9900 !important; */
  
  background-color: #ffffff !important;
  /* border-bottom: 4px solid #ffffff !important; */
  /* border: solid white !important;
  border-radius: 100px; */
  border: 1px solid #ffffff !important;
  border-top-left-radius: 10px !important;
  border-top-right-radius: 10px !important;
}
.top-menus .active-state a {
  /* color: white !important; */
  color: #0047AB !important;
}

.main-header-right {
  background-color: #0047AB;
}
.main-header-left {
  background-color: white !important;
}
.center-text-list {
  list-style-type: none; /* Remove default list styling if desired */
  padding: 0; /* Remove default padding */
  margin: 0; /* Align with the parent container */
  height: 84px !important;
}

.center-text-list li {
  display: flex;
  align-items: center;
  line-height: 70px;
  margin-right: 0px !important;
  padding: 6px 18px !important;
  border-radius: 0px !important;
}

.center-text-list .mm_style {
  color: white;
  line-height: 1.5;
  display: inline-block;
  vertical-align: middle;
}

.center-text-list li:hover {
  background-color: #4682B4; /* Replace with your desired hover color */
  
  border-top-left-radius: 10px !important;
  border-top-right-radius: 10px !important;

}

.notification-dropdown.onhover-show-div {
  /* Ensure the dropdown is a block element and positioned absolutely (if needed) */
  display: block !important;
  position: absolute;
  left: 0;
  right: 0;
  z-index: 1000;
}

.notification-dropdown.onhover-show-div li {
  /* Display list items in a line */
  display: inline-block !important; /* Or 'inline' depending on your layout needs */
  margin-right: 10px; /* Spacing between items */
  cursor: pointer; /* Changes the cursor to indicate clickable items */
}

.onhover-dropdown:hover .notification-dropdown.onhover-show-div {
  /* Show the dropdown menu on hover */
  display: block !important;
}


.notification-dropdown.onhover-show-div {
    display: none;
    position: absolute; /* Adjust as needed for your layout */
    left: 0;
    z-index: 100; /* Ensure it's above other content */
}

/* Show dropdown on hover */
.onhover-dropdown:hover .notification-dropdown.onhover-show-div {
    display: block;
}

/* Adjustments for smaller screens (optional) */
@media (max-width: 768px) {
  .notification-dropdown.onhover-show-div li {
    display: block !important; /* Stack the items vertically on smaller screens */
    margin-right: 0;
  }
}
@media (min-width: 991px) and (max-width: 1223px) {
  .nav-right {
    font-size: smaller;  /* Example: reducing the font size */
    padding: 1px;       /* Example: changing the padding */
  }
  .center-text-list li {
  margin-right: 0px !important;
  padding: 6px 10px !important;
}
 .addnew{
  display: none;
 }
}

@media (min-width: 991px) and (max-width: 1015px) {
  /* .right-menu {
    display: none !important; 
  } */
  .main-header-left {
    width: 25% !important;
  }
}
@media (max-width: 991px) {
  .main-header-left {
    height: 84px !important;
  }
}
@media (max-width: 480px) {
  .main-header-left {
    height: 84px !important;
    width: 100% !important;
  }
  .top-menus {
    display: none !important; 
  }
}
/* @media (max-width:  1053pxx) {
  .right-menu {
    display: none; 
  }
} */
/* navbar-nav me-auto mb-2 mb-lg-0 */

.nav-menus.dropdown-menu {
  display: block; /* Override display for v-show */
  position: absolute; /* Position it relative to the parent */
  left: 0; /* Align to the left of the parent */
  z-index: 1000; /* Ensure it's on top of other content */
  float: none; /* Prevent floating */
  min-width: 10rem; /* Minimum width */
  padding: .5rem 0; /* Padding inside the dropdown */
  margin: .125rem 0 0; /* Margin around the dropdown */
  font-size: 1rem; /* Font size */
  color: #212529; /* Text color */
  text-align: left; /* Text alignment */
  background-color: #fff; /* Background color */
  border: 1px solid rgba(0,0,0,.15); /* Border */
  border-radius: .25rem; /* Rounded corners */
}

.addnew-btn {
    background-color: white !important;
    color: #333; 
    border-radius: 20px !important; 
    border: none; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); 
    padding: 5px 15px; 
    font-size: 14px; 
    font-weight: bold; 
    display: inline-flex; 
    align-items: center; 
    gap: 10px; 
}
.addnew-btn .icon {
    background-color: #FFEB3B;
    color: rgb(0, 0, 0);
    border-radius: 50%; 
    display: inline-flex; 
    align-items: center;
    justify-content: center; 
    width: 30px; 
    height: 30px; 
    font-size: 20px; 
}

.separator {
  height: 1px;
  background-color: #cbcbcb;
  margin: 0.2rem 0;
  border: none;
  width: 100%;
}

</style>

<template>
  <div  ref="dropdownContainer" class="page-main-header">

    <div class="main-header-right row m-0 top-main-header">
        <div class="main-header-left">
          <div class="logo-wrapper">
            <a href="/" id="company_logo" style="font-size:x-large;">
              {{ (_page.props.company.logo!='') ? _page.props.company.logo : '' }}
              <!-- <img id="company_logo" class="img-fluid2" :src="(_page.props.company.logo!='') ? '/uploads/logos/'+_page.props.company.logo : '/assets/images/logo/logo.png'" alt="" style="width: 150px;height: 50px;"> -->
            </a>

          </div>
          <!-- <div class="dark-logo-wrapper"><a href="/"><img class="img-fluid" src="https://dev2.buildovate.io/assets/images/logo/dark-logo.png" alt=""></a></div> -->
          <div class="toggle-sidebar" @click="toggleSidebar">
            <i :class="[arrowDirection, 'status_toggle middle']" data-feather="align-center" id="sidebar-toggle"></i>
          </div>
        </div>
          <!-- <div class="d-lg-none mobile-toggle pull-right w-auto text-primary" @click="toggleMainMenus">
            <i class="icofont icofont-navigation-menu"></i>
          </div> -->

      <div class="nav-right col p-0 mx-3 top-menus"  style="height: 84px !important;" >
        <ul class="nav-menus main-menus p-0 center-text-list">
            <li v-for="t in topNavs" :key="t.name" :class="[t.class, { 'onhover-dropdown has-more-link': t.name === 'More' }]" class="">
              <MainMenuOptionLink
                  :key="t.name"
                  :href="t.href"
                  :name="t.name"
                  :icon="t.icon"
                  :component ="t.component">
              </MainMenuOptionLink>
                <ul v-if="t.name === 'More'" class="notification-dropdown onhover-show-div">
                  <li v-for="subItem in topNavs" :key="subItem.name" :class="[subItem.class, 'noti-primary']">
                    <MainMenuOptionLink
                      :key="subItem.name"
                      :href="subItem.href"
                      :name="subItem.name"
                      :icon="subItem.icon"
                      :component ="subItem.component">
                    </MainMenuOptionLink>
                  </li>
                </ul>
            </li>
            <li>
              <a href="javascript:void(0)" class="fs-6"  data-bs-toggle="modal" data-bs-target="#searchModal"><i class="icofont icofont-search-alt-1 text-muted" style="color: white !important;"></i></a>
            </li>
            <!-- <li>
              <div class="input-group">
                <span class="input-group-text"><i class="icofont icofont-search-alt-1 text-muted"></i></span>
                <input class="form-control" type="text" placeholder="Search here...">
              </div>
            </li> -->
        </ul>
      </div>

      
      <div class="nav-right pull-right right-menu p-0 m-0" style="width: auto !important;">
          <ul class="nav-menus m-0 p-0" style="padding-right: 10px !important; ">
            <div class= "addnew">
                <button class="btn addnew-btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" @click="toggleDropdown">
                  <span class="icon">+</span> Add new
                </button>
                <div class="dropdown">
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" :href="'/sales/lead-management/new-lead'">Lead</a></li>
                        <li class="separator"></li>
                        <li><a class="dropdown-item" :href="'/sales/lead-management/proposal'">Proposal </a></li>
                        <li><a class="dropdown-item" href="#">Invoice</a></li>
                        <li><a class="dropdown-item" href="#">Service Plan</a></li>
                        <li class="separator"></li>
                        <li><a class="dropdown-item" href="#">Client</a></li>
                        <li><a class="dropdown-item" :href="'/company/users'">User</a></li>
                        <li class="separator"></li>
                        <li><a class="dropdown-item" href="#">Automation Rule</a></li>
                    </ul>
                </div>
            </div>
              <li class="dropdown1">
                <button class="btn" @click=toggleDropdown><i class="fas fa-bars" style="color: white;"></i></button>
                  <!-- <div class="mm_style"  @click=toggleDropdown>
                      <i class="fas fa-bars"></i>
                  </div> -->
                  <ul  v-show="isDropdownOpen" class="nav-menus dropdown-menu m-0 p-0 notification-dropdown" style="padding-right: 10px !important; ">
                    <li class="onhover-dropdown" id = "btndropdown1">
                      <div class="notification-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3zm-8.27 4a2 2 0 0 1-3.46 0"></path></svg>
                        <span class="dot-animated"></span>
                      </div>
                      <ul class="notification-dropdown onhover-show-div">
                        <li>
                          <p class="f-w-700 mb-0">You have 3 Notifications<span class="pull-right badge badge-primary badge-pill">4</span></p>
                        </li>
                        <li class="noti-primary">
                          <div class="media"><span class="notification-bg bg-light-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg></span>
                            <div class="media-body">
                              <p>Delivery processing </p><span>10 minutes ago</span>
                            </div>
                          </div>
                        </li>
                        <li class="noti-secondary">
                          <div class="media"><span class="notification-bg bg-light-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></span>
                            <div class="media-body">
                              <p>Order Complete</p><span>1 hour ago</span>
                            </div>
                          </div>
                        </li>
                        <li class="noti-success">
                          <div class="media"><span class="notification-bg bg-light-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span>
                            <div class="media-body">
                              <p>Tickets Generated</p><span>3 hour ago</span>
                            </div>
                          </div>
                        </li>
                      </ul>

                    </li>
                    <li class="onhover-dropdown">
                      <svg class="feather feather-message-square" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                      </svg>

                      <ul class="notification-dropdown onhover-show-div dropdown3">
                        <vueLink href="/company/users">
                        <li class="noti-primary">
                          <div class="media">
                            <span class="notification-bg bg-light-primary">
                              <i class="icofont icofont-ui-user-group h5 mt-2"></i>
                            </span>
                            <div class="media-body">
                              <p class="mt-2">Internal Users </p>
                            </div>
                          </div>
                        </li>
                        </vueLink>
                        <vueLink href="/company/crews">
                        <li class="noti-secondary">
                          <div class="media">
                            <span class="notification-bg bg-light-secondary">
                              <i class="icofont icofont-hammer h5 mt-2"></i>
                            </span>
                            <div class="media-body">
                              <p class="mt-2">Subs/Vendors</p>
                            </div>
                          </div>
                        </li>
                        </vueLink>
                        <li class="noti-success">
                          <div class="media">
                            <span class="notification-bg bg-light-success">
                              <i class="icofont icofont-contacts h5 mt-2"></i>
                            </span>
                            <div class="media-body">
                              <p class="mt-2" @click="openCustomerContact">Customer Contacts</p>
                            </div>
                          </div>
                        </li>
                      </ul>

                    </li>
                    <li class="onhover-dropdown">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>                  
                      <ul class="notification-dropdown onhover-show-div dropdown4">
                        <li class="noti-danger">
                          <div class="media"><span class="notification-bg bg-light-danger"><i class="icofont icofont-envelope"></i></span>
                            <div class="media-body">
                              <p>Email</p><span>Click to compose email.</span>
                            </div>
                          </div>
                        </li>
                        <li class="noti-primary">
                          <div class="media">
                            <span class="notification-bg bg-light-primary"><i class="icofont icofont-paper-plane"></i></span>
                            <div class="media-body">
                              <p>SMS </p><span>Click to create new message.</span>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </li>
                    <li class="onhover-dropdown" style="float: right;">
                      <div style="height: auto; width: 50px; border: 5px solid rgba(36, 105, 92, 0.2); border-radius: 25px;">
                        <div class="text-center">
                          <img class="img-50 rounded-circle" src="https://dev2.buildovate.io/assets/images/dashboard/1.png">
                        </div>
                      </div>
                      
                      <ul class="chat-dropdown onhover-show-div  dropdown5">
                        <li class="noti-success">
                          <div class="media"><span class="notification-bg bg-light-success"><i data-feather="user-check"> </i></span>
                            <div class="media-body">
                              <p>
                              <span class="p-r-10"><i class="icofont icofont-light-bulb"></i></span>
                                <a href="javascript:void(0)" @click="toggleQuickStart()" >
                                  Quickstart
                                </a>
                              </p>
                            </div>
                          </div>
                        </li>
                        <li v-for="u in userProfile" :key="u.name" class="noti-success">
                          <div class="media"><span class="notification-bg bg-light-success"><i data-feather="user-check"> </i></span>
                            <div class="media-body">
                              <p>
                              <span class="p-r-10"><i :class="u.icon"></i></span>
                                <Link 
                                    :key="u.name" 
                                    :href="u.href" 
                                    :name="u.name"
                                    :icon="u.icon"
                                    :component ="u.component"
                                    :class ="u.class">
                                </Link>
                              </p>
                              
                            </div>
                          </div>
                        </li>
                        <li class="noti-success">
                            <div class="media">
                                <div class="media-body">
                                    <p>
                                        <span class="p-r-10"><i class="icofont icofont-ui-power"></i></span>
                                        <a href="https://pros.buildovate.com/" target="_blank"> Login to Pros Account</a>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li>
                          <SupportBox />
                        </li>
                      </ul>
                    </li>
                  </ul>
              </li>
          </ul>
      </div>

    </div>
  </div>
  <CustomerListModal :type="'top-view'" :id="'topViewCustomerModal'"/>

  <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <!-- <div class="modal-header">
            <h5 class="modal-title">Search</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
        </div> -->
        <div class="modal-body p-1">
            <!-- <input type="text" class="w-full fs-5 form-control"> -->
            <div class="input-group">
              <span class="input-group-text">
                <i class="icofont icofont-search-alt-1 text-muted" ></i>
              </span>
              <input class="form-control w-full fs-5" type="text" placeholder="Search here...">
            </div>
        </div>
      </div>
      </div>
  </div>
</template>

<script setup>
import SupportBox from "@/components/SupportBox.vue";
import MainMenuOptionLink from "@/components/MainMenuOptionLink.vue";
import Link from "@/components/Link.vue";
import CustomerListModal from "./modals/CustomerListModal.vue";
import { usePage } from '@inertiajs/vue3';
import { Link as vueLink } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

const isDropdownOpen = ref(false);
const dropdownContainer = ref(null);

function toggleDropdown() {
    console.log("toggleDropdown is fired");
  isDropdownOpen.value = !isDropdownOpen.value;
}

const handleClickOutside = (event) => {
  if (dropdownContainer.value && !dropdownContainer.value.contains(event.target)) {
    isDropdownOpen.value = false;
  }
};
const handleMouseLeave = (event) => {
  if (!dropdownContainer.value.contains(event.relatedTarget)) {
    isDropdownOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
  dropdownContainer.value.addEventListener('mouseleave', handleMouseLeave);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
  dropdownContainer.value.removeEventListener('mouseleave', handleMouseLeave);
});


const props = defineProps(['tQS']);


const emit = defineEmits(['toggleQS']);

function toggleQuickStart()
{
  emit('toggleQS',props.tQS);
}

const _page = usePage();

// console.log('logo',_page.props.company.logo);

const topNavs = [
  { name: 'Company', component:'Company', href: '/company', icon:'ki-chart-pie-3 text-info', class: 'mm_my_company top-nav-item'},
  { name: 'Projects', component:'Projects', href: '/projects', icon:'ki-diamonds text-info', class: 'mm_projects top-nav-item'},
  { name: 'To Do', component:'Todo', href: '/todos', icon:'ki-diamonds text-info', class: 'mm_projects top-nav-item'},
  { name: 'Sales', component:'Sales', href: '/sales', icon:'ki-coffee text-info', class: 'mm_sales top-nav-item'},
  { name: 'Inbox', component:'Inbox', href: '/inbox', icon:'ki-design-frame text-info', class: 'mm_inbox top-nav-item'},
  { name: 'Calendar', component:'Calendar', href: '/calendar', icon:'ki-technology text-info', class: 'mm_calendar top-nav-item'},
  { name: 'Production', component:'Production', href: '/production', icon:'ki-abstract-2 text-info', class: 'mm_production top-nav-item'},
  { name: 'Files', component:'Files', href: '/files', icon:'ki-abstract-2 text-info', class: 'mm_files top-nav-item'},
  { name: 'Financials', component:'Financials', href: '/financials', icon:'ki-abstract-2 text-info', class: 'mm_financials top-nav-item'},
  // { name: 'Admin', component:'Admin', href: '/admin', icon:'ki-abstract-2 text-info', class: 'mm_admin'},
  // { name: 'More', component:'More', icon:'ki-abstract-2 text-info', class: 'mm_more'},
];

// Notifications
// Language
// User Profile 
//  - Settings
//   - Roadmap
//   - Live Chat
//   - Security
//   - Knowledgebase
//   - Logout

const userProfile = [
  // { name: 'Settings', component:'UseProfile', href: '/user/settings', icon:'icon-settings'},
  { name: 'Admin', component:'Admin', href: '/admin/index', icon:'icon-settings'},
  { name: 'Roadmap', component:'UseProfile', href: '/user/roadmap', icon:'icon-arrow-right'},
  { name: 'Live Chat', component:'UseProfile', href: '/user/live-chat', icon:'icofont icofont-ui-chat'},
  // { name: 'Inbox', component:'UseProfile', href: '/user/inbox', icon:'icon-arrow-right'},
  { name: 'Profile', component:'UseProfile', href: '/user/profile', icon:'icon-arrow-right'},
  { name: 'Knowledgebase', component:'UseProfile', href: '/user/knowledgebase', icon:'icon-book'},
  { name: 'Logout', component:'UseProfile', href: '/auth/logout', icon:'icofont icofont-ui-power'},
];


</script>

<script>

import { usePage } from '@inertiajs/vue3';
import { computed, watch, ref, onMounted, onUnmounted } from 'vue';
const arrowDirection = ref('fa fa-arrow-circle-left');

const page = usePage();

const pageUrl = computed(() => page.url || '');
const isSubmenuPage = computed(() => page.url.split('/').length >= 3);
page.isUserTogglingSidebar = true;

const openCustomerContact = () => {
  var modal = document.querySelector('#topViewCustomerModal');
  var bootstrapModal = new bootstrap.Modal(modal);
  bootstrapModal.show();
}

watch(pageUrl, (newUrl, _) => {
  if ((newUrl.startsWith('/sales') && isSubmenuPage.value) || newUrl.startsWith('/admin') || newUrl.startsWith('/inbox')) {
      page.props.style.sidebar = false;
      page.props.style.page_body = 'margin-left:0px';
      arrowDirection.value = 'fa fa-arrow-circle-left';
    }
  }
);

watch(page, (url, u) => {
  const navLinks = document.querySelectorAll('li a');
  navLinks.forEach(link => {
    let parent = link.parentElement.parentElement.parentElement
    if ((link.getAttribute('href') === u.url || page.url.includes(link.getAttribute('href'))) && !parent.classList.contains('sub-menu-items')) {
      link.parentElement.classList.add('active-state');
    } else {
      link.parentElement.classList.remove('active-state')
    }
  });
})

export default {
    name: 'PostFormAxios',
    components: {
    // 'vue-load-image': VueLoadImage
    },
    data(){
        return{

        }
    },
    methods:{
        toggleSidebar() {
          if (!page.props.style.sidebar) {
              page.props.style.sidebar = true;
              page.props.style.page_body = 'margin-left:290px';
              // arrowDirection.value = 'fa fa-arrow-circle-right';
          } else {
              page.props.style.sidebar = false;
              page.props.style.page_body = 'margin-left:0px';
              // arrowDirection.value = 'fa fa-arrow-circle-left';
          }
        }
    }
}
</script>
