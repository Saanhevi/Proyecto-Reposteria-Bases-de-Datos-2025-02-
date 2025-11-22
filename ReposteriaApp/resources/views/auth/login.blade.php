<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Repostería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/logStyles.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="brand-header">
                <div class="brand-logo">
                    <div class="logo-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L13.09 8.26L20 9.27L15 14.14L16.18 21.02L12 17.77L7.82 21.02L9 14.14L4 9.27L10.91 8.26L12 2Z" fill="#1F2937"/>
                        </svg>
                    </div>
                    <div class="logo-text">repostería</div>
                </div>
                <div class="brand-subtitle">DANICO USERS - LA MESA Cundinamarca</div>
            </div>
            
            <h2 class="login-title">Iniciar Sesión</h2>

            {{-- FORMULARIO REAL DE LOGIN --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="identification" class="form-label">Identificación</label>
                    <input type="text" id="identification" 
                           name="usuario"
                           class="form-input" 
                           placeholder="Ingrese su identificación"
                           required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password"
                           name="password"
                           class="form-input" 
                           placeholder="Ingrese su contraseña"
                           required>
                </div>

                @if(session('error'))
                    <p style="color:red; margin-bottom:10px;">
                        {{ session('error') }}
                    </p>
                @endif

                <button type="submit" class="login-button">INICIAR SESIÓN</button>
            </form>

            <a href="#" class="contact-admin">Contactar con administrador</a>
        </div>
    </div>

</body>
</html>
