
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('register-component', require('./components/RegisterComponent.vue'));
Vue.component('login-component', require('./components/LoginComponent.vue'));
Vue.component('home-conponent', require('./components/HomeComponent.vue'));

const router = new VueRouter({
    routes: [
        {path: '', name: 'home', component: require('./components/HomeComponent')},
        {path: '/register', name: 'register', component: require('./components/RegisterComponent')},
        {path: '/login', name: 'login', component: require('./components/LoginComponent')},
    ]
});

const app = new Vue({
    el: '#app',
    router,
});
