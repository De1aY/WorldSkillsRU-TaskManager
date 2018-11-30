<template>
    <div id="panel_modal" @click="switchModal">
        <div class="modal">
            <component
                    :is="modal_name">
            </component>
        </div>
    </div>
</template>

<script>
    import AddTaskModal from './modals/AddTaskModal'
    export default {
        name: "PanelModal",
        props: [ 'modal_name' ],
        methods: {
            switchModal (e, flag = false) {
                if (flag || e.target.id === 'panel_modal') {
                    this.$store.commit('switchModal')
                }
            },
        },
        components: {
            'panel_tasks_add': AddTaskModal
        }
    }
</script>

<style>

    #panel_modal {
        z-index: 1000;
        position: fixed;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        height: 100%;
        width: 100%;
        background: rgba(0, 0, 0, 0.3);
    }
    .modal {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-width: 350px;
        min-height: 200px;
        border-radius: 5px;
        background: #ecf0f1;
    }

    #panel_modal .form-field {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        margin: 15px 0;
        width: 300px;
        height: 38px;
        border-radius: 5px;
        background-color: #ffffff;
    }

    #panel_modal .form-field--border {
        padding: 0 25px;
        width: 100%;
        border-bottom: 1px solid rgba(0,0,0,.1)
    }

    #panel_modal .form-field:first-child {
        margin: 30px 0 15px 0;
    }

    #panel_modal .form-field .fa-icon { color: #95a5a6; }

    #panel_modal .form-field .form-field__icon--lock {
        margin-top: 4px;
    }

    #panel_modal .form-field .form-field__input {
        width: 240px;
        height: 35px;
        font-size: 18px;
        color: #95a5a6;
        border: none;
        outline: none;
    }

    #panel_modal .form-field .form-field__input::-webkit-input-placeholder { color: #95a5a6; }
    #panel_modal .form-field .form-field__input:-moz-placeholder { color: #95a5a6; }
    #panel_modal .form-field .form-field__input::-moz-placeholder { color: #95a5a6; }
    #panel_modal .form-field .form-field__input:-ms-input-placeholder { color: #95a5a6; }

    #panel_modal .form-field__input .multiselect__tags {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
        padding: 0;
        margin: 2px 0;
        min-height: 35px;
        max-height: 35px;
        border: none;
    }

    #panel_modal .form-field__input .multiselect__tags input {
        margin: 0;
        padding: 0;
        height: 35px;
        font-size: 18px;
        color: #95a5a6;
    }

    #panel_modal .form-field__input .multiselect__tags input::-webkit-input-placeholder { color: #95a5a6; }
    #panel_modal .form-field__input .multiselect__tags input:-moz-placeholder { color: #95a5a6; }
    #panel_modal .form-field__input .multiselect__tags input::-moz-placeholder { color: #95a5a6; }
    #panel_modal .form-field__input .multiselect__tags input:-ms-input-placeholder { color: #95a5a6; }

</style>