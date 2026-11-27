<?php
/**
 * Modal reutilizable de aviso: muestra un mensaje con la X arriba a la derecha y el botón "Salir".
 * Se abre desde JavaScript con window.casaAModal.abrir( texto, tipo ), tipo: 'ok' o 'error'.
 *
 * @package CASA_A
 */
?>
<div class="casa-a-aviso-fondo" data-aviso-cerrar hidden></div>

<div class="casa-a-aviso-modal" role="dialog" aria-modal="true" aria-labelledby="casa-a-aviso-texto" aria-hidden="true" hidden>
	<button type="button" class="casa-a-aviso-x" data-aviso-cerrar aria-label="<?php esc_attr_e( 'Cerrar', 'casa-a' ); ?>">
		<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
	</button>
	<p id="casa-a-aviso-texto" class="casa-a-aviso-texto" data-aviso-texto></p>
	<button type="button" class="casa-a-boton-enviar casa-a-aviso-salir" data-aviso-cerrar><?php esc_html_e( 'Salir', 'casa-a' ); ?></button>
</div>
