<template>
  <div class="m-0 p-0 d-flex flex-column gap-3 pb-3" style="height: 100%; max-height: calc(100vh - 98px)">
    <div class="b-primary-v2 b-radius-10 mx-4">
      <div class="d-flex justify-content-between align-items-center px-3 py-2">
        <h5 class="f-16 f-w-600 text-dark m-0 p-0">Financial Health</h5>
        <i class="f-16 f-w-600 icon-info-alt text-primary bigger" style="cursor: pointer"></i>
      </div>

      <div class="d-flex flex-column gap-2 px-3 mt-3 pb-2">
        <template v-for="data in fiveMagicNumber">
          <div class="d-flex flex-column">
            <h5 class="f-12 text-muted f-w-500 m-0 p-0">
              {{ data.name }}: <span class="text-dark f-w-600">{{ formatCurrency(data.amount) }}</span>
            </h5>
            <div class="d-flex gap-2 b-radious-5 align-items-center">
              <div class="bg-main flex-grow-1" style="height: 8px; border-radius: 5px; overflow: hidden">
                <div class="bg-primary" style="height: 8px" :style="{ width: data.percentage + '%' }"></div>
              </div>
              <span class="f-12 text-dark f-w-600">{{ data.percentage }}%</span>
            </div>
          </div>
        </template>
      </div>
    </div>

    <div class="flex-grow-1 d-flex flex-column gap-2 slim-scroll-light px-4" style="overflow: auto">
      <template v-for="menu in sideMenus">
        <Link :href="menu.href">
          <div
            class="px-3 py-2 d-flex gap-3 bg-hover-secondary b-radius-10 align-items-center justify-content-between"
            style="cursor: pointer"
            :class="activeMenu.name === menu.name ? 'bg-secondary-v2 text-white' : 'text-dark'"
            @click="handleMenuClick(menu)"
          >
            <div class="d-flex gap-3">
              <i class="f-16" :class="menu.icon" style="height: 18px"></i>
              <h5 class="m-0 p-0 f-16 f-w-500">{{ menu.name }}</h5>
            </div>
            <i
              :class="activeMenu.name === menu.name ? 'icon-angle-down' : 'icon-angle-right'"
              v-if="menu.sub_menu.length != 0"
            ></i>
          </div>
        </Link>
        <div class="d-flex flex-column" v-if="menu.sub_menu.length != 0">
          <div class="d-flex flex-column mt-1 mb-1" style="margin-left: 33px" v-if="activeMenu.name === menu.name">
            <template v-for="sub_menu in menu.sub_menu">
              <Link :href="sub_menu.href" v-if="sub_menu.href">
                <div
                  class="px-3 py-2 d-flex gap-3 bg-hover-secondary b-radius-10 align-items-center"
                  style="cursor: pointer"
                  :class="activeSubMenu.name === sub_menu.name ? 'bg-secondary-v2 text-white' : 'text-muted'"
                  @click="handleSubMenuClick(sub_menu)"
                >
                  <h5 class="m-0 p-0 f-14 f-w-500">{{ sub_menu.name }}</h5>
                </div>
              </Link>
            </template>
          </div>
        </div>
      </template>
    </div>

    <div class="px-4">
      <Link :href="'/company/users'">
        <div class="px-3 py-2 d-flex gap-3 bg-hover-secondary b-radius-10 align-items-center" style="cursor: pointer">
          <i class="f-16 fi fi-rr-settings" style="height: 18px"></i>
          <h5 class="m-0 p-0 f-16 f-w-500">Manage Users</h5>
        </div>
      </Link>
    </div>
  </div>
</template>
<script>
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

