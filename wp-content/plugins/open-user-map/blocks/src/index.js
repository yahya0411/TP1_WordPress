import 'core-js';
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import { Dashicon } from '@wordpress/components';
import { useState } from 'react';

const { TextControl } = wp.components;
const { SelectControl } = wp.components;

registerBlockType( 'open-user-map/map', {
    apiVersion: 2,
    title: __( 'Open User Map', 'open-user-map' ),
    description: __('Let your visitors add locations directly from within the map.', 'open-user-map'),
    icon: 'location-alt',
    category: 'widgets',
    example: {},
    attributes: {
        lat: {
            type: 'string',
        },
        long: {
            type: 'string',
        },
        zoom: {
            type: 'string',
        },
        region: {
            type: 'string',
        },
        types: {
            type: 'string',
        },
        ids: {
            type: 'string',
        },
        size: {
            type: 'string',
        },
        size_mobile: {
            type: 'string',
        },
        height: {
            type: 'string',
        },
        height_mobile: {
            type: 'string',
        },
    },
    edit: ({attributes, setAttributes}) => {
        const blockProps = useBlockProps();
        const [isActive1, setIsActive1] = useState(false);
        const [isActive2, setIsActive2] = useState(false);
        const [isActive3, setIsActive3] = useState(false);

        const handleClick1 = event => {
            // 👇️ toggle isActive state on click
            setIsActive1(current => !current);
        };

        const handleClick2 = event => {
            // 👇️ toggle isActive state on click
            setIsActive2(current => !current);
        };

        const handleClick3 = event => {
            // 👇️ toggle isActive state on click
            setIsActive3(current => !current);
        };

        // Render
        return ([
            <div { ...blockProps }>
                <div class="hint">
                    <h5>{ __('Open User Map', 'open-user-map') }</h5>
                    <p>
                        { __('This block will show your', 'open-user-map') } <a href="edit.php?post_type=oum-location">{ __('Locations', 'open-user-map') }</a> { __('on a map in the front end.', 'open-user-map') } <a class="link-oum-settings" href="edit.php?post_type=oum-location&page=open-user-map-settings"><Dashicon icon="admin-generic" />{ __('Settings', 'open-user-map') }</a>
                    </p>
                    <div class="oum-custom-settings">
                        <div className={isActive1 ? 'active' : ''}>
                            <p class="custom-settings-label oum-collapse-toggle" onClick={handleClick1}>
                                <strong>{ __('Custom Map Position:', 'open-user-map') }</strong>
                                { __('This will override the general configuration from the', 'open-user-map') } <a href="edit.php?post_type=oum-location&page=open-user-map-settings">{ __('settings', 'open-user-map') }</a>.<br /><br />
                            </p>
                            <div class="oum-collapse-content">
                                <div class="flex">
                                    <TextControl 
                                        label="Latitude"
                                        value={attributes.lat}
                                        onChange={(val) => setAttributes({ lat: val })}
                                        placeholder="e.g. 51.50665732176545"
                                    /> 
                                    <TextControl 
                                        label="Longitude"
                                        value={attributes.long}
                                        onChange={(val) => setAttributes({ long: val })}
                                        placeholder="e.g. -0.12752251529432854"
                                    /> 
                                    <TextControl 
                                        label="Zoom"
                                        value={attributes.zoom}
                                        onChange={(val) => setAttributes({ zoom: val })}
                                        placeholder="e.g. 13"
                                    />
                                </div>
                                <p class="custom-settings-label">
                                    <strong>{ __('OR', 'open-user-map') }</strong>
                                    <br />
                                </p>
                                <div class="flex">
                                    <TextControl 
                                        label="Pre-select region"
                                        value={attributes.region}
                                        onChange={(val) => setAttributes({ region: val })}
                                        placeholder="e.g. Europe"
                                    />
                                </div>
                            </div>
                        </div>
                        
                        <div className={isActive2 ? 'active' : ''}>
                            <p class="custom-settings-label oum-collapse-toggle" onClick={handleClick2}>
                                <strong>{ __('Custom style:', 'open-user-map') }</strong>
                                { __('This will override the general configuration from the', 'open-user-map') } <a href="edit.php?post_type=oum-location&page=open-user-map-settings">{ __('settings', 'open-user-map') }</a>.<br /><br />
                            </p>
                            <div class="oum-collapse-content">
                                <div class="flex">
                                    <SelectControl 
                                        label="Size"
                                        value={attributes.size}
                                        onChange={(val) => setAttributes({ size: val })}
                                        options={ [
                                            { label: '', value: '' },
                                            { label: 'Content Width', value: 'default' },
                                            { label: 'Full Width', value: 'fullwidth' },
                                        ] }
                                    />
                                    <SelectControl 
                                        label="Size (mobile)"
                                        value={attributes.size_mobile}
                                        onChange={(val) => setAttributes({ size_mobile: val })}
                                        options={ [
                                            { label: '', value: '' },
                                            { label: 'Square', value: 'square' },
                                            { label: 'Landscape', value: 'landscape' },
                                            { label: 'Portrait', value: 'portrait' },
                                        ] }
                                    />
                                </div>
                                <div class="flex">
                                    <TextControl 
                                        label="Height"
                                        value={attributes.height}
                                        onChange={(val) => setAttributes({ height: val })}
                                        placeholder="e.g. 400px"
                                        help={ __('Don\'t forget to add a unit like px.', 'open-user-map') }
                                    />
                                    <TextControl 
                                        label="Height (mobile)"
                                        value={attributes.height_mobile}
                                        onChange={(val) => setAttributes({ height_mobile: val })}
                                        placeholder="e.g. 400px"
                                        help={ __('Don\'t forget to add a unit like px.', 'open-user-map') }
                                    />
                                </div>
                            </div>
                        </div>

                        <div className={isActive3 ? 'active' : ''}>
                            <p class="custom-settings-label oum-collapse-toggle" onClick={handleClick3}>
                                <strong>{ __('Filter Locations:', 'open-user-map') }</strong>
                                { __('Show only specific markers by filtering for categories or Post IDs. You can separate multiple Categories or IDs with a | symbol.', 'open-user-map') }<br /><br />
                            </p>
                            <div class="oum-collapse-content">
                                <div class="flex">
                                    <TextControl 
                                        label="Filter by Marker Categories [PRO]"
                                        value={attributes.types}
                                        onChange={(val) => setAttributes({ types: val })}
                                        placeholder="e.g. food|drinks"
                                    />
                                    <TextControl 
                                        label="Filter by Post IDs"
                                        value={attributes.ids}
                                        onChange={(val) => setAttributes({ ids: val })}
                                        placeholder="e.g. 1|2|3"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ]);
    },
    save: () => { 
        return null // use PHP
    } 
} );