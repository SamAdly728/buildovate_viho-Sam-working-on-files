<template>
  <div>
    <!-- Use a conditional rendering to show/hide the modal -->
    <form @submit.prevent="submitForm">
      <div
        v-if="showModal"
        class="modal fade show"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-modal="true"
        style="display: block"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Drip</h1>
              <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
            </div>

            <!-- modal body  -->
            <div class="modal-body px-4 overflow-auto">
              <div class="row">
                <!-- name  -->
                <div class="col-4 border border-light p-2">
                  <label class="form-label">Name</label>
                </div>
                <div class="col-8 border border-light p-2">
                  <div class="mb-3">
                    <input type="text" class="form-control" v-model="formData.drip_name" />
                    <small v-if="v$.drip_name.$invalid && v$.drip_name.$dirty" class="error-message"
                      >this field is required</small
                    >
                  </div>
                </div>

                <!-- send  -->
                <div class="col-4 border border-light p-2">
                  <label class="form-label">Send</label>
                </div>
                <div class="col-8 border border-light p-2">
                  <div class="form-check text-nowrap">
                    <input class="form-check-input me-2" type="checkbox" v-model="sendImmediately" />
                    <label class="form-check-label m-0 text-muted fw-light text-nowrap"> Send Immediately </label>
                  </div>
                  <div class="input-group">
                    <input
                      type="number"
                      class="form-control"
                      style="width: 70%"
                      v-model="formData.send_number"
                      :disabled="sendImmediately"
                    />
                    <select
                      class="form-select"
                      v-model="formData.send_type"
                      style="width: 30%"
                      :disabled="sendImmediately"
                    >
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
                      >this field is required</small
                    >
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
                  <label class="form-label">SMS Message</label>
                </div>
                <div class="col-8 border border-light p-2" v-if="formData.type !== 'Email'">
                  <textarea class="form-control" placeholder="Your message here" v-model="formData.sms_msg"></textarea>
                  <small
                    v-if="formData.type !== 'Email' && v$.sms_msg.$invalid && v$.sms_msg.$dirty"
                    class="error-message"
                    >this field is required</small
                  >
                </div>

                <!-- email subject  -->
                <div class="col-4 border border-light p-2" v-if="formData.type !== 'SMS Message'">
                  <label class="form-label">Email Subject</label>
                </div>
                <div class="col-8 border border-light p-2" v-if="formData.type !== 'SMS Message'">
                  <div class="mb-3">
                    <input type="text" class="form-control" v-model="formData.email_subject" />
                    <small
                      v-if="formData.type !== 'SMS Message' && v$.email_subject.$invalid && v$.email_subject.$dirty"
                      class="error-message"
                      >this field is required</small
                    >
                  </div>
                </div>

                <!-- email body  -->
                <div class="col-4 border border-light p-2" v-if="formData.type !== 'SMS Message'">
                  <label class="form-label">Email Body</label>
                </div>
                <div
                  class="col-8 border border-light pt-3"
                  style="padding-bottom: 100px"
                  v-if="formData.type !== 'SMS Message'"
                >
                  <quill-editor theme="snow" v-model:content="formData.email_body" content-type="text"></quill-editor>
                  <small
                    v-if="formData.type !== 'SMS Message' && v$.email_body.$invalid && v$.email_body.$dirty"
                    class="error-message"
                    >this field is required</small
                  >
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
            </div>

            <div class="modal-footer">
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

const props = defineProps(["showModal", "data"]);
const emits = defineEmits(["close"]);

const closeModal = () => {
  emits("close");
};

const sendImmediately = ref(true);

const formData = ref({
  drip_name: "",
  send_number: "",
  send_type: "days",
  type: "Email",
  email_subject: "",
  sms_msg: "",
  active: true,
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

// Watch for changes in sendImmediately and trigger revalidation
watchEffect(sendImmediately, formData, () => {
  v$.value.$reset();
});

const headers = {
  "Content-Type": "multipart/form-data",
  //   Authorization: "Bearer YourAccessToken",
};

async function submitForm() {
  v$.value.$touch(); // This will trigger validation on all fields

  // Check if the form is valid
  if (v$.value.$pending || v$.value.$error) {
    console.log("Form validation failed");
    return;
  }

  const form = new FormData();

  // Iterate over the form data object and append each field to the FormData
  for (const field in formData.value) {
    form.append(field, formData.value[field]);
  }
  form.append("sequence_id", props.data);
  form.delete("send_number");
  form.delete("send_type");
  if (sendImmediately.value) {
    form.append("send_time", "Immediately");
  } else {
    const send = convertToMinutes(formData.value.send_number, formData.value.send_type);
    form.append("send_time", send);
  }

  for (const pair of form.entries()) {
    console.log(pair[0] + ", " + pair[1]);
  }

  try {
    const response = await axios.post("/company/follow-up/drips/store", form, { headers });
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
</script>
<style scoped>
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
</style>
