<template>
<main class="d-flex justify-content-center align-items-center">
    
   
   
<div class="bg-light d-flex w-50 mx-auto border my-auto content-container">
        <figure class="w-50 my-auto p-2">
            <img src="../images/scan.png" alt="" class="w-100">
        </figure>
    <form @submit.prevent="handleLogin" novalidate="true" class="w-50 p-2 mx-auto m-4 d-flex flex-column justify-content-center">
         <h1>Se connecter</h1>
       <div class="errors-container">
        
             <p v-if="Object.entries($store.state.errors)">
                <ul>
                    <li class="alert alert-danger" v-for="error in $store.state.errors" :key="error">{{ error.error }} </li>
                </ul>
            </p>
        </div>
    <div class="mb-3">
        <label for="email" class="form-label">Adresse mail</label>
        <input type="email" v-model="email" class="form-control" id="email" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">Cette adresse ne sera pas partagée sans votre accord.</div>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" v-model="password" id="password">
    </div>
   
    <button type="submit" class="btn btn-outline-warning">Se connecter</button>
    </form>
</div>
</main>    
</template>

<script>
 export default {
    name:'Login',

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