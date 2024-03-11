<template>
    <div class="progress-container position-relative bigger" style="cursor: pointer;">
      <div style="position: absolute;" class="d-flex centered justify-content-center align-items-center">
        <div class="d-flex flex-column align-items-center">
            <a class="f-16 f-w-600">$0.00</a>
            <a class="f-14 f-w-500">Deposit</a>
        </div>
      </div>
      <svg viewBox="0 0 120 120">
        <circle
          class="progress-bar__background"
          cx="60"
          cy="60"
          r="54"
          fill="none"
          stroke="#eee"
          stroke-width="12"
        />
        <circle
          class="progress-bar__value"
          cx="60"
          cy="60"
          r="54"
          fill="none"
          stroke-width="12"
          stroke-linecap="round"
          :style="progressStyle"
        />
      </svg>
    </div>
  </template>  
  
  <script>
  export default {
    props: {
      percentage: {
        type: Number,
        default: 0,
      },
    },
    computed: {
      progressStyle() {
        const circumference = 2 * Math.PI * 54; // Circumference of the circle (2πr)
        const offset = circumference - (this.percentage / 100) * circumference;
        const strokeColor = this.percentage === 100 ? '#0b793a' : '#1E5BB2';
        return {
            strokeDasharray: `${circumference} ${circumference}`,
            strokeDashoffset: offset,
            stroke: strokeColor
        };
      },
    },
  };
  </script>
  
  <style scoped>
  .centered{
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
  }
  .progress-container svg {
    width: 130px;
    width: 130px;
  }
  
  .progress-bar__value {
    transition: stroke-dashoffset 0.35s;
    transform: rotate(-90deg);
    transform-origin: center;
  }
  </style>
  
  