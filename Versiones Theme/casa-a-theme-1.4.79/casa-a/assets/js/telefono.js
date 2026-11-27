/**
 * Teléfono chileno: 8 dígitos con espacio después del cuarto (8510 3181).
 * No acepta un primer dígito 1 ni 2. Campo: input[data-telefono].
 */
(function () {
	'use strict';

	function formatear(valor) {
		var digitos = valor.replace(/\D/g, '').replace(/^[12]/, '').slice(0, 8);

		return digitos.length > 4 ? digitos.slice(0, 4) + ' ' + digitos.slice(4) : digitos;
	}

	document.addEventListener('input', function (evento) {
		if (evento.target.matches('[data-telefono]')) {
			evento.target.value = formatear(evento.target.value);
		}
	});
})();
