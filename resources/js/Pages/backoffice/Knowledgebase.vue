<template>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                <h5>List of Articles 
                    <span class="p-l-25">
                        <BtnLink
                            href="/bo/knowledgebase/create"
                            class="btn btn-success"
                            name="Create Article"
                            icon=""
                        >
                        </BtnLink>
                    </span>
                </h5>
                <span>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Illo sequi impedit voluptatum officiis accusamus. Nam quae ad nostrum eligendi voluptatem earum temporibus rem iste. Voluptates alias</span>
                </div>
                <div class="table-responsive p-20">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Category</th>
                            <th scope="col">Title</th>
                            <th scope="col">Date</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in articles.data" :key="item.id">
                                <td>{{ item.categ_title }}</td>
                                <td>
                                    <Link
                                        class="text-info"
                                        href="/user/knowledgebase/details"
                                        :name="item.title "
                                        :data="{ id: item.id }"
                                    >
                                    </Link>
                                </td>
                                <td>{{ item.created_at }}</td>
                                <td>
                                    <div class="media-body text-center">
                                        <label class="switch">
                                            <input type="checkbox" :checked="item.status == 1 ? true: false" @click="setStatus(item)"><span class="switch-state"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <BtnLink
                                        class="btn btn-sm text-warning"
                                        href="/bo/knowledgebase/edit"
                                        icon="edit"
                                        name=""
                                        :data="{ id: item.id }"
                                    >
                                    </BtnLink>

                                    <button type="button" @click="removeArticle(item)" class="btn btn-sm text-danger">
                                        <vue-feather type="trash-2"></vue-feather>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <Paginate v-if="articles.data.length && articles.data.length>0" :prev="articles.prev_page_url" :next="articles.next_page_url" :totalItems="articles.total" :links="articles.links" :fromRow="articles.from" :toRow="articles.to"/>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</template>

<script setup>
import Paginate from "@/components/Paginate.vue";
import BtnLink from "@/components/BtnLink.vue";
import Link from "@/components/Link.vue";
import VueFeather from 'vue-feather';

// defineProps(['categories','articles']);
</script>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'

const page = usePage();

export default {
        name: 'app',
        props: ['articles'],
        methods:{
                setStatus(item) {
                    let new_status = item.status==0 ? 1 : 0;
                    axios.post('/bo/knowledgebase/set-status', { 
                        id:item.id, 
                        status:new_status,
                        _token: page.props.csrf_token 
                    })
                    .then((res) => {
                            console.log(res.data);
                    
                    })
                    .catch((error) => {
                            console.log(error.message);

                    });

                    router.reload();
                },
                removeArticle(item){
                    Swal.fire({
                        html: "Are you sure you want to delete <br><b>"+item.title+"</b>?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, return",
                        customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: "btn btn-active-light"
                        }
                    }).then(function (result) {
                        if (result.isConfirmed) 
                        {                        
                            axios.delete('/bo/knowledgebase/destroy/'+item.id, { } )
                                .then((res) => {
                                    if(res.data.success)
                                    {
                                        router.reload();
                                    }
                                });

                        }
                    });
                }
        }
    }

    

</script>

