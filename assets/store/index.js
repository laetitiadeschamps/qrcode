import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import axios from 'axios'
import router from '../router';
import  { flashMessage } from '@smartweb/vue-flash-message';

export default createStore({
    state: {
        errors: []
    },
    mutations: {
       
        addFormErrors(state, payload) {
          state.errors= JSON.parse(payload); 
        },
        addFormError(state, payload) {
            state.errors.push(payload) ;    
        },
        resetErrors(state) {
            state.errors=[];
        }
    },
   
    actions: {
        
        handleRegister({commit}, data) {
          
            axios.post('api/v1/user', data)
                .then(response=> {
                  
                    router.push('/login');
                    flashMessage.show({
                        type: 'success',
                        title: 'Le compte a été créé!',
                        message: 'Le compte a été créé!'
                    });
                })
                .catch(error=> {
                    commit('addFormErrors', error.request.responseText);
                    flashMessage.show({
                        type: 'error',
                        title: 'Il y a eu une erreur!',
                        message: 'Il y a eu une erreur!'
                    });
                    
                })
        },
        handleLogin({commit}, data) {
          
            axios.post(window.location.origin + 'api/login_check', data)
                .then(response=> {
                    router.push('/');    
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