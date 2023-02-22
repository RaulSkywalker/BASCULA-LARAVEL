<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if (strlen (session('status')) > 0)
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                                {{ session(['status' => '']) }}
                            </div>
                        @endif
                        <!--AQUI HAY OTRA COSA DE ESTAS DE RUTAS-->
                            <form class="form-floating" action="{{ route("grupos.update", ["producto" => $producto->id]) }}" method="post">
                                @csrf
                                @method("PUT")
                                <div class="form-group row">
                                    <input type="hidden" name="oldname" value="{{ $producto->name }}">
                                    <label for="name" class="col-4 col-form-label">Nombre del producto:</label>
                                    <div class="col-8">
                                        <input id="name" name="name" placeholder="nombre del producto" type="text" class="form-control" value="{{ $producto->name }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="importe" class="col-4 col-form-label">Precio del producto:</label>
                                    <div class="col-8">
                                        <input id="importe" name="importe" placeholder="precio del producto" type="text" class="form-control" value="{{ $producto->price }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input type="hidden" name="oldname" value="{{ $producto->image }}">
                                    <label for="name" class="col-4 col-form-label">Imagen del producto:</label>
                                    <div class="col-8">
                                        <input id="name" name="name" placeholder="enlace de la imagen del producto" type="text" class="form-control" value="{{ $producto->image }}">
                                    </div>
                                </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-4 col-8">
                                        <button type="submit" class="btn btn-primary">Modificar</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
