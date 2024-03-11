<template>
  <div class="container-fluid  pt-0">
    <div class="row">
      <!-- <div class="col-md-12">
        <div class="d-flex justify-content-center">
          <ul class="nav nav-tabs" role="tablist" style="border-bottom: none !important;">
            <li class="nav-item" v-for="(tab, index) in tabs" :key="index">
              <a 
                class="nav-link p-2" :class="{ active: activeTab === tab.event }" data-toggle="tab" href="#" role="tab" 
                @click.prevent="activeTab = tab.event"
              >
                {{ tab.name }}
              </a>
            </li>
          </ul>
        </div>
      </div> -->
      
      <div class="col-md-12 mt-3 mx-3">
        <div  class="d-flex justify-content-center" style="gap: 1px;">
          <button class="btn btn-primary-v2">Today</button>
          <button class="btn btn-primary-v2">Upcoming</button>
          <button class="btn btn-primary-v2">Reminders</button>
          <button class="btn btn-primary-v2">Overdue</button>
          <button class="btn btn-primary-v2">Completed</button>
        </div>
      </div>
      <div class="col-md-12">
        <div style="display: flex; gap: 5px;">
            <button class="btn btn-primary-v2 mt-2" @click="filterPage('all');"> All </button>
            <button class="btn btn-primary-v2 mt-2" @click="filterPage('projects')"> Projects </button>
            <button class="btn btn-primary-v2 mt-2" @click="filterPage('leads')"> Leads </button>
        </div>
        <div class="card">
          <div class="d-flex justify-content-between align-items-center m-4">
            <h4><strong>{{ filterTitle }}</strong></h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-original-title="test" data-bs-target="#AddTodoModal" data-bs-original-title="">+ Add</button>
          </div>

          <table class="table mb-4 mx-6">
            <thead>
              <tr>
                <th scope="col">Card</th>
                <th scope="col">List</th>
                <th scope="col">Description</th>
                <th scope="col">Labels</th>
                <th scope="col">Members</th>
                <th scope="col">Due Date</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id" style="background-color:#f5f9ff; border: 1px solid #f5f9ff;border-radius: 15px;">
                <td>
                  <h6 :class="[item.is_completed ? 'text-decoration-line-through' : 'text-decoration-none']">{{ item.title }} </h6>
                </td>
                <td>
                  <span v-if = "item.entityType === 'non-work'">
                    <h6 class="card-title"  :class="[item.is_completed ? 'text-decoration-line-through' : 'text-decoration-none']">{{ item.entityType }}</h6>
                  </span>
                  <span v-else>
                    <h6 class="card-title"  :class="[item.is_completed ? 'text-decoration-line-through' : 'text-decoration-none']">{{ item.entityType }} : {{ item.entityName }}</h6>
                  </span>
                </td>
                <td>
                  <p class="card-text" :class="[item.is_completed ? 'text-decoration-line-through' : 'text-decoration-none']">{{ item.description }}</p>
                </td>
                <td>{{ item.labels }}</td>
                <td>{{ item.members }}</td>
                <td>                    
                  <div  :class="[item.is_completed ? 'text-decoration-line-through' : 'text-decoration-none']">
                    {{ formatDate(item.due_date) }}
                  </div>
                </td>
                <td>
                  <a class="me-2" href="javascript:void(0)" @click="editItem(item)">
                    <i class="icofont icofont-pencil-alt-2" style="font-size: 15px"></i> Edit
                  </a>

                  <a class="me-2" href="#" @click="markTodoItem(item)">
                    <i class="icofont icofont-ui-check ms-2" style="font-size: 15px"></i>
                  </a>
                  <a class="me-2" href="javascript:void(0)" data-bs-toggle="modal" :data-bs-target="'#cardModal'+item.id">
                    <i class="icofont icofont-pencil-alt-2" style="font-size: 15px"></i>
                  </a>
                  <a class="me-2" href="#" @click="handleEdit(item)">
                    <i class="icofont icofont-alarm" style="font-size: 15px"></i>
                  </a>
                  <a href="#" @click="removeTodoItem(item)">
                    <i class="icofont icofont-trash ms-2" style="font-size: 15px"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>

          <div class="modal fade" id="itemCardModal" tabindex="-1" aria-labelledby="itemCardModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-body">
                  <CardDetail :card="selectedItem" :list_title="selectedItem.title"/>
                </div>
              </div>
            </div>
          </div>
          <!-- <div v-for="item in items" :key="item.id">
            <div class="modal fade" :id="'cardModal'+item.id" tabindex="-1" aria-labelledby="cardModal" aria-hidden="true" style="display: none;">
              <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                  <div class="modal-body">
                    <CardDetail :card="item" :list_title="item.title"/>
                  </div>
              </div>
              </div>
            </div>
          </div> -->
          <!-- <div v-for="item in items" :key="item.id" class="card mb-3 mx-4"  style="background-color:#f5f9ff; border: 1px solid #f5f9ff;border-radius: 15px;">
            <div class="card-body p-4">
              <div class="row">
                <div class="col-md-3">
                  <h6 :class="[item.is_completed ? 'text-decoration-line-through' : 'text-decoration-none']"
                    >{{ item.title }} </h6>
                </div>
                <div class="col-md-9">
                  <div class="d-flex justify-content-between">
                    <div class="me-4">
                      <span v-if = "item.entityType === 'non-work'">
                        <h6 class="card-title"  :class="[item.is_completed ? 'text-decoration-line-through' : 'text-decoration-none']">{{ item.entityType }}</h6>
                      </span>
                      <span v-else>
                        <h6 class="card-title"  :class="[item.is_completed ? 'text-decoration-line-through' : 'text-decoration-none']">{{ item.entityType }} : {{ item.entityName }}</h6>
                      </span>
                      <p class="card-text" :class="[item.is_completed ? 'text-decoration-line-through' : 'text-decoration-none']">{{ item.description }}</p>
                    </div>
                    <div  :class="[item.is_completed ? 'text-decoration-line-through' : 'text-decoration-none']">
                      <small class="text-muted">Due by: </small>{{ formatDate(item.due_date) }}
                    </div>
                  </div>
                  <div class="d-flex justify-content-end">
                    <a class="me-1" href="#" @click="markTodoItem(item)"
                      ><i class="icofont icofont-ui-check ms-2" style="font-size: 15px"></i
                    ></a>
                    
                    <a class="me-1" href="javascript:void(0)" data-bs-toggle="modal" :data-bs-target="'#cardModal'+item.id"
                      ><i class="icofont icofont-pencil-alt-2" style="font-size: 15px"></i
                    ></a>

                    <a class="me-1" href="#" @click="handleEdit(item)"
                      ><i class="icofont icofont-alarm" style="font-size: 15px"></i></a>

                    <a href="#" @click="removeTodoItem(item)"
                      ><i class="icofont icofont-trash ms-2" style="font-size: 15px"></i
                    ></a>
                  </div>
                </div>
              </div>

              <div class="modal fade" :id="'cardModal'+item.id" tabindex="-1" aria-labelledby="cardModal" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                      <CardDetail :card="item" :list_title="item.title"/>
                    </div>
                </div>
                </div>
              </div>


            </div>
          </div> -->
        </div>
      </div>
    </div>

    <div class="modal fade" id="AddTodoModal" tabindex="-1" aria-labelledby="cardModal" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
          <div class="modal-body">
            <AddTodo     
              :entityId="props.id"
              :entityType="props.type"
              @reload="handleReloadPage"
              :leads="props.leads"
              :jobsites="props.jobsites">
            </AddTodo>
          </div>
      </div>
      </div>
    </div>
  </div>
  
