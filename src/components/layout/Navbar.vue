<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <h3>
          <i v-if="alumno" class="fa fa-graduation-cap" aria-hidden="true"></i>
          <i v-if="preceptor" class="fa fa-user" aria-hidden="true"></i>
          <i v-if="admin" class="fa fa-user-secret" aria-hidden="true"></i>
          {{ nombre_usuario }}<span v-if="alumno"> - {{ legajo }}</span><small v-if="mostrarBorrar"> - {{ legajo }} <button @click="borrarLegajo" class="btn btn-danger">x</button></small>
        </h3>
      </div>
      <div class="row text-right fechas col-sm-offset-3 col-sm-3">
        <div><strong>Inicio Inscripción:</strong> {{fechaInicio | fechaConFormato }}</div>
        <div><strong>Final Inscripción:</strong> {{fechaFin | fechaConFormato }}</div>
      </div>

    </div>
      <section class="main container margen_section">
      <div class="row">
        <div class="cd-md-12 cd-xs-12">
          <div role="tabpanel" >
              <!-- en esta parte es la de las tabs dinamicas-->
            <div class="row" >
              <ul class="nav nav-tabs" role="tablist">
                <router-link exact-active-class="active" to="/" tag="li"><a>Inicio</a></router-link>
                <router-link v-show="legajo" exact-active-class="active" to="/menu_finales" tag="li"><a>Inscripción a Finales</a></router-link>
                <router-link v-show="legajo" exact-active-class="active" to="/menu_estado" tag="li"><a>Estado de la Inscripción</a></router-link>
                <router-link v-show="legajo" exact-active-class="active" to="/menu_situacion_academica" tag="li"><a>Situación Académica</a></router-link>
                <template v-if="!legajo">
                  <router-link v-if="admin" exact-active-class="active" to="/preceptor/bitacora" tag="li"><a>Bitacora</a></router-link>
                  <router-link exact-active-class="active" to="/preceptor/inscripciones_admin" tag="li"><a>Modificaciones de Inscripciones</a></router-link>
                  <router-link exact-active-class="active" to="/preceptor/noticias" tag="li"><a>Noticias</a></router-link>
                  <router-link exact-active-class="active" to="/preceptor/estadisticas" tag="li"><a>Estadisticas</a></router-link>
                  <router-link v-if="admin" exact-active-class="active" to="/periodo_inscripcion" tag="li"><a>Periodo Inscripción</a></router-link>
                </template>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
// Import the EventBus we just created.
import { EventBus } from '../../event-bus.js';
import { store } from '../../store';
import configUrl from '../../services/config.js';
import axios from 'axios';

var url = configUrl.apiUrl;
export default {

  name: 'navbar',

  data () {
    return {
    	alumno: true,
      preceptor: false,
      admin: false,
      nombre:'',
      apellido:'',
      nombre_usuario:"",
      fecha_inicio:'',
      fecha_fin:'',
    };
  },
  store,
  computed: {
    tipo_usuario() {
      return this.$store.state.tipo_usuario;
    },
    legajo() {
      return this.$store.state.legajo;
    },
    mostrarBorrar() {
      return this.legajo!= 0 && !this.alumno;
    },
    fechaInicio() {
      return this.$store.state.fechas.fecha_inicio;
    },
    fechaFin() {
      return this.$store.state.fechas.fecha_fin;
    }
  },
  methods: {
  	cerrarSesion() {
      this.$emit("cerrar");
  	},
  	getDatos(){
      if(localStorage.getItem('datos')){
        let datos = JSON.parse(localStorage.getItem('datos'));
        this.nombre_usuario = datos.nombre_usuario;
        this.nombre = datos.nombre;
        this.apellido = datos.apellido;
        this.$store.state.legajo = datos.legajo || 0;
        if(this.tipo_usuario && this.tipo_usuario == 1){
          this.nombre_usuario = datos.nombre + ' ' + datos.apellido;
          this.alumno = true;
          this.preceptor = false;
          this.admin = false;
        } else if (this.tipo_usuario && this.tipo_usuario == 2) {
          this.alumno = false;
          this.preceptor = true;
          this.admin = false;
        } else if(this.tipo_usuario && this.tipo_usuario == 3) {
          this.alumno = false;
          this.preceptor = false;
          this.admin = true;
        }
      }
  	},
    borrarLegajo() {
      let datos = JSON.parse(localStorage.getItem('datos'));
      datos.legajo = 0;
      delete datos.legajo;
      localStorage.setItem('datos', JSON.stringify(datos));
      this.$store.state.legajo = 0;
      this.$router.push('/');
    },
    getPeriodo(){
      let urlPeriodo = url + 'mostrarPeriodo.php';
      let token = localStorage.getItem('token');
      axios.get(urlPeriodo,{ 
        params: {
          token: token
        }
      })
      .then(response => {
        this.$store.state.fechas.fecha_inicio = response.data.fechas.fecha_inicio;
        this.$store.state.fechas.fecha_fin = response.data.fechas.fecha_fin;
      }).catch(err=>{
        let codigo_error = err.response.status;
        this.modalMensaje = err.response.data.mensaje;
        console.log(codigo_error);
        if(codigo_error == 403){
          EventBus.$emit("cerrar", err.response.data.mensaje);
        } else {
          $("#modal-final").modal();
        }
      })
    },
  },
  mounted() {
    this.getDatos();
    this.getPeriodo();
  },
  created() {
    EventBus.$on('cambiarLegajo', (legajo) => {
      this.$store.state.legajo = legajo;
    });
  },
  filters: {
    fechaConFormato(fecha) {
      let array1 = fecha.split('-');
      let array2 = array1.reverse();
      return array2.join('-');
    }
  }
};
</script>

<style lang="css" scoped>
  .fechas {
    margin-top: 10px;
  }
  .nav-tabs {
    border:0px;
  }
</style>
