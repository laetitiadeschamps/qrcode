import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import axios from 'axios'
import router from '../router/index';
import  { flashMessage } from '@smartweb/vue-flash-message';

export default createStore({
    state: {
        errors: [],
        user:{}
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
        },
       
        saveUserInfos(state, payload) {
            state.user = payload
        },
        handleLogout(state) {
            state.user = {};
            localStorage.setItem('token', null);
            flashMessage.show({
                type: 'success',
                title: 'Vous avez été déconnecté!',
                message: 'Vous avez été déconnecté!'
            });
            router.push('/login'); 
        }
    },
   
    actions: {
        getQrcodes({commit}) {
            axios.get('api/v1/qrcodes')
            
            .then(response=> {
                console.log(response);
                //commit('qrcodesDisplayed', response)
            })
        },
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
        
            axios.post('api/login_check', data)
                .then(response=> {
                   
                   commit('saveUserInfos', response.data);
                   //axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
                   localStorage.setItem('token', response.data.token);
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