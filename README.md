<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Expedientes</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        h2 {
            color: #3498db;
            margin-top: 30px;
        }
        h3 {
            color: #2980b9;
        }
        a {
            color: #3498db;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        code {
            background-color: #f8f8f8;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }
        pre {
            background-color: #f8f8f8;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            border: 1px solid #ddd;
        }
        pre code {
            background-color: transparent;
            padding: 0;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin: 20px 0;
        }
        ul, ol {
            padding-left: 25px;
        }
        li {
            margin-bottom: 8px;
        }
        blockquote {
            border-left: 4px solid #3498db;
            padding-left: 15px;
            margin-left: 0;
            color: #666;
        }
        hr {
            border: none;
            height: 1px;
            background-color: #eee;
            margin: 30px 0;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Bienvenido al Sistema de Gestión de Expedientes! 👋</h1>

        <p>¡Hola! Este es un sistema web que desarrollé con Laravel y Bootstrap 5 para gestionar expedientes de manera eficiente. Permite a los usuarios registrarse, iniciar sesión y gestionar expedientes con diferentes niveles de acceso según su rol.</p>

        <img src="https://via.placeholder.com/800x400?text=Sistema+de+Gesti%C3%B3n+de+Expedientes" alt="Sistema de Gestión de Expedientes">

        <h2>¿Qué puedes hacer con este sistema? 🚀</h2>

        <ul>
            <li>Autenticarte con diferentes roles (administrador o usuario normal)</li>
            <li>Crear, ver, editar y eliminar expedientes (¡con borrado lógico!)</li>
            <li>Filtrar expedientes por estatus, fechas o texto</li>
            <li>Trabajar desde cualquier dispositivo gracias a su diseño responsive</li>
            <li>Y mucho más...</li>
        </ul>

        <h2>Lo que necesitas para instalarlo 🛠️</h2>

        <p>Antes de empezar, asegúrate de tener:</p>

        <ul>
            <li>PHP 8.1 o superior (¡las nuevas características son geniales!)</li>
            <li>Composer (el mejor gestor de dependencias para PHP)</li>
            <li>PostgreSQL 10 o superior (nuestro motor de base de datos)</li>
            <li>Node.js y npm (para los assets de frontend)</li>
            <li>Git (para clonar el proyecto)</li>
        </ul>

        <h2>Instalación paso a paso 🔧</h2>

        <h3>1. Preparando tu entorno (si usas Debian/Ubuntu)</h3>

        <pre><code># Primero actualiza tus repos
sudo apt update

# Instala PHP y sus amigos
sudo apt install -y php php-mbstring php-xml php-curl php-pgsql php-zip unzip

# PostgreSQL, para guardar todos nuestros datos
sudo apt install -y postgresql postgresql-contrib

# Composer, nuestro gestor de dependencias favorito
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Node.js y npm para el frontend
sudo apt install -y nodejs npm

# Comprueba que todo esté correctamente instalado
php -v
composer -V
psql --version
node -v
npm -v</code></pre>

        <h3>2. Configurando PostgreSQL</h3>

        <pre><code># Entra a PostgreSQL como superusuario
sudo -u postgres psql

# Crea la base de datos
CREATE DATABASE sistema_expedientes;

# Si prefieres trabajar con otro usuario, crea uno (pero nosotros usaremos postgres)
# CREATE USER mi_usuario WITH PASSWORD 'mi_contraseña';
# GRANT ALL PRIVILEGES ON DATABASE sistema_expedientes TO mi_usuario;

# Sal de PostgreSQL cuando termines
\q</code></pre>

        <h3>3. Clonando el repositorio</h3>

        <pre><code># Clona el repositorio (¡asegúrate de usar la URL correcta!)
git clone https://github.com/altgared/phpLaravel.git
cd phpLaravel</code></pre>

        <h3>4. Instalando las dependencias</h3>

        <pre><code># Instala todo lo que el proyecto necesita
composer install

# Y también las dependencias de frontend
npm install
npm run build</code></pre>

        <h3>5. Configurando el entorno</h3>

        <pre><code># Crea tu archivo de configuración a partir del ejemplo
cp .env.example .env

# Genera una clave de aplicación única
php artisan key:generate</code></pre>

        <h3>6. Personalizando el archivo .env</h3>

        <p>Abre el archivo <code>.env</code> con tu editor favorito y configúralo así:</p>

        <pre><code>APP_NAME="Sistema de Expedientes"
APP_ENV=production
APP_DEBUG=false

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sistema_expedientes
DB_USERNAME=postgres
DB_PASSWORD=expediente</code></pre>

        <h3>7. Migrando la base de datos</h3>

        <pre><code># Este comando creará todas las tablas y añadirá datos iniciales
php artisan migrate --seed</code></pre>

        <h3>8. Configurando permisos</h3>

        <pre><code># Laravel necesita escribir en estos directorios
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache</code></pre>

        <h3>9. ¡Hora de probar el sistema!</h3>

        <pre><code># Inicia el servidor de desarrollo de Laravel
php artisan serve --host=0.0.0.0 --port=8000</code></pre>

        <p>¡Listo! Ahora puedes abrir tu navegador e ir a <a href="http://localhost:8000">http://localhost:8000</a> o http://tu-ip:8000</p>

        <h3>10. Configurándolo en un servidor real (Apache)</h3>

        <p>Si quieres ponerlo en un entorno de producción con Apache:</p>

        <pre><code># Instala Apache y el módulo PHP
sudo apt install -y apache2 libapache2-mod-php

# Habilita el módulo rewrite (importante para Laravel)
sudo a2enmod rewrite
sudo systemctl restart apache2

# Crea un VirtualHost para el sistema
sudo nano /etc/apache2/sites-available/sistema-expedientes.conf</code></pre>

        <p>Copia esto en el archivo de configuración:</p>

        <pre><code>&lt;VirtualHost *:80&gt;
    ServerName sistema-expedientes.local
    DocumentRoot /var/www/phpLaravel/public

    &lt;Directory /var/www/phpLaravel/public&gt;
        AllowOverride All
        Require all granted
    &lt;/Directory&gt;

    ErrorLog ${APACHE_LOG_DIR}/sistema-expedientes-error.log
    CustomLog ${APACHE_LOG_DIR}/sistema-expedientes-access.log combined
&lt;/VirtualHost&gt;</code></pre>

        <p>Y por último, activa el sitio:</p>

        <pre><code>sudo a2ensite sistema-expedientes.conf
sudo systemctl restart apache2</code></pre>

        <h2>Usuarios para probar el sistema 👥</h2>

        <p>¡El sistema ya viene con usuarios para que puedas probarlo inmediatamente!</p>

        <ol>
            <li>
                <strong>Administrador (tiene acceso total)</strong>
                <ul>
                    <li>Email: admin@example.com</li>
                    <li>Contraseña: password</li>
                    <li>¡Prueba a eliminar expedientes y restaurarlos!</li>
                </ul>
            </li>
            <li>
                <strong>Usuario normal (acceso limitado)</strong>
                <ul>
                    <li>Email: usuario@example.com</li>
                    <li>Contraseña: password</li>
                    <li>Solo puede gestionar sus propios expedientes</li>
                </ul>
            </li>
        </ol>

        <h2>Cómo está organizado el proyecto 📁</h2>

        <p>El proyecto sigue la estructura estándar de Laravel, con algunas carpetas específicas:</p>

        <pre><code>app/
├── Http/
│   ├── Controllers/        # Aquí está toda la lógica de control
│   ├── Middleware/         # Filtros para las peticiones
│   ├── Requests/           # Validaciones de formularios
│   └── Policies/           # Reglas de autorización
├── Models/                 # Modelos que representan las tablas
├── Services/               # La lógica de negocio está aquí
database/
├── migrations/             # Creación de tablas
└── seeders/                # Datos iniciales
resources/
├── views/                  # Todas las vistas del sistema
├── js/                     # JavaScript
└── css/                    # Estilos
public/                     # Archivos públicos
routes/                     # Definición de URLs</code></pre>

        <h2>Lo que pueden hacer los usuarios 👨‍💼</h2>

        <h3>Como Administrador podrás:</h3>
        <ul>
            <li>Ver absolutamente todos los expedientes (¡incluso los eliminados!)</li>
            <li>Crear expedientes nuevos cuando quieras</li>
            <li>Editar cualquier expediente existente</li>
            <li>Eliminar expedientes (no te preocupes, es un borrado lógico)</li>
            <li>Restaurar expedientes que hayas eliminado</li>
            <li>Usar todos los filtros para encontrar rápidamente lo que buscas</li>
        </ul>

        <h3>Como Usuario normal podrás:</h3>
        <ul>
            <li>Ver solo tus propios expedientes</li>
            <li>Crear tus propios expedientes</li>
            <li>Editarlos cuando necesites actualizarlos</li>
            <li>Aplicar filtros para organizarte mejor</li>
        </ul>

        <h2>Si algo no funciona... 🔧</h2>

        <h3>¿Problemas con los permisos?</h3>
        <pre><code>chmod -R 775 storage bootstrap/cache
chown -R $USER:www-data storage bootstrap/cache</code></pre>

        <h3>¿PostgreSQL no conecta?</h3>
        <p>Asegúrate de que esté funcionando:</p>
        <pre><code>sudo systemctl status postgresql</code></pre>

        <h3>¿Algún error con las dependencias?</h3>
        <p>Prueba actualizándolas:</p>
        <pre><code>composer update
npm update</code></pre>

        <h3>¿La aplicación se comporta raro después de cambios?</h3>
        <p>Limpia las cachés:</p>
        <pre><code>php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear</code></pre>

        <h2>¿Necesitas ayuda? 📞</h2>

        <p>Si tienes alguna duda o sugerencia, ¡no dudes en contactarme!</p>
        <ul>
            <li>GitHub: <a href="https://github.com/altgared">https://github.com/altgared</a></li>
            <li>Correo: emaho.altamira@gmail.com</li>
        </ul>

        <hr>

        <p>Desarrollé este sistema como parte de una prueba técnica para ATDT. ¡Espero que te sea útil y fácil de implementar!</p>
    </div>
</body>
</html>
