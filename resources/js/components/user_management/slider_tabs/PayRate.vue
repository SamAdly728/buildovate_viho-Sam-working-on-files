<style scoped>
::placeholder {
  color: #0c0c0c;
  opacity: .5;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}
</style>
<template>
  <div class="card b-primary-v2 b-radius-10 shadow-sm mt-3">
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <div class="mt-2">
            <label class="d-block">
              <input @change="onHourlyChange('hourly')" class="checkbox_animated" type="checkbox" v-model="setHourlyActive"> Hourly
            </label>
          </div>
          <div class="mt-2">
            <label class="d-block">
              <input @change="onCommissionChange('commission')" class="checkbox_animated" type="checkbox" v-model="setCommissionActive"> Commission
            </label>
          </div>
          <div>
            <input v-if="setHourlyActive" placeholder="Hourly..." type="number" class="form-control mb-2 mt-2">
            <div class="row mt-3" v-if="setCommissionActive">
              <div class="col-auto d-flex align-items-center">
                <label for="commission">Lead Cost %</label>
              </div>
              <div class="col">
                <input id="commission" placeholder="Commission..." type="number" class="form-control" style="background-color: #7ca7e6; color: #0c0c0c" v-model="payRate">
              </div>
            </div>
          </div>
        </div>
        <transition>
          <div class="col-md-6" v-if="setCommissionActive">
            <div class="card b-radius-10" style="background-color: #7ca7e6">
              <div class="card-body p-3">
                <p class="f-20 mb-3 f-w-600 text-dark h6">Example:</p>
                <p class="mb-0"><span class="f-w-700 text-dark">Job Sale:</span> <i class="f-17">$100,000</i></p>
                <p class="mb-0"><span class="f-w-700 text-dark">Job Cost:</span> <i class="f-17">$40,000</i></p>
                <p class="mb-0"><span class="f-w-700 text-dark">Gross Profit:</span> <i class="f-17">$60,000</i></p>
                <p class="mb-0"><span class="f-w-700 text-dark">Lead Cost:</span> <i class="f-17">20% from $100,000 sale = $20,000</i></p>
                <p class="mb-0"><span class="f-w-700 text-dark">Net Profit:</span> <i class="f-17">$40,000</i></p>
                <p><span class="f-w-700 text-dark">Split 50/50:</span> <i class="f-17">Sales Rep Commission $20,000</i></p>
              </div>
            </div>
          </div>
        </transition>
      </div>
      <button class="pull-right btn btn-primary-v2 btn-xs" @click="savePayRate(userData.user_id)">Save Pay Rate</button>
    </div>
  </div>
</template>
<script>
import axios from "axios"
export default {
  props: ['userData', 'newUser'],
  data() {
    return {
      setHourlyActive: false,
      setCommissionActive: false,
      payRate: null
    }
  },
  methods: {
    savePayRate(userId, id) {
      axios.post('users/save/payrate', {userId: userId, payRate: this.payRate}).then((res) => {
        console.log(res)
      })
    },
    getUserPayRate() {
      axios.post('users/get/payrate', {userId: this.userData.user_id}).then((res) => {
        this.setCommissionActive = !this.setCommissionActive
        this.payRate = res.data.pay_rate ?? 0
      })
    },
    onHourlyChange() {
      if (this.setHourlyActive) {
        this.setCommissionActive = false;
      }
    },
    onCommissionChange() {
      if (this.setCommissionActive) {
        this.setHourlyActive = false;
      }
    }
  },
  mounted() {
    if (!this.newUser) {
      this.getUserPayRate()
    }
  }
}
</script>