<?php
/**
 * Funciones del theme lacasaa.cl.
 *
 * @package CASA_A
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function casa_a_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );

	register_nav_menus(
		array(
			'principal' => __( 'Menú principal', 'casa-a' ),
		)
	);
}
add_action( 'after_setup_theme', 'casa_a_setup' );

function casa_a_enqueue_assets() {
	wp_enqueue_style( 'casa-a-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_assets' );

/**
 * Paginación y "Mi selección" (el segundo depende de la paginación).
 */
function casa_a_enqueue_seleccion() {
	wp_enqueue_script( 'casa-a-paginacion', get_template_directory_uri() . '/assets/js/paginacion.js', array(), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'casa-a-seleccion', get_template_directory_uri() . '/assets/js/seleccion.js', array( 'casa-a-paginacion' ), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_seleccion' );

/**
 * Carrusel de la portada (solo en el home).
 */
function casa_a_enqueue_slider() {
	if ( ! is_front_page() ) {
		return;
	}

	wp_enqueue_script( 'casa-a-slider', get_template_directory_uri() . '/assets/js/slider.js', array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_slider' );

/**
 * Modal de producto: se abre desde las fotos del catálogo.
 */
function casa_a_enqueue_producto_modal() {
	wp_enqueue_script( 'casa-a-producto-modal', get_template_directory_uri() . '/assets/js/producto-modal.js', array( 'casa-a-seleccion' ), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_producto_modal' );

/**
 * Menú lateral del nav (hamburguesa).
 */
function casa_a_enqueue_menu_lateral() {
	wp_enqueue_script( 'casa-a-menu-lateral', get_template_directory_uri() . '/assets/js/menu-lateral.js', array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_menu_lateral' );

/**
 * Modal de aviso reutilizable (mensajes de envío, errores, etc.).
 */
function casa_a_enqueue_aviso_modal() {
	wp_enqueue_script( 'casa-a-aviso-modal', get_template_directory_uri() . '/assets/js/aviso-modal.js', array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_aviso_modal' );

/**
 * Formato del campo de teléfono (8 dígitos con espacio).
 */
function casa_a_enqueue_telefono() {
	wp_enqueue_script( 'casa-a-telefono', get_template_directory_uri() . '/assets/js/telefono.js', array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_telefono' );

function casa_a_enqueue_minusculas() {
	wp_enqueue_script( 'casa-a-minusculas', get_template_directory_uri() . '/assets/js/minusculas.js', array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_minusculas' );

function casa_a_enqueue_requeridos() {
	wp_enqueue_script( 'casa-a-requeridos', get_template_directory_uri() . '/assets/js/requeridos.js', array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_requeridos' );

add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_requeridos' );

/**
 * Script de la página "Mi reserva" (solo en esa plantilla).
 */
function casa_a_enqueue_reserva() {
	if ( ! is_page_template( 'template-mi-reserva.php' ) ) {
		return;
	}

	wp_enqueue_script( 'casa-a-reserva', get_template_directory_uri() . '/assets/js/reserva.js', array( 'casa-a-paginacion' ), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_reserva' );

/**
 * Analítica (GTM y Clarity) solo en páginas públicas; nunca en el panel privado de galería.
 *
 * @return bool
 */
function casa_a_analitica_activa() {
	return ! is_page( array( 'galeria', 'galeria-panel' ) );
}

/**
 * Script del banner de cookies. Carga GTM y Clarity solo si el visitante acepta.
 */
function casa_a_enqueue_cookies() {
	if ( ! casa_a_analitica_activa() ) {
		return;
	}

	wp_enqueue_script( 'casa-a-cookies', get_template_directory_uri() . '/assets/js/cookies.js', array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_cookies' );

/**
 * Clase para ocultar la barra de scroll visible en la página de contacto (la página sigue desplazable).
 *
 * @param string[] $clases Clases del body.
 * @return string[]
 */
function casa_a_clase_contacto( $clases ) {
	if ( is_page( 'contacto' ) ) {
		$clases[] = 'casa-a-pagina-contacto';
	}

	return $clases;
}
add_filter( 'body_class', 'casa_a_clase_contacto' );

/**
 * Verificación de Google Search Console (indexación).
 */
function casa_a_meta_verificacion_google() {
	echo '<meta name="google-site-verification" content="' . esc_attr( 'At01at2U_j49AKd9uHEs2o9HQRZ_a7t_iFaN1b4_f5Y' ) . '" />' . "\n";
}
add_action( 'wp_head', 'casa_a_meta_verificacion_google' );

/**
 * Menú de respaldo cuando aún no hay menú asignado.
 */
function casa_a_menu_fallback() {
	$items = array(
		__( 'Inicio', 'casa-a' )        => '/',
		__( 'Catálogo', 'casa-a' )      => '/producto/',
		__( 'Galería', 'casa-a' )       => '/en-accion/',
		__( 'Quiénes somos', 'casa-a' ) => '/casa-a/',
		__( 'Cómo arrendar', 'casa-a' ) => '/como-arrendar/',
		__( 'Contacto', 'casa-a' )      => '/contacto/',
	);

	echo '<ul class="casa-a-nav-list">';
	foreach ( $items as $etiqueta => $ruta ) {
		echo '<li><a href="' . esc_url( home_url( $ruta ) ) . '">' . esc_html( $etiqueta ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Correo válido: formato y dominio según is_email(), longitud máxima de 254 caracteres (límite de SMTP),
 * sin empezar con "." ni "@", sin comillas, guion bajo ni guion medio, una sola "@", sin espacios,
 * sin puntos seguidos ni junto a la "@", y parte local de máximo 64 caracteres.
 *
 * @param string $email Correo ya pasado por sanitize_email().
 * @return bool
 */
function casa_a_email_valido( $email ) {
	if ( ! is_email( $email ) || strlen( $email ) > 254 ) {
		return false;
	}

	// No puede empezar con "." ni "@", ni tener comillas, guion bajo o guion medio.
	if ( in_array( $email[0], array( '.', '@' ), true ) || false !== strpbrk( $email, '"_-' ) ) {
		return false;
	}

	// Una sola "@", sin espacios, sin puntos seguidos ni junto a la "@".
	if ( 1 !== substr_count( $email, '@' ) || preg_match( '/\s/', $email ) || false !== strpos( $email, '..' ) || false !== strpos( $email, '.@' ) || false !== strpos( $email, '@.' ) ) {
		return false;
	}

	// La parte antes de la "@" no puede superar los 64 caracteres.
	return strlen( strstr( $email, '@', true ) ) <= 64;
}

/**
 * Procesa el formulario de contacto de la página Contacto.
 */
function casa_a_contacto_procesar() {
	check_admin_referer( 'casa_a_contacto', 'casa_a_contacto_nonce' );

	$destino = wp_get_referer() ? wp_get_referer() : home_url( '/contacto/' );

	// Campo trampa anti-spam: los humanos no lo llenan.
	if ( ! empty( $_POST['sitio_web'] ) ) {
		wp_safe_redirect( add_query_arg( 'casa_a_estado', 'ok', $destino ) );
		exit;
	}

	$nombre = isset( $_POST['nombre'] ) ? sanitize_text_field( wp_unslash( $_POST['nombre'] ) ) : '';
	$nombre = function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $nombre ) : strtoupper( $nombre );

	$telefono_digitos = preg_replace( '/\D/', '', isset( $_POST['telefono'] ) ? wp_unslash( $_POST['telefono'] ) : '' );
	$telefono         = strlen( $telefono_digitos ) ? substr( $telefono_digitos, 0, 4 ) . ' ' . substr( $telefono_digitos, 4, 4 ) : '';
	$pais             = '+56 9';

	$email       = isset( $_POST['email'] ) ? strtolower( sanitize_email( wp_unslash( $_POST['email'] ) ) ) : '';
	$descripcion = isset( $_POST['descripcion'] ) ? sanitize_textarea_field( wp_unslash( $_POST['descripcion'] ) ) : '';
	$promociones = ! empty( $_POST['promociones'] ) ? 'Sí' : 'No';

	$largo_nombre      = function_exists( 'mb_strlen' ) ? mb_strlen( $nombre ) : strlen( $nombre );
	$largo_descripcion = function_exists( 'mb_strlen' ) ? mb_strlen( $descripcion ) : strlen( $descripcion );

	if ( $largo_nombre < 3 || $largo_nombre > 25 || ! casa_a_email_valido( $email ) || '' === $descripcion || $largo_descripcion > 2000 || empty( $_POST['privacidad'] ) || ( strlen( $telefono_digitos ) && ( 8 !== strlen( $telefono_digitos ) || in_array( $telefono_digitos[0], array( '1', '2' ), true ) ) ) ) {
		wp_safe_redirect( add_query_arg( 'casa_a_estado', 'error', $destino ) );
		exit;
	}

	$asunto = sprintf( __( 'Nueva cotización desde lacasaa.cl: %s', 'casa-a' ), $nombre );
	$cuerpo = casa_a_correo_plantilla(
		__( 'Nuevo mensaje de contacto', 'casa-a' ),
		casa_a_correo_seccion(
			__( 'Datos de contacto', 'casa-a' ),
			casa_a_correo_datos(
				array(
					__( 'Nombre', 'casa-a' )      => esc_html( $nombre ),
					__( 'Teléfono', 'casa-a' )    => casa_a_correo_telefono( trim( $pais . ' ' . $telefono ) ),
					__( 'Correo', 'casa-a' )      => casa_a_correo_enlace( $email ),
					__( 'Promociones', 'casa-a' ) => esc_html( $promociones ),
				)
			)
		)
		. casa_a_correo_seccion( __( 'Descripción del proyecto', 'casa-a' ), casa_a_correo_texto( $descripcion ) )
	);
	$cabeceras = array( 'Reply-To: ' . $nombre . ' <' . $email . '>', 'Content-Type: text/html; charset=UTF-8' );

	$enviado = wp_mail( 'hola@lacasaa.cl', $asunto, $cuerpo, $cabeceras );

	wp_safe_redirect( add_query_arg( 'casa_a_estado', $enviado ? 'ok' : 'fallo', $destino ) );
	exit;
}
add_action( 'admin_post_nopriv_casa_a_contacto', 'casa_a_contacto_procesar' );
add_action( 'admin_post_casa_a_contacto', 'casa_a_contacto_procesar' );

/**
 * Valida un RUT chileno (cuerpo y dígito verificador).
 *
 * @param string $rut RUT con o sin puntos y guion.
 * @return bool
 */
function casa_a_rut_valido( $rut ) {
	$rut = strtoupper( preg_replace( '/[^0-9kK]/', '', (string) $rut ) );

	if ( strlen( $rut ) < 2 ) {
		return false;
	}

	$cuerpo = substr( $rut, 0, -1 );
	$dv     = substr( $rut, -1 );

	if ( ! ctype_digit( $cuerpo ) ) {
		return false;
	}

	$suma     = 0;
	$multiplo = 2;

	for ( $i = strlen( $cuerpo ) - 1; $i >= 0; $i-- ) {
		$suma    += (int) $cuerpo[ $i ] * $multiplo;
		$multiplo = 7 === $multiplo ? 2 : $multiplo + 1;
	}

	$resto    = 11 - ( $suma % 11 );
	$esperado = 11 === $resto ? '0' : ( 10 === $resto ? 'K' : (string) $resto );

	return $dv === $esperado;
}

/**
 * Procesa la solicitud de arriendo de "Mi reserva".
 *
 * Los precios y los códigos se leen de la base de datos, nunca del navegador.
 */
function casa_a_cotizacion_procesar() {
	check_admin_referer( 'casa_a_cotizar', 'casa_a_cotizar_nonce' );

	$destino = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	// Campo trampa anti-spam: los humanos no lo llenan.
	if ( ! empty( $_POST['sitio_web'] ) ) {
		wp_safe_redirect( add_query_arg( 'casa_a_cotizacion', 'ok', $destino ) );
		exit;
	}

	$error = function () use ( $destino ) {
		wp_safe_redirect( add_query_arg( 'casa_a_cotizacion', 'error', $destino ) );
		exit;
	};

	$nombre = isset( $_POST['nombre'] ) ? sanitize_text_field( wp_unslash( $_POST['nombre'] ) ) : '';
	$nombre = function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $nombre ) : strtoupper( $nombre );

	$telefono_digitos = preg_replace( '/\D/', '', isset( $_POST['telefono'] ) ? wp_unslash( $_POST['telefono'] ) : '' );
	$telefono         = strlen( $telefono_digitos ) ? substr( $telefono_digitos, 0, 4 ) . ' ' . substr( $telefono_digitos, 4, 4 ) : '';
	$pais             = '+56 9';
	$pais             = '+56 9';

	$email        = isset( $_POST['email'] ) ? strtolower( sanitize_email( wp_unslash( $_POST['email'] ) ) ) : '';
	$nombre_proyecto = isset( $_POST['nombre_proyecto'] ) ? sanitize_text_field( wp_unslash( $_POST['nombre_proyecto'] ) ) : '';
	$nombre_proyecto = function_exists( 'mb_strtolower' ) ? mb_strtolower( $nombre_proyecto ) : strtolower( $nombre_proyecto );
	$comentarios   = isset( $_POST['comentarios'] ) ? sanitize_textarea_field( wp_unslash( $_POST['comentarios'] ) ) : '';
	$condiciones   = ! empty( $_POST['condiciones'] );
	$privacidad    = ! empty( $_POST['privacidad'] );
	$retiro        = isset( $_POST['fecha_retiro'] ) ? sanitize_text_field( wp_unslash( $_POST['fecha_retiro'] ) ) : '';
	$devolucion    = isset( $_POST['fecha_devolucion'] ) ? sanitize_text_field( wp_unslash( $_POST['fecha_devolucion'] ) ) : '';

	$largo_nombre = function_exists( 'mb_strlen' ) ? mb_strlen( $nombre ) : strlen( $nombre );

	$largo_proyecto = function_exists( 'mb_strlen' ) ? mb_strlen( $nombre_proyecto ) : strlen( $nombre_proyecto );

	if ( $largo_nombre < 3 || $largo_nombre > 25 || $largo_proyecto < 1 || $largo_proyecto > 25 || strlen( $email ) > 35 || strlen( $email ) > 35 || ! casa_a_email_valido( $email ) || ! $condiciones || ! $privacidad || ( function_exists( 'mb_strlen' ) ? mb_strlen( $comentarios ) : strlen( $comentarios ) ) > 2000 || ( strlen( $telefono_digitos ) && ( 8 !== strlen( $telefono_digitos ) || in_array( $telefono_digitos[0], array( '1', '2' ), true ) ) ) ) {
		$error();
	}

	foreach ( array( $retiro, $devolucion ) as $fecha ) {
		if ( ! preg_match( '/^(\d{4})-(\d{2})-(\d{2})$/', $fecha, $partes ) || ! checkdate( (int) $partes[2], (int) $partes[3], (int) $partes[1] ) ) {
			$error();
		}
	}

	if ( $devolucion < $retiro ) {
		$error();
	}

	$items = isset( $_POST['items'] ) ? json_decode( wp_unslash( $_POST['items'] ), true ) : null;

	if ( ! is_array( $items ) ) {
		$error();
	}

	$productos = array();
	$imagenes_correo = array();
	$total     = 0;

	foreach ( $items as $item ) {
		$id       = isset( $item['id'] ) ? absint( $item['id'] ) : 0;
		$cantidad = isset( $item['cantidad'] ) ? min( 99, max( 1, absint( $item['cantidad'] ) ) ) : 1;
		$producto = $id ? get_post( $id ) : null;

		if ( ! $producto || 'producto' !== $producto->post_type || 'publish' !== $producto->post_status ) {
			continue;
		}

		if ( '0' === get_post_meta( $id, 'casa_a_disponible', true ) ) {
			continue;
		}

		// Nunca más unidades que el stock real del producto.
		$stock = get_post_meta( $id, 'casa_a_stock', true );

		if ( '' !== (string) $stock ) {
			$cantidad = min( $cantidad, (int) $stock );

			if ( $cantidad < 1 ) {
				continue;
			}
		}

		$codigo = get_post_meta( $id, 'casa_a_codigo', true );
		$codigo = $codigo ? $codigo : 'CA-' . str_pad( (string) $id, 4, '0', STR_PAD_LEFT );
		$precio = (int) get_post_meta( $id, 'casa_a_precio_dia', true );

		$miniatura = casa_a_correo_miniatura( $id );
		if ( $miniatura ) {
			$imagenes_correo[ 'producto-' . $id ] = $miniatura;
		}
		$productos[] = array( $codigo, $producto->post_title, $cantidad, $precio * $cantidad, $miniatura ? 'producto-' . $id : '' );
		$total   += $precio * $cantidad;
	}

	if ( empty( $productos ) ) {
		$error();
	}

	$dias = (int) ( ( strtotime( $devolucion ) - strtotime( $retiro ) ) / DAY_IN_SECONDS ) + 1;

	$asunto = sprintf( __( 'Solicitud de arriendo de %s', 'casa-a' ), $nombre );

	$filas_productos = '';
	foreach ( $productos as $linea ) {
		$imagen = $linea[4]
			? '<img src="cid:' . esc_attr( $linea[4] ) . '" width="56" alt="" style="display:block;width:56px;height:auto;border:0;">'
			: '';

		$filas_productos .= '<tr>'
			. '<td style="' . casa_a_correo_celda() . 'width:64px;">' . $imagen . '</td>'
			. '<td style="' . casa_a_correo_celda() . 'font-size:12px;color:#8E8E8E;">' . esc_html( $linea[0] ) . '</td>'
			. '<td style="' . casa_a_correo_celda() . '">' . esc_html( $linea[1] ) . '</td>'
			. '<td style="' . casa_a_correo_celda( 'center' ) . '">' . (int) $linea[2] . '</td>'
			. '<td style="' . casa_a_correo_celda( 'right' ) . '">$' . esc_html( number_format_i18n( $linea[3] ) ) . '</td>'
			. '</tr>';
	}

	$tabla_productos = '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;font-size:13px;">'
		. '<tr style="background:#E9E9E9;">'
		. '<th style="' . casa_a_correo_celda() . '"></th>'
		. '<th style="' . casa_a_correo_celda() . 'font-size:11px;text-transform:uppercase;letter-spacing:1px;">' . esc_html__( 'Código', 'casa-a' ) . '</th>'
		. '<th style="' . casa_a_correo_celda() . 'font-size:11px;text-transform:uppercase;letter-spacing:1px;">' . esc_html__( 'Producto', 'casa-a' ) . '</th>'
		. '<th style="' . casa_a_correo_celda( 'center' ) . 'font-size:11px;text-transform:uppercase;letter-spacing:1px;">' . esc_html__( 'Cant.', 'casa-a' ) . '</th>'
		. '<th style="' . casa_a_correo_celda( 'right' ) . 'font-size:11px;text-transform:uppercase;letter-spacing:1px;">' . esc_html__( 'Subtotal/día', 'casa-a' ) . '</th>'
		. '</tr>'
		. $filas_productos
		. '</table>';

	$total_html = '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-top:14px;background:#B0A08A;border-collapse:collapse;">'
		. '<tr>'
		. '<td style="padding:14px 16px;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;">' . esc_html__( 'Total por día', 'casa-a' ) . '</td>'
		. '<td style="padding:14px 16px;font-size:18px;font-weight:700;text-align:right;">$' . esc_html( number_format_i18n( $total ) ) . '</td>'
		. '</tr></table>';

	$cuerpo = casa_a_correo_plantilla(
		__( 'Nueva solicitud de arriendo', 'casa-a' ),
		casa_a_correo_seccion(
			__( 'Cliente', 'casa-a' ),
			casa_a_correo_datos(
				array(
					__( 'Nombre', 'casa-a' )   => esc_html( $nombre ),
					__( 'Teléfono', 'casa-a' ) => casa_a_correo_telefono( trim( $pais . ' ' . $telefono ) ),
					__( 'Correo', 'casa-a' )   => casa_a_correo_enlace( $email ),
				)
			)
		)
		. casa_a_correo_seccion(
			__( 'Arriendo', 'casa-a' ),
			casa_a_correo_datos(
				array(
					__( 'Nombre del proyecto', 'casa-a' ) => esc_html( $nombre_proyecto ),
					__( 'Retiro', 'casa-a' )           => esc_html( $retiro ),
					__( 'Devolución', 'casa-a' )       => esc_html( sprintf( '%s (%d días)', $devolucion, $dias ) ),
				)
			)
		)
		. casa_a_correo_seccion( __( 'Comentarios', 'casa-a' ), casa_a_correo_texto( $comentarios ) )
		. casa_a_correo_seccion( __( 'Productos', 'casa-a' ), $tabla_productos . $total_html )
	);

	$GLOBALS['casa_a_correo_imagenes'] = $imagenes_correo;

	$enviado = wp_mail(
		'hola@lacasaa.cl',
		$asunto,
		$cuerpo,
		array( 'Reply-To: ' . $nombre . ' <' . $email . '>', 'Content-Type: text/html; charset=UTF-8' )
	);

	unset( $GLOBALS['casa_a_correo_imagenes'] );

	wp_safe_redirect( add_query_arg( 'casa_a_cotizacion', $enviado ? 'ok' : 'fallo', $destino ) );
	exit;
}
add_action( 'admin_post_nopriv_casa_a_cotizar', 'casa_a_cotizacion_procesar' );
add_action( 'admin_post_casa_a_cotizar', 'casa_a_cotizacion_procesar' );

/**
 * Filtros del catálogo que se leen de la URL: categoría, estilo, color, material y disponibilidad.
 */
function casa_a_catalogo_filtros() {
	return array(
		'categoria' => 'categoria_producto',
		'estilo'    => 'estilo_producto',
		'color'     => 'color_producto',
		'material'  => 'material_producto',
	);
}

/**
 * Aplica los filtros de la URL a la consulta del catálogo y a la búsqueda de productos.
 * Si lo buscado coincide con una categoría, se muestran sus productos.
 *
 * @param WP_Query $query Consulta principal.
 */
function casa_a_catalogo_aplicar_filtros( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	$es_catalogo = $query->is_post_type_archive( 'producto' );
	$es_busqueda = $query->is_search() && 'producto' === $query->get( 'post_type' );

	if ( ! $es_catalogo && ! $es_busqueda ) {
		return;
	}

	// Todos los productos en la página: la paginación por subcategoría (6 por página) se hace en el navegador.
	$query->set( 'posts_per_page', -1 );

	$tax_query = array( 'relation' => 'AND' );

	$termino = $es_busqueda ? trim( (string) get_search_query() ) : '';

	if ( '' !== $termino ) {
		$coincidencias = get_terms(
			array(
				'taxonomy'   => 'categoria_producto',
				'hide_empty' => false,
				'name__like' => $termino,
			)
		);

		if ( ! empty( $coincidencias ) && ! is_wp_error( $coincidencias ) ) {
			$exactas = array_filter(
				$coincidencias,
				function ( $categoria ) use ( $termino ) {
					return 0 === strcasecmp( $categoria->name, $termino );
				}
			);

			$elegidas    = ! empty( $exactas ) ? $exactas : $coincidencias;
			$tax_query[] = array(
				'taxonomy' => 'categoria_producto',
				'field'    => 'term_id',
				'terms'    => wp_list_pluck( $elegidas, 'term_id' ),
			);

			$query->set( 's', '' );
			$query->set( 'casa_a_busqueda', $termino );
		}
	}

	foreach ( casa_a_catalogo_filtros() as $parametro => $taxonomia ) {
		$valor = isset( $_GET[ $parametro ] ) ? sanitize_title( wp_unslash( $_GET[ $parametro ] ) ) : '';

		if ( '' !== $valor ) {
			$tax_query[] = array(
				'taxonomy' => $taxonomia,
				'field'    => 'slug',
				'terms'    => $valor,
			);
		}
	}

	if ( count( $tax_query ) > 1 ) {
		$query->set( 'tax_query', $tax_query );
	}

	// Sin stock solo se oculta si el producto lo marca explícitamente con '0'.
	if ( ! empty( $_GET['disponibles'] ) ) {
		$query->set(
			'meta_query',
			array(
				'relation' => 'OR',
				array(
					'key'     => 'casa_a_disponible',
					'value'   => '0',
					'compare' => '!=',
				),
				array(
					'key'     => 'casa_a_disponible',
					'compare' => 'NOT EXISTS',
				),
			)
		);
	}

	$query->set( 'posts_per_page', 24 );
	$query->set( 'orderby', 'title' );
	$query->set( 'order', 'ASC' );
}
add_action( 'pre_get_posts', 'casa_a_catalogo_aplicar_filtros' );

/**
 * La búsqueda de productos usa la misma plantilla que el catálogo.
 *
 * @param string $template Plantilla elegida por WordPress.
 * @return string
 */
function casa_a_catalogo_plantilla_busqueda( $template ) {
	if ( is_search() && 'producto' === get_query_var( 'post_type' ) ) {
		$catalogo = locate_template( 'archive-producto.php' );

		if ( $catalogo ) {
			return $catalogo;
		}
	}

	return $template;
}
add_filter( 'template_include', 'casa_a_catalogo_plantilla_busqueda' );

/**
 * URL del catálogo con un filtro cambiado. Si el valor ya está activo, lo quita.
 *
 * @param string $clave Parámetro: categoria, estilo, color, material o disponibles.
 * @param string $valor Valor del filtro.
 * @return string
 */
function casa_a_catalogo_url_filtro( $clave, $valor ) {
	$activos = array();

	foreach ( array_merge( array_keys( casa_a_catalogo_filtros() ), array( 'disponibles', 's' ) ) as $parametro ) {
		if ( ! empty( $_GET[ $parametro ] ) ) {
			$activos[ $parametro ] = sanitize_text_field( wp_unslash( $_GET[ $parametro ] ) );
		}
	}

	if ( isset( $activos[ $clave ] ) && $activos[ $clave ] === $valor ) {
		unset( $activos[ $clave ] );
	} else {
		$activos[ $clave ] = $valor;
	}

	return add_query_arg( $activos, get_post_type_archive_link( 'producto' ) );
}

/**
 * Indica si un filtro está activo en la URL.
 *
 * @param string $clave Parámetro.
 * @param string $valor Valor.
 * @return bool
 */
function casa_a_catalogo_filtro_activo( $clave, $valor ) {
	return isset( $_GET[ $clave ] ) && sanitize_text_field( wp_unslash( $_GET[ $clave ] ) ) === $valor;
}

/**
 * robots.txt: rastreo permitido para todo el sitio (incluidos buscadores de IA),
 * salvo el panel privado de galería y el área de administración. Indica el mapa del sitio.
 *
 * @param string $output Contenido por defecto de WordPress.
 * @return string
 */
function casa_a_robots_txt( $output ) {
	$reglas = array(
		'Disallow: /galeria/',
		'Disallow: /galeria-panel/',
		'Disallow: /wp-admin/',
		'Allow: /wp-admin/admin-ajax.php',
	);

	$agentes = array(
		'*',
		'Googlebot',
		'Bingbot',
		'GPTBot',
		'OAI-SearchBot',
		'ChatGPT-User',
		'ClaudeBot',
		'Claude-SearchBot',
		'Claude-User',
		'PerplexityBot',
		'Perplexity-User',
		'Google-Extended',
		'Applebot-Extended',
	);

	$lineas = array();

	foreach ( $agentes as $agente ) {
		$lineas[] = 'User-agent: ' . $agente;
		$lineas   = array_merge( $lineas, $reglas );
		$lineas[] = '';
	}

	$lineas[] = 'Sitemap: ' . home_url( '/wp-sitemap.xml' );

	return implode( "\n", $lineas ) . "\n";
}
add_filter( 'robots_txt', 'casa_a_robots_txt' );

/**
 * Ruta /robots.txt cuando WordPress no está instalado en la raíz del dominio.
 */
function casa_a_robots_reescritura() {
	add_rewrite_rule( '^robots\.txt$', 'index.php?casa_a_robots=1', 'top' );
}
add_action( 'init', 'casa_a_robots_reescritura' );

function casa_a_robots_variable( $vars ) {
	$vars[] = 'casa_a_robots';

	return $vars;
}
add_filter( 'query_vars', 'casa_a_robots_variable' );

function casa_a_robots_salida() {
	if ( ! get_query_var( 'casa_a_robots' ) ) {
		return;
	}

	header( 'Content-Type: text/plain; charset=utf-8' );
	echo apply_filters( 'robots_txt', '', true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit;
}
add_action( 'template_redirect', 'casa_a_robots_salida', 0 );


/**
 * Correos HTML con estilos en línea (los clientes de correo no leen hojas de estilo).
 * Colores y tipografía de la paleta de lacasaa.cl.
 */
function casa_a_correo_celda( $alinear = 'left' ) {
	return 'padding:10px 8px;border-bottom:1px solid #E9E9E9;text-align:' . $alinear . ';vertical-align:top;';
}

/**
 * Teléfono sin subrayado: Gmail lo marca como enlace, y un enlace con estilo propio lo evita.
 */
function casa_a_correo_telefono( $numero ) {
	$tel = preg_replace( '/[^0-9+]/', '', $numero );

	return '<a href="tel:' . esc_attr( $tel ) . '" style="color:#000000;text-decoration:none;">' . esc_html( $numero ) . '</a>';
}

function casa_a_correo_enlace( $email ) {
	return '<a href="mailto:' . esc_attr( $email ) . '" style="color:#000000;text-decoration:none;">' . esc_html( $email ) . '</a>';
}

function casa_a_correo_texto( $texto ) {
	if ( '' === (string) $texto ) {
		return '<p style="margin:0;font-size:13px;color:#8E8E8E;">—</p>';
	}

	return '<p style="margin:0;padding:14px;background:#E9E9E9;font-size:13px;line-height:1.6;">' . nl2br( esc_html( $texto ) ) . '</p>';
}

function casa_a_correo_seccion( $titulo, $html ) {
	return '<h2 style="margin:28px 0 12px;padding-bottom:6px;border-bottom:1px solid #000000;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;">' . esc_html( $titulo ) . '</h2>' . $html;
}

/**
 * Tabla etiqueta/valor. Los valores llegan ya escapados (esc_html o casa_a_correo_enlace).
 */
function casa_a_correo_datos( $pares ) {
	$filas = '';

	foreach ( $pares as $etiqueta => $valor ) {
		$filas .= '<tr>'
			. '<td style="' . casa_a_correo_celda() . 'width:36%;font-size:11px;letter-spacing:1px;text-transform:uppercase;color:#8E8E8E;">' . esc_html( $etiqueta ) . '</td>'
			. '<td style="' . casa_a_correo_celda() . 'font-size:14px;">' . $valor . '</td>'
			. '</tr>';
	}

	return '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">' . $filas . '</table>';
}

function casa_a_correo_plantilla( $etiqueta, $contenido ) {
	$fuente = "font-family:'Cascadia Code',ui-monospace,Menlo,Consolas,monospace;";

	return '<!doctype html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>'
		. '<body style="margin:0;padding:0;background:#E9E9E9;">'
		. '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#E9E9E9;padding:24px 12px;"><tr><td align="center">'
		. '<table role="presentation" width="600" cellspacing="0" cellpadding="0" style="width:100%;max-width:600px;background:#FFFFFF;color:#000000;' . $fuente . '">'
		. '<tr><td style="background:#000000;padding:22px 28px;">'
		. '<div style="font-size:20px;font-weight:700;letter-spacing:.5px;"><a href="https://lacasaa.cl" style="color:#FFFFFF;text-decoration:none;">lacasaa.cl</a></div>'
		. '<div style="color:#B0A08A;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;margin-top:6px;">' . esc_html( $etiqueta ) . '</div>'
		. '</td></tr>'
		. '<tr><td style="padding:12px 28px 8px;">' . $contenido . '</td></tr>'
		. '<tr><td style="padding:18px 28px 24px;font-size:11px;line-height:1.6;color:#000000;">Padre Orellana 1957, Santiago · hola@lacasaa.cl · ' . casa_a_correo_telefono( '+569 8510 3181' ) . '</td></tr>'
		. '</table></td></tr></table></body></html>';
}


/**
 * Ruta de la miniatura de un producto para incrustarla en el correo (vacío si no tiene foto).
 */
function casa_a_correo_miniatura( $id ) {
	$adjunto = get_post_thumbnail_id( $id );

	if ( ! $adjunto ) {
		return '';
	}

	$ruta  = get_attached_file( $adjunto );
	$meta  = wp_get_attachment_metadata( $adjunto );
	$mini  = ! empty( $meta['sizes']['thumbnail']['file'] ) ? dirname( $ruta ) . '/' . $meta['sizes']['thumbnail']['file'] : '';

	if ( $mini && is_readable( $mini ) ) {
		return $mini;
	}

	return ( $ruta && is_readable( $ruta ) ) ? $ruta : '';
}

/**
 * Incrusta las miniaturas de los productos en el correo que se está enviando.
 * Solo actúa mientras casa_a_cotizacion_procesar() define $GLOBALS['casa_a_correo_imagenes'].
 */
function casa_a_correo_incrustar_imagenes( $phpmailer ) {
	if ( empty( $GLOBALS['casa_a_correo_imagenes'] ) || ! is_array( $GLOBALS['casa_a_correo_imagenes'] ) ) {
		return;
	}

	foreach ( $GLOBALS['casa_a_correo_imagenes'] as $cid => $ruta ) {
		$phpmailer->addEmbeddedImage( $ruta, $cid, basename( $ruta ) );
	}
}
add_action( 'phpmailer_init', 'casa_a_correo_incrustar_imagenes' );

/**
 * Filtro del catálogo: botón + para desplegar las subcategorías de cada categoría principal.
 */
function casa_a_enqueue_filtro_categorias() {
	if ( ! is_post_type_archive( 'producto' ) && ! is_search() ) {
		return;
	}

	wp_enqueue_script( 'casa-a-filtro-categorias', get_template_directory_uri() . '/assets/js/filtro-categorias.js', array(), wp_get_theme()->get( 'Version' ), true );

	if ( is_post_type_archive( 'producto' ) ) {
		wp_enqueue_script( 'casa-a-subcategorias-paginacion', get_template_directory_uri() . '/assets/js/subcategorias-paginacion.js', array( 'casa-a-paginacion' ), wp_get_theme()->get( 'Version' ), true );
	}
}
add_action( 'wp_enqueue_scripts', 'casa_a_enqueue_filtro_categorias' );
