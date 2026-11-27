<?php
/**
 * Componente de navegación reutilizable: menú hamburguesa, logo, buscador de productos,
 * enlace de contacto y "Mi selección".
 *
 * Uso en cualquier plantilla: get_template_part( 'template-parts/nav' );
 * Las categorías y accesos principales están en el menú lateral (template-parts/menu-lateral.php).
 *
 * @package CASA_A
 */

// Pendiente: conectar con la selección real del usuario. El contador lo actualiza seleccion.js.
$casa_a_seleccion = 0;
?>
<div class="casa-a-wrap casa-a-nav">
	<div class="casa-a-nav-izq">
		<button type="button" class="casa-a-menu-toggle" aria-controls="casa-a-menu-lateral" aria-expanded="false" aria-label="<?php esc_attr_e( 'Abrir menú', 'casa-a' ); ?>">
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
		</button>

		<a class="casa-a-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="lacasaa.cl">
			<img class="casa-a-logo-img" src="<?php echo esc_url( casa_a_logo_url() ); ?>" alt="lacasaa.cl" width="auto" height="auto">
		</a>
	</div>

		<form class="casa-a-buscador" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="hidden" name="post_type" value="producto">
			<label class="screen-reader-text" for="casa-a-buscar"><?php esc_html_e( 'Buscar producto', 'casa-a' ); ?></label>
			<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
			<input type="search" id="casa-a-buscar" name="s" placeholder="<?php esc_attr_e( 'Buscar', 'casa-a' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
			<div class="casa-a-sugerencias" data-sugerencias data-endpoint="<?php echo esc_url( rest_url( 'casa-a/v1/sugerencias' ) ); ?>" hidden></div>
		</form>
	<div class="casa-a-nav-der">
		<a class="casa-a-nav-enlace" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"><?php esc_html_e( 'Contacto', 'casa-a' ); ?></a>

		<a class="casa-a-seleccion" href="#" aria-label="<?php echo esc_attr( sprintf( __( 'Mi reserva: %d', 'casa-a' ), $casa_a_seleccion ) ); ?>">
			<span class="casa-a-seleccion-texto"><?php esc_html_e( 'Mi reserva', 'casa-a' ); ?></span>
			<span class="casa-a-seleccion-contador"><?php echo esc_html( $casa_a_seleccion ); ?></span>
		</a>
	</div>
</div>
