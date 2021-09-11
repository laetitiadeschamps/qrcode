import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import axios from 'axios'
import router from '../router/index';
import  { flashMessage } from '@smartweb/vue-flash-message';

export default createStore({
    state: {
        errors: [],
        user:{},
        qrcodesDisplayed:[],
        singleQrcode:{},
        loading:false
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
        resetQrCodes(state) {
            state.qrcodesDisplayed=[];
        },
        qrcodesDisplayed(state, data) {
            state.qrcodesDisplayed = data; 
        },
        qrcodeSingle(state, data) {
            state.singleQrcode = data; 
        },
        saveUserInfos(state, payload) {
            state.user = payload
        },
        changeLoadingStatus(state, payload) {
            state.loading = payload;
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
                commit('changeLoadingStatus', false);
                commit('qrcodesDisplayed', response.data)
            })
            .catch(error=> {
                commit('changeLoadingStatus', false);
               
                flashMessage.show({
                    type: 'error',
                    title: 'Il y a eu une erreur, veuillez réessayer!',
                    message: 'Il y a eu une erreur, veuillez réessayer!'
                });
            })
        },
        getQrCode({commit}, id) {
            axios.get(`api/v1/qrcodes/${id}`)
            
            .then(response=> {
                console.log(response);
                commit('changeLoadingStatus', false);
                commit('qrcodeSingle', response.data)
            })
            .catch(error=> {
                commit('changeLoadingStatus', false);
               
                flashMessage.show({
                    type: 'error',
                    title: 'Il y a eu une erreur, veuillez réessayer!',
                    message: 'Il y a eu une erreur, veuillez réessayer!'
                });
            })
        },
        handleRegister({commit}, data) {
          
            axios.post('api/v1/user', data)
                .then(response=> {
                  commit('changeLoadingStatus', false);
                    router.push('/login');
                    flashMessage.show({
                        type: 'success',
                        title: 'Le compte a été créé!',
                        message: 'Le compte a été créé!'
                    });
                })
                .catch(error=> {
                    commit('changeLoadingStatus', false);
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
                   localStorage.setItem('token', response.data.token);
                   commit('changeLoadingStatus', false);
                 
                    router.push('/');  
                })
                .catch(error=> {
                    commit('changeLoadingStatus', false);
                   commit("addFormError", {field:"email", error:"Les identifiants sont invalides"});
                    
                })
        },
        handleNewCode({commit}, data) {
        
            axios.post('api/v1/qrcodes', data)
                .then(response=> { 
                    console.log(response);
                    commit('changeLoadingStatus', false);
                    router.push('/');  
                    flashMessage.show({
                        type: 'success',
                        title: 'Le code a bien été créé',
                        message: 'Le code a bien été créé'
                    });
                })
                .catch(error=> {
                    commit('changeLoadingStatus', false);
                    commit('addFormErrors', error.request.responseText);
                    
                })
        },
        handleDeleteCode({commit}, id) {
          
            axios.delete(`api/v1/qrcodes/${id}`)
                .then(response=> { 
                    console.log(response);
                    commit('changeLoadingStatus', false);
                    router.push('/');  
                    flashMessage.show({
                        type: 'success',
                        title: 'Le code a bien été supprimé',
                        message: 'Le code a bien été supprimé'
                    });
                })
                .catch(error=> {
                    commit('changeLoadingStatus', false);
                    commit('addFormErrors', error.request.responseText);
                    
                })
        }

    },
    
    
    modules: {

    },
    plugins: [createPersistedState()]

})