<template>
  <div class="rounded">
    <section id="" class="d-flex align-items-center">
      <video autoplay muted loop style="width: 100%; height:100%; outline: 4px solid white; outline-offset: -1px;">
        <source :src="videoUrl" type="video/mp4" >
      </video>
      <div class="container position-absolute" data-aos="fade-up" data-aos-delay="500" style="margin-top: -100px">
        <h1 class="text-muted">Coming Soon!!!</h1>
        <h3 class="text-muted">This page is under development.</h3>
      </div>
    </section>
  </div>
</template>
<script>
export default {
  data() {
    return {
      videoUrl: window.location.origin + '/assets/video/auth-bg.mp4',
    }
  }
}
</script>