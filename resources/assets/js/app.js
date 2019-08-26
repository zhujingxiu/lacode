
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueRouter from 'vue-router'
import VeeValidate, { Validator } from 'vee-validate'
import zh from 'vee-validate/dist/locale/zh_TW.js';
import App from './member/base/VApp.vue'

window.Vue = require('vue');
Vue.use(VueRouter);

Validator.localize(zh);
Vue.use(VeeValidate,{
    locale: 'zh_TW',
    classes: true,
    classNames: {
        valid: 'isValid',
        invalid: 'isInvalid'
    }
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding base to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// 路由配置


const router = new VueRouter({
    // mode: 'history',
    routes: [
        { path: '/group/:groupId', name:'group', component: require('./member/group/Index.vue') },
        { path: '/reset', component: require('./member/Reset.vue') },
        { path: '/rule', component: require('./member/Rule.vue') },
    ]
});

Vue.component('VHeader', require('./member/base/VHeader.vue'));
Vue.component('VSidebar', require('./member/base/VSidebar.vue'));

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App)
});
