<style>
.page-body {
  min-height: calc(100vh - 98px) !important;
  max-height: calc(100vh - 98px) !important;
  margin-top: 98px !important;
  overflow: auto;
}
.dashboard-default-sec > slot {
  flex-grow: 1;
}

/* we will explain what these classes do next! */
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}

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

.customizer-links .nav-link .settings i {
  font-size: 16px !important;
  padding: 4px !important;
}

#c-pills-home-tab {
  color: #24695c !important;
}

#c-pills-home-tab:hover {
  color: #e2c636 !important;
}
</style>

<template>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities."
    />
    <meta
      name="keywords"
      content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app"
    />
    <meta name="author" content="pixelstrap" />
    <link
      rel="icon"
      href="https://dev2.buildovate.io/assets/images/favicon.png"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="https://dev2.buildovate.io/assets/images/favicon.png"
      type="image/x-icon"
    />

    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
    />
    
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap"
    />
    <title>Buildovate.io</title>
  </head>
  <body>
    <!-- Loader starts-->
    <!-- <div class="loader-wrapper">
      <div class="theme-loader">    
        <div class="loader-p"></div>
      </div>
    </div> -->
    <!-- Loader ends-->
    <!-- page-wrapper Start       -->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      <TopHeader />
      <!-- <TopBar :tQS="1" @toggleQS="toggleQuickStart" /> -->
      <!-- Page Header Ends  -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <MainSideBar />
        <!-- <transition name="fade" mode="out-in"> -->
        <!-- <SideBarCompany v-if="page.url.includes('company')" /> -->
        <!--      <SideBarInbox v-else-if="page.url.includes('inbox')" />-->
        <!-- <SideBar
          v-else-if="
            !page.url.includes('admin') &&
            !page.url.includes('todos') &&
            !page.url.includes('inbox')
          "
        />
        <SideBarTodo
          v-else-if="!page.url.includes('admin') && page.url.includes('todos')"
        ></SideBarTodo> -->
        <!-- </transition> -->

        <div
          :class="{ 'page-body': page.url !== '/admin' }"
          class="p-0 d-flex flex-column slim-scroll-gray"
          :style="page.props.style.page_body"
        >
          <!-- Container-fluid starts-->
          <!-- <Header
            :pageTitle="pageTitle"
            v-if="
              page.url !== '/calendar' &&
              page.url !== '/company/details' &&
              page.url.includes('files') == false &&
              page.url !== '/admin' &&
              page.url !== '/inbox'
            "
          >
          </Header> -->

          <slot class="p-5"></slot>
          <!-- Container-fluid Ends-->
        </div>

        <!-- footer start-->
        <!-- <Footer /> -->
      </div>
    </div>

    <div
      class="customizer-links"
      style="top: 85%; padding-right: 10px; margin-right: -3px"
    >
      <div
        v-show="!quickstartBar && quickstartLink"
        class="nav flex-column nac-pills"
        id="quickstarttab"
        role="tablist"
        aria-orientation="vertical"
      >
        <button
          @click="quickstartLink = false"
          class="btn btn-success btn-xs"
          data-bs-original-title=""
          title=""
          aria-selected="true"
          role="tab"
          style="
            float: left;
            position: fixed;
            margin-top: -10px;
            font-size: 9px;
            border-radius: 25px;
            padding: 0px 5px;
            margin-left: -7px;
          "
        >
          x
        </button>
        <a
          @click="quickstartBar = true"
          class="nav-link"
          :class="quickstartBar ? 'active' : ''"
          id="c-pills-home-tab"
          data-bs-toggle="pill"
          href="#layout-type"
        >
          <div class="settings">
            <i class="icofont icofont-light-bulb" id="quickstartIcon"></i>
            <b class="fs-7" style="font-weight: 400">Quickstart</b>
          </div>
        </a>
      </div>
      <div :class="quickstartBar ? 'open' : ''" class="customizer-contain">
        <div class="tab-content" id="quickstarttabContent">
          <div class="customizer-header text-center">
            <i
              @click="quickstartBar = false"
              class="icofont-close icon-close"
            ></i>
            <!-- <div class="progress-bar text-center" :data-content="progress_percent+'%'" :style="'color: '+progress_color+';background: radial-gradient(closest-side, white 79%, transparent 80% 100%), conic-gradient('+progress_color+' '+progress_percent+'%, #d2d2ce 0)'">
                <progress value="60" min="0" max="100" style="visibility:hidden;height:0;width:0;">60%</progress>
              </div> -->
            <div
              class="progress mt-5 mb-3"
              style="height: 33px; border-radius: 60px"
            >
              <div
                class="progress-bar-animated bg-primary-v2 progress-bar-striped"
                role="progressbar"
                :style="
                  'width: ' +
                  progress_percent +
                  '%;padding-top: 7px;background: rgb(74, 208, 159) !important;'
                "
                :aria-valuenow="progress_percent"
                aria-valuemin="0"
                aria-valuemax="100"
              >
                {{ progress_percent }}%
              </div>
            </div>
            <h5>Quickstart</h5>
            <hr />
            <SupportBox />
          </div>
          <div class="customizer-body custom-scrollbar">
            <div class="tab-pane fade show active" id="layout-type">
              <div
                class="default-according style-1"
                id="accordion"
                style="font-size: 12px !important"
              >
                <TransitionGroup>
                  <div class="card" v-for="q in quickstarts_data" :key="q.id">
                    <div class="card-header">
                      <div class="row mb-0">
                        <div class="col-md-2 text-center">
                          <i
                            class="fa fa-check"
                            :class="
                              q.status == 1 ? 'text-success' : 'text-secondary'
                            "
                          ></i>
                        </div>
                        <div class="col-md-9">
                          <button
                            @click="loadQuickStartBody(q.id)"
                            class="btn btn-link"
                            :aria-expanded="isActive == q.id ? true : false"
                          >
                            {{ q.title }}
                          </button>
                        </div>
                      </div>
                    </div>

                    <!-- QUICKSTART CONTENTS -->
                    <div
                      :class="isActive == q.id ? 'collapse show' : 'collapse'"
                    >
                      <div :id="'content' + q.id"></div>
                      <div class="text-center mb-3">
                        <Link :href="q.url" class="btn btn-success"
                          >Setup Now</Link
                        >
                      </div>
                    </div>
                  </div>
                </TransitionGroup>
              </div>

              <div
                class="text-center text-center text-white bg-success p-10 fs-7 mb-20"
              >
                For more help, please visit the Instructional Videos page, or
                chat with one of our live agents.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <LeftPanel></LeftPanel>

    <!-- Global Components -->
    <ProposalListModal />
    <SmartEstimatesModal />
    <SmartEstimateListModal />
    <CostItemListModal />
    <CostItemModal />
    <CustomerListModal />
    <InternalUserListModal />
    <LeadListModal />
    <PlaidTransactions />
    <LeadDetailsModal />
    <ScheduleAppointmentModal />
    <CalendarSchedule />
    <NewLead/>
    <NewAppointment/>
  </body>
