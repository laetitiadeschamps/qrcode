import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";

export default createStore({
    state: {
        username:'test'
    },
    mutations: {
       setUsername(state, payload) {
            state.username =  payload
        }
    },
    actions: {

    },
    modules: {

    },
    plugins: [createPersistedState()]

})