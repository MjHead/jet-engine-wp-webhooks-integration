<?php
namespace Jet_Engine_WPWH\Relations;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Manager {

	private $processed_hook = null;

	public function __construct() {
		add_filter( 'wpwhpro/admin/webhooks/webhook_data', array( $this, 'maybe_add_send_data' ), 10, 5 );
		add_filter( 'wpwhpro/webhooks/add_webhook_actions', array( $this, 'maybe_add_retrieve_data' ), 10, 2 );
	}

	public function maybe_add_retrieve_data( $return_data, $action ) {

		if ( $action ) {

			$class_name = $this->get_class_name( $action );

			if ( class_exists( $class_name ) ) {
				$this->processed_hook = $class_name;
				add_filter( 'wpwhpro/webhooks/response_json_arguments', array( $this, 'add_send_data' ) );
			}
		}

		return $return_data;
	}

	public function maybe_add_send_data( $data, $response, $webhook, $args, $authentication_data ) {

		if ( ! empty( $webhook['webhook_name'] ) ) {

			$class_name = $this->get_class_name( $webhook['webhook_name'] );

			if ( class_exists( $class_name ) ) {

				$instance = new $class_name( $data );
				$data = $instance->get_prepared_data();

			}
		}

		return $data;

	}

	public function add_send_data( $data ) {

		$class_name = $this->processed_hook;
		$this->processed_hook = null;

		$instance     = new $class_name( $data['data'] );
		$data['data'] = $instance->get_prepared_data();

		return $data;

	}

	public function get_class_name( $webhook_name ) {
		$name = str_replace( ' ' , '_', ucwords( str_replace( '_', ' ', $webhook_name ) ) );
		return __NAMESPACE__ . '\\Hooks\\' . $name;
	}

}
