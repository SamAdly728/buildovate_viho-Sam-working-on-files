<script setup>
import { ref, onMounted, watch } from "vue";
import { addTodoRecord } from "@/api/api";
import { toast } from "vue3-toastify";
import VueMultiselect from "vue-multiselect";

import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const editor = ClassicEditor;
const editorData = ref('<p>Initial content</p>');
const editorConfig = {
    // Configuration options go here
};

const props = defineProps(["item"]);
const emits = defineEmits(["reload"]);

const id = ref("");
const title = ref("");
const icon = ref("");
const content = ref(true);
const sequence = ref(true);
const status = ref(true);

const icons = [
    { class: 'bi-alarm', name: 'Alarm' },
    { class: 'bi-align-bottom', name: 'Align Bottom' },
    { class: 'bi-align-center', name: 'Align Center' },
    // Add more icons as needed
];

const handleSubmit = () => {
  console.log(title.value);
};

onMounted(() => {
  console.log(props.item);
  if (props.item) {
    id.value = props.item.id;
    title.value = props.item.title;
    icon.value = props.item.icon;
    content.value = props.item.content;
    sequence.value = props.item.sequence;
    status.value = props.item.status;
  }
});

// watch(, () => {

// });
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
          <h5 class="modal-title" id="exampleModalLabel2">ADD/EDIT Timeline</h5>
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
                  <h4 class="card-title mb-0">Event Information</h4>
                  <div class="card-options">
                    <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse" ><i class="fe fe-chevron-up"></i></a>
                    <a class="card-options-remove" href="#" data-bs-toggle="" card-remove><i class="fe fe-x"></i></a>
                  </div>
                </div>
                <div class="card-body">
                  <!-- Title -->
                  <div class="mb-3">
                      <label for="title" class="form-label">Title</label>
                      <input type="text" class="form-control" id="title" placeholder="Enter title"  v-model="title">
                  </div>
                  <!-- Icon Selection -->
                  <div class="mb-3">
                  <label for="iconSelect" class="form-label"><i class="icon-video-camera"></i> Select Icon</label>
                  <select class="form-select" id="iconSelect" v-model="icon">
                    <option v-for="icon in icons" :key="icon.class" :value="icon.class">
                      <i :class="icon.class">{{ icon.name }}</i>
                    </option>
                  </select>
                  </div>

                   <!-- Content (HTML) -->
                  <div class="mb-3">
                      <label for="contentHtml" class="form-label">Content</label>
                      <!-- <textarea class="form-control" id="contentHtml" rows="3" placeholder="Enter HTML content"></textarea> -->
                      <ckeditor :editor="editor" v-model="content" :config="editorConfig"></ckeditor>
                  </div>

                  <!-- Sequence -->
                  <div class="mb-3">
                      <label for="sequenceNumber" class="form-label">Sequence</label>
                      <input type="number" class="form-control" id="sequenceNumber" placeholder="Enter sequence number">
                  </div>

                  <!-- Status (Toggle) -->
                  <div class="form-check form-switch mb-3">
                      <input class="form-check-input" type="checkbox" id="statusToggle">
                      <label class="form-check-label" for="statusToggle">Status</label>
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
