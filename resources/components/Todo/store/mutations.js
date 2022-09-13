export default {
    /**
     * @description Receives and sets the value of the payload in the vuex store.
     * @param { Any } state
     * @param { Any } payload
     */
    setTasks(state, payload) {
        state.tasks = payload;
    },
};
