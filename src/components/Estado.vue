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
								<th class="text-center">Cod. Materia</th>
								<th class="text-center">Materia</th>
								<th class="text-center">Fecha Final</th>
								<th class="text-center">Modalidad</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="materia in carrera.materias">
								<td class="text-center">{{materia.codigo_materia}}</td>
								<td class="text-center">{{materia.nombre_materia}} ({{materia.codigo_materia}})</td>
								<td class="text-center">{{materia.fecha_final | fechaConFormato}}</td>
								<td class="text-center">{{materia.modalidad}}</td>
								<td class="text-center">
									<a 	v-bind:disabled="!periodoFinalizado" 
											class="btn btn-success" 
											v-on:click="periodoFinalizado ? abrirComprobante(materia.url_codigo_operacion, materia):null"
											:data-toggle="!periodoFinalizado?'tooltip':null" data-placement="left" :title="!periodoFinalizado?'Disponible cuando finalice el periodo de inscripción':''">
										Abrir Comprobante
									</a>
								</td>
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
				fecha: null,
			}
		},
		components: {
			ModalNotificacion,
			ModalComprobante
		},
		methods: {
			getFechaServidor() {
				var urlFechaServidor = url + "fecha.php";
				axios.get(urlFechaServidor)
					.then( resp => {
						this.fecha = new Date(resp.data);
					})
					.catch( err => {
						console.log(err);
						this.modalMensaje = 'Error en el servidor';
						$("#modal-final").modal();
					});
			},
			getCarreras() {
				var legajo = this.legajo;
				var urlEstadoInscripcion = url + "estadoInscripcion.php";
				var token = localStorage.getItem('token');
				axios.get(urlEstadoInscripcion, {
					params:{
						legajo: legajo,
						token: token,
					}
				}).then( res => {
					this.carreras = res.data;
				}).catch( err => {
					let codigo_error = err.response.status;
					this.modalMensaje = err.response.data.mensaje;
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
		computed: {
			periodoFinalizado(){
				let fecha_final = new Date(this.$store.state.fechas.fecha_fin);
				let fecha_hoy = new Date(this.fecha);
				console.log('fecha final: ' + fecha_final);
				console.log(fecha_hoy);
				return fecha_hoy.getTime() > fecha_final.getTime();
			},
		},
		mounted: function() {
			this.getLegajo();
			this.getCarreras();
			this.getFechaServidor();
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
