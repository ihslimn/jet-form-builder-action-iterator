<?php

namespace JFB_Action_Iterator\Jet_Form_Builder;

use JFB_Action_Iterator\Plugin;

if ( ! defined( 'WPINC' ) ) {
	die();
}

class Manager {

	public function __construct() {
		
		add_action( 'jet-form-builder/form-handler/before-send', array( $this, 'remove_actions_from_flow' ) );

		require Plugin::instance()->plugin_path( 'includes/jet-form-builder/actions/action-iterator.php' );
		new \JFB_Action_Iterator\Jet_Form_Builder\Actions\Action_Iterator();

	}

	public function remove_actions_from_flow() {

		$action_handler = jet_fb_action_handler();

		foreach ( $action_handler->get_all() as $action ) {

			if ( ! is_a( $action, '\JFB_Action_Iterator\Jet_Form_Builder\Actions\Action_Iterator' ) ) {
				continue;
			}

			$action_id = $action->settings['action_id'];

			$events_list = jet_fb_action_handler()->get_events_by_id( $action_id );

			$events_list->push( \Jet_Form_Builder\Actions\Events_Manager::instance()->get_never_event() );

		}

	}

}