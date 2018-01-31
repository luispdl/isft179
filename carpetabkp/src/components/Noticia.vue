<template>
	<div class="box box-primary container">
		<div class="box-header with-border">
			<h3 class="box-title">{{nueva?'Agregar':'Editar'}} una noticia</h3>
		</div>
		<!-- /.box-header -->
		<!-- form start -->
		<form class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
			<div class="box-body">
				<div class="form-group">
					<label for="titulo" class="col-lg-2 control-label">Titulo</label>
					<div class="col-lg-10">
						<input id="titulo1" maxlength="81" v-model="titulo" type="text" class="form-control"  name="titulo" placeholder="Titulo" required data-toggle="tooltip" title="Limite de ingreso - 80 caracteres" v-on:keyup="controlTitulo">
					</div>
				</div>
				<div class="form-group">
					<label for="contenido" class="col-lg-2 control-label">Contenido</label>
					<div class="col-lg-10">
						<textarea maxlength="256" v-model="contenido" class="form-control" rows="6" cols="50" id="contenido" name="contenido" required placeholder="Contenido" data-toggle="tooltip" title="Limite de ingreso - 255 caracteres" v-on:keyup="controlContenido">
						</textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="imagen" class="col-lg-2 control-label">Imagen</label>
					<div class="col-lg-6">
						<input type="file" id="imagen" name="imagen" placeholder="Imagen">
					</div>
				</div>
				<div v-if="!nueva  && contieneImagen" class="row center-block img-thumbnail">
					<div class="row container titulo-imagen">
						<h4 class="col-md-11">Imagen actual</h4>
						<button type="button" @click="borrarImagen" class="pull-right btn btn-danger">X</button>	
					</div>
					<img :src="urlImagen" alt="..." class="img-thumbnail">
				</div>
			</div>

			<div class="box-footer text-center">
				<button @click="guardarNoticia" type="button" class="btn btn-primary">Guardar noticia</button>
				<button type="reset" class="btn btn-success">Reiniciar formulario</button>
				<router-link to="/preceptor/noticias" type="button" class="btn btn-danger">Volver</router-link>
			</div>
		</form>
		<modal-notificacion :claseModal="claseModal" :tituloModal="tituloModal" :mensajeRespuesta="mensajeRespuesta" :redireccion="redireccion"></modal-notificacion>
	</div>

</template>

<script>

	import axios from 'axios';
	import configUrl from '../services/config.js';
	import ModalNotificacion from './ModalNotificacion.vue';

	var url = configUrl.apiUrl;

	export default {
		name:'noticia',
		data(){
			return {
				nueva: true,
				titulo:"",
				contenido:"",
				imagen: "",
				urlImagen:"",
				claseModal:"",
				tituloModal:'',
				mensajeRespuesta:"",
				redireccion:"",
				contieneImagen: false,
			}
		},
		components: {
			ModalNotificacion,
		},
		methods: {
			getNoticia(){
				var id = this.$route.params.id;
				let token = localStorage.getItem('token');
				var urlNoticia = url + 'mostrarNoticia.php';
				axios.get(urlNoticia,{
					params: {
						id: id,
						token: token
					}
				}).then( res =>{
					this.titulo = res.data.titulo;
					this.contenido = res.data.contenido;
					if(res.data.imagen){
						this.contieneImagen = true;
						this.urlImagen = res.data.imagen;
					}
				}).catch( err => {
				})
			},
			agregarOactualizar(){
				if(!this.$route.params.id){
					this.nueva = true;
				} else {
					this.nueva = false;
				}
			},
			guardarNoticia(){
				var token = localStorage.getItem('token');
				var urlGuardar = '';
				var formData = new FormData();
				formData.append('imagen',$("input[type=file]")[0].files[0]);
				formData.append('titulo',this.titulo);
				formData.append('contenido', this.contenido);
				formData.append('token', token);
				if(!this.nueva){
					formData.append('id',this.$route.params.id);
					urlGuardar = url + 'actualizarNoticia.php';

				} else {
					urlGuardar = url + 'guardarNoticia.php';
				}
				axios({
					method: 'post',
					url: urlGuardar,
					data: formData,
					contentType:false,
					processData: false
				}).then(response => {
					this.claseModal = "bg-success";
					this.tituloModal = "Operación exitosa";
					this.mensajeRespuesta = "La noticia se guardó de forma exitosa!";
					this.redireccion = "/preceptor/noticias";
					$('#modal-final').modal();
				}).catch(err => {
					this.claseModal = "bg-danger";
					this.tituloModal = "Operación fallida";
					this.mensajeRespuesta = err.response.data.mensaje;
					if(!this.$route.params.id) {
						this.redireccion = "/preceptor/noticia";
					} else {
						this.redireccion = "/preceptor/noticia/" + this.$route.params.id;
					}
					$('#modal-final').modal();
				})
			},
			controlTitulo(){
				var control = this.titulo.length;
				if (control > 80){
					$('#titulo1').addClass('alert-danger');
					$('#titulo1').tooltip();
				} else{
					$('#titulo1').tooltip('destroy');
					$('#titulo1').removeClass('alert-danger');
				}
			},
			controlContenido(){
				var control = this.contenido.length;
				if (control > 255){
					$('#contenido').addClass('alert-danger');
					$('#contenido').tooltip();
				} else{
					$('#contenido').tooltip('destroy');
					$('#contenido').removeClass('alert-danger');
				}
			},
			borrarImagen(){
				var formData = new FormData();
				var token = localStorage.getItem('token');
				formData.append('id',this.$route.params.id);
				formData.append('token', token);
				var urlBorrarImagen = url + 'borrarImagenNoticia.php';
				axios({
					method: 'post',
					url: urlBorrarImagen,
					data: formData,
				}).then(response => {
					this.contieneImagen = false;
				}).catch(err => {
				});
			}
		},
		mounted(){
			this.agregarOactualizar()
			if(!this.nueva){
				this.getNoticia();
			}
		}
	}
</script>
<style>
	.box-footer {
		margin-top: 20px;
	}
	img {
		width: 50%;
	}
	.titulo-imagen{
		padding:0 20px;
	}
</style>
