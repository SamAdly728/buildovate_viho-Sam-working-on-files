<template>
    <div class="email-right-aside inter-font">
        <div class="card email-body radius-left no-border">
            <div v-if="showTitle" class="card-header py-3 pt-0 pb-0">
                <h5>Other Actions</h5>
            </div>
            <hr v-if="showTitle">
            <div class="card-body email-app-sidebar p-0 px-4 pe-0 pb-0">
                <ul class="icon-lists border navs-icon default-according style-1 p-0 inter-font" 
                    v-for="accordion in rightAccordions" 
                    :key="accordion" 
                    :style="{ border: '0px !important' }">
                        <li>
                            <div class="d-flex flex-column">
                                <button class="btn btn-link text-muted py-2" @click="toggleAccordion(accordion.title)">
                                    <i :class="accordion.icon" :style="{ width: '30px' }"></i><span> {{ accordion.title }}</span>
                                    <span>

                                    <i :class="getChevronClass(accordion.title)" :style="{ float: 'right', width: '20px' }"></i>
                                    <span class="btn btn-primary-v2 btn-sm m-0 p-0 px-2  py-1" :style="{ float: 'right' }" @click.stop="handleCreateClick(accordion.title)">
                                            CREATE</span>
                                    </span>
                                </button>
                                <transition name="fade">
                                    <div v-if="isOpen[accordion.title]" 
                                            class="m-0 p-0" 
                                            style="
                                            width: 1000px;
                                            max-width: 100% !important; 
                                            height: auto;
                                            overflow: hidden;
                                        "
                                        v-html="accordion.content">
                                    </div>
                                    </transition>
                                </div>
                        </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { reactive } from 'vue';
    defineProps(['showTitle']);

   let rightAccordions = [
        {title: 'Tasks', icon: 'fa fa-tasks m-0', content: getComingSoonContent()},
        {title: 'Calendar', icon: 'fa fa-calendar m-0', content: getComingSoonContent()},
        {title: 'Proposals', icon: 'fa fa-trophy m-0', content: getComingSoonContent()},
        {title: 'Invoices', icon: 'fa fa-money m-0', content: getComingSoonContent()},
        {title: 'Stage Payments', icon: 'fa fa-money m-0', content: getComingSoonContent()},
        {title: 'Automations', icon: 'fa fa-bolt m-0', content: getComingSoonContent()},
        {title: 'Files', icon: 'fa fa-file m-0', content: getComingSoonContent()}
    ];

    const isOpen = reactive({
        'Tasks': false,
        'Calendar': false,
        'Proposals': false,
        'Invoices': false,
        'Automations': false,
        'Files': false,
        'Stage Payments': false
    });

    function toggleAccordion(accordionName){
        isOpen[accordionName] = !isOpen[accordionName];
    }

    function getChevronClass(accordionName) {
        return isOpen[accordionName] ? 'fa fa-caret-down' : 'fa fa-caret-right';
    }

    function getComingSoonContent(){
        return `Coming soon.`
    }

</script>