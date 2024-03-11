<template>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12 col-xl-10">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="card">
                      <div class="card-header pb-0">
                        <h5>Edit Article - <b class="text-success">{{ article.title }}</b></h5>
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
                        <button type="button" class="btn btn-warning" @click="updateArticle">Update</button>
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
        props: ['categories','article'],
        components: {
            // Use the <ckeditor> component in this view.
            ckeditor: CKEditor.component
        },
        data() {
            return {
                editor: ClassicEditor,
                form: {
                        id: this.article.id,
                        category_id: this.article.categ_id,
                        title: this.article.title,
                        editor_data: this.article.content,
                        _token: page.props.csrf_token,
                },
            }
        },
        methods:{
                updateArticle() {

                        axios.post('/bo/knowledgebase/edit', this.form)
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

