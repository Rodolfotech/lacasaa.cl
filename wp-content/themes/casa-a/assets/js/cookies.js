/**
 * Banner de cookies de lacasaa.cl.
 *
 * - Google Tag Manager y Microsoft Clarity no se cargan hasta que el visitante acepta.
 * - Se guarda la decisión con fecha y versión del texto: { decision, fecha, version }.
 * - Rechazar borra las cookies de analítica y, si ya estaban cargadas, recarga la página.
 * - El enlace [data-cookies-abrir] (footer) vuelve a mostrar el banner.
 */
(function () {
	'use strict';

	var CLAVE = 'casa_a_cookies';
	var banner = document.querySelector('[data-cookies]');

	if (!banner) {
		return;
	}

	var VERSION = banner.dataset.version;
	var analiticaCargada = false;

	function leer() {
		try {
			var dato = JSON.parse(window.localStorage.getItem(CLAVE));
			return dato && dato.version === VERSION ? dato : null;
		} catch (e) {
			return null;
		}
	}

	function guardar(decision) {
		try {
			window.localStorage.setItem(CLAVE, JSON.stringify({
				decision: decision,
				fecha: new Date().toISOString(),
				version: VERSION
			}));
		} catch (e) {
			// Sin almacenamiento disponible, el banner volverá a aparecer en la próxima visita.
		}
	}

	function cargarGTM(id) {
		window.dataLayer = window.dataLayer || [];
		window.dataLayer.push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });

		var script = document.createElement('script');
		script.async = true;
		script.src = 'https://www.googletagmanager.com/gtm.js?id=' + id;
		document.head.appendChild(script);
	}

	function cargarClarity(id) {
		window.clarity = window.clarity || function () {
			(window.clarity.q = window.clarity.q || []).push(arguments);
		};

		var script = document.createElement('script');
		script.async = true;
		script.src = 'https://www.clarity.ms/tag/' + id;
		document.head.appendChild(script);
	}

	function activarAnalitica() {
		if (analiticaCargada) {
			return;
		}

		analiticaCargada = true;
		cargarGTM(banner.dataset.gtm);
		cargarClarity(banner.dataset.clarity);
	}

	function borrarCookiesAnaliticas() {
		var patron = /^(_ga|_gid|_gat|_gcl_|_clck|_clsk|CLID|MUID|ANONCHK|SM$|_cl)/;
		var host = window.location.hostname;
		var dominios = ['', host, '.' + host];

		document.cookie.split(';').forEach(function (par) {
			var nombre = par.split('=')[0].trim();

			if (!patron.test(nombre)) {
				return;
			}

			dominios.forEach(function (dominio) {
				document.cookie = nombre + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/' + (dominio ? '; domain=' + dominio : '');
			});
		});
	}

	var estado = banner.querySelector('[data-cookies-estado]');

	// Muestra la decisión vigente para que el visitante la vea al volver a configurarla.
	function pintarEstado() {
		var dato = leer();

		if (!dato) {
			estado.hidden = true;
			return;
		}

		estado.textContent = dato.decision === 'aceptado'
			? 'Tu decisión actual: cookies de analítica aceptadas.'
			: 'Tu decisión actual: cookies de analítica rechazadas.';
		estado.hidden = false;
	}

	function mostrar() {
		banner.hidden = false;
	}

	function ocultar() {
		banner.hidden = true;
	}

	function aceptar() {
		guardar('aceptado');
		pintarEstado();
		ocultar();
		activarAnalitica();
	}

	function rechazar() {
		var previo = leer();
		var estabaAceptado = previo && previo.decision === 'aceptado';

		guardar('rechazado');
		pintarEstado();
		ocultar();
		borrarCookiesAnaliticas();

		if (estabaAceptado) {
			window.location.reload();
		}
	}

	var vigente = leer();

	pintarEstado();

	// La analítica sigue la última decisión guardada; el banner se muestra en cada visita hasta aceptar o rechazar.
	if (vigente && vigente.decision === 'aceptado') {
		activarAnalitica();
	}
	mostrar();

	banner.querySelector('[data-cookies-aceptar]').addEventListener('click', aceptar);
	banner.querySelector('[data-cookies-rechazar]').addEventListener('click', rechazar);

	document.addEventListener('click', function (evento) {
		if (evento.target.closest('[data-cookies-abrir]')) {
			evento.preventDefault();
			pintarEstado();
			mostrar();
			banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
			banner.querySelector('[data-cookies-aceptar]').focus();
		}
	});
})();