</template>

<script setup>
import CardDetail from '@/Pages/todo/kanban/CardDetail.vue';
import { onMounted, ref, watch } from "vue";
import TodoItem from "@/Pages/todo/list/TodoItem.vue";
// import ModalAddToDo from "@/Pages/todo/list/ModalAddToDo.vue";
import AddTodo from "@/Pages/todo/list/AddTodo.vue";
import { fetchJobsiteRecord, fetchLeadRecord, fetchTodo,markTodo, removeTodo, updateTodoRecord, formatDate } from "@/api/api";
import { toast } from "vue3-toastify";

const props = defineProps(["type", "id", "leads", "jobsites"]);
const item = ref(null);
const show = ref(false);
const reloadPage = ref(false);
const items = ref([]);
const lists = ref([{id:1, title:"non-work"},{id:1, title:"leads"},{id:1, title:"projects"}]);

const emits = defineEmits(["reload"]);
const isStrike = ref(false);
const isHide = ref(false);
const isEdit = ref(false);
const title = ref("");
const description = ref("");
const reminder_date = ref("");
const filter = ref("all");
const filterTitle = ref("All");

// const activeTab = ref('all');
// const tabs = ref([
//         { name: 'Today', event: 'all', icon: 'icon-menu', content: 'Content for All' },
//         { name: 'Upcoming', event: 'notes', icon: 'icon-notepad', content: 'Content for Notes' },
//         { name: 'Reminders', event: 'emails', icon: 'icon-email', content: 'Content for Emails' },
//         { name: 'Overdue', event: 'messages', icon: 'icon-comment', content: 'Content for Messages' },
//         { name: 'Completed', event: 'calls', icon: 'icon-headphone-alt', content: 'Content for Calls' },
//       ]);

