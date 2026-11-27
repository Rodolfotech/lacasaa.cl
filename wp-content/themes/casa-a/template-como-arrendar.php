<?php
/**
 * Template Name: Cómo arrendar
 *
 * Pasos del arriendo en línea vertical y políticas, en acordeón. Usa esta plantilla en la página con slug "como-arrendar".
 *
 * @package CASA_A
 */

get_header();

$casa_a_pasos = array(
	array(
		'numero' => '1',
		'titulo' => __( 'Elige tus favoritos', 'casa-a' ),
		'texto'  => __( 'Explora nuestro catálogo y selecciona los muebles y objetos que necesitas para tu producción, sesión de fotos, comercial, película o evento. Agrégalos a tu selección.', 'casa-a' ),
	),
	array(
		'numero' => '2',
		'titulo' => __( 'Envía tu solicitud', 'casa-a' ),
		'texto'  => __( 'Una vez que tengas tu selección lista, dirígete a la sección RESERVA. Allí podrás revisar los productos elegidos y completar los datos de tu solicitud de arriendo.', 'casa-a' ),
	),
	array(
		'numero' => '3',
		'titulo' => __( 'Confirma tu arriendo', 'casa-a' ),
		'texto'  => __( 'Recibiremos tu solicitud y nos pondremos en contacto contigo para confirmar disponibilidad, fechas y detalles de entrega. ¡Así de fácil!', 'casa-a' ),
	),
);

$casa_a_politicas = array(
	array( __( 'Garantía', 'casa-a' ), __( 'Texto por completar: monto y condiciones de la garantía.', 'casa-a' ) ),
	array( __( 'Plazos', 'casa-a' ), __( 'Texto por completar: plazos de arriendo y extensiones.', 'casa-a' ) ),
	array( __( 'Daños', 'casa-a' ), __( 'Texto por completar: qué ocurre si un producto se daña o pierde.', 'casa-a' ) ),
	array( __( 'Retiro y devolución', 'casa-a' ), __( 'Retiro y devolución en nuestra bodega dentro del horario de atención. Consulta por despacho a set.', 'casa-a' ) ),
);
?>
<main class="casa-a-main casa-a-arrendar">
	<div class="casa-a-wrap">
		<header class="casa-a-galeria-cabecera">
			<p class="casa-a-etiqueta"><?php esc_html_e( 'Paso a paso', 'casa-a' ); ?></p>
			<h1 class="casa-a-catalogo-titulo"><?php esc_html_e( 'Cómo arrendar', 'casa-a' ); ?></h1>
		</header>

		<ol class="casa-a-linea">
			<?php foreach ( $casa_a_pasos as $paso ) : ?>
				<li class="casa-a-linea-paso">
					<span class="casa-a-linea-numero" aria-hidden="true"><?php echo esc_html( $paso['numero'] ); ?></span>
					<div class="casa-a-linea-tarjeta">
						<h2 class="casa-a-linea-titulo"><?php echo esc_html( $paso['titulo'] ); ?></h2>
						<p class="casa-a-linea-texto"><?php echo esc_html( $paso['texto'] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>

		<a class="casa-a-button casa-a-arrendar-boton" href="<?php echo esc_url( home_url( '/producto/' ) ); ?>"><?php esc_html_e( 'Ir al catálogo', 'casa-a' ); ?></a>

		<section class="casa-a-politicas" aria-labelledby="casa-a-politicas-titulo">
			<h2 id="casa-a-politicas-titulo" class="casa-a-politicas-titulo"><?php esc_html_e( 'Políticas de arriendo', 'casa-a' ); ?></h2>
			<?php foreach ( $casa_a_politicas as $indice => $politica ) : ?>
				<details class="casa-a-politica"<?php echo 3 === $indice ? ' open' : ''; ?>>
					<summary><?php echo esc_html( $politica[0] ); ?></summary>
					<p><?php echo esc_html( $politica[1] ); ?></p>
				</details>
			<?php endforeach; ?>
		</section>
	</div>
</main>
<?php
get_footer();
