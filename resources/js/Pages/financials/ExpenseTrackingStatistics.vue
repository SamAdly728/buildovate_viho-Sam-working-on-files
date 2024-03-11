<template>
    <div class="row">
        <template v-for="item in items" :key="item">
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div :class="item.color" class=" b-r-4 card-body">
                        <div class="media static-top-widget d-flex align-items-center">
                            
                            <i :class="item.icon" style="font-size: 1.50rem;"></i>
                            <div class="media-body p-0 ml-5">
                                <span class="m-0">{{ item.title }}</span>
                                <h4 class="mb-0 counter">{{formatCurrency(item.amount)}}</h4>
                                <i class="feather feather-database icon-bg" :class="item.icon" style="font-size: 5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>
<script setup>

const items = [
        {title: 'Owner Price', icon: 'icon-pulse', amount: 12345, color: 'bg-primary'},
        {title: 'Amount', icon: 'icon-bar-chart-alt', amount: 10000, color: 'bg-info'},
        {title: 'Remaining', icon: 'icon-stamp', amount: 2345, color: 'bg-secondary'},
        {title: 'Testing', icon: 'icon-stats-up', amount: 75, color: 'bg-dark'},
    ];

    function formatCurrency(amount) {
        if(amount){
            const formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            });
            return formatter.format(parseFloat(amount));
        }else{
            return '$0.0';
        }
    }
</script>