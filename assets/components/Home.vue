<template>
<main>
    <section class="my-auto content-container text-center">
    <header>
       <h1 class="d-inline-block border border-dark rounded p-3 m-2"> <i class="fas fa-qrcode"></i> Mes codes</h1>
    </header>
    <div class="new-code">
        <router-link to="/new" class="btn btn-outline-success ml-4">Créer un qrcode</router-link>
       
    </div>
    <section class="d-flex">
        <section class="w-50">
            <h3> <i class="fas fa-check-circle"></i> Mes codes créés</h3>
            
            <ul v-for="qrcode in $store.state.qrcodesDisplayed['owned']" :key="qrcode.id" class="my-4 list-group list-group-flush w-100 ">
       
                <li class="list-group-item d-flex align-items-center mx-3" :id="qrcode.id">
                    <figure>
                        <img :src="qrcode.url" alt="" class="list-image" :title="qrcode.name" />
                            <!-- <img :src="qrcode.url" alt="qrtag"> -->
                    </figure>
                    <figcaption class="d-flex flex-column p-3 justify-content-center align-items-center">
                            <section class="d-flex justify-content-between w-100 align-items-center">
                                <a style="color:grey" :href="`/qrcodes/${qrcode.id}`" class="ml-4 fs-3">{{ qrcode.name }}  </a>
                                <article class="list-icons">
                                    <router-link :to="`/update/${qrcode.id}`"><i class="fas fa-edit px-2"></i></router-link>
                                    <span @click="downloadFile($event)"><i class="fas fa-download"></i></span>
                                    <router-link to="/delete" @click="deleteCode($event)"><i class="fas fa-trash px-2"></i></router-link>   
                                </article>
                            </section>
                            
                           <section class="d-flex justify-content-between align-items-center w-100">
                            <span class="badge mb-2 mr-2 color-secondary badge bg-secondary text-wrap ">
                                {{formatDate(qrcode.created_at)}}
                            </span>
                            <span v-if="qrcode.expires_at" class="badge mb-2 ml-2  bg-danger text-wrap">
                                Expire : {{formatDate(qrcode.expires_at)}}
                            </span>
                           </section>
                            
                    </figcaption>
                </li>   
                <p v-if="!$store.state.qrcodesDisplayed['owned']">Vous n'avez pas encore de qrcode, cliquez sur "Créer un qrcode" pour créer votre premier code !</p>
       
            </ul>
        </section>
        <section class="w-50">
            <h3> <i class="fas fa-check-circle"></i> Mes codes partagés</h3>
            <ul v-for="qrcode in $store.state.qrcodesDisplayed['shared']" :key="qrcode.id" class="my-4 list-group list-group-flush w-100">
        
                    <li class="list-group-item d-flex align-items-center mx-3" :id="qrcode.id">
                    <figure>
                        <img :src="qrcode.url" alt="" class="list-image" :title="qrcode.name" />
                            <!-- <img :src="qrcode.url" alt="qrtag"> -->
                    </figure>
                    <figcaption class="d-flex flex-column p-3 justify-content-center align-items-center">
                            <section class="d-flex justify-content-between w-100 align-items-center">
                                <a style="color:grey" :href="`/qrcodes/${qrcode.id}`" class="ml-4 fs-3">{{ qrcode.name }}  </a>
                                <article class="list-icons">
                                    <span @click="downloadFile($event)"><i class="fas fa-download"></i></span>             
                                </article>
                            </section>
                            
                           <section class="d-flex justify-content-between align-items-center w-100">

                            <span class="badge mb-2 ml-2  bg-secondary text-wrap">
                                 {{qrcode.author.email}}
                            </span>
                            <span v-if="qrcode.expires_at" class="badge mb-2 ml-2  bg-danger text-wrap">
                                Expire : {{formatDate(qrcode.expires_at)}}
                            </span>
                           </section>
                            
                    </figcaption>
                </li>   
                <p v-if="!$store.state.qrcodesDisplayed['shared']">Vous n'avez pas encore de qrcode, cliquez sur "Créer un qrcode" pour créer votre premier code !</p>
       
                </ul>
        </section>
    </section>
    
   
    
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
    width:4em;
    height:4em;
}
.list-group-item {
    background: #cccccc;
}

.list-icons {
    font-size: 1.2em;
    color:grey;
}

h3 i {
    color:green;
}

.list-group-item figcaption {
    flex-grow: 1;
}

</style>
