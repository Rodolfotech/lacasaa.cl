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
$casa_a_restante = isset( $_GET['casa_a_restante'] ) ? absint( $_GET['casa_a_restante'] ) : 0;
$casa_a_minutos  = max( 1, (int) ceil( $casa_a_restante / 60 ) );
$campo  = isset( $_GET['casa_a_campo'] ) ? sanitize_key( wp_unslash( $_GET['casa_a_campo'] ) ) : '';
$nombres_campo = array(
	'nombre'      => __( 'Nombre', 'casa-a' ),
	'email'       => __( 'Correo', 'casa-a' ),
	'telefono'    => __( 'Teléfono', 'casa-a' ),
	'descripcion' => __( 'Mensaje', 'casa-a' ),
	'privacidad'  => __( 'Política de privacidad', 'casa-a' ),
);
$aviso_error = isset( $nombres_campo[ $campo ] )
	? sprintf( __( 'Revisa el campo «%s» e intenta de nuevo.', 'casa-a' ), $nombres_campo[ $campo ] )
	: __( 'Hay campos obligatorios sin completar o con errores. Revisa los campos marcados en rojo e intenta de nuevo.', 'casa-a' );
$avisos = array(
	'ok'      => array( 'casa-a-aviso-ok', __( 'Gracias. Recibimos tu mensaje y te responderemos pronto.', 'casa-a' ) ),
	'error'   => array( 'casa-a-aviso-error', $aviso_error ),
	'archivo' => array( 'casa-a-aviso-error', __( 'El archivo no se pudo subir. Usa JPG, PNG o PDF.', 'casa-a' ) ),
	'fallo'   => array( 'casa-a-aviso-error', __( 'No pudimos enviar el mensaje. Intenta más tarde o escríbenos directamente.', 'casa-a' ) ),
	'espera'  => array( 'casa-a-aviso-error', sprintf(
		/* translators: 1: número de minutos, 2: palabra "minuto" o "minutos". */
		__( 'Acabas de enviar tu mensaje. Para evitar envíos repetidos, puedes enviar otro en %1$d %2$s. Si necesitas algo urgente, escríbenos a hola@lacasaa.cl.', 'casa-a' ),
		$casa_a_minutos,
		_n( 'minuto', 'minutos', $casa_a_minutos, 'casa-a' )
	) ),
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

				<?php /* El modal de aviso solo aparece cuando el mensaje se envió bien; los errores van en el formulario. */ ?>
				<?php if ( 'ok' === $estado ) : ?>
					<span hidden data-aviso-inicial data-tipo="<?php echo esc_attr( $avisos[ $estado ][0] ); ?>" data-texto="<?php echo esc_attr( $avisos[ $estado ][1] ); ?>"></span>
				<?php endif; ?>

				<form class="casa-a-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-campo-error="<?php echo esc_attr( 'error' === $estado ? $campo : '' ); ?>">
					<input type="hidden" name="action" value="casa_a_contacto">
					<?php wp_nonce_field( 'casa_a_contacto', 'casa_a_contacto_nonce' ); ?>

					<div class="casa-a-campo">
						<label for="casa-a-nombre"><?php esc_html_e( 'Nombre', 'casa-a' ); ?> <span class="casa-a-obligatorio" tabindex="0" data-tip="Campo obligatorio" aria-label="Campo obligatorio">*</span></label>
						<input type="text" id="casa-a-nombre" name="nombre" required minlength="3" maxlength="25" autocomplete="name">
					</div>

					<div class="casa-a-campo">
						<label for="casa-a-email"><?php esc_html_e( 'Correo', 'casa-a' ); ?> <span class="casa-a-obligatorio" tabindex="0" data-tip="Campo obligatorio" aria-label="Campo obligatorio">*</span></label>
						<input type="email" id="casa-a-email" name="email" required maxlength="50" pattern="[^.@&quot;_-][^&quot;_-]*" autocomplete="email" class="casa-a-minusculas">
					</div>

					<div class="casa-a-campo">
						<label for="casa-a-telefono"><?php esc_html_e( 'Teléfono', 'casa-a' ); ?> <span class="casa-a-obligatorio" tabindex="0" data-tip="Campo obligatorio" aria-label="Campo obligatorio">*</span></label>
						<div class="casa-a-telefono">
							<input type="text" name="prefijo" value="+56 9" readonly tabindex="-1" aria-label="<?php esc_attr_e( 'Prefijo', 'casa-a' ); ?>">
							<input type="text" id="casa-a-telefono" name="telefono" required inputmode="numeric" maxlength="9" pattern="[3-9][0-9]{3} [0-9]{4}" placeholder="8510 3181" autocomplete="tel-national" data-telefono>
						</div>
					</div>

					<div class="casa-a-campo">
						<label for="casa-a-descripcion"><?php esc_html_e( 'Mensaje', 'casa-a' ); ?> <span class="casa-a-obligatorio" tabindex="0" data-tip="Campo obligatorio" aria-label="Campo obligatorio">*</span></label>
						<textarea id="casa-a-descripcion" name="descripcion" rows="6" maxlength="2000" required></textarea>
						<p class="casa-a-contador">Límite 2000 caracteres</p>
					</div>

					<label class="casa-a-check">
						<input type="checkbox" name="privacidad" value="1" required>
						<span><?php esc_html_e( 'He leído y acepto la', 'casa-a' ); ?> <a href="<?php echo esc_url( home_url( '/politica-de-privacidad/' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Política de Privacidad', 'casa-a' ); ?></a> <span class="casa-a-obligatorio" tabindex="0" data-tip="Campo obligatorio" aria-label="Campo obligatorio">*</span>.</span>
					</label>
					<div class="casa-a-privacidad-aviso">
						<?php esc_html_e( 'Tus datos se usan solo para responder tu consulta.', 'casa-a' ); ?>
					</div>

					<?php /* Campo trampa anti-spam: oculto para personas. */ ?>
					<div class="casa-a-trampa" aria-hidden="true">
						<label>Sitio web <input type="text" name="sitio_web" tabindex="-1" autocomplete="off"></label>
					</div>

					<?php $contacto_mostrar_error = 'fallo' === $estado; ?>
					<p class="casa-a-contacto-error" data-contacto-error role="alert"<?php echo $contacto_mostrar_error ? '' : ' hidden'; ?>><?php echo $contacto_mostrar_error ? esc_html( $avisos[ $estado ][1] ) : ''; ?></p>

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
<script>
/* Contacto: los datos del formulario se conservan al recargar o si el envío falla; se borran solo tras un envío correcto. */
document.addEventListener('DOMContentLoaded', function () {
	var formulario = document.querySelector('.casa-a-form');
	if (!formulario) {
		return;
	}

	var CLAVE = 'casa_a_contacto_formulario';
	var parametros = new URLSearchParams(window.location.search);
	var estado = parametros.get('casa_a_estado');
	var campos = Array.prototype.filter.call(formulario.elements, function (campo) {
		return campo.name && campo.type !== 'hidden' && campo.type !== 'submit' && campo.name !== 'prefijo' && campo.name !== 'sitio_web';
	});

	function guardar() {
		var datos = {};
		campos.forEach(function (campo) {
			datos[campo.name] = campo.type === 'checkbox' ? campo.checked : campo.value;
		});
		try { sessionStorage.setItem(CLAVE, JSON.stringify(datos)); } catch (e) {}
	}

	if (estado === 'ok') {
		try { sessionStorage.removeItem(CLAVE); } catch (e) {}
		// Se quita el resultado de la dirección para que el aviso de éxito no vuelva a aparecer al recargar.
		window.history.replaceState({}, '', window.location.pathname + window.location.hash);
	} else {
		try {
			var datos = JSON.parse(sessionStorage.getItem(CLAVE) || 'null');
			if (datos) {
				campos.forEach(function (campo) {
					if (!(campo.name in datos)) {
						return;
					}
					if (campo.type === 'checkbox') {
						campo.checked = !!datos[campo.name];
					} else {
						campo.value = datos[campo.name];
					}
				});
			}
		} catch (e) {}
	}

	var MENSAJES = {
		nombre: { vacio: 'Ingresa tu nombre.', formato: 'El nombre debe tener entre 3 y 25 caracteres.' },
		email: { vacio: 'Ingresa tu correo.', formato: 'Ingresa un correo válido.' },
		telefono: { vacio: 'Ingresa tu teléfono.', formato: 'Ingresa un teléfono válido de 8 dígitos (sin el +56 9).' },
		descripcion: { vacio: 'Escribe tu mensaje.', formato: 'El mensaje puede tener hasta 2000 caracteres.' },
		privacidad: { vacio: 'Debes aceptar la Política de Privacidad.', formato: 'Debes aceptar la Política de Privacidad.' }
	};

	// Límite de envíos: tras un mensaje enviado, aviso en modal con cuenta regresiva de 5 minutos (también al recargar).
	var CLAVE_ESPERA = 'casa_a_contacto_espera_hasta';
	var temporizador = null;
	var avisoEsperaPendiente = false;

	function guardarEspera(segundos) {
		try { localStorage.setItem(CLAVE_ESPERA, String(Date.now() + segundos * 1000)); } catch (e) {}
	}

	function segundosDeEspera() {
		var hasta = 0;
		try { hasta = parseInt(localStorage.getItem(CLAVE_ESPERA), 10) || 0; } catch (e) {}
		return Math.max(0, Math.ceil((hasta - Date.now()) / 1000));
	}

	function enEspera() {
		return segundosDeEspera() > 0;
	}

	function textoEspera() {
		var segundos = segundosDeEspera();
		var minutos = Math.floor(segundos / 60);
		var resto = segundos % 60;
		return 'Acabas de enviar tu mensaje. Para evitar envíos repetidos, puedes enviar otro en ' + minutos + ':' + (resto < 10 ? '0' : '') + resto + '. Si necesitas algo urgente, escríbenos a hola@lacasaa.cl.';
	}

	function modalAbierto() {
		var modal = document.querySelector('.casa-a-aviso-modal');
		return !!modal && !modal.hidden;
	}

	// Contador inverso: actualiza el modal cada segundo y lo cierra al terminar.
	function actualizarEspera() {
		if (!enEspera()) {
			if (temporizador) {
				clearInterval(temporizador);
				temporizador = null;
			}
			if (modalAbierto() && window.casaAModal) {
				window.casaAModal.cerrar();
			}
			return;
		}

		if (modalAbierto()) {
			var texto = document.querySelector('[data-aviso-texto]');
			if (texto) {
				texto.textContent = textoEspera();
			}
		}

		if (!temporizador) {
			temporizador = setInterval(actualizarEspera, 1000);
		}
	}

	function mostrarAvisoEspera() {
		if (!enEspera() || !window.casaAModal) {
			return;
		}
		window.casaAModal.abrir(textoEspera(), 'espera');
		actualizarEspera();
	}

	document.addEventListener('casaa:aviso-cerrado', function () {
		if (avisoEsperaPendiente) {
			avisoEsperaPendiente = false;
			mostrarAvisoEspera();
		}
	});

	if (estado === 'ok') {
		guardarEspera(5 * 60);
		avisoEsperaPendiente = true;
	}
	if (estado === 'espera') {
		guardarEspera(parseInt(parametros.get('casa_a_restante'), 10) || 300);
		window.addEventListener('load', mostrarAvisoEspera);
	}
	if (!estado && enEspera()) {
		window.addEventListener('load', mostrarAvisoEspera);
	}

	casaAValidacion.inicializar(formulario, campos, MENSAJES, function () {
		if (enEspera()) {
			mostrarAvisoEspera();
			return false;
		}
		return true;
	});
	formulario.addEventListener('input', guardar);
	formulario.addEventListener('change', guardar);

	if (estado === 'error') {
		casaAValidacion.mostrarServidor(formulario, campos, MENSAJES);
	}
});
</script>
<?php
get_footer();
