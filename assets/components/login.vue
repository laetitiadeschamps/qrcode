<template>
<main>
<div class="text-center">
    <h1>Se connecter</h1>
    <form @submit.prevent="handleLogin">
        
       <div class="errors-container">
        
             <p v-if="Object.entries($store.state.errors)">
                <ul>
                    <li class="alert alert-danger" v-for="error in $store.state.errors" :key="error">{{ error.error }} </li>
                </ul>
            </p>
        </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" v-model="email" class="form-control" id="email" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">Cette adresse ne sera pas partagée sans votre accord.</div>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" v-model="password" id="password">
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</main>    
</template>

<script>
import Spinner from './Spinner.vue'
 export default {
    name:'Login',
    components: {
        Spinner
    },
    props: {
         email:'', 
         password:'',
    },
    beforeUnmount() {
         this.$store.commit('resetErrors');
    },
    
    methods: {
        
        handleLogin() {
                this.$store.commit('resetErrors');
                if(!this.email || !this.password) {
                this.$flashMessage.show({
                                type: 'error',
                                title: 'Tous les champs doivent être remplis',
                                message: 'Tous les champs doivent être remplis'
                            });
                    return;
                } 
            
                const data = {
                    username:this.email,
                    password:this.password
                }
                this.$store.commit('changeLoadingStatus', true);
                this.$store.dispatch('handleLogin', data);          

        }
    }
 }
</script>