/**
 * Campos en minúsculas: el texto se convierte a minúsculas mientras se escribe.
 * Campo: input con clase casa-a-minusculas.
 */
(function () {
	'use strict';

	document.addEventListener('input', function (evento) {
		var campo = evento.target;

		if (!campo.classList || !campo.classList.contains('casa-a-minusculas')) {
			return;
		}

		var minusculas = campo.value.toLowerCase();

		if (minusculas !== campo.value) {
			var inicio = campo.selectionStart;
			var fin = campo.selectionEnd;

			campo.value = minusculas;

			try {
				campo.setSelectionRange(inicio, fin);
			} catch (e) {
				// Algunos tipos de campo (email) no permiten mover el cursor: no pasa nada.
			}
		}
	});
})();
