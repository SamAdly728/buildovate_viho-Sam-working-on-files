<template>
  <AddSequence :showModal="modalAddSequence" :data="selectedData" @close="closeModal" @success="handleSubmitSuccess" />
  <EditSequence :showModal="modalEditSequence" :data="selectedData" @close="closeModal" @success="handleSubmitSuccess" />
  <AddDrip :showModal="modalAddDrip" @close="closeModal" :data="selectedData" @success="handleSubmitSuccess" />
  <EditDrip :showModal="modalEditDrip" @close="closeModal" :data="selectedData" @success="handleSubmitSuccess" />
  <AddDealStage :showModal="modalAddDealStage" @close="closeModal" @success="handleSubmitSuccess" />
  <EditDealStage :showModal="modalEditDealStage" :data="selectedData" @close="closeModal" @success="handleSubmitSuccess" />
  <FollowUpSettingsModalVue :showModal="modalSettings" @close="closeModal"></FollowUpSettingsModalVue>
  <div class="row p-5">
    <div class="d-flex justify-content-between mb-2">
      <button class="btn btn-primary-v2 py-2 px-3" @click="toggleAddDealStageModal()">
        <i class="fa-solid fa-plus me-2"></i>
        Add Deal Stage
      </button>
    </div>

    <div v-for="item in data" style="width: 100%" class="mb-3 follow-up-list-container">
      <div class="row box-list border-primary" @click="toggleBoxList(item)">
        <div class="col-1 d-flex align-items-center justify-content-center">
          <i class="fa-regular fa-handshake fs-5"></i>
        </div>
        <div class="col-9 d-flex align-items-center">
          <h6 class="m-0 fs-6">
            {{ item.deal_stage }}
            <small class="text-muted fw-light ms-3">{{ item.description }}</small>
          </h6>
        </div>
        <div class="col-1 d-flex align-items-center justify-content-center">
          <i
            class="fs-5"
            :class="{
              'fa-solid fa-minus': item.toggle,
              'fa-solid fa-plus': !item.toggle,
            }"
          ></i>
        </div>
        <div class="col-1 d-flex align-items-center justify-content-center">
          <button class="p-2 border-0 bg-transparent" @click.stop="toggleEditDealStageModal(item.id)">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
        </div>
      </div>
      <div class="sub-menu" :class="{ show: item.toggle, hide: !item.toggle }">
        <!-- sequence list  -->
        <div v-for="sequence in item.sequences">
          <div class="bg-white border border-secondary row m-0 px-4 py-3" @click="toggleEditSequenceModal(sequence)">
            <div class="col d-flex align-items-center fs-6">
              <span class="fw-bold me-3">Sequence Name:</span>
              {{ sequence.sequence_name }}
            </div>
            <div class="col text-white d-flex justify-content-end align-items-center">
              <span class="rounded-pill py-1 px-3">Open Rate 0.00%</span>
            </div>
          </div>
          <!-- drip list  -->
          <div v-for="drip in sequence.drips">
            <div class="bg-white border border-secondary row m-0 px-4 py-3" @click="toggleEditDripModal(drip)">
              <div class="col d-flex align-items-center fs-6">
                {{ drip.drip_name }}
              </div>
              <div class="col text-white d-flex flex-row gap-2 align-items-center justify-content-end">
                <span class="text-muted">
                  {{ !drip.send_time ? "Send Immediately" : "Send After " + convertSendTime(drip.send_time) }}
                </span>
                <span class="rounded-pill py-1 px-3">Open Rate 0.00%</span>
              </div>
            </div>
          </div>

          <!-- add drip  -->
          <div class="bg-white border border-secondary row m-0 px-4 py-3" @click="toggleAddripModal(sequence.id)">
            <div class="col d-flex align-items-center fs-6 fw-bold text-primary">Add New Drip</div>
          </div>
        </div>

        <div class="bg-white border border-secondary row m-0 px-4 py-3" @click="toggleAddSequenceModal()">
          <div class="col d-flex align-items-center fs-6 fw-bold text-primary">Add New Sequnce</div>
        </div>
      </div>

      <!-- sequence  -->

      <!-- add sequence  -->
    </div>
  </div>
