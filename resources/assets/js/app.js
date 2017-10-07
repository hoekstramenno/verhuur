import './bootstrap';

//import router from './routes';

//import VueRouter from 'vue-router'
//import DatesList from './components/frontend/Datelist'
//import App from './components/App'


// Vue.component(
//     'passport-clients',
//     require('./components/passport/Clients.vue')
// );
//
// Vue.component(
//     'passport-authorized-clients',
//     require('./components/passport/AuthorizedClients.vue')
// );
//
// Vue.component(
//     'passport-personal-access-tokens',
//     require('./components/passport/PersonalAccessTokens.vue')
// );

// Vue.component(
//     'list-of-available-dates',
//     require('./components/frontend/Datelist.vue')
// );



//define your routes

Vue.component('materiallist', require('./components/Materials.vue'));
Vue.component('flash', require('./components/Flash.vue'));

const app = new Vue({
   el: '#app'
    //router
});
