<style scoped>
</style>
<template>
  <div class="p-3 overflow-auto" >
    <div class="">
      <div class="row">
        <div class="col-md-12">
          <div class="card rounded">
            <div class="card-header pl-3 pt-3 pb-1">
              <div class="card-title">
                <h5 class="text-muted">General</h5>
              </div>
            </div>
            <hr class="mt-0">
            <div class="card-body">

              <div class="row mb-4" >
                <div class="col col-md-3 col-sm-12 col-xs-12 mb-3" v-for="a in General" :key="a.url">
                  <Link :href="a.url">
                    <span class="text-muted">
                      {{ a.name }}
                    </span>
                  </Link>
                </div>
              </div>

            </div>
          </div>
          <div class="card rounded">
            <div class="card-header pl-3 pt-3 pb-1">
              <div class="card-title">
                <h5 class="text-muted">Sales</h5>
              </div>
            </div>
            <hr class="mt-0">
            <div class="card-body">
              
              <div class="row mb-4" >
                <div class="col col-md-3 col-sm-12 col-xs-12 mb-3" v-for="a in Sales" :key="a.url">
                  <Link :href="a.url">
                    <span class="text-muted">
                      {{ a.name }}
                    </span>
                  </Link>
                </div>
              </div>

            </div>
          </div>
          <div class="card rounded">
            <div class="card-header pl-3 pt-3 pb-1">
              <div class="card-title">
                <h5 class="text-muted">Project Management</h5>
              </div>
            </div>
            <hr class="mt-0">
            <div class="card-body">
              
              <div class="row mb-4" >
                <div class="col col-md-3 col-sm-12 col-xs-12 mb-3" v-for="a in ProjectManagement" :key="a.url">
                  <Link :href="a.url">
                    <span class="text-muted">
                      {{ a.name }}
                    </span>
                  </Link>
                </div>
              </div>

            </div>
          </div>
          <div class="card rounded">
            <div class="card-header pl-3 pt-3 pb-1">
              <div class="card-title">
                <h5 class="text-muted">Files</h5>
              </div>
            </div>
            <hr class="mt-0">
            <div class="card-body">
              
              <div class="row mb-4" >
                <div class="col col-md-3 col-sm-12 col-xs-12 mb-3" v-for="a in Files" :key="a.url">
                  <Link :href="a.url">
                    <span class="text-muted">
                      {{ a.name }}
                    </span>
                  </Link>
                </div>
              </div>

            </div>
          </div>
          <div class="card rounded">
            <div class="card-header pl-3 pt-3 pb-1">
              <div class="card-title">
                <h5 class="text-muted">Communication</h5>
              </div>
            </div>
            <hr class="mt-0">
            <div class="card-body">
              
              <div class="row mb-4" >
                <div class="col col-md-3 col-sm-12 col-xs-12 mb-3" v-for="a in Communication" :key="a.url">
                  <Link :href="a.url">
                    <span class="text-muted">
                      {{ a.name }}
                    </span>
                  </Link>
                </div>
              </div>

            </div>
          </div>
          <div class="card rounded">
            <div class="card-header pl-3 pt-3 pb-1">
              <div class="card-title">
                <h5 class="text-muted">Marketing</h5>
              </div>
            </div>
            <hr class="mt-0">
            <div class="card-body">
              
              <div class="row mb-4" >
                <div class="col col-md-3 col-sm-12 col-xs-12 mb-3" v-for="a in Marketing" :key="a.url">
                  <Link :href="a.url">
                    <span class="text-muted">
                      {{ a.name }}
                    </span>
                  </Link>
                </div>
              </div>

            </div>
          </div>
          <div class="card rounded">
            <div class="card-header pl-3 pt-3 pb-1">
              <div class="card-title">
                <h5 class="text-muted">Financial</h5>
              </div>
            </div>
            <hr class="mt-0">
            <div class="card-body">
              
              <div class="row mb-4" >
                <div class="col col-md-3 col-sm-12 col-xs-12 mb-3" v-for="a in Financial" :key="a.url">
                  <Link :href="a.url">
                    <span class="text-muted">
                      {{ a.name }}
                    </span>
                  </Link>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";

import {usePage} from '@inertiajs/vue3';
import {useSideBar} from "../stores/sidebar.js";
import {onMounted, onUnmounted} from "vue";

const store = useSideBar();
const page = usePage();

onMounted(() => {
  store.toggle()
})

onUnmounted(() => {
  store.toggle()
})

