<?php
/**
 * Template Name: Condiciones de arriendo
 *
 * Condiciones de arriendo en acordeón (componente .casa-a-politica).
 * Usa esta plantilla en la página con slug "condiciones-de-arriendo".
 *
 * @package CASA_A
 */

get_header();

$casa_a_condiciones = array(
	array(
		__( '1. Valores', 'casa-a' ),
		__( 'Los valores publicados en nuestra página web corresponden al arriendo por día y por jornada de trabajo.', 'casa-a' ),
	),
	array(
		__( '2. Garantía', 'casa-a' ),
		__( 'Cada arriendo estará sujeto a una garantía, cuyo monto será informado al momento de la cotización. Esta será devuelta una vez recibido y revisado el material arrendado, siempre que se encuentre en las mismas condiciones en que fue entregado.', 'casa-a' ),
	),
	array(
		__( '3. Daños', 'casa-a' ),
		__( 'En caso de daños, se cobrará un monto proporcional al deterioro, correspondiente al costo de reparación o recuperación del elemento.', 'casa-a' ),
	),
	array(
		__( '4. Pérdida o daño irreparable', 'casa-a' ),
		__( 'En caso de pérdida total, robo o daño que impida la recuperación del producto, se cobrará su valor de reposición.', 'casa-a' ),
	),
	array(
		__( '5. Responsabilidad', 'casa-a' ),
		__( 'El cliente será responsable de los elementos arrendados durante todo el período de arriendo, desde su entrega hasta su devolución.', 'casa-a' ),
	),
	array(
		__( '6. Devoluciones', 'casa-a' ),
		__( 'Los elementos deberán ser devueltos en las mismas condiciones en que fueron entregados, considerando su desgaste normal por uso.', 'casa-a' ),
	),
	array(
		__( '7. Retiros y devoluciones', 'casa-a' ),
		__( 'Los retiros y devoluciones deberán realizarse dentro de los horarios establecidos por lacasaa.cl. Cualquier solicitud fuera de estos horarios o días estará sujeta a disponibilidad del equipo y podrá tener un cobro adicional por concepto de horas extraordinarias, previamente informado al cliente.', 'casa-a' ),
	),
);
?>
<main class="casa-a-main casa-a-arrendar">
	<div class="casa-a-wrap">
		<header class="casa-a-galeria-cabecera">
			<p class="casa-a-etiqueta"><?php esc_html_e( 'Antes de arrendar', 'casa-a' ); ?></p>
			<h1 class="casa-a-catalogo-titulo"><?php esc_html_e( 'Condiciones de arriendo', 'casa-a' ); ?></h1>
		</header>

		<section class="casa-a-politicas" aria-label="<?php esc_attr_e( 'Condiciones de arriendo', 'casa-a' ); ?>">
			<?php foreach ( $casa_a_condiciones as $indice => $condicion ) : ?>
				<details class="casa-a-politica"<?php echo 0 === $indice ? ' open' : ''; ?>>
					<summary><?php echo esc_html( $condicion[0] ); ?></summary>
					<p><?php echo esc_html( $condicion[1] ); ?></p>
				</details>
			<?php endforeach; ?>
		</section>
	</div>
</main>
<?php
get_footer();
