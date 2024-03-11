<style scoped>
.card{
    min-height:700px;
}
</style>
<template>
    <div class="container-fluid  pt-5">
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-10">
                        <Kanban :lists="lists" :cards="cards" />
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import Kanban from '@/components/Kanban.vue';

defineProps(['lists','cards']);

</script>