</template>

<script setup>
import SupportBox from "@/components/SupportBox.vue";
import { usePage } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import LeftPanel from "@/components/LeftPanel.vue";
defineProps(["pageTitle", "tQS"]);

const page = usePage();
</script>

<script>
import CustomerListModal from "./modals/CustomerListModal.vue";
import ProposalListModal from './modals/ProposalListModal.vue';
import SmartEstimatesModal from "./modals/SmartEstimatesModal.vue";
import SmartEstimateListModal from "./modals/SmartEstimateListModal.vue";
import CostItemListModal from "./modals/CostItemListModal.vue";
import CostItemModal from "./modals/CostItemModal.vue";
import InternalUserListModal from "./modals/InternalUserListModal.vue";
import ScheduleAppointmentModal from "./modals/ScheduleAppointmentModal.vue";
import PlaidTransactions from "./plaid/PlaidTransactions.vue";
import LeadListModal from './modals/LeadListModal.vue';
import LeadDetailsModal from "./modals/LeadDetailsModal.vue";
import TopHeader from "./TopHeader.vue";
import MainSideBar from "./MainSideBar.vue";
import CalendarSchedule from "./modals/CalendarSchedule.vue";
import NewLead from "./modals/NewLead.vue";
import NewAppointment from "./modals/NewAppointment.vue";

