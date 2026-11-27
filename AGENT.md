# lacasaa.cl — Brief y estado del proyecto

Última actualización: 2026-11-24

## Brief original

Espacio boutique multifuncional y hub creativo multidisciplinario. Diseñado como estudio para campañas fotográficas, producción de video, activaciones de marcas, grabación de podcast y eventos pequeños. Además, lacasaa.cl arrienda mobiliario, decoración y props para producciones audiovisuales.

**Sitio web:** simple y fácil de navegar, con el índice a la vista.
- **Inicio:** portada con carrusel de tres diapositivas.
- **Quiénes somos (`casa-a`):** intro de la marca y tres valores.
- **Estudio:** parte técnica del lugar, con planos y fotos.
- **Contacto:** datos de contacto, mapa y formulario de mensaje.

**Theme:** visual (`casa-a`, nombre visible "lacasaa.cl").

**Plugin:** catálogo de productos con categorías y productos.

## Estado actual

### Theme `casa-a` (versión 1.4.5)

Ruta: `wp-content/themes/casa-a/`. Activo.

**Paleta** (variables en `:root` de `style.css` y en `theme.json`):

| Nombre | Hex | Variable | Uso |
|---|---|---|---|
| Negro | #000000 | `--casa-a-negro` | Títulos, texto y botones negros |
| Gris | #8E8E8E | `--casa-a-gris` | Texto secundario y bordes |
| Gris claro | #E9E9E9 | `--casa-a-gris-claro` | Formularios, footer, tarjetas, fondo del correo |
| Taupe | #B0A08A | `--casa-a-taupe` | Botones y botón "aceptar" de cookies |
| Gris taupe | #A0968C | `--casa-a-gris-taupe` | Contador de Mi reserva, etiquetas e íconos |

