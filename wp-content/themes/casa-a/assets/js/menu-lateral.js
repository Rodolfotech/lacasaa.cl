/**
 * Menú lateral: se abre con la hamburguesa o el logo. En computadores con mouse se abre al pasar
 * el mouse por ellos y se mantiene abierto mientras el cursor esté sobre el navbar o el menú.
 * Se cierra al salir de esas zonas, con la X, con clic fuera del menú o con Escape.
 */
(function () {
	'use strict';

	var boton = document.querySelector('.casa-a-menu-toggle');
	var menu = document.getElementById('casa-a-menu-lateral');
	var fondo = document.querySelector('.casa-a-menu-fondo');
	var logo = document.querySelector('.casa-a-logo');
	var header = document.querySelector('.casa-a-header');

	if (!boton || !menu || !fondo) {
		return;
	}

	var temporizador = null;
	var pasoMouse = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

	function abrir(conFoco) {
		if (menu.classList.contains('is-open')) {
			return;
		}

		if (header) {
			menu.style.top = Math.max(0, header.getBoundingClientRect().bottom) + 'px';
			header.classList.add('is-forzado');
		}

		menu.hidden = false;
		fondo.hidden = false;
		requestAnimationFrame(function () {
			menu.classList.add('is-open');
			fondo.classList.add('is-open');
		});
		boton.setAttribute('aria-expanded', 'true');
		document.body.classList.add('casa-a-menu-abierto');

		if (conFoco) {
			menu.querySelector('.casa-a-menu-cerrar').focus();
		}
	}

	function cerrar() {
		menu.classList.remove('is-open');
		fondo.classList.remove('is-open');
		boton.setAttribute('aria-expanded', 'false');
		document.body.classList.remove('casa-a-menu-abierto');
		volverGrupos();

		if (header) {
			header.classList.remove('is-forzado');
		}

		window.setTimeout(function () {
			if (!menu.classList.contains('is-open')) {
				menu.hidden = true;
				fondo.hidden = true;
			}
		}, 300);
	}

	function cancelarCierre() {
		window.clearTimeout(temporizador);
	}

	function programarCierre() {
		cancelarCierre();
		temporizador = window.setTimeout(cerrar, 300);
	}

	// Categorías: al pulsar una, el menú muestra solo sus subcategorías; "‹" vuelve a la lista.
	var lista = menu.querySelector('.casa-a-menu-lista');
	var grupos = Array.prototype.slice.call(menu.querySelectorAll('[data-menu-grupo]'));
	var otrosElementos = lista ? Array.prototype.slice.call(lista.children).filter(function (el) {
		return !el.hasAttribute('data-menu-grupo') && !el.classList.contains('casa-a-menu-ver-todo');
	}) : [];

	function abrirGrupo(grupo) {
		grupos.forEach(function (g) {
			g.hidden = g !== grupo;
		});
		otrosElementos.forEach(function (el) {
			el.hidden = true;
		});
		grupo.querySelector('[data-menu-abrir]').hidden = true;
		grupo.querySelector('[data-menu-subs]').hidden = false;
	}

	function volverGrupos() {
		grupos.forEach(function (g) {
			g.hidden = false;
			g.querySelector('[data-menu-abrir]').hidden = false;
			g.querySelector('[data-menu-abrir]').setAttribute('aria-expanded', 'false');
			g.querySelector('[data-menu-subs]').hidden = true;
		});
		otrosElementos.forEach(function (el) {
			el.hidden = false;
		});
	}

	menu.addEventListener('click', function (evento) {
		var abrirBoton = evento.target.closest('[data-menu-abrir]');
		if (abrirBoton) {
			abrirGrupo(abrirBoton.closest('[data-menu-grupo]'));
			return;
		}
		if (evento.target.closest('[data-menu-volver]')) {
			volverGrupos();
		}
	});

	boton.addEventListener('click', function () {
		cancelarCierre();
		abrir(true);
	});

	if (pasoMouse) {
		[boton, logo].forEach(function (elemento) {
			if (!elemento) {
				return;
			}

			elemento.addEventListener('mouseenter', function () {
				cancelarCierre();
				abrir(false);
			});
			elemento.addEventListener('mouseleave', programarCierre);
		});

		if (header) {
			header.addEventListener('mouseenter', cancelarCierre);
			header.addEventListener('mouseleave', programarCierre);
		}

		menu.addEventListener('mouseenter', cancelarCierre);
		menu.addEventListener('mouseleave', programarCierre);
	}

	document.addEventListener('click', function (evento) {
		if (evento.target.closest('[data-menu-cerrar]')) {
			cerrar();
			boton.focus();
			return;
		}

		if (menu.classList.contains('is-open') && !evento.target.closest('#casa-a-menu-lateral, .casa-a-menu-toggle, .casa-a-logo')) {
			cerrar();
		}
	});

	document.addEventListener('keydown', function (evento) {
		if (evento.key === 'Escape' && menu.classList.contains('is-open')) {
			cerrar();
		}
	});
})();
