<template>
    <v-app id="inspire">
        <v-app-bar app shrink-on-scroll>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <v-toolbar-title>Todo List App</v-toolbar-title>

            <v-spacer></v-spacer>

            <div class="col-md-3">
                <v-text-field v-model="search" @click:append="searchTasks" @keyup="searchTasks" class="expanding-search pa-3" placeholder="Search" prepend-inner-icon="mdi-magnify" hide-details filled dense ></v-text-field>
            </div>

            <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
        </v-app-bar>

        <v-main>
            <TodoList/>
        </v-main>
    </v-app>
</template>

<script>
    import TodoList from '../components/Todo/TodoList.vue'

    export default {
        name: 'App',
        data: () => ({
            search: '',
        }),
        components: {
            TodoList,
        },
        computed: {
            /**
             * @description
             * @return { Array }
             */
            getTasksFromStore() {
                return this.$store.getters['todo/getTasks']
            },
        },
        methods:{
            searchTasks(){
                if (this.search === '' || this.search === null){
                    this.$store.dispatch('todo/storeTasks', null)
                    return
                }

                let result = []
                for (let task of this.getTasksFromStore) {
                    let search = task.name_of_the_task.toLowerCase()
                    if (search.indexOf(this.search.toLowerCase()) !== -1) {
                        result.push(task)
                        this.$store.dispatch('todo/storeTasks', [...result])
                    }
                }
                if (result.length == 0) {
                    this.$store.dispatch('todo/storeTasks', [])
                }
            },
        },
    }
</script>
