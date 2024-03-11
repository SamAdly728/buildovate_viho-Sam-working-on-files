<template>
    <div class="modal fade" id="costItemModal" tabindex="-1" role="dialog" aria-labelledby="costItemModal" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0" style="max-height: 90vh !important;">
                    <div class="card p-0 m-0" style="max-height: 90vh !important;">
                        <div class="card-header border">
                            <h5>{{ cost_item_id === 0 ? 'New Cost Item' : 'Update Cost Item'}}</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" @click="store.closeModal()" :style="{'visibility': loading ? 'hidden' : 'visible'}"></button>
                        </div>
                        <div class="card-body p-0 m-0 position-relative bg-light slim-scroll-gray" style="overflow: auto;">
                            <div class="card text-dark b-r-5 p-3 m-3">
                                <h5 class="f-16 f-w-600 mb-3">Estimated Cost Details</h5>
                                <hr class="m-0 p-0"/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label f-w-600 m-0 pt-3 pb-1 f-12">Cost Item Title</label>
                                        <input class="form-control border-light" type="text" v-model="cost_item_title" :disabled="loading">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label f-w-600 m-0 pt-3 pb-1 f-12">Description</label>
                                        <textarea class="form-control border-light" type="text" v-model="cost_item_description" :disabled="loading"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label f-w-600 m-0 pt-3 pb-1 f-12">Internal Notes</label>
                                        <textarea class="form-control border-light" type="text" v-model="cost_item_notes" :disabled="loading"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card text-dark b-r-5 p-3 m-3    ">
                                <h5 class="f-16 f-w-600 mb-3">Cost Information</h5>
                                <hr class="m-0 p-0"/>
                                <div class="row">
                                    <div class="col-md-6 p-3 d-flex flex-column gap-2 mt-2">
                                        <div class="checkbox checkbox-dark m-0 p-0">
                                            <input id="include-quantity" type="checkbox" class=" m-0 p-0" v-model="include_quantity" :disabled="loading">
                                            <label class="m-0" for="include-quantity">Include Quantity</label>
                                        </div>
                                        <div class="checkbox checkbox-dark m-0 p-0">
                                            <input id="include-owner-price" type="checkbox" class=" m-0 p-0" v-model="include_owner_price" :disabled="loading">
                                            <label class="m-0" for="include-owner-price">Include Owner Price</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 p-3 d-flex flex-column gap-2 mt-2">
                                        <div class="radio radio-dark m-0 p-0">
                                            <input id="labor" type="radio" class=" m-0 p-0" name="labor" value="0" v-model="labor" checked :disabled="loading">
                                            <label class="m-0" for="labor">Labor Only</label>
                                        </div>
                                        <div class="radio radio-dark m-0 p-0">
                                            <input id="labor-and-material" type="radio" class=" m-0 p-0" name="labor" value="1" v-model="labor" :disabled="loading">
                                            <label class="m-0" for="labor-and-material">Labor and Material</label>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label f-w-600 m-0 pt-3 pb-1 f-12">Unit Cost</label>
                                            <div class="input-group">
                                                <span class="input-group-text f-14 border-light">$</span>
                                                <input class="form-control border-light text-right" type="number" v-model="unit_cost" :disabled="loading">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label f-w-600 m-0 pt-3 pb-1 f-12">Unit of Measurement</label>
                                            <input class="form-control border-light" type="text" v-model="unit" :disabled="loading">
                                        </div>
                                        <div class="col-md-2" v-if="include_quantity">
                                            <label class="form-label f-w-600 m-0 pt-3 pb-1 f-12">Quantity</label>
                                            <input class="form-control border-light" type="number" min="1" v-model="unit_quantity" :disabled="loading">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label f-w-600 m-0 pt-3 pb-1 f-12">Builder Cost</label>
                                            <div class="input-group">
                                                <span class="input-group-text f-14 border-light">$</span>
                                                <input class="form-control border-light text-right" type="number" v-model="builder_cost" disabled>
                                            </div>  
                                        </div>
                                    </div>

                                    <div class="row" v-if="include_owner_price">
                                        <div class="col-md-4">
                                            <label class="form-label f-w-600 m-0 pt-3 pb-1 f-12">Markup</label>
                                            <div class="input-group">
                                                <span class="input-group-text f-14 border-light" v-if="markup_type !== '%'">$</span>
                                                <input class="form-control border-light text-right" type="number" :disabled="markup_type == '' || loading" v-model="markup">
                                                <span class="input-group-text f-14 border-light" v-if="markup_type === '%'">%</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label f-w-600 m-0 pt-3 pb-1 f-12">Markup Type</label>
                                            <select class="form-control border-light" v-model="markup_type" @change="onChangeMarkupType" :disabled="loading">
                                                <option value="--">Default (Input)</option>
                                                <option value="$">Amount</option>
                                                <option value="$/">Amount/Unit</option>
                                                <option value="%">Percentage</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label f-w-600 m-0 pt-3 pb-1 f-12">Owner Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text f-14 border-light">$</span>
                                                <input class="form-control border-light text-right" type="number" v-model="owner_price" :disabled="markup_type != '' || loading">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card text-dark b-r-5 p-3 m-3">
                                <h5 class="f-16 f-w-600 mb-3">Cost Item Photo</h5>
                                <hr class="m-0 p-0"/>
                                <div class="row m-0 p-0">
                                    <div class=" col-md-6 b-primary bg-light text-center m-0" 
                                        :style="{'height': '200px', 'padding-top': imageUrl ? '0px' : '45px', 'overflow': 'hidden'}">
                                        <img :src="imageUrl" alt="Preview" style="width: 100%;" class="preview-image">
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                                        <div class="d-flex gap-2 flex-column" v-if="!loading">
                                            <a class="btn btn-primary-v2" @click="handleUpload">{{imageUrl ? 'Change' : 'Upload'}}</a>
                                            <a class="btn btn-outline-danger" v-if="imageUrl" @click="handleRemoveUrl">Remove</a>
                                        </div>
                                    </div>
                                    <input type="file" @change="previewImage" id="uploadInput" style="visibility: none;" accept="image/*"/>
                                </div>
                            </div>
                            
                        </div>
                        <div class="d-flex justify-content-between p-4 align-items-center b-t-light" v-if="store.type === 'database'">
                            <div class="checkbox checkbox-dark m-0 p-0" v-if="store.type !== 'database'">
                                <input id="add-to-catalog" type="checkbox" class=" m-0 p-0">
                                <label class="m-0" for="add-to-catalog">ADD TO CATALOG</label>
                            </div>
                            <div></div>
                            <div v-if="!loading" class="d-flex gap-2">
                                <button class="btn btn-light" data-bs-dismiss="modal" @click="store.closeModal()">Cancel</button>
                                <button class="btn btn-danger" v-if="store.type === 'database' && cost_item_id !== 0 && !loading" @click="handleDeleteCostItem">Delete</button>
                                <button class="btn btn-primary-v2" @click="handlCreateCostItem" v-if="cost_item_id === 0">Submit</button>
                                <button class="btn btn-primary-v2" @click="handlUpdateCostItem" v-else>Update</button>
                            </div>
                            <button class="btn btn-danger" disabled v-else><i class="fa fa-spin fa-spinner me-2"></i> Loading</button>
                        </div>
                        <div class="d-flex justify-content-between p-4 align-items-center b-t-light" v-else>
                            <div></div>
                            <button class="btn btn-primary-v2" @click="handleSubmit" data-bs-dismiss="modal">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { useCostItemModal } from '../../stores/cost-item-modal';
