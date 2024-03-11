<style>
.sub-menu {
  /* background-color: #93C572 !important; */
  background-color: #ffffff !important;
}

.active-submenu-state {
  /* background-color: #FF5733 !important; */
  font-weight: 900;
}
.sub-menu-items > ul > li:hover {
  /* background-color: #FF5733 !important; */
  background-color: #0047AB !important;
}

.sub-menu-items > ul > li > a{
  display: block;
    width: 100%;
    height: 100%;
    text-decoration: none;
    color: inherit;
    /* Additional link styling */
}

.sub-menu {
  height: auto !important;
}

.sub-menu-items > ul > li {
  position: relative;
  border-radius: 4px;
  margin-right: 20px;
  display: inline-block;
  padding: 10px 15px !important;
}

.sub-menu-items > ul > li > a {
  /* color: white !important; */
  color: black !important;
}

@media (max-width: 1028px) {
  .sub-menu {
      font-size: smaller;  /* Example: reducing the font size */
    }
    .sub-menu-items > ul > li {
      margin-right: 4px;
      padding: 10px 5px !important;
  }
}

@media (min-width: 1029px) and (max-width: 1200px) {
  .sub-menu {
      font-size: 12px;  /* Example: reducing the font size */
    }
    .sub-menu-items > ul > li {
      margin-right: 4px;
      padding: 10px 8px !important;
  }
}
@media  (min-width: 1201px) and (max-width: 1390px) {
  .sub-menu {
      font-size: 14px;  /* Example: reducing the font size */
    }
    .sub-menu-items > ul > li {
      margin-right: 5px;
      padding: 10px 10px !important;
  }
}

</style>
<template>
  <div>
    <ProjectsSubMenu v-if="isProjectsPage && !isTodoPage" />
    <SalesSubMenu v-if="isSalesPage && !isReportsPage" />
    <ProductionSubMenu v-if="isProductionPage" />
    <!--	  <FilesSubMenu v-if="isFilesPage" />-->
    <FinancialsSubMenu v-if="isFinancialsPage" />
    <ReportsSubMenu v-if="isReportsPage"></ReportsSubMenu>
    <TodosSubMenu v-if="isTodoPage" />
    <!-- Uncomment the next line when you are ready to use Breadcrumb component -->
  </div>
</template>

<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

import ProjectsSubMenu from "@/components/sub_menu/Projects.vue";
import SalesSubMenu from "@/components/sub_menu/Sales.vue";
import ProductionSubMenu from "@/components/sub_menu/Production.vue";
import FilesSubMenu from "@/components/sub_menu/Files.vue";
import FinancialsSubMenu from "@/components/sub_menu/Financials.vue";
import ReportsSubMenu from "@/components/sub_menu/Reports.vue";
import TodosSubMenu from "@/components/sub_menu/Todos.vue";
// Uncomment the next line when you are ready to use Breadcrumb component

import { ref, watch } from 'vue';

const page = usePage();
// console.log("pageee", page);

const isProjectsPage = computed(() => page.url.includes("projects"));
const isSalesPage = computed(() => page.url.includes("sales"));
const isProductionPage = computed(() => page.url.includes("production"));
// const isFilesPage = computed(() => page.url.includes('files'));
const isFinancialsPage = computed(() => page.url.includes("financials"));
const isReportsPage = computed(() => page.url.includes("reports"));
const isSubmenuPage = computed(() => page.url.split("/").length >= 3);
const isTodoPage = computed(() => page.url.includes("todos"));
const exceptions = computed(
  () =>
    (isProjectsPage.value || isSalesPage.value || isProductionPage.value || isTodoPage.value) &&
    isSubmenuPage.value
);
const showHeader = computed(
  () =>
    exceptions.value &&
    (isProjectsPage.value ||
      isSalesPage.value ||
      isProductionPage.value ||
      isFinancialsPage.value || 
      isTodoPage.value)
);

defineProps(["pageTitle"]);

watch(page, (url, u) => {
  const navLinks = document.querySelectorAll('li a');
  navLinks.forEach(link => {
    
    let parent = link.parentElement.parentElement.parentElement
    if(link.getAttribute('href') && u.url){
      if ((link.getAttribute('href').trim() === u.url.trim()) && parent.classList.contains('sub-menu-items')) {
        link.parentElement.classList.add('active-submenu-state');
      } else {
        link.parentElement.classList.remove('active-submenu-state');
      }
    }
  });
})

</script>
