<template>
  <div>
    <div class="row m-0 px-4 pt-4">
			<div class="col-sm-4">
        <div class="d-flex justify-content-between">
          <div>
            <p>Total Deals</p>
            <p>1</p>
          </div>

          <div>
            <p>Total Value</p>
            <p>$12,000.00</p>
          </div>

          <div>
            <ul class="nav nav-tabs">
              <li class="nav-item" v-for="tab in tabs" :key="tab.id">
                  <a class="nav-link" :class="{ active: activeTab === tab.id }" href="#" @click.prevent="setActiveTab(tab.id)" >
                  {{ tab.name }}
                </a>
              </li>
            </ul>
          </div>

        </div>
			</div>
      <div class="col-sm-8">
        <div class="d-flex justify-content-end gap-2">
            <a class="btn btn-primary-v2 rounded-4" @click="handleNewLeadClick"> New Lead </a>
            <div class="dropdown">
              <button class="btn btn-primary-v2 rounded-4 dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                New Appt.
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#" @click="handleOnSiteEstimateClick">On-Site Estimate</a></li>
                <li><a class="dropdown-item" href="#" @click="handleSiteVisitClick">Site Visit</a></li>
                <li><a class="dropdown-item" href="#" @click="handleProjectWalkthroughClick">Project Walkthrough</a></li>
                <li><a class="dropdown-item" href="#" @click="handleScopeClarificationClick">Scope Clarification</a></li>
                <li><a class="dropdown-item" href="#" @click="handleQualityControlClick">Quality Control</a></li>
                <li><a class="dropdown-item" href="#" @click="handlePaymentCollectionClick">Payment Collection</a></li>
              </ul>
            </div>

            <button class="btn btn-primary-v2 rounded-4" @click="handleNewProposalClick"> New Proposal </button>
            <button class="btn btn-primary-v2 rounded-4"> New Request </button>
        </div>
			</div>
    </div>

    <div class="tab-content bg-gray">
      <!-- BOARD -->
      <div class="tab-pane fade bg-gray" :class="{ 'show active': activeTab === 'Board' }" role="tabpanel">
        <div class="row m-0 p-4">
          <div v-for="(list, index) in lists" :key="index" class="col-sm-2">
            <div class="card shadow-sm" style="border-radius: 10px;">
              <div class="card-body m-0 px-1 py-2">
                <div class="d-flex justify-content-between">
                  <div>
                    <h6>{{ list.name }}</h6>
                    <p>{{ list.items.length }} Deal{{ list.items.length !== 1 ? 's' : '' }}</p>
                  </div>
                  <div class="icon-with-tooltip">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <span v-if="list.id === 1" class="custom-tooltip">Potential customers you have not yet communicated with, most often coming from a paid leads source.</span>
                    <span v-else-if="list.id === 2" class="custom-tooltip">These are potential customers you've met or spoken with who have expressed interest in utilizing your services, but are not yet ready to book. <i>Example: Someone you met at a trade show or the local coffee shop.</i></span>
                    <span v-else-if="list.id === 3" class="custom-tooltip">These are customers looking to schedule an estimate, who have come from your Customer Booking Form, whether they completed the form or you filled it out for them.</span>
                    <span v-else-if="list.id === 4" class="custom-tooltip">All scheduled appointments will move automatically to the Estimate Scheduled stage.</span>
                    <span v-else-if="list.id === 5" class="custom-tooltip">Once a Proposal has been started the Deal Card will move automatically to In Draft.</span>
                    <span v-else-if="list.id === 6" class="custom-tooltip">Once a proposal has been completed and sent, the Deal Card will move automatically to the Proposal(s) Sent stage and the next round of Follow Ups will start.</span>
                  </div>
                  <div>
                    <i class="fa fa-bullhorn" style="color: #6A5AEB; vertical-align: middle;"></i>
                  </div>
                </div>
              </div>
            </div>
            <draggable :list="list.items" group="items" item-key="id" @change="onItemMoved" class="drag-area mt-3">
              <template #item="{element}">
                <div class="item-card" style="cursor: pointer; overflow: hidden;">
                  <div class="item-header">
                    <span class="item-status">
                      {{ list.title }}
                    </span>
                    <span class="item-dots">...</span>
                  </div>
                  <div class="item-body">
                    <div class="item-title">{{ element.opportunity_title }}</div>
                    <div class="item-subtitle">Test Contact</div>
                    <div class="item-info">
                      <span class="item-icon">
                        <i class="fa fa-hashtag"></i>
                      </span>
                      <span class="item-id">#594780</span>
                    </div>
                  </div>
                  <div class="item-footer">
                    <div></div>
                    <div>
                      <span class="item-time">16h</span>
                      <span class="item-initials">TC</span>
                    </div>
                    
                  </div>
                </div>
              </template>
            </draggable>
          </div>
        </div>
      </div>

      <!-- LIST -->
      <div class="tab-pane fade bg-gray" :class="{ 'show active': activeTab === 'List' }" role="tabpanel">
        <div class="row m-0 p-4 pt-0">
          <div class="col-12">
            <LeadManagement :overviewpage="true"></LeadManagement>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import draggable from 'vuedraggable';
