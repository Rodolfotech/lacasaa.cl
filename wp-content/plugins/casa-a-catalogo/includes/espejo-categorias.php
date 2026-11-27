<?php
/**
 * Espejo de categorías: las categorías creadas en el panel de galería (jg_gallery_category)
 * se reflejan en el catálogo (categoria_producto). Al crear, editar o eliminar una categoría o
 * subcategoría en el panel, el catálogo se actualiza solo.
 *
 * Vínculo: meta _casa_a_espejo en la categoría de galería (id del catálogo) y
 * _casa_a_origen en la del catálogo (id de la galería). El menú y el filtro del theme
 * muestran solo las categorías que tienen _casa_a_origen.
 *
 * @package CASA_A
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'CASA_A_GALERIA_TAXONOMY' ) ) {
	define( 'CASA_A_GALERIA_TAXONOMY', 'jg_gallery_category' );
}

/**
 * Busca una categoría del catálogo por nombre dentro de un padre (0 = principal).
 */
function casa_a_espejo_buscar( $nombre, $padre ) {
	$nombre = strtolower( wp_specialchars_decode( $nombre, ENT_QUOTES ) );
	$terms  = get_terms(
		array(
			'taxonomy'   => 'categoria_producto',
			'hide_empty' => false,
			'parent'     => (int) $padre,
		)
	);

	if ( is_wp_error( $terms ) ) {
		return 0;
	}

	foreach ( $terms as $term ) {
		if ( strtolower( wp_specialchars_decode( $term->name, ENT_QUOTES ) ) === $nombre ) {
			return (int) $term->term_id;
		}
	}

	return 0;
}

/**
 * Asegura el espejo de una categoría de galería y devuelve su id en el catálogo.
 */
function casa_a_espejo_asegurar( $termino ) {
	$padre_espejo = 0;

	if ( $termino->parent ) {
		$padre = get_term( $termino->parent, CASA_A_GALERIA_TAXONOMY );

		if ( $padre instanceof WP_Term ) {
			$padre_espejo = casa_a_espejo_asegurar( $padre );
		}
	}

	$nombre   = wp_specialchars_decode( $termino->name, ENT_QUOTES );
	$id       = (int) get_term_meta( $termino->term_id, '_casa_a_espejo', true );
	$existe   = $id && get_term( $id, 'categoria_producto' ) instanceof WP_Term;

	if ( ! $existe ) {
		$id = casa_a_espejo_buscar( $nombre, $padre_espejo );
	}

	if ( $id ) {
		wp_update_term( $id, 'categoria_producto', array( 'name' => $nombre, 'parent' => $padre_espejo ) );
	} else {
		$nuevo = wp_insert_term( $nombre, 'categoria_producto', array( 'parent' => $padre_espejo ) );

		if ( is_wp_error( $nuevo ) ) {
			return 0;
		}

		$id = (int) $nuevo['term_id'];
	}

	update_term_meta( $termino->term_id, '_casa_a_espejo', $id );
	update_term_meta( $id, '_casa_a_origen', (int) $termino->term_id );

	return $id;
}

/**
 * Sincroniza todo: borra espejos de categorías de galería que ya no existen y asegura el resto.
 * Las categorías del catálogo que no vienen del panel no se tocan (no se muestran en el sitio).
 */
function casa_a_espejo_sincronizar_todo() {
	$huerfanos = get_terms(
		array(
			'taxonomy'   => 'categoria_producto',
			'hide_empty' => false,
			'meta_query' => array(
				array(
					'key'     => '_casa_a_origen',
					'compare' => 'EXISTS',
				),
			),
		)
	);

	if ( ! is_wp_error( $huerfanos ) ) {
		foreach ( $huerfanos as $espejo ) {
			$origen = (int) get_term_meta( $espejo->term_id, '_casa_a_origen', true );

			if ( ! $origen || ! get_term( $origen, CASA_A_GALERIA_TAXONOMY ) instanceof WP_Term ) {
				wp_delete_term( $espejo->term_id, 'categoria_producto' );
			}
		}
	}

	$galeria = get_terms( array( 'taxonomy' => CASA_A_GALERIA_TAXONOMY, 'hide_empty' => false ) );

	if ( is_wp_error( $galeria ) ) {
		return;
	}

	// Principales primero, para que las subcategorías encuentren a su padre.
	usort(
		$galeria,
		function ( $a, $b ) {
			return (int) $a->parent - (int) $b->parent;
		}
	);

	foreach ( $galeria as $termino ) {
		casa_a_espejo_asegurar( $termino );
	}
}

/**
 * Categorías del catálogo que vienen del panel (las que se muestran en el menú y en el filtro).
 *
 * @return WP_Term[]
 */
function casa_a_categorias_del_plugin() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'categoria_producto',
			'hide_empty' => false,
			'meta_query' => array(
				array(
					'key'     => '_casa_a_origen',
					'compare' => 'EXISTS',
				),
			),
		)
	);

	return is_wp_error( $terms ) ? array() : $terms;
}

add_action( 'created_' . CASA_A_GALERIA_TAXONOMY, 'casa_a_espejo_sincronizar_todo' );
add_action( 'edited_' . CASA_A_GALERIA_TAXONOMY, 'casa_a_espejo_sincronizar_todo' );
add_action(
	'deleted_term',
	function ( $term, $tt_id, $taxonomy ) {
		if ( CASA_A_GALERIA_TAXONOMY === $taxonomy ) {
			casa_a_espejo_sincronizar_todo();
		}
	},
	10,
	3
);
