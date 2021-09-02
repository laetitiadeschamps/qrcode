<template>
    <h1>Accueil</h1>
   {{$store.state.username}}
    <input v-model="computedUsername" type="text">
    <button @click="setUsername" >Submit</button>
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