<template>
    <div>
        <Header />
        <div v-if="$store.state.loading">
           <Spinner />
       </div>
        <router-view></router-view>
        <Footer />
    </div>

</template>

<script>
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
import Spinner from './components/Spinner.vue'
export default {
    name:'App',
    components: {
        Header,
        Footer,
        Spinner
    }
}




</script>

<style>
</style>