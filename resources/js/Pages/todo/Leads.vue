<template>
  <div>
    <div class="input-group group-style mb-3 mt-3">
      <input class="form-control" type="text" v-model="search" />
      <span class="input-group-text group-text-style"
        ><i class="icon-search"></i
      ></span>
    </div>

    <ul class="cursor-default mt-0 overflow-scroll leads-list">
      <li
        v-for="(item, index) in rowData"
        :key="index"
        class="btn btn-outline-light truncate-text"
      >
        <vueLink :href="'/todos?type=leads&id=' + item.id">
          {{ item.name }}</vueLink
        >
      </li>
      <li v-if="has_next_page" class="text-center">
        <a href="#" @click.prevent="loadMore">load more...</a>
      </li>
    </ul>
  </div>
</template>

<style scope>
.leads-list {
  height: 600px;
}
</style>

<script setup>
import { ref, onMounted, watch } from "vue";
import { Link as vueLink } from "@inertiajs/vue3";
import { fetchLeads } from "@/api/api";

const loadingLeads = ref(false);
const pageNumber = ref(1);
const rowData = ref([]);
const has_next_page = ref(false);
const search = ref("");

const loadMore = () => {
  pageNumber.value = pageNumber.value + 1;
  getLeads();
};
const getLeads = async () => {
  loadingLeads.value = true;
  fetchLeads(pageNumber.value, search.value)
    .then((response) => {
      if (response && response.status == "success") {
        has_next_page.value = response.data.next_page_url ? true : false;
        const data = response.data.data;

        Object.values(data).map((source) => {
          rowData.value = [
            ...rowData.value,
            {
              id: source.lead_id,
              name: source.opportunity_title
            }
          ];
        });
      }
      loadingLeads.value = false;
    })
    .catch((error) => {
      loadingLeads.value = false;
      console.log(error);
    });
};

const autocomplete = () => {
  console.log("search: ", search.value);
  rowData.value = [];
  pageNumber.value = 1;
  getLeads();
};

onMounted(() => {
  getLeads();
});

watch([search], () => {
  setTimeout(() => {
    autocomplete();
  }, 2000);
});
</script>
