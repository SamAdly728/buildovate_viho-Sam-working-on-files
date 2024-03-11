import { ref } from 'vue';

export const show_filter = ref(false);

//LEFT SIDE BAR
export let jobsite_list = ref(null);
export const selected_jobsite = ref(null);
export let reload_jobsite_list = ref(false);

//PLAID 
export let new_transactions_added = ref(false);