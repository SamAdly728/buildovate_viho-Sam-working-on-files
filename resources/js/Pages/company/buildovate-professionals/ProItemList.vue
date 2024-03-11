<script setup>
import { computed, onMounted, ref, watch } from "vue";
import { useMainStore } from "@/stores/main";

const store = useMainStore();
const isFavorite = ref(false);
const companyLogo = ref(
  "https://buildovate-development.s3.us-west-1.amazonaws.com/ConstructionWorkerAvatar.png"
);
const isChecked = ref(false);

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
//   var words = props.item.tags.split(",");
//   return words.slice(0, 10).join(" ");
// });

const profile_image = computed(() => {
  return props.item.profile_image
    ? `https://buildovate-development.s3.us-west-1.amazonaws.com/${props.item.profile_image}`
    : companyLogo.value;
});

const handleChange = (mode) => {
  let new_mode = mode ? false : true;
  isChecked.value = new_mode;

  store.setRightPanel(false);

  if (isChecked.value) {
    setTimeout(() => {
      handleOpen();
    }, 100);
  }
};

onMounted(() => {
  // store.setSelectedPro(null);
});

store.$subscribe(() => {
  // console.log("selectedPro", store.selectedPro);
  isChecked.value =
    store.selectedPro && props.item.pro_id == store.selectedPro.pro_id
      ? true
      : false;
});
</script>

<template>
  <div class="card p-3">
    <div class="row">
      <div class="col">
        <div class="d-flex">
          <div>
            <a href="#" @click.prevent="handleFavorite" class="heart"
              ><i
                class="icofont icofont-heart-alt"
                :class="isFavorite ? 'text-danger' : 'txt-gray'"
                style="font-size: 20px"
              ></i
            ></a>
          </div>
          <div class="ms-2">
            <div>
              <span class="h6" style="font-weight: bold">Specialties</span>
            </div>
            <div class="specialties">
              <p class="text-wrap text-truncate">
                <span
                  class="badge badge-success margin-1"
                  v-for="(item, index) in props.item.tags"
                  :key="index"
                  >{{ item }}</span
                >
              </p>
            </div>
            <div>
              <span
                ><i
                  class="icofont icofont-social-google-map"
                  style="font-size: 22px"
                ></i>
                <span class="h6"
                  >{{ props.item.city }} {{ props.item.state }}</span
                ></span
              >
              <span class="ms-2"
                ><i
                  class="icofont icofont-telephone"
                  style="font-size: 22px"
                ></i>

                <span class="h6 ms-1"
                  >{{ props.item.cell_phone }}
                  {{ props.item.business_phone }}</span
                ></span
              >
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="d-flex justify-content-end">
          <div>
            <div class="text-right">
              <a href="#"
                ><span
                  class="f-w-600 d-block"
                  style="font-weight: bold; font-size: 22px"
                  @click.prevent="handleOpen"
                  >{{ props.item.firstname }} {{ props.item.lastname }}</span
                ></a
              >
            </div>
            <div class="star-rating txt-warning mt-2">
              ★★★★★
              <span class="text-muted">8 Reviews </span>
            </div>
            <div class="media mt-3">
              <div class="media-body text-end">
                <label class="switch">
                  <input
                    type="checkbox"
                    :checked="isChecked"
                    @change="handleChange(isChecked)"
                  /><span class="switch-state"></span>
                </label>
              </div>
            </div>
          </div>
          <div class="ms-3">
            <img style="width: 130px" :src="profile_image" alt="" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
div.specialties {
  width: 500px;
}

.break-all {
  word-break: break-all;
}
.break-word {
  word-wrap: break-word;
}

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
