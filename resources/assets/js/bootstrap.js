import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios'

window.Vue = Vue;
Vue.use(VueRouter);

window.axios = axios
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest'
}

window.events = new Vue();

window.flash = function (message) {
    window.events.$emit('flash', message);
};