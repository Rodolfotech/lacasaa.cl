<?php
/**
 * Catálogo de productos: filtros a la izquierda y grilla de productos con "Agregar".
 * También sirve para los resultados de búsqueda de productos.
 *
 * @package CASA_A
 */

/**
 * Filtro de categorías agrupado como el menú: principal y, debajo, sus subcategorías con productos.
 */
if ( ! function_exists( 'casa_a_filtro_categorias_agrupadas' ) ) {
	function casa_a_filtro_categorias_agrupadas() {
		// Todas las categorías creadas en el plugin (también las vacías), agrupadas por principal.
		$todas = function_exists( 'casa_a_categorias_del_plugin' ) ? casa_a_categorias_del_plugin() : array();

		if ( empty( $todas ) ) {
			return;
		}

		$principales = array_values(
			array_filter(
				$todas,
				function ( $t ) {
					return 0 === (int) $t->parent;
				}
			)
		);

		usort(
			$principales,
			function ( $a, $b ) {
				return strcasecmp( wp_specialchars_decode( $a->name, ENT_QUOTES ), wp_specialchars_decode( $b->name, ENT_QUOTES ) );
			}
		);

		foreach ( $principales as $principal ) {
			$items = array_values(
				array_filter(
					$todas,
					function ( $t ) use ( $principal ) {
						return (int) $t->parent === (int) $principal->term_id;
					}
				)
			);

			usort(
				$items,
				function ( $a, $b ) {
					return strcasecmp( wp_specialchars_decode( $a->name, ENT_QUOTES ), wp_specialchars_decode( $b->name, ENT_QUOTES ) );
				}
			);

			// Sin subcategorías, la principal es el único filtro del grupo.
			if ( empty( $items ) ) {
				$items = array( $principal );
			}

			$abre = false;
			foreach ( $items as $item_chk ) {
				if ( casa_a_catalogo_filtro_activo( 'categoria', $item_chk->slug ) ) {
					$abre = true;
				}
			}

			echo '<section class="casa-a-filtro-grupo">';
			echo '<h2 class="casa-a-filtro-titulo">';
			echo '<button type="button" class="casa-a-filtro-toggle" aria-expanded="' . ( $abre ? 'true' : 'false' ) . '" aria-label="' . esc_attr( sprintf( __( 'Mostrar subcategorías de %s', 'casa-a' ), wp_specialchars_decode( $principal->name, ENT_QUOTES ) ) ) . '">' . ( $abre ? '&minus;' : '+' ) . '</button>';
			echo '<span>' . esc_html( wp_specialchars_decode( $principal->name, ENT_QUOTES ) ) . '</span>';
			echo '</h2>';
			echo '<div class="casa-a-chips"' . ( $abre ? '' : ' hidden' ) . '>';

			foreach ( $items as $item ) {
				$clase = casa_a_catalogo_filtro_activo( 'categoria', $item->slug ) ? ' is-active' : '';
				echo '<a class="casa-a-chip' . esc_attr( $clase ) . '" href="' . esc_url( casa_a_catalogo_url_filtro( 'categoria', $item->slug ) ) . '">';
				echo esc_html( wp_specialchars_decode( $item->name, ENT_QUOTES ) );
				echo '</a>';
			}

			echo '</div></section>';
		}
	}
}

get_header();

$casa_a_es_busqueda = is_search();
$casa_a_termino     = (string) get_query_var( 'casa_a_busqueda' ) ? get_query_var( 'casa_a_busqueda' ) : get_search_query();
$casa_a_termino     = (string) get_query_var( 'casa_a_busqueda' ) ? get_query_var( 'casa_a_busqueda' ) : get_search_query();
$casa_a_total       = (int) $GLOBALS['wp_query']->found_posts;

