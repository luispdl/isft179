<template>
  <div class="modal fade" id="modal-cerrar" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h4 class="modal-title"> Cerrando Sesión</h4>
        </div>
        <div class="modal-body">
         {{mensaje}}
       	</div>
       	<div class="modal-footer">
        	<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      	</div>
    	</div>
  	</div>
	</div>
</template>

<script>
export default {

  name: 'modal-cerrar-sesion',

  data () {
    return {
    }
  },
  props: ['mensaje'],
  methods : {
    cerrarVentana() {
      $("#modal-cerrar").on('hidden.bs.modal', ()=> {
        localStorage.removeItem('datos');
        localStorage.removeItem('token');
        this.$store.state.registrado = false;
        this.$store.state.legajo = 0;
        this.$store.state.tipo_usuario = 0;
        this.$router.push('/login');
      });
    }
  },
  updated() {
    this.cerrarVentana();
    $("#modal-cerrar").modal();
  }

}
</script>

<style lang="css" scoped>
</style>