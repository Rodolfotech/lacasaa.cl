/**
 * Mi reserva: muestra los productos guardados en el navegador, permite cambiar cantidades o quitar
 * productos, calcula el arriendo por día y envía la solicitud con los productos.
 * Usa la misma clave que "Mi selección" (casa_a_seleccion).
 */
(function () {
	'use strict';

	var CLAVE = 'casa_a_seleccion';
	var MAX_CANTIDAD = 99;
	var lista = document.querySelector('[data-reserva-lista]');
	var POR_PAGINA = 2;
	var paginaActual = 1;

	if (!lista) {
		return;
	}

	function leer() {
		try {
			var datos = JSON.parse(window.localStorage.getItem(CLAVE));
			return Array.isArray(datos) ? datos.filter(function (p) { return p && p.id && p.nombre; }) : [];
		} catch (e) {
			return [];
		}
	}

	function guardar(items) {
		try {
			window.localStorage.setItem(CLAVE, JSON.stringify(items));
		} catch (e) {
			// Sin almacenamiento disponible, los cambios no se conservan.
		}
	}

	function formato(numero) {
		return '$' + String(Math.round(numero)).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
	}

	function maximoPara(producto) {
		var stock = parseInt(producto.stock, 10);
		return isNaN(stock) ? MAX_CANTIDAD : Math.min(MAX_CANTIDAD, stock);
	}

	function filaProducto(producto) {
		var li = document.createElement('li');
		li.className = 'casa-a-reserva-item';

		var foto = document.createElement('div');
		foto.className = 'casa-a-reserva-foto';
		if (producto.imagen) {
			var img = document.createElement('img');
			img.src = producto.imagen;
			img.alt = '';
			foto.appendChild(img);
		}
		li.appendChild(foto);

		var info = document.createElement('div');
		info.className = 'casa-a-reserva-info';

		var codigo = document.createElement('p');
		codigo.className = 'casa-a-reserva-codigo';
		codigo.textContent = producto.codigo || '';
		info.appendChild(codigo);

		var nombre = document.createElement('h2');
		nombre.className = 'casa-a-reserva-nombre';
		nombre.textContent = producto.nombre;
		info.appendChild(nombre);

		var precio = document.createElement('p');
		precio.className = 'casa-a-reserva-precio';
		precio.textContent = formato(parseInt(producto.precio, 10) || 0) + ' / día';
		info.appendChild(precio);

		var controles = document.createElement('div');
		controles.className = 'casa-a-reserva-controles';

		var cantidad = producto.cantidad || 1;
		var maximo = maximoPara(producto);

		var menos = document.createElement('button');
		menos.type = 'button';
		menos.textContent = '−';
		menos.setAttribute('aria-label', 'Quitar una unidad');
		menos.dataset.accion = 'menos';
		menos.dataset.id = producto.id;
		menos.disabled = cantidad <= 1;

		var valor = document.createElement('span');
		valor.textContent = cantidad;

		var mas = document.createElement('button');
		mas.type = 'button';
		mas.textContent = '+';
		mas.setAttribute('aria-label', 'Agregar una unidad');
		mas.dataset.accion = 'mas';
		mas.dataset.id = producto.id;
		mas.disabled = cantidad >= maximo;

		var stock = document.createElement('span');
		stock.className = 'casa-a-reserva-stock';
		stock.textContent = isNaN(parseInt(producto.stock, 10)) ? '' : 'Stock: ' + producto.stock + (producto.stock === 1 ? ' unidad' : ' unidades');

		var quitar = document.createElement('button');
		quitar.type = 'button';
		quitar.className = 'casa-a-reserva-quitar';
		quitar.textContent = 'Quitar';
		quitar.dataset.accion = 'quitar';
		quitar.dataset.id = producto.id;

		var cajaCantidad = document.createElement('div');
		cajaCantidad.className = 'casa-a-reserva-cantidad';
		cajaCantidad.appendChild(menos);
		cajaCantidad.appendChild(valor);
		cajaCantidad.appendChild(mas);

		controles.appendChild(cajaCantidad);
		controles.appendChild(stock);
		controles.appendChild(quitar);
		info.appendChild(controles);
		li.appendChild(info);

		return li;
	}

	function pintar() {
		var items = leer();
		var total = items.reduce(function (suma, p) {
			return suma + (parseInt(p.precio, 10) || 0) * (p.cantidad || 1);
		}, 0);

		document.querySelector('[data-reserva-titulo]').textContent = 'Tu selección (' + items.length + ')';
		document.querySelector('[data-reserva-total]').textContent = formato(total);
		document.querySelector('[data-reserva-vacia]').hidden = items.length > 0;
		document.querySelector('[data-reserva-enviar]').disabled = items.length === 0;

		var paginas = window.casaAPaginacion.totalPaginas(items.length, POR_PAGINA);
		paginaActual = Math.min(paginaActual, paginas);

		lista.textContent = '';
		window.casaAPaginacion.paginar(items, paginaActual, POR_PAGINA).forEach(function (p) {
			lista.appendChild(filaProducto(p));
		});

		window.casaAPaginacion.renderizar(document.querySelector('[data-reserva-paginacion]'), {
			total: paginas,
			actual: paginaActual,
			onCambio: function (pagina) {
				paginaActual = pagina;
				pintar();
			}
		});

		var campoItems = document.querySelector('[data-reserva-items]');
		campoItems.value = JSON.stringify(items.map(function (p) {
			return { id: p.id, cantidad: p.cantidad || 1 };
		}));
	}

	function cambiar(id, accion) {
		var items = leer().reduce(function (nueva, p) {
			if (String(p.id) !== String(id)) {
				nueva.push(p);
				return nueva;
			}

			if (accion === 'quitar') {
				return nueva;
			}

			var cantidad = p.cantidad || 1;
			p.cantidad = accion === 'mas' ? Math.min(maximoPara(p), cantidad + 1) : Math.max(1, cantidad - 1);
			nueva.push(p);
			return nueva;
		}, []);

		guardar(items);
		pintar();
	}

	lista.addEventListener('click', function (evento) {
		var boton = evento.target.closest('[data-accion]');
		if (boton) {
			cambiar(boton.dataset.id, boton.dataset.accion);
		}
	});

	var formulario = document.querySelector('[data-reserva-form]');
	formulario.addEventListener('submit', function (evento) {
		var inicio = formulario.fecha_retiro.value;
		var fin = formulario.fecha_devolucion.value;

		if (leer().length === 0) {
			evento.preventDefault();
			return;
		}

		if (fin < inicio) {
			evento.preventDefault();
			formulario.fecha_devolucion.setCustomValidity('La fecha de devolución no puede ser anterior a la de retiro.');
			formulario.fecha_devolucion.reportValidity();
			return;
		}

		formulario.fecha_devolucion.setCustomValidity('');
		pintar();
	});

	// Tras una solicitud enviada con éxito, la reserva se vacía.
	var parametros = new URLSearchParams(window.location.search);
	if (parametros.get('casa_a_cotizacion') === 'ok') {
		guardar([]);
	}

	pintar();
})();
