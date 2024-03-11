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

   /* .attachment-list {
      display: flex;
      flex-direction: column;
   } */

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

   /* .attachment-info {
      flex-grow: 1;
    } */

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
         <h5><i class="icofont icofont-card"></i> {{ card.title }}</h5>
         <small class="ms-4">in list <u> <a href="#"  @click="toggleMovePopup">{{ card.entityType }}</a> </u></small>
         <MovePopup :showPopup="showMovePopup" :position="memberPopupPosition" :card="card"   @close-popup="showMovePopup = false" @save-form="handleMoveForm" />

         <div class="mt-3 ms-4">
            <table width="70%">
               <tr>
                  <td width="20%">Members</td>
                  <td width="40%">Due Date</td>
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
                  <td> {{ card.due_date }} <span class="badge badge-warning text-dark">Due Soon</span></td>
               </tr>
            </table>
         </div>

         <div class=" mt-4  w-full">Description
            <button v-if="!descIsEdit" class="btn btn-sm pull-right btn-primary" @click="descIsEdit = !descIsEdit">Edit</button>
         </div>
         <div v-if="descIsEdit" class="mt-3 ms-4">
            <ckeditor :editor="editor" v-model="card.description"></ckeditor>
            
            <div style="display: flex; gap: 10px;">
                  <button class="btn-sm btn-primary mt-2" @click="updateDescription"> Save </button>
                  <button class="btn-sm btn-secondary mt-2" @click="descIsEdit = !descIsEdit"> Cancel </button>
            </div>
         </div>
         <div v-else @click="descIsEdit = !descIsEdit"  class="mt-3 ms-4">
               <div  class="activities-box"  >
                  <div v-html="card.description" style="padding: 10px;"></div>
               </div>
               <!-- <a class="attachment-action me-1" href="#" @click="editActivity(activity)">Edit</a>
               <a class="attachment-action me-1" href="#" @click="deleteActivity(activity)">Delete</a> -->
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
               <button class="btn-sm btn-primary mt-2" @click="saveActivity(currentActivity)"> Save </button>
            </div>
            <div v-if="showDetails" class="px-3 w-full">
               <div class=" mt-4 w-full" v-for="activity in card.todo_activities" :key="activity.id">
                  <div v-if="activity.isEdit" class="mt-3 ms-4">
                     <ckeditor :editor="editor" v-model="activity.description"></ckeditor>
                     
                     <div style="display: flex; gap: 10px;">
                     <button class="btn-sm btn-primary mt-2" @click="saveActivity(activity)"> Save </button>
                           <button class="btn-sm btn-secondary mt-2" @click="activity.isEdit = !activity.isEdit"> Cancel </button>
                     </div>
                  </div>
                  <div v-else>
                        <p class = "m-0 p-0">{{ activity.user.display_name }} {{ activity.created_at }}</p>
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

         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-label me-1"></i> Labels</button>
         <!-- <div class="input-icon-container">
            <i class="icofont icofont-clock-time"></i>
            <input type="date" class="btn btn-light detail-btn w-full mb-2" v-model="card.deadline" placeholder="Dates">
         </div> -->
         <button class="btn btn-light detail-btn w-full mb-2" @click="toggleDatePopup"><i class="icofont icofont-clock-time me-1"></i> Dates</button>
         <DatePopup :showPopup="showDatePopup" :position="memberPopupPosition" :card="card"   @close-popup="showDatePopup = false" @save-form="handleDateForm" />

         <button class="btn btn-light detail-btn w-full mb-2" @click="toggleAttachmentPopup"><i class="icofont icofont-clip me-1"></i> Attachment</button>
         <AttachmentPopup :showPopup="showAttachmentPopup" :position="memberPopupPosition" @close-popup="showAttachmentPopup = false" @save-form="handleFileUpload" />


         <!-- <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-chart-flow me-1"></i> Custom Fields</button> -->
         <br><br>
         <small>Actions</small><br>
         <button class="btn btn-light detail-btn w-full mb-2" @click="toggleMovePopup"><i class="icofont icofont-arrow-right me-1"></i> Move</button>
         <!-- <MovePopup :showPopup="showMovePopup" :position="memberPopupPosition" :card="card"   @close-popup="showMovePopup = false" @save-form="handleMoveForm" /> -->

         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-copy-alt me-1"></i> Copy</button>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-archive me-1"></i> Archive</button>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-share me-1"></i> Share</button>
      </div>
   </div>
   
</template>

<script >
import axios from 'axios';
// import Swal from 'sweetalert2';
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import MemberSearchPopup from '@/components/kanban/UserSearchPopup.vue';
import DatePopup from '@/components/kanban/DatePopup.vue';
import AttachmentPopup from '@/components/kanban/AttachmentPopup.vue';
import MovePopup from '@/components/kanban/MovePopup.vue';

