<template>
  <div id="app">
    <cabecera :legajo="legajo" class="hidden-print cabecera" v-on:cerrar='cerrar'></cabecera>
    <div class="main container">
      <navbar v-if="registrado"></navbar>
      <router-view v-on:cambiarLegajo="cambiarLegajo" v-on:iniciar="iniciar" v-on:cerrar="cerrar"></router-view>
    </div>
    <pie></pie>
    <modal-notificacion :redireccion="modal_redireccion" :tituloModal="modal_titulo" :mensajeRespuesta="modal_mensaje" :claseModal="modal_clase" v-on:cerrar='cerrar'></modal-notificacion>
    <modal-cerrar-sesion :mensaje="mensaje_cerrar"></modal-cerrar-sesion>
  </div>
</template>

<script>
  import ModalNotificacion from './components/ModalNotificacion.vue';
  import { EventBus } from './event-bus.js';
  import ModalCerrarSesion from './components/ModalCerrarSesion.vue';
  import {store} from './store';

export default {
  name: 'app',
  data () {
    return {
      modal_clase:"",
      modal_mensaje: "",
      modal_redireccion: "",
      modal_titulo: "",
      mensaje_cerrar: "",  
    }
  },
  store,
  computed : {
    registrado() {
      return this.$store.state.registrado;
    },
    legajo() {
      return this.$store.state.legajo;
    }
  },
  components : {
    ModalNotificacion,
    ModalCerrarSesion,
  },
  methods : {
    iniciar() {
      var datos = JSON.parse(localStorage.getItem('datos'));
      this.$store.state.tipo_usuario = datos.tipo_usuario;
      this.$store.state.legajo = datos.legajo? datos.legajo : 0 ;
      this.$store.state.registrado = true;
      this.$router.push('/')
    },
    registrar() {
      this.modal_redireccion = '/';
      this.modal_mensaje = 'Alumno registrado con exito. Inicie Sesión';
      this.modal_titulo = "Excelente";
      this.modal_clase = 'bg-success';
      $('#modal-final').modal();
    },
    cerrar(mensaje_cerrar) {
      this.mensaje_cerrar = mensaje_cerrar;

    },
    cambiarLegajo() {
      this.$store.state.legajo = localStorage.getItem('datos').legajo;
    }
  },
  mounted: function(){
    EventBus.$on('cerrar', mensaje => {
      console.log("cerrando");
      this.cerrar(mensaje);
    });
    var token = localStorage.getItem('token');
    var datos = JSON.parse(localStorage.getItem('datos'));
    if(token){
      this.$store.state.registrado = true;
      this.$store.state.legajo = datos.legajo;
    }
  },
}
</script>

<style>
#app {
  height: 100%;
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
}
.main {
  min-height: 75%;
  border-bottom: 1px solid silver
}
.cabecera {
  height: 10%;
}
</style>