const selectedItem = ref([]);

const editItem = (item) => {
  selectedItem.value = item;
  const modal = new bootstrap.Modal(document.getElementById('itemCardModal'));
  modal.show();
};

const markTodoItem = (item) => {

  console.log("Completed? : " +  item.is_completed);
  let is_completed = item.is_completed;

  if(is_completed == 1){
    is_completed = 0;
  }else{
    is_completed = 1;
  }

  item.is_completed = is_completed;
  
  console.log("After Toggle? : " +  is_completed);

  markTodo(item.id, is_completed)
    .then((response) => {
      console.log(response);
      if (response) {
        handleReloadPage();
        toast.success(`${item.title} marked as complete`);
      } else {
        toast.success(`${item.title} marked as incomplete`);
      }
    })
    .catch((error) => {
      console.log("Error:", error);
    });
};

const removeTodoItem = (item) => {
  removeTodo(item.id)
    .then((response) => {
      if (response && response.status == "success") {
        // isHide.value = true;
        handleReloadPage();
        toast.success(`${item.title} has been deleted`);
      }
    })
    .catch((error) => {
      console.log("Error:", error);
    });
};

const handleEdit = () => {
  isEdit.value = true;
};

const handleUpdate = () => {
  isEdit.value = false;
  const payload = {
    title: title.value,
    description: description.value,
    reminder_date: reminder_date.value
  };

  updateTodoRecord(props.item.id, payload)
    .then((response) => {
      console.log(response);
      emits("reload");
    })
    .catch((error) => {
      console.log(error);
    });
};

const handleClose = () => {
  isEdit.value = false;
  loadDefaults();
};

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
  fetchTodo(0, filter.value)
    .then((response) => {
      if (response && response.status == "success") {
        console.log("getAllUserTodo")
        console.log(response.data)
        items.value = response.data
      }
    })
    .catch((error) => {
      console.log("Error:", error)
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

const filterPage = (type) => {
  filter.value = type;
  if(type == 'projects'){
    filterTitle.value = "Projects"
  }else if(type == 'leads'){
    filterTitle.value = "Leads"
  }else{
    filterTitle.value = "All"
  }
  loadDefaults();
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

<style scoped>
.btn-primary {
  background-color: #1e5bb2 !important;
  border-color: #1e5bb2 !important;
}
.bg-light {
  background-color: #f8f9fa !important; /* Light background for the left column */
}

.badge-secondary {
  background-color: #6c757d; /* Or any color you prefer */
  padding: 0.5em 0.75em;
  font-size: 1em; /* Adjust size as needed */
}

.card-title {
  color: #007bff; /* Or the color you want for the title */
  margin-bottom: 0.5rem;
}

.card-subtitle {
  color: #6c757d; /* Or the color you want for the subtitle */
  margin-bottom: 0.75rem;
}

.card-text {
  margin-bottom: 1rem;
}

.icon {
  display: inline-block;
  width: 24px;
  height: 24px;
  text-align: center;
}

.nav-tabs .nav-link {
  /* border: none !important; */
  color: #000000 !important;
  font-size: 16px !important;
}

.nav-tabs .nav-link:hover {
  border: none !important;
}

.nav-tabs .nav-link.active {
  color: white !important;
  font-weight: bold !important;
  background-color: #1e5bb2 !important;
  border-bottom: 1px solid !important;
}
.nav-tabs {
  border-bottom: 1px solid #b3b4b6 !important;
}
</style>
