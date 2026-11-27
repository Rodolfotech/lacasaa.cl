/**
 * Paginación reutilizable (sin dependencias).
 *
 *   window.casaAPaginacion.totalPaginas(cantidad, porPagina)
 *   window.casaAPaginacion.paginar(lista, pagina, porPagina)  -> elementos de esa página
 *   window.casaAPaginacion.renderizar(contenedor, { total, actual, onCambio })
 *
 * `renderizar` dibuja ‹ 1 2 3 › dentro de `contenedor` y llama a onCambio(pagina) al elegir una.
 * Si hay una sola página, el contenedor queda oculto.
 */
(function () {
	'use strict';

	function totalPaginas(cantidad, porPagina) {
		return Math.max(1, Math.ceil(cantidad / porPagina));
	}

	function paginar(lista, pagina, porPagina) {
		var inicio = (pagina - 1) * porPagina;
		return lista.slice(inicio, inicio + porPagina);
	}

	function boton(texto, etiqueta, deshabilitado, activo, alHacerClic) {
		var b = document.createElement('button');
		b.type = 'button';
		b.textContent = texto;
		b.setAttribute('aria-label', etiqueta);
		b.disabled = deshabilitado;
		if (activo) {
			b.setAttribute('aria-current', 'page');
			b.classList.add('is-active');
		}
		b.addEventListener('click', alHacerClic);
		return b;
	}

	function renderizar(contenedor, opciones) {
		var total = opciones.total;
		var actual = opciones.actual;
		var cambiar = opciones.onCambio;

		contenedor.textContent = '';
		contenedor.hidden = total <= 1;

		if (total <= 1) {
			return;
		}

		var nav = document.createElement('nav');
		nav.setAttribute('aria-label', 'Paginación');
		nav.className = 'casa-a-paginacion-lista';

		nav.appendChild(boton('‹', 'Página anterior', actual === 1, false, function () {
			cambiar(actual - 1);
		}));

		for (var i = 1; i <= total; i++) {
			(function (pagina) {
				nav.appendChild(boton(String(pagina), 'Página ' + pagina, false, pagina === actual, function () {
					cambiar(pagina);
				}));
			})(i);
		}

		nav.appendChild(boton('›', 'Página siguiente', actual === total, false, function () {
			cambiar(actual + 1);
		}));

		contenedor.appendChild(nav);
	}

	window.casaAPaginacion = {
		totalPaginas: totalPaginas,
		paginar: paginar,
		renderizar: renderizar
	};
})();