</template>
<script setup>
import { ref, onUpdated } from "vue";
import AddSequence from "../../modals/AddSequence.vue";
import EditSequence from "../../modals/EditSequence.vue";
import AddDrip from "../../modals/AddDrip.vue";
import EditDrip from "../../modals/EditDrip.vue";
import AddDealStage from "../../modals/AddDealStage.vue";
import EditDealStage from "../../modals/EditDealStage.vue";
import axios from "axios";
import FollowUpSettingsModalVue from "../../modals/FollowUpSettingsModal.vue";
//modals
const modalAddSequence = ref(false);
const modalEditSequence = ref(false);
const modalAddDrip = ref(false);
const modalEditDrip = ref(false);
const modalAddDealStage = ref(false);
const modalEditDealStage = ref(false);
const modalSettings = ref(false);
const selectedData = ref(null);
const connectedEmail = ref(null);

const props = defineProps(["errors", "appName", "company", "support", "csrf_token", "style", "flash", "auth", "dealStages"]);

const data = ref(props.dealStages);

data.value = data.value.map((item) => {
  return { ...item, toggle: false };
});

const toggleBoxList = (item) => {
  data.value.forEach((list) => {
    if (list.id === item.id) {
      list.toggle = !list.toggle;
    } else {
      list.toggle = false;
    }
  });
};

const toggleAddSequenceModal = () => {
  const result = data.value.find((item) => item.toggle === true);
  if (result) {
    selectedData.value = result.id;
    modalAddSequence.value = !modalAddSequence.value;
  }

  selectedData.value = id;
  modalAddSequence.value = !modalAddSequence.value;
};

const toggleEditSequenceModal = (sequence) => {
  selectedData.value = sequence;
  modalEditSequence.value = !modalEditSequence.value;
};

const toggleAddripModal = (sequence_id) => {
  selectedData.value = sequence_id;
  modalAddDrip.value = !modalAddDrip.value;
};

const toggleEditDripModal = (drip) => {
  selectedData.value = drip;
  modalEditDrip.value = !modalEditDrip.value;
};

const toggleAddDealStageModal = () => {
  modalAddDealStage.value = !modalAddDealStage.value;
};

const toggleEditDealStageModal = (id) => {
  const result = data.value.find((item) => item.id === id);

  if (result) {
    selectedData.value = result;
    modalEditDealStage.value = !modalEditDealStage.value;
  }
};

const toggleSettings = () => {
  modalSettings.value = !modalSettings.value;
};

const closeModal = () => {
  modalAddSequence.value = false;
  modalEditSequence.value = false;
  modalAddDrip.value = false;
  modalEditDrip.value = false;
  modalAddDealStage.value = false;
  modalEditDealStage.value = false;
  modalSettings.value = false;
  selectedData.value = null;
};

async function handleSubmitSuccess(success) {
  if (success) {
    try {
      const response = await axios.get(`/company/follow-up/deal-stages/all`);
      // Process the updated data
      console.log("Updated Data:", response.data.data);
      data.value = response.data.data;
      // onUpdated(response.data);
    } catch (error) {
      console.error("Error fetching updated data:", error);
      // Handle error (e.g., show an error message)
    }
  }
}

const convertSendTime = (send_time) => {
  let send_number;
  let send_type;

  if (send_time < 60) {
    send_number = send_time;
    send_type = "min/s";
  } else if (send_time < 1440) {
    send_number = Math.floor(send_time / 60);
    send_type = "hr/s";
  } else {
    send_number = Math.floor(send_time / 1440);
    send_type = "day/s";
  }

  return `${send_number} ${send_type}`;
};
</script>
<style scoped>
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}
.box-list {
  border: 3px solid #1e5bb2;
  border-radius: 5px;
  cursor: pointer;
  padding: 20px;
}

.sub-menu {
  background-color: white;
  margin: 0 !important;
  padding: 0;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s ease-out;
  cursor: pointer;
}

.sub-menu.show {
  max-height: 1000dvh;
}

.sub-menu.hide {
  max-height: 0; /* Set to 0 to hide the submenu */
}

.sub-menu .rounded-pill {
  background-color: #1c2c44;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
