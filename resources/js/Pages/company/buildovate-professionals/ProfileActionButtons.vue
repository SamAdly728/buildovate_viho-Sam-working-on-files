<script setup>
import { ref } from "vue";

const isFavorite = ref(false);

const handleFavorite = () => {
  isFavorite.value = !isFavorite.value;
};
</script>
<template>
  <div class="d-flex align-items-center">
    <span class="onhover-dropdown">
      <svg
        width="16"
        height="13"
        viewBox="0 0 16 13"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M15.0769 0H0.923077C0.413276 0 0 0.415736 0 0.928571C0 1.44141 0.413276 1.85714 0.923077 1.85714H15.0769C15.5867 1.85714 16 1.44141 16 0.928571C16 0.415736 15.5867 0 15.0769 0Z"
        ></path>
        <path
          d="M15.0769 5.57143H0.923077C0.413276 5.57143 0 5.98717 0 6.5C0 7.01284 0.413276 7.42857 0.923077 7.42857H15.0769C15.5867 7.42857 16 7.01284 16 6.5C16 5.98717 15.5867 5.57143 15.0769 5.57143Z"
        ></path>
        <path
          d="M15.0769 11.1429H0.923077C0.413276 11.1429 0 11.5586 0 12.0714C0 12.5843 0.413276 13 0.923077 13H15.0769C15.5867 13 16 12.5843 16 12.0714C16 11.5586 15.5867 11.1429 15.0769 11.1429Z"
        ></path>
      </svg>

      <ul
        class="notification-dropdown onhover-show-div"
        style="top: 20px; width: 200px; padding-top: 5px"
      >
        <li class="p-2">
          <div class="d-flex align-items-center">
            <i
              class="icofont icofont-heart-alt ms-1"
              style="font-size: 16px"
            ></i>
            <span class="ms-2">HERE</span>
          </div>
        </li>
        <li class="p-2">
          <div class="d-flex align-items-center">
            <i
              class="icofont icofont-heart-alt ms-1"
              style="font-size: 16px"
            ></i>
            <span class="ms-2">HERE</span>
          </div>
        </li>
        <li class="p-2">
          <div class="d-flex align-items-center">
            <i
              class="icofont icofont-heart-alt ms-1"
              style="font-size: 16px"
            ></i>
            <span class="ms-2">HERE</span>
          </div>
        </li>
        <li>
          <button
            class="btn btn-square btn-outline-light txt-dark w-100"
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#create-favorite-list"
          >
            + Create List
          </button>
        </li>
      </ul>
    </span>
    <span class="ms-2">
      <a href="#" @click.prevent="handleFavorite"
        ><i
          class="icofont icofont-heart-alt"
          :class="isFavorite ? 'text-danger' : 'txt-gray'"
          style="font-size: 18px"
        ></i
      ></a>
    </span>
  </div>
</template>

<style scoped>
.txt-gray {
  color: lightgray;
}

/* Styles for screens with a maximum width of 767px (extra-small) */
@media (max-width: 767px) {
  .txt-gray {
    color: lightgray;
  }
}
</style>
