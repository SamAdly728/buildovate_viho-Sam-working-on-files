<template>
  <div>
    <!-- Use a conditional rendering to show/hide the modal -->
    <form @submit.prevent="submitForm">
      <div
        v-if="showModal"
        class="modal-edit-drip d-flex justify-content-end"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-modal="true"
        style="display: block"
        @click="closeModal"
      >
        <div class="modal-container" @click.stop="">
          <div class="modal-header m-4 px-4 d-flex flex-row align-items-center">
            <h1 class="fs-5" id="exampleModalLabel">Edit Follow Up</h1>
            <button type="button" class="border-0 bg-transparent text-muted fs-5" @click="closeModal">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>

          <!-- modal body  -->
          <div class="modal-body px-4 overflow-auto mx-4">
            <div class="row mb-5">
              <!-- name  -->
              <div class="col-4 border border-light p-2">
                <label class="form-label">Name</label>
              </div>
              <div class="col-8 border border-light p-2">
                <div class="mb-3">
                  <input type="text" class="form-control" v-model="formData.drip_name" />
                  <small v-if="v$.drip_name.$invalid && v$.drip_name.$dirty" class="error-message">this field is required</small>
                </div>
              </div>

              <!-- send  -->
              <div class="col-4 border border-light p-2">
                <label class="form-label">Send</label>
              </div>
              <div class="col-8 border border-light p-2">
                <div class="form-check text-nowrap">
                  <input class="form-check-input me-2" type="checkbox" v-model="sendImmediately" />
                  <label class="form-check-label m-0 text-muted fw-light text-nowrap">Send Immediately</label>
                </div>
                <div class="input-group">
                  <input
                    type="number"
                    class="form-control"
                    style="width: 70%"
                    v-model="formData.send_number"
                    :disabled="sendImmediately"
                  />
                  <select class="form-select" v-model="formData.send_type" style="width: 30%" :disabled="sendImmediately">
                    <option selected value="days">Day(s)</option>
                    <option value="hrs">Hour(s)</option>
                    <option value="mins">Minute(s)</option>
                  </select>
                  <small
                    v-if="
                      !sendImmediately &&
                      (v$.send_number.$invalid || v$.send_type.$invalid) &&
                      (v$.send_number.$dirty || v$.send_type.$dirty)
                    "
                    class="error-message"
                  >
                    this field is required
                  </small>
                </div>
              </div>

              <!-- Type  -->
              <div class="col-4 border border-light p-2">
                <label class="form-label">Type</label>
              </div>
              <div class="col-8 border border-light p-2">
                <select class="form-select" v-model="formData.type">
                  <option selected value="Email">Email</option>
                  <option value="SMS Message">SMS Message</option>
                  <option value="Both">Both</option>
                </select>
                <small v-if="v$.type.$invalid && v$.type.$dirty" class="error-message">this field is required</small>
              </div>

              <!-- SMS Message  -->
              <div class="col-4 border border-light p-2" v-if="formData.type !== 'Email'">
                <label class="form-label mb-3">SMS Message</label>
                <button class="btn btn-primary-v2">
                  <small>Preview SMS</small>
                </button>
              </div>
              <div class="col-8 border border-light p-2" v-if="formData.type !== 'Email'">
                <textarea class="form-control mb-2" placeholder="Your message here" v-model="formData.sms_msg"></textarea>
                <small v-if="v$.type.$invalid && v$.type.$dirty" class="error-message">this field is required</small>
                <div class="mb-3 col-md-12">
                  <label class="form-label f-w-600">Preview</label>
                  <div class="b-r-5 p-4" style="background-color: #d6d6d6; height: auto">
                    <label v-if="formData.sms_msg == ''">Type Anything to the content</label>
                    <SMSChatBubble :message="formData.sms_msg" v-else />
                  </div>
                </div>
              </div>

              <!-- email subject  -->
              <div class="col-4 p-2" v-if="formData.type !== 'SMS Message'" style="border: 1px solid #e8eaed; border-bottom: 0">
                <label class="form-label">Email Subject</label>
              </div>
              <div class="col-8 p-2" v-if="formData.type !== 'SMS Message'" style="border: 1px solid #e8eaed; border-bottom: 0">
                <div class="mb-3">
                  <input type="text" class="form-control" v-model="formData.email_subject" />
                  <small
                    v-if="formData.type !== 'SMS Message' && v$.email_subject.$invalid && v$.email_subject.$dirty"
                    class="error-message"
                  >
                    this field is required
                  </small>
                </div>
              </div>

              <!-- email body  -->
              <div class="col-4 p-2" v-if="formData.type !== 'SMS Message'" style="border: 1px solid #e8eaed; border-top: 0">
                <label class="form-label mb-3">Email Body</label>
                <button class="btn btn-primary-v2">
                  <small>Preview Email</small>
                </button>
              </div>
              <div
                class="col-8 pt-3"
                v-if="formData.type !== 'SMS Message'"
                style="border: 1px solid #e8eaed; border-top: 0; padding-bottom: 100px"
              >
                <quill-editor
                  class="custom-quill-container"
                  style="max-height: 300px"
                  theme="snow"
                  v-model:content="formData.email_body"
                  content-type="html"
                ></quill-editor>
                <small
                  v-if="formData.type !== 'SMS Message' && v$.email_body.$invalid && v$.email_body.$dirty"
                  class="error-message"
                >
                  this field is required
                </small>
              </div>

              <!-- active  -->
              <div class="col-4 border border-light p-2">
                <label class="form-label">Active</label>
              </div>
              <div class="col-8 border border-light p-2">
                <label class="toggle-switch">
                  <input type="checkbox" v-model="formData.active" />
                  <div class="toggle-switch-background">
                    <div class="toggle-switch-handle"></div>
                  </div>
                </label>
              </div>
            </div>

            <CopyKeywords></CopyKeywords>
          </div>

          <div class="m-4 px-4 d-flex justify-content-between">
            <div>
              <button type="button" class="btn btn-danger" @click="deleteRecord">Delete</button>
            </div>
            <div class="d-flex flex-row gap-3">
              <button type="button" class="btn btn-light" @click="closeModal">Close</button>
              <button type="submit" class="btn btn-primary-v2">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <!-- Overlay to cover the background when the modal is open -->
    <div v-if="showModal" class="modal-backdrop fade show"></div>
  </div>
