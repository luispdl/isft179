<template>
  <div class="container" id="cajon-respuesta" style="margin-top: 10px;">
    <ul class="nav nav-tabs" id="pestanas">
      <li v-for='(carrera,index) in carreras'>
        <a data-toggle="tab" :href="'#'+carrera.codigo_carrera"><h5>{{carrera.nombre_carrera}}({{carrera.codigo_carrera}})</h5></a>
      </li>
      <!-- se cargan las pestañas de cada carrera -->
    </ul>
    <div id="cajon_pestanas" class="tab-content">
      <div v-for='(carrera,index) in carreras' :id="carrera.codigo_carrera" class="tab-pane fade">
        <table class='table table-striped'>
          <thead>
            <tr>
              <th class='text-center'>Materia</th>
              <th class='text-center'>1er Llamado</th>
              <th class='text-center'>2do Llamado</th>
              <th class='text-center'>No Inscribirse</th>
              <th class='text-center'>Modalidad</th>
            </tr></thead>
            <tbody>
              <tr v-for ="materia in carrera.materias">
                <input type="hidden" name="codigo_carrera" v-bind:value="materia.codigo_carrera" />
                <input type="hidden" name="nro_operacion" v-bind:value="materia.nro_operacion" />
                <input type="hidden" name="codigo_materia" v-bind:value="materia.codigo_materia" />
                <td class="text-left">{{ materia.nombre_materia}} ({{ materia.codigo_materia }})</td>

                <td class='text-center' v-if="materia.fecha_1!='0000-00-00'">
                  {{ materia.fecha_1 | fechaConFormato}}
                  <input type='radio'
                  :value='materia.fecha_1'
                  :name='materia.codigo_materia+materia.codigo_carrera'
                  :checked="materia.fecha_1==materia.fecha_final"
                  >
                  <td v-else>No hay fecha</td>
                </td>
                <td class='text-center' v-if="materia.fecha_2!='0000-00-00' && materia.fecha_2!=null">
                  {{ materia.fecha_2 | fechaConFormato}}
                  <input type='radio'
                  :value='materia.fecha_2'
                  :name='materia.codigo_materia+materia.codigo_carrera'
                  :checked="materia.fecha_2==materia.fecha_final"
                  >
                  <td class="text-center" v-else>No hay fecha</td>
                </td>
                <td class='text-center'>
                  <input type='radio'
                  value='NO'
                  :name='materia.codigo_materia+materia.codigo_carrera'
                  :checked="materia.fecha_final==null"
                  >
                </td>

                <td class='text-center'>Regular</td>
              </tr>
            </tbody>
          </table>
        </div>
        <button class='btn-lg btn-success' id='confirmar' @click='inscripcion'>CONFIRMA INSCRIPCIÓN</button>
      </div>
      <ring-loader class="cargando" :loading="loading"></ring-loader>
      <modal-notificacion :claseModal="claseModal" :tituloModal="tituloModal" :mensajeRespuesta="mensajeRespuesta" :redireccion="redireccionModal"></modal-notificacion>
    </div>
</template>

<script>
  import axios from 'axios';

  import ModalNotificacion from './ModalNotificacion.vue';
  import configUrl from '../services/config.js';
  import RingLoader from 'vue-spinner/src/RingLoader.vue';
      // Import the EventBus we just created.
  import { EventBus } from '../event-bus.js';

  var url = configUrl.apiUrl;

  export default {
    name: 'finales',
    data () {
      return {
        carreras: [],
        tituloModal:'Operación Exitosa',
        claseModal:'bg-success',
        mensajeRespuesta:'',
        redireccionModal:'menu_estado',
        legajo:0,
        loading:true,
      }
    },
    components: {
      ModalNotificacion,
      RingLoader,
    },
  	methods: {
      armarMateriasAEnviar() {
        var codigo_carrera;
        var codigo_materia;
        var fecha_final;
        var nro_operacion;
        var modalidad = "regular";
        var materias = [];
        self = this;
        var tr = document.querySelectorAll("tbody tr");
        tr.forEach(function(elemento, indice){
          fecha_final = elemento.querySelector("input[type='radio']:checked").value;
          codigo_carrera = elemento.children.codigo_carrera.value;
          codigo_materia = elemento.children.codigo_materia.value;
          if(elemento.children.nro_operacion.value){
            nro_operacion = elemento.children.nro_operacion.value;
          } else {
            nro_operacion = -1;
          }

          if(fecha_final!='NO'){
            var materia = {
              "codigo_carrera" : codigo_carrera,
              "codigo_materia" : codigo_materia,
              "fecha_final" : fecha_final,
              "modalidad" : modalidad,
              "nro_operacion" : nro_operacion,
            }
            materias.push(materia);
          }
        });

        return materias;
      },
  	  getCarreras: function(){
        var token = localStorage.getItem('token');
  	    var self = this;
  	    var urlMateriasARendir = url + 'materiasARendir.php';
  	    var legajo = this.legajo;
  	    axios.get(urlMateriasARendir,{
            params: {
              legajo: this.legajo,
              token: token
            }
        }).then(response => {
        	this.carreras = response.data;
          console.log(response.data);
          this.loading = false;
        }).catch(error => {
          let codigo_error = error.response.status;
          this.tituloModal = 'Se encontró un problema';
          this.claseModal = 'bg-danger';
          this.mensajeRespuesta = error.response.data.mensaje;
          if(codigo_error == 403) {
            EventBus.$emit("cerrar", error.response.data.mensaje);
          } else {
            this.redireccionModal = '/';
            $('#modal-final').modal();
          }

        })
  	  },
  	  inscripcion: function(){
        var token = localStorage.getItem('token');
  	    var materias = this.armarMateriasAEnviar();
  	    var legajo = this.legajo;
  	    $.ajax({
  	      url: url + 'inscripcionFinales.php',
  	      type: 'POST',
  	      data: {
  	          materias: materias,
  	          legajo: legajo,
              token: token
  	      }
  	    }).done(function(res) {
  	    	self.tituloModal = 'Operación Exitosa';
        	self.claseModal ='bg-success';
          self.redireccionModal = 'menu_estado',
        	self.mensajeRespuesta = res.mensaje;
  	      $('#modal-final').modal();
  	    }).fail(function(res,estado,error) {
  	    	self.tituloModal = 'Operación Fallida';
        	self.claseModal = 'bg-danger';
        	self.mensajeRespuesta = res.responseJSON.mensaje;
          self.redireccionModal = "menu_finales";
  	      if (res.status == 500){
  	         $('#modal-final').modal();
  	      } else {
  	         $('#modal-final').modal();
  	      }
  	    });
  	  },
  	  getLegajo(){
  	  	this.legajo = JSON.parse(localStorage.getItem('datos')).legajo;
  	  }
  	},
    created: function(){
      this.getLegajo();
    },
    mounted: function() {
    	this.getCarreras();
    },
    updated: function() {
      $("#pestanas a:first").tab('show');
    },
    filters: {
      fechaConFormato(fecha) {
        let array1 = fecha.split('-');
        let array2 = array1.reverse();
        return array2.join('-');

      },
    },
  }
</script>

<style scope>
  .cargando {
    display: inline-block;
  }
</style>
