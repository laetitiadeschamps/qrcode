<template>
<main>
    <h1>Accueil</h1>
  
    
    
</main>
</template>

<script>

export default({
    name:'Home',
    created() {
    this.$store.dispatch('getQrcodes');
    },
    
})
</script>

<style>


main {
    margin-top:4em;
    min-height:80vh;
}
</style>