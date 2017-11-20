<template>
	<!-- Modal cabecera-->
  <div class="modal fade" id="modal-comprobante" role="dialog">
    <div class="modal-dialog">

      <!-- Modal contenedor-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="hidden-print close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{titulo}}</h4>
        </div>
        <div class="modal-body text-center" id="comprobante">
          <p>{{materia.nombre_materia}} ({{materia.codigo_materia}})</p>
          <p>{{materia.fecha_final}}</p>
          <p>{{materia.modalidad}}</p>
          <img v-bind:src="url_codigo_operacion">
          <svg id="barcode"></svg>
        </div>
        <div class="modal-footer">
          <button type="button" class="hidden-print btn btn-warning" onclick="window.print();">Imprimir</button>
          <button type="button" class="hidden-print btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
	name:'modal-comprobante',
	data(){
		return{
			titulo:'Comprobante de Inscripción a Final',
		}
	},
	props:['materia', 'url_codigo_operacion'],
  methods: {
  },
  mounted() {
    $("#barcode").JsBarcode("Hi!");
  }
}

</script>

