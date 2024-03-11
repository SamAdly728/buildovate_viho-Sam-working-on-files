<style scoped>
.easycreate-dropdown-reverse::before {
  right: 708px;
}
</style>
<template>
  <div>
    <div class="table-responsive p-l-30 p-r-30">
      <table class="table">
        <thead>
        <tr>
          <th style="width: 250px" scope="col">Name</th>
          <th>Joined</th>
          <th>Specialties</th>
          <th>Mobile App Download</th>
          <th>Licensed</th>
          <th>Projects</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="u in proUsers.data">
          <td>{{ u.firstname }} {{ u.lastname }}<br><span
              class="text-primary">{{ u.business_email }}<br>{{ formatPhoneNumber(u.cell_phone) }}</span></td>
          <td>{{ formatDateValue(u.created_at) }}</td>
          <td>
            <div style="cursor: pointer" @mouseenter="toggleMoreSpecialties(true, u.pro_id)"
                 @mouseleave="toggleMoreSpecialties(false, u.pro_id)">{{ returnFirstThree(u.specialties) }}
            </div>
            <div style="position: absolute; z-index: 9999; margin-left: 300px; margin-top: -10px;"
                 v-if="showMoreSpecialties && showMoreSpecialtyKey == u.pro_id">
              <div class="bg-white easycreate-dropdown-reverse shadow-lg d-flex flex-column" style="width: 800px">
                <span class="text-dark f-14 f-w-600 px-3 py-2 d-flex gap-3 align-items-center">
                  <div class="d-flex flex-column">
                    <a class="text-muted f-12">{{ u.specialties }}</a>
                  </div>
                </span>
              </div>
            </div>
          </td>
          <td>yes</td>
          <td>yes</td>
          <td></td>
          <td><a href="#" class="btn btn-xs btn-primary-v2">...</a></td>
        </tr>
        </tbody>
      </table>
      <Paging v-if="proUsers.data.length>0" :data="proUsers" :search="search" :params="params"/>
    </div>
  </div>
</template>
<script>
import Paging from "@/components/Paging.vue";

export default {
  components: {Paging},
  props: ['proUsers'],
  data() {
    return {
      search: '',
      params: '',
      showMoreSpecialties: false,
      showMoreSpecialtyKey: null,
    }
  },
  mounted() {
    // console.log(this.proUsers)
  },
  methods: {
    toggleMoreSpecialties(option, key) {
      this.showMoreSpecialties = option
      this.showMoreSpecialtyKey = key
    },
    returnFirstThree(string) {
      if (string) {
        const valuesArray = string.split(',').map(value => value.trim());
        return valuesArray.slice(0, 3).join(', ') + '...';
      }
    },
    formatDateValue(date) {

      if (date === "0000-00-00 00:00:00") {
        return "---- -- --";
      }

      let newDate = new Date(date);
      const months = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec"
      ];
      const month = months[newDate.getMonth()];
      const day = newDate.getDate();
      const year = newDate.getFullYear();
      let hours = newDate.getHours();
      const minutes = newDate.getMinutes();
      const ampm = hours >= 12 ? "PM" : "AM";
      hours = hours % 12;
      hours = hours ? hours : 12;
      const minutesStr = minutes < 10 ? "0" + minutes : minutes;
      return `${month} ${day}, ${year}, ${hours}:${minutesStr} ${ampm}`;
    },
    formatPhoneNumber(phoneNumber) {
      let cleaned = ('' + phoneNumber).replace(/\D/g, '');
      let match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
      if (match) {
        return '(' + match[1] + ') ' + match[2] + '-' + match[3];
      }
      return phoneNumber;
    }
  }
}
</script>