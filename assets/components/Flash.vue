<template>
 
   <!-- <ul class="text-center">
        <li class="text-center alert"  v-for="message in $store.state.flashMessages" :class="`alert-${message.type}`" :key="message">{{ message.message }} </li>
    </ul> -->
    <FlashMessage position="left bottom" />
</template>

<style>
ul {
    padding:0;
}
</style>