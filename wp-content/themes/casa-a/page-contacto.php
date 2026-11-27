<?php
/**
 * Plantilla de la página Contacto: datos de contacto, mapa y formulario de mensaje.
 *
 * @package CASA_A
 */

get_header();

// Datos de contacto. Mismos valores que el footer: cambiarlos aquí y en template-parts/footer.php.
$casa_a_direccion = 'Padre Orellana 1957, Santiago';
$casa_a_telefono  = '+569 8510 3181';
$casa_a_correo    = 'hola@lacasaa.cl';
$casa_a_horario   = 'Lunes a viernes 9:30 - 17hrs';
$casa_a_respuesta = '24 horas hábiles';

$estado = isset( $_GET['casa_a_estado'] ) ? sanitize_key( wp_unslash( $_GET['casa_a_estado'] ) ) : '';
$avisos = array(
	'ok'      => array( 'casa-a-aviso-ok', __( 'Gracias. Recibimos tu mensaje y te responderemos pronto.', 'casa-a' ) ),
	'error'   => array( 'casa-a-aviso-error', __( 'Revisa los campos obligatorios e intenta de nuevo.', 'casa-a' ) ),
	'archivo' => array( 'casa-a-aviso-error', __( 'El archivo no se pudo subir. Usa JPG, PNG o PDF.', 'casa-a' ) ),
	'fallo'   => array( 'casa-a-aviso-error', __( 'No pudimos enviar el mensaje. Intenta más tarde o escríbenos directamente.', 'casa-a' ) ),
);
?>
<main class="casa-a-main casa-a-contacto">
	<div class="casa-a-wrap">
		<?php
		while ( have_posts() ) {
			the_post();
			if ( '' !== trim( get_the_content() ) ) {
				?>
				<div class="casa-a-content casa-a-contacto-intro"><?php the_content(); ?></div>
				<?php
			}
		}
		?>

		<header class="casa-a-contacto-cabecera casa-a-contacto-centrada">
			<h1 class="casa-a-contacto-titulo"><?php esc_html_e( 'Contacto', 'casa-a' ); ?></h1>
			<p class="casa-a-contacto-bajada"><?php esc_html_e( 'Respuesta en menos de 24 horas hábiles.', 'casa-a' ); ?></p>
		</header>

		<div class="casa-a-contacto-layout">

			<section class="casa-a-formulario casa-a-contacto-form" aria-labelledby="casa-a-form-titulo">
				<h2 id="casa-a-form-titulo" class="screen-reader-text"><?php esc_html_e( 'Enviar un mensaje', 'casa-a' ); ?></h2>

				<?php if ( isset( $avisos[ $estado ] ) ) : ?>
					<span hidden data-aviso-inicial data-tipo="<?php echo esc_attr( $avisos[ $estado ][0] ); ?>" data-texto="<?php echo esc_attr( $avisos[ $estado ][1] ); ?>"></span>
				<?php endif; ?>

				<form class="casa-a-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="casa_a_contacto">
					<?php wp_nonce_field( 'casa_a_contacto', 'casa_a_contacto_nonce' ); ?>

					<div class="casa-a-campo">
						<label for="casa-a-nombre"><?php esc_html_e( 'Nombre', 'casa-a' ); ?></label>
						<input type="text" id="casa-a-nombre" name="nombre" required minlength="3" maxlength="25" autocomplete="name">
					</div>

					<div class="casa-a-campo">
						<label for="casa-a-email"><?php esc_html_e( 'Mail', 'casa-a' ); ?></label>
						<input type="email" id="casa-a-email" name="email" required maxlength="254" pattern="[^.@&quot;_-][^&quot;_-]*" autocomplete="email" class="casa-a-minusculas">
					</div>

					<div class="casa-a-campo">
						<label for="casa-a-telefono"><?php esc_html_e( 'Teléfono (opcional)', 'casa-a' ); ?></label>
						<div class="casa-a-telefono">
							<input type="text" name="prefijo" value="+56 9" readonly tabindex="-1" aria-label="<?php esc_attr_e( 'Prefijo', 'casa-a' ); ?>">
							<input type="text" id="casa-a-telefono" name="telefono" inputmode="numeric" maxlength="9" pattern="[3-9][0-9]{3} [0-9]{4}" placeholder="8510 3181" autocomplete="tel-national" data-telefono>
						</div>
					</div>

					<div class="casa-a-campo">
						<label for="casa-a-descripcion"><?php esc_html_e( 'Mensaje', 'casa-a' ); ?></label>
						<textarea id="casa-a-descripcion" name="descripcion" rows="6" maxlength="2000" required></textarea>
						<p class="casa-a-contador">Límite 2000 caracteres</p>
					</div>

					<label class="casa-a-check">
						<input type="checkbox" name="privacidad" value="1" required>
						<span><?php esc_html_e( 'He leído y acepto la', 'casa-a' ); ?> <a href="<?php echo esc_url( home_url( '/politica-de-privacidad/' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Política de Privacidad', 'casa-a' ); ?></a>.</span>
					</label>
					<div class="casa-a-privacidad-aviso">
						<?php esc_html_e( 'Tus datos se usan solo para responder tu consulta.', 'casa-a' ); ?>
					</div>

					<?php /* Campo trampa anti-spam: oculto para personas. */ ?>
					<div class="casa-a-trampa" aria-hidden="true">
						<label>Sitio web <input type="text" name="sitio_web" tabindex="-1" autocomplete="off"></label>
					</div>

					<button type="submit" class="casa-a-boton-enviar"><?php esc_html_e( 'Enviar', 'casa-a' ); ?></button>
				</form>
			</section>

			<div class="casa-a-contacto-info">
				<div class="casa-a-contacto-mapa-caja">
					<iframe
						title="<?php esc_attr_e( 'Mapa de ubicación de lacasaa.cl', 'casa-a' ); ?>"
						src="<?php echo esc_url( 'https://www.google.com/maps?q=' . rawurlencode( $casa_a_direccion ) . '&output=embed' ); ?>"
						loading="lazy"
						referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
				<a class="casa-a-mapa-enlace" href="<?php echo esc_url( 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $casa_a_direccion ) ); ?>" target="_blank" rel="noopener">
					<?php esc_html_e( 'Abrir en Google Maps', 'casa-a' ); ?>
				</a>

				<ul class="casa-a-contacto-datos-grid">
					<li>
						<span class="casa-a-dato-etiqueta"><?php esc_html_e( 'Dirección', 'casa-a' ); ?></span>
						<span class="casa-a-dato-valor"><?php echo esc_html( $casa_a_direccion ); ?></span>
					</li>
					<li>
						<span class="casa-a-dato-etiqueta"><?php esc_html_e( 'Teléfono', 'casa-a' ); ?></span>
						<a class="casa-a-dato-valor" href="<?php echo esc_attr( 'tel:' . preg_replace( '/[^0-9+]/', '', $casa_a_telefono ) ); ?>"><?php echo esc_html( $casa_a_telefono ); ?></a>
					</li>
					<li>
						<span class="casa-a-dato-etiqueta"><?php esc_html_e( 'Mail', 'casa-a' ); ?></span>
						<a class="casa-a-dato-valor" href="<?php echo esc_attr( 'mailto:' . $casa_a_correo ); ?>"><?php echo esc_html( $casa_a_correo ); ?></a>
					</li>
					<li>
						<span class="casa-a-dato-etiqueta"><?php esc_html_e( 'Horario de atención', 'casa-a' ); ?></span>
						<span class="casa-a-dato-valor"><?php echo esc_html( $casa_a_horario ); ?></span>
					</li>
					<li>
						<span class="casa-a-dato-etiqueta"><?php esc_html_e( 'Redes sociales', 'casa-a' ); ?></span>
						<a class="casa-a-dato-valor" href="https://www.instagram.com/casaa.cl/" target="_blank" rel="noopener">Instagram @casaa.cl</a>
					</li>
				</ul>
			</div>

		</div>
	</div>
</main>
<?php
get_footer();
