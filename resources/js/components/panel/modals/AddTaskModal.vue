<template>
    <form id="panel_modal_billings">
        <div class="form-field">
            <input
                    class="form-field__input"
                    v-model.trim="name"
                    type="text"
                    placeholder="Название">
            <icon name="list-alt" scale="1.2" class="form-field__icon--lock"></icon>
        </div>
        <div class="form-field form-field--textarea">
            <textarea
                    maxlength="255"
                    class="form-field__textarea"
                    v-model.trim="description"
                    type="text"
                    placeholder="Описание"></textarea>
            <icon name="align-left" scale="1.2" class="form-field__icon--lock"></icon>
        </div>
        <div class="form-field">
            <flat-pickr
                    v-model="due_date"
                    class="form-field__input"
                    :config="date_config"
                    placeholder="Дата окончания"></flat-pickr>
            <icon name="flag-checkered" scale="1.2" class="form-field__icon--flag"></icon>
        </div>
        <div class="form-field__actions">
            <input class="form-field__submit" @click.prevent="submit()" type="submit" value="Создать"/>
        </div>
    </form>
</template>

<script>
    import axios from 'axios'
    import 'vue-awesome/icons/align-left'
    import 'vue-awesome/icons/list-alt'
    import 'vue-awesome/icons/flag-checkered'
    import flatPickr from 'vue-flatpickr-component'
    import 'flatpickr/dist/flatpickr.css'
    import {Russian} from 'flatpickr/dist/l10n/ru'
    export default {
        name: "AddTaskModal",
        data () {
            return {
                name: '',
                description: '',
                due_date: '',
                date_config: {
                    dateFormat: 'd/m/Y',
                    locale: Russian
                }
            }
        },
        methods: {

            submit() {
                if(!this.validateData()) { return }
                this.$store.commit('switchModal')
                this.$snotify.async(
                    'Запрос выполняется',
                    'Подождите...',
                    () => new Promise((resolve, reject) => {
                        axios.put('http://127.0.0.1/api/tasks', {
                            'name': this.name,
                            'description': this.description,
                            'due_date': this.due_date,
                            'sid': this.$store.state.sid,
                        }).then(resp => {
                            if (resp.data.code !== 200) {
                                reject({
                                    title: 'Ошибка!',
                                    body: resp.data.message,
                                    config: {
                                        closeOnClick: true,
                                        timeout: 2000,
                                        showProgressBar: true,
                                        pauseOnHover: true
                                    }
                                })
                                return
                            }
                            this.$store.commit('addTask', {
                                'id': resp.data.id,
                                'name': this.name,
                                'description': this.description,
                                'due_date': this.due_date,
                                'is_completed': false,
                            })
                            resolve({
                                title: 'Успешно',
                                body: 'Задача создана',
                                config: {
                                    closeOnClick: true,
                                    timeout: 2000,
                                    showProgressBar: true,
                                    pauseOnHover: true
                                }
                            })
                        }).catch(resp => {
                            reject({
                                title: 'Ошибка!',
                                body: 'Неизвестная ошибка',
                                config: {
                                    closeOnClick: true,
                                    timeout: 2000,
                                    showProgressBar: true,
                                    pauseOnHover: true
                                }
                            })
                        })
                    })
                )
            },

            validateData() {
                return this.validateName()
                    && this.validateDescription()
                    && this.validateDate()
            },

            validateName() {
                if (this.name.length < 1) {
                    this.$snotify.error('Название не может быть пустым', 'Ошибка!',
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

            validateDescription() {
                if (this.description.length < 1){
                    this.$snotify.error('Описание не может быть пустым', 'Ошибка!',
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

            validateDate() {
                if (this.due_date === '') {
                    this.$snotify.error('Дата не может быть пустой', 'Ошибка!',
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
            }

        },
        components: {
            flatPickr
        }
    }
</script>

<style scoped>

    #panel_modal_billings {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .form-field__submit {
        width: 100%;
        height: 38px;
        border-radius: 5px;
        border: none;
        background-color: #3498db;
        text-transform: uppercase;
        color: #fff;
        font-size: 18px;
        outline: none;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .form-field--textarea {
        height: 120px !important;
    }

    .form-field__textarea {
        width: 240px;
        height: 100px;
        font-size: 18px;
        color: #95a5a6;
        border: none;
        outline: none;
    }

    .form-field__textarea::-webkit-input-placeholder { color: #95a5a6; }
    .form-field__textarea:-moz-placeholder { color: #95a5a6; }
    .form-field__textarea::-moz-placeholder { color: #95a5a6; }
    .form-field__textarea:-ms-input-placeholder { color: #95a5a6; }

    .form-field__submit:hover {  background: #2980b9; }

    .form-field__actions {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
        margin: 15px 0 30px 0;
        width: 300px;
    }
</style>