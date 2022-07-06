require('./bootstrap');

import App from './layouts/App.vue'
import VueRouter from 'vue-router'
import { routes } from './routes'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueEllipseProgress from 'vue-ellipse-progress';
import Toast, { POSITION } from "vue-toastification";
import "vue-toastification/dist/index.css";
import '/css/theme-colors.css';
window.Vue = require('vue').default;
Vue.use(VueRouter);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueEllipseProgress);
Vue.use(Toast, {
    position: POSITION.BOTTOM_RIGHT,

});
let router = new VueRouter({
    mode: 'history',
    routes
})
const app = new Vue({
    el: '#application',
    components: { App },
    router
});