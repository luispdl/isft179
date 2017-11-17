<template>
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Noticias</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body container">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" :data-slide-to="index" :class="index==0?'active':''" v-for="(noticia, index) in noticias"></li>
                </ol>
                <div class="carousel-inner">
                  <div :class="index==0?'item active':'item'" v-for="(noticia, index) in noticias">
                  	<div class="row">
                  		<h3>{{noticia.titulo}}</h3>
                  	</div>
                    <img class="img-fluid" :src="noticia.imagen">
                     
                    {{noticia.contenido}}
                    <div class="fecha">
                    	Noticia creada el {{noticia.fecha_creacion}}
                    </div>

                    	 

                  </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
<!-- 	<div class="container text-center col-md-12">
		<div class="row" v-if="(index % 2) == 0" v-for="(noticia, index) in noticias">
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
</div> -->
</template>

<script>
	import axios from 'axios';
	import configUrl from '../services/config.js';
	import RingLoader from 'vue-spinner/src/RingLoader.vue';

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
				var urlNoticias = url + 'mostrarNoticias.php'
				axios.get(urlNoticias)
				  .then(res => {
				  	this.noticias = res.data.noticias;
				  	this.loading = false;
				}).catch(err => {
						console.log(err);
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
	.box-body {
	}
	.item {
		width: 80%;
		height: 300px;
		margin:10px auto;
	}
	.carousel-control.left,
	.carousel-control.right {
	  background-image: none;
	}
	.carousel-control > .fa {
	  font-size: 40px;
	  position: absolute;
	  top: 50%;
	  z-index: 5;
	  display: inline-block;
	  margin-top: -20px;
	}
	span {
		color:blue;
	}
	img{
	  max-height: 200px;
	  float: right; 
	  margin: 0px 0px 15px 15px;
	}
	li{
		background-color: #3498DB;
		height: 15px;
		width: 15px;
	}
	.carousel-indicators .active {
		background-color: #ABB2B9;
		height: 15px;
		width: 15px;
	}
	.carousel-caption {
		color: black;
	}
	.fecha {
		margin-top: 10px;
		font-style: italic;
	}
</style>
