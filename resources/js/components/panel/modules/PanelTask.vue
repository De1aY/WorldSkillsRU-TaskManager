<template>
    <div class="panel-task">
        <div class="header">
            <icon name="list-alt" scale="1.5" class="header-icon"></icon>
            <div class="header-text">{{name}}</div>
        </div>
        <div class="body">
            <div class="body-description">
                <icon name="align-left" scale="1.5" class="body-description__icon"></icon>
                <div class="body-description__text">{{description}}</div>
            </div>
        </div>
        <div class="footer">
            <button class="footer-button">Выполнить</button>
            <div class="footer-time">
                <icon name="stopwatch" scale="1.5" class="footer-time__icon"></icon>
                <div class="footer-time__text">{{due_date_formatted}}</div>
            </div>
        </div>
    </div>
</template>

<script>
    import 'vue-awesome/icons/list-alt'
    import 'vue-awesome/icons/stopwatch'
    import 'vue-awesome/icons/align-left'
    export default {
        name: "PanelTask",
        props: ['name', 'description', 'due_date'],
        data() {
            return {
                due_date_formatted: this.formatDate(this.due_date)
            }
        },
        methods: {

            formatDate(date) {
                let formatter = new Date(date);
                let months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                return formatter.getDate() + "/" + months[formatter.getMonth()] + "/" + formatter.getFullYear()
            }

        }
    }
</script>

<style scoped>

    .panel-task {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        width: 400px;
        height: 200px;
        box-shadow: 0 0.5px 1px 0 rgba(50, 50, 50, 0.3);
    }

    .header {
        display: flex;
        align-items: center;
        width: 100%;
        height: 50px;
        background-color: #3498db;
        border-bottom: 0.3px solid rgba(50, 50, 50, 0.3);
    }

    .header .header-icon {
        margin: 1px 0 0 13px;
        color: #fff;
    }

    .header .header-text {
        display: flex;
        align-items: center;
        margin: 0 10px;
        font-size: 26px;
        color: #fff;
    }

    .body {
        display: flex;
        width: 100%;
        height: 100px;
    }

    .body .body-description {
        display: flex;
        width: 100%;
        height: 100%;
        margin: 15px;
    }

    .body .body-description .body-description__icon { margin-top: 3px; }

    .body .body-description .body-description__text {
        margin-left: 15px;
        font-size: 20px
    }

    .footer {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
        width: 100%;
        height: 50px;
        border-top: 0.3px solid rgba(50, 50, 50, 0.3);
    }

    .footer .footer-button {
        height: 100%;
        width: 50%;
        color: #fff;
        background: #3498db;
        font-size: 20px;
        border: none;
        outline: none;
        cursor: pointer;
        transition: background-color 300ms ease-in-out;
    }

    .footer .footer-button:hover { background: #2980b9 }

    .footer .footer-time {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        height: 100%;
        width: 50%;
    }

    .footer .footer-time .footer-time__icon { margin: 0 15px; }

    .footer .footer-time .footer-time__text {
        font-size: 20px;
    }

</style>