/**
 * Modal de aviso reutilizable.
 *
 *   window.casaAModal.abrir( 'Mensaje', 'ok' | 'error' );
 *   window.casaAModal.cerrar();
 *
 * Se cierra con la X, con el botón "Salir", con clic en el fondo o con Escape.
 * Si la página trae un elemento [data-aviso-inicial], lo muestra al cargar.
 */
(function () {
	'use strict';

	var fondo = null;
	var modal = null;
	var texto = null;

	function abrir(mensaje, tipo) {
		modal.classList.toggle('is-error', tipo === 'error');
		texto.textContent = mensaje;
		modal.hidden = false;
		fondo.hidden = false;

		requestAnimationFrame(function () {
			modal.classList.add('is-open');
			fondo.classList.add('is-open');
		});

		modal.setAttribute('aria-hidden', 'false');
		modal.querySelector('.casa-a-aviso-salir').focus();
	}

	function cerrar() {
		modal.classList.remove('is-open');
		fondo.classList.remove('is-open');
		modal.setAttribute('aria-hidden', 'true');

		window.setTimeout(function () {
			if (!modal.classList.contains('is-open')) {
				modal.hidden = true;
				fondo.hidden = true;
			}
		}, 250);
	}

	document.addEventListener('click', function (evento) {
		if (evento.target.closest('[data-aviso-cerrar]')) {
			cerrar();
		}
	});

	document.addEventListener('keydown', function (evento) {
		if (evento.key === 'Escape' && modal && modal.classList.contains('is-open')) {
			cerrar();
		}
	});

	// Quita el resultado del envío de la dirección: así recargar la página no vuelve a mostrar el modal.
	function quitarParametroEstado() {
		var url = new URL(window.location.href);

		if (url.searchParams.has('casa_a_estado')) {
			url.searchParams.delete('casa_a_estado');
			window.history.replaceState({}, '', url.pathname + url.search + url.hash);
		}
	}

	// Quita el resultado del envío de la dirección: así recargar la página no vuelve a mostrar el modal.
	function quitarParametroEstado() {
		var url = new URL(window.location.href);

		if (url.searchParams.has('casa_a_estado')) {
			url.searchParams.delete('casa_a_estado');
			window.history.replaceState({}, '', url.pathname + url.search + url.hash);
		}
	}

	function iniciar() {
		fondo = document.querySelector('.casa-a-aviso-fondo');
		modal = document.querySelector('.casa-a-aviso-modal');
		texto = document.querySelector('[data-aviso-texto]');

		if (!fondo || !modal || !texto) {
			return;
		}

		window.casaAModal = { abrir: abrir, cerrar: cerrar };

		var inicial = document.querySelector('[data-aviso-inicial]');
		if (inicial) {
			abrir(inicial.getAttribute('data-texto'), inicial.getAttribute('data-tipo'));
			quitarParametroEstado();
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', iniciar);
	} else {
		iniciar();
	}
})();
