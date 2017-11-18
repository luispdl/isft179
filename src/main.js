import Vue from 'vue'

import VueRouter from 'vue-router'

import App from './App.vue'
import Cabecera from './components/layout/Cabecera.vue'
import Navbar from './components/layout/Navbar.vue'
import Pie from './components/layout/Pie.vue'

import routes from './routes'

Vue.use(VueRouter);

const router = new VueRouter({
	routes,
});

function estaLogueado() {
  return !!localStorage.token;
}

function legajo() {
  return JSON.parse(localStorage.getItem('datos')).legajo;
}

function tipoUsuario() {
  return JSON.parse(localStorage.getItem('datos')).tipo_usuario;
}

router.beforeEach((to, from , next ) => {
  let ruta_para_registro = to.matched[0].path;
  if (to.path != '/login' && ruta_para_registro != '/registro/:usuario' && !estaLogueado()) {
    next('/login');
  } else {
    next();
  }
});

Vue.component('pie', Pie);
Vue.component('navbar', Navbar);
Vue.component('cabecera', Cabecera);

new Vue({
  el: '#app',
  router,
  render: h => h(App)
})
