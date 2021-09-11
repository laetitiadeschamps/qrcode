<template>
<main>
    <section class="my-auto content-container text-center">
    <header>
       <h1>Mes codes</h1>
    </header>
    <section class="d-flex">
        <section class="w-50">
            <h3>Mes codes créés</h3>
            <ul v-for="qrcode in $store.state.qrcodesDisplayed['owned']" :key="qrcode.id" class="my-4 list-group list-group-flush w-100 ">
       
                <li class="list-group-item d-flex align-items-center" :id="qrcode.id">
                    <figure>
                        <img :src="qrcode.url" alt="" class="list-image" :title="qrcode.name" />
                            <!-- <img :src="qrcode.url" alt="qrtag"> -->
                    </figure>
                    <figcaption class="d-flex justify-content-center align-items-center">
                        
                            <a :href="`/qrcodes/${qrcode.id}`" class="ml-4">{{ qrcode.name }}  </a>
                            <router-link :to="`/update/${qrcode.id}`"><i class="fas fa-edit px-2"></i></router-link>
                            <span @click="downloadFile($event)"><i class="fas fa-download"></i></span>
                            <router-link to="/delete" @click="deleteCode($event)"><i class="fas fa-trash px-2"></i></router-link>   
                            <span class="badge mb-2 bg-secondary text-wrap">
                                Crée le {{formatDate(qrcode.created_at)}}
                            </span>
                            <span v-if="qrcode.expires_at" class="badge mb-2 bg-danger text-wrap">
                                Expire le {{formatDate(qrcode.expires_at)}}
                            </span>
                    </figcaption>
                </li>   
                <p v-if="!$store.state.qrcodesDisplayed['owned']">Vous n'avez pas encore de qrcode, cliquez sur "Créer un qrcode" pour créer votre premier code !</p>
       
            </ul>
        </section>
        <section class="w-50">
            <h3>Mes codes partagés</h3>
            <ul v-for="qrcode in $store.state.qrcodesDisplayed['shared']" :key="qrcode.id" class="my-4 list-group list-group-flush w-100 ">
        
                    <li class="list-group-item d-flex align-items-center" :id="qrcode.id">
                        <figure>
                            <img :src="qrcode.url" alt="" class="list-image" :title="qrcode.name" />
                                <!-- <img :src="qrcode.url" alt="qrtag"> -->
                        </figure>
                        <figcaption class="d-flex justify-content-center align-items-center">
                            
                                <a :href="`/qrcodes/${qrcode.id}`" class="ml-4">{{ qrcode.name }}  </a>
                               
                                <router-link to="/delete" @click="deleteCode($event)"><i class="fas fa-trash px-2"></i></router-link>   
                                <span class="badge mb-2 bg-secondary text-wrap">
                                    Crée le {{formatDate(qrcode.created_at)}}
                                </span>
                                <span v-if="qrcode.expires_at" class="badge mb-2 bg-danger text-wrap">
                                    Expire le {{formatDate(qrcode.expires_at)}}
                                </span>
                                <span class="badge mb-2 bg-danger text-wrap">
                                    Auteur {{qrcode.author.email}}
                                </span>
                        </figcaption>
                    </li>   
                    <p v-if="!$store.state.qrcodesDisplayed['shared']">Vous n'avez pas encore de qrcode, cliquez sur "Créer un qrcode" pour créer votre premier code !</p>
        
                </ul>
        </section>
    </section>
    
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
        this.$store.commit('resetQrCodes');
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
        },
        async downloadFile(event) {
            let li = event.target.closest("li");
            let url = li.querySelector("img").src;
            const image = await fetch(url)
            const imageBlog = await image.blob()
            const imageURL = URL.createObjectURL(imageBlog)

            const link = document.createElement('a')
            link.href = imageURL
            link.download = li.querySelector("img").title;
            document.body.appendChild(link)
            link.click()
            document.body.removeChild(link)
        },
        deleteCode(event) {
           
                let id = event.target.closest("li").id;
                this.$store.commit('changeLoadingStatus', true);
                this.$store.dispatch('handleDeleteCode', id); 
            
             
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