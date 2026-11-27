# lacasaa.cl — Brief y estado del proyecto

Última actualización: 2026-11-27

## Brief original

Espacio boutique multifuncional y hub creativo multidisciplinario (campañas fotográficas, producción de video, activaciones de marcas, podcast, eventos pequeños). lacasaa.cl además arrienda mobiliario, decoración y props para producciones audiovisuales.

Requisitos principales:
- **Sitio simple:** índice a la vista, con Inicio, Quiénes somos, Estudio, Contacto y catálogo.
- **Theme visual** (`casa-a`, nombre visible "lacasaa.cl").
- **Plugins:** catálogo de productos con categorías y subcategorías, y un panel de galería para subir las piezas.

## Estado actual

### Theme `casa-a` (versión 1.4.53)

Ruta: `wp-content/themes/casa-a/`. Activo.

**Paleta** (variables en `:root` de `style.css`; `theme.json` usa la misma tipografía):

| Nombre | Hex | Variable | Uso |
|---|---|---|---|
| Negro | #000000 | `--casa-a-negro` | Títulos, texto, botones principales |
| Gris | #8E8E8E | `--casa-a-gris` | Texto chico, bordes, datos secundarios |
| Gris claro | #E9E9E9 | `--casa-a-gris-claro` | Fondos de paneles, footer, tarjetas |
| Taupe | #B0A08A | `--casa-a-taupe` | Acentos, botón de aceptar cookies, botón "Ver decoración" |
| Gris taupe | #A0968C | `--casa-a-gris-taupe` | Hover de botones, contador de Mi reserva |
| Blanco | #FFFFFF | `--casa-a-blanco` | Fondo de página |

**Tipografía:** Cascadia Code en todo el sitio (archivos en `assets/fonts/`, pesos 400, 500, 600 y 700). Esquinas rectas, sin sombras.

**Logo:** `assets/img/LOGO.jpeg`, en el navbar (52 px) y en el pie (76 px). El mismo logo aparece en el login y en la cabecera del panel de galería.

**Navbar:** hamburguesa y logo a la izquierda; buscador centrado; "Contacto" y "Mi reserva" con contador a la derecha. Es transparente sobre la portada y toma colores claros al pasar el mouse o con el menú abierto.

**Buscador (navbar):** al escribir desde 2 letras muestra sugerencias en un desplegable:
- **Categorías** (con su ruta, por ejemplo "Muebles › Sofás"). Solo categorías con productos, directos o en sus subcategorías. Ignoran tildes y mayúsculas.
- **Productos** (con foto, código y precio).
- Al elegir una categoría se abre el catálogo filtrado; al elegir un producto, su ficha. Endpoint REST `casa-a/v1/sugerencias`.

**Menú lateral (hamburguesa):** se abre con el mouse sobre la hamburguesa o el logo, o con clic. Muestra "Ver todo", las categorías principales del plugin con sus subcategorías (todas, incluidas las vacías), y al final Galería (`/en-accion/`) y Quiénes somos (`/casa-a/`). Sin barra de scroll visible.

**Panel "Mi reserva" (lateral):** se abre con el enlace "Mi reserva" del navbar o con "Ir a Mi reserva →" del modal de producto.
- Lista de productos seleccionados con foto, nombre, código, precio, cantidad (− / +) y basurero arriba a la derecha.
- 6 productos por página. La paginación queda centrada y fija sobre el botón; solo la lista se desplaza, sin barra visible.
- Botón "Solicitar cotización" abajo, en taupe; desactivado si no hay productos. Lleva a `/mi-reserva/`.

**Catálogo (`/producto/`):**
- **Filtro lateral:** muestra todas las categorías creadas en el plugin, agrupadas por principal. Cada principal tiene un botón + / − para desplegar sus subcategorías, una debajo de otra. Si una subcategoría activa está en el filtro, su grupo se abre al cargar. Sin texto "Arriendo", "Catálogo", "Solo disponibles" ni "Limpiar filtros".
- **Listado:** agrupado por categoría principal y subcategoría, con título en negrita y subtítulo en gris. Cada subcategoría muestra **6 productos por página** con paginación (reutiliza `paginacion.js`).
- **Tarjetas:** foto (abre el modal), código, nombre y precio por día. Si no está disponible, etiqueta "No disponible".
- **Modal de producto:** galería con miniaturas, medidas, valor de arriendo, unidades disponibles, cantidad y "Agregar a mi reserva". Al agregar muestra "Agregado a tu reserva." con "Ir a Mi reserva →" a la derecha, en la misma fila.

