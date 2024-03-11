<template>
    <div class="modal fade" id="addTransaction" tabindex="-1" role="dialog" aria-labelledby="addTransaction" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"  style="height: 85vh !important;">
                <div class="modal-body p-0 m-0" style="max-height: 93vh !important; background-color: rgb(228, 228, 228);">
                    <div class="px-4 py-3 m-0 b-b-primary d-flex">
                        <h5 class="f-18 f-w-600 text-dark flex-grow-1">Attach Transaction to Jobsite</h5>
                        <span class="bg-hover m-0 p-1 f-w-700 text-darkl f-18 close" type="button" data-bs-dismiss="modal" aria-label="Close" @click="store.closeModal()"><i class="icon-close"></i></span>
                    </div>
                    <div class="card-body">
                        TESTING
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { useTransactionModal } from '../../stores/transaction-modal';

export default {
    setup(){
        const store = useTransactionModal();

        return { store }
    },
    methods: {
        updateModalVisibility() {
            const modalElement = document.getElementById('addTransaction');
            const modalInstance = new bootstrap.Modal(modalElement, {backdrop: 'static', keyboard: false});

            if (this.store.isModalOpen) {
                modalInstance.show();
            } else {
                document.querySelector(`#addTransaction .close`).click();
            }
        }
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