<template>
   <div class="text-center">
    <h1>S'inscrire</h1>
    <form @submit.prevent="handleRegister" novalidate="true">
        <div class="errors-container">
            <p class="message">{{ $store.state.formMessage}}</p>
            <p v-if="errors.length">
                <b>Merci de vérifier le(s) champs suivant(s):</b>
                <ul>
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
            </p>
             <p v-if="$store.state.errors.length">
                <b>Merci de vérifier le(s) champs suivant(s):</b>
                <ul>
                    <li v-for="error in $store.state.errors" :key="error">{{ error }}</li>
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
    
    <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>
</template>

<script>
export default {
    name:'Register',
    data() {
        return {
            errors:[],
            email:'',
            password:'',
            password_confirm:''
        }
    },
    methods: {
        handleRegister() {
            this.errors=[];
            this.$store.commit('resetErrors');
            let isValid=true;
                if(!this.validEmail()) {
                    this.errors.push("L'email n'est pas valide");
                   isValid = false;
                } 
                if(!this.validPassword()) {
                    this.errors.push("Le mot de passe n'est pas valide");
                    isValid = false;
                }
                if(!this.matchingPassword()) {
                    this.errors.push("Les mots de passe ne correspondent pas");
                    isValid = false;
                }
                if(isValid) {
                    this.errors=[];
                    const data = {
                        email:this.email,
                        password:this.password,
                        password_confirm:this.password_confirm
                    }
                    console.log(data);

                    this.$store.dispatch('handleRegister', data);
                    
                      
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

li {
    list-style-type: none;
}

.errors-container {
    min-height: 5em;
}
</style>