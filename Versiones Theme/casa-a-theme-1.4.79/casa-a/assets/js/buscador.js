/**
 * Buscador del navbar: sugerencias de categorías (con productos) y de productos mientras se escribe.
 * Endpoint: data-endpoint del contenedor [data-sugerencias] (REST casa-a/v1/sugerencias).
 */
(function () {
	'use strict';

	var campo = document.getElementById('casa-a-buscar');
	var panel = document.querySelector('[data-sugerencias]');

	if (!campo || !panel) {
		return;
	}

	var temporizador = null;
	var pedido = 0;

	function ocultar() {
		panel.hidden = true;
		panel.textContent = '';
	}

	function titulo(texto) {
		var encabezado = document.createElement('p');
		encabezado.className = 'casa-a-sugerencias-titulo';
		encabezado.textContent = texto;
		return encabezado;
	}

	function enlace(url, contenido) {
		var a = document.createElement('a');
		a.className = 'casa-a-sugerencia';
		a.href = url;
		contenido(a);
		return a;
	}

	function pintar(datos) {
		panel.textContent = '';

		if (!datos.categorias.length && !datos.productos.length) {
			panel.hidden = true;
			return;
		}

		if (datos.categorias.length) {
			panel.appendChild(titulo('Categorías'));
			datos.categorias.forEach(function (c) {
				panel.appendChild(enlace(c.url, function (a) {
					a.textContent = c.nombre;
				}));
			});
		}

		if (datos.productos.length) {
			panel.appendChild(titulo('Productos'));
			datos.productos.forEach(function (p) {
				panel.appendChild(enlace(p.url, function (a) {
					if (p.imagen) {
						var img = document.createElement('img');
						img.src = p.imagen;
						img.alt = '';
						img.width = 40;
						img.height = 40;
						a.appendChild(img);
					}

					var texto = document.createElement('span');
					var nombre = document.createElement('strong');
					nombre.textContent = p.nombre;
					var detalle = document.createElement('small');
					detalle.textContent = p.codigo + (p.precio ? ' · ' + p.precio : '');
					texto.appendChild(nombre);
					texto.appendChild(detalle);
					a.appendChild(texto);
				}));
			});
		}

		panel.hidden = false;
	}

	function buscar(q) {
		var actual = ++pedido;

		fetch(panel.dataset.endpoint + '?q=' + encodeURIComponent(q), { credentials: 'same-origin' })
			.then(function (respuesta) {
				return respuesta.ok ? respuesta.json() : null;
			})
			.then(function (datos) {
				if (actual === pedido && datos) {
					pintar(datos);
				}
			})
			.catch(ocultar);
	}

	campo.addEventListener('input', function () {
		var q = campo.value.trim();

		clearTimeout(temporizador);

		if (q.length < 2) {
			ocultar();
			return;
		}

		temporizador = setTimeout(function () {
			buscar(q);
		}, 200);
	});

	document.addEventListener('click', function (evento) {
		if (!evento.target.closest('.casa-a-buscador')) {
			ocultar();
		}
	});

	document.addEventListener('keydown', function (evento) {
		if (evento.key === 'Escape') {
			ocultar();
		}
	});
})();
