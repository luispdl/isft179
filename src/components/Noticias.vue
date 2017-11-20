<template>
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title"><router-link to="/preceptor/noticia" class="btn btn-success">Ingresar nueva noticia</router-link></h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="text-center">Id</th>
								<th class="text-center">Titulo</th>
								<th class="text-center">Fecha de creacion</th>
								<th class="text-center">Acción</th>

							</tr>
						</thead>
						<tbody>
							<tr v-for="noticia in noticias">
								<td class="text-center">{{noticia.ID_noticia}}</td>
								<td class="text-center">{{noticia.titulo}}</td>
								<td class="text-center">{{noticia.fecha_creacion | fechaConFormato}}</td>
								<td class="text-center">
									<router-link :to="'/preceptor/noticia/'+noticia.ID_noticia" title = 'Editar' class="btn btn-warning"><span class="fa fa-pencil-square-o" aria-hidden="true"> Editar</span></router-link>
									<a @click="eliminarNoticia(noticia.ID_noticia)" href="#" title ="Eliminar" class="btn btn-danger" ><span class="fa fa-trash-o" aria-hidden="true"> Eliminar</span></a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</template>

<script>
	import axios from 'axios';
	import configUrl from '../services/config.js';

	var url = configUrl.apiUrl;

	export default {
		name:"noticias",
		data() {
			return {
				noticias: []
			}
		},
		methods: {
			getNoticias(){
				let token = localStorage.getItem('token');
				let urlNoticias = url + 'mostrarNoticias.php'
				axios.get(urlNoticias,{
					params:{
						token,
					}
				})
				  .then(res => {
				  	this.noticias = res.data.noticias;
				}).catch(err => {
						console.log(err);
				})
			},
			eliminarNoticia(id){
				var urlEliminiarNoticias = url + 'eliminarNoticia.php';
				let token = localStorage.getItem('token');
				axios.get(urlEliminiarNoticias,{
					params: {
						id: id,
						token: token
					}
				}).then( res => {
					this.$router.push("/preceptor/noticias");
				}).catch( err => {
					console.log(err);
				})
			}
		},
		created(){

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
