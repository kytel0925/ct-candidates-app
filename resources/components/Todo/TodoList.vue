<template>
    <v-container>
        <div class="home">
            <v-text-field v-model="newTask" @click:append="addTask" @keyup.enter="addTask" class="pa-3" outlined label="Add Task" append-icon="mdi-plus" hide-details clearable></v-text-field>

            <ConfirmDlg ref="confirm" />

            <template v-if="showEditTask">
                <EditTask @getTask="getTasks" />
            </template>

            <div v-if="showSpinner">
                <Spinner />
            </div>
            <div v-else>
                <v-list v-if="getTasksFromStore.length" class="pt-0 mt-4" flat>
                    <draggable v-model="dragTasks" class="list-group" handle=".handle">
                        <div v-for="task in getTasksFromStore" :key="task.id">
                            <v-list-item @click="changeStatusTask(task.id)">
                                <template v-slot:default>
                                    <v-list-item-action>
                                        <v-checkbox :input-value="task.status" color="primary"></v-checkbox>
                                    </v-list-item-action>

                                    <v-list-item-content>
                                        <v-list-item-title :class="{ 'text-decoration-line-through' : task.status }">
                                            {{ task.name_of_the_task }}
                                        </v-list-item-title>
                                    </v-list-item-content>

                                    <v-list-item-action>
                                        <v-btn class="handle" icon>
                                            <v-icon color="primary lighten-1">mdi-drag-horizontal-variant</v-icon>
                                        </v-btn>
                                    </v-list-item-action>

                                    <v-list-item-action>
                                        <v-btn @click.stop="editTasks(task.id)" icon>
                                            <v-icon color="primary lighten-1">mdi-pencil-outline</v-icon>
                                        </v-btn>
                                    </v-list-item-action>

                                    <v-list-item-action>
                                        <v-btn @click.stop="showDialog(task.id)" icon>
                                            <v-icon color="red lighten-1">mdi-delete</v-icon>
                                        </v-btn>
                                    </v-list-item-action>
                                </template>
                            </v-list-item>
                            <v-divider></v-divider>
                        </div>
                    </draggable>
                </v-list>
                <div v-else class="no-tasks">
                    <v-icon size="100" color="primary">
                        mdi-check
                    </v-icon>
                    <div class="text-h5 primary--text">No tasks</div>
                </div>
            </div>
        </div>
    </v-container>
</template>


<script>
    import ConfirmDlg from '../Todo/ConfirmDlg.vue'
    import EditTask from '../Todo/EditTask.vue'
    import Spinner from '../Shared/Spinner.vue';

    import draggable from 'vuedraggable';

    import useTodo from '../Todo/composable/useTodo.js'
    const { _getTasks, _addTask, _changeStatusTask, _deleteTask } = useTodo()
    import { toastMessage } from '../../utils/toast'

    export default {

        name: 'TodoList',

        created() {
            this.getTasks()
        },

        components: {
            ConfirmDlg,
            draggable,
            EditTask,
            Spinner,
        },

        computed: {
            dragTasks:{
                get(){
                    return this.getTasksFromStore
                },
                set( value ){
                    this.$store.dispatch('todo/storeTasks', value)
                },
            },
            /**
             * @description Gets all tasks from the store
             * @return { Array }
             */
            getTasksFromStore() {
                return this.$store.getters['todo/getTasks']
            },
        },

        data: () => ({
            showSpinner: false,
            showEditTask: false,
            newTask: null,
            editTask: "",
            tasks: [],

        }),

        methods: {
            /**
             * @description
             * @param { Integer } id task id
             */
            editTasks(id){
                this.showEditTask = true
                this.editTask = this.tasks.filter( task => task.id == id)[0]
            },
            /**
             * @description Consumes the task index api
             */
            async getTasks(){
                this.showSpinner = true
                const response = await _getTasks()
                if (response.status == 200) {
                    this.tasks = response.data
                    this.showSpinner = false
                    this.$store.dispatch('todo/storeTasks', this.tasks)
                    this.$toast.success('Success', toastMessage())
                }else{
                    console.log(response);
                    this.$toast.error(response.statusText, toastMessage())
                }

                this.showSpinner = false
                this.showEditTask = false
            },
            /**
             * @description Consumes the task store api
             */
            async addTask(){
                if (this.newTask === '' || this.newTask === null) return

                const request = { name_of_the_task: this.newTask }
                const response = await _addTask(request)
                if (response.status == 200) {
                    this.newTask = ''
                    this.getTasks()
                }else{
                    console.log(response);
                    this.$toast.error(response.statusText, toastMessage())
                }
            },
            /**
             * @description Updates the status of the task according to the submitted id
             * @param { Integer } id task id
             */
            async changeStatusTask(id){
                const response = await _changeStatusTask(id)
                if (response.status == 200) {
                    this.getTasks()
                }else{
                    console.log(response);
                    this.$toast.error(response.statusText, toastMessage())
                }
            },
            /**
             * @description Displays a confirmation message for deletion of the selected task.
             * @param { Integer } id task id
             */
            async showDialog(id) {
                if ( await this.$refs.confirm.open( "Confirm", "Are you sure you want to delete the selected task?" )) {
                    this.deleteTask(id);
                }
            },
            /**
             * @description Deletes the selected task according to the task id
             * @param { Integer } id task id
             */
            async deleteTask(id){
                const response = await _deleteTask(id)
                if (response.status == 200) {
                    this.getTasks()
                }else{
                    console.log(response);
                    this.$toast.error(response.statusText, toastMessage())
                }
            },
        },

        watch:{
            getTasksFromStore:{
                deep: true,
                handler () {
                    if (this.getTasksFromStore == null) {
                        this.$store.dispatch('todo/storeTasks', this.tasks)
                    }
                }
            },
        },
    }
</script>

<style lang='sass' scoped>
    .no-tasks
        left: 50%
        position: absolute
        top: 50%
        transform: translate(-50%, -50%)

    .sorting
        bottom: 20px
        left: 50%
        position: fixed
        transform: translateX(-50%)

</style>