import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';

registerBlockType('custom/about-area', {
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();
        const { title, description, tabs } = attributes;

        const updateTabContent = (index, content) => {
            const updatedTabs = [...tabs];
            updatedTabs[index].content = content;
            setAttributes({ tabs: updatedTabs });
        };

        return (
            <div {...blockProps} className="rts-about-area rts-section-gap">
                <div className="container">
                    <div className="title-area-left">
                        <RichText
                            tagName="h2"
                            className="title skew-up"
                            value={title}
                            onChange={(newTitle) => setAttributes({ title: newTitle })}
                        />
                        <RichText
                            tagName="p"
                            value={description}
                            onChange={(newDesc) => setAttributes({ description: newDesc })}
                        />
                    </div>
                    <ul className="nav custom-nav-soalr-about nav-pills" id="pills-tab" role="tablist">
                        {tabs.map((tab, index) => (
                            <li key={index} className="nav-item" role="presentation">
                                <button className={`nav-link ${index === 0 ? 'active' : ''}`} data-bs-toggle="pill">
                                    {tab.label}
                                </button>
                            </li>
                        ))}
                    </ul>
                    <div className="tab-content">
                        {tabs.map((tab, index) => (
                            <div key={index} className={`tab-pane fade ${index === 0 ? 'show active' : ''}`}>
                                <RichText
                                    tagName="p"
                                    className="disc"
                                    value={tab.content}
                                    onChange={(newContent) => updateTabContent(index, newContent)}
                                />
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        );
    },
    save: ({ attributes }) => {
        const { title, description, tabs } = attributes;

        return (
            <div className="rts-about-area rts-section-gap">
                <div className="container">
                    <div className="title-area-left">
                        <h2 className="title skew-up">{title}</h2>
                        <p>{description}</p>
                    </div>
                    <ul className="nav custom-nav-soalr-about nav-pills" id="pills-tab" role="tablist">
                        {tabs.map((tab, index) => (
                            <li key={index} className="nav-item" role="presentation">
                                <button className={`nav-link ${index === 0 ? 'active' : ''}`} data-bs-toggle="pill">
                                    {tab.label}
                                </button>
                            </li>
                        ))}
                    </ul>
                    <div className="tab-content">
                        {tabs.map((tab, index) => (
                            <div key={index} className={`tab-pane fade ${index === 0 ? 'show active' : ''}`}>
                                <p className="disc">{tab.content}</p>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        );
    }
});
