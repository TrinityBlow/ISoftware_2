<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>




    <title>Viaje Facil</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/body_align_layout.css" rel="stylesheet">

  </head>

  <body class="sticky-footer">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Viaje F&aacute;cil</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Inicio
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Ayuda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contacto</a>
            </li>
             <!-- Authentication Links -->
             @guest
             <li><a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a></li>
             <li><a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a></li>
              @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      
                        <a class="dropdown-item" href="/mi_usuario" class="list-group-item">Mi usuario</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
              @endguest
          </ul>
        </div>
      </div>
    </nav>

    
    <!-- Page Content -->

    
    <div class="container margin_fix">

      <div class="row">

        <div class="col-lg-3 col-sm-4">
          
          <div class="list-group mt-4">
            <a href="/viajes/buscarViajes" class="list-group-item active">Buscar viaje</a>
            <a href="#" class="list-group-item">Crear viaje</a>
            @auth
            @endauth
          </div>
        <!-- /.col-lg-3 -->

        

        </div>
      <!-- /.container -->
      <div class="container col-sm-8 mt-4">
        @yield('content')
      </div>

      </div>

    </div>
    <!-- Footer -->
    <footer class="py-5 bg-dark sticky-footer">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Viaje Fácil 2018</p>
      </div>
      <!-- /.container -->
    </footer>

  </body>

</html>
