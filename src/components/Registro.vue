<template>
	<section class="main container-fluid margen_section text-center">					
    <h3>
     REGISTRO USUARIO
   </h3>

   <div id="registro_alumno" class="col-sm-6 col-sm-offset-3">
    <div>
     <div class="alert-danger" v-if="errors.length !== 0">
      <ol class="login-errors">
       <li v-for="error in errors"> {{ error }}</li>
     </ol>
    </div>
    <form role="form">
      <div class="form-group"  v-if="!preceptor">
        <label for="legajo"> Legajo</label>
        <input v-model="legajo" class="form-control" type="number" id="legajo" name="legajo" placeholder="Legajo">
        <p class="help-block">*Campo requerido como validación</p>
      </div>
   
    <div class="form-group">
      <label for="email">Nombre de Usuario</label>
      <input v-model="nombre_usuario" class="form-control" type="text" id="email" name="email" placeholder="Nombre de Usuario">
    </div>
  
      <div class="form-group">
          <label for="username">Email</label>
         <input v-model="email" class="form-control" type="text" id="username" name="username" placeholder="Email">
      </div>
      <div class="form-group">
        <label for="psw">Contraseña</label>
        <input v-model="password" class="form-control" type="password"  id="psw" placeholder="Contraseña">
      </div>

      <div class="form-group">
        <label for="psw2">Repetir Contraseña</label>
        <input v-model="password2" class="form-control" type="password" id="psw2" placeholder="Repetir Contraseña">
      </div>
      <div class="form-group">
        <button @click="registrar" type="button" class="btn btn-primary btn-md" id="enviar_legajo">
          <span class="glyphicon glyphicon-off"></span>
            Registrar
        </button>
        <router-link v-if="preceptor" class="btn btn-danger" to="/">Salir</router-link>
      </div>
    </form>
    </div>
    </div>
    <modal-notificacion :claseModal="claseModal" :tituloModal="tituloModal" :redireccion="redireccion" :mensajeRespuesta="mensajeModal"></modal-notificacion>
	</section>
</template>

<script>
	import axios from 'axios';
	import configUrl from '../services/config.js';
	import ModalNotificacion from './ModalNotificacion.vue';

	var url = configUrl.apiUrl;

export default {

  name: 'registro',
  data () {
    return {
    	password:'',
    	legajo:null,
    	nombre_usuario:'',
      email:'',
    	password2:'',
    	errors:[],
    	numero_documento: this.$route.params.usuario,
    	claseModal:"alert-danger",
    	tituloModal:"Error",
    	redireccion: "/",
    	mensajeModal: "",
      preceptor:false
    };
  },
  components:{
  	ModalNotificacion,
  },
  methods: {
  	validar() {
  		if(this.password.length < 8 ) {
  			this.errors.push('La contraseña tiene que tener un mínimo de 8 caracteres');
  		}
  		if(this.password != this.password2) {
  			this.errors.push('Las contraseñas deben ser iguales');
  			this.password = '';
  			this.password2 = '';
  		}
  	},
  	registrar() {
  		var token = localStorage.getItem('token');
  		var urlRegistrar = url + 'registrar.php';
      this.errors = [];
  		this.validar();
  		if (this.errors.length == 0){
  			var formData = new FormData();
        if (!this.preceptor) {
          formData.append('legajo', this.legajo);
        }
  			formData.append('nombre_usuario', this.nombre_usuario);
        formData.append('email', this.email);
  			formData.append('password', this.password);
  			formData.append('token', token);
  			formData.append('numero_documento', this.numero_documento);
        console.log(this.numero_documento);
  			axios({
  				method: 'post',
  				data: formData,
  				url: urlRegistrar,
  			}).then( response => {
          console.log(response);
          this.claseModal ="alert-success";
          this.tituloModal = "Excelente";
          this.mensajeModal = "Se registró exitosamente!!";
  				this.redireccion = "/login";
          $("#modal-final").modal();
   			}).catch( error => {
          console.log(error);
  				this.claseModal ="alert-danger";
  				this.tituloModal = "Error";
  				this.mensajeModal = error.response.data.mensaje;
  				this.redireccion = "'/registro/" + this.$route.params.usuario;
  				$("#modal-final").modal();
  			});
  		}
  	},
  },
  created() {
    if(this.$route.params.usuario == 'preceptor') {
      this.preceptor = true;
    }
  }
};
</script>

<style lang="css" scoped>
.margen_section{
    margin-top: 10px;
    margin-bottom: 10px;
    height: 100%;
    border-bottom: 1px solid silver;
  }
  form {
    min-height: 210px;
    border-radius: 10px;
    border-style: solid;
    border-top: solid 15px rgba(0,0,255,0.5);
    border-bottom: solid 1px rgba(0,0,255,0.5);
    border-left: solid 1px rgba(0,0,255,0.5);
    border-right: solid 1px rgba(0,0,255,0.5);
  }
  .form-group {
    margin-right: 10px;
    margin-left: 10px;
  }
</style>
