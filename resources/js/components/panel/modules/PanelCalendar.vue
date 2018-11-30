<template>
    <div id="panel-calendar">
        <gantt-elastic :tasks="tasks" :options="options"></gantt-elastic>
    </div>
</template>

<script>
    import GanttElastic from "gantt-elastic/src/GanttElastic.vue";
    export default {
        name: "PanelGantt",
        data() {
            return {
                tasks: [
                    {
                        id: 1,
                        label: 'Make some noise',
                        user: '<a href="https://www.google.com/search?q=John+Doe" target="_blank" style="color:#0077c0;">John Doe</a>',
                        start: this.getDate(-24 * 5),
                        duration: 5 * 24 * 60 * 60,
                        progress: 85,
                        type: 'project'
                    }, {
                        id: 2,
                        label: 'With great power comes great responsibility',
                        user: '<a href="https://www.google.com/search?q=Peter+Parker" target="_blank" style="color:#0077c0;">Peter Parker</a>',
                        parentId: 1,
                        start: this.getDate(-24 * 4),
                        duration: 4 * 24 * 60 * 60,
                        progress: 50,
                        type: 'milestone',
                        style: {
                            base: {
                                fill: '#1EBC61',
                                stroke: '#0EAC51'
                            },
                            /*'tree-row-bar': {
                              fill: '#1EBC61',
                              stroke: '#0EAC51'
                            },
                            'tree-row-bar-polygon': {
                              stroke: '#0EAC51'
                            }*/
                        },
                    }, {
                        id: 3,
                        label: 'Courage is being scared to death, but saddling up anyway.',
                        user: '<a href="https://www.google.com/search?q=John+Wayne" target="_blank" style="color:#0077c0;">John Wayne</a>',
                        parentId: 2,
                        start: this.getDate(-24 * 3),
                        duration: 2 * 24 * 60 * 60,
                        progress: 100,
                        type: 'task'
                    },
                ],
                options: {
                    style: {
                        "header": "background-color: #fff",
                    },
                    title: {
                        label: '',
                        html: false,
                    },
                    taskList: {
                        columns: [
                            { id: 1, label: 'ID', value: 'id', width: 40 },
                            { id: 2, label: 'Description', value: 'label', width: 200, expander: true },
                            { id: 3, label: 'Assigned to', value: 'user', width: 130, html: true },
                            { id: 3, label: 'Start', value: (task) => task.startDate.format('YYYY-MM-DD'), width: 78 },
                        ]
                    },
                    locale: {
                        code: "en",
                        Now: "Сейчас",
                        "X-Scale": "Масштаб по X",
                        "Y-Scale": "Масштаб по Y",
                        "Task list width": "Список задач",
                        "Before/After": "Расширить",
                        "Display task list": "Показать список задач"
                    }
                }
            }
        },
        methods: {
            getDate(hours) {
                const currentDate = new Date()
                const currentYear = currentDate.getFullYear()
                const currentMonth = currentDate.getMonth() + 1
                const currentDay = currentDate.getDate()
                const timeStamp = new Date(`${currentYear}-${currentMonth}-${currentDay} 00:00:00`).getTime()
                return new Date(timeStamp + hours * 60 * 60 * 1000)
            }
        },
        components: {
            'gantt-elastic': GanttElastic
        }
    }
</script>

<style scoped>

    #panel-calendar { margin:50px }

</style>