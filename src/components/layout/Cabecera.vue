<template>
  <header>
    <nav class="navbar gradiente_nav" role="navigation">
      <div class="container">
        <div class="navbar-header ">
          <button type="button" class="navbar-toggle collapsed gradiente_responsive" data-toggle="collapse" data-target="#navegación-PP">
            <span class="sr-only">Desplegar / Ocultar Menu</span>
            <span class="icon-bar icon1"></span>
            <span class="icon-bar icon1"></span>
            <span class="icon-bar icon1"></span>              
          </button>
          <img class="navbar-brand imagen_institucional" src="img/isft.png">
          <a href="#" class="navbar-brand tipo_fuentes logo_institucional">ISFT N°179 </a>
        </div>
        <!-- inicio menu la parte de noticias-->
        <div class="collapse navbar-collapse botones_operativos" id="navegación-PP">
          <ul class="nav navbar-nav navbar-right" v-show="$store.state.registrado">
            <li class="dorpdown">
              <a href="#" class="color_fuentes dropdown-toggle " data-toggle="dropdown" role="button" ><i class="fa fa-cog" aria-hidden="true" ald="notificaciones"></i> Configuración<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <router-link to="/editar" tag="li"><a>Editar Perfil</a></router-link>
                <router-link v-if="tipo_usuario==3" to="/registro/preceptor" tag="li"><a>Registrar Preceptor</a></router-link>
                <li class="divider"></li>
                <li><a href="#" @click="cerrarSesion">Cerrar Sesión</a></li>              
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="color_fuentes dropdown-toggle" data-toggle="dropdown" role="button" ><i class="fa fa-paint-brush" aria-hidden="true" ald="notificaciones" ></i><span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#"><div class="opcion1"></div></a></li>
                <li><a href="#"><div class="opcion2"></div></a></li>  
                <li><a href="#"><div class="opcion3"></div></a></li>            
              </ul>
            </li>
            <li ><a class="color_fuentes " href="#"><i class="fa fa-home" aria-hidden="true"></i></a></li>
          </ul> 
        </div>
      </div>
    </nav>
  </header>

</template>

<script>
  import {store} from '../../store';

export default {
  name: 'cabecera',
  store,
  data () {
    return {
      alumno: true,
      preceptor: false,
      admin: false,
      mostrarTipo: '',
    }
  },
  computed: {
    tipo_usuario() {
      return this.$store.state.tipo_usuario;
    }
  },
  methods: {
    cerrarSesion() {
      localStorage.removeItem('datos');
      localStorage.removeItem('token');
      this.$store.state.registrado = false;
      this.$router.push('/login');
    },
  },
}
</script>

<style scoped>
  .navbar {
    margin-bottom: 0;
  }
  .tipo_fuentes{
    font-size:20px;
    font-style:"arial";
  }
  .color_fuentes{
    color: white;
  }
  .logo_institucional{
    overflow: normal;
    line-height: 36px;
  }
  .imagen_institucional {
    float: left; 
    width: 65px; 
    height: 65px;
  }
  .gradiente_responsive {
    background: silver; /* For browsers that do not support gradients */
    background: -webkit-linear-gradient(left top, silver, white); /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(bottom right, silver, white); /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(bottom right, silver, white); /* For Firefox 3.6 to 15 */
    background: linear-gradient(to bottom right, silver, white); /* Standard syntax */
    
  }
  .gradiente_responsive:hover{
    background: silver; /* For browsers that do not support gradients */
    background: -webkit-linear-gradient(left top, white, silver); /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(bottom right, white, silver); /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(bottom right, white, silver); /* For Firefox 3.6 to 15 */
    background: linear-gradient(to bottom right,white, silver); /* Standard syntax */
  }
  /*paleta de colores*/
  .opcion1{
    border: solid 1px black; 
    padding: 5px;
    background: blue; /* color de referencia */
    background: -webkit-linear-gradient(left,rgba(0,0,255,0.2),rgba(0,0,255,1.5)); /* para navegadores Safari */
    background: -o-linear-gradient(right,rgba(0,0,255,0.2),rgba(0,0,255,1.5)); /*para navegadores Opera */
    background: -moz-linear-gradient(right,rgba(0,0,255,0.2),rgba(0,0,255,1.5)); /*para navegadores Fx */
    background: linear-gradient(to right, rgba(0,0,255,0.2), rgba(0,0,255,1.5)); /*para navegadores Standard*/

  }
  .opcion2{
    border: solid 1px black; 
    padding: 5px;
    background: aqua; /* color de referencia */
    background: -webkit-linear-gradient(left,rgba(0,0,255,0.2),rgba(0,0,255,0.7)); /* para navegadores Safari */
    background: -o-linear-gradient(right,rgba(0,0,255,0.2),rgba(0,0,255,0.7)); /*para navegadores Opera */
    background: -moz-linear-gradient(right,rgba(0,0,255,0.2),rgba(0,0,255,0.7)); /*para navegadores Fx */
    background: linear-gradient(to right, rgba(0,0,255,0.2), rgba(0,0,255,0.7)); /*para navegadores Standard*/
  }
  .opcion3{
    border: solid 1px black; 
    padding: 5px;
    background: silver;/* color de referencia */
    background: -webkit-linear-gradient(left,rgba(100,118,135,0.2),rgba(100,118,135,0.7)); /* para navegadores Safari */
    background: -o-linear-gradient(right,rgba(100,118,135,0.2),rgba(100,118,135,0.7)); /*para navegadores Opera */
    background: -moz-linear-gradient(right,rgba(100,118,135,0.2),rgba(100,118,135,0.7)); /*para navegadores Fx */
    background: linear-gradient(to right, rgba(100,118,135,0.2), rgba(100,118,135,0.7)); /*para navegadores Standard*/
  }
</style>