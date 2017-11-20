<template>
	<div id="editar" class="container col-md-6 col-md-offset-2">
			<h3 class="col-md-offset-4">Editar Perfil</h3>
			<ul>
				<li v-for="error in errors" class="red">{{error}} </li>
			</ul>
			<form role="form">
				<div class="form-group">
					<label for="email"> Email:</label>
					<input v-model="email" class="form-control" type="email">
					<p class="help-block">*Requerido</p>
				</div>
				<div class="form-group">
					<label for="password_actual"> Contraseña actual:</label>
					<input v-model="password_actual" name="password_actual" class="form-control" type="password" placeholder="Contraseña Actual">
					<p class="help-block">*Requerido</p>
				</div>
				<div class="form-group">
					<label for="password_nuevo"> Nueva Contraseña:</label>
					<input v-model="password_nuevo" name="password_nuevo" class="form-control" type="password" placeholder="Nueva Contraseña">
					<p class="help-block">*Requerido</p>
				</div>
				<div class="form-group">
					<label for="password_repetido"> Repetir Contraseña:</label>
					<input v-model="password_repetido" name="password_repetido" class="form-control" type="password" placeholder="Repetir Contraseña">
					<p class="help-block">*Requerido</p>
				</div>
				<div class="form-group text-center">
					<button type="button" class=" btn btn-primary" @click="modificar">Modificar</button>
					<router-link class="btn btn-danger" to="/">Salir</router-link>
				</div>

			</form>
			<modal-notificacion @cerrar="cerrar" :continuar="continuar" :claseModal="claseModal" :tituloModal="tituloModal" :redireccion="redireccion" :mensajeRespuesta="mensajeRespuesta"></modal-notificacion>
	</div>
</template>

<script>
import configUrl from '../services/config.js';
import axios from 'axios'
import ModalNotificacion from "./ModalNotificacion.vue";

var url = configUrl.apiUrl;

export default {

  name: 'EditarPerfil',

  data () {
    return {
    	email: '',
    	nombre_usuario: '',
    	password_actual: '',
    	password_nuevo: '',
    	password_repetido: '',
    	errors: [],
    	claseModal: '',
    	tituloModal: '',
    	redireccion: '',
    	mensajeRespuesta:'',
      continuar:false,
    }
  },
  components: {
  	ModalNotificacion,
  },
  methods: {
  	getDatos() {
  		this.email = JSON.parse(localStorage.getItem('datos')).email;
  		this.nombre_usuario = JSON.parse(localStorage.getItem('datos')).nombre_usuario;
  	},
  	modificar() {
  		let token = localStorage.getItem('token');
  		this.errors = [];
  		this.validar();
  		if (this.errors.length == 0) {
  			let urlEditar = url + 'editarPerfil.php';
	  		let formData = new FormData();
	  		formData.append('nombre_usuario', this.nombre_usuario);
	  		formData.append('email', this.email);
	  		if(this.password_nuevo.length >0 && this.password_actual.length >0){
	  			formData.append('password_nuevo', this.password_nuevo);
	  			formData.append('password_actual', this.password_actual);
	  			formData.append('nombre_usuario', this.nombre_usuario);
	  		}
	  		formData.append('token', token);
	  		axios({
	  			method: 'POST',
	  			data: formData,
	  			url: urlEditar,
	  		}).then(response => {
	  			this.claseModal = "bg-success";
	  			this.tituloModal = 'Operación exitosa';
	  			this.redireccion = '/';
          this.continuar = true;
	  			this.mensajeRespuesta = 'Se actualizaron los datos correctamente';
	  			$("#modal-final").modal();
	  		}).catch(error => {
	  			this.claseModal = "bg-danger";
	  			this.tituloModal = 'Operación fallida';
	  			this.redireccion = '/';
	  			this.mensajeRespuesta = error.response.data.mensaje;
	  			$("#modal-final").modal();
	  		});
  		}
  	},
  	validar() {
	  	if (this.email.length == 0){
	  		this.errors.push('El email no puede estar vacío');
	  	}
	  	if (this.password_actual.length > 0){
	  		if (this.password_nuevo >0 && this.password_nuevo <8) {
	  			this.errors.push = 'La contraseña debe tener al menos 8 caracteres';
	  		}
	  	}
	  	if (this.password_nuevo != this.password_repetido) {
	  		this.errors.push('Las contraseñas nuevas deben ser iguales');
	  	}
	  	if (this.email == JSON.parse(localStorage.getItem('datos')).email && this.password_actual.length == 0 ) {
	  		this.errors.push("No se realizaron cambios");
	  	}
  	},
  	cerrar() {
  		this.$emit('cerrar');
  	}
  },
  mounted() {
  	this.getDatos();
  }
}
</script>

<style lang="css" scoped>
	.red {
		color: red;
	}	
</style>
