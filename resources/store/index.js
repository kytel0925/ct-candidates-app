import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistence from 'vuex-persist'


import actions from './actions';
import getters from './getters';
import mutations from './mutations';

//moduls store
import todo from '../components/Todo/store';

Vue.use(Vuex);

export default new Vuex.Store({
    strict: true, //disable for prod,
    plugins: [ new VuexPersistence().plugin ],

    modules: {
        todo,
    },
    state: {},
    actions,
    getters,
    mutations,
});
