<template>
  <div class="modal fade" id="modal-final" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div :class="'modal-header '+ claseModal">
          <h4 class="modal-title"> {{tituloModal}}</h4>
        </div>
        <div class="modal-body">
         {{mensajeRespuesta}}
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
    name: "modal-notificacion",
    data() {
      return {
      }
    },
    props:["claseModal","tituloModal","mensajeRespuesta",'redireccion','continuar'],
    updated(){
      self = this;
      $("#modal-final").on('hidden.bs.modal', function () {
        if(this.continuar) {
          this.$store.state.registrado = false;
        } else {
          self.$router.push({path:self.redireccion});
        }
      });
    }
  }
</script>
