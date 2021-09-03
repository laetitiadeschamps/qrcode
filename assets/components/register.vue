<template>
   <div class="text-center">
    <h1>S'inscrire</h1>
    <form @submit.prevent="handleRegister">
    <div class="mb-3">
        <label for="email" class="form-label">Adresse email</label>
        <input type="email" class="form-control" id="email" v-model="email" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">Cette adresse ne sera pas partagée sans votre accord.</div>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" v-model="password" class="form-control" id="password">
    </div>
     <div class="mb-3">
        <label for="password_confirm" class="form-label">Confirmez votre mot de passe</label>
        <input type="password" v-model="password_confirm" class="form-control" id="password_confirm">
    </div>
    
    <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>
</template>

<script>
export default {
    name:'Register',
    data() {
        return {
            email:'',
            password:'',
            password_confirm:''
        }
    },
    methods: {
        handleRegister() {
           const data = {
               email:this.email,
               password:this.password,
               password_confirm:this.password_confirm
           }
        //    console.log(window.location.origin);
        //    console.log(this.$route.path);
           this.$store.dispatch('handleRegister', data);

            //this.$store.commit('setUsername', this.computedUsername);
        }
    }
}

</script>