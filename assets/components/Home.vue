<template>
<main>
    <section class="w-50 mx-auto my-auto content-container text-center">
    <header>
       <h1>Mes codes</h1>
    </header>
    <ul v-for="qrcode in $store.state.qrcodesDisplayed['owned']" :key="qrcode.id" class="my-4 list-group list-group-flush w-100 ">
       
        <li class="list-group-item d-flex align-items-center">
            <figure>
                   <img :src="qrcode.url" alt="" class="list-image" title="" />
                    <!-- <img :src="qrcode.url" alt="qrtag"> -->
            </figure>
            <figcaption class="d-flex justify-content-center align-items-center">
                
                    <a :href="`/qrcodes/${qrcode.id}`" class="ml-4">{{ qrcode.name }}  </a>
                    <span><i class="fas fa-edit px-2"></i></span>
                    <a href=""><i class="fas fa-trash px-2"></i></a>
              
               
                    
                <span class="badge mb-2 bg-secondary text-wrap">
                    Crée le {{formatDate(qrcode.created_at)}}
                </span>
                 <span class="badge mb-2 bg-danger text-wrap">
                    Expire le {{formatDate(qrcode.expires_at)}}
                </span>
               
           
           
            </figcaption>
            
        </li>   
        
            <p v-if="!$store.state.qrcodesDisplayed['owned']">Vous n'avez pas encore de qrcode, cliquez sur "Créer un qrcode" pour créer votre premier code !</p>
       
    </ul>
    <div class="new-code">
         <router-link to="/new" class="btn btn-outline-success ml-4">Créer un qrcode</router-link>
       
    </div>
    
</section>
  
    
    
</main>
</template>

<script>

export default({
    name:'Home',
    created() {
        this.$store.commit('changeLoadingStatus', true);
        this.$store.dispatch('getQrcodes');
    },
    methods: {
        formatDate(dateInput) {
            let date = new Date(dateInput);
            let month = date.getMonth()+1;
            let displayMonth = month >9 ? month : '0'+month;
            let displayDay = date.getDate() >9 ? date.getDate() : '0'+date.getDate();

            return displayDay+'-'+displayMonth+'-'+date.getFullYear();
        }
    }
    
})
</script>

<style>


main {
    margin:4em 0;
    min-height:80vh;
}

a {
    text-decoration: none;
    color:inherit; 
}

.list-image {
    width:5em;
    height:5em;
}

</style>