/**
 * Validación de formularios del sitio: cada campo con error muestra su mensaje debajo.
 * Lo usan "Mi reserva" (reserva.js) y "Contacto" (page-contacto.php).
 */
(function (window, document) {
	'use strict';

	function contenedorDe(campo) {
		if (campo.type === 'checkbox') {
			return campo.closest('label');
		}
		return campo.closest('.casa-a-reserva-campo, .casa-a-campo') || campo.parentNode;
	}

	function quitar(campo) {
		if (campo.__casaMensaje) {
			campo.__casaMensaje.remove();
			campo.__casaMensaje = null;
		}
		campo.classList.remove('casa-a-campo-invalido');
	}

	function mostrar(campo, texto) {
		quitar(campo);

		var mensaje = document.createElement('p');
		mensaje.className = 'casa-a-campo-error';
		mensaje.setAttribute('role', 'alert');
		mensaje.textContent = texto;

		var contenedor = contenedorDe(campo);
		if (campo.type === 'checkbox') {
			contenedor.parentNode.insertBefore(mensaje, contenedor.nextSibling);
		} else {
			contenedor.appendChild(mensaje);
		}

		campo.__casaMensaje = mensaje;
		campo.classList.add('casa-a-campo-invalido');
	}

	function mensajeDe(campo, mensajes) {
		var textos = mensajes[campo.name] || {};
		if (campo.validity.customError) {
			return campo.validationMessage;
		}
		if (campo.validity.valueMissing) {
			return textos.vacio || 'Este campo es obligatorio.';
		}
		return textos.formato || 'Revisa este campo.';
	}

	function revisar(campo, mensajes) {
		if (campo.checkValidity()) {
			quitar(campo);
		} else {
			mostrar(campo, mensajeDe(campo, mensajes));
		}
	}

	/**
	 * @param {HTMLFormElement} formulario
	 * @param {HTMLElement[]} campos
	 * @param {Object} mensajes  Por nombre de campo: { vacio: '...', formato: '...' }
	 * @param {function(Event): boolean} [antesDeEnviar]  Devuelve false para no enviar.
	 */
	function inicializar(formulario, campos, mensajes, antesDeEnviar) {
		campos.forEach(function (campo) {
			var alCambiar = function () {
				if (campo.__casaMensaje || campo.classList.contains('casa-a-campo-invalido')) {
					revisar(campo, mensajes);
				}
			};
			campo.addEventListener('input', alCambiar);
			campo.addEventListener('change', alCambiar);
		});

		formulario.addEventListener('submit', function (evento) {
			if (antesDeEnviar && antesDeEnviar(evento) === false) {
				evento.preventDefault();
				return;
			}

			campos.forEach(function (campo) {
				revisar(campo, mensajes);
			});

			var primero = campos.filter(function (campo) {
				return !campo.checkValidity();
			})[0];

			if (primero) {
				evento.preventDefault();
				primero.focus();
			}
		});
	}

	/** Tras un error del servidor: se revisan todos los campos y se muestra el mensaje del que rechazó. */
	function mostrarServidor(formulario, campos, mensajes) {
		campos.forEach(function (campo) {
			revisar(campo, mensajes);
		});

		var culpable = formulario.getAttribute('data-campo-error');
		var campo = culpable ? formulario.elements[culpable] : null;
		if (campo && campo.name) {
			var textos = mensajes[culpable] || {};
			mostrar(campo, textos.formato || 'Revisa este campo.');
		}
	}

	window.casaAValidacion = {
		inicializar: inicializar,
		mostrarServidor: mostrarServidor
	};
})(window, document);
