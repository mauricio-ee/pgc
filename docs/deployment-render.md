# Publicar EcoVenta en Render

La configuración de este proyecto crea una aplicación Laravel con Docker, una base de datos PostgreSQL y almacenamiento persistente para imágenes. La URL gratuita de Render es un subdominio `onrender.com`; la aplicación, la base de datos y el disco persistente usan planes de pago. Revisa el costo mostrado por Render antes de confirmar la creación de recursos.

## Antes de publicar

- Conecta Render a un repositorio privado de GitHub. El remoto configurado actualmente es público; cambia su visibilidad o prepara un repositorio privado antes de subir cambios si no quieres que el código sea público.
- No incluyas `.env`, claves, `vendor`, `node_modules` ni `database/database.sqlite`.
- Crea una cuenta de Render e inicia un Blueprint usando ese repositorio y el archivo `render.yaml`.
- Revisa los planes y cargos de la base de datos, el servicio web y el disco antes de aprobarlos.
- Configura el nombre del banco, número de cuenta y código bancario correctos (`BANK_NAME`, `BANK_ACCOUNT`, `BANK_CODE`) en el panel privado de Render. No dejes los datos de ejemplo del proyecto para una tienda real.
- Configura las credenciales de Mercado Pago en el panel privado de variables de entorno de Render. No las escribas en Git ni las compartas en el chat.
- Configura un proveedor SMTP en Render antes de depender de correos de confirmación o recuperación de contraseña.

El contenedor ejecuta `php artisan migrate --force` al iniciar. La base de datos de producción comienza vacía; los datos de SQLite local y las imágenes locales no se copian. Carga los productos y crea las cuentas necesarias desde el sitio después de comprobar el despliegue.

## Comprobación antes de vender

Confirma que el sitio usa HTTPS, que los archivos subidos siguen disponibles tras un nuevo despliegue, que los correos llegan y que Mercado Pago funciona con credenciales de prueba. Solo configura credenciales de producción después de verificar el flujo completo de compra, pago, webhook y cancelación.