$casa_a_grupos = array(
	'categoria' => array( __( 'Categoría', 'casa-a' ), 'categoria_producto' ),
	'estilo'    => array( __( 'Estilo', 'casa-a' ), 'estilo_producto' ),
	'color'     => array( __( 'Color', 'casa-a' ), 'color_producto' ),
	'material'  => array( __( 'Material', 'casa-a' ), 'material_producto' ),
);
?>
<main class="casa-a-main casa-a-catalogo-pagina">
	<div class="casa-a-wrap">

		<header class="casa-a-catalogo-cabecera">
			<div>
				<?php if ( $casa_a_es_busqueda ) : ?>
					<h1 class="casa-a-catalogo-titulo"><?php echo esc_html( sprintf( __( 'Resultados para «%s»', 'casa-a' ), $casa_a_termino ) ); ?></h1>
					<h1 class="casa-a-catalogo-titulo"><?php echo esc_html( sprintf( __( 'Resultados para «%s»', 'casa-a' ), $casa_a_termino ) ); ?></h1>
				<?php else : ?>
				<?php endif; ?>
			</div>
		</header>

		<div class="casa-a-catalogo-layout">

			<aside class="casa-a-filtros" aria-label="<?php esc_attr_e( 'Filtros del catálogo', 'casa-a' ); ?>">
				<?php
				foreach ( $casa_a_grupos as $parametro => $grupo ) {
					if ( 'categoria' === $parametro ) {
						casa_a_filtro_categorias_agrupadas();
						continue;
					}

					$terminos = get_terms(
						array(
							'taxonomy'   => $grupo[1],
							'hide_empty' => false,
						)
					);

					if ( empty( $terminos ) || is_wp_error( $terminos ) ) {
						continue;
					}

					// Solo categorías finales: los grupos (como Alfombras o Muebles) no son filtros.
					$padres = array_map( 'intval', wp_list_pluck( $terminos, 'parent' ) );
					$terminos = array_values(
						array_filter(
							$terminos,
							function ( $termino ) use ( $padres ) {
								return ! in_array( (int) $termino->term_id, $padres, true );
							}
						)
					);

					if ( empty( $terminos ) ) {
						continue;
					}
					?>
					<section class="casa-a-filtro-grupo">
						<h2 class="casa-a-filtro-titulo"><?php echo esc_html( $grupo[0] ); ?></h2>
						<div class="casa-a-chips">
							<?php foreach ( $terminos as $termino ) : ?>
								<a class="casa-a-chip <?php echo casa_a_catalogo_filtro_activo( $parametro, $termino->slug ) ? 'is-active' : ''; ?>" href="<?php echo esc_url( casa_a_catalogo_url_filtro( $parametro, $termino->slug ) ); ?>"><?php echo esc_html( wp_specialchars_decode( $termino->name, ENT_QUOTES ) ); ?></a>
							<?php endforeach; ?>
						</div>
					</section>
					<?php
				}
				?>
			</aside>

			<section class="casa-a-catalogo-resultados">
				<?php
				if ( ! function_exists( 'casa_a_tarjeta_catalogo' ) ) {
					/**
					 * Tarjeta de producto del catálogo (la foto abre el modal de producto).
					 */
					function casa_a_tarjeta_catalogo( $casa_a_p ) {
						$casa_a_id         = $casa_a_p->ID;
						$casa_a_codigo     = get_post_meta( $casa_a_id, 'casa_a_codigo', true );
						$casa_a_codigo     = $casa_a_codigo ? $casa_a_codigo : 'CA-' . str_pad( (string) $casa_a_id, 4, '0', STR_PAD_LEFT );
						$casa_a_precio     = get_post_meta( $casa_a_id, 'casa_a_precio_dia', true );
						$casa_a_disponible = '0' !== get_post_meta( $casa_a_id, 'casa_a_disponible', true );
						?>
						<article class="casa-a-producto">
							<div class="casa-a-producto-imagen">
								<button type="button" class="casa-a-producto-abrir" data-modal-producto="<?php echo esc_attr( function_exists( 'casa_a_producto_datos_modal' ) ? wp_json_encode( casa_a_producto_datos_modal( $casa_a_id ) ) : '' ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Ver %s', 'casa-a' ), get_the_title( $casa_a_p ) ) ); ?>">
									<?php
									if ( has_post_thumbnail( $casa_a_p ) ) {
										echo get_the_post_thumbnail( $casa_a_p, 'medium_large', array( 'loading' => 'lazy' ) );
									}
									?>
								</button>
								<?php if ( ! $casa_a_disponible ) : ?>
									<span class="casa-a-sin-stock"><?php esc_html_e( 'No disponible', 'casa-a' ); ?></span>
								<?php endif; ?>
							</div>
							<div class="casa-a-producto-info">
								<p class="casa-a-producto-codigo"><?php echo esc_html( $casa_a_codigo ); ?></p>
								<div class="casa-a-producto-fila">
									<h3 class="casa-a-producto-nombre"><a href="<?php echo esc_url( get_permalink( $casa_a_p ) ); ?>" title="<?php echo esc_attr( get_the_title( $casa_a_p ) ); ?>"><?php echo esc_html( get_the_title( $casa_a_p ) ); ?></a></h3>
								</div>
								<?php if ( '' !== (string) $casa_a_precio ) : ?>
									<p class="casa-a-producto-precio">
										<?php echo esc_html( '$' . number_format( (int) $casa_a_precio, 0, ',', '.' ) ); ?>
										<span><?php esc_html_e( '/ día', 'casa-a' ); ?></span>
									</p>
								<?php endif; ?>
							</div>
						</article>
						<?php
					}
				}

				if ( have_posts() ) :
					// Agrupar: categoría principal > subcategoría. Sin categoría: "Otros".
					$casa_a_grupos = array();

					foreach ( $GLOBALS['wp_query']->posts as $casa_a_post ) {
						$casa_a_principal = __( 'Otros', 'casa-a' );
						$casa_a_sub       = '';
						$casa_a_terms     = get_the_terms( $casa_a_post->ID, 'categoria_producto' );

						if ( $casa_a_terms && ! is_wp_error( $casa_a_terms ) ) {
							$casa_a_elegido = $casa_a_terms[0];
							foreach ( $casa_a_terms as $casa_a_t ) {
								if ( $casa_a_t->parent ) {
									$casa_a_elegido = $casa_a_t;
									break;
								}
							}

							if ( $casa_a_elegido->parent ) {
								$casa_a_padre     = get_term( $casa_a_elegido->parent, 'categoria_producto' );
								$casa_a_principal = ( $casa_a_padre && ! is_wp_error( $casa_a_padre ) ) ? wp_specialchars_decode( $casa_a_padre->name, ENT_QUOTES ) : __( 'Otros', 'casa-a' );
								$casa_a_sub       = wp_specialchars_decode( $casa_a_elegido->name, ENT_QUOTES );
							} else {
								$casa_a_principal = wp_specialchars_decode( $casa_a_elegido->name, ENT_QUOTES );
							}
						}

						$casa_a_grupos[ $casa_a_principal ][ $casa_a_sub ][] = $casa_a_post;
					}

					ksort( $casa_a_grupos, SORT_NATURAL | SORT_FLAG_CASE );

					foreach ( $casa_a_grupos as $casa_a_nombre_principal => $casa_a_subs ) {
						ksort( $casa_a_subs, SORT_NATURAL | SORT_FLAG_CASE );
						?>
						<div class="casa-a-catalogo-grupo">
							<h2 class="casa-a-grupo-titulo"><?php echo esc_html( $casa_a_nombre_principal ); ?></h2>
							<?php
							foreach ( $casa_a_subs as $casa_a_nombre_sub => $casa_a_posts ) {
								if ( '' !== $casa_a_nombre_sub ) {
									?>
									<h3 class="casa-a-subgrupo-titulo"><?php echo esc_html( $casa_a_nombre_sub ); ?></h3>
									<?php
								}
								?>
								<div class="casa-a-productos">
									<?php
									foreach ( $casa_a_posts as $casa_a_post_item ) {
										casa_a_tarjeta_catalogo( $casa_a_post_item );
									}
									?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					}

					wp_reset_postdata();
					?>
					<?php the_posts_pagination(); ?>
				<?php else : ?>
					<p class="casa-a-muted"><?php esc_html_e( 'No encontramos productos con esos filtros.', 'casa-a' ); ?></p>
				<?php endif; ?>
			</section>

		</div>
	</div>
</main>
<?php
get_footer();
