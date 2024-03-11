<script setup>
  import SemiCircleGauge from "../../components/charts/SemiCircleGauge.vue";
  import StrokeGauge from "../../components/charts/StrokeGauge.vue";
  import MetricsGauge from "../../components/charts/MetricsGauge.vue";
  import BarChart from "../../components/charts/BarChart.vue";
  import PieChart from "../../components/charts/PieChart.vue";
  import MixChart from "../../components/charts/MixeLineColumnArea.vue";

  import columnChart1 from "../../components/charts/columnChart.vue";
  import MixedChart1 from "../../components/charts/MixedChart.vue";
  import pieChart1 from "../../components/charts/pieChart1.vue";


  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  import { Link } from "@inertiajs/vue3";
  import { usePage } from "@inertiajs/vue3";
  const page = usePage();
  const props = defineProps({
      open: {
          type: Boolean,
          default: false
      }
  });

  // Define reactive data properties
  const progress_color = ref('white')
  const progress_percent = ref(0)
  const quickstartLink = ref(true)
  const quickstartBar = ref(false)
  const quickstarts_data = ref([])
  const isActive = ref(false)

  // Define the method as a regular function
  function checkQuickstartProgress() {
    axios.post('/quickstart/check-progress', {})
      .then((res) => {
        progress_color.value = res.data.color
        progress_percent.value = res.data.percent
      })
      .catch((error) => {
        console.log('error', error.message)
      })
  }

  function loadQuickStart(){
    axios.post('/quickstart/load', {} )
    .then((res) => {
      quickstarts_data.value = res.data.quickstarts;
    })
    .catch((error) => {
      console.log('error',error.message);
    });
  }

  function loadQuickStartBody(id){
      var isEmpty = document.getElementById('content'+id).innerHTML === "";
      if(isEmpty)
      {
        //show loader
        document.getElementById('content'+id).innerHTML = '<center><img src="/assets/images/ajax-loader.gif" class="m-50"></center>';

        axios.post('/quickstart/load-body', { id:id } )
        .then((res) => {
          if(res.data.description)
          {
            var image = (res.data.image!='') ? '<img class="align-self-center" src="'+res.data.image+'" style="height: 200px; width: 250px;">' : '';
            var todo = '';
            if(id==1 && res.data.checklists)
            {
              const checklists = res.data.checklists;
              for(var key in checklists)
              {
                  var value = checklists[key];
                  if(value==0)
                  {
                    var x = '<i class="fa fa-remove text-danger"></i> ';
                    switch(key)
                    {
                        case "company":
                        todo += '<li>' + x + 'Company Name</li>';
                        break;
                        case "timezone":
                        todo += '<li>' + x + 'Timezone</li>';
                        break;
                        case "date_format":
                        todo += '<li>' + x + 'Date Format </li>'
                        break;
                        case "time_format":
                        todo += '<li>' + x + 'Time Format </li>';
                        break;
                        case "first_day":
                        todo += '<li>' + x + 'First day of the week </li>';
                        break;
                        case "phone_numbers":
                        todo += '<li>' + x + 'Phone Numbers </li>';
                        break;
                        case "hours":
                        todo += '<li>' + x + 'Hours </li>';
                        break;
                        case "emails":
                        todo += '<li>' + x + 'Emails </li>';
                        break;
                        case "location":
                        todo += '<li>' + x + 'Locations </li>';
                        break;
                    }
                  }
              }

              if(todo!='')
              {
                  todo = '<br><b>Please complete the following:</b><br><ul>'+todo+'</ul><br>';
              }
            }

            document.getElementById('content'+id).innerHTML = '<div class="card-body text-muted">' + image + res.data.description + '<br>' + todo + res.data.body + '</div>';
          
          }else{				
            console.log('Failed to load quickstart content');
          }

        })
        .catch((error) => {
          console.log('error',error.message);
        });
      }

      var index = id;
      isActive.value = isActive.value === index ? null : index;

    }

  // Use onMounted lifecycle hook
  onMounted(() => {
    checkQuickstartProgress()
    loadQuickStart()
  })

</script>

<template>
  <div class="row pt-4 content">
    <div class="col-12 d-flex align-items-center">
      <!-- Rounded image -->
      <img :src="'/assets/images/user/7.jpg'" alt="Profile Image" class="img-70 rounded-circle me-2">
      <div>
        <h4>Hi {{page.props.auth.user.display_name}} 👋</h4> 
        <p>Get the most out of your Buildovate</p>
      </div>
    </div>
  </div>
  
  <div class="container my-4 content">
  <div class="p-4 bg-white rounded shadow-sm">
    <div v-for="q in quickstarts_data" :key="q.id">
      <!-- Clickable row for each item -->
      <div class="d-flex py-3 my-2 border-bottom align-items-center hover-effect" @click="loadQuickStartBody(q.id)"  :aria-expanded="(isActive==q.id) ? true : false">
        <div class="me-3">
          <i class="fa fa-check" :class="q.status === 1 ? 'text-success' : 'text-secondary'"></i>
        </div>
        <div class="flex-grow-1">
          <h6 class="mt-0 mb-1">{{ q.title }}</h6>
        </div>
        <div>
          <!-- Toggle icon changes depending on whether the item is active -->
          <i class="fas" :class="{ 'fa-angle-right': isActive !== q.id, 'fa-angle-down': isActive === q.id }" style="font-size: 1.5em;"></i>
        </div>
      </div>
      
      <!-- Collapsible QUICKSTART CONTENTS -->
      <div :class="(isActive==q.id) ? 'collapse show': 'collapse' ">
        <div :id="'content'+q.id"></div>
        <div class="text-center mb-3">
          <Link :href="q.url" class="btn btn-success">Setup Now</Link>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<style scoped>
.hover-effect {
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}
.hover-effect:hover {
  box-shadow: 0 4px 14px 0 rgba(0,0,0,.1);
  border-color: #3b4b52;
}
.content {
  padding: 0px 15% 0px 15%;
}
</style>