import { usePage } from "@inertiajs/vue3";
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    emits: ['result'],
    setup(){
        const page = usePage();
        const store = useCostItemModal();

        return { page, store }
    },
    data(){
        const imageUrl = null;
        const fileUrl = null;
        const loading = false;
        const cost_item_id = 0;
        const cost_item_title = '';
        const cost_item_description = '';
        const cost_item_notes = '';
        const include_quantity = false;
        const include_owner_price = false;
        const unit_cost = 0;
        const unit = '';
        const unit_quantity = 0;
        const markup = 0;
        const markup_type = '';
        const labor = 0;

        return {
            imageUrl,
            fileUrl,
            loading,
            cost_item_id,
            cost_item_title,
            cost_item_description,
            cost_item_notes,
            include_quantity,
            include_owner_price,
            unit_cost,
            unit,
            unit_quantity,
            markup,
            markup_type,
            labor
        }
    },
    computed: {
        builder_cost() {
            return this.unit_cost * this.unit_quantity;
        },
        owner_price() {
            const type = this.markup_type;
            let new_owner_price = this.builder_cost + this.markup;

            if(type === '--'){
                
            }else if(type === '%'){
                new_owner_price = (this.builder_cost + ((this.builder_cost) * (this.markup/100)));
            }else if(type === '$/'){
                new_owner_price = (this.builder_cost + (this.markup * this.unit_quantity));
            }else if(type === '$'){
                new_owner_price = (this.builder_cost + this.markup);
            }

            return new_owner_price;
        },
        isModalOpen() {
            return this.store.isModalOpen;
        },
        selected() {
            return this.store.selectedItem;
        }
    },
    methods: {
        handleRemoveUrl() {
            this.imageUrl = '';
        },
        handleUpload(){
            document.querySelector(`#uploadInput`).click();
        },
        updateModalVisibility() {
            const modalElement = document.getElementById('costItemModal');
            const modalInstance = new bootstrap.Modal(modalElement, {backdrop: 'static', keyboard: false});
            if (this.store.isModalOpen) {
                modalInstance.show();
            } else {
                document.querySelector(`#costItemModal .btn-close`).click();
            }
        },
        previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = new Image();
                    img.onload = () => {
                        // Perform scaling logic here
                        // For example, scale down to a certain width while maintaining aspect ratio
                        const scaleFactor = 200 / img.width; // Example scaling factor
                        img.width = 200; // Example new width
                        img.height *= scaleFactor;

                        this.imageUrl = img.src;
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
                this.fileUrl = input.files[0];
            }
        },
        onChangeMarkupType() {
            if(this.markup_type === ''){
                this.markup = 0;
            }
        },
        getItemObject() {
            return {
                title : this.cost_item_title,
                description : this.cost_item_description,
                internal_notes : this.cost_item_notes,
                unit_cost : this.unit_cost,
                unit : this.unit,
                unit_quantity : this.unit_quantity,
                unit_mark_up : this.markup,
                unit_mark_up_type : this.markup_type,
                labor : document.querySelector('#labor').checked ? '1' : '0',
                quantity_included : this.include_quantity ? '1' : '0',
                tiered_price_included : '0',
                owner_price_included : this.include_owner_price ? '1' : '0',
                discount : 0,
                discount_type : '',
                status : 1
            }
        },
        handleSubmit() {
            this.store.setSubmitedItem(this.getItemObject());
        },
        handlCreateCostItem() {
            this.add(this.getItemObject());
        },
        handlUpdateCostItem() {
            this.edit(this.getItemObject());
        },
        handleDeleteCostItem() {
            Swal.fire({
                title: 'Delete COST ITEM',
                text: "Are you sure you want to delete this cost item?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Proceed'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteCostItem();
                }
            });
        },
        async add() {
            try {
                this.loading = true;

                if(this.fileUrl != null){
                    const filedetails = await this.upload();
                    this.imageUrl = filedetails.data.s3Url;
                }
                const form = this.form();
                const response = await axios.post('/api/costItems', form, {
                    headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.status === 201) {
                    const costItemDetails = response.data.data;

                    this.store.setUpdateItem(costItemDetails);
                    this.store.closeModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Create Cost Item Successful!',
                        text: 'You can now add the newly created Cost Item to your proposals.',
                    });
                    this.loading = false;
                } else {
                    this.loading = false;
                    const message = response.data.errors.title;
                    Swal.fire({
                        icon: 'error',
                        title: 'Unexpected Error!',
                        text: message? message : 'ERROR MESSAGE: ADDING COST ITEM.',
                    });
                }
            } catch (error) {
                if (axios.isAxiosError(error)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Unexpected Error!',
                        text: 'Error adding cost item: ' + error.response?.data || error.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Unexpected Error!',
                        text: 'Non-HTTP error: ' + error
                    });
                }
            } finally {
                this.loading = false;
            }
        },
        async edit() {
            try {
                this.loading = true;
                
                if(this.fileUrl != null){
                    const filedetails = await this.upload();
                    this.imageUrl = filedetails.data.s3Url;
                }

                const form = this.form();
                const response = await axios.put(`/api/costItems/${this.cost_item_id}`, form, {
                    headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.status === 201) {
                    const costItemDetails = response.data.data;
                    this.loading  = false;

                    this.store.setUpdateItem(costItemDetails);
                    this.store.closeModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Update Cost Item Successful!',
                        text: 'You can now add the newly updated Cost Item to your proposals.',
                    });
                } else {
                    this.loading = false;
                    const message = response.data.errors.title;
                    Swal.fire({
                        icon: 'error',
                        title: 'Unexpected Error!',
                        text: message? message : 'ERROR MESSAGE: UPDATING COST ITEM.',
                    });
                }
            } catch (error) {
                if (axios.isAxiosError(error)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Unexpected Error!',
                        text: 'Error updating cost item: ' + error.response?.data || error.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Unexpected Error!',
                        text: 'Non-HTTP error: ' + error
                    });
                }
            } finally {
                this.loading = false;
            }
        },
        async deleteCostItem() {
            try {
                this.loading = true;
                const response = await axios.delete(`/api/costItems/${this.cost_item_id}`, {}, {
                    headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.status === 201) {
                    this.loading = false;

                    this.store.closeModal();
                    emit('result', { value: 'COST ITEM DELETED' });
                    Swal.fire({
                        icon: 'success',
                        title: 'Delete Cost item Successful!',
                        text: 'You have successfully deleted a cost item.',
                    });
                } else {
                    this.loading = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Unexpected Error!',
                        text: 'ERROR MESSAGE: DELETING COST ITEM.',
                    });
                }
            } catch (error) {
                if (axios.isAxiosError(error)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Unexpected Error!',
                        text: 'Error deleting cost item: ' + error.response?.data || error.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Unexpected Error!',
                        text: 'Non-HTTP error: ' + error
                    });
                }
            } finally {
                this.loading = false;
            }
        },
        async upload() {
            const response = await axios.post('/api/upload', {
                file: this.fileUrl,
                'upload-file-from': 'cost-item'
            }, {
                headers: {
                    'Authorization': 'Bearer ' + this.page.props.csrf_token,
                    'Content-Type': 'multipart/form-data',
                }
            });

            return response;
        },
        reset() {
            this.cost_item_title = '';
            this.cost_item_description = '';
            this.cost_item_notes = '';
            this.include_quantity = false;
            this.include_owner_price = false;
            this.unit_cost = 0;
            this.unit = '';
            this.unit_quantity = 1;
            this.markup = 0;
            this.markup_type = '';
            this.cost_item_id = 0;
            this.imageUrl = '';
            this.labor = 0;
        },
        form() {
            return {
                title: this.cost_item_title,
                description: this.cost_item_description,
                internal_notes: this.cost_item_notes,
                quantity_included: this.include_quantity ? 1 : 0,
                owner_price_included: this.include_owner_price ? 1 : 0,
                unit_cost: this.unit_cost,
                unit: this.unit,
                unit_quantity: this.unit_quantity,
                unit_mark_up: this.markup,
                unit_mark_up_type: this.markup_type,
                cost_item_id: this.cost_item_id,
                item_photo_url: this.imageUrl,
                labor: this.labor
            }
        }
    },
    mounted() {
        this.updateModalVisibility();
    },
    watch: {
        selected: {
            handler(costItem){
                if(costItem){
                    const title = costItem.title ? costItem.title : '';
                    const description = costItem.description ? costItem.description : '';
                    const internal_notes = costItem.internal_notes ? costItem.internal_notes : '';
                    const quantity_included = costItem.quantity_included ? (costItem.quantity_included === 1) : false;
                    const owner_price_included = costItem.owner_price_included ? (costItem.owner_price_included === 1) : false;
                    const unit_cost = costItem.unit_cost ? parseFloat(costItem.unit_cost) : 0;
                    const unit = costItem.unit ? costItem.unit : '';
                    const unit_quantity = costItem.unit_quantity ? parseFloat(costItem.unit_quantity) : 1;
                    const markup = costItem.unit_mark_up ? parseFloat(costItem.unit_mark_up) : 0;
                    const unit_mark_up_type = costItem.unit_mark_up_type ? costItem.unit_mark_up_type : '';
                    const cost_item_id = costItem.cost_item_id ? costItem.cost_item_id : 0;
                    const item_photo_url = costItem.item_photo_url ? costItem.item_photo_url : '';
                    const labor = costItem.labor ? costItem.labor : 0;
                    

                    this.cost_item_title = title;
                    this.cost_item_description = description;
                    this.cost_item_notes = internal_notes;
                    this.include_quantity = quantity_included;
                    this.include_owner_price = owner_price_included;
                    this.unit_cost = unit_cost;
                    this.unit = unit;
                    this.unit_quantity = unit_quantity;
                    this.markup = markup;
                    this.markup_type = unit_mark_up_type;
                    this.cost_item_id = cost_item_id;
                    this.imageUrl = item_photo_url;
                    this.labor = labor;
                }else{
                    this.reset();
                }
            }, deep: true
        },
        isModalOpen: {
            handler() {
                this.updateModalVisibility();
            }
        }
    }
}
</script>
