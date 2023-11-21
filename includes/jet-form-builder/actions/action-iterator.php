<?php

namespace JFB_Action_Iterator\Jet_Form_Builder\Actions;

if ( ! defined( 'WPINC' ) ) {
	die();
}

use JFB_Action_Iterator\Plugin;
use Jet_Form_Builder\Actions\Manager;
use Jet_Form_Builder\Actions\Types\Base as ActionBase;
use Jet_Form_Builder\Actions\Action_Handler;
use Jet_Engine\Query_Builder\Manager as Queries;
use Jet_Form_Builder\Exceptions\Action_Exception as Error;

class Action_Iterator extends ActionBase {

	public function __construct() {

		add_action(
			'jet-form-builder/actions/register',
			array( $this, 'register_action' )
		);
		add_action(
			'jet-form-builder/editor-assets/before',
			array( $this, 'editor_assets' )
		);

	}

	public function register_action( Manager $manager ) {
		$manager->register_action_type( $this );
	}

	public function get_id() {
		return 'jfbc_action_iterator';
	}

	public function get_name() {
		return 'Action Iterator';
	}

	public function self_script_name() {
		return 'JFBActionIterator';
	}

	public function editor_labels() {
		return array(
			'action_id'   => 'Action ID',
			'array_field' => 'Field with array data',
		);
	}

	public function visible_attributes_for_gateway_editor() {
		return array();
	}

	public function do_action( array $request, Action_Handler $handler ) {

		$action_id = $this->settings['action_id'] ?? '';

		if ( empty( $action_id ) ) {
			throw new Error( 'No action ID' );
		}

		$action = $handler->get_action( $action_id );

		if ( ! $action ) {
			throw new Error( 'Action not found' );
		}

		$array_field = $this->settings['array_field'] ?? '';

		if ( empty( $array_field ) ) {
			throw new Error( 'Set field to get data from' );
		}

		$array = $request[ $array_field ];

		if ( empty( $array ) || ! is_array( $array ) ) {
			throw new Error( 'No data' );
		}

		foreach ( $array as $item ) {

			foreach ( $item as $key => $value ) {
				$request[ $key ] = $value;
				jet_fb_context()->update_request( $value, $key );

			}

			$action->do_action( $request, $handler );

		}

	}

	public function editor_assets() {
		wp_enqueue_script(
			Plugin::instance()->slug . '-editor',
			Plugin::instance()->plugin_url( 'assets/js/builder.editor.js' ),
			array(),
			Plugin::instance()->get_version(),
			true
		);
	}

}