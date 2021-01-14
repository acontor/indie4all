<footer class="bg-light text-center text-lg-start">
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Info del Proyecto</h5>
                <p>
                    Este proyecto ha sido realizado por Älvaro Conde Torres y Justo Medina Solano
                    como proyecto final para el ciclo formativo de Desarrollo de Aplicaciones Web
                    impartido en el I.E.S Trassierra.
                </p>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Links de interés</h5>
                <ul class="list-unstyled mb-0">
                    <li>
                        <a href="{{ route('usuario.acerca') }}" class="text-dark">Acerca de nosotros</a>
                    </li>
                    <li>
                        <a href="{{ route('usuario.desarrolladora') }}" class="text-dark">¿Tienes una
                            desarrolladora?</a>
                    </li>
                    <li>
                        <a href="{{ route('usuario.master') }}" class="text-dark">¿Quieres ser master?</a>
                    </li>
                    <li>
                        <a href="{{ route('usuario.faq') }}" class="text-dark">Política de privacidad</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase mb-0">Menú</h5>
                <ul class="list-unstyled">
                    <li>
                        <a href="#!" class="text-dark">Portal</a>
                    </li>
                    <li>
                        <a href="{{ route('usuario.masters.index') }}" class="text-dark">Masters</a>
                    </li>
                    <li>
                        <a href="{{ route('usuario.desarrolladoras.index') }}" class="text-dark">Desarrolladoras</a>
                    </li>
                    <li>
                        <a href="{{ route('usuario.juegos.index') }}" class="text-dark">Juegos</a>
                    </li>
                    <li>
                        <a href="{{ route('usuario.campanias.all') }}" class="text-dark">Campañas</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
