import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import axios from 'axios'

export default createStore({
    state: {
        username:'test',
        counter:0
    },
    mutations: {
       setUsername(state, payload) {
            state.username =  payload
        },
        addRandom(state, payload) {
            state.counter+= payload
        }
    },
    actions: {
        //with param
        //testAxios({ commit }, param) {
        testAxios({ commit }) {
            axios('https://www.random.org/integers/?num=1&min=1&max=8&col=1&base=10&format=plain&rnd=new').then(response=> {
                commit('addRandom', response.data);
            })
        },
        handleRegister({commit}, data) {
          
            axios.post(window.location.origin + '/api/v1/user', data)
                .then(response=> {
                    console.log(response);
                    //commit('addRandom', response.data);
                })
                .catch(error=> {
                    console.log(error);
                })
        }

    },
    modules: {

    },
    plugins: [createPersistedState()]

})