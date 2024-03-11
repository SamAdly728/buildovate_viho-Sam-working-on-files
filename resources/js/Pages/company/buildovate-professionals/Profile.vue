<script setup>
import { computed, ref } from "vue";
import { useMainStore } from "@/stores/main";
import LatestPhotosVideos from "@/Pages/company/buildovate-professionals/LatestPhotosVideos.vue";
import ReviewItem from "@/Pages/company/buildovate-professionals/ReviewItem.vue";
import ProfileActionButtons from "@/Pages/company/buildovate-professionals/ProfileActionButtons.vue";

const store = useMainStore();

const companyLogo = ref(
  "https://buildovate-development.s3.us-west-1.amazonaws.com/ConstructionWorkerAvatar.png"
);

const emits = defineEmits(["onOpen"]);

const handleOpen = () => {
  store.setRightPanel(true);
  store.setMessage("This is a test message");
};

const handleEdit = () => {
  alert("Suggest an Edit\nComing soon...");
};

const handleOwnBusiness = () => {
  alert("Own this Business?\nComing soon...");
};

const profile_image = computed(() => {
  return store.selectedPro.profile_image
    ? `https://buildovate-development.s3.us-west-1.amazonaws.com/${store.selectedPro.profile_image}`
    : companyLogo.value;
});
</script>
<template>
  
  <div>
    <button class="btn btn-primary btn-sm" @click="handleEdit">
      Suggest an Edit
    </button>
    <button class="btn btn-primary btn-sm ms-1" @click="handleOwnBusiness">
      Own this Business?
    </button>
  </div>
  <div class="row row-cols-1 row-cols-sm-2">
    <div class="col-md-5">
      <div class="card text-center p-4">
        <ProfileActionButtons></ProfileActionButtons>
        <div class="d-flex justify-content-center">
          <div>
            <img class="img-100 rounded-circle" :src="profile_image" alt="" />
          </div>
        </div>
        <div class="h3 mt-2">
          <strong>{{ store.selectedPro.firstname }} {{ store.selectedPro.lastname }}</strong>
        </div>
        <div class="d-flex justify-content-center align-items-center">
          <svg
            width="28px"
            height="28px"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            style="fill: green"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M12.3636 3L5 6.27273V11.1818C5 15.7227 8.14182 19.9691 12.3636 21C16.5855 19.9691 19.7273 15.7227 19.7273 11.1818V6.27273L12.3636 3ZM15.06 9L16 9.94667L10.6667 15.28L8 12.62L8.94667 11.68L10.6667 13.3933L15.06 9Z"
            />
          </svg>
          <span>LICENSED</span>
          <span class="text-muted ms-2" style="font-size: 10px; cursor: pointer"
            >Check<br />Licensed</span
          >
        </div>
        <div class="star-rating txt-warning">
          ★★★★★
          <span class="text-muted">8 Reviews</span>
        </div>
        <div class="d-flex justify-content-evenly align-items-center m-3">
          <div>Contact Me:</div>
          <div class="ml">
            <div class="font-weight-bold d-inline h6">
              <i class="icofont icofont-telephone" style="font-size: 22px"></i>

              <span class="h6 ms-1">{{ store.selectedPro.cell_phone }}</span>
            </div>
          </div>
        </div>
        <div>
          <i class="icofont icofont-brand-linkedin" style="font-size: 22px"></i>
          <i
            class="icofont icofont-social-facebook"
            style="font-size: 22px"
          ></i>
          <i
            class="icofont icofont-social-instagram"
            style="font-size: 22px"
          ></i>
          <i class="icofont icofont-social-yelp" style="font-size: 22px"></i>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card">
        <div class="col-xl-12 col-lg-6 col-md-12 col-sm-6">
          <div class="card">
            <h5 class="p-3">Latest Photos and Videos</h5>

            <LatestPhotosVideos></LatestPhotosVideos>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row row-cols-1 row-cols-sm-2">
    <div class="col-md-7">
      <div class="card p-3">
        <h6>Specialties and Pricing</h6>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card p-3"><h6>Form Wizard Validation</h6></div>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-3">
        <h6>Reviews</h6>

        <div class="row row-cols-1 row-cols-sm-2">
          <div class="col">
            <div>109 reviews</div>
            <table class="w-100">
              <tr>
                <td>5 Stars</td>
                <td style="width: 300px">
                  <div class="progress lg-progress-bar">
                    <div
                      class="progress-bar bg-secondary"
                      role="progressbar"
                      style="width: 100%"
                      aria-valuenow="50"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                </td>
                <td>(107)</td>
              </tr>
              <tr>
                <td>4 Stars</td>
                <td style="width: 300px">
                  <div class="progress lg-progress-bar">
                    <div
                      class="progress-bar bg-secondary"
                      role="progressbar"
                      style="width: 20%"
                      aria-valuenow="50"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                </td>
                <td>(2)</td>
              </tr>
              <tr>
                <td>3 Stars</td>
                <td style="width: 300px">
                  <div class="progress">
                    <div
                      class="progress-bar bg-default"
                      role="progressbar"
                      aria-valuenow="0"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                </td>
                <td>(0)</td>
              </tr>
              <tr>
                <td>2 Stars</td>
                <td style="width: 300px">
                  <div class="progress lg-progress-bar">
                    <div
                      class="progress-bar bg-secondary"
                      role="progressbar"
                      style="width: 0%"
                      aria-valuenow="50"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                </td>
                <td>(0)</td>
              </tr>
              <tr>
                <td>1 Star</td>
                <td style="width: 300px">
                  <div class="progress lg-progress-bar">
                    <div
                      class="progress-bar bg-secondary"
                      role="progressbar"
                      style="width: 0%"
                      aria-valuenow="50"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                </td>
                <td>(0)</td>
              </tr>
            </table>
          </div>
          <div class="col">
            <div class="star-rating txt-warning text-right">★★★★★</div>
            <p><strong>Rating Breakdown</strong></p>
            <table class="w-100">
              <tr>
                <td>Seller communication level</td>
                <td>
                  <span class="star-rating txt-default text-right">★</span
                  ><span class="ms-1">5</span>
                </td>
              </tr>
              <tr>
                <td>Recommend to a friend</td>
                <td>
                  <span class="star-rating txt-default text-right">★</span
                  ><span class="ms-1">5</span>
                </td>
              </tr>
              <tr>
                <td>Service as described</td>
                <td>
                  <span class="star-rating txt-default text-right">★</span
                  ><span class="ms-1">5</span>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="mt-5">
          <div class="timeline-content">
            <div class="social-chat">
              <ReviewItem></ReviewItem>
              <ReviewItem></ReviewItem>
              <ReviewItem></ReviewItem>
              <ReviewItem></ReviewItem>

              <div class="text-center">
                <a class="f-w-600" href="javascript:void(0)">More Reviews</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.progress-bar {
  border-radius: 0%;
}

#mobile-button {
  cursor: pointer;
  display: inline-block;
}

#mobile-button::after {
  display: block;
  content: "";
  height: 4px;
  width: 25px;
  border-top: 3px solid #fc0101;
  border-bottom: 3px solid #fc0101;
}

#mobile-button::before {
  display: block;
  content: "";
  height: 4px;
  width: 25px;
  border-top: 3px solid #fc0101;
}
</style>
