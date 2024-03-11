<script setup>
import { computed, onMounted, ref } from "vue";
import { useMainStore } from "@/stores/main";

const store = useMainStore();
const isFavorite = ref(false);
const companyLogo = ref(
  "https://buildovate-development.s3.us-west-1.amazonaws.com/ConstructionWorkerAvatar.png"
);

const props = defineProps(["item"]);
const emits = defineEmits(["onOpen"]);

const handleOpen = () => {
  store.setSelectedPro(props.item);
  store.showViewProfile(true);
  store.setRightPanel(true);
  store.setMessage("This is a test message");
};

const handleFavorite = () => {
  isFavorite.value = !isFavorite.value;
};

// const skills = computed(() => {
//   var words = props.item.specialties.split(",");
//   return words.slice(0, 10).join(" ");
// });

const profile_image = computed(() => {
  return props.item.profile_image
    ? `https://buildovate-development.s3.us-west-1.amazonaws.com/${props.item.profile_image}`
    : companyLogo.value;
});

onMounted(() => {
  store.setSelectedPro(null);
});
</script>

<template>
  <div class="card p-3">
    <div class="md:hidden">
      <a href="#" @click.prevent="handleFavorite"
        ><i
          class="icofont icofont-heart-alt"
          :class="isFavorite ? 'text-danger' : 'txt-gray'"
          style="font-size: 20px"
        ></i
      ></a>
    </div>

    <div class="row">
      <div class="col">
        <div class="d-flex justify-content-center">
          <img
            class="m-r-15"
            style="width: 130px"
            :src="profile_image"
            alt=""
          />
        </div>
      </div>
      <div class="col-md-10">
        <div class="pro-name">
          <div>
            <a href="#"
              ><span
                class="f-w-600 d-block"
                style="font-weight: bold; font-size: 22px"
                @click.prevent="handleOpen"
                >{{ props.item.firstname }} {{ props.item.lastname }}</span
              ></a
            >
          </div>
          <div class="star-rating txt-warning">
            ★★★★★
            <span class="text-muted">8 Reviews</span>
          </div>
        </div>

        <div class="pro-name">
          <span class="h6" style="font-weight: bold">Specialties</span>
        </div>
        <div class="specialties">
          <p class="text-wrap text-truncate">{{ props.item.tags }}...</p>
        </div>

        <div class="row mt-2">
          <div class="col-md-10 text-right">
            <span
              ><i
                class="icofont icofont-social-google-map"
                style="font-size: 22px"
              ></i>
              <span class="h6"
                >{{ props.item.city }} {{ props.item.state }}</span
              ></span
            >
            <span
              ><i class="icofont icofont-telephone" style="font-size: 22px"></i>

              <span class="h6 ms-1"
                >{{ props.item.cell_phone }}
                {{ props.item.business_phone }}</span
              ></span
            >
          </div>
          <div class="col md:hidden text-center">
            <a
              class="d-inline mt-1 text-primary"
              href="#"
              @click.prevent="handleOpen"
              ><b>View Profile</b></a
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.txt-gray {
  color: lightgray;
}
.pro-name {
  text-align: right;
}

.heart {
  float: left;
}

.ml {
  margin-left: 10px;
}

.desktop-view {
  display: block;
}

/* Styles for screens with a maximum width of 767px (extra-small) */
@media (max-width: 767px) {
  .pro-name {
    text-align: center;
  }

  .heart {
    top: 13px;
    position: absolute;
    right: 12px;
  }

  .ml {
    margin-left: 0px;
  }

  .desktop-view {
    display: none;
  }

  .txt-gray {
    color: lightgray;
  }
}
</style>
