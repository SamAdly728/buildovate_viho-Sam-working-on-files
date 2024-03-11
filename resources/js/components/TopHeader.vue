<template>
    <Transition name="slide-fade">
        <div ref="headerContainer" class="page-main-header d-flex top-header-sidebar" style="z-index: 7;" :class="!sidebarStore.isOpen ? 'open' : ''" :style="{ width: !sidebarStore.isOpen ? 'calc(100vw - 21px)' : 'calc(100vw - 320px)' }">
            <div class="flex-grow-1 d-flex flex-column shadow-sm">
                <div class="bg-primary-v2 d-flex gap-0 px-4" style="height: 49px;">
                    <template v-for="menu in menus">
                        <Link :href="menu.href"  v-if="headerWidth > menu.width" >
                            <a class="d-flex align-items-center" style="height: 100%; cursor: pointer;" :class="active_menu && active_menu_name === menu.name ? 'active_menu' : ''"  @click="handleMenuClick(menu)">
                                <span class="px-4 f-16" :class="active_menu && active_menu_name === menu.name ? 'text-primary-v2 f-w-600' : 'text-white f-w-400'">
                                    {{ menu.name }}
                                </span>
                            </a>
                        </Link>
                    </template>
                    <div class="flex-grow-1"></div>
                    <div class="align-right position-relative">
                        <a class="d-flex align-items-center justify-content-center gap-3 top-icons position-relative" style="height: 100%;">
                            <div v-if="headerWidth <= 1340"  @mouseenter="toggleHiddenMenuDropdown(true)" @mouseleave="toggleHiddenMenuDropdown(false)">
                                <a class="px-2 f-16 text-white d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                    <i class="icon-arrow-circle-down"></i>
                                </a>
                                <div style="position: relative; width: 0;">
                                    <HiddenMenus :menus="menus" :width="headerWidth" :active="active_menu" v-if="showHiddenMenuDropDown"/>
                                </div>
                            </div>
                            <div>
                                <a class="px-2 f-16 text-white d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                    <i class="icon-search f-w-600"></i>
                                </a>
                                <div style="position: relative; width: 0;">
                                    <!-- <ProfileDropDown /> -->
                                </div>
                            </div>
                            <div @mouseenter="toggleEasyCreateDropdown(true)" @mouseleave="toggleEasyCreateDropdown(false)">
                                <a class="px-2 f-16 text-white d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                    <i class="icon-plus f-w-600"></i>
                                </a>
                                <div style="position: relative; width: 0;" v-if="showEasyCreateDropDown">
                                    <EasyCreateDropDown />
                                </div>
                            </div>
                            <div>
                                <a class="px-2 f-16 text-white d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                    <i class="flaticon fi fi-rs-bell f-w-600"></i>
                                </a>
                                <div style="position: relative; width: 0;">
                                    <!-- <ProfileDropDown /> -->
                                </div>
                            </div>
                            <div @mouseenter="togglePeoplesDropdown(true)" @mouseleave="togglePeoplesDropdown(false)">
                                <a class="px-2 f-16 text-white d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                    <i class="flaticon fi fi-rs-user f-w-600"></i>
                                </a>
                                <div style="position: relative; width: 0;" v-if="showMPeoplesDropDown">
                                    <ManagePeopleDropDown />
                                </div>
                            </div>
                            <div @mouseenter="toggleMessagesDropdown(true)" @mouseleave="toggleMessagesDropdown(false)">
                                <a class="px-2 f-16 text-white d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                    <i class="flaticon fi fi-rr-messages f-w-600"></i>
                                </a>
                                <div style="position: relative; width: 0;" v-if="showMessagesDropDown">
                                    <MessagesDropDown />
                                </div>
                            </div>
                            
                            <a style="height: 38px; width: 38px;" id="profile-icon" @mouseenter="toggleProfileDropdown(true)" @mouseleave="toggleProfileDropdown(false)">
                                <a class="circle-image-secondary"  style="cursor: pointer; height: 100%; width: 100%; position: relative; display: block;">
                                    <a class="circle-image-light-default f-w-700 f-18">LJ</a>
                                </a>
                                <div style="position: relative;" v-if="showProfileDropDown">
                                    <ProfileDropDown />
                                </div>
                            </a>

                        
                        </a>
                    </div>
                </div>
                <div class="bg-white d-flex gap-0 px-4" style="height: 49px;" v-if="active_menu && active_menu.sub_menus.length != 0">
                    <template v-for="sub_menu in active_menu.sub_menus">
                        <Link :href="sub_menu.href">
                            <a class="d-flex align-items-center" style="height: 100%; cursor: pointer;" @click="handleSubMenuClick(sub_menu)">
                                <a class="px-4 text-dark f-14" :class="active_sub_menu && active_sub_menu.name === sub_menu.name ? 'f-w-600' : 'f-w-400'">{{ sub_menu.name }}</a>
                            </a>
                        </Link>
                    </template>
                </div>
            </div>
        </div>
    </Transition>
