/**
 * Filtro del catálogo: cada categoría principal tiene un botón + que despliega sus subcategorías.
 */
(function () {
	'use strict';

	document.addEventListener('click', function (evento) {
		var boton = evento.target.closest('.casa-a-filtro-toggle');

		if (!boton) {
			return;
		}

		var grupo = boton.closest('.casa-a-filtro-grupo');
		var lista = grupo ? grupo.querySelector('.casa-a-chips') : null;

		if (!lista) {
			return;
		}

		var abierto = boton.getAttribute('aria-expanded') === 'true';
		boton.setAttribute('aria-expanded', abierto ? 'false' : 'true');
		boton.textContent = abierto ? '+' : '−';
		lista.hidden = abierto;
	});
})();
