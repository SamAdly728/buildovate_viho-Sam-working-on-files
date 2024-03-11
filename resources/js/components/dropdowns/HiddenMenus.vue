<template>
    <Transition name="slide-fade">
        <div class="bg-white easycreate-dropdown shadow-lg d-flex flex-column">
            <div  style="max-height: calc(100vh - 110px); overflow: auto;" class="slim-scroll-light">
                <template v-for="menu in menus">
                    <Link :href="menu.href" v-if="menu.width > width">
                        <a class="text-dark f-14 f-w-600 px-3 py-3 d-flex gap-3 bg-hover-primary-primary" style="cursor: pointer; overflow: hidden;"
                        :class="active && active.name === menu.name ? 'bg-main' : ''">
                            <i class="f-20 f-w-700" :class="[menu.icon]"></i>
                            <a>{{ menu.name }}</a>
                        </a>
                    </Link>
                </template>
            </div>
        </div>
    </Transition>
</template>
<script>
import { Link } from '@inertiajs/vue3';

export default {
    components:{
        Link
    },
    props: {
        menus: {
            typeof: Array,
            default: []
        },
        width: {
            typeof: Number,
            default: 0
        },
        active: {
            typeof: Object,
            default: {}
        }
    }
}
</script>