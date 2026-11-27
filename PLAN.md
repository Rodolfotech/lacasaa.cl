# Plan de trabajo: sitio lacasaa.cl

Estado al 2026-11-27. El detalle de cada parte está en `AGENT.md`.

## Fases

| Fase | Descripción | Estado |
|---|---|---|
| 1 | Theme `casa-a`: estructura, paleta, navbar, menú lateral y responsive | Hecho (versión 1.4.53) |
| 2 | Páginas: Inicio, Quiénes somos, Estudio, Contacto, Galería, Cómo arrendar, Condiciones, Política de privacidad, Mi reserva, Catálogo | Hecho. Faltan textos de garantía, plazos, daños y los [POR COMPLETAR] de la política |
| 3 | Activación del theme y de los plugins | Hecho. Theme y plugins activos |
| 4 | Plugin de catálogo `casa-a-catalogo`: productos, categorías y sincronización con la galería | Hecho. Espejo de categorías y disponibilidad incluidos |
| 5 | Reservas: calendario en Contacto | Pendiente. Hoy hay solicitud de arriendo en Mi reserva y formulario de mensaje en Contacto |
| 6 | Documentación | Hecho en `AGENT.md`, `PLAN.md` y `Docs_Plugin.md` |
| 7 | Envío de correos | Pendiente. Falta un SMTP real y el remitente `hola@lacasaa.cl` |
| 8 | Categorías de galería: principales y subcategorías desde el panel, con +, arrastre, buscador y espejo en el catálogo | Hecho |
| 9 | Panel de galería: piezas con hasta 3 imágenes, reordenar por arrastre, "No disponible" y logo | Hecho |
| 10 | Buscador del navbar con sugerencias de categorías y productos | Hecho. Falta versión móvil |
| 11 | Cookies según la ley 21.719 (consentimiento informado, revocar igual de fácil) | Hecho en el navegador. Falta registro en el servidor |
| 12 | Despliegue a producción | Pendiente. Falta definir cómo se suben los archivos |

## Pendientes

1. Configurar SMTP real y remitente `hola@lacasaa.cl` (fase 7).
2. Registro de consentimiento de cookies en el servidor (fase 11).
3. Volver a subir las fotos de productos y piezas cuyos archivos se perdieron con `uploads/`.
4. Buscador en el menú hamburguesa para celular, sinónimos y búsqueda de productos sin tildes (fase 10).
5. Textos de garantía, plazos y daños en "Cómo arrendar".
6. Completar los [POR COMPLETAR] de la política de privacidad.
7. Datos reales de contacto, redes y número de WhatsApp.
8. Productos reales en el catálogo (hoy hay productos de prueba).
9. Calendario de reservas (fase 5).
10. Definir el despliegue a producción de theme y plugins (fase 12).
11. Decidir si se borran `casa-a.zip` y `casa-a-catalogo.zip`.
