<template>
	<div class="container" id="cajon-respuesta3">
		<ul  class="nav nav-tabs" id="pestanas_academica" style="margin-top: 10px;">
			<li>
			</li>
		</ul>
		<div class="container-fluid">
			<div class="row">
				<form class="navbar-form navbar-right" role="search">
				  <div class="form-group">
				    <input v-if="buscarPor != 2" v-model="q" type='text' class="form-control" placeholder="Buscar">
				    <input v-else v-model="q" type='date' class="form-control" placeholder="Buscar">
				    <select name="" id="" class="form-control" v-model="buscarPor">
				    	<option value="1">Nombre de Usuario</option>
				    	<option value="2">Fecha</option>
				    	<option value="3">Legajo</option>
				    </select>
				  </div>
				  <button @click="busqueda" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
				</form>
			</div>
		</div>
		<div id="cajon_pestanas_academica" class="tab-content">
			<div>
				<table class='table' v-if="bitacora.length > 0">
					<thead>
						<tr>
							<th>Id Usuario</th>
							<th> Fecha</th>
							<th>Descripción</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="item in bitacora" >
							<th>{{item.ID_usuario}}</th>
							<th>{{item.fecha}}</th>
							<th>{{item.Descripcion}}</th>
						</tr>
					</tbody>
				</table>
				<div v-else class="h3 text-center"><em>No hay registros</em></div>
			</div>
			<ring-loader class="cargando text-center" :loading="loading"></ring-loader>
		</div>

	</div>
</template>

<script>
	import axios from 'axios';
	import configUrl from '../services/config.js';
	import RingLoader from 'vue-spinner/src/RingLoader.vue';


	var url = configUrl.apiUrl;
export default {

  name: 'bitacora',

  data () {
    return {
    	bitacora: [],
    	loading: true,
    	buscarPor: 1,
    	q: ''
    }
  },
  components: {
		RingLoader,
	},
  methods: {
		getBitacoraPorUsuario() {
			var token = localStorage.getItem('token');
			var urlBitacora = url +'mostrarBitacora.php';
			let usuario_id = this.$route.params.usuario_id;
			console.log(usuario_id);
			axios.get(urlBitacora, {
				params: {
					usuario_id: usuario_id,
					token: token
				}
			}).then(res => {
				console.log(res);
				this.bitacora = res.data;
				this.loading = false;
			}).catch(err => {
			})
		},
		getBitacoraAdmin() {
			var token = localStorage.getItem('token');
			var urlBitacora = url +'mostrarBitacora.php';
			axios.get(urlBitacora, {
				params: {
					token: token
				}
			}).then(res => {
				console.log(res);
				this.bitacora = res.data;
				this.loading = false;
			});
		},
		busqueda() {
			var token = localStorage.getItem('token');
			var urlBitacora = url +'mostrarBitacora.php';
			axios.get(urlBitacora, {
				params: {
					token: token,
					q: this.q,
					buscarPor: this.buscarPor
				}
			}).then(res => {
				console.log(res);
				this.bitacora = res.data;
				this.loading = false;
			}).catch(error => console.log);
		}
	},
	created() {
		if(this.$route.params.usuario_id) {
			console.log("usuario");
			this.getBitacoraPorUsuario();
		} else {
			console.log('admin');
			this.getBitacoraAdmin();
		}
	}

}
</script>

<style lang="css" scoped>
</style>