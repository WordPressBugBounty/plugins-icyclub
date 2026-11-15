/**
 * Pure Gutenberg Native Sidebar Panel for Portfolio CPT
 *
 * Provides a native Document Setting Panel in the block editor sidebar.
 * Reactively binds to registered post meta:
 * - port_cpt_link
 * - port_cpt_target
 * - port_disc
 *
 * Saves natively via the WordPress REST API with zero legacy $_POST handling.
 *
 * @package Icyclub
 */

( function ( wp ) {
	const { registerPlugin } = wp.plugins;
	const { PluginDocumentSettingPanel } = wp.editPost;
	const { createElement, Fragment } = wp.element;
	const { TextControl, TextareaControl, ToggleControl } = wp.components;
	const { useSelect } = wp.data;
	const { useEntityProp } = wp.coreData;
	const { __ } = wp.i18n;

	const PortfolioDetailsPanel = () => {
		// Only render for portfolio post types
		const postType = useSelect( ( select ) => {
			return select( 'core/editor' ).getCurrentPostType();
		}, [] );

		if ( postType !== 'icyclub_portfolio' && postType !== 'consultup_portfolio' ) {
			return null;
		}

		// Connect to post meta in the Gutenberg entity store
		const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );

		const portLink   = ( meta && meta.port_cpt_link ) || '';
		const rawTarget  = meta && meta.port_cpt_target;
		const portTarget = rawTarget === '1' || rawTarget === 'on' || rawTarget === true;
		const portDesc   = ( meta && meta.port_disc ) || '';

		const updateMeta = ( key, value ) => {
			setMeta( {
				...meta,
				[ key ]: value,
			} );
		};

		return createElement(
			PluginDocumentSettingPanel,
			{
				name: 'icycp-portfolio-details',
				title: __( 'Portfolio Details', 'icyclub' ),
				icon: 'portfolio',
				initialOpen: true,
			},
			createElement(
				Fragment,
				{},
				createElement( TextControl, {
					label: __( 'Project Link', 'icyclub' ),
					help: __( 'Optional external link for this portfolio item.', 'icyclub' ),
					value: portLink,
					placeholder: 'https://example.com',
					onChange: ( value ) => updateMeta( 'port_cpt_link', value ),
				} ),
				createElement( ToggleControl, {
					label: __( 'Open link in new tab', 'icyclub' ),
					checked: portTarget,
					onChange: ( checked ) => updateMeta( 'port_cpt_target', checked ? '1' : '' ),
				} ),
				createElement( TextareaControl, {
					label: __( 'Short Description', 'icyclub' ),
					help: __( 'Summary text used in portfolio grids and templates.', 'icyclub' ),
					value: portDesc,
					rows: 4,
					placeholder: __( 'Enter a short summary...', 'icyclub' ),
					onChange: ( value ) => updateMeta( 'port_disc', value ),
				} )
			)
		);
	};

	registerPlugin( 'icycp-portfolio-sidebar', {
		render: PortfolioDetailsPanel,
		icon: 'portfolio',
	} );
} )( window.wp );
