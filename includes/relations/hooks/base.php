<?php
namespace Jet_Engine_WPWH\Relations\Hooks;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

abstract class Base {

	public $input_data = array();

	public function __construct( $data ) {
		$this->input_data = $data;
	}

	public function get_type_from_data() {
		return false;
	}

	public function get_item_id() {
		return false;
	}

	public function get_relations() {

		$current_type = $this->get_type_from_data();
		$result       = array();
		$item_id      = $this->get_item_id();

		if ( ! $current_type || ! $item_id ) {
			return $result;
		}

		$all_rels = jet_engine()->relations->get_active_relations();

		foreach ( $all_rels  as $relation ) {

			$rel_ids           = array();
			$rel_object        = null;
			$rel_object_prefix = null;

			if ( $relation->get_args( 'parent_object' ) === $current_type ) {
				$rel_object = $relation->get_args( 'child_object' );
				$rel_object_prefix = 'children';
				$rel_ids = $relation->get_children( $item_id, 'ids' );
			} elseif ( $relation->get_args( 'child_object' ) === $current_type ) {
				$rel_object = $relation->get_args( 'parent_object' );
				$rel_object_prefix = 'parent';
				$rel_ids = $relation->get_parents( $item_id, 'ids' );
			}

			if ( $rel_object ) {
				$rel_object            = $rel_object_prefix . '_' . str_replace( jet_engine()->relations->types_helper->type_delimiter(), '__', $rel_object );
				$result[ $rel_object ] = $rel_ids;
			}

		}

		return $result;

	}

	public function get_prepared_data() {

		$found_relations = $this->get_relations();

		if ( ! empty( $found_relations ) ) {
			foreach ( $found_relations as $key => $value ) {
				$this->input_data[ $key ] = $value;
			}
		}

		return $this->input_data;
	}

}
