<template>
<main>
<div class="text-center">
    <h1>Se connecter</h1>
    <form @submit.prevent="handleLogin">
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
                this.$store.dispatch('handleLogin', data);          

        }
    }
 }
</script>