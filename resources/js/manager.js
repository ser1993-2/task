require('./bootstrap');

import VueMomentLib from 'vue-moment-lib';
import Vue from 'vue'
import VueRouter from 'vue-router'
import VueAxios from 'vue-axios'

import Tasks from './components/manager/Tasks'
import Task from './components/manager/Task'

Vue.use(VueMomentLib);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);

const router = new VueRouter({
    mode: 'hash',
    base: '/manager/',
    routes: [
        { path: '/', redirect: '/task/'},

        { path: '/task/', component: Tasks},
        { path: '/task/:id', component: Task},

    ]
});

window.Vue = new Vue(Vue.util.extend({
    router,
    components: {
    },
    template: `<div>
        <router-view></router-view>
    </div>`,

})).$mount('#app');




