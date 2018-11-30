<template>
    <div id="panel_main">
        <panel_preloader v-if="!contentLoaded">
        </panel_preloader>
        <panel_modal
            v-if="$store.state.modal_active"
            :modal_name="modal_name">
        </panel_modal>
        <div class="menu">
            <div class="brand">
                <span class="brand-text">LOGO</span>
            </div>
            <div class="menu__item"
                 :class="{'menu__item--active': selected_module === 'panel_calendar'}"
                 @click="selected_module = 'panel_calendar'">
                <icon name="calendar-alt" scale="1" class="menu__item-icon"></icon>
                <span class="menu__item-text">{{modules_headers_headlines['panel_calendar']}}</span>
            </div>
            <div class="menu__item"
                 :class="{'menu__item--active': selected_module === 'panel_tasks'}"
                 @click="selected_module = 'panel_tasks'">
                <icon name="tasks" scale="1" class="menu__item-icon"></icon>
                <span class="menu__item-text">{{modules_headers_headlines['panel_tasks']}}</span>
            </div>
            <div class="menu__item"
                 :class="{'menu__item--active': selected_module === 'panel_processes'}"
                 @click="selected_module = 'panel_processes'">
                <icon name="clock" scale="1" class="menu__item-icon"></icon>
                <span class="menu__item-text">{{modules_headers_headlines['panel_processes']}}</span>
            </div>
            <div class="menu__item"
                @click="logout()">
                <icon name="sign-out-alt" scale="1" class="menu__item-icon"></icon>
                <span class="menu__item-text">выйти</span>
            </div>
        </div>
        <div class="container">
            <div class="header">
                <div class="header-page_name">
                    <span class="page_name-text">{{modules_headers_headlines[selected_module]}}</span>
                </div>
                <div class="header-actions" v-if="selected_module === 'panel_tasks'">
                    <button @click="showModal(selected_module + '_add')" class="actions__button">Новая задача</button>
                </div>
            </div>
            <component :is="selected_module"></component>
        </div>
    </div>
</template>

<script>
    import 'vue-awesome/icons/clock'
    import 'vue-awesome/icons/tasks'
    import 'vue-awesome/icons/calendar-alt'
    import 'vue-awesome/icons/sign-out-alt'
    import axios from 'axios'
    import PanelModal from './PanelModal'
    import PanelPreloader from '../Preloader'
    import PanelCalendar from './modules/PanelCalendar'
    import PanelProcesses from './modules/PanelProcesses'
    import PanelTasks from './modules/PanelTasks'
    export default {
        name: 'PanelMain',
        data () {
            return {
                modal_name: '',
                additional_data: [],
                modules_headers_headlines: {
                    'panel_tasks': 'Задачи',
                    'panel_processes': 'Процессы',
                    'panel_calendar': 'Календарь'
                },
                selected_module: 'panel_calendar',
                billings: [],
                deals: [],
                media: [],
                clients: [],
                contentLoaded: false
            }
        },
        created () {
            this.selected_module = this.$cookie.get('last_page')
            this.checkSessionID();
            this.getData();
        },
        components: {
            'panel_modal': PanelModal,
            'panel_tasks': PanelTasks,
            'panel_processes': PanelProcesses,
            'panel_calendar': PanelCalendar,
            'panel_preloader': PanelPreloader
        },
        methods: {

            showModal (modalName) {
                this.modal_name = modalName
                this.$store.commit('switchModal')
            },

            getData () {
                axios.all([this.getUsers(), this.getTasks(), this.getProcesses()])
                    .then(axios.spread((users, tasks, processes) => {
                        this.contentLoaded = true;
                        if (!this.validateResponseData(users) ||
                            !this.validateResponseData(tasks) ||
                            !this.validateResponseData(processes)) {
                            return
                        }
                        this.$store.commit('setUsers', users.data.data)
                        this.$store.commit('setTasks', tasks.data.data)
                        this.$store.commit('setProcesses', processes.data.data)
                    }));
            },

            getUsers () {
              return axios.get('http://127.0.0.1/api/users')
            },

            getTasks () {
                return axios.get('http://127.0.0.1/api/tasks')
            },

            getProcesses () {
                return axios.get('http://127.0.0.1/api/processes')
            },

            validateResponseData (resp) {
                if (resp.data.code === 402 || resp.data.code === 403) {
                    this.logout(true, resp.data.message)
                    return false
                }
                if (resp.data.code !== 200 && resp.data.message !== undefined) {
                    this.$snotify.error(resp.data.message, 'Ошибка!',
                        {
                            closeOnClick: true,
                            timeout: 2000,
                            showProgressBar: true,
                            pauseOnHover: true
                        }
                    )
                    return false
                }
                return true
            },

            checkSessionID () {
                let sid = this.$cookie.get('sid');
                if (sid === null || sid.length !== 64) { this.logout(true, "Сессия истекла"); return}
                this.$store.commit('setSid', sid)
            },

            logout(force = false, reason = "Выход успешен") {
                this.$cookie.set('sid', '', -1)
                this.$store.commit('setSid', '')
                if (force) {
                    // TODO: Toast ее появляется без setTimeout
                    setTimeout( () => this.$snotify.error(reason, 'Ошибка!',
                        {
                            closeOnClick: true,
                            timeout: 2000,
                            showProgressBar: true,
                            pauseOnHover: true
                        }
                    ), 100)
                } else {
                    // TODO: Toast не появляется без setTimeout
                    setTimeout( () => this.$snotify.success(reason, 'Успешно',
                        {
                            closeOnClick: true,
                            timeout: 2000,
                            showProgressBar: true,
                            pauseOnHover: true
                        }
                    ), 100)
                }
                this.$router.push({name: 'sign_in'})
            }
        },
        watch: {
            selected_module: function (newSelect) {
                this.$cookie.set('last_page', newSelect, 365)
            }
        }
    }
