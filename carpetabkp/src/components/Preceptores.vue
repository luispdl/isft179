<template>
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title"><router-link to="/registro/preceptor" class="btn btn-success">Registrar Nuevo Preceptor</router-link></h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="text-center">Id</th>
								<th class="text-center">Nombre Usuario</th>
								<th class="text-center">Email</th>
								<th class="text-center">Acciones</th>

							</tr>
						</thead>
						<tbody>
							<tr v-for="(preceptor, index) in preceptores">
								<td class="text-center">{{index + 1}}</td>
								<td class="text-center">{{preceptor.nombre_cuenta_usuario}}</td>
								<td class="text-center">{{preceptor.correoElectronico}}</td>
								<td class="text-center">
									<router-link :to="'/admin/editar_password/'+preceptor.nombre_cuenta_usuario" title = 'Editar' class="btn btn-warning"><span class="fa fa-pencil-square-o" aria-hidden="true"> Editar Contraseña</span></router-link>
									<a @click="eliminarPreceptor(preceptor.nombre_cuenta_usuario)" title ="Eliminar" class="btn btn-danger" ><span class="fa fa-trash-o" aria-hidden="true"> Eliminar</span></a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<modal-reiniciar-clave :abrir="abrir_reiniciar" :usuario="usuario"></modal-reiniciar-clave>
	</div>
</template>

<script>
import configUrl from '../services/config.js';
import axios from 'axios';
import ModalReiniciarClave from './ModalReiniciarClave.vue';

var urlPreceptores = configUrl.apiUrl + 'preceptores.php';
export default {

  name: 'Preceptores',

  data () {
    return {
    	preceptores: [],
    	abrir_reiniciar:false,
    	usuario:'',
    }
  },
  components: {
  	ModalReiniciarClave,
  },
  methods: {
  	getPreceptores() {
  		let token = localStorage.getItem('token');
  		axios.get(urlPreceptores, {
  			params: {
  				token: token,
  			}
  		}).then( response => {
  			this.preceptores = response.data.preceptores;
  		}).catch( error => {
  		});
  	},
  	eliminarPreceptor(nombre_usuario) {
			this.usuario = nombre_usuario;
			this.abrir_reiniciar = true;
		},
  },
  mounted(){
  	this.getPreceptores();
  }
}
</script>

<style lang="css" scoped>
</style>