**Mi reserva (página `/mi-reserva/`):**
- Lista de la misma selección, paginada de 2 en 2.
- Formulario de solicitud: nombre (3–25, mayúsculas), correo (minúsculas, máximo 35), teléfono con prefijo +56 9 (8 dígitos, sin primer dígito 1 ni 2), nombre del proyecto (hasta 25, minúsculas), fechas de retiro y devolución, comentarios (2000), y dos checks obligatorios: condiciones de arriendo y política de privacidad. Campo trampa anti-spam.
- Envío a `hola@lacasaa.cl` con correo HTML (paleta del sitio, miniaturas incrustadas de los productos).

**Portada:** carrusel de tres diapositivas, centradas verticalmente sobre la imagen (etiqueta, título, botón).
- Muebles → `/producto/?s=Sofás`; Decoración → `/producto/?s=Decoración` (botón taupe, texto negro); Escenografía → `/producto/?s=Escenografía`.
- Puntos de navegación, avance cada 6 segundos, teclado y deslizar.

**Contacto (`/contacto/`):** título "Contacto" centrado y subtítulo "Respuesta en menos de 24 horas hábiles."
- Formulario a la izquierda: nombre, mail, teléfono, mensaje (2000), check de privacidad obligatorio, botón ENVIAR (negro, gris taupe al pasar el mouse).
- A la derecha: mapa de Google Maps, enlace "Abrir en Google Maps" y datos: Dirección (Padre Orellana 1957, Santiago), Teléfono (+569 8510 3181), Mail (hola@lacasaa.cl), Horario de atención (lunes a viernes 9:30–17hrs) y Redes sociales (Instagram @casaa.cl).
- Aviso centrado tras enviar; el mensaje se valida en servidor y en el navegador.

**Footer:** fondo gris claro, franja taupe arriba, contenido centrado en 1170 px. Columnas: marca con logo y descripción, Contacto, Horario y Ayuda. Barra inferior con copyright y, a la derecha, "Política de privacidad" y "Configurar cookies".

**Cookies (ley 21.719):** banner con texto informado (finalidad, transferencia fuera de Chile, cómo cambiar la decisión, versión 1.0 de la política). Botones "Aceptar" (taupe) y "Rechazar" (gris claro), del mismo tamaño. Google Tag Manager (GTM-5CFDL8ZS) y Microsoft Clarity (zi7qd4b8ue) se cargan solo tras aceptar. Rechazar borra las cookies analíticas. "Configurar cookies" del pie reabre el banner, lo lleva a la vista y muestra la decisión vigente. La decisión se guarda en el navegador (`casa_a_cookies`).

**Indexación y SEO:** `robots.txt` generado por el theme (bloquea `/galeria/`, `/galeria-panel/` y `/wp-admin/`; incluye el sitemap). `wp-sitemap.xml` activo. Meta `google-site-verification` en el `<head>`. Sitio visible para buscadores.

**Formularios:** los campos y validaciones están en `functions.php` (`casa_a_contacto_procesar`, `casa_a_cotizacion_procesar`, `casa_a_email_valido`) y en `assets/js/telefono.js`, `minusculas.js`, `requeridos.js`. Los mensajes de campo obligatorio están en español.

**Otros:** scrollbars ocultas en todo el sitio. Elementos con `hidden` siempre ocultos (regla global).

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
| Catálogo | archivo de `producto` (`/producto/`) | `archive-producto.php` |

### Plugin `casa-a-catalogo`

Ruta: `wp-content/plugins/casa-a-catalogo/`. Activo.

- **Tipo de contenido `producto`** con la taxonomía jerárquica `categoria_producto` (principal y subcategorías) y las taxonomías `estilo_producto`, `color_producto` y `material_producto`.
- **Metadatos:** código (`casa_a_codigo`), precio por día (`casa_a_precio_dia`), disponibilidad (`casa_a_disponible`), unidades (`casa_a_stock`), dimensiones, uso y galería de adjuntos (`casa_a_galeria`).
- **Sincronización con la galería** (`includes/sync-galeria.php`): cada pieza publicada en el panel crea o actualiza su producto, con título, descripción, medidas, categoría (buscada dentro de su principal), precio, cantidad, disponibilidad y las imágenes. La casilla "No disponible" manda sobre la cantidad. Si una imagen ya importada perdió su archivo, se reimporta. La primera imagen queda como destacada. Si la pieza va a la papelera, el producto también.
- **Espejo de categorías** (`includes/espejo-categorias.php`): cada categoría creada en el panel (`jg_gallery_category`) tiene su espejo en `categoria_producto`. Al crear, editar, mover o eliminar una categoría o subcategoría en el panel, el catálogo se actualiza solo. Los espejos se marcan con `_casa_a_origen`; el menú y el filtro muestran solo esos.

### Plugin `jwt-gallery` ("lacasaa.cl Panel"), versión 2.0.29

Ruta: `wp-content/plugins/jwt-gallery/`. Activo.

