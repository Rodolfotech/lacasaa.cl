<?php
/**
 * Template Name: Política de privacidad
 *
 * Política de tratamiento de datos personales (Ley 21.719, art. 14 ter).
 * Usa esta plantilla en la página con slug "politica-de-privacidad".
 * Versión y fecha: cambiar aquí cuando se modifique el texto.
 *
 * @package CASA_A
 */

get_header();

$casa_a_version = '1.0';
$casa_a_fecha   = '23 de noviembre de 2026';
?>
<main class="casa-a-main casa-a-legal">
	<div class="casa-a-wrap">
		<header class="casa-a-galeria-cabecera">
			<p class="casa-a-etiqueta"><?php esc_html_e( 'Legal', 'casa-a' ); ?></p>
			<h1 class="casa-a-catalogo-titulo"><?php esc_html_e( 'Política de privacidad', 'casa-a' ); ?></h1>
			<p class="casa-a-legal-version">
				<?php echo esc_html( sprintf( __( 'Versión %1$s · Fecha: %2$s', 'casa-a' ), $casa_a_version, $casa_a_fecha ) ); ?>
			</p>
		</header>

		<article class="casa-a-legal-texto">

			<h2>1. Responsable del tratamiento</h2>
			<p>El responsable del tratamiento de tus datos personales es <strong>[POR COMPLETAR: razón social]</strong>, RUT <strong>[POR COMPLETAR: RUT]</strong>, con domicilio en <strong>Padre Orellana 1957, Santiago, Chile</strong>, en adelante "lacasaa.cl".</p>
			<p>Encargado de prevención de datos: <strong>[POR COMPLETAR, si existe]</strong>.</p>

			<h2>2. Canales de contacto</h2>
			<p>Para ejercer tus derechos o hacer consultas sobre esta política puedes escribir a <a href="mailto:hola@lacasaa.cl">hola@lacasaa.cl</a> o usar el <a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>">formulario de contacto</a>.</p>

			<h2>3. Qué datos tratamos</h2>
			<ul>
				<li><strong>Datos de contacto y de solicitud:</strong> nombre, RUT, correo electrónico, teléfono, nombre de la productora, fechas de retiro y devolución, y el contenido de tu mensaje o de tu solicitud de cotización.</li>
				<li><strong>Datos de navegación:</strong> información sobre cómo usas el sitio (páginas visitadas, clics, tiempo de navegación, dispositivo y navegador), que recogemos solo si aceptas las cookies de analítica.</li>
			</ul>
			<p>No tratamos datos personales sensibles. Te pedimos no adjuntar ni escribir datos sensibles, como tu cédula de identidad, en los formularios.</p>

			<h2>4. Para qué usamos tus datos y base legal</h2>
			<ul>
				<li><strong>Responder consultas y gestionar cotizaciones de arriendo:</strong> porque es necesario para tu solicitud y para la ejecución de un eventual contrato de arriendo.</li>
				<li><strong>Enviar la cotización y coordinar el retiro y la devolución de los productos:</strong> ejecución del contrato.</li>
				<li><strong>Cumplir obligaciones legales</strong>, como las tributarias y contables, cuando corresponda.</li>
				<li><strong>Entender cómo se usa el sitio y mejorarlo:</strong> solo con tu consentimiento, mediante las cookies de analítica (ver punto 7).</li>
			</ul>

			<h2>5. Destinatarios y encargados</h2>
			<p>Tus datos pueden ser tratados por proveedores que nos prestan servicios, como alojamiento web, correo electrónico y analítica. Estos proveedores actúan por cuenta nuestra y solo pueden usar los datos para prestarnos el servicio. Los datos de la analítica los tratan Microsoft (Clarity) y Google (Analytics, a través de Google Tag Manager).</p>
			<p>No vendemos ni cedemos tus datos a terceros para fines comerciales.</p>

			<h2>6. Transferencias internacionales</h2>
			<p>Algunos de los proveedores de analítica tratan los datos fuera de Chile, en servidores que pueden estar en Estados Unidos u otros países. Antes de transferir datos verificamos las garantías que ofrece cada proveedor. <strong>[POR COMPLETAR: detalle de las garantías contractuales de cada proveedor].</strong></p>

			<h2>7. Cookies</h2>
			<p>Usamos cookies y tecnologías similares. Las cookies de analítica solo se cargan si las aceptas en el banner. Puedes cambiar tu decisión en cualquier momento con el enlace "Configurar cookies" del pie de página.</p>
			<ul>
				<li><strong>Google Tag Manager y Google Analytics</strong> (por ejemplo, <code>_ga</code>, <code>_gid</code>): miden visitas y uso de las páginas.</li>
				<li><strong>Microsoft Clarity</strong> (por ejemplo, <code>_clck</code>, <code>_clsk</code>): registra cómo navegan los visitantes para mejorar el sitio.</li>
			</ul>

			<h2>8. Plazo de conservación</h2>
			<p>Conservamos los datos de tu solicitud o consulta por el tiempo necesario para responderla y gestionar el arriendo, y luego los suprimimos o los anonimizamos. Los datos de analítica se conservan según el plazo que aplique a cada proveedor. <strong>[POR COMPLETAR: plazos específicos].</strong></p>

			<h2>9. Medidas de seguridad</h2>
			<p>Aplicamos medidas técnicas y organizativas razonables para proteger tus datos contra el acceso, la pérdida o la alteración no autorizados. Solo el personal que lo necesita para su trabajo tiene acceso a ellos.</p>

			<h2>10. Tus derechos</h2>
			<p>Como titular de datos personales puedes:</p>
			<ul>
				<li><strong>Acceder</strong> a tus datos y saber qué tratamos.</li>
				<li><strong>Rectificar</strong> los datos inexactos, desactualizados o incompletos.</li>
				<li><strong>Suprimir</strong> tus datos cuando proceda legalmente.</li>
				<li><strong>Oponerte</strong> a determinados tratamientos.</li>
				<li><strong>Portabilidad:</strong> recibir una copia de tus datos en un formato electrónico estructurado y de uso común.</li>
				<li><strong>Bloqueo:</strong> suspender temporalmente el tratamiento mientras se resuelve una solicitud de rectificación, supresión u oposición.</li>
				<li><strong>Retirar tu consentimiento</strong> en cualquier momento, sin que ello afecte la licitud del tratamiento realizado antes de su retiro.</li>
			</ul>
			<p>Para ejercerlos, escribe a <a href="mailto:hola@lacasaa.cl">hola@lacasaa.cl</a> indicando tu nombre, la forma de contactarte y el derecho que quieres ejercer. Te responderemos en un plazo de 30 días corridos desde la recepción de tu solicitud. El ejercicio de los derechos de rectificación, supresión y oposición es gratuito.</p>
			<p>Si no estás conforme con nuestra respuesta, o si no respondemos en plazo, puedes presentar una reclamación ante la <strong>Agencia de Protección de Datos Personales</strong>.</p>

			<h2>11. Cambios en esta política</h2>
			<p>Podemos actualizar esta política. Cada versión indica su fecha. Si la modificación afecta el tratamiento de tus datos, te lo informaremos y, cuando la ley lo exija, te pediremos nuevamente tu consentimiento.</p>

		</article>
	</div>
</main>
<?php
get_footer();
