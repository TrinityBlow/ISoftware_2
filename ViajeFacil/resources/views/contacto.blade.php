@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Contacto</div>

        <div class="card-body">
        <form method="POST" action="/contacto/enviarMensaje">
				@csrf

				@auth
					<div class="row">

						<div class="form-group col">
							<label for="name" class="control-label">Nombre:</label>
							<input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
						</div>

						<div class="form-group col">
							<label for="last_name" class="control-label">Apellido:</label>
							<input type="text" class="form-control" name="last_name" value="{{ Auth::user()->last_name }}" required>
						</div>

					</div>

					<div class="form-group">
						<label for="email" class="control-label">E-Mail:</label>
						<input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
					</div>
				@else
					<div class="row">

						<div class="form-group col">
							<label for="name" class="control-label">Nombre:</label>
							<input type="text" class="form-control" name="name" required>
						</div>

						<div class="form-group col">
							<label for="last_name" class="control-label">Apellido:</label>
							<input type="text" class="form-control" name="last_name" required>
						</div>

					</div>

					<div class="form-group">
						<label for="email" class="control-label">E-Mail:</label>
						<input type="email" class="form-control" name="email" required>
					</div>
				@endauth

                <div class="form-group">
                    <label for="message" class="control-label">Mensaje:</label>
                    <textarea type="text" class="form-control" rows="6" name="message" required></textarea>
                </div>

				<div class="form-group text-center"> <!-- Submit Button -->
					<button type="submit" class="btn btn-primary">Enviar mensaje</button>
				</div>

			</form>
        </div>
    </div>
</div>
@endsection
