# Plan de trabajo: sitio lacasaa.cl

Estado al 2026-11-24. El detalle de cada parte está en `AGENT.md`.

## Fases

| Fase | Descripción | Estado |
|---|---|---|
| 1 | Theme `casa-a`: estructura, paleta, navbar, menú lateral y responsive | Hecho (versión 1.4.5) |
| 2 | Páginas y contenido: Inicio, Quiénes somos, Estudio, Contacto, Galería, Cómo arrendar, Condiciones, Política de privacidad, Mi reserva | Hecho. Faltan textos de garantía, plazos, daños y los [POR COMPLETAR] de la política |
| 3 | Activación del theme y del plugin | Hecho. Theme y plugins activos en la base de datos |
| 4 | Plugin de catálogo `casa-a-catalogo`: categorías, productos y CRUD | Hecho. Gestión por el panel de galería y el admin |
| 5 | Reservas: calendario en Contacto | Pendiente. Hoy hay solicitud de arriendo en Mi reserva y formulario de mensaje en Contacto |
| 6 | Documentación | Hecho en `AGENT.md` y `PLAN.md`. `Docs_Plugin.md` sin cambios (solo describe el plugin de galería) |
| 7 | Envío de correos | Pendiente. El formulario responde "ok", pero falta un SMTP real |
| 8 | Categorías de galería: principales y subcategorías desde el panel, con +, arrastre, buscador, selector principal + subcategoría al publicar y máximo 3 imágenes por pieza | Hecho en el código (`jwt-gallery` 2.0.20). Falta probar en el navegador y revisar las 33 categorías locales |
| 9 | Despliegue a producción | Pendiente. Falta definir cómo se suben los archivos |

## Trabajo adicional realizado (fuera del plan original)

- **Panel de galería (`jwt-gallery`, 2.0.7):** login y panel en `/galeria/` y `/galeria-panel/`. Campos de precio, cantidad, medidas y hasta 10 imágenes por pieza.
- **Sincronización galería → catálogo:** cada pieza crea o actualiza un producto, con todas sus imágenes.
- **Catálogo:** filtros, tarjetas con modal de producto y menú lateral por grupos.
- **Mi reserva:** lista con cantidades, control de stock y paginación de 2 productos por página. El formulario pide nombre (mayúsculas), correo y nombre del proyecto (minúsculas), teléfono con +56 9, fechas, comentarios y dos checks obligatorios (condiciones y privacidad).
- **Correos HTML:** solicitud de arriendo con miniaturas de los productos incrustadas y contacto, con la paleta del sitio. Teléfono y correo sin subrayado.
- **Portada:** carrusel de tres diapositivas (Muebles, Decoración y Escenografía) con botón a su búsqueda.
- **Cookies:** banner con aceptar y rechazar, GTM y Clarity solo tras aceptar.
- **Páginas legales:** condiciones de arriendo y política de privacidad (versión 1.0).
- **Robots y verificación:** `robots.txt` desde el theme y meta de verificación de Google.
- **Paleta:** blanco, gris claro, negro, gris, taupe y gris taupe, con Cascadia Code en todo el sitio.

## Pendientes

1. Configurar SMTP real y remitente `hola@lacasaa.cl` (fase 7).
2. Editar una pieza con el mismo selector de principal y subcategoría que la subida.
3. Revisar las 33 categorías creadas por script en local y decidir si se borran.
4. Textos de garantía, plazos y daños en "Cómo arrendar".
5. Completar los [POR COMPLETAR] de la política de privacidad.
6. Datos reales de contacto, redes y número de WhatsApp.
7. Productos reales en el catálogo (hoy hay dos de prueba).
8. Calendario de reservas (fase 5).
9. Registro de consentimiento en el servidor (ley 21.719, vigencia 01-DIC-2026).
10. Confirmar el destino de "Continuar a cotización".
11. Permisos de escritura en `wp-content/uploads` para el usuario del servidor web.
12. Decidir si se borran `casa-a.zip` y `casa-a-catalogo.zip`.
13. Definir el despliegue a producción de theme y plugins.
