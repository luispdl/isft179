<template>
  <div class="container">
  <div class="row text-left">
    <h3>
      <i v-if="alumno" class="fa fa-graduation-cap" aria-hidden="true"></i>
      <i v-if="preceptor" class="fa fa-user" aria-hidden="true"></i>
      <i v-if="admin" class="fa fa-user-secret" aria-hidden="true"></i>
      {{ nombre_usuario }} <small v-if="mostrarBorrar">{{ legajo }} <button class="btn btn-danger">x</button></small>
    </h3>
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
                <template v-if="preceptor || admin">
                  <router-link exact-active-class="active" to="/preceptor/inscripciones_admin" tag="li"><a>Modificaciones de Inscripciones</a></router-link>
                  <router-link exact-active-class="active" to="/preceptor/noticias" tag="li"><a>Noticias</a></router-link>
                  <router-link exact-active-class="active" to="/estadisticas" tag="li"><a>Estadisticas</a></router-link>
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
  },
  mounted() {
    this.getDatos();
  },
  created() {
    EventBus.$on('cambiarLegajo', (legajo) => {
      this.$store.state.legajo = legajo;
    });
  }
};
</script>

<style lang="css" scoped>
  .nav-tabs {
    border:0px;
  }
</style>
