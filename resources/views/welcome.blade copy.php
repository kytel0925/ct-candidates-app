@extends('default')

@section('app')
<div id="app">
    <v-app id="inspire">
        <v-app-bar app shrink-on-scroll>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <v-toolbar-title>Todo List App</v-toolbar-title>

            <v-spacer></v-spacer>
            

            <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
        </v-app-bar>

        <v-main>
            <v-container>
                <template>
                    <v-card max-width="900" class="mx-auto">
                        <v-text-field v-model="newTask" @click:append="addTask" @keyup.enter="addTask"
                        class="pa-5" outlined label="Add Task" append-icon="mdi-plus" hide-details clearable ></v-text-field>
                        <v-divider></v-divider>
                        <v-subheader>Awesome Todo List</v-subheader>

                       
                        <show-sss/>
                       


                        <dialog></dialog>

                        <div v-if="showSpinner">
                            <show-spinner></show-spinner>
                        </div>

                        <div v-if="tasks.length">
                            <v-list class="pt-0" flat>
                                <div v-for="task in tasks" :key="task.id" >
                                <!--:class="{ 'blue lighten-5' : task.status }" -->
                                    <v-list-item @click=changeStatusTask(task.id) >
                                        <template v-slot:default="">
                                            <v-list-item-action>
                                                <v-checkbox :input-value="task.status" color="primary"></v-checkbox>
                                            </v-list-item-action>

                                            <v-list-item-content>
                                                <v-list-item-title :class="{ 'text-decoration-line-through' : task.status }">@{{ task.name_of_the_task }}</v-list-item-title>
                                            </v-list-item-content>

                                            <v-list-item-action>
                                                <v-btn @click.stop=updateTask(task.id) icon>
                                                    <v-icon color="primary lighten-1">mdi-pencil-outline</v-icon>
                                                </v-btn>
                                            </v-list-item-action>

                                            <v-list-item-action>
                                                <v-btn @click.stop=deleteTask(task.id) icon>
                                                    <v-icon color="red lighten-1">mdi-delete</v-icon>
                                                </v-btn>
                                            </v-list-item-action>

                                        </template>
                                        <v-divider></v-divider>
                                    </v-list-item>
                                    <v-divider></v-divider>
                                </div>
                            </v-list>
                        </div>
                        <div v-else>
                            <center>No Task</center>
                        </div>

                    </v-card>
                </template>
            </v-container>
        </v-main>
    </v-app>
</div>
@endsection

@section('vue')
    <script>
        new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            data: () => ({
                BASE_URL: 'http://127.0.0.1:8000/api',
                PREFIX: 'tasks',
                showSpinner: false,
                newTask: "",
                tasks: []
            }),
            components: {
                'show-sss' : ShowSss,
            },
            created() {
                this.getTasks()
            },
            methods: {
                /**
                 * @description
                 */
                getTasks(){
                    const me = this
                    me.showSpinner = true
                    axios.get(`${this.BASE_URL}/${this.PREFIX}/index`)
                    .then(function(response) {
                        if (response.status == 200) {
                            me.tasks = response.data
                            me.showSpinner = false
                        }
                    }).catch(function (error) {
                        console.log(error);
                    })

                    me.showSpinner = false
                },
                /**
                 * @description
                 */
                addTask(){
                    const me = this
                    axios.post(`${this.BASE_URL}/${this.PREFIX}/store`, { name_of_the_task: this.newTask })
                    .then(function(response) {
                        if (response.status == 200) {
                            me.newTask = ''
                            me.getTasks()
                        }
                    }).catch(function (error) {
                        console.log(error);
                    })
                },
                /**
                 * @description
                 * @param { Integer } id task id
                 */
                updateTask(id){
                    this.newTask = "tarea actualizada"
                    const me = this
                    axios.put(`${this.BASE_URL}/${this.PREFIX}/update/${id}`,{ name_of_the_task: this.newTask })
                    .then(function(response) {
                        me.newTask = ''
                        if (response.status == 200) {
                            me.getTasks()
                        }
                    }).catch(function (error) {
                        console.log(error);
                    })
                },
                /**
                 * @description
                 * @param { Integer } id task id
                 */
                changeStatusTask(id){
                    const me = this
                    axios.put(`${this.BASE_URL}/${this.PREFIX}/change-status/${id}`,)
                    .then(function(response) {
                        if (response.status == 200) {
                            me.getTasks()
                        }
                    }).catch(function (error) {
                        console.log(error);
                    })
                },
                /**
                 * @description
                 * @param { Integer } id task id
                 */
                deleteTask(id){
                    const me = this
                    axios.delete(`${this.BASE_URL}/${this.PREFIX}/delete/${id}`,)
                    .then(function(response) {
                        if (response.status == 200) {
                            me.getTasks()
                        }
                    }).catch(function (error) {
                        console.log(error);
                    })
                },
            },
        });

        Vue.component('show-spinner', {
           
            template:`
                    
            `,
            data: () => ({}),
        })

        Vue.component('show-sss', {
            name: 'ShowSss',
            template:`
                    <div class="text-center">
                        Show
                    </div>
            `,
            data: () => ({}),
        })

        /* Vue.component('dialog', {
            name: 'Dialog',
            template:`
                    <div>
                        sadasd
                    </div>
            `,
            data: () => ({}),
        }) */
    </script>
@show
