<template>
	<div id="registro" class="container">
		<div class="container col-md-offset-4 col-md-4">
			<div class="panel-group center-block">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">
							REGISTRO ALUMNO
						</h2>
					</div>
					<div id="registro_alumno" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="alert-danger" v-if="errors.length !== 0">
								<ol class="login-errors">
									<li v-for="error in errors"> {{ error }}</li>
								</ol>
							</div>
							<form role="form">
								<div class="form-group"  v-if="!preceptor">
									<label for="legajo"><span class="glyphicon glyphicon-file"></span> Legajo</label>
									<input v-model="legajo" type="number" class="form-control" id="legajo" name="legajo" placeholder="Legajo">
								</div>
                <div class="form-group">
                  <label for="email"><span class="glyphicon glyphicon-user"></span> Nombre de Usuario</label>
                  <input v-model="nombre_usuario" type="text" class="form-control" id="email" name="email" placeholder="Nombre de Usuario">
                </div>
								<div class="form-group">
									<label for="username"><span class="glyphicon glyphicon-user"></span> Email</label>
									<input v-model="email" type="text" class="form-control" id="username" name="username" placeholder="Email">
								</div>
								<div class="form-group">
									<label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Contraseña</label>
									<input v-model="password" type="password" class="form-control" id="psw" placeholder="Contraseña">
								</div>
								<div class="form-group">
									<label for="psw2"><span class="glyphicon glyphicon-eye-open"></span> Repetir Contraseña</label>
									<input v-model="password2" type="password" class="form-control" id="psw2" placeholder="Repetir Contraseña">
								</div>
								<button @click="registrar" type="button" class="btn btn-success" id="enviar_legajo">
									<span class="glyphicon glyphicon-off"></span>
									Registrar
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<modal-notificacion :claseModal="claseModal" :tituloModal="tituloModal" :redireccion="redireccion" :mensajeRespuesta="mensajeModal"></modal-notificacion>
	</div>
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
    	password:null,
    	legajo:null,
    	nombre_usuario:null,
      email:null,
    	password2:null,
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
  		if(this.pass != this.pass2) {
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
  			axios({
  				method: 'post',
  				data: formData,
  				url: urlRegistrar,
  			}).then( response => {
          this.claseModal ="alert-success";
          this.tituloModal = "Excelente";
          this.mensajeModal = "Se registró exitosamente!!";
  				this.redireccion = "/login";
   			}).catch( error => {
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
	.container {
		padding:50px 0;
	}
</style>
