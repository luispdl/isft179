<template>
<div class="container-fluid" style="margin-top: 5%;">



	<div class="panel-group" id="accordion">


		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse1" >
						Cantidad de Alumnos Insc. por Carreras
					</a>
				</h2>
			</div>
			<div id="collapse1" class="panel-collapse collapse">
				<div id="grafica1"></div>
			</div>
		</div>


		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse2" >
						Cantidad de Alumnos Insc. por Turno
					</a>
				</h2>
			</div>
			<div id="collapse2" class="panel-collapse collapse">
				<div id="grafica2"></div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse3" >
						Cantidad de Alumnos Insc. por Materia
					</a>
				</h2>
			</div>
			<div id="collapse3" class="panel-collapse collapse">
				<div id="grafica3"></div>
			</div>
		</div>
	</div>

</div>	

</template>

<script>

export default {
	name: "grafico",
	data(){
		return {

		}
	},
	methods:{
		getGrafico1(){
			this.morris1 = new Morris.Bar({
				  element: 'grafica1',
				  data: [
				    { y: 'Analista de Sistemas', a: 100 },
				    { y: 'Administracion de Empresas', a: 75 },
				    { y: 'Turismo', a: 50 },
				    { y: 'Seguridad y Higiene', a: 75 },
				    { y: 'Textil', a: 50 },
				    { y: 'Robotica', a: 75 },
				  ],
				  xkey: 'y',
				  ykeys: 'a',
				  labels: 'Carreras'
			});
		},
		getGrafico2(){
			this.morris1 = new Morris.Bar({
				  element: 'grafica2',
				  data: [
				    { y: 'Mañana', a: 100 },
				    { y: 'Vespertino', a: 75 },
				  ],
				  xkey: 'y',
				  ykeys: 'a',
				  labels: 'Turnos',
			});
		},
		getGrafico3(){
			this.morris1 = new Morris.Bar({
				  element: 'grafica3',
				  data: [
				    { y: 'Analista de Sistemas', a: 100 },
				    { y: 'Administracion de Empresas', a: 75 },
				    { y: 'Turismo', a: 50 },
				    { y: 'Seguridad y Higiene', a: 75 },
				    { y: 'Textil', a: 50 },
				    { y: 'Robotica', a: 75 },
				  ],
				  xkey: 'y',
				  ykeys: 'a',
				  labels: 'Carreras'
			});
		},
	}

}


</script>