export default {
  mounted() {
    this.loadQuickStart();
    this.checkQuickstartProgress();
  },
  components: {
    CustomerListModal,
    ProposalListModal,
    SmartEstimatesModal,
    SmartEstimateListModal,
    CostItemListModal,
    CostItemModal,
    InternalUserListModal,
    PlaidTransactions,
    LeadListModal,
    TopHeader,
    LeadDetailsModal,
    ScheduleAppointmentModal,
    CalendarSchedule,
    NewLead,
    NewAppointment,
  },
  data() {
    return {
      quickstartLink: true,
      quickstartBar: false,
      quickstarts_data: [],
      progress_color: "white",
      progress_percent: 0,
      isActive: null
    };
  },
  methods: {
    toggleQuickStart(ev) {
      this.quickstartBar = !this.quickstartBar;
      this.quickstartLink = true;
    },
    loadQuickStart() {
      axios
        .post("/quickstart/load", {})
        .then((res) => {
          this.quickstarts_data = res.data.quickstarts;
        })
        .catch((error) => {
          console.log("error", error.message);
        });
    },
    checkQuickstartProgress() {
      axios
        .post("/quickstart/check-progress", {})
        .then((res) => {
          this.progress_color = res.data.color;
          this.progress_percent = res.data.percent;
        })
        .catch((error) => {
          console.log("error", error.message);
        });
    },
    loadQuickStartBody(id) {
      var isEmpty = document.getElementById("content" + id).innerHTML === "";
      if (isEmpty) {
        //show loader
        document.getElementById("content" + id).innerHTML =
          '<center><img src="/assets/images/ajax-loader.gif" class="m-50"></center>';

        axios
          .post("/quickstart/load-body", { id: id })
          .then((res) => {
            if (res.data.description) {
              var image =
                res.data.image != ""
                  ? '<img class="align-self-center" src="' +
                    res.data.image +
                    '" style="height: 200px; width: 250px;">'
                  : "";
              var todo = "";
              if (id == 1 && res.data.checklists) {
                const checklists = res.data.checklists;
                for (var key in checklists) {
                  var value = checklists[key];
                  if (value == 0) {
                    var x = '<i class="fa fa-remove text-danger"></i> ';
                    switch (key) {
                      case "company":
                        todo += "<li>" + x + "Company Name</li>";
                        break;
                      case "timezone":
                        todo += "<li>" + x + "Timezone</li>";
                        break;
                      case "date_format":
                        todo += "<li>" + x + "Date Format </li>";
                        break;
                      case "time_format":
                        todo += "<li>" + x + "Time Format </li>";
                        break;
                      case "first_day":
                        todo += "<li>" + x + "First day of the week </li>";
                        break;
                      case "phone_numbers":
                        todo += "<li>" + x + "Phone Numbers </li>";
                        break;
                      case "hours":
                        todo += "<li>" + x + "Hours </li>";
                        break;
                      case "emails":
                        todo += "<li>" + x + "Emails </li>";
                        break;
                      case "location":
                        todo += "<li>" + x + "Locations </li>";
                        break;
                    }
                  }
                }

                if (todo != "") {
                  todo =
                    "<br><b>Please complete the following:</b><br><ul>" +
                    todo +
                    "</ul><br>";
                }
              }

              document.getElementById("content" + id).innerHTML =
                '<div class="card-body text-muted">' +
                image +
                res.data.description +
                "<br>" +
                todo +
                res.data.body +
                "</div>";
            } else {
              console.log("Failed to load quickstart content");
            }
          })
          .catch((error) => {
            console.log("error", error.message);
          });
      }

      var index = id;
      this.isActive = this.isActive === index ? null : index;
    }
  }
};
</script>
