<template>
    <div class="modal fade" id="addStagePayment" tabindex="-1" role="dialog" aria-labelledby="addStagePayment" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0">
                    <div class="card p-0 m-0">
                        <div class="card-header border px-4 py-3">
                            <h5 class="m-0 p-0">{{ store.form.update_index == -1 ? 'Add' : 'Update'}} Stage Payment</h5>
                            <span v-if="store.form.update_index == -1">This will be added directly to the current last stage.</span>
                            <span class="bg-hover m-0 p-1 f-w-700 text-darkl f-18 close" type="button" data-bs-dismiss="modal" aria-label="Close" @click="store.closeModal()"><i class="icon-close"></i></span>
                        </div>
                        <div class="card-body p-0" style="background-color: #f5f7fb; overflow-y: auto; max-height: 65vh;">
                            <div class="row m-0 p-4 bg-white d-flex flex-column gap-3">
                                <div class="col-md-12 row m-0 p-0 mb-3">
                                    <label class="form-label f-w-600 p-0 m-0">Stage Title</label>
                                    <input class="form-control b-primary-v2" type="text" v-model="store.form.stage_name">
                                    <div class="text-danger" v-if="modalStageTitleError">Title is Required</div>
                                </div>
                                <div class="col-md-12 row m-0 p-0 mb-3">
                                    <label class="form-label f-w-600 p-0 m-0">Stage Amount</label>
                                    <div class="input-group p-0">
                                        <span class="input-group-text b-primary-v2 bg-primary-v2 text-white">$</span>
                                        <input class="form-control b-primary-v2" @input="processInput" aria-label="Amount (to the nearest dollar)" v-model="store.form.stage_amount" :disabled="store.form.locked">
                                        <span class="input-group-text b-primary-v2 bg-primary-v2 text-white" style="cursor: pointer;" @click="store.toggleLock()"><i :class="store.form.locked ? 'icon-lock' : 'icon-unlock'"></i></span>
                                    </div>
                                    <div class="text-danger" v-if="modalStageAmountError">Amount is Required</div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-end border px-4 py-3">
                            <button class="btn btn-light float-right" data-bs-dismiss="modal" @click="store.closeModal()">Cancel</button>
                            <button class="btn btn-primary-v2 mr-2 float-right" data-bs-dismiss="modal" @click="handleStagePaymentSubmit(store.form.update_stage, store.form.update_index)">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { useStagePayment } from '../../stores/stage-payment';

export default {
    setup(){
        const store = useStagePayment();

        return { store }
    },
    data(){
        const modalStageTitleError = false;
        const modalStageAmountError = false;
        const changed = false;

        return { modalStageTitleError, modalStageAmountError, changed }
    },
    methods: {
        updateModalVisibility() {
            const modalElement = document.getElementById('addStagePayment');
            const modalInstance = new bootstrap.Modal(modalElement);

            if (this.store.isModalOpen) {
                modalInstance.show();
            } else {
                document.querySelector(`#addStagePayment .close`).click();
                $(".modal-backdrop").hide();
            }
        },
        processInput(event) {
            let value = event.target.value;
            this.changed = true;
            this.modalStageTitleError = false;
            this.modalStageAmountError = false;

            if (!/^\d*\.?\d{0,2}$/.test(value)) {
                event.target.value = value.substring(0, value.length - 1);
            }
        },
        handleStagePaymentSubmit(update_stage, update_index){
            const changeType = update_index != -1 ? 'update' : 'new';
            const locked = this.changed ? true : this.store.form.locked;
            this.changed = false;

            if(!this.store.form.stage_name){
                this.modalStageTitleError = true;
                return;
            }

            if(!this.store.form.stage_amount){
                this.modalStageAmountError = true;
                return;
            }

            const updateStage = {
                ...this.store.form,
                locked,
                update_index,
                update_stage,
                change_type: changeType
            };

            this.store.setSubmittedForm(updateStage);
            this.store.closeModal();
        },
    },
    computed: {
        isModalOpen() {
            return this.store.isModalOpen;
        }
    },
    watch: {
        isModalOpen: {
            handler() {
                this.updateModalVisibility();
            }
        }
    }
}
</script>