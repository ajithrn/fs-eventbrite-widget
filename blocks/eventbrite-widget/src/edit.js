/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, BlockControls, AlignmentToolbar } from '@wordpress/block-editor';
import {
	PanelBody,
	TextControl,
	SelectControl,
	ToggleControl,
	RangeControl,
	__experimentalBoxControl as BoxControl,
	__experimentalUnitControl as UnitControl,
	ColorPicker,
	GradientPicker,
	Button,
	Notice,
	Placeholder,
	ToolbarGroup,
	ToolbarButton,
	Popover,
} from '@wordpress/components';
import { useState } from '@wordpress/element';
import { edit } from '@wordpress/icons';

/**
 * Edit component
 *
 * @param {Object} props Block props
 * @return {JSX.Element} Edit component
 */
export default function Edit( { attributes, setAttributes } ) {
	const {
		eventId,
		widgetType,
		buttonText,
		fontSize,
		fontWeight,
		textColor,
		backgroundColor,
		useGradient,
		backgroundGradient,
		borderWidth,
		borderStyle,
		borderColor,
		borderRadius,
		paddingTop,
		paddingRight,
		paddingBottom,
		paddingLeft,
		hoverBackgroundColor,
		hoverTextColor,
		hoverBorderColor,
		hoverTransform,
		transitionDuration,
		buttonClass,
		buttonStyle,
		width,
		height,
		containerClass,
		containerStyle,
		alignment,
	} = attributes;

	const [ isEventIdValid, setIsEventIdValid ] = useState( true );
	const [ showEventIdPopover, setShowEventIdPopover ] = useState( false );

	const blockProps = useBlockProps( {
		className: `has-text-align-${ alignment }`,
	} );

	/**
	 * Validate Event ID
	 */
	const validateEventId = ( value ) => {
		const cleaned = value.replace( /[^0-9]/g, '' );
		const isValid = cleaned.length >= 10 && cleaned.length <= 19;
		setIsEventIdValid( isValid || cleaned.length === 0 );
		setAttributes( { eventId: cleaned } );
	};

	/**
	 * Reset to defaults
	 */
	const resetToDefaults = () => {
		setAttributes( {
			buttonText: 'Get Tickets',
			fontSize: '16px',
			fontWeight: 'bold',
			textColor: '#ffffff',
			backgroundColor: '#ff6600',
			useGradient: false,
			backgroundGradient: '',
			borderWidth: '2px',
			borderStyle: 'solid',
			borderColor: 'transparent',
			borderRadius: '4px',
			paddingTop: '12px',
			paddingRight: '24px',
			paddingBottom: '12px',
			paddingLeft: '24px',
			hoverBackgroundColor: '#e55a00',
			hoverTextColor: '#ffffff',
			hoverBorderColor: '',
			hoverTransform: 'scale',
			transitionDuration: '300ms',
		} );
	};

	/**
	 * Build button preview styles
	 */
	const getButtonPreviewStyles = () => {
		const styles = {
			display: 'inline-block',
			fontSize,
			fontWeight,
			color: textColor,
			background: useGradient && backgroundGradient ? backgroundGradient : backgroundColor,
			border: `${ borderWidth } ${ borderStyle } ${ borderColor }`,
			borderRadius,
			padding: `${ paddingTop } ${ paddingRight } ${ paddingBottom } ${ paddingLeft }`,
			transition: `all ${ transitionDuration }`,
			cursor: 'pointer',
			textDecoration: 'none',
		};
		return styles;
	};

	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<AlignmentToolbar
						value={ alignment }
						onChange={ ( newAlignment ) => setAttributes( { alignment: newAlignment || 'left' } ) }
					/>
				</ToolbarGroup>
				{ eventId && (
					<ToolbarGroup>
						<ToolbarButton
							icon={ edit }
							label={ __( 'Change Event ID', 'fs-eventbrite-widget' ) }
							onClick={ () => setShowEventIdPopover( ! showEventIdPopover ) }
						/>
						{ showEventIdPopover && (
							<Popover
								position="bottom center"
								onClose={ () => setShowEventIdPopover( false ) }
							>
								<div style={ { padding: '16px', minWidth: '280px' } }>
									<TextControl
										label={ __( 'Event ID', 'fs-eventbrite-widget' ) }
										value={ eventId }
										onChange={ validateEventId }
										help={ __( 'Enter your Eventbrite event ID', 'fs-eventbrite-widget' ) }
										placeholder="1234567890123"
									/>
									{ ! isEventIdValid && eventId && (
										<Notice status="error" isDismissible={ false }>
											{ __( 'Event ID must be 10-19 digits', 'fs-eventbrite-widget' ) }
										</Notice>
									) }
									<Button
										isPrimary
										onClick={ () => setShowEventIdPopover( false ) }
										style={ { marginTop: '8px' } }
									>
										{ __( 'Done', 'fs-eventbrite-widget' ) }
									</Button>
								</div>
							</Popover>
						) }
					</ToolbarGroup>
				) }
			</BlockControls>

			<InspectorControls>
				{/* Event Settings */ }
				<PanelBody title={ __( 'Event Settings', 'fs-eventbrite-widget' ) } initialOpen={ true }>
					<TextControl
						label={ __( 'Event ID', 'fs-eventbrite-widget' ) }
						value={ eventId }
						onChange={ validateEventId }
						help={ __( 'Enter your Eventbrite event ID (numbers only)', 'fs-eventbrite-widget' ) }
						placeholder="1234567890123"
					/>
					{ ! isEventIdValid && eventId && (
						<Notice status="error" isDismissible={ false }>
							{ __( 'Event ID must be 10-19 digits', 'fs-eventbrite-widget' ) }
						</Notice>
					) }

					<SelectControl
						label={ __( 'Widget Type', 'fs-eventbrite-widget' ) }
						value={ widgetType }
						options={ [
							{ label: __( 'Modal Button', 'fs-eventbrite-widget' ), value: 'modal' },
							{ label: __( 'Embedded Widget', 'fs-eventbrite-widget' ), value: 'embedded' },
						] }
						onChange={ ( value ) => setAttributes( { widgetType: value } ) }
					/>
				</PanelBody>

				{/* Button Appearance - Only for Modal */ }
				{ widgetType === 'modal' && (
					<>
						<PanelBody title={ __( 'Button Text & Typography', 'fs-eventbrite-widget' ) } initialOpen={ false }>
							<TextControl
								label={ __( 'Button Text', 'fs-eventbrite-widget' ) }
								value={ buttonText }
								onChange={ ( value ) => setAttributes( { buttonText: value } ) }
							/>

							<UnitControl
								label={ __( 'Font Size', 'fs-eventbrite-widget' ) }
								value={ fontSize }
								onChange={ ( value ) => setAttributes( { fontSize: value } ) }
								units={ [
									{ value: 'px', label: 'px' },
									{ value: 'em', label: 'em' },
									{ value: 'rem', label: 'rem' },
								] }
							/>

							<SelectControl
								label={ __( 'Font Weight', 'fs-eventbrite-widget' ) }
								value={ fontWeight }
								options={ [
									{ label: __( 'Normal', 'fs-eventbrite-widget' ), value: 'normal' },
									{ label: __( 'Bold', 'fs-eventbrite-widget' ), value: 'bold' },
									{ label: '600', value: '600' },
									{ label: '700', value: '700' },
									{ label: '800', value: '800' },
								] }
								onChange={ ( value ) => setAttributes( { fontWeight: value } ) }
							/>

							<p>{ __( 'Text Color', 'fs-eventbrite-widget' ) }</p>
							<ColorPicker
								color={ textColor }
								onChange={ ( value ) => setAttributes( { textColor: value } ) }
								enableAlpha
							/>
						</PanelBody>

						<PanelBody title={ __( 'Background', 'fs-eventbrite-widget' ) } initialOpen={ false }>
							<ToggleControl
								label={ __( 'Use Gradient', 'fs-eventbrite-widget' ) }
								checked={ useGradient }
								onChange={ ( value ) => {
									setAttributes( { useGradient: value } );
									// Set a default gradient if none exists
									if ( value && ! backgroundGradient ) {
										setAttributes( { backgroundGradient: 'linear-gradient(135deg, #ff6600 0%, #e55a00 100%)' } );
									}
								} }
							/>

							{ useGradient ? (
								<>
									<p>{ __( 'Background Gradient', 'fs-eventbrite-widget' ) }</p>
									<GradientPicker
										value={ backgroundGradient || 'linear-gradient(135deg, #ff6600 0%, #e55a00 100%)' }
										onChange={ ( value ) => setAttributes( { backgroundGradient: value || '' } ) }
										gradients={ [
											{
												name: 'Orange to Red',
												gradient: 'linear-gradient(135deg, #ff6600 0%, #e55a00 100%)',
												slug: 'orange-red',
											},
											{
												name: 'Blue to Purple',
												gradient: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
												slug: 'blue-purple',
											},
											{
												name: 'Green to Teal',
												gradient: 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)',
												slug: 'green-teal',
											},
										] }
									/>
								</>
							) : (
								<>
									<p>{ __( 'Background Color', 'fs-eventbrite-widget' ) }</p>
									<ColorPicker
										color={ backgroundColor }
										onChange={ ( value ) => setAttributes( { backgroundColor: value } ) }
										enableAlpha
									/>
								</>
							) }
						</PanelBody>

						<PanelBody title={ __( 'Border', 'fs-eventbrite-widget' ) } initialOpen={ false }>
							<UnitControl
								label={ __( 'Border Width', 'fs-eventbrite-widget' ) }
								value={ borderWidth }
								onChange={ ( value ) => setAttributes( { borderWidth: value } ) }
								units={ [
									{ value: 'px', label: 'px' },
								] }
							/>

							<SelectControl
								label={ __( 'Border Style', 'fs-eventbrite-widget' ) }
								value={ borderStyle }
								options={ [
									{ label: __( 'None', 'fs-eventbrite-widget' ), value: 'none' },
									{ label: __( 'Solid', 'fs-eventbrite-widget' ), value: 'solid' },
									{ label: __( 'Dashed', 'fs-eventbrite-widget' ), value: 'dashed' },
									{ label: __( 'Dotted', 'fs-eventbrite-widget' ), value: 'dotted' },
								] }
								onChange={ ( value ) => setAttributes( { borderStyle: value } ) }
							/>

							<p>{ __( 'Border Color', 'fs-eventbrite-widget' ) }</p>
							<ColorPicker
								color={ borderColor }
								onChange={ ( value ) => setAttributes( { borderColor: value } ) }
								enableAlpha
							/>

							<UnitControl
								label={ __( 'Border Radius', 'fs-eventbrite-widget' ) }
								value={ borderRadius }
								onChange={ ( value ) => setAttributes( { borderRadius: value } ) }
								units={ [
									{ value: 'px', label: 'px' },
									{ value: '%', label: '%' },
								] }
							/>
						</PanelBody>

						<PanelBody title={ __( 'Spacing', 'fs-eventbrite-widget' ) } initialOpen={ false }>
							<p>{ __( 'Padding', 'fs-eventbrite-widget' ) }</p>
							<div style={ { display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '8px' } }>
								<UnitControl
									label={ __( 'Top', 'fs-eventbrite-widget' ) }
									value={ paddingTop }
									onChange={ ( value ) => setAttributes( { paddingTop: value } ) }
								/>
								<UnitControl
									label={ __( 'Right', 'fs-eventbrite-widget' ) }
									value={ paddingRight }
									onChange={ ( value ) => setAttributes( { paddingRight: value } ) }
								/>
								<UnitControl
									label={ __( 'Bottom', 'fs-eventbrite-widget' ) }
									value={ paddingBottom }
									onChange={ ( value ) => setAttributes( { paddingBottom: value } ) }
								/>
								<UnitControl
									label={ __( 'Left', 'fs-eventbrite-widget' ) }
									value={ paddingLeft }
									onChange={ ( value ) => setAttributes( { paddingLeft: value } ) }
								/>
							</div>
						</PanelBody>

						<PanelBody title={ __( 'Hover Effects', 'fs-eventbrite-widget' ) } initialOpen={ false }>
							<p>{ __( 'Hover Background Color', 'fs-eventbrite-widget' ) }</p>
							<ColorPicker
								color={ hoverBackgroundColor }
								onChange={ ( value ) => setAttributes( { hoverBackgroundColor: value } ) }
								enableAlpha
							/>

							<p>{ __( 'Hover Text Color', 'fs-eventbrite-widget' ) }</p>
							<ColorPicker
								color={ hoverTextColor }
								onChange={ ( value ) => setAttributes( { hoverTextColor: value } ) }
								enableAlpha
							/>

							<p>{ __( 'Hover Border Color', 'fs-eventbrite-widget' ) }</p>
							<ColorPicker
								color={ hoverBorderColor }
								onChange={ ( value ) => setAttributes( { hoverBorderColor: value } ) }
								enableAlpha
							/>

							<SelectControl
								label={ __( 'Hover Transform', 'fs-eventbrite-widget' ) }
								value={ hoverTransform }
								options={ [
									{ label: __( 'None', 'fs-eventbrite-widget' ), value: 'none' },
									{ label: __( 'Scale', 'fs-eventbrite-widget' ), value: 'scale' },
									{ label: __( 'Lift', 'fs-eventbrite-widget' ), value: 'lift' },
								] }
								onChange={ ( value ) => setAttributes( { hoverTransform: value } ) }
							/>

							<RangeControl
								label={ __( 'Transition Duration (ms)', 'fs-eventbrite-widget' ) }
								value={ parseInt( transitionDuration ) }
								onChange={ ( value ) => setAttributes( { transitionDuration: `${ value }ms` } ) }
								min={ 0 }
								max={ 1000 }
								step={ 50 }
							/>

							<Button isSecondary onClick={ resetToDefaults } style={ { marginTop: '10px' } }>
								{ __( 'Reset to Defaults', 'fs-eventbrite-widget' ) }
							</Button>
						</PanelBody>
					</>
				) }

				{/* Container Settings */ }
				<PanelBody title={ __( 'Container Settings', 'fs-eventbrite-widget' ) } initialOpen={ false }>
					<UnitControl
						label={ __( 'Width', 'fs-eventbrite-widget' ) }
						value={ width }
						onChange={ ( value ) => setAttributes( { width: value } ) }
						units={ [
							{ value: '%', label: '%' },
							{ value: 'px', label: 'px' },
							{ value: 'vw', label: 'vw' },
						] }
					/>

					{ widgetType === 'embedded' && (
						<TextControl
							label={ __( 'Height (px)', 'fs-eventbrite-widget' ) }
							type="number"
							value={ height }
							onChange={ ( value ) => setAttributes( { height: value } ) }
							min={ 300 }
							max={ 1000 }
						/>
					) }

					<TextControl
						label={ __( 'Container CSS Classes', 'fs-eventbrite-widget' ) }
						value={ containerClass }
						onChange={ ( value ) => setAttributes( { containerClass: value } ) }
						help={ __( 'Additional CSS classes for the container', 'fs-eventbrite-widget' ) }
					/>

					<TextControl
						label={ __( 'Custom Container Styles', 'fs-eventbrite-widget' ) }
						value={ containerStyle }
						onChange={ ( value ) => setAttributes( { containerStyle: value } ) }
						help={ __( 'Custom inline CSS for the container', 'fs-eventbrite-widget' ) }
					/>
				</PanelBody>

				{/* Advanced */ }
				<PanelBody title={ __( 'Advanced', 'fs-eventbrite-widget' ) } initialOpen={ false }>
					<TextControl
						label={ __( 'Button CSS Classes', 'fs-eventbrite-widget' ) }
						value={ buttonClass }
						onChange={ ( value ) => setAttributes( { buttonClass: value } ) }
						help={ __( 'Additional CSS classes for the button', 'fs-eventbrite-widget' ) }
					/>

					<TextControl
						label={ __( 'Custom Button Styles', 'fs-eventbrite-widget' ) }
						value={ buttonStyle }
						onChange={ ( value ) => setAttributes( { buttonStyle: value } ) }
						help={ __( 'Custom inline CSS for the button', 'fs-eventbrite-widget' ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				{ ! eventId ? (
					<Placeholder
						label={ __( 'Eventbrite Widget', 'fs-eventbrite-widget' ) }
						instructions={ __( 'Enter your Eventbrite event ID in the block settings to get started.', 'fs-eventbrite-widget' ) }
					>
						<TextControl
							label={ __( 'Event ID', 'fs-eventbrite-widget' ) }
							value={ eventId }
							onChange={ validateEventId }
							placeholder="1234567890123"
						/>
					</Placeholder>
				) : (
					<div className="fs-eventbrite-widget-preview">
						{ widgetType === 'modal' ? (
							<button style={ getButtonPreviewStyles() } disabled>
								{ buttonText }
							</button>
						) : (
							<div
								style={ {
									border: '2px dashed #ccc',
									padding: '20px',
									textAlign: 'center',
									height: `${ height }px`,
									display: 'flex',
									alignItems: 'center',
									justifyContent: 'center',
									backgroundColor: '#f5f5f5',
									borderRadius: '4px',
								} }
							>
								<p style={ { margin: 0, color: '#666' } }>
									{ __( 'Embedded widget will appear here', 'fs-eventbrite-widget' ) }
								</p>
							</div>
						) }
					</div>
				) }
			</div>
		</>
	);
}
