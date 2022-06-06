/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('sidebar', require('./components/Sidebar.vue').default);
Vue.component('profile', require('./components/Profile.vue').default);
Vue.component('accounts', require('./components/TwitterAccounts.vue').default);
Vue.component('home', require('./components/Home.vue').default);

Vue.component('news', require('./components/News.vue').default);
Vue.component('coin', require('./components/Coin.vue').default);
Vue.component('twitter', require('./components/TwitterComponent.vue').default);
Vue.component('nologin', require('./components/NologinComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const sidebar = new Vue({
    el: '#js-sidebar'
});



const home = new Vue({
    el: '#js-home'
});

const profile = new Vue({
    el: '#js-profile'
});

const accounts = new Vue({
    el: '#js-accounts'
});

const news = new Vue({
    el: '#js-news'
});

const coin = new Vue({
    el: '#js-coin'
});

const twitter = new Vue({
    el: '#js-twitter'
});

const nologin = new Vue({
    el: '#js-nologin'
});

//aaaazaaa
