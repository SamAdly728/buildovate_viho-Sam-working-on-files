<template>
    <Transition name="slide-fade">
        <div class="bg-white easycreate-dropdown shadow-lg d-flex flex-column">
            <a class="text-muted f-w-600 f-12 px-3 py-2">Compose message:</a>
            <a class="text-dark f-14 f-w-600 px-3 py-2 d-flex gap-3 bg-hover-danger-danger align-items-center" style="cursor: pointer;" @click="handleEmailClick">
                <i class="f-20 f-w-700 icon-email"></i>
                <div class="d-flex flex-column">
                    <a>Email</a>
                    <a class="text-muted f-12">Compose email.</a>
                </div>
            </a>
            <a class="text-dark f-14 f-w-600 px-3 py-2 d-flex gap-3 bg-hover-success-success align-items-center" style="cursor: pointer;" @click="handleMessageClick">
                <i class="f-20 f-w-700 icon-comment"></i>
                <div class="d-flex flex-column">
                    <a>Message</a>
                    <a class="text-muted f-12">Compose message.</a>
                </div>
            </a>
            <a class="text-dark f-14 f-w-600 px-3 py-2 d-flex gap-3 bg-hover-primary-primary align-items-center" style="cursor: pointer;" @click="handleFeedbackClick">
                <i class="f-20 f-w-700 icon-comments-smiley"></i>
                <div class="d-flex flex-column">
                    <a>Feedbacks</a>
                    <a class="text-muted f-12">Read feedbacks.</a>
                </div>
            </a>
        </div>
    </Transition>
</template>
<script>
import Swal from 'sweetalert2';

export default{
    methods: {
        handleEmailClick(){
            Swal.fire({
                icon: 'info',
                title: 'Coming soon!',
                text: 'Compose email through here coming very soon ;)',
            });
        },
        handleMessageClick(){
            Swal.fire({
                icon: 'info',
                title: 'Coming soon!',
                text: 'Compose message through here coming very soon ;)',
            });
        },
        handleFeedbackClick(){
            Swal.fire({
                icon: 'info',
                title: 'Coming soon!',
                text: 'Read and reply to feedbacks through here coming very soon ;)',
            });
        }
    }
}
</script>