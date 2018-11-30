import Vue from 'vue'
import VueRouter from 'vue-router'
import SignIn from './components/SignIn'
import PanelMain from "./components/panel/PanelMain";

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'sign_in',
            component: SignIn
        },
        {
            path: '/panel',
            name: 'panel_main',
            component: PanelMain
        },
    ],
});