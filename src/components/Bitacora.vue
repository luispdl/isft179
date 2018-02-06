<template>
	<div class="container" id="cajon-respuesta3">
		<ul  class="nav nav-tabs" id="pestanas_academica" style="margin-top: 10px;">
			<li v>
			</li>
		</ul>
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