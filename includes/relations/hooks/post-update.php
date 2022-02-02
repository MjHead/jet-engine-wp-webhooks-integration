<?php
namespace Jet_Engine_WPWH\Relations\Hooks;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Post_Update extends Base {

	public function get_type_from_data() {

		$post_type = ! empty( $this->input_data['post']['post_type'] ) ? $this->input_data['post']['post_type'] : false;

		if ( ! $post_type || ! isset( jet_engine()->relations->types_helper ) ) {
			return false;
		}

		return jet_engine()->relations->types_helper->type_name_by_parts( 'posts', $post_type );
	}

	public function get_item_id() {
		if ( isset( $this->input_data['post_id'] ) ) {
			return $this->input_data['post_id'];
		} elseif ( isset( $this->input_data['post']['ID'] ) ) {
			return $this->input_data['post']['ID'];
		} else {
			return false;
		}
	}

}
