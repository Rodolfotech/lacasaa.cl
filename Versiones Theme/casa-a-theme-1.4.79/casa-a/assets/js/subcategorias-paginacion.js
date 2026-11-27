/**
 * Catálogo: cada subcategoría muestra 6 productos por página, con el paginador compartido
 * (assets/js/paginacion.js). Usa window.casaAPaginacion.
 */
(function () {
	'use strict';

	var POR_PAGINA = 6;

	function paginarGrupo(contenedor) {
		var items = Array.prototype.slice.call(contenedor.querySelectorAll(':scope > .casa-a-producto'));

		if (items.length <= POR_PAGINA) {
			return;
		}

		var nav = document.createElement('div');
		nav.className = 'casa-a-paginacion';
		contenedor.parentNode.insertBefore(nav, contenedor.nextSibling);

		function mostrar(pagina) {
			var visibles = window.casaAPaginacion.paginar(items, pagina, POR_PAGINA);

			items.forEach(function (item) {
				item.hidden = visibles.indexOf(item) === -1;
			});

			window.casaAPaginacion.renderizar(nav, {
				total: window.casaAPaginacion.totalPaginas(items.length, POR_PAGINA),
				actual: pagina,
				onCambio: mostrar
			});
		}

		mostrar(1);
	}

	function iniciar() {
		if (!window.casaAPaginacion) {
			return;
		}

		document.querySelectorAll('.casa-a-catalogo-grupo .casa-a-productos').forEach(paginarGrupo);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', iniciar);
	} else {
		iniciar();
	}
})();
