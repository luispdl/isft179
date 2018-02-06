<template>
	<div class="container">
		<h1>Inscripciones de alumnos</h1>
		<div class="container formulario">
			<form class="form-inline">
				<div class="col-md-2"></div>
			  <div class="form-group col-md-6">
			    <label for="legajo" class="col-md-6">Legajo</label>
			    <input v-model="inputLegajo" type="number" class="form-control col-md-5" id="legajo" name="legajo">
			  </div>
			  <button @click="buscarPorLegajo" type="button" class="btn btn-primary col-md-1"><span class="hidden-md glyphicon glyphicon-search" aria-hidden="true"></span><span class="hidden-sm"> Buscar</span></button>
			</form>

			<form class="form-inline">
				<div class="col-md-2"></div>
				<div class="form-group col-md-6">
					<label for="nombre" class="col-md-6">Apellido</label>
					<input v-model="nombre" type="text" class="form-control col-md-5" placeholder="PEREZ" name="nombre">
				</div>
				<button @click="buscarPorNombre(1)" type="button" class="btn btn-primary col-md-1"><span class="hidden-md glyphicon glyphicon-search" aria-hidden="true"></span><span class="hidden-sm"> Buscar</span></button>
			</form>
			<form class="form-inline">
				<div class="col-md-2"></div>
				<div class="form-group col-md-6">
					<label for="dni" class="col-md-6">DNI</label>
					<input v-model="dni" type="text" class="form-control col-md-5" name="dni">
				</div>
				<button @click="buscarPorDni" type="button" class="btn btn-primary col-md-1"><span class="hidden-md glyphicon glyphicon-search" aria-hidden="true"></span><span class="hidden-sm"> Buscar</span></button>
			</form>
			<form class="form-inline">
				<div class="col-md-2"></div>
				<div class="form-group col-md-6">
					<label for="nombre_usuario" class="col-md-6">Nombre de Usuario</label>
					<input v-model="nombre_usuario" type="text" class="form-control col-md-5" placeholder="nombreusuario" name="nombre_usuario">
				</div>
				<button @click="buscarPorUsuario" type="button" class="btn btn-primary col-md-1"><span class="hidden-md glyphicon glyphicon-search" aria-hidden="true"></span><span class="hidden-sm"> Buscar</span></button>
			</form>
		</div>
		<hr>
		<div v-show="!sinResultado" class="row container">
			<h3>Alumnos encontrados.</h3>
			<table class="table table-striped">
				<thead>
					<tr>
						<td class="text-center">N°</td>
						<td class="text-center">Legajo</td>
						<td class="text-center">Nombre</td>
						<td class="text-center">Apellido</td>
						<td class="text-center">Nro Documento</td>
						<td class="text-center">Nombre de Usuario</td>
						<td class="text-center">Acciones</td>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(alumno,index) in alumnos">
						<td class="text-center">{{(index +1) + (paginaActiva-1)*20}} </td>
						<td class="text-center">{{alumno.legajo}}</td>
						<td class="text-center">{{alumno.nombre}}</td>
						<td class="text-center">{{alumno.apellido}}</td>
						<td class="text-center">{{alumno.numero_documento}}</td>
						<td class="text-center">{{alumno.nombre_usuario}}</td>
						<td class="text-center">
							<a @click="seleccionarAlumno(alumno.legajo)" class="btn btn-success"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Seleccionar</a>
							<a @click="reiniciarClave(alumno.nombre_usuario)" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Reiniciar Clave</a>
						</td>
					</tr>
				</tbody>
			</table>
			<nav class="text-center" aria-label="Page navigation">
			  <ul class="pagination">
			    <li v-bind:class="{ active: paginaActiva==n }" v-for="n in paginas"><a @click="buscarPorNombre(n)">{{n}}</a></li>
			  </ul>
			</nav>
		</div>
		<div class="sinResultado text-center" v-show="sinResultado"> No hay usuarios encontrados.</div>
		<modal-notificacion :continuar="continuar" :claseModal="claseModal" :tituloModal="tituloModal" :redireccion="redireccion" :mensajeRespuesta="mensajeRespuesta"></modal-notificacion>
		<modal-reiniciar-clave :abrir="abrir_reiniciar" :usuario="usuario"></modal-reiniciar-clave>
	</div>

</template>

