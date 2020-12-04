import Vue from 'vue';
import VueRouter from 'vue-router';

import Welcome from './views/welcome-vue';
import Hellowvue from './views/hellow-vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/hello",
            component: Hellowvue
        },
        {
            path: "/Welcome",
            component: Welcome
        }
    ]
});

export default router;