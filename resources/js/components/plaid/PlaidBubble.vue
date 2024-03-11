<template>
    <div
        ref="draggable"
        class="draggable shadow-lg bg-white d-flex align-items-center justify-content-center bigger"
        :class="{ 'smooth-transition': !dragging }"
        @mousedown="dragStart"
        :style="{ left: `${x}px`, top: `${y}px` }"
        @click="handlePlaidClick"
    >
        <img :src="asset_link + 'general/plaid_icon.png'" alt="logo" style="height: 35px;"/>
    </div>
  </template>
  
<script>
import { useSideBar } from '../../stores/sidebar';
import { useTransactionSidebar } from '../../stores/plaid-transaction';
import { ref, watch, onMounted  } from 'vue';

export default {
  methods:{
    handlePlaidClick(){
      this.transactionStore.open();
    }
  },
  setup() {
    const transactionStore = useTransactionSidebar();
    const store = useSideBar();
    const draggable = ref(null);
    const x = ref(0);
    const y = ref(0);
    const dragging = ref(false);
    const asset_link = window.asset_link;

    // Function to snap to the nearest side
    const snapToNearestSide = (watched) => {
      dragging.value = false; // Ensure smooth transition applies
      const draggableWidth = draggable.value.offsetWidth;
      const parentWidth = draggable.value.parentNode.offsetWidth;
      const halfParentWidth = parentWidth / 2;
      if (x.value + draggableWidth / 2 < halfParentWidth) {
        x.value = 0;
      } else {
        if(watched){
            if(store.isOpen){
                x.value = (parentWidth - draggableWidth) - 301;
            }else{
                x.value = (parentWidth - draggableWidth) + 301;
            }
        }else{
            x.value = parentWidth - draggableWidth - 1;
        }
      }
    };

    const dragStart = (event) => {
      dragging.value = true;
      const startX = event.clientX - x.value;
      const startY = event.clientY - y.value;

      const mouseMove = (event) => {
        x.value = event.clientX - startX;
        y.value = event.clientY - startY;
      };

      const dragEnd = () => {
        snapToNearestSide(false); // Use the snap function here as well
        document.removeEventListener('mousemove', mouseMove);
        document.removeEventListener('mouseup', dragEnd);
      };

      document.addEventListener('mousemove', mouseMove);
      document.addEventListener('mouseup', dragEnd);
    };

    onMounted(() => {
        x.value = 1000;
        y.value = 300;
        // snapToNearestSide(false);
    });

    watch(() => store.isOpen, (newData, oldData) => {
      snapToNearestSide(true);
    });

    return { draggable, x, y, dragStart, dragging, asset_link, transactionStore };
  },
};
</script>
  
  <style scoped>
  .draggable {
    width: 50px;
    height: 50px;
    position: absolute;
    text-align: center;
    line-height: 50px;
    border-radius: 50%;
    cursor: pointer;
    user-select: none;
    z-index: 100;
    border: 2px solid black;
  }

.smooth-transition {
    transition: left 0.3s ease-out; /* Smooth transition for the left property */
}

</style>
  