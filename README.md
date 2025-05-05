# 🚀 Sistema de Gestión de Expedientes

¡Hola! Este es un sistema web que desarrollé con Laravel y Bootstrap 5 para gestionar expedientes de manera eficiente. Permite a los usuarios registrarse, iniciar sesión y gestionar expedientes con diferentes niveles de acceso según su rol.

## ✨ ¿Qué puedes hacer con este sistema?

- **Autenticarte** con diferentes roles (administrador o usuario normal)
- **Crear, ver, editar y eliminar** expedientes (¡con borrado lógico!)
- **Filtrar expedientes** por estatus, fechas o texto
- Trabajar desde cualquier dispositivo gracias a su **diseño responsive**
- Y mucho más...

## 🛠️ Lo que necesitas para instalarlo

Antes de empezar, asegúrate de tener:

- **PHP 8.1** o superior (¡las nuevas características son geniales!)
- **Composer** (el mejor gestor de dependencias para PHP)
- **PostgreSQL 10** o superior (nuestro motor de base de datos)
- **Node.js y npm** (para los assets de frontend)
- **Git** (para clonar el proyecto)

## 🔧 Instalación paso a paso

### 1. Preparando tu entorno (si usas Debian/Ubuntu)

```bash
# Primero actualiza tus repos
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
npm -v
```

### 2. Configurando PostgreSQL

```bash
# Entra a PostgreSQL como superusuario
sudo -u postgres psql

# Crea la base de datos
CREATE DATABASE sistema_expedientes;

# Si prefieres trabajar con otro usuario, crea uno (pero nosotros usaremos postgres)
# CREATE USER mi_usuario WITH PASSWORD 'mi_contraseña';
# GRANT ALL PRIVILEGES ON DATABASE sistema_expedientes TO mi_usuario;

# Sal de PostgreSQL cuando termines
\q
```

### 3. Clonando el repositorio

```bash
# Clona el repositorio (¡asegúrate de usar la URL correcta!)
git clone https://github.com/altgared/phpLaravel.git
cd phpLaravel
```

### 4. Instalando las dependencias

```bash
# Instala todo lo que el proyecto necesita
composer install

# Y también las dependencias de frontend
npm install
npm run build
```

### 5. Configurando el entorno

```bash
# Crea tu archivo de configuración a partir del ejemplo
cp .env.example .env

# Genera una clave de aplicación única
php artisan key:generate
```

### 6. Personalizando el archivo .env

Abre el archivo `.env` con tu editor favorito y configúralo así:

```
APP_NAME="Sistema de Expedientes"
APP_ENV=production
APP_DEBUG=false

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sistema_expedientes
DB_USERNAME=postgres
DB_PASSWORD=expediente
```

### 7. Migrando la base de datos

```bash
# Este comando creará todas las tablas y añadirá datos iniciales
php artisan migrate --seed
```

### 8. Configurando permisos

```bash
# Laravel necesita escribir en estos directorios
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 9. ¡Hora de probar el sistema!

```bash
# Inicia el servidor de desarrollo de Laravel
php artisan serve --host=0.0.0.0 --port=8000
```

¡Listo! Ahora puedes abrir tu navegador e ir a http://localhost:8000 o http://tu-ip:8000

### 10. Configurándolo en un servidor real (Apache)

Si quieres ponerlo en un entorno de producción con Apache:

```bash
# Instala Apache y el módulo PHP
sudo apt install -y apache2 libapache2-mod-php

# Habilita el módulo rewrite (importante para Laravel)
sudo a2enmod rewrite
sudo systemctl restart apache2

# Crea un VirtualHost para el sistema
sudo nano /etc/apache2/sites-available/sistema-expedientes.conf
```

Copia esto en el archivo de configuración:

```apache
<VirtualHost *:80>
    ServerName sistema-expedientes.local
    DocumentRoot /var/www/phpLaravel/public

    <Directory /var/www/phpLaravel/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/sistema-expedientes-error.log
    CustomLog ${APACHE_LOG_DIR}/sistema-expedientes-access.log combined
</VirtualHost>
```

Y por último, activa el sitio:

```bash
sudo a2ensite sistema-expedientes.conf
sudo systemctl restart apache2
```

## 👥 Usuarios para probar el sistema

¡El sistema ya viene con usuarios para que puedas probarlo inmediatamente!

1. **Administrador** (tiene acceso total)
   - Email: admin@example.com
   - Contraseña: password
   - ¡Prueba a eliminar expedientes y restaurarlos!

2. **Usuario normal** (acceso limitado)
   - Email: usuario@example.com
   - Contraseña: password
   - Solo puede gestionar sus propios expedientes

## 📁 Cómo está organizado el proyecto

El proyecto sigue la estructura estándar de Laravel, con algunas carpetas específicas:

```
app/
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
routes/                     # Definición de URLs
```

## 👨‍💼 Lo que pueden hacer los usuarios

### Como Administrador podrás:
- Ver absolutamente todos los expedientes (¡incluso los eliminados!)
- Crear expedientes nuevos cuando quieras
- Editar cualquier expediente existente
- Eliminar expedientes (no te preocupes, es un borrado lógico)
- Restaurar expedientes que hayas eliminado
- Usar todos los filtros para encontrar rápidamente lo que buscas

### Como Usuario normal podrás:
- Ver solo tus propios expedientes
- Crear tus propios expedientes
- Editarlos cuando necesites actualizarlos
- Aplicar filtros para organizarte mejor

## 🔧 Si algo no funciona...

### ¿Problemas con los permisos?
```bash
chmod -R 775 storage bootstrap/cache
chown -R $USER:www-data storage bootstrap/cache
```

### ¿PostgreSQL no conecta?
Asegúrate de que esté funcionando:
```bash
sudo systemctl status postgresql
```

### ¿Algún error con las dependencias?
Prueba actualizándolas:
```bash
composer update
npm update
```

### ¿La aplicación se comporta raro después de cambios?
Limpia las cachés:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

## 📞 ¿Necesitas ayuda?

Si tienes alguna duda o sugerencia, ¡no dudes en contactarme!
- GitHub: https://github.com/altgared

---

Desarrollé este sistema como parte de una prueba técnica para ATDT. ¡Espero que te sea útil y fácil de implementar!
