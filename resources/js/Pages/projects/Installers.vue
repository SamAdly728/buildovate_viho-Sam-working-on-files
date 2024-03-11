<style scoped>
.card{
    min-height:384px;
}
</style>
<template>
    <div class="container-fluid  pt-5">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <Installers />
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import Installers from '@/components/projects/Installers.vue';

</script>