</script>

<style scoped="true">

    #panel_main {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: stretch;
        width: 100%;
        height: 100vh;
        max-height: 100vh;
        overflow: hidden;
    }

    .menu {
        z-index: 999;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        height: 100%;
        min-width: 200px;
        background: #fff;
        box-shadow: 0.5px 0 1px 0 rgba(50, 50, 50, 0.3);
    }

    .container {
        z-index: 10;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: stretch;
        flex-grow: 1;
        overflow-y: scroll;
    }

    .header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        height: 50px;
        width: 100%;
        background: #fff;
        box-shadow: 0 0.5px 1px 0 rgba(50, 50, 50, 0.3);
    }

    .header-page_name { margin-left: 50px; }

    .page_name-text {
        font-size: 24px;
        font-weight: 600;
        color: #3498db;
    }

    .header-actions {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        margin-right: 50px;
    }

    .actions__button {
        padding: 5px 10px;
        color: #fff;
        background: #3498db;
        font-size: 18px;
        border-radius: 10px;
        border: none;
        outline: none;
        transition: all 0.3s ease-in-out;
    }

    .actions__button:hover {
        cursor: pointer;
        background: #2980b9;
    }

    .brand {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        height: 50px;
        width: 100%;
        box-shadow: 0 0.5px 1px 0 rgba(50, 50, 50, 0.3);
    }

    .brand-text {
        font-size: 28px;
        font-weight: 800;
        color: #3498db;
    }

    .menu__item:nth-child(2) { margin-top: 50px; }

    .menu__item {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
        height: 50px;
        width: 90%;
        margin-left: 10%;
        color: #3498db;
        font-size: 24px;
        transition: all 0.3s ease-in-out;
    }

    .menu__item:hover { cursor: pointer; }

    .menu__item:not(.menu__item--active):hover {
        color: #fff;
        background: #3498db;
    }

    .menu__item--active {
        color: #fff;
        background: #3498db;
    }

    .menu__item--active:after {
        content: '';
        position: absolute;
        left: 190px;
        width: 10px;
        height: 50px;
        background: #2980b9;
    }

    .menu__item-icon {
        margin: 1px 10px 0 10px;
    }

    .menu__item-text { text-transform: capitalize; }

</style>
