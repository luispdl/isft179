<template>
	<div class="container">
		<h1>Búsqueda de usuarios</h1>
		<div class="container formulario">
			<form class="form-inline">
				<div class="col-md-2"></div>
			  <div class="form-group col-md-6">
			    <label for="legajo" class="col-md-6">Legajo</label>
			    <input v-model="inputLegajo" type="number" class="form-control col-md-5" id="legajo" name="legajo">
			  </div>
			  <button @click="buscarPorLegajo" type="button" class="btn btn-primary col-md-1"><span class="hidden-md glyphicon glyphicon-search" aria-hidden="true"></span><span class="hidden-sm"> Buscar</span></button>
			</form>

			<form class="form-inline">
				<div class="col-md-2"></div>
				<div class="form-group col-md-6">
					<label for="nombre" class="col-md-6">Apellido y Nombre</label>
					<input v-model="nombre" type="text" class="form-control col-md-5" placeholder="PEREZ JUAN" name="nombre">
				</div>
				<button @click="buscarPorNombre" type="button" class="btn btn-primary col-md-1"><span class="hidden-md glyphicon glyphicon-search" aria-hidden="true"></span><span class="hidden-sm"> Buscar</span></button>
			</form>

			<form class="form-inline">
				<div class="col-md-2"></div>
				<div class="form-group col-md-6">
					<label for="dni" class="col-md-6">DNI</label>
					<input v-model="dni" type="text" class="form-control col-md-5" name="dni">
				</div>
				<button @click="buscarPorDni" type="button" class="btn btn-primary col-md-1"><span class="hidden-md glyphicon glyphicon-search" aria-hidden="true"></span><span class="hidden-sm"> Buscar</span></button>
			</form>
		</div>
		<hr>
		<div v-show="!sinResultado" class="row container">
			<h3>Alumnos encontrados.</h3>
			<table class="table table-striped">
				<thead>
					<tr>
						<td>Legajo</td>
						<td>Nombre</td>
						<td>Apellido</td>
						<td>Nro Documento</td>
						<td>Nombre de usuario</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<tr v-for="alumno in alumnos">
						<td>{{alumno.legajo}}</td>
						<td>{{alumno.nombre}}</td>
						<td>{{alumno.apellido}}</td>
						<td>{{alumno.numero_documento}}</td>
						<td><a @click="seleccionarAlumno(alumno.legajo)" class="btn btn-success"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Seleccionar</a></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="sinResultado text-center" v-show="sinResultado"> No hay alumnos encontrados.</div>
		<modal-notificacion :continuar="continuar" :claseModal="claseModal" :tituloModal="tituloModal" :redireccion="redireccion" :mensajeRespuesta="mensajeRespuesta"></modal-notificacion>
	</div>
</template>

<script>
export default {

  name: 'ReiniciarClave',

  data () {
    return {

    }
  }
}
</script>

<style lang="css" scoped>
</style>