- **Login** (`/galeria/`, shortcode `[jwt_gallery]`) y **panel** (`/galeria-panel/`, shortcode `[jwt_gallery_panel]`), con el logo de lacasaa.cl en ambos. Autenticación con JWT y usuarios de WordPress; las credenciales no van en este archivo.
- **Categorías:** un formulario "Nueva categoría" (principal) y otro "Nueva subcategoría" (la principal es obligatoria). Un solo nivel de subcategorías. Un mismo nombre puede repetirse en niveles distintos. Lista con botón + / − por principal, sangría en las subcategorías, arrastre de una subcategoría sobre otra principal para moverla, renombrar y eliminar. Buscador (encima de las pestañas) que filtra subcategorías, sin tildes ni mayúsculas.
- **Publicar una pieza:** categoría principal y subcategoría (la subcategoría depende de la principal). Si la principal no tiene subcategorías, la pieza se guarda en la principal. Bajo los selectores aparece la ruta y el número de piezas.
- **Piezas:** título, descripción, precio por día (CLP), cantidad, medidas, casilla "No disponible" y **de 1 a 3 imágenes** (el servidor rechaza más). Al editar: quitar imágenes con la ×, subir nuevas y **arrastrar para reordenar** (la primera es la principal). El orden se guarda.
- **Tarjetas del panel:** imagen con contador x/3, etiqueta de categoría arriba a la izquierda y etiqueta "No disponible" abajo a la izquierda.
- **Almacenamiento:** imágenes en `wp-content/uploads/jg-gallery/`. Esa carpeta debe ser escribible por el usuario del servidor (`www-data`).
- **Estilo:** el mismo del theme (paleta, Cascadia Code, esquinas rectas, botones negros con mayúsculas).
- **Seguridad:** XML-RPC deshabilitado; los endpoints del plugin requieren sesión válida.

## Decisiones y pendientes

**Decisiones tomadas:**
- El nombre visible es lacasaa.cl. Las rutas, carpetas y prefijos internos siguen con `casa-a`.
- La ruta `/galeria/` es el login del panel. La galería pública usa `en-accion`.
- Los checks de condiciones y de privacidad son obligatorios en Mi reserva; el de privacidad también en Contacto.
- El panel "Mi reserva" muestra 6 productos por página; la página `/mi-reserva/`, 2.
- El catálogo muestra solo las categorías creadas en el plugin (no las que solo existen en el catálogo).
- Los correos usan la paleta del sitio y muestran las miniaturas de los productos.

**Entorno:**
- El servidor web corre como `www-data`. `wp-content/uploads/` y `jg-gallery/` deben ser escribibles por ese usuario.
- `wp-content/uploads` se perdió con la carpeta del proyecto: las fotos de productos y de la biblioteca hay que volver a subirlas desde el panel, o restaurarlas desde una copia.
- El PHP de línea de comandos es 7.3, pero WordPress 7.1 exige 7.4. Para scripts de mantenimiento se usa `/usr/bin/php8.3`.
- Hay caché de página (LiteSpeed): tras cambios, recargar con Ctrl+F5.

**Pendiente:**
- **Envío de correos:** WP Mail SMTP está en modo `smtp` a `localhost:25` sin servidor, y el remitente `wordpress@localhost` no es válido. Falta un SMTP real y remitente `hola@lacasaa.cl`.
- **Registro de consentimiento en el servidor** (la ley 21.719 exige poder demostrar el consentimiento; hoy se guarda solo en el navegador).
- **Fotos:** volver a subir las imágenes de las piezas y productos cuyos archivos faltan.
- **Buscador:** versión móvil dentro del menú hamburguesa; sinónimos (silla → sillas y sillones); búsqueda de productos sin tildes.
- **Textos legales:** completar los [POR COMPLETAR] de la política de privacidad; revisarla con un abogado.
- **Datos reales:** productos de prueba en el catálogo; número de WhatsApp; redes.
- **Calendario de reservas** en Contacto (hoy hay solicitud de arriendo y formulario de mensaje).
- **Despliegue a producción** de theme y plugins: definir cómo se suben los archivos.
- Decidir si se borran `casa-a.zip` y `casa-a-catalogo.zip` (antiguos).

## Cómo probar

1. Entra a `http://localhost/wordpress/proyecto4/`: revisa la portada, el navbar, el footer y el banner de cookies.
2. En `galeria-panel/` crea una categoría principal y una subcategoría; sube una pieza con principal, subcategoría y hasta 3 imágenes. Revisa que aparezca en `/producto/` bajo su subcategoría.
3. En `/producto/` prueba el buscador del navbar y el botón + de las categorías. Agrega un producto a "Mi reserva" y revisa el panel (6 por página).
4. Envía el formulario de `/contacto/` con datos de prueba. Sin SMTP, la solicitud responde "ok" pero el correo no sale.
