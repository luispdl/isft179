<template>
	<div class="container text-center">
		<div class="row col-md-12" v-if="(index % 2) == 0" v-for="(noticia, index) in noticias">
			<div class="panel panel-default col-md-5 col-sm-12">
				<div class="panel-heading"><h3><strong>{{ noticia.titulo }}</strong></h3></div>
				<div class="panel-body">
					<img v-if="noticia.imagen" :src="noticia.imagen" class="img-thumbnail img-rounded">
					{{ noticia.contenido }}
				</div>
				<div class="panel-footer">Fecha de creación de noticia: {{ noticia.fecha_creacion | fechaConFormato }}</div>
			</div>
			<div v-if="noticias[(index + 1)]" class="panel panel-default col-md-5 col-sm-12">
				<div class="panel-heading">
					<h3><strong>{{ noticias[(index + 1)].titulo }}</strong></h3>
				</div>
				<div class="panel-body">
					<img v-if="noticias[(index + 1)].imagen" :src="noticias[(index + 1)].imagen" class="img-thumbnail img-rounded">
					{{ noticias[(index + 1)].contenido }}
				</div>
				<div class="panel-footer">Fecha de creación de noticia: {{ noticias[(index + 1)].fecha_creacion | fechaConFormato }}</div>
			</div>
		</div>
		<ring-loader class="cargando" :loading="loading"></ring-loader>
	</div>
</template>

<script>
	import axios from 'axios';
	import configUrl from '../services/config.js';
	import RingLoader from 'vue-spinner/src/RingLoader.vue';
		  // Import the EventBus we just created.
  import { EventBus } from '../event-bus.js';

	var url = configUrl.apiUrl;

	export default {
		name:'home',
		data() {
			return {
				noticias: [],
				contieneImagen: false,
				loading:true,
			}
		},
		components: {
    	RingLoader
  	},
		methods: {
			getNoticias(){
				var token = localStorage.getItem('token');
				var urlNoticias = url + 'mostrarNoticias.php'
				axios.get(urlNoticias,{
            params: {
              token: token
            }
        }).then(res => {
				  	this.noticias = res.data.noticias;
				  	this.loading = false;
				}).catch(err => {
					let codigo_error = err.response.status;
					if (codigo_error = 403) {
						EventBus.$emit("cerrar");
					}
				})
			},
		},
		mounted(){
			this.getNoticias();
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
<style scoped>
	.panel{
	  margin-top: 10px; 
	  margin-left: 5px; 
	  margin-right: 10px; 
	  float:left;
	}
	.cargando {
		display: inline-block;
	}
	.panel-body {
		position:relative;
		height: 220px;
	}
	.panel-heading {
		background: rgba(0,0,255,0.3);
	}
	.panel-footer {
		text-align: left;
		background: rgba(0,0,255,0.3);
	}
	.row {
		display: table;
	}
	.row [class*="col-"] {
		display: table-cell;
		float: left;
	}
	img {
		max-height: 200px;
	  max-width: 200px;
	  float: right; 
	  margin: 0px 0px 15px 15px;
	}
</style>

