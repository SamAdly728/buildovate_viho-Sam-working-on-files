<script setup>
import { ref, watch, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import ProjectsTab from "@/Pages/todo/Projects.vue";
import LeadsTab from "@/Pages/todo/Leads.vue";
import { Link as vueLink } from "@inertiajs/vue3";

const page = usePage();
const tab = ref(1);
const isAll = ref(true);
const entityId = ref(null);

const handClickAll = () => {
  isAll.value = true;
};

const handClickTab = (num) => {
  tab.value = num;
  isAll.value = false;
};

watch([tab], () => {
  if (tab.value !== 3) {
    isAll.value = false;
  }
});

onMounted(() => {
  entityId.value = page.props.id;
  if (entityId.value) {
    isAll.value = false;
  }

  if (page.props.type == "projects") {
    tab.value = 1;
  }

  if (page.props.type == "leads") {
    tab.value = 2;
  }
});
</script>

<template>
  <!-- Page Sidebar Start-->
  <Transition name="slide-fade">
    <header
      v-show="page.props.style.sidebar"
      class="main-nav"
      :style="page.props.style.sidebar_opacity"
    >
      <div>
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
          <a
            class="nav-link"
            :class="tab == 1 && !isAll ? 'active' : ''"
            href="#"
            @click.prevent="handClickTab(1)"
            >Projects</a
          >

          <a
            class="nav-link"
            :class="tab == 2 && !isAll ? 'active' : ''"
            href="#"
            @click.prevent="handClickTab(2)"
            >Leads</a
          >

          <vueLink
            :href="'/todos'"
            class="nav-link"
            :class="isAll ? 'active' : ''"
            @click.prevent="handClickAll"
          >
            All</vueLink
          >
        </ul>
      </div>

      <div class="p-3">
        <ProjectsTab v-show="tab == 1"></ProjectsTab>
        <LeadsTab v-show="tab == 2"></LeadsTab>
      </div>
    </header>
  </Transition>
  <!-- Page Sidebar Ends-->
</template>
