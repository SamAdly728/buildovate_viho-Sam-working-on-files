<template>
        <div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="tagModal" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0">
                    <div class="card p-0 m-0">
                        <div class="card-header border">
                            <h5>{{ props.type === 'add' ? 'New Tag' : 'Edit Tag'}}</h5>
                            <small v-if="props.type !== 'add'">Selected tag is based on the first item in the field</small>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="card-body p-4 position-relative">
                            <label class="form-label f-w-600">Tag Name</label>
                            <input class="form-control border-success" id="tag_name" type="text" :value="props.selected.text" :disabled="loading">
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
        title: 'Delete TAG',
        text: "Are you sure you want to delete this tag?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed'
      }).then((result) => {
        if (result.isConfirmed) {
            deleteTag(props.selected.id);
        }
      });
    }
}

const updateEmit = () => {
    emit('click', {
                    type: 'edit',
                    value: {
                        id: props.selected.id,
                        text: document.querySelector('#tag_name').value
                    }
                });
        setTimeout(() => {
                emit('click', {
                    type: 'edit',
                    value: {
                        id: props.selected.id,
                        text: document.querySelector('#tag_name').value
                    }
                });
            }, 0);
}

const add = async () => {
    try {
        loading.value = true;
        const tagName = document.querySelector('#tag_name').value;

        const response = await axios.post('/api/tags', { tags_name: tagName }, {
            headers: {
                'Authorization': 'Bearer ' + page.props.csrf_token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.status === 201) {
            const tags_id = response.data.data;
            loading.value = false;

            document.querySelector('#tagModal .btn-close').click();
            emit('click', {
                type: 'add',
                value: {
                    id: tags_id,
                    text: tagName
                }
            });
            Swal.fire({
                icon: 'success',
                title: 'Create Tag Successful!',
                text: 'You can now select the newly created tag.',
            });
        } else {
            loading.value = false;
            const message = response.data.errors.tags_name;
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: message? message : 'ERROR MESSAGE: FETCHING ADDING TAG.',
            });
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: 'Error adding tag: ' + error.response?.data || error.message
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
        const tagName = document.querySelector('#tag_name').value;

        const response = await axios.put(`/api/tags/${id}`, { tags_name: tagName }, {
            headers: {
                'Authorization': 'Bearer ' + page.props.csrf_token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.status === 201) {
            const tags_id = response.data.data;
            loading.value = false;

            document.querySelector('#tagModal .btn-close').click();
            emit('click', {
                type: 'edit',
                value: {
                    id: tags_id,
                    text: tagName
                }
            });
            Swal.fire({
                icon: 'success',
                title: 'Update Tag Successful!',
                text: 'You can now select the newly updated tag.',
            });
        } else {
            loading.value = false;
            const message = response.data.errors.tags_name;
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: message? message : 'ERROR MESSAGE: FETCHING UPDATING TAG.',
            });
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: 'Error updating tag: ' + error.response?.data || error.message
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

const deleteTag = async (tags_id) => {
    try {
        loading.value = true;
        const response = await axios.delete(`/api/tags/${tags_id}`, {}, {
            headers: {
                'Authorization': 'Bearer ' + page.props.csrf_token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.status === 201) {
            loading.value = false;

            document.querySelector('#tagModal .btn-close').click();
            emit('click', {
                type: 'delete',
                value: {
                    id: tags_id,
                    text: ''
                }
            });
            Swal.fire({
                icon: 'success',
                title: 'Delete Tag Successful!',
                text: 'You have successfully deleted a tag.',
            });
        } else {
            loading.value = false;
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: 'ERROR MESSAGE: FETCHING DELETING TAG.',
            });
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: 'Error deleting tag: ' + error.response?.data || error.message
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