</template>
<script setup>
import { ref, computed, watchEffect, onMounted, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import axios from "axios";
import { QuillEditor } from "@vueup/vue-quill";
import SMSChatBubble from "../components/SMSChatBubble.vue";
import emailContentHTML from "../../assets/follow-up/emai-body-html";
import CopyKeywords from "../components/CopyKeywords.vue";

const props = defineProps(["showModal", "data"]);
const emits = defineEmits(["close"]);

const closeModal = () => {
  emits("close");
};

const sendImmediately = ref(true);

const formData = ref({
  drip_name: "",
  send_number: "",
  send_type: "",
  type: "",
  email_subject: "",
  sms_msg: "",
  active: "",
  email_body: "",
});

const rules = () => ({
  drip_name: { required },
  send_number: sendImmediately.value ? {} : { required },
  send_type: sendImmediately.value ? {} : { required },
  type: { required },
  email_subject: formData.value.type === "SMS Message" ? {} : { required },
  email_body: formData.value.type === "SMS Message" ? {} : { required },
  sms_msg: formData.value.type === "Email" ? {} : { required },
  active: {},
});

const v$ = useVuelidate(rules, formData);

onMounted(() => {});

// Watch for changes in sendImmediately and trigger revalidation
watchEffect(sendImmediately, formData, () => {
  v$.value.$reset();
});

watchEffect(() => {
  if (props.data) {
    // Ensure props.data exists and is not null
    formData.value.drip_name = props.data.drip_name;
    formData.value.type = props.data.type;
    formData.value.email_subject = props.data.email_subject;
    formData.value.email_body = props.data.email_body;
    formData.value.sms_msg = props.data.sms_msg;
    formData.value.active = props.data.active;

    if (props.data.send_time === 0) {
      sendImmediately.value = true;
    } else {
      sendImmediately.value = false;
      let send_time = props.data.send_time;
      let send_number;
      let send_type;

      if (send_time < 60) {
        send_number = send_time;
        send_type = "mins";
      } else if (send_time < 1440) {
        send_number = Math.floor(send_time / 60);
        send_type = "hrs";
      } else {
        send_number = Math.floor(send_time / 1440);
        send_type = "days";
      }

      formData.value.send_number = send_number;
      formData.value.send_type = send_type;
    }
  }
  console.log(formData.value.email_body, "hey");
});

const headers = {
  "Content-Type": "multipart/form-data",
  //   Authorization: "Bearer YourAccessToken",
};

async function submitForm() {
  // const deltaContent = this.$refs.quillEditor.getContents();
  console.log(formData.value.email_body, "hey");

  // v$.value.$touch(); // This will trigger validation on all fields

  // // Check if the form is valid
  // if (v$.value.$pending || v$.value.$error) {
  //   console.log("Form validation failed");
  //   return;
  // }

  // Iterate over the form data object and append each field to the FormData
  for (const field in formData.value) {
    if (field === "email_body") {
      form.append(field, JSON.stringify(emailContentDelta));
    } else {
      form.append(field, formData.value[field]);
    }
  }
  form.append("sequence_id", props.data.sequence_id);
  form.delete("send_number");
  form.delete("send_type");
  if (sendImmediately.value) {
    form.append("send_time", 0);
  } else {
    const send = convertToMinutes(formData.value.send_number, formData.value.send_type);
    form.append("send_time", send);
  }

  // // Iterate over the form data object and append each field to the FormData
  // for (const field in formData.value) {
  //   if (field === "email_body") {
  //     form.append(field, JSON.stringify(formData.value[field]));
  //   } else {
  //     form.append(field, formData.value[field]);
  //   }
  // }
  // form.append("sequence_id", props.data.sequence_id);
  // form.delete("send_number");
  // form.delete("send_type");
  // if (sendImmediately.value) {
  //   form.append("send_time", 0);
  // } else {
  //   const send = convertToMinutes(formData.value.send_number, formData.value.send_type);
  //   form.append("send_time", send);
  // }

  try {
    const response = await axios.post(`/company/follow-up/drips/update/${props.data.id}`, form, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
      params: {
        _method: "put",
      },
    });
    console.log("Response:", response.data);
    closeModal();
    emits("success", true);
    // Handle success (e.g., show a success message)
  } catch (error) {
    console.error("Error submitting form:", error);
    // Handle error (e.g., show an error message)
  }

  // for (const pair of form.entries()) {
  //   console.log(pair[0] + ", " + pair[1]);
  // }

  // try {
  //   const response = await axios.post(`/company/follow-up/drips/update/${props.data.id}`, form, {
  //     headers: {
  //       "Content-Type": "multipart/form-data",
  //     },
  //     params: {
  //       _method: "put",
  //     },
  //   });
  //   console.log("Response:", response.data);
  //   closeModal();
  //   emits("success", true);
  //   // Handle success (e.g., show a success message)
  // } catch (error) {
  //   console.error("Error submitting form:", error);
  //   // Handle error (e.g., show an error message)
  // }
}

