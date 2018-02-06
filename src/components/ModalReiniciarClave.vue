<template>
	<div class="modal fade" tabindex="-1" role="dialog" id="modal-reiniciar">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-danger">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Cuidado</h4>
	      </div>
	      <div class="modal-body">
	        <p>¿Esta seguro que desea eliminar al usuario <em>{{nombreUsuario}}</em>?</p>
	      </div>
	      <div class="modal-footer">
	      	<button type="button" @click="reiniciar" class="btn btn-primary">Aceptar</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</template>

<script>
import configUrl from '../services/config.js';
import axios from 'axios';

var urlReiniciar = configUrl.apiUrl + 'reiniciar.php';
export default {

  name: 'ModalReiniciarClave',

  data () {
    return {
    }
  },
  props: ['usuario','abrir' ],
  computed: {
  	abrirModal(){
  		return this.abrir;
  	},
  	nombreUsuario() {
  		return this.usuario;
  	}
  },
  methods: {
  	reiniciar() {
  		let token = localStorage.getItem('token');
  		let formData = new FormData();
  		formData.append('token', token);
  		formData.append('nombre_usuario', this.nombreUsuario);
  		axios({
  			'method': "POST",
  			'data': formData,
  			'url': urlReiniciar,
  		}).then( response => {
  			$('#modal-reiniciar').modal('hide');
  			this.$router.push('/');
  		}).catch( error => {
  			$('#modal-reiniciar').modal('hide')
  		});
  	}
  },
  updated() {
  	if(this.abrirModal) {
  		$('#modal-reiniciar').modal();
  	}
  },
}
</script>

<style lang="css" scoped>
</style>