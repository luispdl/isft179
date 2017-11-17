import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
	state: {
		registrado: false,
		tipo_usuario: getTipoUsuario(),
		legajo: getLegajo(),
	}
});

function getTipoUsuario() {
	let datos = JSON.parse(localStorage.getItem('datos'));
	if(datos) {
		return datos.tipo_usuario;
	} else {
		return 0
	}
}

function getLegajo() {
	let datos = JSON.parse(localStorage.getItem('datos'));
	if(datos) {
		return datos.legajo;
	} else {
		return 0
	}
}