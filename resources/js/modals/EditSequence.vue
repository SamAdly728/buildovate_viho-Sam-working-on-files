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
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Sequence</h1>
              <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
            </div>
            <!-- modal body  -->
            <div class="modal-body">
              <!-- Sequence Name  -->
              <div class="mb-3">
                <label class="form-label">Sequence Name</label>
                <input type="text" class="form-control" v-model="formData.sequence_name" />
                <small v-if="v$.sequence_name.$invalid && v$.sequence_name.$dirty" class="error-message"
                  >this field is required</small
                >
              </div>
              <!-- Sort Order  -->
              <div class="mb-3">
                <label class="form-label">Sort Order</label>
                <input type="number" class="form-control" v-model="formData.sort_order" />
                <small v-if="v$.sort_order.$invalid && v$.sort_order.$dirty" class="error-message"
                  >this field is required</small
                >
              </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
              <div>
                <button type="button" class="btn btn-danger" @click="deleteRecord">Delete</button>
              </div>
              <div>
                <button type="button" class="btn btn-light" @click="closeModal">Close</button>
                <button type="submit" class="btn btn-primary-v2">Submit</button>
              </div>
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
import { ref, onMounted, watchEffect } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import axios from "axios";

const props = defineProps(["showModal", "data"]);
const emits = defineEmits(["close", "success"]);

const formData = ref({
  sequence_name: "",
  sort_order: "",
});

const rules = {
  sequence_name: { required },
  sort_order: { required },
};

const v$ = useVuelidate(rules, formData);

watchEffect(() => {
  console.log(props.data, "hey 4");
  if (props.data) {
    // Ensure props.data exists and is not null
    formData.value.sequence_name = props.data.sequence_name;
    formData.value.sort_order = props.data.sort_order;
  }
});

const closeModal = () => {
  emits("close");
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
  form.append("deal_stage_id", props.data.deal_stage_id);
  for (const pair of form.entries()) {
    console.log(pair[0] + ", " + pair[1]);
  }
  try {
    const response = await axios.post(`/company/follow-up/sequence/update/${props.data.id}`, form, {
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
}

async function deleteRecord() {
  try {
    const response = await axios.delete(`/company/follow-up/sequence/delete/${props.data.id}`, {
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
</script>
<style scoped>
.error {
  border-color: red;
}

.error-message {
  color: red;
}
</style>
