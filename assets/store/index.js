import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import axios from 'axios'
export default createStore({
    state: {
        errors: []

    },
    mutations: {
       
        addFormErrors(state, payload) {
          state.errors= JSON.parse(payload); 
          console.log(state.errors);
          console.log(typeof state.errors);
        },
        addFormError(state, payload) {
            console.log(typeof state.errors);
            state.errors.push(payload) ; 
            console.log(state.errors);     
        },
        resetErrors(state) {
            state.errors=[];
        }
    },
    actions: {
        
        handleRegister({commit}, data) {
          
            axios.post(window.location.origin + '/api/v1/user', data)
                .then(response=> {
                    console.log(response);
                   
                    this.$router.push('/login');
                })
                .catch(error=> {
                    commit('addFormErrors', error.request.responseText);
                    
                    
                })
        }

    },
    
    
    modules: {

    },
    plugins: [createPersistedState()]

})