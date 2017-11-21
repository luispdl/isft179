<template>
	<div class="modal fade" tabindex="-1" role="dialog" id="modal-eliminar">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-danger">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Cuidado</h4>
	      </div>
	      <div class="modal-body">
	        <p>¿Esta seguro que desea eliminar al preceptor <em>{{nombrePreceptor}}</em>?</p>
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
export default {

  name: 'ModalEliminar',

  data () {
    return {

    }
  },
  props: ['id', 'abrir','nombre'],
  computed: {
  	idPreceptor(){

  	},
  	nombrePreceptor(){

  	},
  	abrirModal(){
  		return this.abrir;
  	},
  },
  methods: {
  	eliminar() {
  		
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