const General = [
      { name : 'Manage Subscription', 'url': '/admin/subscription' }, 
      { name : 'Products & Services', 'url': '/admin/products-and-services' },
      { name : 'Role Management', 'url': '/company/users' },
      { name : 'Subs / Vendors', 'url': '/admin/subs-vendors' },
      { name : 'Teams', 'url': '/admin/teams' },
      { name : 'Job Settings', 'url': '/admin/job-settings' },
      { name : 'Customer Contacts', 'url': '/admin/customer-contacts' },
      { name : 'Gallery', 'url': '/admin/gallery' },
      { name : 'Voice & Text', 'url': '/admin/voice-and-text' },
      { name : 'Calendar', 'url': '/admin/calendar' },
      { name : 'Customer Portal', 'url': '/admin/customer-portal' },
      { name : 'Company Information', 'url': '/admin/company-information' },
      { name : 'Automation', 'url': '/admin/automation' },
      { name : 'Phone Number Management', 'url': '/admin/phone-number-management' },
      { name : 'Customer Fields', 'url': '/admin/customer-fields' },
      { name : 'Templates', 'url': '/admin/templates' },
      { name : 'Roles and Permissions', 'url': '/admin/permissions-roles' },
 ];

 const Sales = [
      { name : 'Leads', 'url': '/sales/lead-management' },
      { name : 'Smart Estimates', 'url': '/sales/estimator-tool' },
      { name : 'Products Catalogs', 'url': '/sales/catalogs' },
      { name : 'Schedules', 'url': '/sales/activities' },
      { name : 'Proposals', 'url': '/sales/proposals' },
      { name : 'Sample Kits', 'url': '/sales/sample-kits' },
 ];

const ProjectManagement = [
      { name : 'Schedules', 'url': '/production/schedules' },
      { name : 'Daily Logs', 'url': '/production/daily-logs' },
      { name : 'To-Do\'s', 'url': '/production/todos' },
      { name : 'Change Orders', 'url': '/production/change-orders' },
      { name : 'Time Clock', 'url': '/production/time-clock' },
      { name : 'Builder\'s Insurance', 'url': '/production/builders-insurance' },
      { name : 'Scope of Work', 'url': '/production/scope-of-work' },
      { name : 'Jobsite Checklist', 'url': '/production/jobsite-checklist' },
      { name : 'Subcontractors', 'url': '/production/subcontractor' },
      { name : 'Calendar', 'url': '/production/production-calendar' },
      { name : 'Engineering & Plans', 'url': '/production/plans-and-permits' },
];

const Files = [
      { name : 'Files', 'url': '/files' },
];

const Communication = [
      { name : 'Comment & Messages', 'url': '/admin/comment-and-messages' },
      { name : 'Whatsapp', 'url': '/inbox/whatsapp' },
];

const Marketing = [
      { name : 'Lead Providers', 'url': '/marketing/lead-providers' },
      { name : 'Marketing Calendar', 'url': '/marketing/marketing-calendar' },
      { name : 'Branded Magazines', 'url': '/marketing/branded-magazines' },
      { name : 'Ad Creatives', 'url': '/marketing/ad-creatives' },
      { name : 'Social Media', 'url': '/marketing/social-media' },
      { name : 'Local Ranking', 'url': '/marketing/local-ranking' },
      { name : 'Review Management', 'url': '/marketing/review-management' },
      { name : 'Position Tracking', 'url': '/marketing/position-tracking' },
];

const Financial = [
      { name : 'Bids', 'url': '/financial/bids' },
      { name : 'Estimates', 'url': '/financial/estimates' },
      { name : 'Bills / POs / Budget', 'url': '/financial/bills-pos-budget' },
      { name : 'Owner Invoices', 'url': '/financial/owner-invoices' },
      { name : 'Online Payments', 'url': '/financial/online-payments' },
      { name : 'Accounting', 'url': '/financial/accounting' },
      { name : 'Taxes', 'url': '/financial/taxes' },
      { name : 'Stage Payments', 'url': '/financial/stage-payments' },
      { name : 'Overhead', 'url': '/financial/overhead' },
      { name : 'Expenses Tracking', 'url': '/financial/expenses-tracking' },
      { name : 'Financing', 'url': '/financial/financing' },
];
</script>

<script>

import {router} from "@inertiajs/vue3";

export default {
  data() {
    return {
      
    }
  },
  mounted() {
    // location.reload()
    $('html, body').css({
      overflow: 'auto'
    }).addClass('custom-scrollbar');
  }
}

</script>

