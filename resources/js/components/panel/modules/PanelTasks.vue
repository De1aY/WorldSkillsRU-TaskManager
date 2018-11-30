<template>
    <div id="panel-tasks">
        <panel-task v-for="task in $store.state.tasks" :key="task.id"
                :name="task.name"
                :description="task.description"
                :due_date="task.due_date">
        </panel-task>
    </div>
</template>

<script>
    import PanelTask from './PanelTask'
    export default {
        name: "PanelTasks",
        components: {
            'panel-task': PanelTask,
        }
    }
</script>

<style scoped>

    #panel-tasks {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        margin:50px;
    }

</style>