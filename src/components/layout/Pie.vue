<template>
	<footer>
			<div class=" gradiente_nav">
				<div class="container" >
					<div class="col-md-3 col-sm-4">
						<img class=" img-responsive tamano-propio center-block" src="img/logobanner.png" alt="">
					</div>
					<div class="col-md-6 col-sm-4">
						<img class=" img-responsive center-block tamano-propio img-rounded" src="img/logo22-1.png"  alt="soluciones practicas">
					</div>
					<div class="col-md-3 col-sm-4">
						<img class="img-responsive center-block fotos1" src="img/facebook3.png" alt="" style="">
					</div>
					<div class="col-md-12 col-sm-12 text-center" >
						
						<p> MIMF <i class="fa fa-copyright" aria-hidden="true"></i>2017 1.0 | <a href="#">ISFT N°179</a> | <a href="#"> Soluciones Practicas</a></p>
						
					</div>
				</div>
			</div>
		</footer>
</template>

<script>
export default {

  name: 'Pie',

  data () {
    return {

    };
  }
};
</script>

<style lang="css" scoped>
	#pie {
	  margin-bottom: 0px;
	  padding-bottom: 0px;
	}
	.gradiente_nav {
	  background: aqua; /* color de referencia */
	  background: -webkit-linear-gradient(left,rgba(0,0,255,0.2),rgba(0,0,255,0.7)); /* para navegadores Safari */
	  background: -o-linear-gradient(right,rgba(0,0,255,0.2),rgba(0,0,255,0.7)); /*para navegadores Opera */
	  background: -moz-linear-gradient(right,rgba(0,0,255,0.2),rgba(0,0,255,0.7)); /*para navegadores Fx */
	  background: linear-gradient(to right, rgba(0,0,255,0.2), rgba(0,0,255,0.7)); /*para navegadores Standard*/
	}
	/* footer estilos de las fotos y dimensiones de del pie.*/

	.tamano-propio{
	  margin-top: 5px;
	  width: 200px;
	  height: 90px;
	}
	.fotos1{
	  width: 100px;
	  height: 100px;
	  margin-top: 5px;
	}

	.container div p{
	  margin-top: 5px;
	}
</style>
