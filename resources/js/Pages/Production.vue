<template>
		<div class="row p-3">
			<div class="col-sm-12">
        <h3>Production Operations</h3>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a>Utilize integrated tools to optimize your project's production phase, ensuring timely completion.</a></li>
        </ol>
			</div>

			<div class="col-sm-12">
        <div class="row">

          <div class="col-sm-6" v-for="m in subMenus" :key="m.name">
            <div class="card shadow-sm list-group-item-action" @click="navigateTo('production/'+m.url)" style="cursor: pointer;">
              <div class="job-search">
                <div class="card-body">
                  <div class="media"><img class="img-70 img-fluid m-r-20" :src="'/assets/images/production/'+m.url+'.png'" alt="">
                    <div class="media-body">
                      <h6 class="f-w-700">{{ m.name }}</h6>
                      <p>{{ m.desc }}</p>
                    </div>
                  </div>
                  </div>
              </div>
            </div>
          </div>
        
        </div>
      </div>

    </div>
</template>

<script setup>
import Paginate from "@/components/Paginate.vue";
import Link from "@/components/Link.vue";
// defineProps(['appts']);

const subMenus = [
  {
    name: "Material Take-Off",
    url: "material-take-off",
    desc: "Calculate materials needed, prevent wastage, and ensure the right supplies are ordered for each project."
  },
  {
    name: "Material Orders",
    url: "material-orders",
    desc: "Create, oversee and manage material orders, track deliveries, and ensure you have all you need on-site."
  },
  {
    name: "Production Calendar",
    url: "production-calendar",
    desc: "Schedule tasks, track project progress, and coordinate with teams for efficient production timelines."
  },
  {
    name: "Plans and Permits",
    url: "plans-and-permits",
    desc: "Order, access and manage construction plans, secure necessary permits, and ensure compliance at all times."
  },
  {
    name: "Crew Management",
    url: "crew-management",
    desc: "Allocate crew members, monitor their tasks and progress, and ensure efficient manpower utilization on-site."
  },
  {
    name: "Forms and Checklists",
    url: "forms-and-checklists",
    desc: "Use standardized forms and checklists to ensure consistency, compliance, and thoroughness in every job."
  },
  {
    name: "Vendor and Supplier Management",
    url: "#",
    desc: "A section to manage an view transactions with specific vendors or suppliers, including contact information and payment history."
  },

];


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

