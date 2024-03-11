<style scoped>
   .add-card{
      font-weight: 400;
      width:100%;
      text-align: left;
      border: 1px solid #1e5bb2 !important;
      color: #1e5bb2 !important;
   }

   .btn-primary {
      background-color: #1e5bb2 !important;
      border-color: #1e5bb2 !important;
   }
   
</style>
<template>
   <div id="app" class="p-15">

      <div id="KanbanContainer" class=" kanban-container" style="width: 100%;overflow-x: scroll;display:-webkit-box">
         
      <draggable class="dragArea" @change="log">
         <template v-for="k in Lists" :key="k.id">
            <!-- LIST -->
            <div data-id="_todo" data-order="1" class="kanban-board" style="width: 295px !important; height:fit-content !important; margin-left: 7px; margin-right: 7px;">
               <header class="kanban-board-header info">
               <div class="kanban-title-board">{{ k.title }}</div>
               <div class="pull-right"><i class="icofont icofont-justify-all"></i></div>
               </header>
               <main class="kanban-drag" style="padding:10px !important;">
                  <div v-if="cards[k.title]" >
                     <draggable class="dragArea" @change="log">
                        <template v-for="card in cards[k.title]" :key="card.id">

                           <!-- <a @click="getCard(card)" class="kanban-box" href="javascript:void(0)"> -->
                           <a class="kanban-box" href="javascript:void(0)" data-bs-toggle="modal" :data-bs-target="'#cardModal'+card.id">
                           <!-- <a @click="getCard(card)" class="kanban-box" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#cardModal"> -->
                                 <KanbanCard class="mb-2" :card="card"/>
                           </a>
                           <div class="modal fade" :id="'cardModal'+card.id" tabindex="-1" aria-labelledby="cardModal" aria-hidden="true" style="display: none;">
                              <div class="modal-dialog modal-dialog-centered modal-lg">
                              <div class="modal-content">
                                 <div class="modal-body">
                                    <!-- <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button> -->
                                    <CardDetail :card="card" :list_title="k.title"/>
                                 </div>
                              </div>
                              </div>
                           </div>
                        </template>
                     </draggable>
                  </div>

                  <div v-show="k.showAddCard" id="newCard">
                        <textarea v-model="k.card_title" @keydown.enter.prevent="addCard(k);setTheFocus(k.id)" :id="'newCardTitle'+k.id" class="form-control mb-2" placeholder="Enter a title for this card..." style="border-radius: 8px;"></textarea>
                  </div>
                  <button v-if="!k.showAddCard" @click="k.showAddCard=true;setTheFocus(k.id);" class="btn btn-light fs-7 mt-2 text-muted add-card"><i class="icofont icofont-plus me-2"></i>Add a card</button>
                  
                  <button  v-if="k.showAddCard" @click="addCard(k)" class="btn btn-sm btn-primary fs-7" style="font-weight: 400;">Add a card</button> 
                  <button  v-if="k.showAddCard" @click="k.showAddCard=false" class="btn btn-default fs-7" style="font-weight: bold;">X</button> 
               
               </main>
               <footer></footer>
            </div>
            
         </template>
      </draggable>
      <!-- New LIST -->
      <!-- <div class="kanban-board" style="width: 295px !important; height:fit-content !important; margin-left: 7px; margin-right: 7px;-webkit-box-shadow:none;box-shadow:none;">
         <main class="kanban-drag" style="padding: 10px !important;min-height: 55px !important;">
            <div v-if="showAddList" id="newList">
               <input type="text" v-model="list_title" class="form-control mb-2" placeholder="Enter list title..." style="border-radius: 8px;">
            </div>
            <button v-if="!showAddList" @click="showAddList=true" type="button" class="btn btn-light fs-7 text-muted" style="font-weight: 400;width: 100%;text-align: left;"><i class="icofont icofont-plus me-2"></i>Add List</button>
            
            <button  v-if="showAddList" @click="addList" type="button" class="btn btn-sm btn-primary fs-7" style="font-weight: 400;">Add List</button> 
            <button  v-if="showAddList" @click="showAddList=false"  type="button" class="btn btn-default fs-7" style="font-weight: bold;">X</button> 
         </main>
         <footer></footer>
      </div> -->

      </div>
     
   </div>
 </template>
 
 
 <script setup>
 import { VueDraggableNext } from 'vue-draggable-next';
 import KanbanCard from '@/Pages/todo/kanban/Card.vue';
 import CardDetail from '@/Pages/todo/kanban/CardDetail.vue';
 import { router } from '@inertiajs/vue3';
 
 </script>
 
 <script>
 import axios from 'axios';
 import Swal from 'sweetalert2';
 
 export default {
   props:(['lists','cards']),
   mounted(){
     this.scrollRight();
   },
   components: {
       CardDetail,
       draggable: VueDraggableNext,
   },
   data(props) {
     return {
       Lists: props.lists,
       Cards: props.cards,
       showAddList:false,
       list_title:'',
 
       showAddCard:false,
       // card_title : '',
       
     }
   },
   methods:{
     log(event) {
         console.log(event)
     },
     addList(){
       if(this.list_title=='')
       {
         Swal.fire({
           html: 'Please name your list.',
           icon: "error",
           buttonsStyling : false,
           confirmButtonText : "OK, Got It!",
           customClass: {
             confirmButton: 'btn btn-md btn-danger text-white',
         }});
 
       }else{
 
         axios.post('/kanban/add-list', { 
           list_title:this.list_title
         })
         .then((res) => {
           if(res.data.success)
           {
             this.Lists.push({ id: res.data.last_id, title: this.list_title });
             this.list_title = '';
             this.showAddList = false;
             this.scrollRight();
             router.reload();
           }else{
             Swal.fire({
               title: 'Action Failed! '+res.data.message,
               icon: "error",
               buttonsStyling : false,
               confirmButtonText : "OK, Got It!",
               customClass: {
                 confirmButton: 'btn btn-md btn-danger text-white',
             }});
           }
         })
         .catch((error) => {
             console.log(error.message);
         });
       }
     },    
     addCard(list){

          if(list.card_title=='')
          {
             Swal.fire({
                html: 'Please name your card.',
                icon: "error",
                buttonsStyling : false,
                confirmButtonText : "OK, Got It!",
                customClass: {
                   confirmButton: 'btn btn-md btn-danger text-white',
             }});
 
          }else{
            axios.post(`/api/todo`, {
               entityId : 0,
               entityType : list.title,
               title : list.card_title
            })
            .then((res) => {
               if(res.data){
                  list.showAddCard=false
                  list.card_title = "";
                  this.getCards(list.title);
               }else{
                   Swal.fire({
                   title: 'Failed! '+res.data.message,
                   icon: "error",
                   buttonsStyling : false,
                   confirmButtonText : "OK, Got It!",
                   customClass: {
                      confirmButton: 'btn btn-md btn-danger text-white',
                   }});
                }
            })
            .catch((error) => {
                  console.log(error.message);
            });
          }
       },
       getCards(list_id){
          axios.get('/api/todo', {
               entityType : list_id,
            })
          .then((res) => {
             if(res.data.cards)
             {
               this.cards[list_id] = res.data.cards[list_id];
             }
          })
          .catch((error) => {
                console.log(error.message);
          });
       },
       setTheFocus(list_id){
         let id = 'newCardTitle' + list_id;
         let newCardElement =  document.getElementById(id);
         newCardElement.focus();
       },
       scrollRight(){
         var element = document.getElementById('KanbanContainer');
         element.scrollLeft = element.scrollWidth + 200;
       }
   }
 }
 </script>
 