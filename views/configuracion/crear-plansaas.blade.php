 @extends ('adminsite.layout')
 
 @section('ContenidoSite-01')



		
		<form action="{{url('suscripcion/crear-plan')}}" method="post" role="form">
			<legend>Form title</legend>
		
			<div class="form-group">
				<label for="">ID Plan</label>
				<input type="text" name="id_plan" class="form-control">
			</div>
			<div class="form-group">
				<label for="">Nombre plan</label>
				<input type="text" name="name" class="form-control">
			</div>
			<div class="form-group">
				<label for="">Descripcion</label>
				<input type="text" name="description" class="form-control">
			</div>
			<div class="form-group">
				<label for="">Valor</label>
				<input type="text" name="amount" class="form-control">
			</div>
			<div class="form-group">
				<label for="">Moneda</label>
				<input type="text" name="moneda" class="form-control" value="COP">
			</div>
			<div class="form-group">
				<label for="">Intervalo</label>
				<input type="text" name="intervalo" class="form-control">
			</div>
			<div class="form-group">
				<label for="">Intervalo conteo</label>
				<input type="text" name="int_conteo" class="form-control">
			</div>
			<div class="form-group">
				<label for="">Dias Trial</label>
				<input type="text" name="trial" class="form-control">
			</div>
	
			<button type="submit" class="btn btn-primary">Submit</button>
	
		</div>
	
 @stop

			
		