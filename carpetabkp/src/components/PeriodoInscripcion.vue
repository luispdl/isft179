<template>
	<div class="container" style="margin-top: 50px;">
		<h2>Panel de ingreso del Período de Inscripción a los Finales</h2>
		<form class="form-horizontal" style="margin-top: 40px;">
			<div class="form-group">
				<label class="control-label col-sm-5">Ingrese fecha de INICIO: </label>
				<div class="col-sm-3">
				<input class="form-control" v-model="fecha_inicio" type="date" name="fecha" :min="fechaMin">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-5">Ingrese fecha de FIN: </label>
				<div class="col-sm-3">
				<input class="form-control" v-model="fecha_fin" type="date" name="fecha" :min="fechaMin">
				</div>
			</div>
			<div class="text-center">
				<button @click="guardarPeriodo" type="button" class="btn btn-primary" style="margin-top: 15px;">Cargar</button>
			</div>
			
		</form>
	<modal-notificacion :claseModal="modalClase" :tituloModal="modalTitulo" :mensajeRespuesta="modalMensaje" :redireccion="modalRedireccion"></modal-notificacion>

	</div>


</template>


<script>

	import axios from 'axios';
	import configUrl from '../services/config.js';
	import ModalNotificacion from './ModalNotificacion.vue';

	var url = configUrl.apiUrl;

	export default {
		name:'periodo_inscripcion',
		data(){
			return {
				hoy: (new Date()).toLocaleDateString(),
				fecha_inicio: '',
				fecha_fin: '',
				modalClase: 'bg-success',
				modalTitulo: 'Operación Exitosa',
				modalMensaje: '',
				modalRedireccion: 'periodo_inscripcion'
			}
		},
		components: {
			ModalNotificacion
		},
		computed: {
			fechaMin() {
				let hoy = new Date();
				var d = hoy.getDate();
    		var m = hoy.getMonth() + 1;
    		var y = hoy.getFullYear();
    		return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
			}
		},
		methods: {
			guardarPeriodo(){
				var token = localStorage.getItem('token');
				var urlPeriodo = url + 'cargarPeriodo.php';
				var formData = new FormData();
				formData.append('fecha_inicio', this.fecha_inicio);
				formData.append('fecha_fin', this.fecha_fin);
				formData.append('token', token);
				if (this.fecha_inicio < this.fecha_fin){
					axios({
						method: 'post',
						url: urlPeriodo,
						data: formData
					}).then(response => {
						this.modalClase = 'bg-success';
						this.modalTitulo = 'Operación exitosa';
						this.modalMensaje = response.data.mensaje;
						this.$store.state.fechas.fecha_inicio = this.fecha_inicio;
						this.$store.state.fechas.fecha_fin = this.fecha_fin;
						$('#modal-final').modal();
					}).catch(err => {
						this.modalClase = 'bg-danger';
						this.modalTitulo = 'Operación fallida';
						this.modalMensaje = err.response.data.mensaje;
						$('#modal-final').modal();
					});
				} else {
					this.modalClase = 'bg-danger';
					this.modalTitulo = 'Operación fallida';
					this.modalMensaje = 'Ingreso de fechas invalidas, intentar nuevamente. ';
					$('#modal-final').modal();
				}
			},
		},
	}
</script>
