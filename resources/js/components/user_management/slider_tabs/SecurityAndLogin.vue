<template>
  <div class="card b-primary-v2 b-radius-10 shadow-sm mt-3">
    <div class="card-body">
      <div class="col-md-12 mb-3">
        <div class="">
          <div class="col d-block mb-4">
            <label class="form-label">Username</label>
            <span class="d-block f-26 f-w-600 text-dark">{{userData.username}}</span>
          </div>
          <div class="col d-block">
            <label class="form-label">Password</label>
            <button class="btn btn-primary-v2 btn-xs d-block" @click="sendPasswordReset(userData.user_id, userData.email)">Reset Password</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  props: ['userData'],
  data() {
    return {

    }
  },
  methods: {
    sendPasswordReset(id, email) {
      axios.post('/send-password-reset-email', {user_id: id, email:email}).then((res) => {
        console.log(res)
      })
    }
  },
  mounted() {
    // console.log(this.userData)
  }
}
</script>