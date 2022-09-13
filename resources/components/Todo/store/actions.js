export default {
    /**
     * @description  commit to the mutation setTasks
     * @param { Array } payload
     */
    storeTasks: function (state, payload) {
        state.commit("setTasks", payload);
    },
};
