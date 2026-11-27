<?php
/**
 * Panel "Mi selección": lista de productos, pestaña de proyectos y formulario de cotización.
 *
 * Se abre desde el enlace "Mi selección" del nav. El contenido de la lista lo dibuja
 * assets/js/seleccion.js a partir de lo guardado en el navegador.
 *
 * @package CASA_A
 */

$casa_a_hoy = gmdate( 'Y-m-d' );
?>
<div class="casa-a-drawer-fondo" data-seleccion-cerrar hidden></div>

<aside class="casa-a-drawer" role="dialog" aria-modal="true" aria-labelledby="casa-a-drawer-titulo" aria-hidden="true" hidden>
	<header class="casa-a-drawer-cabecera">
		<div>
			<h2 id="casa-a-drawer-titulo" class="casa-a-drawer-titulo"><?php esc_html_e( 'Mi reserva', 'casa-a' ); ?></h2>
			<p class="casa-a-drawer-resumen" data-seleccion-resumen></p>
		</div>
		<button type="button" class="casa-a-drawer-cerrar" data-seleccion-cerrar aria-label="<?php esc_attr_e( 'Cerrar', 'casa-a' ); ?>">
			<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
		</button>
	</header>

	<section class="casa-a-drawer-panel" data-panel="productos">
		<ul class="casa-a-drawer-lista" data-seleccion-lista></ul>
		<div class="casa-a-paginacion" data-seleccion-paginacion hidden></div>
		<div class="casa-a-drawer-pie">
			<button type="button" class="casa-a-boton-enviar" data-seleccion-continuar data-url="<?php echo esc_url( home_url( '/mi-reserva/' ) ); ?>" disabled><?php esc_html_e( 'Solicitar cotización', 'casa-a' ); ?></button>
		</div>
</aside>
