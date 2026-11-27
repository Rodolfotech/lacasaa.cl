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

		// Sin subcategorías, la principal se muestra una sola vez como enlace (no como subcategoría).
		$casa_a_menu_grupos[ wp_specialchars_decode( $casa_a_principal->name, ENT_QUOTES ) ] = array(
			'principal' => $casa_a_principal,
			'subs'      => $casa_a_subs,
		);
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
	</div>

	<nav class="casa-a-menu-lista" aria-label="<?php esc_attr_e( 'Categorías', 'casa-a' ); ?>">
		<a class="casa-a-menu-ver-todo" href="<?php echo esc_url( home_url( '/producto/' ) ); ?>"><?php esc_html_e( 'Ver todo', 'casa-a' ); ?></a>

		<?php foreach ( $casa_a_menu_grupos as $casa_a_grupo => $casa_a_datos ) : ?>
			<?php if ( $casa_a_datos['subs'] ) : ?>
				<div class="casa-a-menu-grupo" data-menu-grupo>
					<button type="button" class="casa-a-menu-grupo-titulo" data-menu-abrir aria-expanded="false">
						<span><?php echo esc_html( $casa_a_grupo ); ?></span>
						<span class="casa-a-menu-flecha" aria-hidden="true">&rsaquo;</span>
					</button>
					<div class="casa-a-menu-subs" data-menu-subs hidden>
						<button type="button" class="casa-a-menu-volver" data-menu-volver><span aria-hidden="true">&lsaquo;</span> <?php echo esc_html( $casa_a_grupo ); ?></button>
						<?php foreach ( $casa_a_datos['subs'] as $casa_a_term ) : ?>
							<a href="<?php echo esc_url( add_query_arg( 'categoria', $casa_a_term->slug, home_url( '/producto/' ) ) ); ?>"><?php echo esc_html( wp_specialchars_decode( $casa_a_term->name, ENT_QUOTES ) ); ?></a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php else : ?>
				<div class="casa-a-menu-grupo">
					<a class="casa-a-menu-grupo-titulo" href="<?php echo esc_url( add_query_arg( 'categoria', $casa_a_datos['principal']->slug, home_url( '/producto/' ) ) ); ?>"><?php echo esc_html( $casa_a_grupo ); ?></a>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>

	</nav>
</aside>
