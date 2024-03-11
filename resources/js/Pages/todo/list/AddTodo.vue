<style scoped>
   .activities-box {
      background-color: #f0f0f0;
      border-radius: 8px;
      box-shadow: var(--ds-shadow-raised,0 1px 1px #091e4240,0 0 1px #091e424f);
      box-sizing: border-box;
      clear: both;
      display: inline-block;
      margin: 4px 2px 4px 0;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      display: block;
   }

   .attachments-container {
      width: 100%;
      padding: 10px;
      /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
   }

   .attachment {
      display: flex;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #eee;
   }

   .attachment-icon {
      flex-shrink: 0;
      width: 60px;
      height: 70px;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f4f4f4;
      border-radius: 5px;
      margin-right: 15px;
      font-weight: bold;
   }

   .attachment-name {
      font-size: 15px;
      color: #333;
      text-decoration: none;
   }

   .attachment-meta {
      font-size: 14px;
      color: #666;
   }

   .attachment-action {
      color: #007bff;
      text-decoration: none;
      margin-left: 5px;
   }

   .attachment-action:hover {
      text-decoration: underline;
   }

   .btn-primary {
  background-color: #1e5bb2 !important;
  border-color: #1e5bb2 !important;
}
</style>
<template>
   <div class="row">
      
      <div class="col-md-9">
         <div class=" mt-4  w-full">Title</div>
         <div class="mt-3 ms-4">
            <input type="text" v-model="title" class="form-control" name="title" id="title">
         </div>
         <div class="form-group m-checkbox-inline mb-0 custom-radio-ml mb-3 p-2 d-flex justify-content-center align-items-center">
            <div class="radio radio-primary">
               <input id="radioinline1" type="radio" v-model="entityType" value="projects" required/>
               <label class="mb-0" for="radioinline1">Projects</label>
            </div>
            <div class="radio radio-primary">
               <input id="radioinline2" type="radio" v-model="entityType" value="leads" required/>
               <label class="mb-0" for="radioinline2">Leads</label>
            </div>
            <div class="radio radio-primary">
               <input id="radioinline3" type="radio" v-model="entityType" value="non-work" required/>
               <label class="mb-0" for="radioinline3">Non-Work</label>
            </div>
         </div>

         <div class="row">
            <div class="col-xl-12" v-if="entityType && entityType != 'non-work'">
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
         </div>

         <div class="mt-3 ms-4">
            <table width="70%">
               <tr>
                  <td width="20%">Members</td>
                  <td width="20%">Due Date</td>
                  <td v-if="labels.length > 0" width="20%">Labels</td>
               </tr>
               <tr>
                  <td>
                     <div v-for="member in members" :key="member.id" @click="handleMemberSelect(member)"  style="display: inline-block; cursor: pointer;">
                        <img class="img-20 rounded-circle" :src="'/assets/images/user/3.jpg'" alt="" data-original-title="" title="">
                     </div>
                     <a href="#"  @click="toggleMemberPopup"><i class="icofont icofont-plus-circle fs-5 ms-1"></i></a>
                        <!-- <button ref="membersAddButton" class="btn btn-light detail-btn mb-0" @click="toggleMemberPopup"><i class="icofont icofont-plus-circle fs-5 ms-1"></i></button> -->

                  </td>
                  <!-- <td>tomorrow at 7:20 PM <span class="badge badge-warning text-dark">Due Soon</span></td> -->
                  <td> {{ due_date }} <span  v-if="due_date" class="badge badge-warning text-dark">Due Soon</span></td>
                  <td v-if="labels"> 
                     <div v-for="label in labels" :key="label.id" @click="handleLabelForm(label)" style="display: inline-block; cursor: pointer;">
                        <div :style="{ backgroundColor: label.color, border: '1px solid #000' }">{{ label.title }}</div>
                     </div>
                  </td>
               </tr>
            </table>
         </div>

         <div class=" mt-4  w-full">Description</div>
         <div class="mt-3 ms-4">
            <ckeditor :editor="editor" v-model="description"></ckeditor>
         </div>

         <div class=" mt-4 w-full">
            <i class="icofont icofont-clip"></i> 
            Attachments
            <button class="btn btn-sm pull-right btn-primary" @click="toggleAttachmentPopup">Add</button>
            <div class="attachments-container">
               <div class="attachment-list">
                  <div class="attachment" v-for="attachment in attachments" :key="attachment.id">
                  <div class="attachment-icon">
                     <!-- Here you could dynamically choose an icon based on the file type -->
                     <span>{{ attachment.file_type }}</span>
                  </div>
                  <div class="attachment-info">
                     <a href="#" class="attachment-name">{{ attachment.file_name }}</a>
                     <div class="attachment-meta">
                        <span>Added {{ attachment.created_at }}</span>
                        <span>•</span>
                        <a href="#" class="attachment-action pull-right" @click="deleteAttachment(attachment)">Delete</a>
                     </div>
                  </div>
                  </div>
               </div>
            </div>
         </div>

         <div class=" mt-4 w-full">
            <i class="icofont icofont-listine-dots"></i> Activity
            <button class="btn btn-sm btn-light pull-right"  @click="toggleshowDetails">
               <span  v-if="showDetails">
                  Hide Details
               </span>
               <span  v-else>
                  Show Details
               </span>
            </button>
            <div class="mt-4">
               <!-- <textarea class="form-control" placeholder="Write a comment..."></textarea> -->
               <ckeditor :editor="editor" v-model="currentActivity.description"></ckeditor>
               <button class="btn-sm btn-primary mt-2" @click="saveActivity(currentActivity)"> Add Activity </button>
            </div>
            <div v-if="showDetails" class="px-3 w-full">
               <div class=" mt-4 w-full" v-for="activity in activities" :key="activity.id">
                  <div v-if="activity.isEdit" class="mt-3 ms-4">
                     <ckeditor :editor="editor" v-model="activity.description"></ckeditor>
                     
                     <div style="display: flex; gap: 10px;">
                     <button class="btn-sm btn-primary mt-2" @click="saveEditActivity(activity)"> Save </button>
                           <button class="btn-sm btn-secondary mt-2" @click="activity.isEdit = !activity.isEdit"> Cancel </button>
                     </div>
                  </div>
                  <div v-else>
                        <!-- <p class = "m-0 p-0">{{ activity.user.display_name }} {{ activity.created_at }}</p> -->
                        <div  class="activities-box"  >
                           <div v-html="activity.description" style="padding: 10px;"></div>
                        </div>
                        <a class="attachment-action me-1" href="#" @click="editActivity(activity)">Edit</a>
                        <a class="attachment-action me-1" href="#" @click="deleteActivity(activity)">Delete</a>
                  </div>

               </div>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <small>Add to card</small><br>
         <button ref="membersButton" class="btn btn-light detail-btn w-full mb-2" @click="toggleMemberPopup"><i class="icofont icofont-user-alt-3 me-1"></i> Members</button>
         <MemberSearchPopup :showPopup="showMemberPopup" :position="memberPopupPosition"  @close-popup="showMemberPopup = false" @member-selected="handleMemberSelect" />

         <button class="btn btn-light detail-btn w-full mb-2" @click="toggleLabelPopup"><i class="icofont icofont-label me-1"></i> Labels</button>
         <LabelPopup :showPopup="showLabelPopup" :position="memberPopupPosition"  @close-popup="showLabelPopup = false" @save-form="handleLabelForm" />

         <button class="btn btn-light detail-btn w-full mb-2" @click="toggleDatePopup"><i class="icofont icofont-clock-time me-1"></i> Dates</button>
         <DatePopup :showPopup="showDatePopup" :position="memberPopupPosition" :card="card"   @close-popup="showDatePopup = false" @save-form="handleDateForm" />

         <button class="btn btn-light detail-btn w-full mb-2" @click="toggleAttachmentPopup"><i class="icofont icofont-clip me-1"></i> Attachment</button>
         <!-- <AttachmentPopup :showPopup="showAttachmentPopup" :position="memberPopupPosition" @close-popup="showAttachmentPopup = false" @save-form="handleFileUpload" /> -->


         <!-- <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-chart-flow me-1"></i> Custom Fields</button> -->
         <!-- <br><br>
         <small>Actions</small><br>
         <button class="btn btn-light detail-btn w-full mb-2" @click="toggleMovePopup"><i class="icofont icofont-arrow-right me-1"></i> Move</button>
         <MovePopup :showPopup="showMovePopup" :position="memberPopupPosition" :card="card"   @close-popup="showMovePopup = false" @save-form="handleMoveForm" />

         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-copy-alt me-1"></i> Copy</button>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-archive me-1"></i> Archive</button>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-share me-1"></i> Share</button> -->
      </div>

      <div class = "col-md-12">
         <div class="card-footer text-end">
            <button class="btn btn-success w-100"  @click="saveTodo">Save</button>
         </div>
      </div>
   </div>
   
</template>

<script >
import axios from 'axios';
import Swal from 'sweetalert2';
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import MemberSearchPopup from '@/components/kanban/UserSearchPopup.vue';
import DatePopup from '@/components/kanban/DatePopup.vue';
import AttachmentPopup from '@/components/kanban/AttachmentPopup.vue';
import MovePopup from '@/components/kanban/MovePopup.vue';
import LabelPopup from '@/components/kanban/LabelPopup.vue';
import VueMultiselect from "vue-multiselect";

export default {
   components: {
      ckeditor: CKEditor.component,
      MemberSearchPopup,
      DatePopup,
      MovePopup,
      LabelPopup,
      AttachmentPopup,
      VueMultiselect,
   },
   props:(["leads", "jobsites"]),
   data() {
      return {
         editor: ClassicEditor,
         card:[],
         entityId: 0,
         entityType:"non-work",
         title: "",
         description: "",
         due_date: "",
         start_date:"",
         due_time: "",
         reminder: "",
         reminder_date: "",

         rowOptions: [],
         selectLabel: "",
         selectTrackBy: "",
         selectPlaceHolder: "",
         descIsEdit: false,

         activities:[],
         currentActivity:{
            id:0,
            description:"",
            isEdit: false,
         },
         showDetails: true,

         showMemberPopup: false,
         memberPopupPosition: [],
         members:[],

         showDatePopup: false,

         showAttachmentPopup: false,
         attachments: [],

         showLabelPopup: false,
         labels: [],

      }
  },
   methods:{
   saveTodo(){

      if(!this.title){
         Swal.fire({
            text: "Please Add title",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Close",
            customClass: {
               confirmButton: "btn btn-success"
            }
         });

         return;
      }

      let projId = 0;
      if(this.entityType =="projects"){
         projId = this.entityId.jobsite_id
      }else if(this.entityType =="leads"){
         projId = this.entityId.lead_id
      }

      axios.post(`/api/todo/saveListTodo`, {
         card: {
            entityId: projId,
            entityType: this.entityType,
            title: this.title,
            description: this.description,
            start_date: this.start_date,
            due_date: this.due_date,
            due_time: this.due_time,
            reminder: this.reminder,
            reminder_date: this.reminder_date,
         },
         activities: this.activities,
         members: this.members,
         labels: this.labels
      })
      .then((res) => {
         if(res.data){
            Swal.fire({
               text: "TODO added successfully",
               icon: "success",
               buttonsStyling: false,
               confirmButtonText: "Close",
               customClass: {
                  confirmButton: "btn btn-success"
               }
            });
            emits("reload");

            //Close and Reset Values of fields

         }
      })
      .catch((error) => {
            console.log(error.message);
      });
   },

   /////////////////////////////////////////////// ACTIVITY METHODS //////////////////////////////////////////////
   saveActivity(activity){
      let id = activity.id + 1;
      let desc = activity.description;
      let act = {
         id: id,
         description: desc,
        isEdit: false,
      }
      this.activities.push(act);
      this.currentActivity.id = activity.id + 1;
      this.currentActivity.description = "";
   },
   saveEditActivity(activity){
      let act_id = activity.id - 1;
      activity.isEdit = false
      this.activities[act_id] = activity;
   },
   editActivity(activity){
      activity.isEdit = true;
   },
   deleteActivity(activity){
      let index = activity.id - 1;
      this.activities.splice(index, 1);
   },   
   toggleshowDetails() {
      this.showDetails = !this.showDetails;
   },
   /////////////////////////////////////////////// ACTIVITY METHODS //////////////////////////////////////////////
   /////////////////////////////////////////////// FOR MEMBERS METHOD ////////////////////////////////////////////
   toggleMemberPopup(event) {
      this.showMemberPopup = !this.showMemberPopup;
      // if (this.showMemberPopup) {
      //   const button = this.$refs.membersButton;
      //   this.memberPopupPosition = button.getBoundingClientRect();
      // }
   },
    handleMemberSelect(member) {
      const index = this.members.findIndex(m => m.user_id === member.user_id);
      if (index !== -1) {
         // If member exists, remove it
         this.members.splice(index, 1);
      } else {
         // If member doesn't exist, push it
         this.members.push(member);
      }
      this.showMemberPopup = !this.showMemberPopup;
    },
   /////////////////////////////////////////////// FOR DATE METHOD ////////////////////////////////////////////
   toggleDatePopup(event) {
      this.showDatePopup = !this.showDatePopup;
   },
   handleDateForm(dateForm) {
      this.start_date = dateForm.start_date;
      this.due_date = dateForm.due_date;
      this.due_time = dateForm.due_time;
      this.reminder = dateForm.reminder;
      this.reminder_date = dateForm.reminder_date;
      this.showDatePopup = !this.showDatePopup;
   },
   /////////////////////////////////////////////// FOR DATE METHOD ////////////////////////////////////////////

   /////////////////////////////////////////////// FOR ATTACHMENTS METHOD ////////////////////////////////////////////
   toggleAttachmentPopup(event) {
      this.showAttachmentPopup = !this.showAttachmentPopup;
   },
   handleFileUpload(uploadForm) {
      const formData = new FormData();
      formData.append("file", uploadForm);
      formData.append("todo_id", this.card.id);

      // Adjust the URL and headers as necessary
      axios.post('/api/todo/upload', formData, {
      headers: {
         'Content-Type': 'multipart/form-data',
      }
      })
      .then(res => {
         this.attachments = res.data.data;
         this.showAttachmentPopup = !this.showAttachmentPopup;
      })
      .catch(error => {
         console.error("There was an error uploading the file:", error.response);
      });
   },
   deleteAttachment(attachment){
      axios.post(`/api/todo/deleteUpload`, {
            id: attachment.id,
            todo_id: this.card.id,
         })
      .then((res) => {
         if(res.data){
            this.attachments = res.data.data;
         }
      })
      .catch((error) => {
            console.log(error.message);
      });
   },
   /////////////////////////////////////////////// FOR ATTACHMENTS METHOD ////////////////////////////////////////////
   /////////////////////////////////////////////// FOR Label METHOD ////////////////////////////////////////////
   toggleLabelPopup(event) {
      this.showLabelPopup = !this.showLabelPopup;
   },
   handleLabelForm(label) {
      console.log("handleLabelForm");
      console.log(label);
      const index = this.labels.findIndex(l => l.id === label.id);
      if (index !== -1) {
         // If member exists, remove it
         this.labels.splice(index, 1);
      } else {
         // If member doesn't exist, push it
         this.labels.push(label);
      }

      //this.showLabelPopup = !this.showLabelPopup;
    },
   /////////////////////////////////////////////// FOR Label METHOD ////////////////////////////////////////////

  }, 
  watch: {
    // Watching the "message" data property
    entityType(newValue, oldValue) {
      this.entityId = "";
      if (this.entityType == "projects") {
         this.rowOptions = this.jobsites;
         this.selectLabel = "jobsite_name";
         this.selectTrackBy = "jobsite_id";
         this.selectPlaceHolder = "Select a Project";
         this.entityId = this.rowOptions[0];
      }

      if (this.entityType == "leads") {
         this.rowOptions = this.leads;
         this.selectLabel = "opportunity_title";
         this.selectTrackBy = "lead_id";
         this.selectPlaceHolder = "Select a Lead";
         this.entityId = this.rowOptions[0];
      }
    }
  }
}
</script>