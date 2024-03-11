<script setup>
import { onMounted, ref } from "vue";
import { markTodo, removeTodo, updateTodoRecord, formatDate } from "@/api/api";
import { toast } from "vue3-toastify";

const props = defineProps(["item"]);
const emits = defineEmits(["reload"]);
const isStrike = ref(false);
const isHide = ref(false);
const isEdit = ref(false);
const title = ref("");
const description = ref("");
const reminder_date = ref("");

const markTodoItem = () => {
  isStrike.value = !isStrike.value;
  let is_completed = isStrike.value ? 1 : 0;

  markTodo(props.item.id, is_completed)
    .then((response) => {
      if (response && response.status == "success") {
        toast.success(`${props.item.title} marked as complete`);
      } else {
        toast.success(`${props.item.title} marked as incomplete`);
      }
    })
    .catch((error) => {
      console.log("Error:", error);
    });
};

const removeTodoItem = () => {
  removeTodo(props.item.id)
    .then((response) => {
      if (response && response.status == "success") {
        // isHide.value = true;
        emits("reload");
        toast.success(`${props.item.title} has been deleted`);
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

const loadDefaults = () => {
  if (props.item) {
    isStrike.value = props.item.is_completed;
    title.value = props.item.title;
    description.value = props.item.description;
    reminder_date.value = props.item.reminder_date;
  }
};
onMounted(() => {
  loadDefaults();
});
</script>

<template>
  <div class="row row-cols-1 row-cols-sm-2 border-bottom mt-3">
    <div class="col-md-10">
      <div class="row row-cols-1 row-cols-sm-2 mb-2">
        <div class="col-sm-12 col-md-3">
          <input
            v-if="isEdit"
            class="form-control mb-2"
            type="text"
            placeholder="Type your task name"
            required
            v-model="title"
          />
          <h6
            v-else
            class="task_title_0 text-black"
            :class="[
              isStrike ? 'text-decoration-line-through' : 'text-decoration-none'
            ]"
          >
            {{ props.item.title }}
          </h6>
        </div>
        <div class="col-sm-12 col-md-6">
          <input
            v-if="isEdit"
            class="form-control"
            type="text"
            placeholder="Type your description"
            required
            v-model="description"
          />
          <p
            v-else
            class="text-secondary"
            :class="[
              isStrike ? 'text-decoration-line-through' : 'text-decoration-none'
            ]"
          >
            {{ props.item.description }}
          </p>
        </div>
        <div class="col-sm-12 col-md-3">
          <input
            v-if="isEdit"
            class="form-control"
            type="date"
            required
            v-model="reminder_date"
          />
          <p
            v-else
            class="text-secondary"
            :class="[
              isStrike ? 'text-decoration-line-through' : 'text-decoration-none'
            ]"
          >
            <span v-if="props.item.reminder_date">
                {{ formatDate(props.item.reminder_date) }}
            </span>
            <span v-else>
              Select Date
            </span>
          </p>
        </div>
      </div>
      <small class="text-capitalize text-primary">
        <span v-if = "props.item.entityType === 'non-work'">
          <strong>{{ props.item.entityType }} </strong>
        </span>
        <span v-else>
          <strong>{{ props.item.entityType }} </strong> : {{ props.item.entityName }}
        </span>
      </small>
    </div>
    <div class="col-6 col-md-2 md:text-right">

      <span class="me-1"><i class="icofont icofont-alarm" style="font-size: 20px"></i></span>

      <a class="me-1" href="#" v-if="!isEdit" @click.prevent="handleEdit"
        ><i class="icofont icofont-pencil-alt-2" style="font-size: 20px"></i
      ></a>

      <a class="me-1" href="#" v-if="!isEdit" @click.prevent="markTodoItem"
        ><i class="icofont icofont-ui-check ms-2" style="font-size: 20px"></i
      ></a>
      <a href="#" v-if="!isEdit" @click.prevent="removeTodoItem"
        ><i class="icofont icofont-trash ms-2" style="font-size: 20px"></i
      ></a>

      <a class="me-1" href="#" v-if="isEdit" @click.prevent="handleUpdate"
        ><i class="icofont icofont-save" style="font-size: 20px"></i
      ></a>

      <a class="ms-2" href="#" v-if="isEdit" @click.prevent="handleClose"
        ><i class="icofont icofont-ui-close" style="font-size: 20px"></i
      ></a>
    </div>
  </div>
</template>
