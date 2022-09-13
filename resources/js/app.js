require('./bootstrap');
import Vue from 'vue'
import store from '../store'
import '../plugins/toastification'

import vuetify from '../plugins/vuetify' // path to vuetify export

import App from '../views/App.vue'

new Vue({
    vuetify,
    store,
    render: h => h(App)
}).$mount('#app')