# Plan de trabajo: sitio lacasaa.cl

Estado al 2026-11-27 (theme 1.4.109, plugin 2.1.6). El detalle de cada parte está en `AGENT.md`.

## Fases

| Fase | Descripción | Estado |
|---|---|---|
| 1 | Theme `casa-a`: estructura, paleta, navbar, menú lateral y responsive | Hecho (versión 1.4.109) |
| 2 | Páginas: Inicio, Quiénes somos, Estudio, Contacto, Galería, Cómo arrendar, Condiciones, Política de privacidad, Mi reserva, Catálogo | Hecho. Faltan textos de garantía, plazos, daños y los [POR COMPLETAR] de la política |
| 3 | Activación del theme y de los plugins | Hecho. Theme y plugins activos |
| 4 | Catálogo de productos: productos, categorías y sincronización con la galería | Hecho. Integrado en `jwt-gallery` 2.1.6 (ya no es un plugin aparte) |
| 5 | Reservas: calendario en Contacto | Pendiente. Hoy hay solicitud de arriendo en Mi reserva y formulario de mensaje en Contacto |
| 6 | Documentación | Hecho en `AGENT.md`, `PLAN.md` y `Docs_Plugin.md` |
| 7 | Envío de correos | Pendiente. Falta un SMTP real y el remitente `hola@lacasaa.cl` |
| 8 | Categorías de galería: principales y subcategorías desde el panel, con +, arrastre, buscador y espejo en el catálogo | Hecho |
| 9 | Panel de galería: piezas con hasta 3 imágenes, reordenar por arrastre, "No disponible" y logo | Hecho |
| 10 | Buscador del navbar con sugerencias de categorías y productos | Hecho. Falta versión móvil |
| 11 | Cookies según la ley 21.719 (consentimiento informado, revocar igual de fácil) | Hecho en el navegador. Falta registro en el servidor |
| 12 | Despliegue a producción | Pendiente. Subir `casa-a-theme-1.4.109.zip` y `jwt-gallery-2.1.6.zip`, guardar enlaces permanentes. La página `mi-reserva` ya existe con su plantilla |
| 13 | Consolidación: catálogo dentro de `jwt-gallery` (un solo plugin) | Hecho (2.1.6) |
| 14 | Páginas de ayuda: Cómo arrendar (3 pasos) y Condiciones de arriendo (acordeón, enlazada desde el pie) | Hecho (theme 1.4.109) |
| 15 | Pie siempre al final de la página; categorías sin duplicados en menú y filtro; categorías borradas | Hecho |
| 16 | Mi reserva: formulario con errores por campo (sin borrar datos), teléfono y mensaje obligatorios, correo de 50 caracteres, espera de 5 minutos con cuenta regresiva y modales | Hecho (theme 1.4.109) |
| 17 | Contacto: campos obligatorios con popover, errores por campo, espera de 5 minutos y correo "Nuevo mensaje de contacto" | Hecho (theme 1.4.109) |
| 18 | Menú lateral con subcategorías por flecha (`‹ ›`), navbar blanco al abrir el menú y tipografía unificada | Hecho (theme 1.4.109) |
| 19 | Eliminar una categoría borra sus subcategorías y piezas, sin dejar nada | Hecho (plugin 2.1.6) |

## Pendientes

1. Configurar SMTP real y remitente `hola@lacasaa.cl` (fase 7).
2. Ley 21.719 (vigencia 1 de diciembre de 2026): informar la transferencia fuera de Chile en el banner o en la política, registrar el consentimiento en el servidor y revisar con un abogado (fase 11).
3. Volver a subir las fotos de productos y piezas cuyos archivos se perdieron con `uploads/`.
4. Diagnosticar el "Error de red" al publicar piezas (ver `AGENT.md`, sección Pendiente).
5. Decidir si se quita el sitemap de usuarios (`wp-sitemap-users-1.xml`).
6. Buscador en el menú hamburguesa para celular, sinónimos y búsqueda de productos sin tildes (fase 10).
7. Textos de garantía, plazos y daños en "Cómo arrendar".
8. Completar los [POR COMPLETAR] de la política de privacidad.
9. Datos reales de contacto, redes y número de WhatsApp.
10. Productos reales en el catálogo (hoy hay productos de prueba).
11. Calendario de reservas (fase 5).
12. Definir el despliegue a producción de theme y plugins (fase 12).
13. Decidir si se borran `casa-a.zip` y `casa-a-catalogo.zip`.
14. Verificar en producción el selector de categoría padre al crear una subcategoría (plugin 2.1.6).
15. Quitar la contraseña en texto plano de `README.MD` y cambiarla.
16. Identificar el recuadro "wordpress-proyecto3" (probablemente una extensión del navegador).