async function deleteRecord() {
  try {
    const response = await axios.delete(`/company/follow-up/drips/delete/${props.data.id}`, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });
    console.log("Response:", response.data);
    closeModal();
    emits("success", true);
    // Handle success (e.g., show a success message)
  } catch (error) {
    console.error("Error submitting form:", error);
    // Handle error (e.g., show an error message)
  }
}

const convertToMinutes = (number, type) => {
  switch (type) {
    case "days":
      return number * 24 * 60;
    case "hrs":
      return number * 60;
    case "mins":
      return number;
    default:
      return number;
  }
};

const parseIfJSON = (str) => {
  try {
    const obj = JSON.parse(str);
    return obj;
  } catch (error) {
    // If parsing fails, return the original string
    return str;
  }
};
</script>
<style scoped>
.modal-edit-drip {
  position: fixed;
  right: 0;
  top: 0;
  left: 0;
  bottom: 0;
  z-index: 5050;
}

.modal-edit-drip .modal-container {
  height: 100dvh;
  width: clamp(400px, 50%, 50%);
  background-color: white;
  overflow: auto;
}

.error {
  border-color: red;
}

.error-message {
  color: red;
}

.ql-editor {
  height: 30px;
}

.toggle-switch {
  position: relative;
  display: inline-block;
  width: 80px;
  height: 30px;
  cursor: pointer;
}

.toggle-switch input[type="checkbox"] {
  display: none;
}

.toggle-switch-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #ddd;
  border-radius: 20px;
  box-shadow: inset 0 0 0 2px #ccc;
  transition: background-color 0.3s ease-in-out;
}

.toggle-switch-handle {
  position: absolute;
  top: 5px;
  left: 5px;
  width: 20px;
  height: 20px;
  background-color: #fff;
  border-radius: 50%;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease-in-out;
}

.toggle-switch::before {
  content: "";
  position: absolute;
  top: -25px;
  right: -35px;
  font-size: 12px;
  font-weight: bold;
  color: #aaa;
  text-shadow: 1px 1px #fff;
  transition: color 0.3s ease-in-out;
}

.toggle-switch input[type="checkbox"]:checked + .toggle-switch-handle {
  transform: translateX(45px);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2), 0 0 0 3px #05c46b;
}

.toggle-switch input[type="checkbox"]:checked + .toggle-switch-background {
  background-color: #05c46b;
  box-shadow: inset 0 0 0 2px #04b360;
}

.toggle-switch input[type="checkbox"]:checked + .toggle-switch:before {
  content: "On";
  color: #05c46b;
  right: -15px;
}

.toggle-switch input[type="checkbox"]:checked + .toggle-switch-background .toggle-switch-handle {
  transform: translateX(50px);
}

.custom-quill-container .ql-editor {
  height: 200px;

  overflow: auto !important;
}
</style>
