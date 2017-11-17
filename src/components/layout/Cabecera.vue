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
              <a href="#" class="color_fuentes dropdown-toggle " data-toggle="dropdown" role="button" ><i class="fa fa-cog" aria-hidden="true" ald="notificaciones" ></i> Configuración <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <router-link to="/editar" tag="li"><a>Editar Perfil</a></router-link>
                <router-link v-if="tipo_usuario==3" to="/registro/preceptor" tag="li"><a>Registrar Preceptor</a></router-link>
                <li class="divider"></li>
                <li><a href="#" @click="cerrarSesion">Cerrar Sesión</a></li>              
              </ul>
            </li>

            <li class="dropdown" id="paleta_colores">
                <a href="#" class="color_fuentes dropdown-toggle" data-toggle="dropdown" role="button" ><i class="fa fa-paint-brush" aria-hidden="true" ald="notificaciones" ></i><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#"><div class="opcion1"></div></a></li>
                    <li><a href="#"><div class="opcion2"></div></a></li>  
                    <li><a href="#"><div class="opcion3"></div></a></li>            
                  </ul>
              </li>
              
              
              <li class="dropdown" id="letras_forma">
                <a href="#" class="color_fuentes dropdown-toggle" data-toggle="dropdown" role="button" ><i class="fa fa-etsy" aria-hidden="true"></i><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#"><div><p >E</p></div></a></li>
                    <li><a href="#"><div><p >E</p></div></a></li> 
                    <li><a href="#"><div><p >E</p></div></a></li>           
                  </ul>
              </li>
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
  /* navbar de la parte responsive de dispositivos como tablets y celulares.*/

  .icon-bar{
    background-color: black;
  }
  .corregircaja{ 
        margin-top:-5pt;
        padding: 10pt; 
    }


  /*en esta parte son los colores de efecto que se le da el boton responsive.*/

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

  /* navbar de la parte de escritorio tamaño pc*/


  .tipo_fuentes{
    font-size:20px;
    font-style:arial;
     
  }
  .logo_institucional{
    overflow: normal;
    line-height: 36px;

  }
  .botones_operativos{
    margin-top: 8px;
  }

  .imagen_institucional{
    float: left; 
    width: 65px; 
    height: 65px;
  }
  .color_fuentes{
    color: white;
  }

  .navbar{
    margin-bottom: 0;
  }


  .navbar .container .collapse ul li a{
    transition: linear all 0.3s;
  }

  /*dropdown de la paleta de colores y letras que se pueden cambiar*/

  #paleta_colores{
    padding-left: 5px;
    padding-right: 1.5px;
  }

  #paleta_colores ul{
    min-width: 50px;
    
  }

  #paleta_colores ul li{
    width: 54.5px;
  }


  #paleta_colores ul li a{
    height: 40px;
    width: 40px;
    padding-left: 3px;
    padding-right: 0px;
    margin-left: 7px;
  }


  #paleta_colores ul li a div{
    padding: 5px;
    border: solid 1px black;
    width: 32px;
    height: 32px;
  }
  .opcion1{
    
    background: blue; /* color de referencia */
    background: -webkit-linear-gradient(left,rgba(0,0,255,0.2),rgba(0,0,255,1.5)); /* para navegadores Safari */
    background: -o-linear-gradient(right,rgba(0,0,255,0.2),rgba(0,0,255,1.5)); /*para navegadores Opera */
    background: -moz-linear-gradient(right,rgba(0,0,255,0.2),rgba(0,0,255,1.5)); /*para navegadores Fx */
    background: linear-gradient(to right, rgba(0,0,255,0.2), rgba(0,0,255,1.5)); /*para navegadores Standard*/

  }
  .opcion2{
    
    background: aqua; /* color de referencia */
    background: -webkit-linear-gradient(left,rgba(0,0,255,0.2),rgba(0,0,255,0.5)); /* para navegadores Safari */
    background: -o-linear-gradient(right,rgba(0,0,255,0.2),rgba(0,0,255,0.5)); /*para navegadores Opera */
    background: -moz-linear-gradient(right,rgba(0,0,255,0.2),rgba(0,0,255,0.5)); /*para navegadores Fx */
    background: linear-gradient(to right, rgba(0,0,255,0.2), rgba(0,0,255,0.5)); /*para navegadores Standard*/
  }
  .opcion3{
    
    background: silver;/* color de referencia */
    background: -webkit-linear-gradient(left,rgba(100,118,135,0.2),rgba(100,118,135,0.7)); /* para navegadores Safari */
    background: -o-linear-gradient(right,rgba(100,118,135,0.2),rgba(100,118,135,0.7)); /*para navegadores Opera */
    background: -moz-linear-gradient(right,rgba(100,118,135,0.2),rgba(100,118,135,0.7)); /*para navegadores Fx */
    background: linear-gradient(to right, rgba(100,118,135,0.2), rgba(100,118,135,0.7)); /*para navegadores Standard*/
  }

  /*dropdown del tamaño de las letras que se pueden modificar*/

  #letras_forma{
    padding-left: 5px;
    padding-right: 1.5px;
  }

  #letras_forma a{
    padding-right: 14px;
  }

  #letras_forma ul{
    min-width: 53px;
    margin-right: 0.5px;
    
  }

  #letras_forma ul li{
    width: 51.5px;
  }


  #letras_forma ul li a{
    height: 40px;
    width: 40px;
    padding-left: 4px;
    padding-right: 0px;
    margin-left: 7px;
  }

  #letras_forma ul li a div{
    padding: 5px;
    border: solid 1px black;
    width: 32px;
    height: 32px;
  }

  #letras_forma ul li:nth-child(1) a div p{
    font-size: 12px; 
    text-align: center; 
    margin-top: 2px; 
  }

  #letras_forma ul li:nth-child(2) a div p{
    font-size: 16px; 
    text-align: center; 
    margin-top: -1px;
  }

  #letras_forma ul li:nth-child(3) a div p{
    font-size: 20px; 
    text-align: center; 
    margin-top: -4px;
  }
</style>