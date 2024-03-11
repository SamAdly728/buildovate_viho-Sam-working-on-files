<style scoped>
.align-header-center {
  text-align: center;
  vertical-align: middle;
}
</style>
<template>
  <div>
    <div class="table-responsive p-l-30 p-r-30">
      <table class="table table-hover">
        <thead>
        <tr>
          <th>Name</th>
          <th class="align-header-center">Account Status</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="p in pendingUsers.data">
          <td>{{p.display_name}}</td>
          <td align="middle" v-html="getAccountStatus(p.account_status)"></td>
        </tr>
        </tbody>
      </table>
      <Paging v-if="pendingUsers.data.length>0" :data="pendingUsers" :search="search" :params="params" />
    </div>
  </div>
</template>
<script>
import Paging from "@/components/Paging.vue";

export default {
  components: {Paging},
  props: ['pendingUsers'],
  data() {
    return {
      search: '',
      params: '',
    }
  },
  methods: {
    getAccountStatus(n) {
      let d = '';
      let clas = '';
      switch (n) {
        case 0:
          d = "Deleted/Inactive";
          clas = "light";
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
    },
  },
  mounted() {
    // console.log(this.pendingUsers)
  }
}
</script>