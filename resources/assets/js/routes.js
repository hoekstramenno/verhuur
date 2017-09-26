import VueRouter from 'vue-router';

let routes = [
    {
        path: '/',
        component: require('./pages/DateList.vue')
    },
    {
        path: '/date/:id',
        component: require('./pages/Date.vue')
    }
]

export default new VueRouter({
   routes
});