import axios from 'axios';
import { useNewLeadSidebar } from '../stores/new-lead';
import { useNewAppointmentSidebar } from '../stores/new-appointment';
import LeadManagement from '@/Pages/sales/lead/LeadManagement.vue';

export default {
  components: {
    draggable,
    LeadManagement
  },
  setup(){
    const newLeadStore = useNewLeadSidebar();
    const newAppointmentStore = useNewAppointmentSidebar();
    
    return {newLeadStore,newAppointmentStore}
  },
  data() {
    return {
      lists: [],
      tabs: [
          { id: 'Board', name: 'Board'},
          { id: 'List', name: 'List'},
        ],
      activeTab: 'Board',
    };
  },
  methods: { 
    setActiveTab(tabId) {
    this.activeTab = tabId;
    },
    onItemMoved(event) {
      if(event.added){
        const item = event.added.element;
        const newIndex = event.added.newIndex; 

        const destinationData = this.lists.find(list => list.items.includes(item));
        
        console.log('item', item)
        console.log('destinationData', destinationData)

        console.log('Updating server state with new item positions...');
        this.moveLead(item.lead_id,destinationData.id);
      }
    },
    getLeadsGroupedByStage() {
      axios.get('/api/getLeadsGroupedByStage')
        .then(response => {
          this.lists = response.data.lists;
        })
        .catch(error => {
          console.error('There was an error fetching the leads:', error);
        });
    },
    moveLead(leadId, newStageId) {
      axios.patch(`/api/leads/${leadId}/stage`, { stage_id: newStageId })
        .then(response => {
          console.log(response.data.message);
        })
        .catch(error => {
          console.error('Error updating lead stage:', error.response);
        });
    },
    handleNewLeadClick() {
      this.newLeadStore.setFormType('lead');
      this.newLeadStore.open();
    },
    handleNewProposalClick() {
      this.newLeadStore.setFormType('proposal');
      this.newLeadStore.open();
    },
    handleOnSiteEstimateClick() {
      this.newAppointmentStore.setFormType('On-Site Estimate');
      this.newAppointmentStore.open();
    },
    handleSiteVisitClick() {
      this.newAppointmentStore.setFormType('Site Visit');
      this.newAppointmentStore.open();
    },
    handleProjectWalkthroughClick() {
      this.newAppointmentStore.setFormType('Project Walkthrough');
      this.newAppointmentStore.open();
    },
    handleScopeClarificationClick() {
      this.newAppointmentStore.setFormType('Scope Clarification');
      this.newAppointmentStore.open();
    },
    handleQualityControlClick() {
      this.newAppointmentStore.setFormType('Quality Control');
      this.newAppointmentStore.open();
    },
    handlePaymentCollectionClick() {
      this.newAppointmentStore.setFormType('Payment Collection');
      this.newAppointmentStore.open();
    },
  },
  mounted() {
    this.getLeadsGroupedByStage();
  },
};
</script>

<style scoped>
  .item-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 8px;
    margin: 4px;
    position: relative;
    font-family: 'Arial', sans-serif;
    transition: box-shadow 0.3s ease; 
  }
  .item-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    border: 1px solid #6A5AEB;
  }

  .item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    color: #555;
  }

  .item-status {
    background-color: #6A5AEB;
    color: white;
    border-radius: 10px;
    padding: 2px 6px;
    font-weight: bold;
  }

  .item-dots {
    color: #ccc;
  }

  .item-body {
    padding: 8px 0;
  }

  .item-title {
    color: #6A5AEB;
    font-weight: bold;
    margin-bottom: 4px;
  }

  .item-subtitle {
    color: #888;
    font-size: 14px;
  }

  .item-info {
    display: flex;
    align-items: center;
    font-size: 14px;
    color: #555;
    margin-top: 4px;
  }

  .item-icon {
    color: #6A5AEB;
    margin-right: 4px;
  }

  .item-id {
    font-weight: bold;
  }

  .item-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    color: #555;
    position: absolute;
    bottom: 8px;
    width: calc(100% - 16px);
  }

  .item-time {
    background-color: #f2f2f2;
    border-radius: 10px;
    padding: 2px 6px;
  }

  .item-initials {
    background-color: #f2f2f2;
    border-radius: 50%;
    padding: 4px;
    width: 20px;
    height: 20px;
    text-align: center;
  }

  .icon-with-tooltip {
    position: relative;
    display: inline-block;
  }

  .icon-with-tooltip .custom-tooltip {
    visibility: hidden;
    width: 150px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    top: 45%;
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
  }

  .icon-with-tooltip:hover .custom-tooltip {
    visibility: visible;
    opacity: 1;
  }
</style>