El fondo de página es blanco (#FFFFFF, `--casa-a-blanco`).

**Tipografía:** Cascadia Code en todo el sitio, incluido el panel de galería. Archivos en `assets/fonts/` (400, 500, 600 y 700). En correos se usa como fuente preferida con respaldo monoespaciado.

**Componentes reutilizables** (`template-parts/`):
- `nav.php`: hamburguesa y logo a la izquierda; buscador de productos centrado; "Contacto" y "Mi reserva" con contador a la derecha. Transparente sobre la portada; estilo claro al pasar el mouse o con el menú abierto.
- `menu-lateral.php`: menú que empieza bajo el navbar, sin barra de scroll. Abre con el mouse sobre la hamburguesa o el logo, o con clic. Grupos: Exterior (Deportes, Camping, Jardín, Playa), Alfombras, Decoración, Escenografía, Iluminación (Lámparas colgantes, de pie y sobremesa) y Muebles (Bancas, Taburetes & Poufs como una sola categoría). Después: Galería (`/en-accion/`) y Quiénes somos (`/casa-a/`).
- `seleccion.php`: panel lateral "Mi reserva" con la lista paginada de 2 productos por página y el botón "Continuar a cotización" (lleva a `/mi-reserva/`).
- `modal-producto.php`: modal de producto con galería, medidas, precio por día, disponibles, cantidad y "Agregar a mi reserva". Al agregar muestra "Agregado a tu reserva." con el enlace "Ir a Mi reserva →".
- `footer.php`: logo circular, contacto (Padre Orellana 1957, Santiago; +569 8510 3181; hola@lacasaa.cl), horario 9:30–17:00, "Respondemos en 24 horas hábiles.", ayuda e Instagram @casaa.cl (https://www.instagram.com/casaa.cl/), y barra legal con "Política de privacidad" y "Configurar cookies". Contenido de 1860 px de ancho.
- `cookies-banner.php`: banner de cookies (ver abajo).
- `aviso-modal.php`: modal reutilizable para avisos, con X y "Salir".

**Plantillas de página:**
- `front-page.php`: carrusel de tres diapositivas. Cada una tiene etiqueta, título en mayúsculas y botón negro.
- `archive-producto.php`: catálogo con filtros a la izquierda ("Solo disponibles", categorías, estilos, colores y materiales). Tarjetas sin botón "Agregar": al hacer clic en la foto abren el modal. Sirve también para la búsqueda de productos.
- `single-producto.php`: ficha de producto.
- `page-contacto.php`: datos de contacto, mapa y formulario de mensaje.
- `template-mi-reserva.php` ("Mi reserva", slug `mi-reserva`): lista de productos seleccionados y formulario de solicitud de arriendo.
- `page-estudio.php`: planos, fotos y datos técnicos.
- `template-galeria.php` ("Galería"): mosaico con las imágenes del panel de galería, con la categoría sobre la foto. Slug `en-accion`.
- `template-como-arrendar.php` ("Cómo arrendar"): tres pasos verticales (Elige tus favoritos, Envía tu solicitud, Confirma tu arriendo).
- `template-condiciones.php` ("Condiciones de arriendo"): siete puntos en acordeón.
- `template-politica.php` ("Política de privacidad"): versión 1.0, fecha 23-11-2026, con marcadores [POR COMPLETAR].
- `template-quienes-somos.php` ("Quiénes somos"): intro de la marca y valores Calidez, Calidad y Confianza.

**Carrusel de la portada** (`slider.js`: cambia cada 6 segundos, con puntos, teclado y deslizar; sin cambio automático si el usuario reduce el movimiento):
1. "Muebles" / "Sofás & sillones para tu set" / botón "Ver muebles" → `/producto/?s=Sof%C3%A1s`.
2. "Decoración" / "Objetos que cuentan historias" / botón "Ver decoración" → `/producto/?s=Decoraci%C3%B3n`.
3. "Escenografía" / "Fondos, pisos & paneles" / botón "Ver escenografía" → `/producto/?s=Escenograf%C3%ADa`.

**Catálogo:**
- Los filtros se leen de la URL, así que se pueden compartir. "Limpiar filtros" aparece cuando hay alguno activo.
- Los chips de filtro muestran solo categorías finales, no grupos como Alfombras o Muebles.

**Mi reserva** (los avisos se muestran con `casa_a_estado` en la URL):
- La selección se guarda en el navegador (`localStorage`, clave `casa_a_seleccion`). Cantidades con campo numérico, sin pasar el stock (máximo 99 cuando no hay stock cargado).
- Lista paginada de 2 productos por página, también en el panel lateral. La paginación aparece cuando hay más de 2 productos.
- Total "Arriendo por día" y aviso "Valores referenciales. El total final y la disponibilidad se confirman al revisar tu solicitud."
- Formulario: nombre, correo, teléfono, nombre del proyecto, fecha de retiro, fecha de devolución, comentarios y los dos checks obligatorios (ver abajo). Botón "Enviar solicitud de arriendo".
- Al enviarse con éxito, la selección se vacía.

**Reglas de formularios:**
- **Nombre:** de 3 a 25 caracteres. Se guarda y se muestra en mayúsculas.
- **Correo:** se muestra y guarda en minúsculas. Validación con `casa_a_email_valido()`: sin inicio "." o "@", sin comillas, guion bajo ni guion medio, una sola "@", sin espacios ni puntos seguidos, parte local de hasta 64 caracteres. Máximo 254 en Contacto y 35 en Mi reserva.
- **Teléfono:** prefijo fijo "+56 9" y 8 dígitos (formato 8510 3181). No acepta un primer dígito 1 ni 2. Es opcional.
- **Nombre del proyecto** (solo Mi reserva): obligatorio, de hasta 25 caracteres, en minúsculas.
- **Comentarios y descripción:** hasta 2000 caracteres, con contador.
- **Checks obligatorios:** "He leído y acepto la Política de Privacidad" en ambos formularios, y "Acepto las condiciones de arriendo" en Mi reserva.
- **Campo trampa anti-spam** ("Sitio web"), oculto para personas.
- **Mensajes de campo obligatorio:** en español ("Este campo es obligatorio." o "Debes marcar esta casilla para continuar.") con `requeridos.js`.

**Correos de los formularios** (`functions.php`):
- Se envían a `hola@lacasaa.cl` con `Reply-To` al cliente, en HTML con la paleta del sitio.
- **Solicitud de arriendo:** datos del cliente (nombre, teléfono, correo), arriendo (nombre del proyecto, retiro, devolución y días), comentarios, tabla de productos con su miniatura incrustada y el total por día.
- **Contacto:** datos del cliente, promociones y descripción del proyecto.
- El correo del cliente y el teléfono van sin subrayado (enlaces con estilo propio, para evitar el subrayado automático de Gmail).
- El envío real depende del SMTP (ver pendientes).

**Cookies** (`cookies.js`, `cookies-banner.php`):
- Banner con "Rechazar" (gris claro #E9E9E9) y "Aceptar" (taupe #B0A08A). Hover gris taupe y gris.
- Guarda `{decision, fecha, version}` en `localStorage`, clave `casa_a_cookies`, versión 1.
- Carga Google Tag Manager (GTM-5CFDL8ZS) y Microsoft Clarity (zi7qd4b8ue) solo tras aceptar. Al rechazar, borra las cookies analíticas.
- El banner solo aparece en páginas con analítica (`casa_a_analitica_activa()`, que excluye las páginas de galería).
- Aclara que parte de los datos se tratan fuera de Chile.

**Otros:**
- `robots.txt` desde el theme (`casa_a_robots_txt`), con agentes de IA permitidos y `Sitemap: …/wp-sitemap.xml`. La ruta se registra con una regla de reescritura.
- Meta de verificación de Google Search Console en `<head>`.
- Scrollbars ocultas en todo el sitio (`scrollbar-width: none`).
- Scripts propios: `telefono.js`, `minusculas.js`, `requeridos.js`, `paginacion.js`, `reserva.js`, `seleccion.js`, `producto-modal.js`, `menu-lateral.js`, `aviso-modal.js`, `slider.js` y `cookies.js`.

**Páginas y slugs:**

| Página | Slug | Plantilla |
|---|---|---|
| Inicio | portada (Ajustes → Lectura) | `front-page.php` |
| Quiénes somos | `casa-a` | `template-quienes-somos.php` |
| Estudio | `estudio` | `page-estudio.php` |
| Contacto | `contacto` | `page-contacto.php` |
| Galería pública | `en-accion` | `template-galeria.php` |
| Cómo arrendar | `como-arrendar` | `template-como-arrendar.php` |
| Condiciones de arriendo | `condiciones-de-arriendo` | `template-condiciones.php` |
| Política de privacidad | `politica-de-privacidad` | `template-politica.php` |
| Mi reserva | `mi-reserva` | `template-mi-reserva.php` |
| Catálogo | archivo de `producto` en `/producto/` | `archive-producto.php` |

**Imágenes del theme:** `assets/img/` con `cabecera1.jpeg`, `cabecera2.jpg` y `cabecera3.jpeg`. El logo circular es un SVG en `nav.php` y `footer.php`.

### Plugin `casa-a-catalogo`

Ruta: `wp-content/plugins/casa-a-catalogo/`. Activo.

- **Tipo de contenido `producto`** con la taxonomía jerárquica `categoria_producto` y las taxonomías `estilo_producto`, `color_producto` y `material_producto`.
- **Metadatos del producto:** código (`casa_a_codigo`), precio por día (`casa_a_precio_dia`), disponibilidad (`casa_a_disponible`), unidades (`casa_a_stock`), dimensiones (`casa_a_dimensiones`), uso (`casa_a_uso`) y galería de imágenes (`casa_a_galeria`).
- **Cuadros del editor:** "Ficha de arriendo" (código, precio, disponibilidad) e "Inventario" (unidades).
- **Sincronización con la galería** (`includes/sync-galeria.php`): cada pieza publicada en el panel de galería crea o actualiza un producto, con título, descripción, medidas, uso, categoría, precio, cantidad e imágenes. La categoría se toma de la subcategoría de la galería y se busca dentro de su categoría principal. La primera imagen queda como destacada. Si la pieza va a la papelera, el producto también. La sincronización se ejecuta al final de cada petición.
- **Datos para el modal:** `casa_a_producto_datos_modal()` en `includes/producto-extra.php`.
- **Ruta de gestión propia eliminada:** antes existía `/catalogo-gestion/`. La gestión se hace con el panel de galería o en el admin.

### Plugin `jwt-gallery` (nombre visible: "lacasaa.cl Panel"), versión 2.0.20

Ruta: `wp-content/plugins/jwt-gallery/`. Activo.

- **Login:** `http://localhost/wordpress/proyecto4/galeria/` (shortcode `[jwt_gallery]`).
- **Panel:** `http://localhost/wordpress/proyecto4/galeria-panel/` (shortcode `[jwt_gallery_panel]`).
- **Acceso:** con correo y contraseña de un usuario de WordPress. Las credenciales no van en este archivo.
- **Campos de cada pieza:** título, descripción, precio por día (CLP), cantidad, medidas, categoría principal, subcategoría y de 1 a 3 imágenes (misma pieza en distintos ángulos).
- **Publicar una pieza:** primero se elige la categoría principal; la subcategoría muestra solo las de esa principal. Si la principal no tiene subcategorías, la pieza se guarda en la principal. Bajo los selectores aparece la ruta donde quedará la pieza y cuántas tiene.
- **Categorías (panel):** las crea el usuario. Hay dos formularios: "Nueva categoría" (principal) y "Nueva subcategoría" (elige la principal a la que pertenece). Un solo nivel de subcategorías. Un mismo nombre puede repetirse en niveles distintos (por ejemplo, "Alfombras" como principal y como subcategoría).
- **Lista de categorías:** cada principal tiene un botón **+** que muestra u oculta sus subcategorías, con sangría. Las subcategorías se pueden **arrastrar** sobre otra principal para moverlas; el servidor valida que el nombre no se repita en el nuevo nivel y que una principal con subcategorías no pase a ser subcategoría.
- **Buscador:** encima de las pestañas de categorías. Filtra solo subcategorías (en la lista y en las pestañas), sin importar mayúsculas ni tildes.
- **Límite:** máximo 3 imágenes por publicación, tanto en el panel como en el servidor.
- **Selectores con ruta:** las categorías aparecen como "Decoración › Cuadros" en el formulario de subida, en la edición y en las pestañas.
- **Cambios frente a todoacrilico:** sin logo, categorías por defecto vacías y nombre de marca "lacasaa.cl". Detalle en `Docs_Plugin.md`.
- **Efecto secundario:** el plugin deshabilita XML-RPC en todo el sitio.

## Decisiones y pendientes

**Contenido por completar:**
- Políticas "Garantía", "Plazos" y "Daños" en "Cómo arrendar".
- Política de privacidad: marcadores [POR COMPLETAR] (razón social, RUT, encargado, garantías de proveedores, plazos).
- Datos de contacto, redes sociales y número de WhatsApp. Sin número, el enlace y el botón flotante no aparecen.
- Productos reales en el catálogo. Hoy hay dos de prueba (la alfombra de yute no tiene precio).

**Decisiones tomadas:**
- El nombre visible es lacasaa.cl. Las rutas, carpetas y prefijos internos siguen con `casa-a`.
- La ruta `/galeria/` es el login del panel. La galería pública usa `en-accion`, y el enlace "Galería" del menú apunta ahí.
- Los checks de privacidad y de condiciones son obligatorios en Mi reserva. El de privacidad es obligatorio también en Contacto.
- Mi reserva: el nombre se guarda en mayúsculas y el correo y el nombre del proyecto en minúsculas.
- Los correos usan la paleta del sitio y muestran las miniaturas de los productos.
- El límite de stock en la selección es 99 cuando el producto no tiene unidades cargadas.

**Entorno:**
- El servidor web corre como `www-data`. `wp-content/uploads` debe ser escribible por ese usuario.
- El límite de subida de PHP es 2 MB (`upload_max_filesize`), y el plugin acepta 8 MB por imagen.
- El PHP de línea de comandos es 7.3, pero WordPress 7.1 exige 7.4. Para scripts de mantenimiento se usa `/usr/bin/php8.3`.
- Los zips `casa-a.zip` y `casa-a-catalogo.zip` son antiguos y no se usan: el theme y el plugin se activan desde sus carpetas.

**Pendiente:**
- **Envío de correos:** WP Mail SMTP está en modo `smtp` a `localhost:25`, y en este servidor no hay nadie escuchando. Además, el remitente que usa WordPress (`wordpress@localhost`) no es válido. Falta configurar un proveedor SMTP real en *Ajustes → WP Mail SMTP*, con remitente `hola@lacasaa.cl`, y probar una entrega. Las credenciales se ingresan en el plugin, no en archivos.
- **Categorías de galería:** la base de datos local tiene 33 categorías creadas por script (6 principales y 27 subcategorías) que el usuario debe revisar. Decidir si se borran para que las cree desde el panel. "Alfombras" (con sus 2 piezas) quedó como subcategoría de "Alfombras".
- **Editar una pieza publicada:** el formulario de edición sigue con un solo selector de categoría. Falta darle el mismo selector de principal y subcategoría que tiene la subida.
- **Piezas con más de 3 imágenes:** las que ya existían con más de 3 no se pueden guardar hasta quitar las sobrantes.
- Registro de consentimiento en el servidor (la ley 21.719 entra en vigencia el 01-DIC-2026).
- Confirmar si el enlace "Continuar a cotización" debe cambiar de destino.
- Revisar la política de privacidad con un abogado antes de publicarla.
- Decidir si se borran los zips antiguos.
- Despliegue a producción: definir cómo se suben los archivos del theme y de los plugins.

## Cómo probar

1. Entra a `http://localhost/wordpress/proyecto4/` y revisa el carrusel, el navbar transparente sobre la portada y el menú lateral.
2. En `galeria-panel/` crea las categorías principales y sus subcategorías (formularios separados). Sube una pieza eligiendo principal y subcategoría, con hasta 3 imágenes. Revisa que aparezca en `/producto/` con su modal.
3. Agrega más de dos productos a "Mi reserva", revisa la paginación de 2 por página y completa el formulario. Sin los dos checks, el formulario no debe enviarse.
4. El envío de correo necesita el SMTP configurado para llegar a `hola@lacasaa.cl`. Sin él, la solicitud responde "ok" pero el correo no sale.
