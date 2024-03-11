<script setup>
import { onMounted, ref, watch } from "vue";
import ModalAddTodo from "@/Pages/todo/list/ModalAddToDo.vue";
import { fetchJobsiteRecord, fetchLeadRecord, fetchTodo } from "@/api/api";

import Kanban from '@/Pages/todo/kanban/KanbanItem.vue';

const props = defineProps(["type", "id", "leads", "jobsites"]);
const item = ref(null);
const show = ref(false);
const reloadPage = ref(false);
const items = ref([]);
const lists = ref([{id:1, title:"non-work"},{id:1, title:"leads"},{id:1, title:"projects"}]);
const cards = ref([]);

const fetchJobsites = async () => {
  fetchJobsiteRecord(props.id)
    .then((response) => {
      if (response && response.status == "success") {
        let record = response.data.data[0];
        item.value = {
          id: record.jobsite_id,
          name: record.jobsite_name
        };

        getEntityTodo();
      }
    })
    .catch((error) => {
      console.log("Error:", error);
    });
};

const fetchLeads = async () => {
  fetchLeadRecord(props.id)
    .then((response) => {
      if (response && response.status == "success") {
        let record = response.data.data[0];
        item.value = {
          id: record.lead_id,
          name: record.opportunity_title
        };

        getEntityTodo();
      }
    })
    .catch((error) => [console.log("Error:", error)]);
};

const getEntityTodo = () => {
  fetchTodo(props.id, props.type)
    .then((response) => {
      if (response && response.status == "success") {
        // console.log(response.data)
        items.value = response.data;
      }
    })
    .catch((error) => {
      console.log("Error:", error);
    });
};

const getAllUserTodo = () => {
  fetchTodo(0, "all")
    .then((response) => {
      if (response && response.status == "success") {
        console.log(response.data)
        items.value = response.data;
        cards.value = response.cards;
      }
    })
    .catch((error) => {
      console.log("Error:", error);
    });
};

const loadDefaults = () => {
  if (props.type == "projects") {
    fetchJobsites();
  }

  if (props.type == "leads") {
    fetchLeads();
  }

  if (!props.id && !props.type) {
    console.log("all");
    getAllUserTodo();

    item.value = {
      id: null,
      name: "All"
    };
  }
};

const handleReloadPage = () => {
  reloadPage.value = true;
  setTimeout(() => {
    reloadPage.value = false;
  }, 2000);
};

onMounted(() => {
  loadDefaults();
});

watch([reloadPage], () => {
  if (reloadPage.value) {
    loadDefaults();
  }
});
</script>

<template>
      <div class="container-fluid  pt-5">
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-10">
                        <Kanban :lists="lists" :cards="cards" />
                    </div>
                </div>
            </div>
        </div>

    </div>
<!-- 
  <ModalAddTodo
    v-show="show"
    :entityId="props.id"
    :entityType="props.type"
    @reload="handleReloadPage"
    :leads="props.leads"
    :jobsites="props.jobsites"
  ></ModalAddTodo> -->
</template>

<style scoped>
.btn-primary {
  background-color: #1e5bb2 !important;
  border-color: #1e5bb2 !important;
}

</style>
