<template>
	<footer>
			<div class=" gradiente_nav">
				<div class="container" >
					<div class="col-md-3 col-sm-4">
						<img class=" img-responsive tamano-propio center-block" src="img/logobanner.png" alt="">
					</div>
					<div class="col-md-6 col-sm-4">
						<a href="#" target="_blank">
							<img class=" img-responsive center-block tamano-propio img-rounded" src="img/logo22-1.png"  alt="soluciones practicas">
						</a>
					</div>
					<div class="col-md-3 col-sm-4">
						<a href="https://www.facebook.com/ISFT179/" target="_blank">
							<img class="img-responsive center-block fotos1" src="img/facebook3.png" alt="">
						</a>
					</div>
					<div class="col-md-12 col-sm-12 text-center" >
						<p>
						 MIMF 1.0 <i class="fa fa-copyright" aria-hidden="true"></i> 2017 Soluciones Prácticas | <i class="fa fa-registered" aria-hidden="true"></i>
							<a href="#" target="_blank">
						  	ISFT N°179
							</a> | 
						 	<a href="#" target="_blank"> 
						 		Contacto con Soporte Técnico
						 	</a>
						</p>
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

	/* footer estilos de las fotos y dimensiones de del pie.*/

	.tamano-propio{
	  margin-top: 5px;
	  height: 64px;
	}

	footer div{
	  max-height: 15%;
	  min-height: 15%;
	  bottom:0px;
	}

	footer div div{
		max-height: 15%;
	  min-height: 15%;
	} 

	.fotos1{
	  width: 64px;
	  height: 64px;
	  margin-top: 5px;
	}
	.container div p{
	  margin-top: 10px;
	}
</style>
