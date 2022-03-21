require('./bootstrap');
window.Vue = require('vue').default;
import router from './routes';
import store from './Store/index';
import Vuetify from '../plugins/vuetify';

store.dispatch("getUser");

Vue.component('front', require('./components/Front.vue').default);

const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
    store,
    router
});