</template>
<script>
import { usePage } from '@inertiajs/vue3';
import { useSideBar } from '../stores/sidebar';
import { useTopHeader } from '../stores/topheader';
import { Link } from "@inertiajs/vue3";
import ProfileDropDown from './dropdowns/ProfileDropDown.vue';
import EasyCreateDropDown from './dropdowns/EasyCreateDropDown.vue';
import MessagesDropDown from './dropdowns/MessagesDropDown.vue';
import ManagePeopleDropDown from './dropdowns/ManagePeopleDropDown.vue';
import HiddenMenus from './dropdowns/HiddenMenus.vue';

export default{
    components: {
        Link,
        ProfileDropDown,
        EasyCreateDropDown,
        MessagesDropDown,
        ManagePeopleDropDown,
        HiddenMenus
    },
    setup(){
        const page = usePage();
        const sidebarStore = useSideBar();
        const store = useTopHeader();

        return { page, sidebarStore, store }
    },
    data(){
        const menus = [
            { name: 'Dashboard', href: '/dashboard',  width: 820, sub_menus: [] },
            { name: 'Projects', href: '/projects',  width: 820,
                sub_menus: [
                    { name: 'Overview', href: '/projects' },
                    { name: 'To Do', href: '/projects/todo' },
                    { name: 'Installer Status', href: '/projects/installer-status' },
                    { name: 'Schedule', href: '/projects/schedule' },
                    { name: 'Payments', href: '/projects/payments' },
                    { name: 'Reports', href: '/projects/reports' },
                    { name: 'Agreements', href: '/projects/agreements' },
                    { name: 'Timelines', href: '/projects/timelines' },] 
                },
            { name: 'To Do', href: '/todos',  width: 820,
                sub_menus: [
                    { name: 'List', href: '/todos' },
                    { name: 'Kanban', href: '/todos/kanban' }] 
                },
            { name: 'Sales', href: '/sales', width: 820,
                sub_menus: [
                    { name: 'Overview', href: '/sales' },
                    { name: 'Lead Management', href: '/sales/lead-management' },
                    { name: 'Activities', href: '/sales/activities' },
                    { name: 'Smart Estimates', href: '/sales/smart-estimates' },
                    { name: 'Proposals', href: '/sales/proposals' },
                    { name: 'Change Orders', href: '/sales/change-orders' },
                    { name: 'Catalogs', href: '/sales/catalogs' },
                    { name: 'Map', href: '/sales/map' }] 
                },
            { name: 'Inbox', href: '/inbox', width: 920, sub_menus: [] },
            { name: 'Calendar', href: '/calendar', width: 1050, sub_menus: [] },
            { name: 'Productions', href: '/production', width: 1140, 
                sub_menus: [
                    // { name: 'Material Take Off', href: '/production/material-take-off'},
                    // { name: 'Material Orders', href: '/production/material-orders'},
                    // { name: 'Production Calendar', href: '/production/production-calendar'},
                    // { name: 'Plans and Permits', href: '/production/plans-and-permits'},
                    // { name: 'Crew Management', href: '/production/crew-management'},

                    { name: 'Overview', href: '/production'},
                    { name: 'Preliminaries', href: '/production/preliminaries'},
                    { name: 'Material TakeOff', href: '/production/material-take-off'},
                    { name: 'Work Orders', href: '/production/work-orders'},
                    { name: 'Work Schedule', href: '/production/work-schedule'},
                 ] 
                },
            { name: 'Files', href: '/files', width: 1240,
                sub_menus: [
                    { name: 'Documents', href: '/files/documents'},
                    { name: 'Photos', href: '/files/photos'},
                    { name: 'Videos', href: '/files/videos'}, ] 
                },
            { name: 'Financials', href: '/financials', width: 1340,
                sub_menus: [
                    { name: 'Overview', href: '/financials'},
                    { name: 'Expense Tracking', href: '/financials/expense-tracking'},
                    { name: 'Accounts Receivable', href: '/financials/accounts-receivable'},
                    { name: 'Accounts Payable', href: '/financials/accounts-payable'},
                    { name: 'Budget', href: '/financials/budget'},
                    { name: 'Stage Payments', href: '/financials/stage-payments'},
                    { name: 'Payments Report', href: '/financials/payments-report'},] 
                }
        ];
        const active_menu = menus[1];
        const active_menu_name = menus[1].name;
        const active_sub_menu = menus[1].sub_menus[0];
        const showProfileDropDown = false;
        const showEasyCreateDropDown = false;
        const showMessagesDropDown = false;
        const showMPeoplesDropDown = false;
        const showHiddenMenuDropDown = false;
        const headerWidth = 0;

        return {
            menus,
            active_menu,
            active_sub_menu,
            showProfileDropDown,
            showEasyCreateDropDown,
            showMessagesDropDown,
            showMPeoplesDropDown,
            showHiddenMenuDropDown,
            headerWidth,
            active_menu_name
        }
    },
    mounted(){
        this.setActiveMenu();

        document.querySelectorAll('.top-icons a').forEach(anchor => {
            anchor.addEventListener('mouseenter', function() {
                let nearestIcon = anchor.querySelector('i');
                if (nearestIcon) {
                    nearestIcon.classList.add('f-18');
                }
            });

            anchor.addEventListener('mouseleave', function() {
                let nearestIcon = anchor.querySelector('i');
                if (nearestIcon) {
                    nearestIcon.classList.remove('f-18');
                }
            });
        });

        this.$nextTick(() => {
            const observer = new ResizeObserver((entries) => {
                for (const entry of entries) {
                    this.headerWidth = entry.contentRect.width;
                    this.setActiveMenu();
                }
            });
            
            if (this.$refs.headerContainer) {
                observer.observe(this.$refs.headerContainer);
            }

            this.resizeObserver = observer;
        });

    },
    beforeUnmount() {
        if (this.resizeObserver) {
            this.resizeObserver.disconnect();
        }
    },
    methods: {
        setActiveMenu(){
            this.active_menu = this.menus.find(menu => {
                return this.page.url.includes(menu.href);
            });
            if(this.active_menu){
                this.active_menu_name = this.active_menu.name;

                if(this.active_menu.sub_menus){
                    this.active_menu.sub_menus.forEach(sub_menu => {
                        if(sub_menu.href === this.page.url){
                            this.active_sub_menu = sub_menu;
                        }
                    });
                }

                if(!this.active_sub_menu && this.active_menu.sub_menus.length != 0){
                    this.active_sub_menu = this.active_menu.sub_menus[0];
                }

                this.store.setSelectedMenu(this.active_menu);
                this.setPageBody(this.active_menu.sub_menus.length != 0);
            }else{
                this.active_menu = null;
                this.active_sub_menu = null;
                this.store.setSelectedMenu(null);
                this.setPageBody(false);
            }
        },
        getSizeOfHeader(){
            this.$nextTick(() => {
                const header = this.$refs.headerContainer;
                if (header) {
                    let width = header.offsetWidth;
                    console.log(width);
                }
            });
        },
        toggleHiddenMenuDropdown(status){
            this.showHiddenMenuDropDown = status;
        },
        togglePeoplesDropdown(status){
            this.showMPeoplesDropDown = status;
        },
        toggleMessagesDropdown(status){
            this.showMessagesDropDown = status;
        },
        toggleEasyCreateDropdown(status){
            this.showEasyCreateDropDown = status;
        },
        toggleProfileDropdown(status){
            this.showProfileDropDown = status;
        },
        handleMenuClick(menu){
            this.sidebarStore.setDisabled(false);
            this.active_menu = menu;
            this.active_menu_name = menu.name;
            this.active_sub_menu = menu.sub_menus.length != 0 ? menu.sub_menus[0] : '';
            this.store.setSelectedMenu(menu);
            this.setPageBody(menu.sub_menus.length != 0);
        },
        handleSubMenuClick(sub_menu){
            this.sidebarStore.setDisabled(false);
            this.active_sub_menu = sub_menu;
        },
        setPageBody(hasMenus){
            const headerHeight = hasMenus ? '98px' : '49px';
            const marginLeft = this.sidebarStore.isOpen ? '320px' : '21px';
            this.page.props.style.page_body = `margin-top: ${headerHeight} !important; min-height: calc(100vh - ${headerHeight}) !important; max-height: calc(100vh - ${headerHeight}) !important; margin-left: ${marginLeft};`;
        }
    },
    computed: {
        url() {
            return this.page.url;
        }
    },
    watch: {
        url: {
            handler(to, _) {
                const active_menu = this.menus.find(menu => {
                    return to.includes(menu.href);
                });
                if(active_menu){
                    this.active_menu_name = active_menu.name;
                    this.active_sub_menu = active_menu.sub_menus.find(sub_menu => {
                        return this.page.url.includes(sub_menu.name);
                    });
                    this.setPageBody(active_menu.sub_menus.length != 0);
                }else{
                    this.active_menu = null;
                    this.active_sub_menu = null;
                    this.store.setSelectedMenu(null);
                    this.setPageBody(false);
                }
            }
        }
    }
}

</script>