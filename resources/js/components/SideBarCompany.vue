<style>
/* .fade-enter-active,
.fade-leave-active {
  transition: opacity 2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
} */

/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-fade-enter-active {
  transition: all 0.5s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}

.active {
  text-decoration: none !important;
}
#custom-datepicker .datepicker {
  width: 267px !important;
  border-radius: 0 !important;
  -webkit-box-shadow: none !important;
  -moz-box-shadow: none !important;
  box-shadow: none !important;
}

.dp__outer_menu_wrap {
  width: 289px !important;
}
.dp__action_row {
  display: none;
}
.dp__theme_light {
  border-color: transparent;
}
</style>

<template>
  <!-- Page Sidebar Start-->
  <Transition name="slide-fade">
    <header v-show="page.props.style.sidebar" class="main-nav" :style="page.props.style.sidebar_opacity">
      <div id="user" class="sidebar-user text-center">
        <!-- TABLE  -->

        <div class="row row-grid fs-sm p-0 border border-faded text-end">
          <div class="col-6">
            <div class="text-left py-1 px-1">
              <p class="mb-0 fw-700">Gross Income</p>
            </div>
          </div>
          <div class="col-4">
            <div class="text-right py-1 px-1">
              <p class="mb-0 fw-700 text-muted">$0.00</p>
            </div>
          </div>
          <div class="col-2">
            <div class="text-center py-1">
              <p class="mb-0 fw-700 text-muted">0%</p>
            </div>
          </div>
          <div class="col-6">
            <div class="text-left py-1 px-1">
              <p class="mb-0 fw-700">COGS (Job Cost)</p>
            </div>
          </div>
          <div class="col-4">
            <div class="text-right py-1 px-1">
              <p class="mb-0 fw-700 text-muted">$0.00</p>
            </div>
          </div>
          <div class="col-2">
            <div class="text-center py-1">
              <p class="mb-0 fw-700 text-muted">0%</p>
            </div>
          </div>
          <div class="col-6">
            <div class="text-left py-1 px-1">
              <p class="mb-0 fw-700">Gross Profit</p>
            </div>
          </div>
          <div class="col-4">
            <div class="text-right py-1 px-1">
              <p class="mb-0 fw-700 text-muted">$0.00</p>
            </div>
          </div>
          <div class="col-2">
            <div class="text-center py-1">
              <p class="mb-0 fw-700 text-muted">0%</p>
            </div>
          </div>
          <div class="col-6">
            <div class="text-left py-1 px-1">
              <p class="mb-0 fw-700">Overhead</p>
            </div>
          </div>
          <div class="col-4">
            <div class="text-right py-1 px-1">
              <p class="mb-0 fw-700 text-muted" id="left-overhead-total">$30,000.00</p>
            </div>
          </div>
          <div class="col-2">
            <div class="text-center py-1">
              <p class="mb-0 fw-700 text-muted">0%</p>
            </div>
          </div>
          <div class="col-6">
            <div class="text-left py-1 px-1">
              <p class="mb-0 fw-700">Net Profit</p>
            </div>
          </div>
          <div class="col-4">
            <div class="text-right py-1 px-1">
              <p class="mb-0 fw-700 text-muted">$0.00</p>
            </div>
          </div>
          <div class="col-2">
            <div class="text-center py-1">
              <p class="mb-0 fw-700 text-muted">0%</p>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="main-navbar">
          <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
          <div id="mainnav">
            <ul class="nav-menu custom-scrollbar">
              <li class="back-btn">
                <div class="mobile-back text-end">
                  <span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                </div>
              </li>
              <li v-for="l in companyPages" :key="l.name">
                <Link class="nav-link menu-title" :href="l.href" :vficon="l.vficon" :name="l.name"> </Link>
              </li>
            </ul>
          </div>
          <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
      </nav>
    </header>
  </Transition>
  <!-- Page Sidebar Ends-->
</template>

<script setup>
import Link from "@/components/Link.vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const companyPages = [
  { name: "Company Details", href: "/company/details", vficon: "sliders" },
  { name: "Templates", href: "/company/templates", vficon: "book-open" },
  { name: "Reports", href: "/company/reports", vficon: "bar-chart-2" },
  { name: "Marketing", href: "/company/marketing", vficon: "trending-up" },
  { name: "Manage Users", href: "/company/users", vficon: "user-check" },
  { name: "Buildovate Professionals", href: "/company/buildovate-professionals", vficon: "tool" },
  { name: "Portfolio", href: "/company/portfolio", vficon: "file-minus" },
];
</script>
