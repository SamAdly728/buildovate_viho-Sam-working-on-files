<template>
    <small v-if="props.subtitle != ''">{{ props.subtitle }}</small>
	<h3>{{ props.page_title != '' ? props.page_title : lastPath }}</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item" v-for="(breadcrumb, index) in breadcrumbs" :key="breadcrumb.text">
			<Link 
                :href="breadcrumb.href" 
                :name="(props.last_page_title != '' && index === (breadcrumbs.length - 1)) ? props.last_page_title : breadcrumb.text" >
            </Link>
		</li>
	</ol>
</template>
<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Link from './Link.vue';

const page = usePage();
const lastPath = ref('');
const props = defineProps({
    page_title: {
        typeof: String,
        default: ''
    },
    stop_at: {
        typeof: String,
        default: ''//EDIT: use' edit-lead' on EDITLEAD page.
    },
    last_page_title:{
        typeof: String,
        default: ''//EDIT: use' edit-lead' on EDITLEAD page.
    },
    subtitle:{
        typeof: String,
        default: ''
    }
});

function generateBreadcrumbs() {
    const url = page.url;
    const segments = url.split('/').filter(Boolean);
    const breadcrumbs = [];
    let currentPath = '';
    let stopNext = false;

    for(const segment of segments) {
        if (stopNext) break;
        
        if (!isNaN(segment)) break;
        
        currentPath += `/${segment}`;
        let breadcrumbText = '';

        breadcrumbText = segment.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');

        breadcrumbs.push({ text: breadcrumbText, href: currentPath });

        lastPath.value = breadcrumbText;
        if (segment === props.stop_at) true;
    }

    return breadcrumbs;
}

const breadcrumbs = ref(generateBreadcrumbs());
</script>
<style scoped>
    .breadcrumb-item{
        background-color: transparent !important;
    }
</style>