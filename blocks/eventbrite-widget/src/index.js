/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';
import metadata from '../block.json';
import './editor.scss';
import './style.scss';

/**
 * Block variations
 */
const variations = [
	{
		name: 'modal-button',
		title: 'Eventbrite Modal Button',
		description: 'Show a button that opens a modal checkout',
		icon: 'tickets-alt',
		isDefault: true,
		attributes: {
			widgetType: 'modal',
		},
	},
	{
		name: 'embedded-widget',
		title: 'Eventbrite Embedded Widget',
		description: 'Embed the checkout directly on the page',
		icon: 'embed-generic',
		attributes: {
			widgetType: 'embedded',
		},
	},
];

/**
 * Register the Eventbrite Widget block
 */
registerBlockType( metadata.name, {
	edit: Edit,
	save,
	variations,
} );