export default {
  components: { Link },
  setup() {
    const page = usePage();
    return { page };
  },
  data() {
    const fiveMagicNumber = [
      { name: "Gross Income", amount: 3500, percentage: 30 },
      { name: "COGS(Job Cost)", amount: 4500, percentage: 40 },
      { name: "Gross Profit", amount: 5500, percentage: 50 },
      { name: "Overhead", amount: 7500, percentage: 70 },
      { name: "Net Profit", amount: 6500, percentage: 60 },
    ];

    const sideMenus = [
      { name: "Dashboard", href: "/dashboard", icon: "fi fi-rr-apps", sub_menu: [] },
      { name: "Metrics", href: "/dashboard/metrics", icon: "fi fi-rr-arrow-trend-up", sub_menu: [] },
      { name: "Portfolio", href: "/dashboard/portfolio", icon: "fi fi-rr-book-alt", sub_menu: [] },
      {
        name: "Buildovate Professionals",
        href: "/dashboard/buildovate-professionals",
        icon: "fi fi-rr-file-user",
        sub_menu: [],
      },
      { name: "Catalog", href: "/dashboard/catalog", icon: "fi fi-rr-chart-simple", sub_menu: [] },
      {
        name: "Company",
        href: "/company/marketing",
        icon: "fi fi-rr-building",
        sub_menu: [
          { name: "Marketing", href: "/company/marketing" },
          { name: "Reports", href: "/company/reports" },
          { name: "Templates", href: "/company/templates" },
          { name: "Follow Up", href: "/company/follow-up" },
          { name: "Reminders", href: "/company/reminders" },
          { name: "Settings", href: "/company/settings" },
        ],

        // sub_menu: [
        //   { name: "Basic Info", href: "/company/details" },
        //   { name: "Hours", href: "/company/details/hours" },
        //   { name: "Monthly Overhead", href: "/company/details/overhead" },
        //   { name: "Phone Numbers", href: "/company/details/numbers" },
        //   { name: "Emails", href: "/company/details/emails" },
        //   { name: "Locations", href: "/company/details/locations" },
        //   { name: "Websites", href: "/company/details/websites" },
        //   { name: "Social Media", href: "/company/details/socials" },
        // ],
      },
      // { name: "Templates", href: "/company/templates", icon: "fi fi-rr-book-alt", sub_menu: [] },
      // { name: "Follow Up", href: "/company/follow-up", icon: "fa-solid fa-plus", sub_menu: [] },
      // { name: "Reports", href: "/company/reports", icon: "fi fi-rr-chart-simple", sub_menu: [] },
      // { name: "Marketing", href: "/company/marketing", icon: "fi fi-rr-arrow-trend-up", sub_menu: [] },
      // {
      //   name: "Buildovate Professionals",
      //   href: "/company/buildovate-professionals",
      //   icon: "fi fi-rr-file-user",
      //   sub_menu: [],
      // },
      // { name: "Portfolio", href: "/company/portfolio", icon: "fi fi-rr-document", sub_menu: [] },
    ];
    const activeMenu = sideMenus[0];
    const activeSubMenu = "";
    return { fiveMagicNumber, sideMenus, activeMenu, activeSubMenu };
  },
  methods: {
    formatCurrency(amount) {
      if (amount) {
        const formatter = new Intl.NumberFormat("en-US", {
          style: "currency",
          currency: "USD",
        });
        return formatter.format(parseFloat(amount).toFixed(2));
      } else {
        return "$0.0";
      }
    },
    handleSubMenuClick(menu) {
      this.activeSubMenu = menu;
    },
    handleMenuClick(menu) {
      this.activeMenu = menu;
      if (this.activeMenu.sub_menu.length != 0) {
        this.activeSubMenu = this.activeMenu.sub_menu[0];
      }
    },
  },
  mounted() {
    this.sideMenus.forEach((menu) => {
      if (menu.sub_menu.length != 0) {
        menu.sub_menu.forEach((sub_menu) => {
          if (sub_menu.href === this.page.url) {
            this.activeSubMenu = sub_menu;
            this.activeMenu = menu;
          }
        });
      } else {
        if (menu.href === this.page.url) {
          this.activeMenu = menu;
        }
      }
    });
  },
};
</script>
