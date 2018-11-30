import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        users: [],
        tasks: [],
        processes: [],
        modal_active: false,
        sid: '',
    },
    mutations: {

        setUsers(state, payload) {
            state.users = payload
        },

        setTasks(state, payload) {
            state.tasks = payload
        },

        setProcesses(state, payload) {
            state.processes = payload
        },

        addTask(state, payload) {
            state.tasks.unshift(payload)
        },

        switchModal(state, payload) {
            state.modal_active = !state.modal_active
        },

        setSid (state, payload) {
            state.sid = payload;
        }

    },
})

export default store