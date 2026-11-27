<?php
/**
 * Template Name: Mi reserva
 *
 * Revisión de la selección y solicitud de arriendo. La lista sale de lo guardado en el navegador
 * (assets/js/reserva.js). Usa esta plantilla en la página con slug "mi-reserva".
 *
 * @package CASA_A
 */

get_header();

$casa_a_estado = isset( $_GET['casa_a_cotizacion'] ) ? sanitize_key( wp_unslash( $_GET['casa_a_cotizacion'] ) ) : '';
$casa_a_avisos = array(
	'ok'    => array( 'ok', __( 'Gracias. Recibimos tu solicitud de arriendo y te responderemos pronto.', 'casa-a' ) ),
	'error' => array( 'error', __( 'Revisa los datos de la solicitud (nombre, correo, teléfono, fechas, comentarios, aceptar las condiciones y la política de privacidad) e intenta de nuevo.', 'casa-a' ) ),
	'fallo' => array( 'error', __( 'No pudimos enviar tu solicitud. Intenta más tarde o escríbenos a hola@lacasaa.cl.', 'casa-a' ) ),
);
?>
<main class="casa-a-main casa-a-reserva">
	<div class="casa-a-wrap casa-a-reserva-grid">

		<section class="casa-a-reserva-izq" aria-labelledby="casa-a-reserva-titulo">
			<h1 id="casa-a-reserva-titulo" class="casa-a-reserva-titulo"><?php esc_html_e( 'Mi reserva', 'casa-a' ); ?></h1>
			<p class="casa-a-reserva-subtitulo" data-reserva-titulo><?php esc_html_e( 'Tu selección', 'casa-a' ); ?></p>

			<ul class="casa-a-reserva-lista" data-reserva-lista></ul>
			<div class="casa-a-paginacion" data-reserva-paginacion hidden></div>
			<p class="casa-a-reserva-vacia" data-reserva-vacia hidden><?php esc_html_e( 'Tu reserva está vacía. Agrega productos desde el catálogo.', 'casa-a' ); ?></p>

			<div class="casa-a-reserva-resumen">
				<div><span><?php esc_html_e( 'Arriendo por día', 'casa-a' ); ?></span><span data-reserva-total>$0</span></div>
			</div>
			<p class="casa-a-reserva-nota"><?php esc_html_e( 'Valores referenciales. El total final y la disponibilidad se confirman al revisar tu solicitud.', 'casa-a' ); ?></p>
		</section>

		<aside class="casa-a-reserva-form-wrap">
			<form class="casa-a-reserva-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-reserva-form>
				<input type="hidden" name="action" value="casa_a_cotizar">
				<input type="hidden" name="items" value="[]" data-reserva-items>
				<?php wp_nonce_field( 'casa_a_cotizar', 'casa_a_cotizar_nonce' ); ?>

				<h2 class="casa-a-reserva-form-titulo"><?php esc_html_e( 'Datos de tu solicitud', 'casa-a' ); ?></h2>

				<label class="casa-a-reserva-campo">
					<span><?php esc_html_e( 'Nombre', 'casa-a' ); ?> <span aria-hidden="true">*</span></span>
					<input type="text" name="nombre" required minlength="3" maxlength="25" autocomplete="name" class="casa-a-mayusculas">
				</label>

				<div class="casa-a-reserva-fila">
					<label class="casa-a-reserva-campo">
						<span><?php esc_html_e( 'Correo', 'casa-a' ); ?> <span aria-hidden="true">*</span></span>
						<input type="email" name="email" required maxlength="35" pattern="[^.@&quot;_-][^&quot;_-]*" autocomplete="email" class="casa-a-minusculas">
					</label>
					<div class="casa-a-reserva-campo">
						<span><?php esc_html_e( 'Teléfono (opcional)', 'casa-a' ); ?></span>
						<div class="casa-a-telefono">
							<input type="text" name="prefijo" value="+56 9" readonly tabindex="-1" aria-label="<?php esc_attr_e( 'Prefijo', 'casa-a' ); ?>">
							<input type="text" name="telefono" inputmode="numeric" maxlength="9" pattern="[3-9][0-9]{3} [0-9]{4}" placeholder="8510 3181" autocomplete="tel-national" data-telefono aria-label="<?php esc_attr_e( 'Teléfono', 'casa-a' ); ?>">
						</div>
					</div>
				</div>

				<label class="casa-a-reserva-campo">
					<span><?php esc_html_e( 'Nombre del proyecto', 'casa-a' ); ?></span>
					<input type="text" name="nombre_proyecto" required maxlength="25" class="casa-a-minusculas" autocomplete="off">
				</label>

				<div class="casa-a-reserva-fila">
					<label class="casa-a-reserva-campo">
						<span><?php esc_html_e( 'Fecha de retiro', 'casa-a' ); ?></span>
						<input type="date" name="fecha_retiro" required min="<?php echo esc_attr( gmdate( 'Y-m-d' ) ); ?>">
					</label>
					<label class="casa-a-reserva-campo">
						<span><?php esc_html_e( 'Fecha de devolución', 'casa-a' ); ?></span>
						<input type="date" name="fecha_devolucion" required min="<?php echo esc_attr( gmdate( 'Y-m-d' ) ); ?>">
					</label>
				</div>

				<label class="casa-a-reserva-campo">
					<span><?php esc_html_e( 'Comentarios', 'casa-a' ); ?></span>
					<textarea name="comentarios" rows="4" maxlength="2000"></textarea>
				</label>

				<label class="casa-a-check">
					<input type="checkbox" name="privacidad" value="1" required>
					<span><?php esc_html_e( 'He leído y acepto la', 'casa-a' ); ?> <a href="<?php echo esc_url( home_url( '/politica-de-privacidad/' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Política de Privacidad', 'casa-a' ); ?></a>.</span>
				</label>

				<label class="casa-a-check">
					<input type="checkbox" name="condiciones" value="1" required>
					<span><?php esc_html_e( 'Acepto las', 'casa-a' ); ?> <a href="<?php echo esc_url( home_url( '/condiciones-de-arriendo/' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'condiciones de arriendo', 'casa-a' ); ?></a>.</span>
				</label>

				<?php /* Campo trampa anti-spam: oculto para personas. */ ?>
				<div class="casa-a-trampa" aria-hidden="true">
					<label>Sitio web <input type="text" name="sitio_web" tabindex="-1" autocomplete="off"></label>
				</div>

				<button type="submit" class="casa-a-reserva-enviar" data-reserva-enviar><?php esc_html_e( 'Enviar solicitud de arriendo', 'casa-a' ); ?></button>
			</form>
		</aside>
	</div>

	<?php if ( isset( $casa_a_avisos[ $casa_a_estado ] ) ) : ?>
		<span hidden data-aviso-inicial data-tipo="<?php echo esc_attr( $casa_a_avisos[ $casa_a_estado ][0] ); ?>" data-texto="<?php echo esc_attr( $casa_a_avisos[ $casa_a_estado ][1] ); ?>"></span>
	<?php endif; ?>
</main>
<?php
get_footer();
