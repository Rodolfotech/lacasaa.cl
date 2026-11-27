<?php
/**
 * Banner de cookies: pide consentimiento antes de cargar Google Tag Manager y Microsoft Clarity.
 * Se muestra solo en páginas públicas (ver casa_a_analitica_activa() en functions.php).
 * data-version identifica la versión del texto; si cambia, el visitante vuelve a decidir.
 *
 * @package CASA_A
 */
?>
<div class="casa-a-cookies" role="dialog" aria-labelledby="casa-a-cookies-texto" hidden data-cookies data-version="2" data-gtm="GTM-5CFDL8ZS" data-clarity="zi7qd4b8ue">
	<p id="casa-a-cookies-texto" class="casa-a-cookies-texto">
		<?php esc_html_e( 'Usamos cookies de medición (Google Analytics, Microsoft Clarity y Google Tag Manager) para entender cómo se usa el sitio. Solo se instalan si las aceptas. Más información en la', 'casa-a' ); ?>
		<a href="<?php echo esc_url( home_url( '/politica-de-privacidad/' ) ); ?>"><?php esc_html_e( 'Política de privacidad', 'casa-a' ); ?></a>.
	</p>
	<p class="casa-a-cookies-estado" data-cookies-estado hidden></p>
	<div class="casa-a-cookies-botones">
		<button type="button" class="casa-a-cookies-rechazar" data-cookies-rechazar><?php esc_html_e( 'Rechazar', 'casa-a' ); ?></button>
		<button type="button" class="casa-a-cookies-aceptar" data-cookies-aceptar><?php esc_html_e( 'Aceptar', 'casa-a' ); ?></button>
	</div>
</div>
