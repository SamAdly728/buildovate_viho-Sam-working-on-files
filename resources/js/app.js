import axios from "axios";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { createPinia } from "pinia";
import Layout from "@/components/Layout.vue";
import GuestLayout from "@/components/GuestLayout.vue";
import VueTheMask from "vue-the-mask";
import VueApexCharts from "vue3-apexcharts";
import VueEasyLightbox from "vue-easy-lightbox";
import "../css/app.css";
import EncryptionPlugin from './encryptionPlugin';

import Vue3EasyDataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";

// const vuetify = createVuetify({
//   icons: {
//     iconfont: 'mdi',
//   },
// });

// Set Axios headers here
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
  console.error("CSRF token not found");
}

const userToken = localStorage.getItem("user-token");
if (userToken) {
  axios.defaults.headers.common["Authorization"] = `Bearer ${userToken}`;
}

const pinia = createPinia();

createInertiaApp({
  resolve: (name) => {
    const currentURL = window.location.pathname;
    const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
    const page = pages[`./Pages/${name}.vue`];
    page.default.layout = page.default.layout ?? Layout;
    if (currentURL.startsWith('/guest') || currentURL.startsWith('/portal')) {
      page.default.layout = GuestLayout;
    }
    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .component("EasyDataTable", Vue3EasyDataTable)
      .use(EncryptionPlugin, { secretKey: 'buildovate2024' })
      .use(plugin)
      .use(VueTheMask)
      .use(VueApexCharts)
      .use(VueEasyLightbox)
      .use(pinia)
      .mount(el);
  },
});

// window.Vue = require('vue').default;
// Vue.component('chat-component', require('./components/ChatComponent.vue').default);
// Vue.component('message-component', require('./components/MessageComponent.vue').default);
// const app = new Vue({
//   el: '#app',
//   created() {

//   }
// });

// window._ = require('lodash');

// try {
//     require('bootstrap');
// } catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

// window.axios = require('axios');

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
// import Echo from '@ably/laravel-echo';

// window.Ably = require('ably');

// Create echo client instance around ably-js.
// window.Echo = new Echo({
//     broadcaster: 'ably',
// });

// // Register a callback for listing to connection state change
// window.Echo.connector.ably.connection.on((stateChange) => {
//     console.log("LOGGER:: Connection event :: ", stateChange);
//     if (stateChange.current === 'disconnected' && stateChange.reason?.code === 40142) { // key/token status expired
//         console.log("LOGGER:: Connection token expired https://help.ably.io/error/40142");
//     }
// });
