<template>
    <div class="modal fade" id="jobTypeModal" tabindex="-1" role="dialog" aria-labelledby="jobTypeModal" aria-hidden="true" style="overflow: hidden">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0 m-0">
                <div class="card p-0 m-0">
                    <div class="card-header border">
                        <h5>{{ props.type === 'add' ? 'New Job Type' : 'Edit Job Type'}}</h5>
                        <small v-if="props.type !== 'add'">Selected Job Type is based on the first item in the field</small>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card-body p-4 position-relative">
                        <label class="form-label f-w-600">Job Type Name</label>
                        <input class="form-control border-success" id="job_type_name" type="text" :value="props.selected.text" :disabled="loading">
                    </div>
                    <div class="d-flex justify-content-between p-4" v-if="!loading">
                        <button class="btn btn-danger" v-if="props.type !== 'add'" @click="handleClick('delete')">Delete</button>
                        <div></div>
                        <div>
                            <button class="btn btn-light  mr-2" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" @click="handleClick(props.type === 'add' ? 'add' : 'edit')">Submit</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between p-4" v-else>
                        <div></div>
                        <button class="btn btn-danger" disabled><i class="fa fa-spin fa-spinner me-2"></i> Loading</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, nextTick } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const page = usePage();
const loading = ref(false);
const props = defineProps({
type: {
    type: String,
    default: ''
},
selected: {
    type: Object,
    default: {
        id: 0,
        text: ''
    }
}
});


const emit = defineEmits(['click'])

function handleClick(type) {
if(type === 'add'){
    add();
}else if(type === 'edit'){
    edit(props.selected.id);
    updateEmit(); //NOT SURE ABOUT THIS ONE
}else if(type === 'delete'){
    Swal.fire({
    title: 'Delete JOB TYPE',
    text: "Are you sure you want to delete this job type?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Proceed'
  }).then((result) => {
    if (result.isConfirmed) {
        deleteJobType(props.selected.id);
    }
  });
}
}

const updateEmit = () => {
emit('click', {
                type: 'edit',
                value: {
                    id: props.selected.id,
                    text: document.querySelector('#job_type_name').value
                }
            });
    setTimeout(() => {
            emit('click', {
                type: 'edit',
                value: {
                    id: props.selected.id,
                    text: document.querySelector('#job_type_name').value
                }
            });
        }, 0);
}

const add = async () => {
try {
    loading.value = true;
    const jobTypeName = document.querySelector('#job_type_name').value;

    const response = await axios.post('/api/jobTypes', { job_type_name: jobTypeName }, {
        headers: {
            'Authorization': 'Bearer ' + page.props.csrf_token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    if (response.status === 201) {
        const job_type_id = response.data.data;
        loading.value = false;

        document.querySelector('#jobTypeModal .btn-close').click();
        emit('click', {
            type: 'add',
            value: {
                id: job_type_id,
                text: jobTypeName
            }
        });
        Swal.fire({
            icon: 'success',
            title: 'Create Job Type Successful!',
            text: 'You can now select the newly created job type.',
        });
    } else {
        loading.value = false;
        const message = response.data.errors.job_type_name;
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: message? message : 'ERROR MESSAGE: FETCHING ADDING JOB TYPE.',
        });
    }
} catch (error) {
    if (axios.isAxiosError(error)) {
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: 'Error adding job type: ' + error.response?.data || error.message
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: 'Non-HTTP error: ' + error
        });
    }
} finally {
    loading.value = false;
}
}

const edit = async (id) => {
try {
    loading.value = true;
    const jobTypeName = document.querySelector('#job_type_name').value;

    const response = await axios.put(`/api/jobTypes/${id}`, { job_type_name: jobTypeName }, {
        headers: {
            'Authorization': 'Bearer ' + page.props.csrf_token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    if (response.status === 201) {
        const job_type_id = response.data.data;
        loading.value = false;

        document.querySelector('#jobTypeModal .btn-close').click();
        emit('click', {
            type: 'edit',
            value: {
                id: job_type_id,
                text: jobTypeName
            }
        });
        Swal.fire({
            icon: 'success',
            title: 'Update Job Type Successful!',
            text: 'You can now select the newly updated job type.',
        });
    } else {
        loading.value = false;
        const message = response.data.errors.job_type_name;
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: message? message : 'ERROR MESSAGE: FETCHING UPDATING JOB TYPE.',
        });
    }
} catch (error) {
    if (axios.isAxiosError(error)) {
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: 'Error updating job type: ' + error.response?.data || error.message
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: 'Non-HTTP error: ' + error
        });
    }
} finally {
    loading.value = false;
}
}

const deleteJobType = async (job_type_id) => {
try {
    loading.value = true;
    const response = await axios.delete(`/api/jobTypes/${job_type_id}`, {}, {
        headers: {
            'Authorization': 'Bearer ' + page.props.csrf_token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    if (response.status === 201) {
        loading.value = false;

        document.querySelector('#jobTypeModal .btn-close').click();
        emit('click', {
            type: 'delete',
            value: {
                id: job_type_id,
                text: ''
            }
        });
        Swal.fire({
            icon: 'success',
            title: 'Delete Job Type Successful!',
            text: 'You have successfully deleted a job type.',
        });
    } else {
        loading.value = false;
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: 'ERROR MESSAGE: FETCHING DELETING JOB TYPE.',
        });
    }
} catch (error) {
    if (axios.isAxiosError(error)) {
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: 'Error deleting job type: ' + error.response?.data || error.message
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: 'Non-HTTP error: ' + error
        });
    }
} finally {
    loading.value = false;
}
}

</script>