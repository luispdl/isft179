<template>
	<div class="container" id="cajon-respuesta2">
		<div style="margin-top: 10px;" class="panel-group hidden-print" id="panel-estado-inscripcion">
			<div v-for="carrera in carreras" class='panel panel-info'>
				<div class='panel-heading'>
					<strong>{{carrera.nombre_carrera}}</strong> (cod. {{carrera.codigo_carrera}})
				</div>
				<div class='panel-body'>
					<table class='table table-striped'>
						<thead>
							<tr>
								<th class="text-center">Materia</th>
								<th class="text-center">Fecha Final</th>
								<th class="text-center">Modalidad</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="materia in carrera.materias">
								<td>{{materia.nombre_materia}} ({{materia.codigo_materia}})</td>
								<td>{{materia.fecha_final | fechaConFormato}}</td>
								<td>{{materia.modalidad}}</td>
								<td><a class="btn btn-link" v-on:click="abrirComprobante(materia.url_codigo_operacion, materia)">Abrir Comprobante</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<modal-notificacion :claseModal="claseModal" tituloModal="No hay inscripciones" :mensajeRespuesta="modalMensaje" redireccion="/"></modal-notificacion>
		<modal-comprobante :url_codigo_operacion="url_codigo_operacion" :materia="materia">
		</modal-comprobante>
  </div>

</template>

<script>
	import axios from 'axios';
	import ModalNotificacion from "./ModalNotificacion.vue";
	import configUrl from '../services/config.js';
	import ModalComprobante from './ModalComprobante.vue';
	  // Import the EventBus we just created.
  import { EventBus } from '../event-bus.js';

	var url = configUrl.apiUrl;

	export default {
		name: 'estado',
		data() {
			return {
				carreras: [],
				legajo:0,
				modalMensaje:'',
				url_codigo_operacion: '',
				materia: '',
				claseModal:"bg-warning",
			}
		},
		components: {
			ModalNotificacion,
			ModalComprobante
		},
		methods: {
			getCarreras() {
				var legajo = this.legajo;
				var urlEstadoInscripcion = url + "estadoInscripcion.php";
				var token = localStorage.getItem('token');
				axios.get(urlEstadoInscripcion, {
					params:{
						legajo: legajo,
						token: token,
					}
				}).then(res=>{
					this.carreras = res.data;
				}).catch(err=>{
					let codigo_error = err.response.status;
					this.modalMensaje = err.response.data.mensaje;
					console.log(codigo_error);
					if(codigo_error == 403){
						EventBus.$emit("cerrar", err.response.data.mensaje);
					} else {
						$("#modal-final").modal();
					}
				});
			},
			getLegajo() {
				this.legajo = JSON.parse(localStorage.getItem('datos')).legajo;
			},
			abrirComprobante(url, materia){
				this.materia = materia;
				this.url_codigo_operacion = url;
				$('#modal-comprobante').modal();
			},
		},
		created(){
		},
		mounted: function() {
			this.getLegajo();
			this.getCarreras();
		},
		filters: {
			fechaConFormato(fecha) {
				let array1 = fecha.split('-');
				let array2 = array1.reverse();
				return array2.join('-');

			}
		}
	}
</script>
<style>

</style>
