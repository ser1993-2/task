require('./bootstrap');


import Vue from 'vue'
import VueRouter from 'vue-router'
import VueAxios from 'vue-axios'

import Task from './components/user/Tasks'

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

const router = new VueRouter({
    mode: 'hash',
    base: '/home/',
    routes: [
        { path: '/', redirect: '/task/'},

        { path: '/task/', component: Task},

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




