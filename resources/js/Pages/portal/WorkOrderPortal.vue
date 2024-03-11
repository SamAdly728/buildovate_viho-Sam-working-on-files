<template>
    <div class="d-flex bg-main" style="width: 100vw; height: 100vh;">
        <div class="flex-grow-1 d-flex justify-content-center">
            <div class="shadow flex-grow-1 bg-white" style="max-width: 1000px; margin-top: 25px; margin-bottom: auto;">
                <DefaultTemplate :type="'pros'"/>
            </div>
        </div>
    </div>
</template>
  
<script>
import DefaultTemplate from '@/components/proposal/DefaultTemplate.vue'

export default {
    props: ['token'],
    components: { DefaultTemplate },
    data(){
        const proposal_id = 0;
        const type = '';

        return { proposal_id, type }
    },
    mounted(){
        if(this.token){
            const decrypted = this.$crypto.decryptData(this.token);

            console.log(decrypted, 'decrypted', this.token);
            if(decrypted){
                const split = decrypted.split('-');

                this.proposal_id = split[1];
                this.type = split[0];
            }
        }
    }
}
</script>
  