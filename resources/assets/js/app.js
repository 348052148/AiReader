
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'

import VueRouter from 'vue-router'

Vue.use(VueRouter)

/**
 * Router Paths
 */

import books from './components/BookList.vue'
import classifys from './components/Classifys.vue'
import chapters from './components/ChapterList.vue'

const routes = [
    { path: '/', component: books },
    { path: '/books', component: books },
    { path: '/classify', component: classifys },
    { path: '/chapters', component: chapters }
];

const router = new VueRouter({
    routes // (缩写) 相当于 routes: routes
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('admin', require('./components/Admin.vue'));

const app = new Vue({
    el: '#app',
    router
});