<script>
	import configUrl from '../services/config.js';
	import axios from 'axios';
	import { store } from '../store';
  import { EventBus } from '../event-bus.js';
  import ModalNotificacion from "./ModalNotificacion.vue";
  import ModalReiniciarClave from "./ModalReiniciarClave.vue";

	var urlBuscar = configUrl.apiUrl + 'buscarAlumno.php';
	export default {
		name:"insc-admin",
		data() {
			return {
				dni:'',
				nombre:'',
				nombre_usuario:'',
				alumnos:[],
				sinResultado: false,
				inputLegajo: 0,
				claseModal:'',
				tituloModal:'',
				redireccion:'',
				mensajeRespuesta:'',
				continuar:false,
				abrir_reiniciar:false,
				usuario:'',
				paginas:0,
				paginaActiva: 1,
			}
		},
		components: {
			ModalNotificacion,
			ModalReiniciarClave,
		},
		computed: {
			legajo() {
				return this.$store.state.legajo;
			}
		},
		methods: {
			buscarPorLegajo(){
				let token = localStorage.getItem('token');
				axios.get(urlBuscar,{
					params:{
						legajo:this.inputLegajo,
						tipo:'legajo',
						token: token
					}
				}).then(res=>{
					if(res.data[0]){
						this.sinResultado = false;
						this.alumnos = res.data;
					} else {
						this.sinResultado = true;
					}
				}).catch(error =>{
					this.claseModal = "bg-warning";
	  			this.tituloModal = 'Cuidado';
	  			this.redireccion = '/preceptor/inscripciones_admin';
	  			this.mensajeRespuesta = error.response.data.mensaje;
	  			$("#modal-final").modal();
				})
			},
			buscarPorDni(){
				let token = localStorage.getItem('token');
				axios.get(urlBuscar,{
					params:{
						dni:this.dni,
						tipo:'dni',
						token: token
					}
				}).then( res=> {
					if(res.data[0]){
						this.sinResultado = false;
						this.alumnos = res.data;
					} else {
						this.sinResultado = true;
					}
				}).catch( error => {
					this.claseModal = "bg-warning";
	  			this.tituloModal = 'Cuidado';
	  			this.redireccion = '/preceptor/inscripciones_admin';
	  			this.mensajeRespuesta = error.response.data.mensaje;
	  			$("#modal-final").modal();
				})
			},
			buscarPorNombre(pagina){
				let token = localStorage.getItem('token');
				this.paginaActiva = pagina;
				axios.get(urlBuscar,{
					params:{
						nombre:this.nombre,
						tipo:'nombre',
						token: token,
						pagina: pagina,
					}
				}).then( res=> {
					console.log(res);
					if(res.data.alumnos.length != 0) {
						this.alumnos = res.data.alumnos;
						this.paginas = res.data.paginas;
						this.sinResultado = false;
					} else {
						this.sinResultado = true;
					}
				}).catch( error =>{
					this.claseModal = "bg-warning";
	  			this.tituloModal = 'Cuidado';
	  			this.redireccion = '/preceptor/inscripciones_admin';
	  			this.mensajeRespuesta = error.response.data.mensaje;
	  			$("#modal-final").modal();
				})
			},
			buscarPorUsuario(){
				let token = localStorage.getItem('token');
				axios.get(urlBuscar,{
					params:{
						nombre_usuario:this.nombre_usuario,
						tipo:'usuario',
						token: token
					}
				}).then( res=> {
					if(res.data[0]) {
						this.alumnos = res.data;
						this.sinResultado = false;
					} else {
						this.sinResultado = true;
					}
				}).catch( error =>{
					this.claseModal = "bg-warning";
	  			this.tituloModal = 'Cuidado';
	  			this.redireccion = '/preceptor/inscripciones_admin';
	  			this.mensajeRespuesta = error.response.data.mensaje;
	  			$("#modal-final").modal();
				})
			},
			seleccionarAlumno(legajo){
				var datos = JSON.parse(localStorage.getItem("datos"));
				datos.legajo = legajo;
				console.log(datos);
				this.$store.state.legajo = legajo;
				localStorage.setItem('datos', JSON.stringify(datos));
				this.$emit("cambiarLegajo");
				EventBus.$emit("cambiarLegajo", this.legajo);
				this.$router.push('/menu_finales')
			},
			reiniciarClave(nombre_usuario) {
				this.usuario = nombre_usuario;
				this.abrir_reiniciar = true;
			},
		}
	}
</script>

<style>
	form {
		margin:20px;
		padding:20px;
	}
	.formulario {
		background: rgba(237,237,237,1);
		background: -moz-linear-gradient(left, rgba(237,237,237,1) 0%, rgba(246,246,246,1) 53%, rgba(255,255,255,1) 100%);
		background: -webkit-gradient(left top, right top, color-stop(0%, rgba(237,237,237,1)), color-stop(53%, rgba(246,246,246,1)), color-stop(100%, rgba(255,255,255,1)));
		background: -webkit-linear-gradient(left, rgba(237,237,237,1) 0%, rgba(246,246,246,1) 53%, rgba(255,255,255,1) 100%);
		background: -o-linear-gradient(left, rgba(237,237,237,1) 0%, rgba(246,246,246,1) 53%, rgba(255,255,255,1) 100%);
		background: -ms-linear-gradient(left, rgba(237,237,237,1) 0%, rgba(246,246,246,1) 53%, rgba(255,255,255,1) 100%);
		background: linear-gradient(to right, rgba(237,237,237,1) 0%, rgba(246,246,246,1) 53%, rgba(255,255,255,1) 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ededed', endColorstr='#ffffff', GradientType=1 );
		border: solid 1px grey;
	}
	.sinResultado {
		font-style: italic;
		font-size: 18px;
	}
	.pagination {
		cursor:default;
	}
</style>
