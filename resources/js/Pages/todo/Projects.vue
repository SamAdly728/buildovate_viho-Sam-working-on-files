<template>
  <div>
    <div class="input-group group-style mb-3 mt-3">
      <input class="form-control" type="text" v-model="search" />
      <span class="input-group-text group-text-style"
        ><i class="icon-search"></i
      ></span>
    </div>

    <ul class="cursor-default mt-0">
      <li
        v-for="(item, index) in jobsites"
        :key="index"
        class="btn btn-outline-light truncate-text"
      >
        <vueLink :href="'/todos?type=projects&id=' + item.id">
          {{ item.name }}</vueLink
        >
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { Link as vueLink } from "@inertiajs/vue3";
import { fetchJobsites } from "@/api/api";

const jobsites = ref([]);
const loadingJobsites = ref(false);
const search = ref("");

const getJobsites = async (search) => {
  loadingJobsites.value = true;
  fetchJobsites(search)
    .then((response) => {
      if (response && response.status == "success") {
        const data = response.data.data;

        Object.values(data).map((source) => {
          jobsites.value = [
            ...jobsites.value,
            {
              id: source.jobsite_id,
              name: source.jobsite_name
            }
          ];
        });
      }

      loadingJobsites.value = false;
    })
    .catch((error) => {
      loadingJobsites.value = false;
      console.log("Error", error);
    });
};

const autocomplete = () => {
  console.log("search: ", search.value);
  jobsites.value = [];

  getJobsites(search.value);
};

onMounted(() => {
  console.log("Projects Tab mounted...");
  getJobsites(search.value);
});

watch([search], () => {
  setTimeout(() => {
    autocomplete();
  }, 2000);
});
</script>
