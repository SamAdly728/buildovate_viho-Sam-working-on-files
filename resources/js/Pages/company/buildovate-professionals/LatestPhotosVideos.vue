<template>
  <div class="gallery my-gallery card-body row" itemscope=" ">
    <figure
      v-for="(src, index) in imgs"
      :key="index"
      class="col-xl-3 col-md-4 col-sm-6 xl-33 grid-item"
      @click="() => showImg(index)"
    >
      <img :src="src.image" alt="Image description" class="img-thumbnail" />
      <div class="caption">
        <h4>{{ src.title }}</h4>
        <p>{{ src.descr }}</p>
      </div>
    </figure>
  </div>

  <vue-easy-lightbox
    :index="index"
    :visible="visible"
    :imgs="lightBoxImages"
    @hide="handleHide"
  >
  </vue-easy-lightbox>
</template>

<script>
export default {
  data() {
    return {
      index: 0,
      lightBoxImages: [
        "https://buildovate-development.s3.us-west-1.amazonaws.com/post2.jpg",
        "https://buildovate-development.s3.us-west-1.amazonaws.com/post3.jpg",
        "https://buildovate-development.s3.us-west-1.amazonaws.com/post2.jpg",
        "https://buildovate-development.s3.us-west-1.amazonaws.com/post3.jpg",
        "https://buildovate-development.s3.us-west-1.amazonaws.com/post2.jpg",
        "https://buildovate-development.s3.us-west-1.amazonaws.com/post3.jpg",
        "https://buildovate-development.s3.us-west-1.amazonaws.com/post2.jpg",
        "https://buildovate-development.s3.us-west-1.amazonaws.com/post3.jpg"
      ],
      visible: false,
      imgs: [
        {
          image:
            "https://buildovate-development.s3.us-west-1.amazonaws.com/post2.jpg"
        },
        {
          image:
            "https://buildovate-development.s3.us-west-1.amazonaws.com/post3.jpg"
        },
        {
          image:
            "https://buildovate-development.s3.us-west-1.amazonaws.com/post2.jpg"
        },
        {
          image:
            "https://buildovate-development.s3.us-west-1.amazonaws.com/post3.jpg"
        },
        {
          image:
            "https://buildovate-development.s3.us-west-1.amazonaws.com/post2.jpg"
        },
        {
          image:
            "https://buildovate-development.s3.us-west-1.amazonaws.com/post3.jpg"
        },
        {
          image:
            "https://buildovate-development.s3.us-west-1.amazonaws.com/post2.jpg"
        },
        {
          image:
            "https://buildovate-development.s3.us-west-1.amazonaws.com/post3.jpg"
        }
      ]
    };
  },
  methods: {
    showImg(index) {
      this.index = index;
      this.visible = true;
    },
    handleHide() {
      this.visible = false;
    }
  },
  mounted() {
    // this.imgs.forEach((item) => {
    //   this.lightBoxImages.push(
    //     require("@/assets/images/big-lightgallry/" + item.image)
    //   );
    // });
  }
};
</script>
