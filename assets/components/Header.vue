<template>

    <header class="main-header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Qr-code Scanner</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
             <router-link to="/" class="nav-link active">Accueil</router-link>
        </li>
       
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Compte
          </a>

          <ul  class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><router-link to="/" @click="handleLogout"  v-if="$store.state.user.token" class="nav-link text-dark">Se déconnecter</router-link></li>
             <li><router-link to="/login" v-if="!$store.state.user.token" class="nav-link text-dark">Se connecter</router-link></li>
            <li><router-link to="/register" v-if="!$store.state.user.token" class="nav-link text-dark">S'inscrire</router-link></li>
          </ul>
          
        </li>
      </ul>
    </div>
  </div>
</nav>
    </header>
    <Flash />
</template>

<script>
import Flash from './Flash.vue';

export default {
  name:'Header',
  components: {
    Flash
  },
  methods: {
    handleLogout() {
      this.$store.commit('handleLogout');
    }
  }
}

</script>

<style>
.main-header {
      position: fixed;
      top:0;
      left:0;
      right:0;
      height:4em;
      z-index:100;
   }
</style>