<style>
.main-menus li.has-more-link {
    display: none;
}
.main-menus li.has-more-link ul.notification-dropdown li{
    display: none !important;
}

/* temp fix starts here*/
@media (max-width: 1000px)
{
  .main-menus li.has-more-link {
      display: block !important;
  }

  .main-menus li.mm_production {
        display: none !important;
  }
    .main-menus li.has-more-link ul li.mm_production {
          display: block !important;
    }

  .main-menus li.mm_files {
        display: none !important;
  }
    .main-menus li.has-more-link ul li.mm_files {
          display: block !important;
    }

  .main-menus li.mm_financials {
        display: none !important;
  }
    .main-menus li.has-more-link ul li.mm_financials {
          display: block !important;
    }
  
  .main-menus li.mm_admin {
        display: none !important;
  }
    .main-menus li.has-more-link ul li.mm_admin {
          display: block !important;
    }
}

  @media (min-width: 1155px) and (max-width: 1483px) {
     .contenttop {
        padding-top: 70px !important;
      }

      .main-nav,
      .sub-menu {
        padding-top: 60px;
      }
  }
  @media (min-width: 991px) and (max-width: 1042px) {
     .contenttop {
        padding-top: 70px !important;
      }

      .main-nav,
      .sub-menu {
        padding-top: 60px;
      }
  }
/* temp fix ends here*/

@media (max-width: 1024px){
  .main-menus li.has-more-link {
      display: block !important;
  }

  .main-menus li.mm_production {
        display: none !important;
  }
    .main-menus li.has-more-link ul li.mm_production {
          display: block !important;
    }

  .main-menus li.mm_files {
        display: none !important;
  }
    .main-menus li.has-more-link ul li.mm_files {
          display: block !important;
    }

  .main-menus li.mm_financials {
        display: none !important;
  }
    .main-menus li.has-more-link ul li.mm_financials {
          display: block !important;
    }
  
  .main-menus li.mm_admin {
        display: none;
  }
    .main-menus li.has-more-link ul li.mm_admin {
          display: block !important;
    }

}


@media (max-width: 1105px) {
  .main-menus li.mm_calendar {
        display: none;
  }
  .main-menus li.has-more-link ul li.mm_calendar {
        display: block !important;
  }
}

@media (max-width: 1120px) {
  .main-menus li.mm_production {
        display: none;
  }
  .main-menus li.has-more-link ul li.mm_production {
        display: block !important;
  }
}
@media (max-width: 1310px) {
  .main-menus li.mm_files {
        display: none;
  }
  .main-menus li.has-more-link ul li.mm_files {
        display: block !important;
  }
}

@media (max-width: 1155px) {
  .main-menus li.has-more-link {
      display: block !important;
  }

  .main-menus li.mm_production {
        display: none !important;
  }
    .main-menus li.has-more-link ul li.mm_production {
          display: block !important;
    }

  .main-menus li.mm_files {
        display: none !important;
  }
    .main-menus li.has-more-link ul li.mm_files {
          display: block !important;
    }

  .main-menus li.mm_financials {
        display: none !important;
  }
    .main-menus li.has-more-link ul li.mm_financials {
          display: block !important;
    }
  
  .main-menus li.mm_admin {
        display: none;
  }
    .main-menus li.has-more-link ul li.mm_admin {
          display: block !important;
    }

}

@media (max-width: 1420px) {
  .main-menus li.mm_financials {
        display: none;
  }
  .main-menus li.has-more-link ul li.mm_financials {
        display: block !important;
  }
}
@media (max-width: 1450px) {
  .main-menus li.mm_admin {
        display: none;
  }
  .main-menus li.has-more-link ul li.mm_admin {
        display: block !important;
  }
}
@media (max-width: 1449px) {
  .main-menus li.has-more-link {
    display: block;
  }
}

.active-state {
  background-color: #E6EDEF;
  padding: 2px 5px 2px 5px !important;
}

</style>

<template>
  <div class="page-main-header">

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

      <div class="nav-right col p-0 mx-3 top-menus">
        <ul class="nav-menus main-menus p-0">
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
              <a href="javascript:void(0)" class="fs-6"  data-bs-toggle="modal" data-bs-target="#searchModal"><i class="icofont icofont-search-alt-1 text-muted"></i></a>
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
            <!-- <li>
              <a href="javascript:void(0)" class="fs-6"><i class="icofont icofont-search-alt-1 text-muted"></i></a>
            </li> -->
            <li class="onhover-dropdown">
              <div class="notification-box"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3zm-8.27 4a2 2 0 0 1-3.46 0"></path></svg><span class="dot-animated"></span></div>
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
              <i class="icon-user h1"></i>
              <ul class="notification-dropdown onhover-show-div">
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
            <li class="onhover-dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
              <ul class="notification-dropdown onhover-show-div">
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
              <ul class="chat-dropdown onhover-show-div">
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
                <li>
                  <SupportBox />
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
                <i class="icofont icofont-search-alt-1 text-muted"></i>
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
import CustomerListModal from ".modals/CustomerListModal.vue";
import { usePage } from '@inertiajs/vue3';
import { Link as vueLink } from '@inertiajs/vue3';

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
  { name: 'More', component:'More', icon:'ki-abstract-2 text-info', class: 'mm_more'},
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
import { computed, watch, ref } from 'vue';
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
