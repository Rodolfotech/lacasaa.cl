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
		quitar.innerHTML = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13"/></svg>';
		quitar.setAttribute('aria-label', 'Quitar ' + producto.nombre);
		quitar.dataset.accion = 'quitar';
		quitar.dataset.id = producto.id;

		var cajaCantidad = document.createElement('div');
		cajaCantidad.className = 'casa-a-reserva-cantidad';
		cajaCantidad.appendChild(menos);
		cajaCantidad.appendChild(valor);
		cajaCantidad.appendChild(mas);

		controles.appendChild(cajaCantidad);
		controles.appendChild(stock);
		info.appendChild(controles);
		li.appendChild(info);
		li.appendChild(quitar);

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
		actualizarFormulario();
		if (items.length === 0) {
			mostrarSinProductos();
		}
	}

	/**
	 * Modal de confirmación (mismo diseño y textos de botón que el del panel de galería).
	 * Devuelve una promesa que se resuelve en true (Aceptar) o false (Cancelar, Esc o clic fuera).
	 */
	function confirmar(titulo, mensaje) {
		return new Promise(function (resolver) {
			var fondo = document.createElement('div');
			fondo.className = 'casa-a-confirm-fondo';

			var caja = document.createElement('div');
			caja.className = 'casa-a-confirm';
			caja.setAttribute('role', 'alertdialog');
			caja.setAttribute('aria-modal', 'true');

			var encabezado = document.createElement('h3');
			encabezado.className = 'casa-a-confirm-titulo';
			encabezado.textContent = titulo;

			var texto = document.createElement('p');
			texto.className = 'casa-a-confirm-mensaje';
			texto.textContent = mensaje;

			var acciones = document.createElement('div');
			acciones.className = 'casa-a-confirm-acciones';

			var cancelar = document.createElement('button');
			cancelar.type = 'button';
			cancelar.className = 'casa-a-confirm-cancelar';
			cancelar.textContent = 'Cancelar';

			var aceptar = document.createElement('button');
			aceptar.type = 'button';
			aceptar.className = 'casa-a-confirm-aceptar';
			aceptar.textContent = 'Aceptar';

			function cerrar(resultado) {
				document.removeEventListener('keydown', alTeclear);
				fondo.remove();
				resolver(resultado);
			}

			function alTeclear(e) {
				if (e.key === 'Escape') cerrar(false);
			}

			cancelar.addEventListener('click', function () { cerrar(false); });
			aceptar.addEventListener('click', function () { cerrar(true); });
			fondo.addEventListener('click', function (e) {
				if (e.target === fondo) cerrar(false);
			});
			document.addEventListener('keydown', alTeclear);

			acciones.appendChild(cancelar);
			acciones.appendChild(aceptar);
			caja.appendChild(encabezado);
			caja.appendChild(texto);
			caja.appendChild(acciones);
			fondo.appendChild(caja);
			document.body.appendChild(fondo);
			aceptar.focus();
		});
	}

	lista.addEventListener('click', function (evento) {
		var boton = evento.target.closest('[data-accion]');
		if (!boton) {
			return;
		}

		if (boton.dataset.accion === 'quitar') {
			confirmar('¿Estás seguro?', 'El producto se eliminará de tu selección.').then(function (ok) {
				if (ok) {
					cambiar(boton.dataset.id, 'quitar');
				}
			});
			return;
		}

		cambiar(boton.dataset.id, boton.dataset.accion);
	});

	var formulario = document.querySelector('[data-reserva-form]');
	var errorEl = document.querySelector('[data-reserva-error]');

	// Espera tras enviar: se recuerda en el navegador para bloquear el botón también al recargar.
	var CLAVE_ESPERA = 'casa_a_reserva_espera_hasta';
	var botonEnviar = formulario.querySelector('[data-reserva-enviar]');
	var temporizadorEspera = null;

	function guardarEspera(segundos) {
		try { localStorage.setItem(CLAVE_ESPERA, String(Date.now() + segundos * 1000)); } catch (e) {}
	}

	function segundosDeEspera() {
		var hasta = 0;
		try { hasta = parseInt(localStorage.getItem(CLAVE_ESPERA), 10) || 0; } catch (e) {}
		return Math.max(0, Math.ceil((hasta - Date.now()) / 1000));
	}

	function enEspera() {
		return segundosDeEspera() > 0;
	}

	// Sin productos en la reserva no se puede completar el formulario: se deshabilitan los campos y se avisa.
	function actualizarFormulario() {
		var vacio = leer().length === 0;

		Array.prototype.forEach.call(formulario.querySelectorAll('input, textarea, select, button'), function (control) {
			if (control.type !== 'hidden') {
				control.disabled = vacio;
			}
		});

	}

	// Aviso en modal: sin productos no se puede completar la solicitud.
	function mostrarSinProductos() {
		if (!window.casaAModal || modalAbierto()) {
			return;
		}
		window.casaAModal.abrir('Debes seleccionar al menos un producto.', 'espera');
	}

	function textoEspera() {
		var segundos = segundosDeEspera();
		var minutos = Math.floor(segundos / 60);
		var resto = segundos % 60;
		return 'Acabas de enviar tu solicitud. Para evitar envíos repetidos, puedes enviar otra en ' + minutos + ':' + (resto < 10 ? '0' : '') + resto + '. Si necesitas algo urgente, escríbenos a hola@lacasaa.cl.';
	}

	function modalAbierto() {
		var modal = document.querySelector('.casa-a-aviso-modal');
		return !!modal && !modal.hidden;
	}

	// Contador inverso: actualiza el modal cada segundo mientras esté abierto y lo cierra al terminar.
	function actualizarEspera() {
		if (segundosDeEspera() <= 0) {
			if (temporizadorEspera) {
				clearInterval(temporizadorEspera);
				temporizadorEspera = null;
			}
			if (modalAbierto() && window.casaAModal) {
				window.casaAModal.cerrar();
			}
			return;
		}

		if (modalAbierto()) {
			var texto = document.querySelector('[data-aviso-texto]');
			if (texto) {
				texto.textContent = textoEspera();
			}
		}

		if (!temporizadorEspera) {
			temporizadorEspera = setInterval(actualizarEspera, 1000);
		}
	}


	// Tras una solicitud enviada con éxito, la reserva y los datos del formulario se vacían.
	var parametros = new URLSearchParams(window.location.search);
	var CLAVE_FORMULARIO = 'casa_a_reserva_formulario';
	var estado = parametros.get('casa_a_cotizacion');
	// Aviso de espera: se muestra en el modal (texto negro con X), nunca en línea.
	function mostrarAvisoEspera() {
		if (segundosDeEspera() <= 0 || !window.casaAModal) {
			return;
		}
		window.casaAModal.abrir(textoEspera(), 'espera');
		actualizarEspera();
	}

	var avisoEsperaPendiente = false;
	document.addEventListener('casaa:aviso-cerrado', function () {
		if (avisoEsperaPendiente) {
			avisoEsperaPendiente = false;
			mostrarAvisoEspera();
		}
	});

	if (estado === 'ok') {
		guardar([]);
		try { sessionStorage.removeItem(CLAVE_FORMULARIO); } catch (e) {}
		guardarEspera(5 * 60);
		avisoEsperaPendiente = true;
	}

	if (estado === 'espera') {
		guardarEspera(parseInt(parametros.get('casa_a_restante'), 10) || 300);
		window.addEventListener('load', mostrarAvisoEspera);
	}

	if (!estado && enEspera()) {
		window.addEventListener('load', mostrarAvisoEspera);
	}

	// Se quita el resultado de la dirección: al recargar, el modal o el aviso no deben volver a aparecer.
	if (estado === 'ok' || estado === 'espera') {
		window.history.replaceState({}, '', window.location.pathname + window.location.hash);
	}

	// Datos del formulario: se guardan en el navegador para no perderlos si la solicitud falla.
	var campos = Array.prototype.filter.call(formulario.elements, function (campo) {
		return campo.name && campo.type !== 'hidden' && campo.type !== 'submit' && campo.name !== 'prefijo' && campo.name !== 'sitio_web';
	});

	function guardarFormulario() {
		var datos = {};
		campos.forEach(function (campo) {
			datos[campo.name] = campo.type === 'checkbox' ? campo.checked : campo.value;
		});
		try { sessionStorage.setItem(CLAVE_FORMULARIO, JSON.stringify(datos)); } catch (e) {}
	}

	function restaurarFormulario() {
		var datos = null;
		try { datos = JSON.parse(sessionStorage.getItem(CLAVE_FORMULARIO) || 'null'); } catch (e) {}
		if (!datos) {
			return;
		}
		campos.forEach(function (campo) {
			if (!(campo.name in datos)) {
				return;
			}
			if (campo.type === 'checkbox') {
				campo.checked = !!datos[campo.name];
			} else {
				campo.value = datos[campo.name];
			}
		});
	}

	if (estado !== 'ok') {
		restaurarFormulario();
	}


	var MENSAJES = {
		nombre: { vacio: 'Ingresa tu nombre.', formato: 'El nombre debe tener entre 3 y 25 caracteres.' },
		email: { vacio: 'Ingresa tu correo.', formato: 'Ingresa un correo válido.' },
		telefono: { vacio: 'Ingresa tu teléfono.', formato: 'Ingresa un teléfono válido de 8 dígitos (sin el +56 9).' },
		nombre_proyecto: { vacio: 'Ingresa el nombre del proyecto.', formato: 'El nombre del proyecto puede tener hasta 25 caracteres.' },
		fecha_retiro: { vacio: 'Selecciona la fecha de retiro.', formato: 'Ingresa una fecha de retiro válida.' },
		fecha_devolucion: { vacio: 'Selecciona la fecha de devolución.', formato: 'Ingresa una fecha de devolución válida.' },
		comentarios: { vacio: 'Escribe tu mensaje.', formato: 'El mensaje puede tener hasta 2000 caracteres.' },
		condiciones: { vacio: 'Debes aceptar las condiciones de arriendo.', formato: 'Debes aceptar las condiciones de arriendo.' },
		privacidad: { vacio: 'Debes aceptar la Política de Privacidad.', formato: 'Debes aceptar la Política de Privacidad.' }
	};

	// Antes de enviar: espera activa, reserva vacía y orden de fechas.
	function antesDeEnviar() {
		if (enEspera()) {
			mostrarAvisoEspera();
			return false;
		}

		if (leer().length === 0) {
			return false;
		}

		var inicio = formulario.fecha_retiro.value;
		var fin = formulario.fecha_devolucion.value;
		formulario.fecha_devolucion.setCustomValidity(inicio && fin && fin < inicio ? 'La fecha de devolución no puede ser anterior a la de retiro.' : '');
		pintar();
		return true;
	}

	// Los datos se guardan mientras el usuario escribe: un error o una recarga nunca borra lo escrito.
	formulario.addEventListener('input', guardarFormulario);
	formulario.addEventListener('change', guardarFormulario);

	casaAValidacion.inicializar(formulario, campos, MENSAJES, antesDeEnviar);

	if (estado === 'error') {
		casaAValidacion.mostrarServidor(formulario, campos, MENSAJES);
	}

	actualizarFormulario();
	actualizarEspera();
	pintar();

	// Al cargar sin productos, y tras una vista previa, se avisa en el modal (no tras un envío o una espera).
	window.addEventListener('load', function () {
		if (!estado && leer().length === 0 && !enEspera()) {
			mostrarSinProductos();
		}
	});

	// Clic en el formulario bloqueado (sin productos): se vuelve a mostrar el aviso.
	formulario.parentNode.addEventListener('click', function () {
		if (leer().length === 0) {
			mostrarSinProductos();
		}
	});
})();
