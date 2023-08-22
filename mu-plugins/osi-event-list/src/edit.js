
import { useBlockProps } from "@wordpress/block-editor";
import { TextControl } from "@wordpress/components";
import ServersideRender from "@wordpress/server-side-render";
import blockData from "./block.json";

const Edit = ( props ) => {

	const { attributes, setAttributes, isSelected } = props;

	return(
		( isSelected ) ? (
			<div { ...useBlockProps() }>
				<TextControl
					type="text"
					label="Enter the event list title"
					value={ attributes.title }
					onChange={ ( newTitle ) => setAttributes( { title: newTitle } ) }
				/>
				<TextControl
					type="number"
					label="Enter the number of events to display"
					value={ attributes.eventCount }
					onChange={ ( newEventCount ) => setAttributes( { eventCount: parseInt( newEventCount ) } ) }
				/>
			</div>
		) : (
			<div { ...useBlockProps() }>
				<ServersideRender
					block={ blockData.name }
					attributes={ attributes }
				/>
			</div>
		)
	);

};
export default Edit;
