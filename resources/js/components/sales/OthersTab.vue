<template>
    <div class="col-md-12 m-0 p-0 d-flex flex-column gap-5 slim-scroll-gray" style="max-height: calc(100vh - 370px); overflow: auto;">
        <div class="d-flex flex-column px-4 gap-3">
            <div class="d-flex flex-column gap-1">
                <h5 class="m-0 p-0 f-20 f-w-700 text-primary-v2">Notes</h5>
                <div style="height: 4px; width: 80px;" class="bg-primary-v2 b-radius-5"></div>
            </div>
            <div class="d-flex gap-4">
                <div class="px-4 py-3 b-radius-5 b-primary-v2 d-flex flex-column gap-2" 
                    style="width: 350px;" 
                    :class="(editingNotes === 'salesperson') ? 'flex-grow-1' : 'bigger'">
                    <h5 class="f-w-700 f-18 text-primary-v2">SALESPERSON</h5>
                    <div class="d-flex flex-column gap-2" v-if="editingNotes === 'salesperson'">
                        <input class="px-2 py-1 b-primary-v2 b-radius-5" type="text" placeholder="Type note header here."/>
                        <textarea class="px-2 py-1 b-primary-v2 b-radius-5" placeholder="Type your notes here for assigned salesperson."></textarea>
                        <div class="d-flex gap-2">
                            <span class="flex-grow-1"></span>
                            <a class="btn btn-light" @click="handleEditNote(null)">Cancel</a>
                            <a class="btn btn-primary-v2" @click="handleEditNote(null)">Save</a>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-2" v-else @click="handleEditNote('salesperson')">
                        <h5 class="f-w-600 f-16 p-0 m-0">Type note header here.</h5>
                        <h5 class="f-w-600 f-14 text-muted p-0 m-0">Type your notes here for assigned salesperson.</h5>
                    </div>
                </div>
                <div class="px-4 py-3 b-radius-5 b-primary-v2 d-flex flex-column gap-2" 
                    style="width: 350px;" 
                    :class="(editingNotes === 'customer') ? 'flex-grow-1' : 'bigger'">
                    <h5 class="f-w-700 f-18 text-primary-v2">CUSTOMER</h5>
                    <div class="d-flex flex-column gap-2" v-if="editingNotes === 'customer'">
                        <input class="px-2 py-1 b-primary-v2 b-radius-5" type="text" placeholder="Type note header here."/>
                        <textarea class="px-2 py-1 b-primary-v2 b-radius-5" placeholder="Type your notes here for customer to see."></textarea>
                        <div class="d-flex gap-2">
                            <span class="flex-grow-1"></span>
                            <a class="btn btn-light" @click="handleEditNote(null)">Cancel</a>
                            <a class="btn btn-primary-v2" @click="handleEditNote(null)">Save</a>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-2" v-else @click="handleEditNote('customer')">
                        <h5 class="f-w-600 f-16 p-0 m-0">Type note header here.</h5>
                        <h5 class="f-w-600 f-14 text-muted p-0 m-0">Type your notes here for customer to see.</h5>
                    </div>
                </div>
                <div class="px-4 py-3 b-radius-5 b-primary-v2 d-flex flex-column gap-2" 
                    style="width: 350px;" 
                    :class="(editingNotes === 'company') ? 'flex-grow-1' : 'bigger'">
                    <h5 class="f-w-700 f-18 text-primary-v2">COMPANY</h5>
                    
                    <div class="d-flex flex-column gap-2" v-if="editingNotes === 'company'">
                        <input class="px-2 py-1 b-primary-v2 b-radius-5" type="text" placeholder="Type note header here."/>
                        <textarea class="px-2 py-1 b-primary-v2 b-radius-5" placeholder="Type your notes here for overall company crew to see."></textarea>
                        <div class="d-flex gap-2">
                            <span class="flex-grow-1"></span>
                            <a class="btn btn-light" @click="handleEditNote(null)">Cancel</a>
                            <a class="btn btn-primary-v2" @click="handleEditNote(null)">Save</a>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-2" v-else @click="handleEditNote('company')">
                        <h5 class="f-w-600 f-16 p-0 m-0">Type note header here.</h5>
                        <h5 class="f-w-600 f-14 text-muted p-0 m-0">Type your notes here for overall company crew to see.</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column px-4 gap-3">
            <div class="d-flex flex-column gap-1">
                <h5 class="m-0 p-0 f-20 f-w-700 text-primary-v2">Video</h5>
                <div style="height: 4px; width: 80px;" class="bg-primary-v2 b-radius-5"></div>
            </div>
            <div class="d-flex flex-column">
                <h5 class="f-14 f-w-600 text-muted">Paste here the youtube link of you video.</h5>
                <div class="input-group p-0" style="max-width: 800px;">
                    <span class="input-group-text b-primary-v2 bg-primary-v2 text-white"><i class="icon-world"></i></span>
                    <input class="form-control b-primary-v2" aria-label="Amount (to the nearest dollar)" type="text" placeholder="https://www.youtube.com/watch?v=sampleofyourlinkhere-7"/>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column px-4 gap-2">
            <div class="d-flex flex-column gap-1">
                <h5 class="m-0 p-0 f-20 f-w-700 text-primary-v2">Introductory Text</h5>
                <div style="height: 4px; width: 210px;" class="bg-primary-v2 b-radius-5"></div>
            </div>
            <Summernote />
        </div>
        <div class="d-flex flex-column px-4 gap-2">
            <div class="d-flex flex-column gap-1">
                <h5 class="m-0 p-0 f-20 f-w-700 text-primary-v2">Closing Text</h5>
                <div style="height: 4px; width: 160px;" class="bg-primary-v2 b-radius-5"></div>
            </div>
            <Summernote />
        </div>
    </div>
</template>
<script>
import Summernote from '../Summernote.vue';

export default {
    components: { Summernote },
    data(){
        const editingNotes = null;

        return { editingNotes }
    },
    methods: {
        handleEditNote(type){
            this.editingNotes = type;
        }
    }
}
</script>