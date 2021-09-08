<template>
<main>
    <form class="w-50 mx-auto text-center">
        <h1>Créer un qr-code</h1>
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
  <span class="input-group-text" id="qrcodeText">Texte à encoder</span>
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
<div class="input-group">
  <div class="input-group-text">
    <input class="form-check-input mt-0" v-model="download" type="radio" value="" aria-label="Radio button for automatic download">
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
        expiration:null, 
        text:'',
        format:'',
        qrcodeUrl:''

    },
    computed: {
        qrcodePath: function() {
        let bgcolor=this.background ? this.background.substring(1):""; 
        let color=this.background ? this.foreground.substring(1):""; 
          console.log(bgcolor);
          return `https://api.qrserver.com/v1/create-qr-code/?data=${this.text}&size=${this.size}x${this.size}&format=${this.format}&bgcolor=${bgcolor}&color=${color}`
          //return `https://api.qrserver.com/v1/create-qr-code/?data=Hello&size=200x200&bgcolor=0000ff`
        }
    }
}
</script>