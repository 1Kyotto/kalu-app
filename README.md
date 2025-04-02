# Kalu App - Sistema de Gestión de Recursos Humanos

Sistema de gestión integral para recursos humanos que permite administrar empleados, liquidaciones y solicitudes de manera eficiente.

## Características

- Gestión de empleados y contratos
- Gestión de liquidaciones
- Gestión de solicitudes
- Control de permisos y roles
- Interfaz moderna y responsiva
- Autenticación segura

## Stack Tecnológico

**Frontend:** 
- Blade Templates
- TailwindCSS
- JavaScript

**Backend:** 
- PHP 8.2
- Laravel 11
- MySQL

## Instalación
- Clona el repositorio

```bash
git clone https://github.com/1Kyotto/kalu-app.git
cd kalu-app

-  Instala las dependencias

```bash
composer install
npm install
```

-  Configura el entorno

```bash
cp .env.example .env
php artisan key:generate
```

-  Configura la base de datos en el archivo .env

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kalu_app
DB_USERNAME=root
DB_PASSWORD=
```

-  Ejecuta las migraciones y seeders

```bash
php artisan migrate --seed
```

## Ejecución Local

-  Inicia el servidor de desarrollo

```bash
php artisan serve
```

-  Compila los assets (en una nueva terminal)

```bash
npm run dev
```

-  Accede a la aplicación en `http://localhost:8000`

## Variables de Entorno

Las principales variables de entorno que necesitas configurar son:

```env
APP_NAME=KaluApp
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kalu_app
DB_USERNAME=
DB_PASSWORD=
```

## Autores

- [@1Kyotto](https://github.com/1Kyotto)