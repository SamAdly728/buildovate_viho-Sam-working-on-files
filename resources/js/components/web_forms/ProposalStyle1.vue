<template>
    <div class="px-5 d-flex justify-content-center py-3" style="width: 100% !important; background-color: #cecdcd; overflow: auto;">
        <div class="d-flex flex-column">
            <div class="letter_dimension shadow position-relative">
                <div class="layer layer_3"></div>
                <div class="layer" :style="{ backgroundImage: `url(${front_l2})` }"></div>
            </div>

            <div class="letter_dimension shadow position-relative">
                <div class="layer" :style="{ backgroundImage: `url(${bg_page_2})` }"></div>
                
            </div>

            
            <div class="letter_dimension shadow position-relative">
                <div class="layer" :style="{ backgroundImage: `url(${bg_page_3})` }"></div>
                
            </div>
            
            <div class="letter_dimension shadow position-relative">
                <div class="layer" :style="{ backgroundImage: `url(${bg_page_4})` }">
                </div>
                <div class="gallery my-gallery card-body row p-0  image-grid">
                    <figure  v-for="n in 9" :key="n" class="col-xl-4 col-md-4 xl-33 p-1 mb-1" itemprop="associatedMedia" ><a :href="'/assets/images/big-lightgallry/01.jpg'" itemprop="contentUrl" data-size="1600x950"><img class="img-thumbnail" :src="'/assets/images/lightgallry/01.jpg'" itemprop="thumbnail" alt="Image description"></a>
                        <!-- <figcaption itemprop="caption description">Image caption  1</figcaption> -->
                    </figure>
                </div>
            </div>
            <div class="letter_dimension shadow position-relative">
                <div class="layer" :style="{ backgroundImage: `url(${bg_page_5})` }"></div>
            </div>
            <div class="letter_dimension shadow position-relative">
                <div class="layer" :style="{ backgroundImage: `url(${bg_page_6})` }"></div>
            </div>
            <div class="letter_dimension shadow position-relative">
                <div class="layer" :style="{ backgroundImage: `url(${bg_page_6})` }"></div>
            </div>
            <div class="letter_dimension shadow position-relative">
                <div class="layer" :style="{ backgroundImage: `url(${bg_page_8})` }"></div>
            </div>
            <div class="letter_dimension shadow position-relative">
                <div class="layer" :style="{ backgroundImage: `url(${bg_page_9})` }"></div>
            </div>
            <div class="letter_dimension shadow position-relative">
                <div class="layer" :style="{ backgroundImage: `url(${bg_page_9})` }"></div>
            </div>
            <div class="letter_dimension shadow position-relative">
                <div class="layer" :style="{ backgroundImage: `url(${bg_page_9})` }"></div>
            </div>
            <div class="letter_dimension shadow position-relative">
                <div class="layer" :style="{ backgroundImage: `url(${bg_page_9})` }"></div>
            </div>

        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import front_layer_2 from '../../../assets/templates/proposal_style_bg_2.png';
import page_3 from '../../../assets/templates/proposal_page_3.png';
import page_2 from '../../../assets/templates/proposal_page_2.png';
import page_4 from '../../../assets/templates/proposal_page_4.png';
import page_5 from '../../../assets/templates/proposal_page_5.png';
import page_6_7 from '../../../assets/templates/proposal_page_6.png';
import page_8 from '../../../assets/templates/proposal_page_8.png';
import page_9 from '../../../assets/templates/proposal_page_9.png';

const front_l2 = ref(front_layer_2);
const bg_page_2 = ref(page_2);
const bg_page_3 = ref(page_3);
const bg_page_4 = ref(page_4);
const bg_page_5 = ref(page_5);
const bg_page_6 = ref(page_6_7);
const bg_page_8 = ref(page_8);
const bg_page_9 = ref(page_9);
</script>

<style scoped>
    .letter_dimension{
        width: 612px;
        height: 792px !important;
        background-color: white;
        margin-bottom: 20px;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-image: url('../../../assets/templates/proposal_style_bg_1.jpg');
    }

    .layer{
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        background-repeat: no-repeat;
        background-size: 100% 100%;
    }
    
    .layer_3{
        background-size: 100% 85% !important;
        background-image: url('../../../assets/templates/proposal_style_bg_3.png');
    }

    .image-grid{
        background-color:white;
        margin: 25% 10% 25% 10%;
        padding: 15px 0px 15px 0px;
    }

    
</style>