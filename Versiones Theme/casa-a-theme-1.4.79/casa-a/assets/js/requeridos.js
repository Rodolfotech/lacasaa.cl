/**
 * Mensajes propios para los campos obligatorios de los formularios.
 * Reemplaza el aviso del navegador solo cuando falta el campo; los demás errores quedan igual.
 */
(function () {
	'use strict';

	function textoFaltante(campo) {
		return campo.type === 'checkbox'
			? 'Debes marcar esta casilla para continuar.'
			: 'Este campo es obligatorio.';
	}

	// Al llegar el aviso de inválido, se fija el mensaje propio si falta el valor.
	document.addEventListener('invalid', function (evento) {
		var campo = evento.target;

		if (!campo.form || !campo.willValidate) {
			return;
		}

		campo.setCustomValidity(campo.validity.valueMissing ? textoFaltante(campo) : '');
	}, true);

	// Al corregir el campo se limpia el mensaje para no bloquear el envío.
	function limpiar(evento) {
		if (evento.target.form) {
			evento.target.setCustomValidity('');
		}
	}

	document.addEventListener('input', limpiar, true);
	document.addEventListener('change', limpiar, true);
})();
