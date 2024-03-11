<style scoped>
.align-header-center {
  text-align: center;
  vertical-align: middle;
}

</style>
<template>
  <div>
    <div class="table-responsive p-l-30 p-r-30">
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th class="align-header-center">Account Status</th>
            <th class="align-header-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="d in deactivatedUsers.data">
            <td>{{ d.display_name}}</td>
            <td align="middle" v-html="getAccountStatus(d.account_status)"></td>
            <td align="middle"><button class="btn btn-primary-v2 btn-xs" @click="reactivate(d.user_id, d.display_name)">Reactivate</button></td>
          </tr>
        </tbody>
      </table>
      <Paging v-if="deactivatedUsers.data.length>0" :data="deactivatedUsers" :search="search" :params="params" />
    </div>
  </div>
</template>
<script>
import Paging from "@/components/Paging.vue";
import Swal from "sweetalert2";
import {router} from "@inertiajs/vue3";
import axios from "axios"

export default {
  components: {Paging},
  props: ['deactivatedUsers'],
  data() {
    return {
      search: '',
      params: '',
    }
  },
  methods: {
    reactivate(id, name) {
      Swal.fire({
        html: "Are you sure you want to reactivate <i>"+name+"'s</> account?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        customClass: {
          confirmButton: "btn btn-primary-v2",
          cancelButton: "btn btn-active-light"

        }
      }).then((res) => {
        if (res.isConfirmed) {
          axios.post('/company/users/revoke-access', {userId: id, action: 1}).then((res) => {
            if (res.status == 200) {
              router.reload({only : ['deactivatedUsers']})
            }
          })
        }
      })
    },
    getAccountStatus(n) {
      let d = '';
      let clas = '';
      switch (n) {
        case 0:
          d = "Deactivated";
          clas = "danger";
          break;
        case 1:
          d = "Active";
          clas = "success";
          break;
        case 2:
          d = "Not Validated";
          clas = "warning";
          break;
      }
      return '<span class="badge badge-' + clas + '">' + d + '</span>';
    }
  }
}
</script>