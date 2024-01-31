const {
		  TextControl,
		  ToggleControl,
		  TextareaControl,
	  } = wp.components;

const {
		  addAction,
	  } = JetFBActions;

addAction( 'jfbc_action_iterator', function ActionIterator( {
											   settings, 
											   label,
											   onChangeSetting,
										   } ) {

	if ( settings.error_message === undefined ) {
		settings.error_message = 'No data in array';
	}

	return <>
		<TextControl
			label={ label( 'action_id' ) }
			value={ settings.action_id }
			onChange={ newVal => onChangeSetting( newVal, 'action_id' ) }
		/>
		<TextControl
			label={ label( 'array_field' ) }
			value={ settings.array_field }
			onChange={ newVal => onChangeSetting( newVal, 'array_field' ) }
		/>
		<ToggleControl
			label={ label( 'throw_error' ) }
			checked={ settings.throw_error }
			onChange={ newVal => onChangeSetting( newVal, 'throw_error' ) }
		/>
		{ settings.throw_error &&
		<TextControl
			label={ label( 'error_message' ) }
			value={ settings.error_message }
			onChange={ newVal => onChangeSetting( newVal, 'error_message' ) }
		/>
		}
	</>;
} );
