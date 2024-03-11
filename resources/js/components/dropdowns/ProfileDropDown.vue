<template>
    <Transition name="slide-fade">
        <div class="bg-white profile-dropdown shadow-lg d-flex flex-column">
            <div  style="max-height: calc(100vh - 110px); overflow: auto;" class="slim-scroll-light">
                <template v-for="menu in profileMenu">
                    <Link :href="menu.href" v-if="menu.name != 'Quickstart' && menu.name != 'Logout'">
                        <a class="text-dark f-14 f-w-600 px-3 py-3 d-flex gap-3 bg-hover-primary-primary" style="cursor: pointer;">
                            <i class="f-20 f-w-700" :class="[menu.icon]"></i>
                            <a>{{ menu.name }}</a>
                        </a>
                    </Link>
                    <a v-else-if="menu.name === 'Quickstart'" 
                        class="text-dark f-14 f-w-600 px-3 py-3 d-flex gap-3 bg-hover-primary-primary" style="cursor: pointer;" 
                        @click="handleQuickStartClick">
                        <i class="f-20 f-w-700" :class="[menu.icon]"></i>
                        <a>{{ menu.name }}</a>
                    </a>
                    <a v-else-if="menu.name === 'Logout'" 
                        class="text-dark f-14 f-w-600 px-3 py-3 d-flex gap-3 bg-hover-danger-danger" style="cursor: pointer;" 
                        @click="handleLogoutClick">
                        <i class="f-20 f-w-700" :class="[menu.icon]"></i>
                        <a>{{ menu.name }}</a>
                    </a>
                </template>
                <hr>
                
                <a class="text-dark f-14 f-w-600 px-3 py-3 d-flex gap-3 bg-hover-primary-primary" style="cursor: pointer;">
                    <i class="f-20 f-w-700 icon-direction-alt"></i>
                    <a>Login to Pros Account</a>
                </a>
                <hr>

                <div class="px-3 pb-3 d-flex flex-column gap-2">
                    <a class="f-16 text-primary f-w-600">Looking for Assistance? We've Got You Covered!</a>
                    <p class="f-12 text-muted f-w-500 p-0 m-0">Got a question or need help? Our expert team is ready to offer quick, personalized support. Reach out and experience the difference!</p>
                    <div class="d-flex flex-column m-0 p-0 gap-2">
                        <a class="text-dark f-12 f-w-600">Email: <span class="f-w-700 pl-2">email.support@buildovate.com</span></a>
                        <a class="text-dark f-12 f-w-600">Call/Message: <span class="f-w-700 pl-2">+1 (855) 504-8209</span></a>
                        <a class="text-dark f-12 f-w-600">Chat Support: <a class="btn-primary-v2 m-0 px-2 py-1" style="cursor: pointer; border-radius: 4px;" @click="handleChatSupportClick">Start Chat</a></a>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>
<script>
import Swal from 'sweetalert2';
import { Link } from "@inertiajs/vue3";

export default{
    components: {
        Link
    },
    data(){
        const profileMenu = [
            { name: 'Quickstart', icon: "icon-light-bulb" },
            { name: 'Admin', icon: "icon-lock", href: '/admin/index' },
            { name: 'Road Map', icon: "icon-map", href: '/user/roadmap' },
            { name: 'Live Chat', icon: "icon-comments", href: '/user/live-chat' },
            { name: 'Profile', icon: "icon-user", href: '/user/profile' },
            { name: 'Knowledgebase', icon: "icon-info-alt", href: '/user/knowledgebase' },
            { name: 'Logout', icon: "icon-back-left" },
        ]

        return { profileMenu }
    },
    methods: {
        handleChatSupportClick(){
            Swal.fire({
                icon: 'info',
                title: 'Coming soon!',
                text: 'Chat support is coming very soon ;)',
            });
        },
        handleQuickStartClick(){
            Swal.fire({
                icon: 'info',
                title: 'Coming soon!',
                text: 'Quick Start is coming very soon ;)',
            });
        },
        handleLogoutClick(){
            Swal.fire({
                icon: 'warning',
                title: `Proceed to Logout?`,
                text: `You can comeback anytime ;)`,
                showCancelButton: true,        // Show cancel button
                confirmButtonText: 'Logout',  // Text on the confirm button
                cancelButtonText: 'Cancel',   // Text on the cancel button
                confirmButtonColor: '#d33',   // Color of the confirm button
                cancelButtonColor: '#3085d6', // Color of the cancel button
                reverseButtons: true,         // Swap button positions
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.clear()
                    window.location.href = '/auth/logout';
                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Logging you out.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

                }
            });
        }
    }
}

</script>