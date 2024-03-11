<template>
		<div class="row m-0 p-4">
			<div class="col-sm-12">
        <h3>Sales Options</h3>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a>Unlock powerful tools to streamline your construction sales process and boost conversions.</a></li>
        </ol>
			</div>

			<div class="col-sm-12">
        <div class="row">

          <div class="col-sm-6">
            <div class="card shadow-sm bg-hover-primary b-primary" @click="navigateTo('sales/lead-management')" style="cursor: pointer; overflow: hidden; border-radius: 20px;">
              <div class="card-body m-0 px-4 py-3">
                  <div class="d-flex align-items-center">
                    <div style="z-index: 5; margin-right: 230px;">
                      <label class="f-w-700 f-20 px-2 py-1 text-dark"><a href="sales/lead-management">LEAD MANAGEMENT</a></label>
                      <p class="f-w-600 text-muted f-12 px-2 py-1">Track potential clients, follow up on project leads, and stay ahead with real-time lead management.</p>
                    </div>
                    <img class="img-fluid position-absolute" :src="fileAddress + 'lead_management.png'" alt="" style="width: 300px; right: -20px; top: -20px; opacity: 0.5;">
                  </div>
                </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="card shadow-sm bg-hover-primary b-primary" @click="navigateTo('sales/activities')" style="cursor: pointer; overflow: hidden; border-radius: 20px;">
              <div class="card-body m-0 px-4 py-3">
                  <div class="d-flex align-items-center">
                    <div style="z-index: 5; margin-right: 250px;">
                      <label class="f-w-700 f-20 px-2 py-1 text-dark"><a href="sales/activities">ACTIVITIES</a></label>
                      <p class="f-w-600 text-muted f-12 px-2 py-1">Monitor sales activities, set reminders, and ensure no opportunity falls through the cracks.</p>
                    </div>
                    <img class="img-fluid position-absolute" :src="fileAddress + 'activities.png'" alt="" style="width: 300px; right: -20px; top: -20px; opacity: 0.5;">
                  </div>
                </div>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-sm-6">
            <div class="card shadow-sm bg-hover-primary b-primary" @click="navigateTo('sales/smart-estimates')" style="cursor: pointer; overflow: hidden; border-radius: 20px;">
              <div class="card-body m-0 px-4 py-3">
                  <div class="d-flex align-items-center">
                    <div style="z-index: 5; margin-right: 230px;">
                      <label class="f-w-700 f-20 px-2 py-1 text-dark"><a href="sales/smart-estimates">SMART ESTIMATE</a></label>
                      <p class="f-w-600 text-muted f-12 px-2 py-1">Quickly generate accurate construction estimates, ensuring you stay competitive and profitable.</p>
                    </div>
                    <img class="img-fluid position-absolute" :src="fileAddress + 'smart_estimate.png'" alt="" style="width: 300px; right: -20px; top: -20px; opacity: 0.5;">
                  </div>
                </div>
            </div>
          </div>

          
          <div class="col-sm-6">
            <div class="card shadow-sm bg-hover-primary b-primary" @click="navigateTo('sales/proposals')" style="cursor: pointer; overflow: hidden; border-radius: 20px;">
              <div class="card-body m-0 px-4 py-3">
                  <div class="d-flex align-items-center">
                    <div style="z-index: 5; margin-right: 300px;">
                      <label class="f-w-700 f-20 px-2 py-1 text-dark"><a href="sales/proposals">PROPOSALS</a></label>
                      <p class="f-w-600 text-muted f-12 px-2 py-1">Draft compelling proposals, collaborate with your team, and win more construction bids.</p>
                    </div>
                    <img class="img-fluid position-absolute" :src="fileAddress + 'proposals.png'" alt="" style="width: 300px; right: -20px; top: -20px; opacity: 0.5;">
                  </div>
                </div>
            </div>
          </div>
          
        </div>

        <div class="row">
                    
          <div class="col-sm-6">
            <div class="card shadow-sm bg-hover-primary b-primary" @click="navigateTo('sales/change-orders')" style="cursor: pointer; overflow: hidden; border-radius: 20px;">
              <div class="card-body m-0 px-4 py-3">
                  <div class="d-flex align-items-center">
                    <div style="z-index: 5; margin-right: 230px;">
                      <label class="f-w-700 f-20 px-2 py-1 text-dark"><a href="sales/change-orders">CHANGE ORDERS</a></label>
                      <p class="f-w-600 text-muted f-12 px-2 py-1">fficiently manage and track changes in project scopes, ensuring timely approvals and client satisfaction.</p>
                    </div>
                    <img class="img-fluid position-absolute" :src="fileAddress + 'change_order.png'" alt="" style="width: 300px; right: -20px; top: -20px; opacity: 0.5;">
                  </div>
                </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="card shadow-sm bg-hover-primary b-primary" @click="navigateTo('sales/catalogs')" style="cursor: pointer; overflow: hidden; border-radius: 20px;">
              <div class="card-body m-0 px-4 py-3">
                  <div class="d-flex align-items-center">
                    <div style="z-index: 5; margin-right: 250px;">
                      <label class="f-w-700 f-20 px-2 py-1 text-dark"><a href="sales/catalogs">CATALOGS</a></label>
                      <p class="f-w-600 text-muted f-12 px-2 py-1">Access a comprehensive list of your construction materials, equipment, and services for easy reference.</p>
                    </div>
                    <img class="img-fluid position-absolute" :src="fileAddress + 'catalogs.png'" alt="" style="width: 300px; right: -20px; top: -20px; opacity: 0.5;">
                  </div>
                </div>
            </div>
          </div>

        </div>

      </div>

    </div>
</template>

<script setup>
  defineProps(['appts']);
  const fileAddress = 'https://buildovate-development.s3.us-west-1.amazonaws.com/images/sales/';
</script>

<script>
export default {
    methods:{
      navigateTo(route) {
        this.$inertia.visit(route);
      }
    }
}
</script>

