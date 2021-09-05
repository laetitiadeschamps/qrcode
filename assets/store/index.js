import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import axios from 'axios'
export default createStore({
    state: {
        errors:[],
        formMessage:'',

    },
    mutations: {
       addMessage(state, payload) {
            state.formMessage =  payload
            
        },
        addFormErrors(state, payload) {
            state.errors= JSON.parse(payload);  
        },
        resetErrors(state) {
            state.errors=[];
            state.formMessage='';
        }
    },
    actions: {
        
        handleRegister({commit}, data) {
          
            axios.post(window.location.origin + '/api/v1/user', data)
                .then(response=> {
                    console.log(response);
                   
                    commit('addMessage', {
                        type:"success",
                        message:"Le compte a bien été créé"
                        });
                    this.$router.push('/login');
                })
                .catch(error=> {
                    commit('addFormErrors', error.request.responseText);
                   
                    commit('addMessage', {
                        type:"error",
                        message:"Il y a eu une erreur"
                    });
                    
                })
        }

    },
    modules: {

    },
    plugins: [createPersistedState()]

})