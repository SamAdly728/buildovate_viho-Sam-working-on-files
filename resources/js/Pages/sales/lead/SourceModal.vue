<template>
    <div class="modal fade" id="sourceModal" tabindex="-1" role="dialog" aria-labelledby="sourceModal" aria-hidden="true" style="overflow: hidden">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0 m-0">
                <div class="card p-0 m-0">
                    <div class="card-header border">
                        <h5>{{ props.type === 'add' ? 'New Source' : 'Edit Source'}}</h5>
                        <small v-if="props.type !== 'add'">Selected Source is based on the first item in the field</small>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card-body p-4 position-relative">
                        <label class="form-label f-w-600">Source Name</label>
                        <input class="form-control border-success" id="source_name" type="text" :value="props.selected.text" :disabled="loading">
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
    title: 'Delete SOURCE',
    text: "Are you sure you want to delete this source?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Proceed'
  }).then((result) => {
    if (result.isConfirmed) {
        deleteSource(props.selected.id);
    }
  });
}
}

const updateEmit = () => {
emit('click', {
                type: 'edit',
                value: {
                    id: props.selected.id,
                    text: document.querySelector('#source_name').value
                }
            });
    setTimeout(() => {
            emit('click', {
                type: 'edit',
                value: {
                    id: props.selected.id,
                    text: document.querySelector('#source_name').value
                }
            });
        }, 0);
}

const add = async () => {
try {
    loading.value = true;
    const sourceName = document.querySelector('#source_name').value;

    const response = await axios.post('/api/sources', { source_name: sourceName }, {
        headers: {
            'Authorization': 'Bearer ' + page.props.csrf_token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    if (response.status === 201) {
        const source_id = response.data.data;
        loading.value = false;

        document.querySelector('#sourceModal .btn-close').click();
        emit('click', {
            type: 'add',
            value: {
                id: source_id,
                text: sourceName
            }
        });
        Swal.fire({
            icon: 'success',
            title: 'Create Source Successful!',
            text: 'You can now select the newly created source.',
        });
    } else {
        loading.value = false;
        const message = response.data.errors.source_name;
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: message? message : 'ERROR MESSAGE: FETCHING ADDING SOURCE.',
        });
    }
} catch (error) {
    if (axios.isAxiosError(error)) {
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: 'Error adding source: ' + error.response?.data || error.message
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
    const sourceName = document.querySelector('#source_name').value;

    const response = await axios.put(`/api/sources/${id}`, { source_name: sourceName }, {
        headers: {
            'Authorization': 'Bearer ' + page.props.csrf_token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    if (response.status === 201) {
        const source_id = response.data.data;
        loading.value = false;

        document.querySelector('#sourceModal .btn-close').click();
        emit('click', {
            type: 'edit',
            value: {
                id: source_id,
                text: sourceName
            }
        });
        Swal.fire({
            icon: 'success',
            title: 'Update Source Successful!',
            text: 'You can now select the newly updated source.',
        });
    } else {
        loading.value = false;
        const message = response.data.errors.source_name;
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: message? message : 'ERROR MESSAGE: FETCHING UPDATING SOURCE.',
        });
    }
} catch (error) {
    if (axios.isAxiosError(error)) {
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: 'Error updating source: ' + error.response?.data || error.message
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

const deleteSource = async (source_id) => {
try {
    loading.value = true;
    const response = await axios.delete(`/api/sources/${source_id}`, {}, {
        headers: {
            'Authorization': 'Bearer ' + page.props.csrf_token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    if (response.status === 201) {
        loading.value = false;

        document.querySelector('#sourceModal .btn-close').click();
        emit('click', {
            type: 'delete',
            value: {
                id: source_id,
                text: ''
            }
        });
        Swal.fire({
            icon: 'success',
            title: 'Delete Source Successful!',
            text: 'You have successfully deleted a source.',
        });
    } else {
        loading.value = false;
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: 'ERROR MESSAGE: FETCHING DELETING SOURCE.',
        });
    }
} catch (error) {
    if (axios.isAxiosError(error)) {
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error!',
            text: 'Error deleting source: ' + error.response?.data || error.message
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