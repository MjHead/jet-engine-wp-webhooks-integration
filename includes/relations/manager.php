<?php
namespace Jet_Engine_WPWH\Relations;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Manager {

	public function __construct() {
		add_action( 'wpwhpro/admin/webhooks/webhook_data', array( $this, 'maybe_add_relations_data' ), 10, 5 );
	}

	public function maybe_add_relations_data( $data, $response, $webhook, $args, $authentication_data ) {

		if ( ! empty( $webhook['webhook_name'] ) ) {

			$name = str_replace( ' ' , '_', ucwords( str_replace( '_', ' ', $webhook['webhook_name'] ) ) );
			$class_name = __NAMESPACE__ . '\\Hooks\\' . $name;

			if ( class_exists( $class_name ) ) {
				$instance = new $class_name( $data );
				$data = $instance->get_prepared_data();
			}
		}

		return $data;
	}

}
