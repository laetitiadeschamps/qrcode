<template>
<main>
    <form class="w-50 mx-auto text-center" @submit.prevent="createCode">
        <h1>Créer un qr-code</h1>
         <div class="errors-container">
    
             <p v-if="Object.entries($store.state.errors)">
                <ul>
                    <li class="alert alert-danger" v-for="error in $store.state.errors" :key="error">{{ error.error }} </li>
                </ul>
            </p>
           
            
        </div>
        <div class="input-group input-group-md mb-3">
  <span class="input-group-text" id="qrcodeName">Nom à donner au Qrcode (usage interne)<span>*</span></span> 
  <input type="text" v-model="name" class="form-control" aria-label="name input" aria-describedby="qrcodeName">
</div>
  <div class="input-group mb-3">
  <label class="input-group-text" for="inputGroupSelect01">Format</label>
  <select v-model="format" class="form-select" id="inputGroupSelect01">
    <option selected>Choisir ...</option>
    <option value="svg">SVG</option>
    <option value="png">PNG</option>
    <option value="jpg">JPG</option>
    <option value="jpeg">JPEG</option>
    <option value="gif">GIF</option>
    <option value="eps">EPS</option>
  </select>
</div>
  <div class="input-group input-group-md mb-3">
  <span class="input-group-text" id="qrcodeText">Texte à encoder<span>*</span> </span>
  <input type="text" v-model="text" class="form-control" aria-label="Text input" aria-describedby="qrcodeText">
</div> 
  <div class="mb-3 d-flex align-items-stretch">
    <span class="input-group-text w-75" id="qrcodeBackground">Couleur de fond</span><input type="color" v-model="background" class="align-items-stretch w-25" id="qrcodeBackgroundColor" aria-describedby="qrcodeBackground">
  </div>
<div class="mb-3 d-flex">
    <span class="input-group-text w-75" id="qrcodeForeground">Couleur principale</span><input type="color" v-model="foreground" class="w-25" id="qrcodeForegroundColor" aria-describedby="qrcodeBackground">
  </div>
  <div class="input-group input-group-md mb-3">
  <span class="input-group-text" id="qrcodeSize">Taille en pixels</span>
  <input type="number" v-model="size" class="form-control" aria-label="Sizing input" aria-describedby="qrcodeSize">
</div>
<div class="input-group input-group-md mb-3">
  <span class="input-group-text" id="qrcodeExpiration">Programmer une date de suppression du code</span>
  <input type="date" v-model="expiration" class="form-control" aria-label="expiration date input" aria-describedby="qrcodeExpiration">
</div>
<div>
 <p>Partager mon code : </p>
  <div class="form-group row">
          <div class="col-lg-12">
            <button type="button" @click="addRow" class="btn btn-outline-secondary">Ajouter un contact</button>
          </div>
</div>
 <div class="form-group row" v-for="(user, index) in users" :key="user.id">
          <div class="col-lg-9">
            <input type="text" v-model="user.mail" :name="'user[' + index + '][mail]'" class="form-control" placeholder="email du contact">
          </div>
           <div class="col-lg-3">
            <button type="button" @click="deleteRow(index)" class="btn btn-outline-danger rounded-circle">
              <i class="fa fa-times"></i>
            </button>
          </div>
 </div>

  
  
</div>
  <div class="mt-4">
       <button type="submit" class="btn btn-outline-success">Générer</button>
  </div>
 
</form>
<div class="w-50 mx-auto text-center preview">
<h5>Aperçu</h5>
    <img id="myImage" :src="qrcodePath" alt="" title="" />
   
</div>
</main>
    
</template>

<script>
export default {
    name:'CodeCreation',
    props: {
        background:'',
        foreground:'',
        size:0,
        name:'',
        expiration:null, 
        text:'',
        format:'',
        users:[]

    },
    data() {
        return {
            users:[]
        }
    },
    created() {
        this.$store.commit('resetErrors');
        this.addRow();
    },
    beforeUnmount() {
         this.$store.commit('resetErrors');
    },
    computed: {
        qrcodePath: function() {
        let size = this.size ?? '100';
        let format = this.format ?? '';
        let bgcolor=this.background ? this.background.substring(1):""; 
        let color=this.foreground ? this.foreground.substring(1):""; 
          console.log(bgcolor);
          return `https://api.qrserver.com/v1/create-qr-code/?data=${this.text}&size=${size}x${size}&format=${format}&bgcolor=${bgcolor}&color=${color}`
          //return `https://api.qrserver.com/v1/create-qr-code/?data=Hello&size=200x200&bgcolor=0000ff`
        }
    },
    methods: {
        addRow() {
            console.log(this.users);
            this.users.push({mail:''});
        },
        deleteRow(index) {
             this.users.splice(index, 1);
        },
        async createCode() {
        this.$store.commit('resetErrors');
           if(!this.text) {
                this.$flashMessage.show({
                                type: 'error',
                                title: 'Le texte à encoder doit être renseigné',
                                message: 'Le texte à encoder doit être renseigné'
                            });
                    return;
            } 
            const image = await fetch(this.qrcodePath);
            const imageBlog = await image.blob()
            const imageURL = URL.createObjectURL(imageBlog)
            const data = {
                    url:imageURL,
                    name:this.name,
                    users:this.users,
                   expires_at:this.expiration,
            }
            console.log(data);
            this.$store.commit('changeLoadingStatus', true);
            this.$store.dispatch('handleNewCode', data);   
        }
        
    }
}
</script>