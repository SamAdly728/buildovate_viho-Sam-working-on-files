<template>
  <div class="d-flex justify-content-between align-items-center automation">
    <div>
      <div class="automation-label">
        <p class="mb-2">Automations</p>
        <!-- Toggle Switch -->
        <div class="form-check form-switch toggle-switch">
          <input class="form-check-input" type="checkbox" id="automationToggle" checked />
          <label class="form-check-label" for="automationToggle"></label>
        </div>
      </div>
      <p class="m-3">
        When an appointment is created, send client
        <strong>
          <select id="messageType">
            <option>an email</option>
            <option>a text message</option>
            <option>a text and email</option>
          </select>
        </strong>
        1 day ahead of appointment.
      </p>
      <div class="automation-label">
        <button>+ Add Condition</button>
        <!-- Toggle Switch -->
        <div class="toggle-switch">
          <div class="btn btn-primary">
            <button @click="openModal">Edit Message</button>
          </div>
        </div>
        <!-- <AutomationModal v-if="isModalOpen" :initialData="modalData" @modalClosed="handleModalClosed" /> -->
        <!-- <AutomationModal :openModal="isModalOpen" @closeModal="closeModal" /> -->
      </div>
    </div>
  </div>
</template>
<script>
// import AutomationModal from "../modals/AutomationModal.vue";
export default {
  data() {
    return {
      isModalOpen: false,
    };
  },
  methods: {
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
  },
  // components: {
  //   AutomationModal,
  // },
};
</script>
<style scoped>
.automation {
  background: rgb(207, 226, 243); /* Adjust the background color as needed */
  border: solid black;
  padding: 10px;
  align-items: center;
}
.toggle-switch {
  float: right;
}
.automation-label {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
select {
  background: none;
  border: none;
  text-decoration: underline;
  cursor: pointer;
  padding: 0;
  margin: 0;
  font-family: inherit;
  font-size: inherit;
  text-align: center;
}
</style>
