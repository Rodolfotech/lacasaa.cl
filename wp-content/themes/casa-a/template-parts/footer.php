<?php
/**
 * Componente de pie de página reutilizable: marca, contacto, horario y ayuda, con barra legal.
 *
 * Uso en cualquier plantilla:
 *   get_template_part( 'template-parts/footer' );
 * Para cambiar datos sin editar el archivo:
 *   get_template_part( 'template-parts/footer', null, array( 'telefono' => '+56 2 1234 5678' ) );
 *
 * Los datos de contacto son marcadores ([DIRECCIÓN CASA A], etc.) hasta que se reemplacen.
 *
 * @package CASA_A
 */

$casa_a_args = isset( $args ) && is_array( $args ) ? $args : array();

$casa_a_datos = wp_parse_args(
	$casa_a_args,
	array(
		'descripcion'  => __( 'Arriendo de muebles y decoración para eventos, producciones audiovisuales y fotografía.', 'casa-a' ),
		'direccion'    => 'Padre Orellana 1957, Santiago',
		'telefono'     => '+569 8510 3181',
		'correo'       => 'hola@lacasaa.cl',
		'horario'      => '9:30 – 17:00',
		'horario_nota' => __( 'Respondemos en 24 horas hábiles.', 'casa-a' ),
		'instagram'    => '@casaa.cl',
		'instagram_url' => 'https://www.instagram.com/casaa.cl/',
		'ubicacion'    => __( 'Santiago, Chile', 'casa-a' ),
		// Número con código de país, solo dígitos (ej. 56912345678). Vacío oculta WhatsApp.
		'whatsapp'     => '',
	)
);

$casa_a_tel_href = preg_match( '/\d/', $casa_a_datos['telefono'] ) ? 'tel:' . preg_replace( '/[^0-9+]/', '', $casa_a_datos['telefono'] ) : '#';
$casa_a_wa_href  = $casa_a_datos['whatsapp'] ? 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $casa_a_datos['whatsapp'] ) : '';
?>
<footer class="casa-a-footer">
	<div class="casa-a-wrap casa-a-footer-grid">

		<div class="casa-a-footer-marca">
			<a class="casa-a-footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="lacasaa.cl">
				<img class="casa-a-footer-logo-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/LOGO.jpeg' ); ?>" alt="lacasaa.cl" width="auto" height="auto">
			</a>
			<p><?php echo esc_html( $casa_a_datos['descripcion'] ); ?></p>
		</div>

		<div>
			<h3 class="casa-a-footer-titulo"><?php esc_html_e( 'Contacto', 'casa-a' ); ?></h3>
			<ul class="casa-a-footer-lista">
				<li><span><?php echo esc_html( $casa_a_datos['direccion'] ); ?></span></li>
				<li><a href="<?php echo esc_attr( $casa_a_tel_href ); ?>"><?php echo esc_html( $casa_a_datos['telefono'] ); ?></a></li>
				<li><a href="mailto:<?php echo esc_attr( $casa_a_datos['correo'] ); ?>"><?php echo esc_html( $casa_a_datos['correo'] ); ?></a></li>
			</ul>
		</div>

		<div>
			<h3 class="casa-a-footer-titulo"><?php esc_html_e( 'Horario', 'casa-a' ); ?></h3>
			<p class="casa-a-footer-horario"><?php echo esc_html( $casa_a_datos['horario'] ); ?></p>
			<p class="casa-a-footer-nota"><?php echo esc_html( $casa_a_datos['horario_nota'] ); ?></p>
		</div>

		<div>
			<h3 class="casa-a-footer-titulo"><?php esc_html_e( 'Ayuda', 'casa-a' ); ?></h3>
			<ul class="casa-a-footer-lista">
				<li><a href="<?php echo esc_url( home_url( '/como-arrendar/' ) ); ?>"><?php esc_html_e( 'Cómo arrendar', 'casa-a' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/como-arrendar/#politicas' ) ); ?>"><?php esc_html_e( 'Condiciones de arriendo', 'casa-a' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"><?php esc_html_e( 'Contacto', 'casa-a' ); ?></a></li>
				<li>
					<a class="casa-a-footer-instagram" href="<?php echo esc_url( $casa_a_datos['instagram_url'] ); ?>" target="_blank" rel="noopener">
						<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.8" fill="currentColor"/></svg>
						<?php echo esc_html( 'Instagram ' . $casa_a_datos['instagram'] ); ?>
					</a>
				</li>
			</ul>
		</div>

	</div>

	<div class="casa-a-footer-base">
		<div class="casa-a-wrap casa-a-footer-base-interior">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> lacasaa.cl · <?php echo esc_html( $casa_a_datos['ubicacion'] ); ?></p>
			<nav aria-label="<?php esc_attr_e( 'Legal', 'casa-a' ); ?>">
				<a href="<?php echo esc_url( home_url( '/politica-de-privacidad/' ) ); ?>"><?php esc_html_e( 'Política de privacidad', 'casa-a' ); ?></a>
				<a href="#" data-cookies-abrir><?php esc_html_e( 'Configurar cookies', 'casa-a' ); ?></a>
			</nav>
		</div>
	</div>
</footer>

<?php if ( $casa_a_wa_href ) : ?>
	<a class="casa-a-whatsapp-flotante" href="<?php echo esc_url( $casa_a_wa_href ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Escribir por WhatsApp', 'casa-a' ); ?>">
		<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 11.5A8.5 8.5 0 0 1 8.2 19.3L4 20.5l1.2-4A8.5 8.5 0 1 1 20 11.5z"/><path d="M9 9.5c0 3 2.5 5.5 5.5 5.5l1-1.2-2-1-.8.8a4.5 4.5 0 0 1-2.5-2.5l.8-.8-1-2z"/></svg>
	</a>
<?php endif; ?>

<?php if ( casa_a_analitica_activa() ) { get_template_part( 'template-parts/cookies-banner' ); } ?>

