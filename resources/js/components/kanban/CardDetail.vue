<style scoped>
.detail-btn{
   text-align: left !important;
   font-weight: 400 !important;
   padding: 5px 5px 5px 15px !important;
}
</style>
<template>
   <div class="row mt-5">
      <div class="col-md-12 p-10">
         
      </div>
   </div>
   <div class="row">
      <div class="col-md-9">
         <h5><i class="icofont icofont-card"></i> {{ card.title }}</h5>
         <small class="ms-4">in list <u>{{ list_title }}</u></small>
         <div class="mt-3 ms-4">
            <table width="70%">
               <tr>
                  <td width="20%">Members</td>
                  <td width="40%">Due Date</td>
               </tr>
               <tr>
                  <td>
                     <img class="img-20 rounded-circle" :src="'/assets/images/user/3.jpg'" alt="" data-original-title="" title="" style="    display: inline-block;">
                     <a href="#"><i class="icofont icofont-plus-circle fs-5 ms-1"></i></a>
                  </td>
                  <td>tomorrow at 7:20 PM <span class="badge badge-warning text-dark">Due Soon</span></td>
               </tr>
            </table>
         </div>

         <div class=" mt-4"><i class="icofont icofont-justify-left"></i> Description</div>
         <div class="mt-2 ms-4">
            <textarea class="form-control bg-light" placeholder="Add a more detailed description..."></textarea>
         </div>

         <div class=" mt-4 w-full">
            <i class="icofont icofont-clip"></i> 
            Attachments
            <button class="btn btn-sm btn-light pull-right">Add</button>
         </div>

         <div class=" mt-4 w-full">
            <i class="icofont icofont-listine-dots"></i> Activity
            <button class="btn btn-sm btn-light pull-right">Show Details</button>
            <div class="mt-3 ms-4">
               <textarea class="form-control" placeholder="Write a comment..."></textarea>
            </div>
         </div>

      </div>
      <div class="col-md-3">
         <small>Add to card</small><br>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-user-alt-3 me-1"></i> Members</button>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-label me-1"></i> Labels</button>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-clock-time me-1"></i> Dates</button>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-clip me-1"></i> Attachment</button>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-chart-flow me-1"></i> Custom Fields</button>
         <br><br>
         <small>Actions</small><br>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-arrow-right me-1"></i> Move</button>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-copy-alt me-1"></i> Copy</button>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-archive me-1"></i> Archive</button>
         <button class="btn btn-light detail-btn w-full mb-2"><i class="icofont icofont-share me-1"></i> Share</button>
      </div>
   </div>
</template>

<script setup>
// defineProps(['card']);
// console.log('CardDetail:card_id',card);
</script>

<script >
import axios from 'axios';
import Swal from 'sweetalert2';

export default {

   props:(['card','list_title']),
   data(props) {
      console.log('CardDetail:card_id',props.card);
      return {
         card:props.card,
         list_title:props.list_title
      }
  },
   methods:{
   // getCard(){
   //    axios.post('/kanban/get-card', { 
   //          card_id: this.card_id
   //    })
   //    .then((res) => {
   //       console.log('data',res.data.card)
   //       if(res.data)
   //       {
   //          this.data = res.data.card;
   //       }
   //    })
   //    .catch((error) => {
   //          console.log(error.message);
   //    });
   // }
  },
//   mounted(){
//    this.getCard();
//   }
}
</script>