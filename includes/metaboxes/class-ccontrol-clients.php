<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ccontrol
 * @subpackage Ccontrol/admin
 * @author     Robert Ochoa <ochoa.robert1@gmail.com>
 */
class Ccontrol_Metaboxes_Client
{
	private $plugin_name;
	private $version;

	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function ccontrol_metabox()
	{
		add_meta_box(
			'cc_clientes_metabox',
			__('Información del Cliente', 'ccontrol'),
			array($this, 'cc_clientes_main_metabox'),
			'cc_clientes'
		);
	}

	public function cc_clientes_main_metabox($post)
	{
		wp_nonce_field('ccontrol_metabox', 'ccontrol_metabox_nonce'); ?>
		<div class="postmeta-wrapper">
			<div class="postmeta-item-wrapper cc-col-2">
				<?php $value = get_post_meta($post->ID, 'nombre_cliente', true); ?>
				<label for="nombre_cliente">
					<?php _e('Persona de Contacto', 'ccontrol'); ?>
				</label>
				<input type="text" id="nombre_cliente" name="nombre_cliente" value="<?php echo esc_attr($value); ?>" size="40" />
			</div>

			<div class="postmeta-item-wrapper cc-col-2">
				<?php $value = get_post_meta($post->ID, 'correo_cliente', true); ?>
				<label for="correo_cliente">
					<?php _e('Correo Electrónico', 'ccontrol'); ?>
				</label>
				<input type="email" id="correo_cliente" name="correo_cliente" value="<?php echo esc_attr($value); ?>" size="40" />
			</div>

			<div class="postmeta-item-wrapper cc-col-2">
				<?php $value = get_post_meta($post->ID, 'telf_cliente', true); ?>
				<label for="telf_cliente">
					<?php _e('Teléfono', 'ccontrol'); ?>
				</label>
				<input type="tel" id="telf_cliente" name="telf_cliente" value="<?php echo esc_attr($value); ?>" size="40" />
			</div>

			<div class="postmeta-item-wrapper cc-col-2">
				<?php $value = get_post_meta($post->ID, 'tipo_cliente', true); ?>
				<label for="tipo_cliente">
					<?php _e('Tipo de Cliente', 'ccontrol'); ?>
				</label>
				<select name="tipo_cliente" id="tipo_cliente">
					<option value="" selected disabled><?php _e('Seleccione tipo de cliente', 'ccontrol'); ?></option>
					<option value="Potencial" <?php selected($value, 'Potencial'); ?>><?php _e('Potencial', 'ccontrol'); ?></option>
					<option value="Recurrente" <?php selected($value, 'Recurrente'); ?>><?php _e('Recurrente', 'ccontrol'); ?></option>
					<option value="Saliente" <?php selected($value, 'Saliente'); ?>><?php _e('Saliente', 'ccontrol'); ?></option>
				</select>
			</div>

			<div class="postmeta-item-wrapper cc-col-12">
				<?php $value = get_post_meta($post->ID, 'direccion_cliente', true); ?>
				<label for="direccion_cliente">
					<?php _e('Direccion del Cliente (Usado para facturación)', 'ccontrol'); ?>
				</label>
				<textarea name="direccion_cliente" id="direccion_cliente" cols="30" rows="5"><?php echo esc_attr($value); ?></textarea>
			</div>
		</div>
<?php
	}

	public function cc_clientes_save_metabox($post_id)
	{
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		if (!isset($_POST['ccontrol_metabox_nonce'])) {
			return $post_id;
		}

		$nonce = $_POST['ccontrol_metabox_nonce'];

		if (!wp_verify_nonce($nonce, 'ccontrol_metabox')) {
			return $post_id;
		}

		if (isset($_POST['nombre_cliente'])) {
			$nombre_cliente = sanitize_text_field($_POST['nombre_cliente']);
			update_post_meta($post_id, 'nombre_cliente', $nombre_cliente);
		}

		if (isset($_POST['correo_cliente'])) {
			$correo_cliente = sanitize_text_field($_POST['correo_cliente']);
			update_post_meta($post_id, 'correo_cliente', $correo_cliente);
		}

		if (isset($_POST['telf_cliente'])) {
			$telf_cliente = sanitize_text_field($_POST['telf_cliente']);
			update_post_meta($post_id, 'telf_cliente', $telf_cliente);
		}

		if (isset($_POST['tipo_cliente'])) {
			$tipo_cliente = sanitize_text_field($_POST['tipo_cliente']);
			update_post_meta($post_id, 'tipo_cliente', $tipo_cliente);
		}

		if (isset($_POST['direccion_cliente'])) {
			$tipo_cliente = sanitize_text_field($_POST['direccion_cliente']);
			update_post_meta($post_id, 'direccion_cliente', $tipo_cliente);
		}
	}
}
