<template>
<main>
    <form class="w-50 mx-auto text-center" @submit.prevent="updateCode">
        <h1>Modifier un qr-code</h1>
    
         <div class="errors-container">
    
             <p v-if="Object.entries($store.state.errors)">
                <ul>
                    <li class="alert alert-danger" v-for="error in $store.state.errors" :key="error">{{ error.error }} </li>
                </ul>
            </p>
           
            
        </div>
        <div class="input-group input-group-md mb-3">
  <span class="input-group-text" id="qrcodeName">Nom à donner au Qrcode (usage interne)<span>*</span></span> 
  <input type="text" v-model="qrcode.name" class="form-control" aria-label="name input" aria-describedby="qrcodeName">
</div>
  <div class="input-group mb-3">
  <label class="input-group-text" for="inputGroupSelect01">Format</label>
  <select v-model="qrcode.format" class="form-select" id="inputGroupSelect01">
    <option>Choisir ...</option>
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
  <input type="text" class="form-control" v-model="qrcode.text" aria-label="Text input" aria-describedby="qrcodeText">
</div> 
  <div class="mb-3 d-flex align-items-stretch">
    <span class="input-group-text w-75" id="qrcodeBackground">Couleur de fond</span><input type="color" v-model="qrcode.background" class="align-items-stretch w-25" id="qrcodeBackgroundColor" aria-describedby="qrcodeBackground">
  </div>
<div class="mb-3 d-flex">
    <span class="input-group-text w-75" id="qrcodeForeground">Couleur principale</span><input type="color" v-model="qrcode.foreground" class="w-25" id="qrcodeForegroundColor" aria-describedby="qrcodeBackground">
  </div>
  <div class="input-group input-group-md mb-3">
  <span class="input-group-text" id="qrcodeSize">Taille en pixels</span>
  <input type="number" class="form-control" v-model="qrcode.size" aria-label="Sizing input" aria-describedby="qrcodeSize">
</div>
<div class="input-group input-group-md mb-3">
  <span class="input-group-text" id="qrcodeExpiration">Programmer une date de suppression du code</span>
  <input type="date" class="form-control" v-model="qrcode.expires_at" aria-label="expiration date input" aria-describedby="qrcodeExpiration">
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
    <!-- <img id="myImage" :src="qrcodePath" alt="" title="" /> -->
   
</div>
</main>
    
</template>

<script>
export default {
    name:'CodeUpdate',
    data() {
        return {
            users:[]
        }
    },
    created() {
        this.$store.commit('resetErrors');
        this.addRows();
  
    },
    beforeUnmount() {
         this.$store.commit('resetErrors');
    },
    computed: {
        qrcode() {
          let code = this.$store.state.qrcodesDisplayed['owned'].filter(code=> {
          return code.id == this.$route.params.id;
        })
       
          return code[0]
        },
        qrcodePath: function() {
         let size = this.qrcode.size ?? '100';
         let format = this.qrcode.format ?? '';
         let bgcolor=this.qrcode.background ? this.qrcode.background.substring(1):""; 
         let color=this.qrcode.foreground ? this.qrcode.foreground.substring(1):""; 
     
           return `https://api.qrserver.com/v1/create-qr-code/?data=${this.qrcode.text}&size=${size}x${size}&format=${format}&bgcolor=${bgcolor}&color=${color}`
      
         }
    },
    methods: {
        addRows() {
             let usersToPopulate = this.qrcode.shared_with;
             usersToPopulate.forEach(user=> {
               this.users.push({mail:user.email});
             })
            
        },
         addRow() {
             this.users.push({mail:''});
           
            
        },
        deleteRow(index) {
             this.users.splice(index, 1);
        },
        updateCode() {
          let id = this.$route.params.id;
        const data = {
                    id:id,
                    url:this.qrcodePath,
                    name:this.qrcode.name,
                    users:this.users,
                   expires_at:this.qrcode.expiration,
                   format:this.qrcode.format,
                   text:this.qrcode.text,
                   size:this.qrcode.size,
                   background:this.qrcode.background,
                   foreground:this.qrcode.foreground
            }
            console.log(data);
            
            this.$store.commit('changeLoadingStatus', true);
            this.$store.dispatch('handleUpdateCode', data);  
    }
}
}
</script>