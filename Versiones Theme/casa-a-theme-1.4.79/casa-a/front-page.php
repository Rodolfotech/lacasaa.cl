<?php
/**
 * Portada del theme CASA A.
 *
 * @package CASA_A
 */

get_header();

// Diapositivas de la cabecera: imagen, titular y botón. Cada una enlaza a su sección.
$casa_a_diapositivas = array(
	array(
		'imagen'  => 'cabecera1.jpeg',
		'etiqueta' => __( 'Muebles', 'casa-a' ),
		'titulo'  => __( "Sofás & sillones
para tu set", 'casa-a' ),
		'titulo'  => __( "Sofás & sillones
para tu set", 'casa-a' ),
		'boton'   => __( 'Ver muebles', 'casa-a' ),
		'enlace'  => home_url( '/producto/?s=Sof%C3%A1s' ),
	),
	array(
		'imagen'  => 'cabecera2.jpeg',
		'etiqueta' => __( 'Decoración', 'casa-a' ),
		'titulo'  => __( "Objetos que
cuentan historias", 'casa-a' ),
		'boton'   => __( 'Ver decoración', 'casa-a' ),
		'enlace'  => home_url( '/producto/?s=Decoraci%C3%B3n' ),
		'acento'  => true,
	),
	array(
		'imagen'  => 'cabecera3.jpeg',
		'etiqueta' => __( 'Escenografía', 'casa-a' ),
		'titulo'  => __( "Fondos, pisos
& paneles", 'casa-a' ),
		'boton'   => __( 'Ver escenografía', 'casa-a' ),
		'enlace'  => home_url( '/producto/?s=Escenograf%C3%ADa' ),
	),
);
?>
<main>
	<section class="casa-a-slider" aria-roledescription="<?php esc_attr_e( 'carrusel', 'casa-a' ); ?>" aria-label="<?php esc_attr_e( 'Destacados', 'casa-a' ); ?>">
		<?php foreach ( $casa_a_diapositivas as $indice => $diapositiva ) : ?>
			<div class="casa-a-slide<?php echo 0 === $indice ? ' is-active' : ''; ?>" aria-hidden="<?php echo 0 === $indice ? 'false' : 'true'; ?>">
				<img class="casa-a-slide-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/' . $diapositiva['imagen'] . '?v=' . ( (int) @filemtime( get_template_directory() . '/assets/img/' . $diapositiva['imagen'] ) ) ); ?>" alt="" <?php echo 0 === $indice ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
				<div class="casa-a-slide-texto">
					<?php if ( ! empty( $diapositiva['etiqueta'] ) ) : ?>
						<p class="casa-a-slide-etiqueta"><?php echo esc_html( $diapositiva['etiqueta'] ); ?></p>
					<?php endif; ?>
					<?php if ( 0 === $indice ) : ?>
						<h1><?php echo nl2br( esc_html( $diapositiva['titulo'] ) ); ?></h1>
					<?php else : ?>
						<h2><?php echo nl2br( esc_html( $diapositiva['titulo'] ) ); ?></h2>
					<?php endif; ?>
					<a class="casa-a-slide-boton<?php echo ! empty( $diapositiva['acento'] ) ? ' is-acento' : ''; ?>" href="<?php echo esc_url( $diapositiva['enlace'] ); ?>" <?php echo 0 === $indice ? '' : 'tabindex="-1"'; ?>>
						<?php echo esc_html( $diapositiva['boton'] ); ?>
						<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
					</a>
				</div>
			</div>
		<?php endforeach; ?>

		<div class="casa-a-slider-puntos" role="tablist" aria-label="<?php esc_attr_e( 'Elegir diapositiva', 'casa-a' ); ?>">
			<?php foreach ( $casa_a_diapositivas as $indice => $diapositiva ) : ?>
				<button type="button" role="tab" class="casa-a-slider-punto<?php echo 0 === $indice ? ' is-active' : ''; ?>" aria-selected="<?php echo 0 === $indice ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Diapositiva %d', 'casa-a' ), $indice + 1 ) ); ?>" data-slide="<?php echo esc_attr( $indice ); ?>"></button>
			<?php endforeach; ?>
		</div>
	</section>

</main>
<?php
get_footer();
