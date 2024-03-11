<template>

    <div style="height: 100%; width: 100%; z-index: 500;" class="d-flex justify-content-center pt-3">
        
        <div class="d-flex b-primary-v2" style="height: 73px;">
            <template v-for="(header, index) in headers" :key="header.name">
                <div class="d-flex flex-column"
                    :style="{
                        'min-width': header.min ? header.min : 'auto',
                        'height': '38px'
                    }" >
                    
                    <div class='f-w-500 px-3 py-2 d-flex align-items-center f-14 table_header'>
                        {{ header.name }} 
                    </div>
                    <a v-if="header.name == 'Action'" class='f-w-500 px-3 py-2 text-muted f-12 position-relative bg-white'>
                        <div class='d-flex gap-1'>
                            <a class='badge badge-primary bg-primary-v2 bigger' style='cursor: pointer;'><i class="icon-pencil-alt"></i></a>
                            <a class='badge badge-warning bigger' style='cursor: pointer;' @click="handleClickedAppointment(header,index)"><i class="icon-alarm-clock"></i></a>
                            <a class='badge badge-success bigger' style='cursor: pointer;'><i class="icon-comments"></i></a>
                            <a class='badge badge-danger bigger' style='cursor: pointer;'><i class="icon-headphone-alt"></i></a>
                        </div>
                    </a>
                    <a v-else class='f-w-500 px-3 py-2 text-muted f-12 position-relative bg-white' v-html="setCellContent(header.name)">
                    </a>
                </div>
            </template>
        </div>
    </div>

</template>
<script>

export default {
    props: {
        data: {
            typeof: Object,
            default: null
        },
        row: {
            typeof: Object,
            default: null
        }
    },
    data(){
        const headers = [
            { name: "MORE DETAILS", min: '150px', max: '150px'},
            { name: "Action", min: '150px', max: '150px'},
            { name: "Last Appt.", min: '250px', max: '250px'},
            { name: "Notes", min: '200px'},
            { name: "Tags", min: '150px', max: '250px'},
            { name: "Lead Source", min: '150px', max: '250px'},
            { name: "Job Type", min: '150px', max: '250px'},
            { name: "Postcard", min: '150px', max: '150px'},
            { name: "Magazine", min: '150px', max: '150px'},
        ];
        return { headers }
    },
    methods: {
        setCellContent(headerName){
            if(headerName === 'MORE DETAILS'){
                const lead_id = this.data.lead_id;
                return `<a class="btn-primary-v2 px-2 py-1" style="cursor: pointer; border-radius: 5px;" href='lead-management/view-lead/${lead_id}'>View More</a>`;
            }

            if (headerName === 'Action'){
                const proposal = `<a class='badge badge-primary bg-primary-v2 bigger' style='cursor: pointer;'><i class="icon-pencil-alt"></i></a>`;
                const appointment = `<a class='badge badge-warning bigger' style='cursor: pointer;' @click="showModal = true"><i class="icon-alarm-clock"></i></a>`;
                const email = `<a class='badge badge-success bigger' style='cursor: pointer;'><i class="icon-comments"></i></i></a>`;
                const call = `<a class='badge badge-danger bigger' style='cursor: pointer;'><i class="icon-headphone-alt"></i></a>`;

                return `<div class='d-flex gap-1'>${proposal}${appointment}${email}${call}</div>`
            }

            if(headerName === 'Tags'){
                const list = this.data.tags;
                return this.getMultipleString(list, headerName);
            }

            if(headerName === 'Job Type'){
                const list = this.data.job_types;
                return this.getMultipleString(list, headerName);
            }

            if(headerName === 'Lead Source'){
                const list = this.data.sources;
                return this.getMultipleString(list, headerName);
            }

            return '-';
        },
        getMultipleString(lists, type){
            let listItems = `-`;
            if(lists && lists.length !== 0){
                listItems = lists.map(data => {
                    let name = '-';
                    if(type === 'Job Type'){
                        name = data.job_type.job_type_name;
                    }else if(type === 'Tags'){
                        name = data.tag.tags_name;
                    }else if(type === 'Lead Source'){
                        name = data.source.source_name;
                    }
                    return `<small>${name}</small>`;
                }).join(', ');
            }
            return `<a class="truncate">${listItems}</a>`;
        },
        handleClickedAppointment(head, index){
            this.$emit('appointmentClick', { data:this.data });
        },
    }
}

</script>