<?php
/**
 * Menú lateral del nav: "Ver todo", grupos de categorías con sus subcategorías y accesos principales.
 * Se abre desde el botón de hamburguesa de template-parts/nav.php.
 *
 * Cada subcategoría enlaza al catálogo filtrado por esa categoría. Si la categoría no existe en la
 * base de datos, el enlace abre la búsqueda por su nombre. Las categorías ocultas no se listan.
 *
 * @package CASA_A
 */

// Grupos del menú: cada categoría principal del plugin con sus subcategorías (todas, también las vacías).
$casa_a_menu_grupos = array();

if ( function_exists( 'casa_a_categorias_del_plugin' ) ) {
	$casa_a_todas = casa_a_categorias_del_plugin();

	$casa_a_principales = array_values(
		array_filter(
			$casa_a_todas,
			function ( $t ) {
				return 0 === (int) $t->parent;
			}
		)
	);

	usort(
		$casa_a_principales,
		function ( $a, $b ) {
			return strcasecmp( wp_specialchars_decode( $a->name, ENT_QUOTES ), wp_specialchars_decode( $b->name, ENT_QUOTES ) );
		}
	);

	foreach ( $casa_a_principales as $casa_a_principal ) {
		$casa_a_subs = array_values(
			array_filter(
				$casa_a_todas,
				function ( $t ) use ( $casa_a_principal ) {
					return (int) $t->parent === (int) $casa_a_principal->term_id;
				}
			)
		);

		usort(
			$casa_a_subs,
			function ( $a, $b ) {
				return strcasecmp( wp_specialchars_decode( $a->name, ENT_QUOTES ), wp_specialchars_decode( $b->name, ENT_QUOTES ) );
			}
		);

		// Sin subcategorías, la principal es el único enlace del grupo.
		$casa_a_menu_grupos[ wp_specialchars_decode( $casa_a_principal->name, ENT_QUOTES ) ] = $casa_a_subs ? $casa_a_subs : array( $casa_a_principal );
	}
}

/**
 * Enlace de una categoría: su filtro si existe en la base de datos, o la búsqueda por nombre.
 *
 * @param string $nombre Nombre tal como se muestra en el menú.
 * @return string
 */
function casa_a_menu_enlace_categoria( $nombre ) {
	foreach ( get_terms( array( 'taxonomy' => 'categoria_producto', 'hide_empty' => false ) ) as $termino ) {
		if ( 0 === strcasecmp( wp_specialchars_decode( $termino->name, ENT_QUOTES ), $nombre ) ) {
			return add_query_arg( 'categoria', $termino->slug, home_url( '/producto/' ) );
		}
	}

	return add_query_arg( 's', $nombre, home_url( '/producto/' ) );
}
?>
<div class="casa-a-menu-fondo" data-menu-cerrar hidden></div>

<aside id="casa-a-menu-lateral" class="casa-a-menu-lateral" aria-label="<?php esc_attr_e( 'Menú', 'casa-a' ); ?>" hidden>
	<div class="casa-a-menu-cabecera">
		<button type="button" class="casa-a-menu-cerrar" data-menu-cerrar aria-label="<?php esc_attr_e( 'Cerrar menú', 'casa-a' ); ?>">
			<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
		</button>
		<span class="casa-a-menu-titulo"><?php esc_html_e( 'Muebles', 'casa-a' ); ?></span>
	</div>

	<nav class="casa-a-menu-lista" aria-label="<?php esc_attr_e( 'Categorías', 'casa-a' ); ?>">
		<a class="casa-a-menu-ver-todo" href="<?php echo esc_url( home_url( '/producto/' ) ); ?>"><?php esc_html_e( 'Ver todo', 'casa-a' ); ?></a>

		<?php foreach ( $casa_a_menu_grupos as $casa_a_grupo => $casa_a_subcategorias ) : ?>
			<div class="casa-a-menu-grupo">
				<h2 class="casa-a-menu-grupo-titulo"><?php echo esc_html( $casa_a_grupo ); ?></h2>
				<?php foreach ( $casa_a_subcategorias as $casa_a_term ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 'categoria', $casa_a_term->slug, home_url( '/producto/' ) ) ); ?>"><?php echo esc_html( wp_specialchars_decode( $casa_a_term->name, ENT_QUOTES ) ); ?></a>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>

		<span class="casa-a-menu-separador" aria-hidden="true"></span>

		<a href="<?php echo esc_url( home_url( '/en-accion/' ) ); ?>"><?php esc_html_e( 'Galería', 'casa-a' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/casa-a/' ) ); ?>"><?php esc_html_e( 'Quiénes somos', 'casa-a' ); ?></a>
	</nav>
</aside>
