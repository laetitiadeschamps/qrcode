<template>
<main>
  <div class="bg-light d-flex w-50 mx-auto border my-auto content-container">
        <figure class="w-50 my-auto p-2">
            <img src="../images/scan.png" alt="" class="w-100">
        </figure>

    
    <form @submit.prevent="handleRegister" novalidate="true" class="w-50 p-2 mx-auto m-4 d-flex flex-column justify-content-center">
       <h1>S'inscrire</h1>
        <div class="errors-container">
             <!-- <p v-if="$store.state.formMessage" class="message" :class="{'alert-danger': $store.state.formMessage.type == error, 'alert-success': $store.state.formMessage.type == success}">{{ $store.state.formMessage.message}}</p>  -->
            
            <!-- <p v-if="errors.length">
                <b>Merci de vérifier le(s) champs suivant(s):</b>
                <ul>
                    <li v-for="error in errors" :key="error">{{ error }} </li>
                </ul>
            </p> -->
             <p v-if="Object.entries($store.state.errors)">
                <ul>
                    <li class="alert alert-danger" v-for="error in $store.state.errors" :key="error">{{ error.error }} </li>
                </ul>
            </p>
           
            
        </div>
        
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
    
    <button type="submit" class="btn btn-outline-warning">S'inscrire</button>
    </form>
</div>
</main>
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
   
    beforeUnmount() {
         this.$store.commit('resetErrors');
    },
    
    methods: {
        handleRegister() { 
            this.$store.commit('resetErrors');
            let isValid=true;
                if(!this.validEmail()) {
                   this.$store.commit("addFormError",{field:"email", error:"L'email n'est pas valide"});
                   isValid = false;
                } 
                if(!this.validPassword()) {
                    this.$store.commit("addFormError",{field:"password", error:"Le mot de passe n'est pas valide"});
                    isValid = false;
                }
                if(!this.matchingPassword()) {
                    this.$store.commit("addFormError", {field:"password",error:"Les mots de passe ne correspondent pas"});
                    isValid = false;
                }
                if(isValid) {
                    this.errors=[];
                    const data = {
                        email:this.email,
                        password:this.password,
                        password_confirm:this.password_confirm
                    }
                   this.$store.commit('changeLoadingStatus', true);

                    this.$store.dispatch('handleRegister', data);    
                      
                } else {
                    this.$flashMessage.show({
                        type: 'error',
                        title: 'Il y a eu une erreur',
                        message: 'Il y a eu une erreur'
                    });
                }
                    
            
            
            //    console.log(window.location.origin);
            //    console.log(this.$route.path);
            //this.$store.commit('setUsername', this.computedUsername);
        },
        validEmail(){
            const regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return regex.test(this.email);
        },
        validPassword() {
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$%_*|=&-])[A-Za-z\d@$%_*|=&-]{6,}$/;
           
            return regex.test(this.password);
        },
        matchingPassword() {
            if(this.password != this.password_confirm) {
                return false;
            }
            return true;
        }
    }
}

</script>
<style>
    body {
        background-color: #d6d6d6;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }
</style>