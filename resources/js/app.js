import Vue from 'vue'
import Snotify from 'vue-snotify'
import VueResource from 'vue-resource'
import VueCookie from 'vue-cookie'

import Icon from 'vue-awesome/components/Icon'
import GanttElastic from "gantt-elastic/src/GanttElastic.vue"

import App from './components/App'
import router from './router'
import store from './store'

Vue.use(Snotify)
Vue.use(VueResource)
Vue.use(VueCookie)

Vue.component('icon', Icon)
Vue.component('ganttElastic', GanttElastic)

const app = new Vue({
    el: '#app',
    store,
    template: "<App/>",
    components: {App},
    router,
});