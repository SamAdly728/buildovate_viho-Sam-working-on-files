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
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Sequence</h1>
              <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
            </div>
            <!-- modal body  -->
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Sequence Name</label>
                <input type="text" class="form-control" v-model="formData.sequence_name" />
                <small v-if="v$.sequence_name.$invalid && v$.sequence_name.$dirty" class="error-message"
                  >this field is required</small
                >
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label class="form-label">Sort Order</label>
                <input type="number" class="form-control" v-model="formData.sort_order" />
                <small v-if="v$.sort_order.$invalid && v$.sort_order.$dirty" class="error-message"
                  >this field is required</small
                >
              </div>
            </div>
            <!-- modal body end -->
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
import { ref, watchEffect } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import axios from "axios";

const props = defineProps(["showModal", "data"]);
const emits = defineEmits(["close", "success"]);

const closeModal = () => {
  resetForm();
  emits("close");
};

const formData = ref({
  sequence_name: "",
  sort_order: "",
});

const id = ref(null);

const rules = {
  sequence_name: { required },
  sort_order: { required },
};

const v$ = useVuelidate(rules, formData);

const headers = {
  "Content-Type": "multipart/form-data",
  //   Authorization: "Bearer YourAccessToken",
};

watchEffect(() => {
  console.log(props.data, "foo");
  if (props.data) {
    id.value = props.data;
  }
});

const resetForm = () => {
  formData.value.sequence_name = "";
  formData.value.sort_order = "";
};

async function submitForm() {
  v$.value.$touch(); // This will trigger validation on all fields

  // Check if the form is valid
  if (v$.value.$pending || v$.value.$error) {
    console.log("Form validation failed");
    return;
  }

  const form = new FormData();

  for (const field in formData.value) {
    form.append(field, formData.value[field]);
  }
  form.append("deal_stage_id", id.value);
  // for (const pair of form.entries()) {
  //   console.log(pair[0] + ", " + pair[1]);
  // }
  try {
    const response = await axios.post("/company/follow-up/sequence/store", form, { headers });
    console.log("Response:", response.data);
    closeModal();
    emits("success", true);
    // Handle success (e.g., show a success message)
  } catch (error) {
    console.error("Error submitting form:", error);
    // Handle error (e.g., show an error message)
  }
}
</script>
<style scoped>
.error {
  border-color: red;
}

.error-message {
  color: red;
}
</style>
