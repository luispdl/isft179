<template>

<div class="container-fluid" style="margin-top: 5%;">
<div class="row">
	<div class="col-md-12">
	  	<div class="panel-group">
	    	<div class="panel panel-info">
	      		<div class="panel-heading">
	      			<h3>{{tituloCarreras}}</h3>
	      		</div>
	    		<div class="panel-body">
					<div v-for="valor in datosCarreras">
			<!-- en este blocke se renderizan los datos del objeto "datoCarreras" -->
						<p>Carrera: {{valor.nombre}} |  Cantidad: {{valor.cantidad}}</p>
					</div>
				<div id="grafica1"></div>
	     		</div>
	    	</div>
		</div> 
	</div>

	<div class="col-md-12">
		<div class="panel-group">
	    	<div class="panel panel-info">
	      		<div class="panel-heading">
	      			<h3>{{tituloMaterias}}</h3>
	      		</div>
	      		<div class="panel-body">
					<div v-for="valor in datosMaterias">
						<p>Materia: {{valor.nombre}} |  Cantidad: {{valor.cantidad}}</p>
					</div>
					<div id="grafica2"></div>
	    		</div>
	    	</div>
		</div> 
	</div>
	
	<div class="col-md-12">
	  	<div class="panel-group">
	    	<div class="panel panel-info">
	     		<div class="panel-heading">
	      			<h3>{{tituloMesas}}</h3>
	      		</div>
	     		<div class="panel-body">
					<div v-for="valor in datosMesas">
						<p>Fecha mesa de final: {{valor.fecha_final}} |  Cantidad: {{valor.cantidad}}</p>
					</div>
				<div id="grafica3"></div>
	     		</div>
	    	</div>
		</div> 
	</div>

</div>
</div>

</template>

<script>

import axios from 'axios';
import configUrl from '../services/config.js';
import RingLoader from 'vue-spinner/src/RingLoader.vue';


var url = configUrl.apiUrl;

export default {
	name: "estadisticas",
	data(){
		return {
			datosCarreras: '',
			datosMaterias: '',
			datosMesas: '',
			tituloCarreras: 'Cantidad de Inscriptos por Carrera',
			tituloMaterias: 'Cantidad de Inscriptos por Materias',
			tituloMesas: 'Cantidad de Inscriptos de fecha por Mesas',
			loading: true,
		}
	},
	components: {
		RingLoader
	},
	methods:{
		getGrafico(){
			var urlPhp = url + 'estadisticas.php';
			axios.get(urlPhp, {
				params: {
				}
			}).then(res => {
					this.respuesta = res.data;
					this.loading = false;
					this.datosCarreras = res.data.PorCarreras;
					this.datosMaterias = res.data.PorMaterias;
					this.datosMesas = res.data.PorMesaExamen;
			});
		},
		morrisCarreras(){
			var temporal1 = {};
			var datos1 = [];
			$.each(this.datosCarreras, function(index, val) {
				temporal1['y'] = val.nombre;
				temporal1['a'] = val.cantidad;
				datos1.push(temporal1);
				temporal1 = {};
			});
			// Este es el objeto Morris.js, donde se declaran los datos que queremos ver en los graficos.
			Morris.Bar({    
				element: 'grafica1',
				data: datos1,
				xkey: ['y'],
				ykeys: ['a'],
				labels: ['Valor'],
			});	
		},
		morrisMaterias(){
			var temporal2 = {};
			var datos2 = [];
			$.each(this.datosMaterias, function(index, val) {
				temporal2['label'] = val.nombre;
				temporal2['value'] = val.cantidad;
				datos2.push(temporal2);
				temporal2 = {};
			});
			Morris.Donut({
				element: 'grafica2',
				data: datos2,
			});	
		},
		morrisMesas(){	
			var temporal3 = {};
			var datos3 = [];
			$.each(this.datosMesas, function(index, val) {
				temporal3['value'] = val.cantidad;
				temporal3['label'] = val.fecha_final;
				datos3.push(temporal3);
				temporal3 = {};
			});
			Morris.Donut({
				element: 'grafica3',
				data: datos3,
			});	
		},
	},
	created(){
		this.getGrafico();
	},
	updated(){
		this.morrisCarreras();
		this.morrisMaterias();
		this.morrisMesas();
	},
}
</script>