<template>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12 col-xl-10">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="card">
                      <div class="card-header pb-0">
                        <h5>New Article</h5>
                        <!-- <span>Using the <a href="#">card</a> component, you can extend the default collapse behavior to create an accordion.</span> -->
                      </div>
                      <div class="card-body">
                        <form class="theme-form">
                          <div class="mb-3">
                            <label class="col-form-label pt-0" for="category">Category</label>
                            <select v-model="form.category_id" class="form-control" required>
                                <option value="0">Choose category...</option>
                                <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.title }}</option>
                            </select>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label pt-0" for="title">Title</label>
                            <input v-model="form.title" class="form-control" id="title" type="text" placeholder="Enter Title" required>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label pt-0" for="title">Content</label>
                            <ckeditor :editor="editor" v-model="form.editor_data" :config="editorConfig" required></ckeditor>
                          </div>
                        </form>
                      </div>
                      <div class="card-footer text-end">
                        <BtnLink
                                href="/bo/knowledgebase"
                                name=""
                                class="btn btn-default"
                                icon="arrow-left"
                        >
                        </BtnLink>
                        &nbsp;
                        <button type="button" class="btn btn-primary" @click="saveArticle">Save</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid Ends-->
</template>

<script setup>
import BtnLink from '@/components/BtnLink.vue';
defineProps(['categories']);
</script>

<script>
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { usePage } from '@inertiajs/vue3';

import axios from 'axios';
import Swal from 'sweetalert2';

const page = usePage();

export default {
        name: 'app',
        components: {
            // Use the <ckeditor> component in this view.
            ckeditor: CKEditor.component
        },
        data() {
            return {
                editor: ClassicEditor,
                form: {
                        category_id: 0,
                        category_name: '',
                        title: '',
                        editor_data: '',
                        _token: page.props.csrf_token,
                },
            }
        },
        methods:{
                resetForm(){
                        this.form.category_id = '';
                        this.form.category_name = '';
                        this.form.title = '';
                        this.form.editor_data = '';
                },
                saveArticle() {

                        axios.post('/bo/knowledgebase/create', this.form)
                        .then((res) => {
                                if(res.data.success)
                                {
                                        Swal.fire({
                                                html: res.data.status,
                                                icon: "success",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, got it!",
                                                customClass: {
                                                        confirmButton: "btn btn-success"
                                                }
                                        });

                                        this.resetForm();

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
                        
                        })
                        .catch((error) => {
                                Swal.fire({
                                                text: error.message,
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, got it!",
                                                customClass: {
                                                        confirmButton: "btn btn-danger"
                                                }
                                        });

                        });
                },
        }
    }

    

</script>

