<template>
    <div>
        <h2>Welcome home</h2>
        <button @click="counter++"> Click me {{counter}} </button>
        <Register />
    </div>

</template>

<script>
import Register from './components/register';

export default {
    name: 'App',
    components: {
        Register
    },
    data: ()=> ({
        counter: 0
    })
}

</script>

<style>
</style>