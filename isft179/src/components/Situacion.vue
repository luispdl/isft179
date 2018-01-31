<template>
	<div class="container" id="cajon-respuesta3">
		<ul  class="nav nav-tabs" id="pestanas_academica" style="margin-top: 10px;">
			<li v-for="carrera in carreras">
				<a data-toggle='tab' v-bind:href="'#'+carrera.codigo_carrera">
					<h5>{{carrera.nombre_carrera}} ({{carrera.codigo_carrera}})</h5>
				</a>
			</li>
		</ul>
		<div id="cajon_pestanas_academica" class="tab-content">
			<div v-for="carrera in carreras" v-bind:id="carrera.codigo_carrera" class='tab-pane fade'>
				<table class='table'>
					<thead>
						<tr>
							<th class='text-center'>Cod. Materia</th>
							<th class='text-center'>Materia</th>
							<th class='text-center'>Fecha Regular</th>
							<th class='text-center'>Fecha Final</th>
							<th class='text-center'>Nota Final</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="materia in carrera.materias"  v-bind:class="[materia.fecha_regular!=null?(materia.fecha_final==null || materia.nota_final<4)?'regularizado':'aprobado':'noaprobado']">
							<th><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="left" :title="materia.correlativas?'Correlativas:' + materia.correlativas.join('-'):'No posee correlativas'"></i>  Cod. {{materia.codigo_materia}}</th>
							<th>{{materia.nombre_materia}}</th>
							<th class="text-center">{{materia.fecha_regular || 'NO REGULARIZO' | fechaConFormato}}</th>
							<th class="text-center">{{materia.fecha_final || (materia.fecha_regular==null?'-':'NO RINDIO') | fechaConFormato}}</th>
							<th class="text-center">{{materia.fecha_final==null?'-':materia.nota_final}}</th>
						</tr>
					</tbody>
				</table>
			</div>
			<ring-loader class="cargando" :loading="loading"></ring-loader>
		</div>

	</div>
</template>
<script>

	import axios from 'axios';
	import configUrl from '../services/config';
	import RingLoader from 'vue-spinner/src/RingLoader.vue';

	var url = configUrl.apiUrl;

	export default{
		name:"situacion",
		data(){
			return{
				carreras: [],
				legajo:0,
				loading: true,
			}
		},
		components: {
			RingLoader,
		},
		methods: {
			getCarreras() {
				var token = localStorage.getItem('token');
				var legajo = this.legajo;
				var urlSituacion = url +'situacionAcademica.php'
				axios.get(urlSituacion,{
					params: {
						legajo: legajo,
						token: token
					}
				}).then(res => {
					console.log(res.data);
					this.carreras = res.data;
					this.loading = false;
				}).catch(err => {
				})
			},
			getLegajo() {
				this.legajo = JSON.parse(localStorage.getItem('datos')).legajo;
			}
		},
		mounted() {
			this.getLegajo();
			this.getCarreras();
		},
		updated: function() {
    	$("#pestanas_academica a:first").tab('show');
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
	.cargando {
		display: inline-block;
	}
	.aprobado {
		background: rgba(193, 250, 192,0.7);
	}
	.regularizado{
		background: rgba(193, 250, 192,0.3);
	}
	.noaprobado{
		background: rgba(247, 106, 86,0.5);
	}
</style>
