<style scoped>
.progress-bar{
    border-radius: 0 !important;
}
.card{
    /* min-height:384px; */
    border: none !important;
}

* {
  font-family: 'Inter', sans-serif;
}
</style>
<style>
    .custom-rounded {
    border: 1px solid #e6edef;
    border-radius: 10px !important;
    }

    .bg-gray{
        background-color: #F5F9FF !important;
    }
    .inter-font{
        font-family: 'Inter', sans-serif !important;
    }
    .no-border{
        border: none !important;
    }
</style>

<template>
    <div class="container-fluid pt-5">
        <div class="row">
            <div class="col-md-4 d-flex">
                <div class="card w-100 p-0">
                    <LeadDetails :jobsite_id="jobsite_id" />
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="card flex-grow-1 pt-4">
                    <LeadOtherAction :showTitle="false"/>
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="card w-100">
                    <div class="card-body pt-3">
                        <ProgressBar />
                    </div>
                </div>
            </div>
        </div>

       <Calendar :heigth="400" :initialView="'timeGridWeek'"></Calendar>

        <div class="row">
            <div class="col-md-12">
                <div class="card" style="height:470px;">
                    <!-- <div class="card-body p-10">
                        <Kanban :lists="lists" :cards="cards" />
                    </div> -->
                    <div class="card-header pb-0">
                        <h5>Photos</h5>
                    </div>
                    <div class="card-body pt-2" style="height:384px;overflow-y: scroll;">
                        <Gallery />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 d-flex">
                <EmployeeStatus/>
            </div>
            <div class="col-md-6 d-flex">
                <MaterialStatus/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7 d-flex">
                <div class="card w-100 p-0 m-0">
                    <div class="card-header pb-0">
                        <h5>Contact</h5>
                    </div>
                    <div class="card-body">
                        <ContactForm/>
                    </div>
                </div>
            </div>
            <div class="col-md-5 d-flex">
                <div class="card w-100">
                    <div class="card-header pb-0">
                        <h5>Recent Activities</h5>
                    </div>
                    <div class="card-body m-0 p-0" style="height:384px;overflow-y: scroll;">
                        <Activities/>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Photos</h5>
                    </div>
                    <div class="card-body p-10 pt-2">
                        <ul class="nav nav-tabs search-list mt-3 mx-2" id="top-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="all-link" data-bs-toggle="tab" href="#all-links" role="tab" aria-selected="true">
                                <i class="icon-menu"></i>All</a>
                                <div class="material-border"></div>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="image-link" data-bs-toggle="tab" href="#image-links" role="tab" aria-selected="false">
                                <i class="icon-notepad"></i>Notes</a>
                                <div class="material-border"></div>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="video-link" data-bs-toggle="tab" href="#video-links" role="tab" aria-selected="false">
                                <i class="icon-email"></i>Emails</a>
                                <div class="material-border"></div>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="map-link" data-bs-toggle="tab" href="#map-links" role="tab" aria-selected="false">
                                <i class="icon-comment"></i>Messages</a>
                                <div class="material-border"></div>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="setting-link" data-bs-toggle="tab" href="#setting-links" role="tab" aria-selected="false">
                                <i class="icon-headphone-alt"></i>Calls</a>
                                <div class="material-border"></div>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="setting-link" data-bs-toggle="tab" href="#setting-links" role="tab" aria-selected="false">
                                <i class="icofont icofont-check-circled"></i>Jobsite Checklist</a>
                                <div class="material-border"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="height:384px;overflow-y: scroll;">
                    <div class="card-header pb-0">
                        <h5>Recent files</h5>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Added on</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(file,index) in recentFiles" :key="index">
                                <td><span>{{ file.file_name }}</span></td>
                                <td><span>{{ Math.trunc(Math.round(file.file_size / 1024 * 100) / 100) + ' KB' }}</span></td>
                                <td><span>{{ formatDateValue(file.created_at) }}</span></td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</template>

<script setup>
import LeadDetails from './sales/lead/LeadDetailsCard.vue';
import LeadOtherAction from './sales/lead/LeadOtherActionsCard.vue';
import ProgressBar from '@/components/projects/ProgressBar2.vue';
import Kanban from '@/components/Kanban.vue';
import Installers from '@/components/projects/Installers.vue';
import EmployeeStatus from '@/pages/projects/EmployeeStatus.vue';
import MaterialStatus from '@/pages/projects/MaterialStatus.vue';
import Gallery from '@/components/projects/Gallery.vue';
import Activities from '@/components/projects/Activities.vue';
import ContactForm from '@/components/projects/ContactForm.vue';

import { ref, watch } from 'vue';

import Calendar from '@/components/Calendar.vue';

defineProps(['lists','cards','recentFiles', 'sessionVars']);

const jobsite_id = ref(0);

function formatDateValue(date) {
  let newDate = new Date(date)
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  const month = months[newDate.getMonth()];
  const day = newDate.getDate();
  const year = newDate.getFullYear();
  let hours = newDate.getHours();
  const minutes = newDate.getMinutes();
  const ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12;
  const minutesStr = minutes < 10 ? '0' + minutes : minutes;
  return `${month} ${day}, ${year}, ${hours}:${minutesStr} ${ampm}`;
}
</script>