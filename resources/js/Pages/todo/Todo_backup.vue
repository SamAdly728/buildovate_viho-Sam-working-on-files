<script setup>
import { onMounted, ref, watch } from "vue";
import TodoItem from "@/Pages/todo/list/TodoItem.vue";
import ModalAddTodo from "@/Pages/todo/list/ModalAddToDo.vue";
import { fetchJobsiteRecord, fetchLeadRecord, fetchTodo } from "@/api/api";

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
        // console.log(response.data)
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
          <div class="card mb-0" v-if="item">
            <div class="row gx-5">
              <div class="col">
                <div class="card-header">
                  <div class="">
                    <h5 class="mb-0">{{ item.name }}</h5>
                    <h6 v-if="item.id">{{ item.id }}</h6>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="p-3 text-right">
                  <button
                    type="button"
                    class="btn btn-light"
                    data-bs-toggle="modal"
                    data-original-title="test"
                    data-bs-target="#addCrew"
                    data-bs-original-title=""
                    @click="show = !show"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>
            <div class="p-4">
              <TodoItem
                v-for="(item, index) in items"
                :key="index"
                :item="item"
                @reload="handleReloadPage"
              ></TodoItem>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="p-3 contenttop">
    <div class="ps-0">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#listTab" type="button" role="tab" aria-controls="listTab" aria-selected="true">List</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="kanban-tab" data-bs-toggle="tab" data-bs-target="#kanban" type="button" role="tab" aria-controls="kanban" aria-selected="false">Kanban</button>
        </li>
      </ul>

    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="listTab" role="tabpanel" aria-labelledby="list-tab">
        <div
          class="tab-pane fade active show"
          id="pills-created"
          role="tabpanel"
          aria-labelledby="pills-created-tab"
        >
          <div class="card mb-0" v-if="item">
            <div class="row gx-5">
              <div class="col">
                <div class="card-header">
                  <div class="">
                    <h5 class="mb-0">{{ item.name }}</h5>
                    <h6 v-if="item.id">{{ item.id }}</h6>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="p-3 text-right">
                  <button
                    type="button"
                    class="btn btn-light"
                    data-bs-toggle="modal"
                    data-original-title="test"
                    data-bs-target="#addCrew"
                    data-bs-original-title=""
                    @click="show = !show"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>

            <div class="p-4">
              <TodoItem
                v-for="(item, index) in items"
                :key="index"
                :item="item"
                @reload="handleReloadPage"
              ></TodoItem>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="kanban" role="tabpanel" aria-labelledby="kanban-tab">
        
        <Kanban :lists="lists" :cards="cards" />
        
      </div>
    </div>
    </div>
  </div> -->
  <ModalAddTodo
    v-show="show"
    :entityId="props.id"
    :entityType="props.type"
    @reload="handleReloadPage"
    :leads="props.leads"
    :jobsites="props.jobsites"
  ></ModalAddTodo>
</template>
