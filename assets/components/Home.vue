<template>
<main>
    <h1>Accueil</h1>
   {{$store.state.username}}
    <input v-model="computedUsername" type="text">
    <button @click="setUsername" >Valider</button>
    <button @click="this.$store.dispatch('testAxios')">Get random number</button>
</main>
</template>

<script>

export default({
    name:'Home',
    computed: {
        computedUsername: {
            get() {
                return this.$store.state.username
            },
            set(newValue) {
                console.log('ok'); 
                this.$store.commit('setUsername', newValue)
            }
        }
    },
    methods: {
        setUsername() {
          this.$store.commit('setUsername', this.computedUsername);
        }
    }
})
</script>

<style>
body {
     min-height: 100%;
     display: flex;
     flex-direction: column;
}

main {
    flex-grow: 1;
}
</style>