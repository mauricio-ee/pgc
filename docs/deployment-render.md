# Demo universitaria de EcoVenta en Render

El Blueprint configura una aplicación Laravel y una base de datos PostgreSQL en planes gratuitos. La URL pública es un subdominio `onrender.com`. Es una configuración solo para demo académica, no una tienda en producción.

## Limitaciones del plan gratuito

- El servicio web se detiene tras 15 minutos sin tráfico y puede tardar aproximadamente un minuto en volver a iniciar.
- La base de datos gratuita vence a los 30 días; después de un período de gracia de 14 días, Render elimina sus datos si no se actualiza a un plan de pago.
- El sistema de archivos del servicio es efímero: las imágenes cargadas pueden desaparecer al reiniciarse o desplegarse la aplicación.
- Los servicios gratuitos tienen límites de recursos y no incluyen copias de seguridad de la base de datos.

## Despliegue

1. En Render, selecciona **New > Blueprint**.
2. Introduce el repositorio público `https://github.com/mauricio-ee/pgc` en **Public Git Repository** y pulsa **Continue**.
3. Confirma la rama `main` y el archivo `render.yaml` en la raíz.
4. Revisa que el servicio web y PostgreSQL tengan el plan **Free** antes de crear el Blueprint. No añadas una tarjeta para esta demo.
5. Espera a que terminen la construcción y las migraciones. La base comienza vacía; los datos de SQLite local y las imágenes locales no se copian.

El script de inicio valida el `APP_KEY` generado por Render y lo adapta al formato y longitud que espera Laravel. El valor de origen sigue siendo un secreto administrado por Render y la clave resultante permanece estable entre reinicios. También carga un catálogo idempotente de seis productos de demostración, con precios e inventario ficticios claramente indicados; no ejecuta el seeder general ni crea cuentas con contraseñas predeterminadas.

Las credenciales de Mercado Pago y los datos bancarios no se incluyen en el repositorio ni en el Blueprint. Por tanto, no configures pagos reales ni uses esta demo para recibir pedidos o transferencias. Para una tienda real se necesita alojamiento y almacenamiento persistentes, correo SMTP y configurar credenciales privadas en Render.
