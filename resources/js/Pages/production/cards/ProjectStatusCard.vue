<template>
        <div class="project-box flex-item m-0 shadow-sm shadow-showcase shadow-hover" style="width: 450px;">
            <div class="d-flex position-absolute top-0 right-0">
                <span class="badge badge-danger position-relative"><i class="fa fa-bullhorn"></i></span>
                <span class="badge badge-primary position-relative">In-progress</span>
            </div>
            <a class="d-flex cursor-pointer" @click="handleClick('-')">
                <div class="img-50"><img class="rounded-circle" src="../../../../assets/test-images/user/2.jpg" alt=""></div>
                <div class="ml-3 flex-grow-1">
                    <h6>{{ props.projectDetails.crew.text }}</h6>
                    <div class="media-body">
                        <p>{{ props.projectDetails.crew.email }}</p>
                    </div>
                </div>
            </a>
            <hr>
            <div class="row details gap-2">
                <div class="col-12 mb-2"><span class="f-w-600">PROJECT ASSIGNMENT STATUS</span></div>
                <a class="col-12 row cursor-pointer" @click="handleClick('not yet invited')">
                    <div class="col-7"> <span>Stand By</span></div>
                    <div class="col-5 font-primary d-flex">
                        {{ statusCounter(props.projectDetails.worksheets, 'not yet invited') }} 
                        <i class="ml-1 fa fa-asterisk text-danger" style="font-size: 0.5rem;" v-if="statusCounter(props.projectDetails.worksheets, 'not yet invited') != '-' "></i>
                    </div>
                </a>
                <a class="col-12 row cursor-pointer" @click="handleClick('invited')">
                    <div class="col-7"> <span>Waiting Confirmation</span></div>
                    <div class="col-5 font-primary d-flex">
                        {{ statusCounter(props.projectDetails.worksheets, 'invited') }}
                        <i class="ml-1 fa fa-asterisk text-danger" style="font-size: 0.5rem;" v-if="statusCounter(props.projectDetails.worksheets, 'invited') != '-' "></i>
                    </div>
                </a>
                <a class="col-12 row cursor-pointer" @click="handleClick('accepted')">
                    <div class="col-7"> <span>Project Accepted</span></div>
                    <div class="col-5 font-primary d-flex">
                        {{ statusCounter(props.projectDetails.worksheets, 'accepted') }}
                        <i class="ml-1 fa fa-asterisk text-danger" style="font-size: 0.5rem;" v-if="statusCounter(props.projectDetails.worksheets, 'accepted') != '-' "></i>
                    </div>
                </a>
                <a class="col-12 row cursor-pointer" @click="handleClick('declined')">
                    <div class="col-7"> <span>Project Declined</span></div>
                    <div class="col-5 font-primary d-flex">
                        {{ statusCounter(props.projectDetails.worksheets, 'declined') }}
                        <i class="ml-1 fa fa-asterisk text-danger" style="font-size: 0.5rem;" v-if="statusCounter(props.projectDetails.worksheets, 'declined') != '-' "></i>
                    </div>
                </a>
            </div>
            <hr>
            <div class="row details gap-2">
                <div class="col-12 mb-2"><span class="f-w-600">SCOPE OF WORK</span></div>
                <a class="col-12 row cursor-pointer" @click="handleClick('approved')">
                    <div class="col-7"> <span>In-progress</span></div>
                    <div class="col-5 font-primary">{{ statusCounter(props.projectDetails.worksheets, 'approved') }}</div>
                </a>
                <a class="col-12 row cursor-pointer" @click="handleClick('completed')">
                    <div class="col-7"> <span>Completed</span></div>
                    <div class="col-5 font-primary">{{ statusCounter(props.projectDetails.worksheets, 'completed') }}</div>
                </a>
            </div>
            <div class="project-status mt-4">
                <div class="media mb-0">
                    <p>{{ calculatePercentage(props.projectDetails.worksheets)  }}%</p>
                    <div class="media-body text-end"><span>Done</span></div>
                </div>
                <div class="progress" style="height: 5px">
                    <div class="progress-bar-animated bg-primary progress-bar-striped" 
                    role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" 
                    :style="{ width: calculatePercentage(props.projectDetails.worksheets) + '%'}"></div>
                </div>
            </div>
        </div>
</template>
<script setup>
    const props = defineProps({
        projectDetails: { 
            type: Object,
            default: () => null
        }
    });
    const emit = defineEmits(['click'])

    const statusCounter = (worksheets, type) => {
        if(worksheets && worksheets.length != 0){
            const count = worksheets.filter((item) => item.status === type).length;
            if(count !== 0){
                return count;
            }else{
                return '-';
            }
        }else{
            return '-';
        }
    };

    const calculatePercentage = (worksheets) => {
        if(worksheets && worksheets.length != 0){
            const inProgress =  worksheets.filter((item) => item.status === 'approved').length;
            const completed =  worksheets.filter((item) => item.status === 'completed').length;
            if(inProgress !== 0 && completed !== 0){
                const totalProject = inProgress + completed;
                return ((completed/totalProject) * 100).toFixed(2);
            }else{
                return 0;
            }
        }

        return 0;
    }

    function handleClick(type) {
        emit('click', {
            type: type,
            project: props.projectDetails
        })
    }
</script>
<style scoped>
.shadow-hover:hover{
    box-shadow: 0 0.125rem 0.25rem rgba(0, 63, 14, 0.514) !important;
}
</style>