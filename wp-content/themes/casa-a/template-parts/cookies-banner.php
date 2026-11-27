<?php
/**
 * Banner de cookies: pide consentimiento antes de cargar Google Tag Manager y Microsoft Clarity.
 * Se muestra solo en páginas públicas (ver casa_a_analitica_activa() en functions.php).
 * data-version identifica la versión del texto; si cambia, el visitante vuelve a decidir.
 *
 * @package CASA_A
 */
?>
<div class="casa-a-cookies" role="dialog" aria-labelledby="casa-a-cookies-texto" hidden data-cookies data-version="1" data-gtm="GTM-5CFDL8ZS" data-clarity="zi7qd4b8ue">
	<p id="casa-a-cookies-texto" class="casa-a-cookies-texto">
		<?php esc_html_e( 'Usamos cookies de analítica de', 'casa-a' ); ?> <strong>Microsoft Clarity</strong> <?php esc_html_e( 'y', 'casa-a' ); ?> <strong>Google Analytics</strong>
		<?php esc_html_e( 'para medir cómo se usa lacasaa.cl y mejorarlo. Solo se activan si las aceptas; si no, no se cargan. Estos servicios tratan parte de los datos fuera de Chile. Puedes cambiar tu decisión cuando quieras con «Configurar cookies» en el pie de página.', 'casa-a' ); ?>
		<a href="<?php echo esc_url( home_url( '/politica-de-privacidad/' ) ); ?>"><?php esc_html_e( 'Más información en la política de privacidad (versión 1.0, 23-11-2026)', 'casa-a' ); ?></a>
	</p>
	<p class="casa-a-cookies-estado" data-cookies-estado hidden></p>
	<div class="casa-a-cookies-botones">
		<button type="button" class="casa-a-cookies-rechazar" data-cookies-rechazar><?php esc_html_e( 'Rechazar', 'casa-a' ); ?></button>
		<button type="button" class="casa-a-cookies-aceptar" data-cookies-aceptar><?php esc_html_e( 'Aceptar', 'casa-a' ); ?></button>
	</div>
</div>
