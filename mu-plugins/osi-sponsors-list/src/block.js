import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import Edit from './edit';
import Save from './save';
import blockdata from './block.json';

import "./editor.scss";
import "./style.scss";

const { name, category, attributes, title, icon,  apiVersion } = blockdata;

registerBlockType( name, {
	title: __( title, 'osi-sponsors-list' ),
	icon: icon,
	category: category,
	apiVersion: apiVersion,
	attributes: attributes,
	edit: Edit,
    save: Save,
} );
