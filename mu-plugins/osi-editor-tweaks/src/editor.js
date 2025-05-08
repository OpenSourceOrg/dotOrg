import { registerBlockStyle } from '@wordpress/blocks';
import { addFilter } from '@wordpress/hooks';
import { Fragment } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

// Register the custom style for the core/image block
registerBlockStyle('core/image', {
	name: 'custom-filter-blackwhite',
	label: __('Black & White with Fade', 'osi-et'),
});

registerBlockStyle('core/image', {
	name: 'round-logo-border',
	label: __('Round Logo with Border', 'osi-et'),
});

registerBlockStyle('core/button', {
	name: 'spin-white',
	label: __('Spin (White)', 'osi-et'),
});

registerBlockStyle('core/button', {
	name: 'spin-green',
	label: __('Spin (Green)', 'osi-et'),
});

/**
 * Custom filter to add an "Animations" panel to the Inspector Controls of Heading blocks.
 *
 * @param {Function} BlockEdit The original BlockEdit component.
 * @returns {Function} Modified BlockEdit component with additional Inspector Controls.
 */
addFilter('editor.BlockEdit', 'custom/animation-panel', (BlockEdit) => {
	return (props) => {
		// Only modify the core/heading block
		if (props.name !== 'core/heading') {
			return <BlockEdit {...props} />;
		}

		const { attributes, setAttributes } = props;

		/**
		 * Handles the toggle switch change to enable or disable the "slide-up" class.
		 *
		 * @param {boolean} value Whether the "slide-up" class should be added or removed.
		 */
		const handleToggleChange = (value) => {
			const classList = attributes.className ? attributes.className.split(' ') : [];

			if (value) {
				// Add the class if it doesn’t already exist
				if (!classList.includes('slide-up')) {
					classList.push('slide-up');
				}
			} else {
				// Remove the class if it exists
				const index = classList.indexOf('slide-up');
				if (index > -1) {
					classList.splice(index, 1);
				}
			}

			// Update both enableSlider attribute and className
			setAttributes({
				enableSlider: value,
				className: classList.join(' '),
			});
		};

		return (
			<Fragment>
				{/* Render the original block edit component */}
				<BlockEdit {...props} />

				{/* Add custom Inspector Controls for animation */}
				<InspectorControls>
					<PanelBody title={__("Animations", 'osi-et')}>
						<ToggleControl
							label={__("Slide Up", 'osi-et')}
							checked={attributes.className && attributes.className.includes('slide-up')}
							onChange={handleToggleChange}
						/>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
});

/**
 * Custom filter to add an "OSI Card" panel to the Inspector Controls of Group blocks.
 *
 * @param {Function} BlockEdit The original BlockEdit component.
 * @returns {Function} Modified BlockEdit component with additional Inspector Controls.
 */
addFilter('editor.BlockEdit', 'custom/group-panel', (BlockEdit) => {
	return (props) => {
		// Only modify the core/group block
		if (props.name !== 'core/group') {
			return <BlockEdit {...props} />;
		}

		const { attributes, setAttributes } = props;

		/**
		 * Handles the toggle switch change to enable or disable the "osi-card" class.
		 *
		 * @param {boolean} value Whether the "osi-card" class should be added or removed.
		 */
		const handleToggleChange = (value) => {
			const classList = attributes.className ? attributes.className.split(' ') : [];

			if (value) {
				// Add the class if it doesn’t already exist
				if (!classList.includes('osi-card')) {
					classList.push('osi-card');
				}
			} else {
				// Remove the class if it exists
				const index = classList.indexOf('osi-card');
				if (index > -1) {
					classList.splice(index, 1);
				}
			}

			// Update both isCard attribute and className
			setAttributes({
				isCard: value,
				className: classList.join(' '),
			});
		};

		return (
			<Fragment>
				{/* Render the original block edit component */}
				<BlockEdit {...props} />

				{/* Add custom Inspector Controls for OSI Card toggle */}
				<InspectorControls>
					<PanelBody title={__("OSI Card", 'osi-et')}>
						<ToggleControl
							label={__("Show as Card", 'osi-et')}
							checked={attributes.className && attributes.className.includes('osi-card')}
							onChange={handleToggleChange}
						/>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
});
