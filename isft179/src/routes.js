import Cabecera from './components/layout/Cabecera.vue'
import Login from './components/Login.vue'
import Registro from './components/Registro.vue'
import Finales from './components/Finales.vue'
import Estado from './components/Estado.vue'
import Situacion from './components/Situacion.vue'
import Home from './components/Home.vue'
import Noticias from './components/Noticias.vue'
import Noticia from './components/Noticia.vue'
import InscAdmin from './components/InscAdmin.vue'
import PeriodoInscripcion from './components/PeriodoInscripcion.vue'
import Navbar from './components/layout/Navbar.vue'
import Pie from './components/layout/Pie.vue'
import Preceptor from './components/Preceptor.vue'
import Alumno from './components/Alumno.vue'
import EditarPerfil from './components/EditarPerfil.vue'
import ReiniciarClave from './components/ReiniciarClave.vue'
import Admin from './components/Admin.vue'
import Preceptores from './components/Preceptores.vue'
import EditarPassword from './components/EditarPassword.vue'
import Bitacora from './components/Bitacora.vue'
import Estadisticas from './components/Estadisticas.vue'

const routes = [
	{ path: '/', component: Home},
  { path: '/registro/:usuario', component: Registro},
  { path: '/editar', component: EditarPerfil},
  { path: '/alumno', component:Alumno ,
    children: [
      { path: '/menu_finales', component: Finales },
      { path: '/menu_estado', component: Estado},
      { path: '/menu_situacion_academica', component: Situacion },
    ],
    beforeEnter: (to, from, next) => {
      if(legajo()) {
        next();
      } else {
        next('/');
      }
    }
  },
  { path: '/preceptor', component: Preceptor,
    children: [
      { path: 'noticias', component: Noticias},
      { path: 'noticia', component:Noticia},
      { path: 'noticia/:id', component: Noticia},
      { path: 'inscripciones_admin', component: InscAdmin},
      { path: 'reiniciar_clave', component: ReiniciarClave},
      { path: 'bitacora', component: Bitacora},
      { path: 'bitacora/:usuario_id', component: Bitacora},
      { path: 'estadisticas', component: Estadisticas},
    ],
    beforeEnter: (to, from, next) => {
      if(tipoUsuario()==2 || tipoUsuario()==3 ) {
        next();
      } else {
        next('/');
      }
    }
  },
  { path: '/admin', component: Admin,
    children: [
      { path: 'preceptores', component: Preceptores},
      { path: 'editar_password/:usuario', component: EditarPassword},
      { path: '/periodo_inscripcion', component:PeriodoInscripcion},
    ],
    beforeEnter: (to, from, next) => {
      if(tipoUsuario()==3 ) {
        next();
      } else {
        next('/');
      }
    }
  },
  { path: '/periodo_inscripcion', component: PeriodoInscripcion},
  { path: '/login', component: Login, 
    beforeEnter: (to, from, next) => {
      if(estaLogueado()) {
        next('/');
      } else {
        next();
      }
    }
  },
];

function estaLogueado() {
  return !!localStorage.token;
}

function legajo() {
  return JSON.parse(localStorage.getItem('datos')).legajo;
}

function tipoUsuario() {
  return JSON.parse(localStorage.getItem('datos')).tipo_usuario;
}

export default routes