<template>
	<section class="main container margen_section" id="login">
		<div class="row">
			<div class="cd-md-12 cd-xs-12">
				<div role="tabpanel" >
					<div class="col-xs-12 col-sm-12" >
					<ul class="nav nav-tabs 2" role="tablist">
						<li role="presentacion" class="active"><a href="#parte1" aria-controls="parte1" data-toggle="tab" role="tab" >Iniciar Sesión</a></li>

					</ul>
					<div class="tab-content">
							<div class="alert-danger" v-if="errors.length !== 0">
								<ol class="login-errors">
								<li v-for="error in errors"> {{ error }}</li>
								</ol>
							</div>
						<!-- Contenido del sistema para entrar a la aplicacion-->
						<div role="tabpanel" class="tab-pane text-center inscripcion well active cd-xs-3 cd-md-12 " id="parte1">
        						<label> Usuario: </label>
        						<div class="form-group">
        							<input v-model="usuario" type="text" name="usuario" placeholder="Usuario" style="text-align: center;">
        						</div>
        						<label> Contraseña:</label>
        						<div class="form-group">
        							<input v-model="password" type="password" minlength="8" placeholder="Contraseña" style="text-align: center;">
        						</div>
        						<div class="form-group">
        							<button @click="iniciarSesion" type="button" class="btn btn-primary btn-md" id="enviar">Iniciar</button>
        						</div>
        				</div>
					</div>
					</div>
				</div>
			</div>
		</div>
		<modal-notificacion
			:claseModal="claseModal"
			:tituloModal="tituloModal"
			:mensajeRespuesta="mensajeRespuesta"
			:redireccion="redireccion">
		</modal-notificacion>
	</section>

</template>

<script>
	import axios from 'axios';
	import configUrl from '../services/config.js';
	import ModalNotificacion from './ModalNotificacion.vue';
	var url = configUrl.apiUrl;

export default {
	name:'login',
	data () {
		return {
			usuario:null,
			errors: [],
			password: null,
			claseModal:"alert-danger",
			tituloModal:"Error",
			mensajeRespuesta:"",
			redireccion:"/",
		}
	},
	components: {
		ModalNotificacion
	},
	methods: {
		iniciarSesion(){
			var token = localStorage.getItem('token');
			var formData = new FormData();
			formData.append('usuario', this.usuario);
			formData.append('password', this.password);
			formData.append('token', token);
			console.log(formData);
			if (this.validarFormulario) {
				var urlIniciarSesion = url + 'login.php';
				axios({
					method: 'POST',
					url: urlIniciarSesion,
					data: formData,
				}).then( response => {
					let estado = response.data.estado;
					if(estado == "iniciar") {
						localStorage.setItem('datos', JSON.stringify(response.data.datos));
						localStorage.setItem('token', response.data.token);
						this.$emit('iniciar');
					} else if(estado =="registrar") {
						this.$router.push({path:`/registro/${this.usuario}`});
					}
				}).catch( error => {
					console.log(error.response);
					this.mensajeRespuesta = error.response.data.mensaje;
					$('#modal-final').modal();
				});
			}

		},
		validarFormulario() {
			return true;
		},
	}
}

</script>
<style scoped>
	.margen_section{
	  margin-top: 10px;
	  margin-bottom: 10px;
	  width: 80%;
	  height: 100%;
	  border-bottom: 1px solid silver;
	}

	.inscripcion{
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
