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
	</>;
} );
