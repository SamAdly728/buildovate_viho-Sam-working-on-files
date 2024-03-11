<style scoped>
.title-col{
  width:200px;
  /* text-align: center; */
  vertical-align: middle;
}

.opt-col{
  width:300px;
  text-align: center;
  vertical-align: top;
}
.done{
  text-decoration:line-through;
  font-style:italic;
  color:#cccccc;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}

.btn-group{
  vertical-align: bottom;
}
</style>
<template>
  <br>
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
      <div class="row">
        <div class="col-xl-12 col-md-12 box-col-12">
          <div class="email-right-aside bookmark-tabcontent">
            <div class="card email-body radius-left">
              <div class="ps-0">
                <div class="tab-content">
                  <div class="tab-pane fade active show" id="pills-created" role="tabpanel" aria-labelledby="pills-created-tab">
                    <div class="card mb-0">
                      <div class="card-header">

                        <h5 class="mb-0">{{ filterName }}</h5>

                        

                        <button v-if="showTaskBtn" @click="toggleTaskForm" class="btn btn-success btn-md" href="javascript:void(0)">
                          Add New Task        
                        </button>
                        
                        

                      </div>

                      

                      <div class="card-body p-4">
                        
                        <!-- ADD TASK FORM -->
                        <Transition name="slide-fade">
                          <div v-if="showTaskForm" class="card ribbon-wrapper p-3">
                            <form>
                              <div class="mb-3">
                                <div class="row">

                                  <div class="col-md-6">
                                    <label class="col-form-label">Project Name:</label>
                                    <select v-model="form.project_id" class="form-control js-example-basic-single">
                                      <option value="0">Choose project name...</option>
                                      <option v-for="p in projects" :key="p.id" :value="p.id">{{ p.title }}</option>
                                    </select>
                                  </div>

                                  <div class="col-md-6">
                                    <label class="col-form-label">Jobsite Name:</label>
                                    <select v-model="form.jobsite_id" class="form-control js-example-basic-single">
                                      <option value="0">Choose jobsite...</option>
                                      <option v-for="j in jobsites" :key="j.id" :value="j.jobsite_id">{{ j.jobsite_name }}</option>
                                    </select>
                                  </div>

                                </div>

                              </div>
                              <div class="mb-3">
                                <label class="col-form-label">Task Name:</label>
                                <input 
                                        v-model="form.title" 
                                        class="form-control"
                                        placeholder="Enter task name..."/>
                              </div>
                              <div class="mb-3">
                                <label class="col-form-label">Task Description:</label>
                                <textarea 
                                        v-model="form.description" 
                                        class="form-control"
                                        placeholder="Enter description..."
                                        rows="3">
                                </textarea>
                              </div>
                              <div class="mb-3 text-end">
                                <button class="btn btn-secondary" type="button" @click="closeTaskForm">Close</button>&nbsp;
                                <button class="btn btn-primary" type="button" @click="saveTask">Add Task</button>
                              </div>
                            </form>
                          </div>
                        </Transition>
                        

                        <!-- TASK LIST -->
                        <div class="taskadd">
                            
                          <div class="table-responsive">
                            <!-- FILTER DROPDOWNS -->
                            <div class="row">
                              <div class="col-md-4">
                                
                                <form class="search-form" @submit.prevent="submitSearch">
                                  <input v-model="form.search" type="text" @keyup.enter="submitSearch" name="search" id="search"  class="form-control-plaintext" placeholder="Search..">
                                </form>

                              </div>
                              <div class="col-md-8">
                                
                                
                                <!-- <div class="mark-all-tasks-container">
                                  <span class="mark-all-btn" id="mark-all-finished" role="button">
                                    <span class="btn-label">Mark all as finished</span>
                                    <span class="action-box completed"><i class="icon"><i class="icon-check"></i></i></span>
                                  </span>
                                  <span class="mark-all-btn move-down" id="mark-all-incomplete" role="button">
                                    <span class="btn-label">Mark all as Incomplete</span>
                                    <span class="action-box"><i class="icon"><i class="icon-check"></i></i></span>
                                  </span>
                                </div> -->

                                <div class="dropdown-basic text-right m-r-20">
                                  <div class="dropdown">
                                    <button class="dropbtn btn-info" type="button">
                                      Filter Tasks
                                      <span><i class="icofont icofont-arrow-down"></i></span>
                                    </button>
                                    <div class="dropdown-content text-left" style="margin-top:-3px !important;">
                                      <Link v-for="f in taskFilters" :key="f.name" :href="f.href+'&search='+form.search" :name="f.name"></Link>
                                    </div>
                                  </div>
                                </div>

                                <!-- <div class="col-md-5">
                                  <label class="col-form-label">Project Name:</label>
                                  <select v-model="form.project_id" class="form-control js-example-basic-single">
                                    <option value="0">Choose project name...</option>
                                    <option v-for="p in projects" :key="p.id" :value="p.id">{{ p.title }}</option>
                                  </select>
                                </div> -->

                                <!-- <div class="col-md-5">
                                  <label class="col-form-label">Jobsite Name:</label>
                                  <select v-model="form.jobsite_id" class="form-control js-example-basic-single">
                                    <option value="0">Choose jobsite...</option>
                                    <option v-for="j in jobsites" :key="j.id" :value="j.jobsite_id">{{ j.jobsite_name }}</option>
                                  </select>
                                </div> -->
                                

                              </div>
                            </div>

                            <table class="table">
                              <thead>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td class=" text-center">Assigned To</td>
                                  <td class=" text-center">Due Time</td>
                                  <td>&nbsp;</td>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="t in tasks.data" :key="t.id">
                                  <td  class="title-col" :class="(t.status==1) ? 'done' : 'text-success'">
                                    <h6>{{ t.task_name }}</h6>
                                    <small>{{ t.jobsite_name }}</small>
                                  </td>
                                  <td :class="(t.status==1) ? 'done' : 'text-success'">
                                    {{ t.description }}
                                  </td>
                                  <td class="text-center">
                                    <a class="btn btn-block" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#assignTask" data-bs-original-title="" style="margin-left: 0px !important;padding-left: 15px !important;font-weight: 400;">
                                      Assign
                                    </a>
                                  </td>
                                  <td class="text-center">00:00</td>
                                  <td class="opt-col">
                                    <BtnDropdown name="Next Action" :links="dropDownLinks"></BtnDropdown>&nbsp;
                                    <a @click="removeTask(t)" href="javascript:void(0)" :class="(t.status==1) ? 'text-danger' : 'text-success'">
                                      <i class="icon-trash fs-4"></i>
                                    </a>&nbsp;

                                    <a @click="setStatus(t)" href="javascript:void(0)" :class="(t.status==1) ? 'text-default' : 'text-success'">
                                      <i class="fs-4" :class="(t.status==1) ? 'icon-check-box ' : 'icon-check'"></i>
                                    </a>
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <Paginate v-if="tasks.data.length && tasks.data.length>0" :search="form.search" :filterUrl="filterUrl" :prev="tasks.prev_page_url" :next="tasks.next_page_url" :totalItems="tasks.total" :links="tasks.links" :fromRow="tasks.from" :toRow="tasks.to"/>

                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="assignTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                Assign Task
            </h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-md-8">
                    <label>Choose:</label>
                    <select name="" id="" class="form-control form-control-sm">
                      <option value="">Select...</option>
                      <option v-for="u in users" :key="u.id" :value="u.id">{{ u.display_name }}</option>
                    </select>
                  </div>
              </div>
            </div>
            <div class="p-10 text-right" style="border-top: 1px solid #dee2e6;">
              <button class="btn btn-default" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>&nbsp;
              <button class="btn btn-primary">Assign</button>
            </div>
        </div>
        </div>
    </div>

  </div>
  <!-- Container-fluid Ends-->


  <!-- <Kanban /> -->

</template>

<script setup>
// import Kanban from "@/Pages/Kanban.vue";
import Paginate from "@/components/Paginate.vue";
import Link from "@/components/Link.vue";
import BtnDropdown from "@/components/BtnDropdown.vue";

const taskFilters = [
  { name: "Daily Checklist", component:'Dashboard', href: '?filter=daily-checklist', icon:'ki-chart-pie-3 text-info'},
  { name: "Today's Tasks", component:'Dashboard', href: '?filter=todays-task', icon:'ki-chart-pie-3 text-info'},
  { name: "Delayed Tasks", component:'Dashboard', href: '?filter=delayed-tasks', icon:'ki-chart-pie-3 text-info'},
  { name: "Upcoming Tasks", component:'Dashboard', href: '?filter=upcoming-tasks', icon:'ki-chart-pie-3 text-info'},
  { name: "This Week Tasks", component:'Dashboard', href: '?filter=this-week-tasks', icon:'ki-chart-pie-3 text-info'},
  { name: "This Month Tasks", component:'Dashboard', href: '?filter=this-month-tasks', icon:'ki-chart-pie-3 text-info'},
  { name: "Assigned To Me", component:'Dashboard', href: '?filter=assigned-to-me', icon:'ki-chart-pie-3 text-info'},
  { name: "My Tasks", component:'Dashboard', href: '?filter=my-tasks', icon:'ki-chart-pie-3 text-info'},
];

</script>

<script>
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const page = usePage();

export default {
        name: 'app',
        props: ['filterName','filterUrl','projects','jobsites','tasks','search','users'],
        data(props) {
            return {
                // editor: ClassicEditor,
                form: {
                        project_id: 0,
                        jobsite_id: 0,
                        title: '',
                        description: '',
                        edit_id: '',
                        search: props.search,
                        _token: page.props.csrf_token,
                },
                filterUrl: props.filterUrl,
                current_page: props.tasks.current_page,
                showTaskForm:false,
                showTaskBtn: true,
                dropDownLinks:[
                  { name:'Next Action 1', link: '#' },
                  { name:'Next Action 2', link: '#' },
                  { name:'Next Action 3', link: '#' },
                ]
            }
        },
        methods:{
            openTaskForm(){
                this.showTaskForm = true;
                this.showTaskBtn = false;
            },
            closeTaskForm(){
                this.showTaskForm = false;
                this.showTaskBtn = true;
            },
            clearTaskForm(){
                this.form.proj_id = 0;
                this.form.jobsite_id = 0;
                this.form.title = '';
                this.form.description ='';
                this.form.edit_id = '';
            },
            toggleTaskForm(){
                if(this.showTaskForm)
                {
                    this.closeTaskForm();
                }else{
                    this.form.title = '';
                    this.form.edit_id = '';
                    this.openTaskForm();
                }
            },
            editCategory(c){
                this.form.title = c.title;
                this.form.edit_id = c.id;
                this.openTaskForm();
            },
            submitSearch(){

              let url = window.location.pathname+'?i='; // '/dashboard'
              
              if(this.filterUrl!='')
              {
                url += '&filter=' + this.filterUrl;
              }

              // if(this.current_page!='undefined')
              // {
                url += '&page=1';// + this.current_page;
              // }

              if(this.form.search!='undefined')
              {
                url += '&search=' + this.form.search;
              }

              router.visit(url, { preserveScroll: true });

            },
            saveTask() {
                axios.post('/tasks/save', this.form )
                .then((res) => {
                    if(res.data.success)
                    {
                        if(this.form.edit_id>0)
                        {
                            this.closeTaskForm();
                        }

                        this.clearTaskForm();

                        Swal.fire({
                            text: res.data.status,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-success"
                            }
                        });

                    }else{

                        Swal.fire({
                            text: res.data.status,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                        
                    }

                    router.reload();
                
                })
                .catch((error) => {
                    console.log(error.message);
                });
            },
            setStatus(task) {
                let new_status = (task.status==1) ? 0 : 1;
                axios.post('/tasks/set-status', { id:task.id, status:new_status, _token:this.form._token } )
                .then((res) => {
                    if(res.data.success)
                    {
                      if(new_status==0)
                      {
                        toast.warning(task.task_name + "\n Marked as INCOMPLETE!", {
                          autoClose: 1000,
                        });
                      }else{
                        toast.success(task.task_name + "\n Marked as COMPLETED!", {
                          autoClose: 1000,
                        });
                      }
                      
                    }else{

                        Swal.fire({
                            text: res.data.status,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                        
                    }

                    router.reload();
                
                })
                .catch((error) => {
                    console.log(error.message);
                });
            },
            removeTask(task){
                Swal.fire({
                    html: "Are you sure you want to delete <br><br><h4>"+task.task_name+"</h4><br>?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, return",
                    customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-active-light"
                    }
                }).then(function (result) {
                    if (result.isConfirmed) 
                    {                        
                        axios.delete('/tasks/destroy/'+task.id, { } )
                            .then((res) => {
                                if(res.data.success)
                                {
                                    router.reload();
                                }
                            });

                    }
                });
            },
        }
    }

    

</script>


