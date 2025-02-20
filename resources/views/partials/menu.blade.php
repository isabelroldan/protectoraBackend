<nav style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 2rem; background-color: #fff; border-bottom: 1px solid #eaeaea;">
    <!-- Logo -->
    <div style="font-family: 'Brush Script MT', cursive; font-size: 2rem; color: #FFC382;">
        Pelitos y Bigotes
    </div>

    <!-- Opciones del Menú -->
    <ul style="list-style: none; display: flex; gap: 1.5rem; margin: 0; padding: 0;">
        <li>
            <a href="{{ route('mascota.index') }}" 
               style="text-decoration: none; color: {{ request()->routeIs('mascota.index') ? '#FFC382' : '#000' }}; font-weight: bold;">
               Mascotas
            </a>
        </li>
        <li>
            <a href="{{ route('usuario.index') }}" 
               style="text-decoration: none; color: {{ request()->routeIs('usuario.index') ? '#FFC382' : '#000' }}; font-weight: bold;">
               Usuarios
            </a>
        </li>
        <li>
            <a href="{{ route('mascota.showCreateView') }}" 
               style="text-decoration: none; color: {{ request()->routeIs('mascota.showCreateView') ? '#FFC382' : '#000' }}; font-weight: bold;">
               Añadir Mascota
            </a>
        </li>
        <li>
            <a href="{{ route('solicitud.index') }}" 
               style="text-decoration: none; color: {{ request()->routeIs('solicitud.index') ? '#FFC382' : '#000' }}; font-weight: bold;">
               Solicitudes
            </a>
        </li>
    </ul>
</nav>
