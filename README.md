# Hirewise

Plataforma web de empleo que conecta empresas y candidatos. Las empresas publican vacantes y gestionan postulaciones; los candidatos crean su perfil, suben su hoja de vida y se postulan a las ofertas.

Proyecto universitario desarrollado con Laravel 12 y Blade.

## Funcionalidades

### Empresa

- Registro y gestión de la cuenta de empresa.
- CRUD de vacantes (crear, editar, publicar, cerrar, eliminar).
- Dashboard con resumen de vacantes y postulaciones.
- Listado público de vacantes con vista de detalle.
- Visualización del perfil y la hoja de vida de cada candidato postulado.

### Candidato

- Registro con correo/contraseña o con Google OAuth (rol Empresa o Candidato).
- Perfil editable.
- Carga y visualización de hoja de vida (PDF).
- Postulación a vacantes con un clic.
- Dashboard con el estado de sus postulaciones.

### Autenticación

- Registro y login propios con validación en tiempo real.
- Login con Google mediante Laravel Socialite.
- Roles con Spatie Laravel Permission (`Empresa`, `Candidato`) y middleware `ensure.role`.
- Validación de formularios en el cliente (email, longitud mínima de contraseña, confirmación) e indicador de fuerza de contraseña.

## Stack

| Capa | Tecnología |
|---|---|
| Backend | Laravel 12, PHP 8.2 |
| Frontend | Blade, Vite, JavaScript, Bootstrap |
| Auth | Laravel Socialite (Google OAuth), Spatie Laravel Permission |
| Documentos | smalot/pdfparser (lectura de HV en PDF) |
| Base de datos | MySQL / PostgreSQL / SQLite (según `.env`) |
| Testing | PHPUnit |

## Requisitos

- PHP 8.2 o superior con extensiones `mbstring`, `openssl`, `pdo`, `sqlite3`/`mysql` según el motor.
- Composer 2.
- Node.js 20 o superior y pnpm o npm.
- Una base de datos (SQLite para desarrollo rápido o MySQL/PostgreSQL).
- Credenciales de Google OAuth (solo si se usa login con Google).

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/Andrejulian21/Hirewise.git
cd Hirewise
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Ajustar en `.env` la conexión de base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hirewise
DB_USERNAME=root
DB_PASSWORD=
```

Para desarrollo rápido con SQLite:

```env
DB_CONNECTION=sqlite
```

### 4. Migrar la base de datos

```bash
php artisan migrate
```

### 5. Instalar dependencias de frontend y compilar

```bash
pnpm install
pnpm run dev
```

En producción:

```bash
pnpm run build
```

### 6. Iniciar el servidor

```bash
php artisan serve
```

Abrir [http://localhost:8000](http://localhost:8000) en el navegador.

Atajo con todo incluido (servidor, colas, logs y Vite):

```bash
composer dev
```

## Configurar Google OAuth (opcional)

1. Crear un proyecto en Google Cloud Console y un cliente OAuth 2.0.
2. Agregar como URI de redirección autorizada: `http://localhost:8000/auth/google/callback`.
3. Agregar al `.env`:

```env
GOOGLE_CLIENT_ID=tu-client-id
GOOGLE_CLIENT_SECRET=tu-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

El rol se elige en el login/registro y se envía como `?rol=Empresa|Candidato` al endpoint `/auth/google/redirect`.

## Uso

1. Registrarse como Empresa o como Candidato (formulario o Google).
2. Como Empresa: completar los datos de la compañía en `/empresa/company` y crear vacantes en `/empresa/jobs`.
3. Como Candidato: completar el perfil en `/candidato/perfil/editar`, subir la HV y postularse desde el listado `/jobs`.
4. Como Empresa: revisar postulaciones en el dashboard y abrir el perfil/CV de cada candidato.

## Estructura del proyecto

```
app/
├── Http/Controllers/
│   ├── Auth/            # Registro, login, Socialite (Google)
│   ├── Company/         # Vacantes, cuenta de empresa, vista de candidatos
│   ├── Candidate/       # Perfil, postulaciones, visualización de CV
│   └── DashboardController.php
├── Models/              # User, Company, Job, Application, Candidate...
├── Policies/            # Autorización por rol
└── Services/            # Lógica de negocio (p. ej. lectura de PDF)
resources/
├── views/               # Blade (auth, empresa, candidato, welcome)
└── js/                  # auth.js (validación, fuerza de contraseña), welcome.js
routes/web.php           # Rutas públicas, auth y grupos por rol
database/migrations/     # Esquema de usuarios, empresas, vacantes, postulaciones
```

## Scripts disponibles

| Comando | Descripción |
|---|---|
| `composer setup` | Instala dependencias, genera key, migra y compila assets |
| `composer dev` | Servidor + colas + logs + Vite en paralelo |
| `composer test` | Limpia config y ejecuta la suite de tests |
| `php artisan test` | Ejecuta PHPUnit |
| `pnpm run dev` | Servidor de desarrollo de Vite |
| `pnpm run build` | Compila assets para producción |

## Testing

```bash
php artisan test
```

## Estado y próximos pasos

- [x] Auth propia + Google OAuth con roles
- [x] CRUD de vacantes y cuenta de empresa
- [x] Perfil de candidato y postulaciones
- [x] Visualización de HV (PDF)
- [ ] Filtros y búsqueda avanzada de vacantes
- [ ] Notificaciones por correo al cambiar el estado de una postulación
- [ ] Paginación y pruebas de los flujos principales

## Licencia

Proyecto académico. Todos los derechos reservados.
