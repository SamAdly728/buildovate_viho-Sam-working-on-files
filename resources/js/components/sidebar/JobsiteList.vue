<template>
    <div class="d-flex flex-column gap-0 px-4">
        <div class="card-body m-0 p-0" v-if="store.selectedJobsites.length === 1">
            <ul class="cursor-default">
              <li>
                <div>
                  <h5 class="f-w-600 txt-dark truncate f-16" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    :title="store.selectedJobsites[0].jobsite_name">
                    {{ store.selectedJobsites[0].jobsite_name }}
                  </h5>
                  <div class="d-flex flex-column mt-2 f-14 f-w-600 text-muted">
                    <a class="f-w-400 txt-dark truncate">{{ store.selectedJobsites[0].street }}</a>
                    <a class="f-w-400 txt-dark truncate">{{ store.selectedJobsites[0].city }}</a>
                    <a class="f-w-400 txt-dark truncate">{{ store.selectedJobsites[0].state }} {{ store.selectedJobsites[0].zipcode}}</a>
                    <hr>
                    <a class="f-w-700 d-flex justify-content-between">Current Total: <a>$0.0</a></a>
                    <hr>
                  </div>
                </div>
              </li>
            </ul>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <p class="text-dark f-14 f-w-700">Project</p>
            <p class="text-dark f-14 f-w-700">Leads</p>
            <a class="text-muted f-14 f-w-600" style="cursor: pointer;" @click="handleSelectAll">{{ this.store.selectedJobsites.length != this.jobsites.length ? 'Select All' : 'Unselect All'}}</a>
        </div>
        <div class="bg-main px-3 py-2 d-flex align-items-center gap-2" style="border-radius: 5px;">
            <i class="icon-search"></i>
            <input type="text" class="f-14 p-0 text-muted flex-grow-1" style="border: 0px; background-color: transparent;"/>
            <i class="icon-filter" style="cursor: pointer;"></i>
        </div>
        <hr>
        <div class="d-flex justify-content-center align-items-center f-14 f-w-600 text-muted" v-if="loading">
            <i class="fa fa-spin fa-spinner me-2"></i>Loading...
        </div>
        <div v-else-if="jobsites.length != 0">
            <template v-for="jobsite in jobsites">
                <div class="p-2 bg-hover-primary f-14 f-w-600 text-muted" :class="store.selectedJobsites.length != 0 && store.selectedJobsites.find(j => j.jobsite_id === jobsite.jobsite_id) ? 'bg-main' : ''"
                style="cursor: pointer; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                <a class="text-dark p-2" @click="handleSelectJobsite(jobsite)">{{ jobsite.jobsite_name }}</a>
            </div>
            </template>
        </div>
        <div class="d-flex justify-content-center align-items-center" v-else>
            <a class="btn btn-primary-v2">Create Jobsite</a>
        </div>
    </div>
</template>
<script>
import { usePage } from '@inertiajs/inertia-vue3';
import { useSideBar } from '../../stores/sidebar';
import axios from 'axios';

export default {
    setup(){
        const page = usePage();
        const store = useSideBar();

        return { page, store }
    },
    data(){
        const jobsites = [];
        const loading = false;

        return {
            jobsites,
            loading
        };
    },
    methods: {
        handleSelectAll(){
            if(this.store.selectedJobsites.length != this.jobsites.length){
                this.store.setSelectedJobsite(this.jobsites);
            }else{
                this.store.setSelectedJobsite([]);
            }
        },
        handleSelectJobsite(jobsite){
            this.store.setSelectedJobsite([jobsite]);

            // console.log(this.store.selectedJobsites)
        },
        async fetchJobsites(search, filters){
            try {
                this.loading = true;
                const response = await axios.get('/api/jobsites', {
                params: {
                    search: search,
                    savedFilter: filters.savedFilter,
                    groups: filters.groups,
                    status: filters.status,
                    projectmanagers: filters.projectmanagers
                },  // Pass the page as a query parameter
                headers: {
                    'Authorization': 'Bearer ' + this.page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
                });
                const data = response.data;

                if(data.status === 'success'){
                    this.jobsites = data.data.data;
                }else{
                    console.error("Error fetching jobsites status is fail");
                }

                this.loading = false;
            } catch (error) {
                this.loading = false;
                console.error("Error fetching jobsites: ", error);
            }
        }
    },
    mounted(){
        this.fetchJobsites('', {})
    }
}
</script>