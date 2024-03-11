<script setup>
import { ref, onMounted, watch } from "vue";
import { addTodoRecord } from "@/api/api";
import { toast } from "vue3-toastify";
import VueMultiselect from "vue-multiselect";

const props = defineProps(["entityId", "entityType", "leads", "jobsites"]);
const emits = defineEmits(["reload"]);

const title = ref("");
const description = ref("");
const isAll = ref(true);
const entityType = ref("non-work");
const entityId = ref(null);
const rowOptions = ref([]);
const selectLabel = ref("");
const selectTrackBy = ref("");
const selectPlaceHolder = ref("");
const reminder_date = ref("");

const handleSubmit = () => {
  const payload = {
    entityType: entityType.value,
    title: title.value,
    description: description.value,
    reminder_date: reminder_date.value
  };

  if (!isAll.value) {
    entityId.value = props.entityId;
    payload.entityId = entityId.value;
  }

  if (isAll.value) {
    payload.entityId = null;
    if (entityType.value == "projects") {
      payload.entityId = entityId.value.jobsite_id;
    }

    if (entityType.value == "leads") {
      payload.entityId = entityId.value.lead_id;
    }

    if (entityType.value == "non-work") {
      payload.entityId = 0;
    }
  }

  console.log(payload);

  addTodoRecord(payload)
    .then((response) => {
      // console.log(response);
      if (response && response.status == "success") {
        toast.success(`Successfully added`);
        title.value = "";
        description.value = "";
        reminder_date.value = "";
        emits("reload");
        document.querySelector(".btn-close").click();
      } else {
        toast.error(`Error: Something went wrong. Please try again`);
      }
    })
    .catch((error) => {
      console.log("Error:", error);
    });
};

onMounted(() => {
  if (props.entityId && props.entityType) {
    isAll.value = false;
    entityType.value = props.entityType;
  }
});

watch([entityType], () => {
  // console.log("entityType", entityType.value);
  entityId.value = "";
  if (entityType.value == "projects") {
    rowOptions.value = props.jobsites;
    selectLabel.value = "jobsite_name";
    selectTrackBy.value = "jobsite_id";
    selectPlaceHolder.value = "Select a Project";
    entityId.value = rowOptions.value[0];
  }

  if (entityType.value == "leads") {
    rowOptions.value = props.leads;
    selectLabel.value = "opportunity_title";
    selectTrackBy.value = "lead_id";
    selectPlaceHolder.value = "Select a Lead";
    entityId.value = rowOptions.value[0];
  }
});
</script>

<template>
  <div
    class="modal fade"
    id="addCrew"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div
      class="modal-dialog modal-lg modal-dialog-centered"
      role="document"
      style="max-width: 1000px"
    >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel2">Add To Do</h5>
          <button
            id="btn-close"
            class="btn-close"
            type="button"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="row p-3">
            <div class="col-xl-12">
              <form class="card" method="post" @submit.prevent="handleSubmit">
                <div class="card-header pb-0">
                  <h4 class="card-title mb-0">To Do Information</h4>

                  <div class="card-options">
                    <a
                      class="card-options-collapse"
                      href="#"
                      data-bs-toggle="card-collapse"
                      ><i class="fe fe-chevron-up"></i></a
                    ><a
                      class="card-options-remove"
                      href="#"
                      data-bs-toggle="card-remove"
                      ><i class="fe fe-x"></i
                    ></a>
                  </div>
                </div>
                <div class="card-body">
                  <div
                    v-if="isAll"
                    class="form-group m-checkbox-inline mb-0 custom-radio-ml mb-3 p-2"
                  >
                    <div class="radio radio-primary">
                      <input
                        id="radioinline1"
                        type="radio"
                        v-model="entityType"
                        value="projects"
                        required
                      />
                      <label class="mb-0" for="radioinline1">Projects</label>
                    </div>
                    <div class="radio radio-primary">
                      <input
                        id="radioinline2"
                        type="radio"
                        v-model="entityType"
                        value="leads"
                        required
                      />
                      <label class="mb-0" for="radioinline2">Leads</label>
                    </div>
                    <div class="radio radio-primary">
                      <input
                        id="radioinline3"
                        type="radio"
                        v-model="entityType"
                        value="non-work"
                        required
                      />
                      <label class="mb-0" for="radioinline3">Non-Work</label>
                    </div>
                  </div>

                  <div class="row">
                    <div
                      class="col-xl-12"
                      v-if="isAll && entityType && entityType != 'non-work'"
                    >
                      <div class="mb-3">
                        <VueMultiselect
                          id="select-lead"
                          :placeholder="selectPlaceHolder"
                          :label="selectLabel"
                          :track-by="selectTrackBy"
                          :searchable="true"
                          :close-on-select="true"
                          v-model="entityId"
                          :options="rowOptions"
                        >
                        </VueMultiselect>
                      </div>
                    </div>
                    <div class="col-xl-12">
                      <div class="mb-3">
                        <label class="form-label">Task Name</label>
                        <input
                          class="form-control"
                          type="text"
                          placeholder=""
                          required
                          v-model="title"
                        />
                      </div>
                    </div>
                    <div class="col-xl-12">
                      <div class="mb-3">
                        <label class="form-label">Desciption</label>
                        <textarea
                          class="form-control"
                          placeholder="Type your description"
                          required
                          v-model="description"
                        ></textarea>
                      </div>
                    </div>
                    <div class="col-xl-12">
                      <div class="mb-3">
                        <label class="form-label">Reminder Date</label>
                        <input
                          class="form-control"
                          type="date"
                          placeholder=""
                          required
                          v-model="reminder_date"
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-end">
                  <button class="btn btn-primary" type="submit">Save</button>
                </div>
              </form>
            </div>
          </div>

          <!-- </form> -->
        </div>
      </div>
    </div>
  </div>
</template>
