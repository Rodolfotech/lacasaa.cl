# lacasaa.cl — Brief y estado del proyecto

Última actualización: 2026-11-27

## Brief original

Espacio boutique multifuncional y hub creativo multidisciplinario (campañas fotográficas, producción de video, activaciones de marcas, podcast, eventos pequeños). lacasaa.cl además arrienda mobiliario, decoración y props para producciones audiovisuales.

Requisitos principales:
- **Sitio simple:** índice a la vista, con Inicio, Quiénes somos, Estudio, Contacto y catálogo.
- **Theme visual** (`casa-a`, nombre visible "lacasaa.cl").
- **Plugins:** catálogo de productos con categorías y subcategorías, y un panel de galería para subir las piezas.

## Estado actual

### Theme `casa-a` (versión 1.4.109)

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

**Logo:** `assets/img/LOGO.jpeg` (original), en el navbar y en el pie. `casa_a_logo_url()` (`functions.php`) usa `Logo.jpeg` si existe y, si no, `LOGO.jpeg`, y agrega la fecha de modificación a la URL (`?v=`) para que un logo reemplazado se vea sin borrar la caché. El mismo logo aparece en el login y en la cabecera del panel de galería.

**Navbar:** hamburguesa y logo a la izquierda; buscador centrado; "Contacto" y "Mi reserva" con contador a la derecha. Es transparente sobre la portada y toma colores claros al pasar el mouse o con el menú abierto. Con el menú abierto queda en blanco puro (#FFFFFF) y por encima del velo oscuro (`.casa-a-header.is-forzado`, z-index 150, también en la portada).

**Buscador (navbar):** al escribir desde 2 letras muestra sugerencias en un desplegable:
- **Categorías** (con su ruta, por ejemplo "Muebles › Sofás"). Solo categorías con productos, directos o en sus subcategorías. Ignoran tildes y mayúsculas.
- **Productos** (con foto, código y precio).
- Al elegir una categoría se abre el catálogo filtrado; al elegir un producto, su ficha. Endpoint REST `casa-a/v1/sugerencias`.

**Menú lateral (hamburguesa):** se abre con la hamburguesa o el logo (con el mouse, al pasar sobre ellos), con clic, y se cierra con la X, clic fuera o Escape. Fondo blanco sólido (#FFFFFF), sin sombra. Tipografía Cascadia Code.
- Arriba, "Ver todo" (enlace a `/producto/`, sin flecha, siempre visible).
- Cada categoría principal con subcategorías es un botón con una flecha `›` a la derecha. Al pulsarla, el menú muestra **solo esa categoría**: su nombre con un botón `‹` para volver y, debajo, **todas sus subcategorías una debajo de otra** (lista vertical). `‹` regresa a la lista completa. Al cerrar el menú vuelve a la lista.
- Las categorías sin subcategorías son enlaces directos, sin flecha.
- "Ver todo" y los títulos de categoría tienen la misma tipografía (1 rem, peso 600, mayúsculas).
- No tiene título en la cabecera (solo la X) ni enlaces a Galería o Quiénes somos (las páginas siguen existiendo, pero no están en el menú).
- Implementación: `template-parts/menu-lateral.php` (grupos y subcategorías) y `assets/js/menu-lateral.js` (`abrirGrupo()` / `volverGrupos()`).

**Panel "Mi reserva" (lateral):** se abre con el enlace "Mi reserva" del navbar o con "Ir a Mi reserva →" del modal de producto.
- Lista de productos seleccionados con foto, nombre, código, precio, cantidad (− / +) y basurero arriba a la derecha.
- 6 productos por página. La paginación queda centrada y fija sobre el botón; solo la lista se desplaza, sin barra visible.
- Botón "Solicitar cotización" abajo, en taupe; desactivado si no hay productos. Lleva a `/mi-reserva/`.

**Catálogo (`/producto/`):**
- **Filtro lateral:** muestra todas las categorías creadas en el plugin, agrupadas por principal. Si una principal no tiene subcategorías, aparece una sola vez como filtro, sin repetirse debajo. Cada principal tiene un botón + / − para desplegar sus subcategorías, una debajo de otra. Si una subcategoría activa está en el filtro, su grupo se abre al cargar. Sin texto "Arriendo", "Catálogo", "Solo disponibles" ni "Limpiar filtros".
- **Listado:** agrupado por categoría principal y subcategoría, con título en negrita y subtítulo en gris. Cada subcategoría muestra **6 productos por página** con paginación (reutiliza `paginacion.js`).
- **Tarjetas:** foto (abre el modal), código, nombre y precio por día. Si no está disponible, etiqueta "No disponible".
- **Modal de producto:** galería con miniaturas, descripción (debajo de su título, máximo dos líneas), medidas, valor de arriendo, unidades disponibles, cantidad y "Agregar a mi reserva". Al agregar muestra "Agregado a tu reserva." con "Ir a Mi reserva →" a la derecha, en la misma fila. Si la pieza no está disponible, la foto muestra la etiqueta "No disponible", el botón queda deshabilitado (y los botones de cantidad también) y debajo aparece: "Si quieres consultar por este producto, contáctanos." (enlace a `/contacto/`). Lo controla `assets/js/producto-modal.js` (`estaDisponible()`: `disponible` y stock > 0) con `template-parts/modal-producto.php`.

**Mi reserva (página `/mi-reserva/`):**
- **Requisito:** la página debe existir con la plantilla "Mi reserva" (`template-mi-reserva.php`). Sin la plantilla no se muestra el formulario ni los productos.
- **Sin productos:** los campos y el botón quedan deshabilitados, y aparece el modal "Debes seleccionar al menos un producto." al cargar la página, al quitar el último producto y al hacer clic en el formulario bloqueado. No aparece tras un envío ni durante la espera.
- **Lista:** misma selección, paginada de 2 en 2. Cada producto tiene un basurero arriba a la derecha. Al pulsarlo aparece el modal "¿Estás seguro?" con "El producto se eliminará de tu selección.", con Cancelar (gris taupe, hover gris) y Aceptar (negro, hover taupe), centrados. Esc o un clic fuera cierran sin quitar.
- **Ancho:** el contenido coincide con el del footer (contenedor de 1154 px, de 399 a 1521 px en pantalla de 1920); el formulario se limita a 560 px. Reglas finales al final de `style.css`.
- **Formulario** (todos obligatorios, salvo Mensaje, que es el comentario):
  - Nombre (3–25 caracteres, mayúsculas).
  - Correo (máximo 50 caracteres, minúsculas; `casa_a_email_valido()` lo valida en servidor).
  - Teléfono con prefijo +56 9 (8 dígitos, sin primer dígito 1 ni 2).
  - Nombre del proyecto (hasta 25, minúsculas).
  - Fecha de retiro y de devolución (la devolución no puede ser anterior al retiro).
  - Mensaje (2000 caracteres, contador "Límite 2000 caracteres" a la derecha, debajo del campo).
  - Dos checks: condiciones de arriendo y política de privacidad.
  - Cada campo obligatorio tiene asterisco; al pasar el mouse sobre el asterisco aparece el popover "Campo obligatorio" (`.casa-a-obligatorio`).
  - Campo trampa anti-spam.
- **Errores por campo** (`assets/js/validacion-campos.js`, compartido con Contacto): el mensaje aparece debajo del campo que falla, con un texto propio por campo (por ejemplo, "Ingresa un correo válido."). Antes de enviar se marcan todos los campos incompletos y se enfoca el primero. El servidor indica el campo que rechazó (`casa_a_campo`) y ese campo se marca. El aviso general de error no se usa.
- **Los datos nunca se borran:** se guardan en `sessionStorage` mientras el usuario escribe y se restauran al cargar la página tras un error, una espera o una recarga. Solo se borran tras un envío correcto.
- **Espera de 5 minutos por IP** (`casa_a_cotizacion_procesar`, transient `casa_a_espera_*`): tras un envío correcto, la misma IP debe esperar 5 minutos. Tras un envío correcto aparece el modal de éxito; al cerrarlo, aparece el modal de espera (texto negro, X) con cuenta regresiva en `M:SS` que se actualiza cada segundo y cierra el modal al llegar a cero. Al recargar durante la espera, el modal vuelve a aparecer. Si se pulsa "Enviar" antes de tiempo, aparece el modal con el tiempo que falta. El botón no queda deshabilitado. La espera se guarda en el navegador (`casa_a_reserva_espera_hasta`).
- **Resultado en la URL:** tras un envío correcto se quita `casa_a_cotizacion` de la dirección, para que el modal no vuelva a aparecer al recargar. El modal de éxito lo abre `aviso-modal.js` y emite `casaa:aviso-cerrado` al cerrarse.
- **Envío** a `hola@lacasaa.cl` con correo HTML (paleta del sitio, miniaturas incrustadas). La sección del texto se titula "Mensaje".
- **Teléfono:** obligatorio en el formulario y en el servidor.

**Portada:** carrusel de tres diapositivas, centradas verticalmente sobre la imagen (etiqueta, título, botón).
- Muebles → `/producto/?s=Sofás`; Decoración → `/producto/?s=Decoración` (botón taupe, texto negro); Escenografía → `/producto/?s=Escenografía`.
- Puntos de navegación, avance cada 6 segundos, teclado y deslizar.

**Contacto (`/contacto/`):** título "Contacto" centrado y subtítulo "Respuesta en menos de 24 horas hábiles."
- Formulario a la izquierda, con todos los campos obligatorios y asterisco con popover "Campo obligatorio": Nombre, Correo (máximo 50 caracteres; la etiqueta dice "Correo"), Teléfono (8 dígitos), Mensaje (2000, con "Límite 2000 caracteres") y el check de privacidad.
- Errores por campo igual que en Mi reserva (`validacion-campos.js`), con textos propios por campo. Sin modal para errores; el modal solo aparece tras un envío correcto.
- Tras un envío correcto: modal "Gracias. Recibimos tu mensaje y te responderemos pronto." y, al cerrarlo, el modal de espera de 5 minutos con cuenta regresiva (igual que en Mi reserva; límite por IP en `casa_a_contacto_procesar`). Los datos no se borran tras un error.
- El correo al equipo tiene el asunto "Nuevo mensaje de contacto desde lacasaa.cl: NOMBRE", la sección "Mensaje" y no incluye promociones.
- A la derecha: mapa de Google Maps, enlace "Abrir en Google Maps" y datos: Dirección (Padre Orellana 1957, Santiago), Teléfono (+569 8510 3181), Mail (hola@lacasaa.cl), Horario de atención (lunes a viernes 9:30–17hrs) y Redes sociales (Instagram @casaa.cl).

**Footer:** fondo gris claro, franja taupe arriba, contenido centrado en 1170 px. Columnas: marca con logo y descripción, Contacto, Horario y Ayuda. Barra inferior con copyright y, a la derecha, "Política de privacidad" y "Configurar cookies". En la columna Ayuda, "Condiciones de arriendo" lleva a `/condiciones-de-arriendo/`. El pie queda siempre al final de la página, aunque el contenido sea corto (regla de `body` en `style.css`).

**Cookies (ley 21.719):** banner con el texto "Usamos cookies de medición (Google Analytics, Microsoft Clarity y Google Tag Manager) para entender cómo se usa el sitio. Solo se instalan si las aceptas. Más información en la Política de privacidad." (`template-parts/cookies-banner.php`, `data-version="2"`).
- **Ubicación y comportamiento:** fijo al pie de la pantalla mientras no se acepte ni rechace (no bloquea el resto del sitio). Se muestra en **cada visita** del mismo usuario. Ocupa el ancho completo y la página deja espacio para él (`body:has(...)`).
- **Botones:** "Aceptar" (taupe) y "Rechazar" (gris claro), del mismo tamaño. Rechazar borra las cookies analíticas.
- **Analítica:** Google Tag Manager (GTM-5CFDL8ZS) y Microsoft Clarity (zi7qd4b8ue) se cargan solo si la última decisión guardada es aceptada. La decisión se guarda en el navegador (`casa_a_cookies`, con fecha y versión).
- **"Configurar cookies"** del pie reabre el banner y muestra la decisión vigente.
- **Lógica:** `assets/js/cookies.js` (`mostrar()`, `ocultar()`, `activarAnalitica()`). Al cambiar el texto, subir `data-version` para que cada visitante vea el texto nuevo.
- Estilos: `.casa-a-cookies` (fijo al pie con `:not([hidden])`) en `style.css`.

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
| Galería (login) | `galeria` | shortcode `[jwt_gallery]` |
| Galería panel | `galeria-panel` | shortcode `[jwt_gallery_panel]` |

### Catálogo de productos (integrado en `jwt-gallery` 2.1.6)

El catálogo ya no es un plugin aparte: su código está en `wp-content/plugins/jwt-gallery/includes/catalogo/`. El plugin `casa-a-catalogo` está retirado. **No se instala junto a `jwt-gallery`**: sus funciones se repiten y PHP falla.

- **Tipo de contenido `producto`** con la taxonomía jerárquica `categoria_producto` (principal y subcategorías) y las taxonomías `estilo_producto`, `color_producto` y `material_producto`.
- **Metadatos:** código (`casa_a_codigo`), precio por día (`casa_a_precio_dia`), disponibilidad (`casa_a_disponible`), unidades (`casa_a_stock`), dimensiones, uso y galería de adjuntos (`casa_a_galeria`).
- **Sincronización con la galería** (`includes/catalogo/sync-galeria.php`): cada pieza publicada en el panel crea o actualiza su producto, con título, descripción, medidas, categoría (buscada dentro de su principal), precio, cantidad, disponibilidad y las imágenes. La casilla "No disponible" manda sobre la cantidad. Si una imagen ya importada perdió su archivo, se reimporta. La primera imagen queda como destacada. Si la pieza va a la papelera, el producto también.
- **Espejo de categorías** (`includes/catalogo/espejo-categorias.php`): cada categoría creada en el panel (`jg_gallery_category`) tiene su copia en `categoria_producto`. Al crear, editar, mover o eliminar una categoría o subcategoría en el panel, el catálogo se actualiza solo. La copia se busca por nombre **dentro del mismo padre**. Las copias se marcan con `_casa_a_origen`; el menú y el filtro muestran solo las que tienen una categoría del panel existente.

### Plugin `jwt-gallery` ("CASA A Panel"), versión 2.1.6

Ruta: `wp-content/plugins/jwt-gallery/`. Activo.

- **Login** (`/galeria/`, shortcode `[jwt_gallery]`) y **panel** (`/galeria-panel/`, shortcode `[jwt_gallery_panel]`), con el logo de lacasaa.cl en ambos. Autenticación con JWT y usuarios de WordPress; las credenciales no van en este archivo.
- **Categorías:** un formulario "Nueva categoría" (principal) y otro "Nueva subcategoría" (la principal es obligatoria). Un solo nivel de subcategorías. Un mismo nombre puede repetirse en niveles distintos. Nombres: principales en MAYÚSCULAS; subcategorías con la primera letra en mayúscula y el resto en minúscula (`categoria_formato()` en el servidor). Lista con botón + / − por principal, sangría en las subcategorías, arrastre de una subcategoría sobre otra principal para moverla, renombrar y eliminar. Buscador que filtra subcategorías, sin tildes ni mayúsculas.
- **Eliminar una categoría (regla):** se eliminan la categoría, **todas sus subcategorías** y **todas las piezas** de ellas, con sus archivos en `uploads/jg-gallery/`. Se borran primero las subcategorías y al final la principal, y el espejo del catálogo se actualiza solo (`deleted_term`). La respuesta incluye `subcategories_deleted` y `pieces_deleted`.
- **Publicar una pieza:** categoría principal y subcategoría (la subcategoría depende de la principal). Si la principal no tiene subcategorías, la pieza se guarda en la principal.
- **Piezas:** título (43 caracteres), descripción (**82 caracteres sin contar espacios**, `description_length()`), precio por día (CLP), cantidad, medidas (**40 caracteres**), casilla "No disponible" y **de 1 a 3 imágenes** (el servidor rechaza más).
  - La casilla "No disponible" muestra el check, el texto y el popover "i" en una sola línea (`.jg-form .jg-checkbox-label`, `labelWithHint()` con la entrada `no_disponible` de `HINTS`).
  - Al editar, la descripción se valida solo si cambió: una pieza guardada con un texto más largo se puede seguir editando (por ejemplo, para marcarla "No disponible"). Al crear, el límite siempre se aplica.
  - Al editar: quitar imágenes con la ×, subir nuevas y **arrastrar para reordenar** (la primera es la principal).
- **Subida con la conexión interrumpida:** si la conexión se pierde al publicar, el mensaje dice que la pieza podría haberse guardado y la galería se recarga (antes decía "Error de red" y permitía publicar dos veces).
- **Datos del modal de producto** (`casa_a_producto_datos_modal()`): `disponible` (de `casa_a_disponible`) y `descripcion` (contenido del producto sin HTML), que usa el theme.
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
- "Cómo arrendar" tiene solo los tres pasos (sin etiqueta, sin botón al catálogo y sin sección de políticas).
- "Condiciones de arriendo" es la página de políticas: nombre único en el footer, en la casilla de Mi reserva y en el título. Los siete puntos están en `template-condiciones.php`.

**Entorno:**
- El servidor web corre como `www-data`. `wp-content/uploads/` y `jg-gallery/` deben ser escribibles por ese usuario.
- `wp-content/uploads` se perdió con la carpeta del proyecto: las fotos de productos y de la biblioteca hay que volver a subirlas desde el panel, o restaurarlas desde una copia.
- El PHP de línea de comandos es 7.3, pero WordPress 7.1 exige 7.4. Para scripts de mantenimiento se usa `/usr/bin/php8.3`.
- Hay caché de página (LiteSpeed): tras cambios, recargar con Ctrl+F5 y purgar la caché del servidor.
- **Local:** el plugin `casa-a-catalogo` se retiró de `wp-content/plugins/` (copia en el scratchpad) porque chocaba con `jwt-gallery`. El `.htaccess` local tiene `RewriteBase /wordpress/proyecto4/`, que es solo para este entorno.
- **Producción (`lacasaa.cl`):** `CASA A Panel` activo, theme `CASA A` activo, `casa-a-catalogo` no instalado. Falta subir `casa-a-theme-1.4.109.zip` y `jwt-gallery-2.1.6.zip`, guardar enlaces permanentes y crear las páginas `galeria`, `galeria-panel`, `contacto`, `como-arrendar`, `condiciones-de-arriendo` y `politica-de-privacidad`. Esas seis ya responden 200 en lacasaa.cl. La página **`mi-reserva`** (título "Mi reserva", slug `mi-reserva`) ya está creada en producción con la plantilla "Mi reserva" (`template-mi-reserva.php`). Si no se elige esa plantilla, la página no muestra el formulario ni los productos. El tema no la crea solo.
- **Credenciales:** `README.MD` tiene una contraseña en texto plano. No se repite aquí; debe quitarse del archivo y cambiarse.
- **Recuadro "wordpress-proyecto3"** en las páginas: no está en el código del proyecto. Probablemente es una extensión del navegador; se comprueba en incógnito.

**Pendiente:**
- **Envío de correos:** WP Mail SMTP está en modo `smtp` a `localhost:25` sin servidor, y el remitente `wordpress@localhost` no es válido. Falta un SMTP real y remitente `hola@lacasaa.cl`.
- **Ley 21.719 (vigencia el 1 de diciembre de 2026):**
  - El banner debe informar la transferencia de datos fuera de Chile y las garantías, o remitir expresamente a la Política de privacidad, que debe contenerlo. El texto actual no lo menciona; se decidió no agregarlo todavía.
  - Registro del consentimiento en el servidor (la ley exige poder demostrarlo; hoy se guarda solo en el navegador).
  - El banner aparece en cada visita por instrucción expresa; la ley no lo exige. Revisar con un abogado.
  - Revisión de los textos con un abogado.
- **Subida de piezas con "Error de red":** el diagnóstico de la consola mostró `ERR_NETWORK_CHANGED` y `ERR_NAME_NOT_RESOLVED` en `wp-json/jwt-gallery/v1/images`. Pendiente confirmar con la URL completa de la petición y con una imagen pequeña. Con curl, producción responde 406 (Apache) a multipart con archivo sin cabeceras de navegador; no se confirmó que afecte a los navegadores.
- **Sitemap de usuarios:** `wp-sitemap-users-1.xml` expone los nombres de usuario. Pendiente decidir si se quita (no se cambió).
- **Fotos:** volver a subir las imágenes de las piezas y productos cuyos archivos faltan.
- **Buscador:** versión móvil dentro del menú hamburguesa; sinónimos (silla → sillas y sillones); búsqueda de productos sin tildes.
- **Textos legales:** completar los [POR COMPLETAR] de la política de privacidad.
- **Datos reales:** productos de prueba en el catálogo; número de WhatsApp (el footer lo tiene vacío, así que el botón flotante no aparece); redes.
- **Calendario de reservas** en Contacto (hoy hay solicitud de arriendo y formulario de mensaje).
- **Despliegue a producción** de theme y plugins: definir cómo se suben los archivos.
- Decidir si se borran `casa-a.zip` y `casa-a-catalogo.zip` (antiguos).
- Confirmar en producción el selector de categoría padre al crear una subcategoría (plugin 2.1.6).
- Revisar en producción que no queden copias fantasma de categorías borradas.
- Quitar la contraseña de `README.MD` y cambiarla.
- Revisar los estilos recuperados de Condiciones de arriendo: se tomaron de la transcripción de la sesión anterior.
- Identificar el recuadro "wordpress-proyecto3" (probablemente una extensión del navegador).

## Cómo probar

1. Entra a `http://localhost/wordpress/proyecto4/`: revisa la portada, el navbar (blanco al abrir el menú), el banner de cookies al pie (aparece en cada visita hasta aceptar o rechazar) y el logo.
2. Abre la hamburguesa: pulsa una categoría con flecha y revisa que solo se vean sus subcategorías, una debajo de otra; `‹` vuelve a la lista; "Ver todo" no tiene flecha.
3. En `galeria-panel/` crea una categoría principal y una subcategoría; sube una pieza con principal, subcategoría y hasta 3 imágenes. Revisa que aparezca en `/producto/` bajo su subcategoría. Al eliminar una categoría con subcategorías, deben desaparecer también sus piezas.
4. En `/producto/` prueba el buscador del navbar y el botón + de las categorías. Agrega un producto a "Mi reserva" y revisa el panel (6 por página).
5. En `/mi-reserva/`: sin productos, el formulario queda bloqueado y aparece el aviso en modal. Con productos, envía con campos vacíos o inválidos y revisa que el mensaje aparezca debajo de cada campo sin borrar lo escrito. Tras un envío correcto aparece el modal de éxito y luego el de espera con cuenta regresiva.
6. En `/contacto/`, lo mismo: campos obligatorios con asterisco y popover, mensajes por campo, y el modal de espera de 5 minutos tras un envío.

Sin SMTP, el envío responde "ok" pero el correo no sale.
