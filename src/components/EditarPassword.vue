<template>
	<section class="main container margen_section text-center" id="login">
		<h3>Editar Contraseña de <em>{{$route.params.usuario}}</em></h3>
		<div class="row">
			<div class="alert-danger container row col-sm-6 col-sm-offset-3" v-if="errors.length !== 0">
				<ul class="login-errors">
					<li v-for="error in errors"> {{ error }}</li>
				</ul>
			</div>
			<div class="cd-md-12 cd-xs-12">
				<!-- Contenido del sistema para entrar a la aplicacion-->
				<div role="tabpanel" class="tab-pane text-center formulario well active cd-xs-3 cd-md-12 ">
					<label> Contraseña:</label>
					<div class="form-group">
						<input v-model="password" type="password" minlength="8" placeholder="Contraseña" style="text-align: center;">
					</div>
					<label> Repetir Contraseña: </label>
					<div class="form-group">
						<input v-model="password2" type="password" name="password2" placeholder="Repetir Contraseña" style="text-align: center;">
					</div>
					<div class="form-group">
						<button @click="modificar" type="button" class="btn btn-primary btn-md" id="enviar">Modificar</button>
					</div>
				</div>

			</div>
		</div>
		<modal-notificacion :continuar="continuar" :claseModal="claseModal" :tituloModal="tituloModal" :redireccion="redireccion" :mensajeRespuesta="mensajeRespuesta"></modal-notificacion>
	</section>
</template>

<script>
import configUrl from '../services/config.js';
import axios from 'axios';
import ModalNotificacion from './ModalNotificacion.vue';

var urlEditarPassword = configUrl.apiUrl + 'editarPassword.php';

export default {

  name: 'EditarPassword',

  data () {
    return {
    	errors:[],
    	password:'',
    	password2:'',
    	tituloModal:'',
    	claseModal:'',
    	mensajeRespuesta:'',
    	redireccion:'',
    	continuar:false,
    }
  },
  components: {
  	ModalNotificacion,
  },
  methods: {
  	modificar() {
  		let token = localStorage.getItem('token');
  		let formData = new FormData();
  		this.errors = [];
  		this.validar();
  		if(this.errors.length == 0 ){
  			formData.append('password', this.password);
  			formData.append('token', token);
  			formData.append('nombre_usuario', this.$route.params.usuario);
  			axios({
					method: 'POST',
					url: urlEditarPassword,
					data: formData,
				}).then( response => {
					this.tituloModal = 'Operación exitosa';
          this.claseModal = 'bg-success';
          this.mensajeRespuesta = response.data.mensaje;
					this.redireccion = '/';
					$("#modal-final").modal()
				}).catch( error => {
					this.tituloModal = 'Operación fallida';
          this.claseModal = 'bg-danger';
					this.mensajeRespuesta = error.response.data.mensaje;
					this.redireccion = '/';
					$('#modal-final').modal();
				});
  		}
  		
  	},
  	validar() {
  		if(this.password != this.password2) {
  			this.errors.push('La contraseñas deben ser iguales');
  		}
  		if(this.password.length < 8 ){
  			this.errors.push('La contraseña debe tener al menos 8 caracteres');
  		}
  	},
  }
}
</script>

<style lang="css" scoped>

.margen_section{
	  margin-top: 10px;
	  margin-bottom: 10px;
	  width: 80%;
	  height: 100%;
	  border-bottom: 1px solid silver;
	}

	.formulario{
		width: 300px;
	  height: 210px;
	  border-radius: 10px;
	  border-style: solid;
	  border-top: solid 15px rgba(0,0,255,0.5);
	  border-bottom: solid 1px rgba(0,0,255,0.5);
	  border-left: solid 1px rgba(0,0,255,0.5);
	  border-right: solid 1px rgba(0,0,255,0.5);
	  margin: auto;
		margin-top: 10%;
	  margin-bottom: 10%;

	}
</style>