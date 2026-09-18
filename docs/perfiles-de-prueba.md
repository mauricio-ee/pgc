# Perfiles de prueba de EcoVenta

Estas cuentas sirven únicamente para probar la aplicación en desarrollo local.

**Contraseña de todas las cuentas:** `password`

No utilices estas credenciales en producción. Antes de publicar la aplicación, cambia o elimina todas estas cuentas.

## Acceso general

- URL local: `http://127.0.0.1:8000`
- Inicio de sesión: `http://127.0.0.1:8000/login`
- Registro público: `http://127.0.0.1:8000/register`
- Panel de cliente: `http://127.0.0.1:8000/dashboard`
- Panel del equipo interno: `http://127.0.0.1:8000/equipo`
- Panel administrativo: `http://127.0.0.1:8000/admin`
- Panel del agricultor: `http://127.0.0.1:8000/vendedor/productos/mios`

## Perfiles

| Perfil | Correo de prueba | Contraseña | Acceso principal |
|---|---|---|---|
| Cliente | `prueba-customer@ecoventa.test` | `password` | Catálogo, carrito, favoritos, checkout y mis pedidos |
| Agricultor | `prueba-seller@ecoventa.test` | `password` | Publicar y gestionar productos en `/vendedor/productos/mios` |
| Atención al cliente | `prueba-support@ecoventa.test` | `password` | Panel interno `/equipo` |
| Gestor de pedidos | `prueba-order_manager@ecoventa.test` | `password` | Panel interno `/equipo` |
| Moderador | `prueba-moderator@ecoventa.test` | `password` | Panel interno `/equipo` |
| Verificador de agricultores | `prueba-farmer_verifier@ecoventa.test` | `password` | Panel interno `/equipo` |
| Gestor de pagos | `prueba-payment_manager@ecoventa.test` | `password` | Panel interno `/equipo` |
| Encargado de calidad | `prueba-quality_manager@ecoventa.test` | `password` | Panel interno `/equipo` |
| Gestor de promociones | `prueba-promotion_manager@ecoventa.test` | `password` | Panel interno `/equipo` |
| Analista | `prueba-analyst@ecoventa.test` | `password` | Panel interno `/equipo` |
| Administrador | `prueba-admin@ecoventa.test` | `password` | Panel `/admin`, categorías y todos los pedidos |
| Superadministrador | `prueba-super_admin@ecoventa.test` | `password` | Panel administrativo y panel interno |
| Técnico | `prueba-technician@ecoventa.test` | `password` | Panel interno `/equipo` |
| Certificador ecológico | `prueba-certifier@ecoventa.test` | `password` | Panel interno `/equipo` |

## Usuarios demo adicionales

El seeder también conserva estas cuentas iniciales:

| Perfil | Correo | Contraseña |
|---|---|---|
| Administrador demo | `admin@admin.com` | `password` |
| Agricultor demo | `vendedor@test.com` | `password` |
| Cliente demo | `cliente@test.com` | `password` |
| Certificador demo | `certificador@test.com` | `password` |

## Cómo iniciar sesión

1. Inicia el servidor desde la carpeta `pgc`:

   ```powershell
   php artisan serve --host=127.0.0.1 --port=8000
   ```

2. Abre `http://127.0.0.1:8000/login`.
3. Introduce uno de los correos de la tabla.
4. Introduce la contraseña `password`.
5. Pulsa **Iniciar Sesión**.
6. Según el perfil, abre el panel correspondiente indicado en la tabla.

## Cómo recrear los perfiles

Con la base SQLite local configurada:

```powershell
$env:DB_CONNECTION='sqlite'
$env:DB_DATABASE=(Join-Path (Get-Location) 'database\database.sqlite')
$env:SESSION_DRIVER='file'
$env:CACHE_STORE='file'
$env:QUEUE_CONNECTION='sync'
php artisan migrate --force
php artisan db:seed --force
```

El seeder utiliza `updateOrCreate`, por lo que puede ejecutarse varias veces sin duplicar las cuentas de prueba.

## Seguridad

- No subas contraseñas reales al repositorio.
- No uses `password` en producción.
- Cambia las credenciales demo antes de entregar la aplicación.
- Mantén `APP_DEBUG=false` en producción.
- Usa HTTPS y claves reales almacenadas en variables de entorno seguras.
