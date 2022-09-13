<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Edit Task</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field v-model="editTask.name_of_the_task" label="Task*" required></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false">
                        Close
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="updateTask">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
    import { toastMessage } from '../../utils/toast'
    import useTodo from '../Todo/composable/useTodo.js'
    const { _updateTask } = useTodo()

    export default {
        data: () => ({
            dialog: true,
            editTask: {},
        }),
        methods:{
            /**
             * @description Consumes the task update api
             */
            async updateTask(){
                const request = {
                    name_of_the_task: this.editTask.name_of_the_task,
                    id: this.editTask.id
                }
                const response = await _updateTask(request)
                if (response.status == 200) {
                    this.$emit('getTask');
                }else{
                    console.log(response);
                    this.$toast.error(response.statusText, toastMessage())
                }
            },
        },
        created(){
            this.editTask = { ...this.$parent.$data.editTask }
        }
    }
</script>