export default {
   components: {
      ckeditor: CKEditor.component,
      MemberSearchPopup,
      DatePopup,
      MovePopup,
      AttachmentPopup,
   },
   props:(['card','list_title']),
   data() {
      return {
         editor: ClassicEditor,
         activities:[],
         currentActivity:{
            id:"",
            description:""
         },
         showMemberPopup: false,
         memberPopupPosition: [],
         members:[],
         selectedMember: null,

         showDatePopup: false,
         dateForm: [],
         datePopupPosition:[],

         showAttachmentPopup: false,
         attachments: [],

         showDetails: false,
         descIsEdit: false,

         showMovePopup: false,
         moveForm: [],
      }
  },
   methods:{
   updateDescription(){
      axios.put(`/api/todo/${this.card.id}`, this.card)
      .then((res) => {
         if(res.data){
            this.activities = res.data.activities;
            this.descIsEdit = !this.descIsEdit;
         }
      })
      .catch((error) => {
            console.log(error.message);
      });
   },

   /////////////////////////////////////////////// ACTIVITY METHODS //////////////////////////////////////////////
   getActivities(){
      axios.post(`/api/todo/getActivities`, { 
         todo_id: this.card.id
      })
      .then((res) => {
         if(res.data){
            this.activities = res.data.data;
         }
      })
      .catch((error) => {
            console.log(error.message);
      });
   },
   saveActivity(activity){
      console.log(activity);
      axios.post(`/api/todo/saveActivity`, {
            id: activity.id,
            todo_id: this.card.id,
            user_id: this.card.user_id,
            description: activity.description,
         })
      .then((res) => {
         if(res.data){
            this.activities = res.data.data;
            // this.activity.id = "";
            // this.activity.description = "";
            
            activity.isEdit = true;
         }
      })
      .catch((error) => {
            console.log(error.message);
      });
   },
   editActivity(activity){
      // this.currentActivity.id = activity.id;
      // this.currentActivity.description = activity.description;
      // console.log(this.currentActivity.description);
      activity.isEdit = true;
   },
   deleteActivity(activity){
      axios.post(`/api/todo/deleteActivity`, {
            id: activity.id,
            todo_id: this.card.id,
            user_id: this.card.user_id,
            description: activity.description,
         })
      .then((res) => {
         if(res.data){
            this.activities = res.data.data;
         }
      })
      .catch((error) => {
            console.log(error.message);
      });
   },
   /////////////////////////////////////////////// ACTIVITY METHODS //////////////////////////////////////////////
   /////////////////////////////////////////////// FOR MEMBERS METHOD ////////////////////////////////////////////
   toggleMemberPopup(event) {
      console.log(event);

      this.showMemberPopup = !this.showMemberPopup;
      // if (this.showMemberPopup) {
      //   const button = this.$refs.membersButton;
      //   this.memberPopupPosition = button.getBoundingClientRect();
      // }
   },
    handleMemberSelect(member) {
      this.selectedMember = member;
      console.log('Selected member:', this.selectedMember);
      // save member to todo_members

      axios.post(`/api/todo/save-member`, { 
         todo_id: this.card.id,
         user_id: this.selectedMember.user_id,
      })
      .then((res) => {
         if(res.data){
               this.members = res.data.data;
               this.showMemberPopup = !this.showMemberPopup;
               console.log(this.members);
         }
      })
      .catch((error) => {
         console.log(error.message);
      });
    },
   /////////////////////////////////////////////// FOR DATE METHOD ////////////////////////////////////////////
   toggleDatePopup(event) {
      console.log(event);
      this.showDatePopup = !this.showDatePopup;
   },
    handleDateForm(dateForm) {
      this.dateForm = dateForm;
      this.card.start_date = dateForm.start_date;
      this.card.due_date = dateForm.due_date;
      this.card.due_time = dateForm.due_time;
      this.card.reminder = dateForm.reminder;
      this.card.reminder_date = dateForm.reminder_date;

      console.log(this.card);

      axios.put(`/api/todo/${this.card.id}`, this.card)
      .then((res) => {
         if(res.data){
            this.showDatePopup = !this.showDatePopup;
         }
      })
      .catch((error) => {
            console.log(error.message);
      });
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
   getAttachments(){
      axios.post(`/api/todo/getAllUploads`, { 
         todo_id: this.card.id
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
   /////////////////////////////////////////////// FOR DATE METHOD ////////////////////////////////////////////
   toggleMovePopup(event) {
      this.showMovePopup = !this.showMovePopup;
   },
    handleMoveForm(moveForm) {
      console.log("moveForm");
      console.log(moveForm);
      this.moveForm = moveForm;
      this.card.entityType = moveForm.entityType;
      this.card.entityId = moveForm.entityId;
      this.card.position = moveForm.position;

      console.log(this.card);

      axios.put(`/api/todo/${this.card.id}`, this.card)
      .then((res) => {
         if(res.data){
            this.showMovePopup = !this.showMovePopup;
         }
      })
      .catch((error) => {
            console.log(error.message);
      });
    },
   /////////////////////////////////////////////// FOR DATE METHOD ////////////////////////////////////////////
   toggleshowDetails() {
      this.showDetails = !this.showDetails;
   },
  },
}
</script>