<template>
    <Transition name="slide-fade">
        <header v-show="page.props.style.sidebar" class="main-nav bg-white" :style="page.props.style.sidebar_opacity" :class="isHovered ? 'b-r-primary-v2' : ''">
            <div class="position-relative d-flex flex-column" style="height: 100%; width: 100%; ">
                <div style="height: 98px; overflow: hidden;" class="d-flex" :class="showExtraHeader ? '' : 'px-4'">
                    
                    <img :src="asset_link + 'general/buildovate_logo_big.png'" alt="logo" style="height: 70px;" v-if="this.store.isOpen"/>

                    <div class="d-flex flex-column float-right" style="width: 21px;" v-if="showExtraHeader">
                        <div class="bg-primary-v2 d-flex gap-0" style="height: 49px; width: 100%;"></div>
                        <div class="bg-white d-flex gap-0" style="height: 49px;" v-if="topHeaderStore.selectedMenu && topHeaderStore.selectedMenu.sub_menus.length != 0"></div>
                    </div>
                </div>
                <div class="flex-grow-1 shadow-sm bg-white" v-if="this.store.isOpen">
                    <CompanySide v-if="store.component === 'dashboard'"/>
                    <CompanySide v-else-if="store.component === 'company'"/>
                    <InboxSide  v-else-if="store.component === 'inbox'"/>
                    <TodoSide  v-else-if="store.component === 'todos'"/>
                    <Calendar v-else-if="store.component === 'calendar'"/>
                    <ProposalSide v-else-if="store.component === 'proposal'"/>
                    <JobsiteList v-else/>
                </div>
                <a class="btn-sidebar-toggle f-20 d-flex align-items-center justify-content-center" @click="handleToggleClick()" @mouseenter="hovered(true)" @mouseleave="hovered(false)" v-if="!store.disabled">
                    <i class="icofont icofont-rounded-left"></i>
                </a>
            </div>
        </header>
    </Transition>
</template>
<script>
import { usePage } from '@inertiajs/vue3';
import { useSideBar } from '../stores/sidebar';
import { useTopHeader } from '../stores/topheader';
import JobsiteList from './sidebar/JobsiteList.vue';
import CompanySide from './sidebar/CompanySide.vue';
import InboxSide from './sidebar/InboxSide.vue';
import TodoSide from './sidebar/TodoSide.vue';
import Calendar from './sidebar/Calendar.vue';
import ProposalSide from './sidebar/ProposalSide.vue';

export default {
    components: { JobsiteList, CompanySide, InboxSide, TodoSide, Calendar, ProposalSide },
    setup(){
        const page = usePage();
        const store = useSideBar();
        const topHeaderStore = useTopHeader();

        return { page, store, topHeaderStore } 
    },
    data(){
        const asset_link = window.asset_link;
        const showExtraHeader = false;
        const isHovered = false;

        return { asset_link, showExtraHeader, isHovered }
    },
    methods: {
        hovered(status){
            this.isHovered = status;
        },
        toggleSideBar() {
            document.querySelectorAll('.page-wrapper.compact-wrapper .page-body-wrapper header.main-nav').forEach(header => {
                header.style.width = !this.store.isOpen ? "21px" : "320px";
            });
            const headerHeight = this.topHeaderStore.selectedMenu ? this.topHeaderStore.selectedMenu.sub_menus.length != 0 ? '98px' : '49px' : '49px';
            const marginLeft = this.store.isOpen ? '320px' : '21px';
            this.page.props.style.page_body = `margin-top: ${headerHeight} !important; min-height: calc(100vh - ${headerHeight}) !important; max-height: calc(100vh - ${headerHeight}) !important; margin-left: ${marginLeft};`;
        
            const icon = document.querySelector('.btn-sidebar-toggle i');
            if (icon) {
                icon.classList.toggle('rotate-icon');
            }

            if(!this.store.isOpen){
                setTimeout(() => {
                    this.showExtraHeader = true;
                }, 500);
            }else{
                this.showExtraHeader = false;
            }
        },
        handleToggleClick(){
            this.store.toggle();
        },
        setStoreComponent(to){
            if(to.includes('company')){
                this.store.setComponent('company');
            }else if(to.includes('dashboard')){
                this.store.setComponent('dashboard');
            }else if(to.includes('inbox')){
                this.store.setComponent('inbox');
            }else if(to.includes('todos')) {
                this.store.setComponent('todos');
            }else if(to.includes('calendar')){
                this.store.setComponent('calendar');
            }else if(to.includes('lead-management/proposal')){
                this.store.setComponent('proposal');
            }else{
                this.store.setComponent('default');
            }
        }
    },
    mounted(){
        const to = this.page.url;
        this.setStoreComponent(to);

        document.querySelectorAll('.page-wrapper.compact-wrapper .page-body-wrapper header.main-nav').forEach(header => {
            header.style.width = !this.store.isOpen ? "21px" : "320px";
        });
    },
    computed: {
        toggled() {
            return this.store.isOpen;
        },
        url() {
            return this.page.url;
        }
    },
    watch: {
        toggled: {
            handler(){
                this.toggleSideBar();
            }
        },
        url: {
            handler(to, _) {
                this.setStoreComponent(to);
            }
        }
    }
}
</script>