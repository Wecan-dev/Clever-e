=== WP Grid Builder ===
Author URI: https://wpgridbuilder.com
Plugin URI: https://wpgridbuilder.com
Contributors: WP Grid Builder, Loïc Blascos
Tags: ecommerce, facet, filter, grid, justified, masonry, metro, post filter, post grid, taxonomy, user, search
Requires at least: 4.7.0
Tested up to: 5.4.0
Requires PHP: 5.6
Stable tag: 1.2.2
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Create advanced and filterable grids from (custom) post types with endless possibilities.

== Description ==

= WP Grid Builder WordPress Plugin =

[Live demo](https://demos.wpgridbuilder.com)

WP Grid Builder is a modular and flexible WordPress Grid plugin, which allows you to create advanced and faceted grids.
Show off your post types, taxonomy terms or users in Masonry, Metro, Justified or carousel layout.
Filter your grids from any (custom) taxonomy terms, WordPress fields and custom fields.
Possibilities are endless and do not require coding knowledge.

WP Grid Builder will fit to any project which displays posts, users, or taxonomy terms.
The plugin is perfect to create eCommerces, blogs, portfolios, galleries and so more...
The plugin can also be used to layout grids/carousels from your WordPress media library.

WP Grid Builder was built with performance in mind.
The plugin is able to handle large amout of posts without impacting loading speed of your website.
The faceted search system can handle thousands of posts with an appropriate server (VPS or dedicated server)

WP Grid Builder also includes advanced PHP and JavaScript APIs for developers.
You can use the facet system as standalone without the grid and card system.

**WordPress Features**

WP Grid Builder is certainly the most advanced Grid plugin.
It comes with plenty of options and possibilities easily configurable thanks to powerful admin interface.

**Main Features:**

* Fully Responsive
* Mobile Friendly
* Lazy load support
* RTL layout support
* HTML5 Browser History support
* Google Fonts integration
* 250 SVG icons included
* HTML5 videos support (.mp4, .webm, .ogv)
* Youtube, Vimeo, Wistia support from video post format
* Post formats support (standard, audio, video)
* Index based faceted search
* Accessibility support (WCAG standards)
* W3C standard valid
* SEO Friendly
* Import/Export settings
* PHP and JavaScript APIs
* Developer Friendly
* Multisite Support
* Automatic Updates
* Compatible with Gutenberg or any page builder using shortcodes
* Compatible with WooCommerce plugin
* Compatible with Easy Digital Downloads plugin
* Compatible with Advanced Custom Fields plugin
* Compatible with Relevanssi plugin
* Compatible with SearchWP plugin

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wp-grid-builder` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress.
1. Use the Gridbuilder ᵂᴾ screen to configure the plugin.


== Frequently Asked Questions ==

= What does WP Grid Builder do, exactly? =

WP Grid Builder allows to create grids of (custom) post type(s), users, and taxonomy terms.
Grids can be filtered, thanks to an advanced facet system, by taxonomy terms, WordPress fields and custom fields.

= Is WP Grid Builder compatible with multisites installation? =

Yes, WP Grid Builder can be activated for all your sub-sites, just activate it from your main network site.

= Is WP Grid Builder compatible with all web browsers? =

Yes, WP Grid Builder is compatible with all modern web browsers. WP Grid Builder is compatible with Google Chrome, Safari, FireFox, Opera, Edge and IE11.

== Changelog ==

= 1.2.2 - April 14, 2020 =

* Added    French translation of backend and frontend.
* Changed  Minor changes to admin settings panels.
* Changed  Minor changes to admin labels and descriptions.
* Updated  Flatpickr library used for date picker facet.
* Fixed    Prevent issue with multiple inlined custom JS codes.
* Fixed    Issue with WPML Media plugin and attachment queries.
* Fixed    Issue with Visual Composer column shortcodes in excerpt.

= 1.2.1 - March 25, 2020 =

* Improved Split styles and scripts to only load necessary assets on the frontend.
* Improved Facets scripts (date, range, select) are now loaded asynchronously on the frontend.
* Improved Render facets endpoint (onload) only queries content and fetches facet arguments.
* Improved Date and Range facet options are now handled asynchronously instead of being localized.
* Improved Range facet displays a skeleton placeholder while loading before initialization.
* Improved Use of font-variant-numeric for fluid content change in range facet.
* Improved Custom blocks are only rendered if they hold content.
* Added    Option to load/unload polyfills to support Internet Explorer 11 and older browsers.
* Added    Support filtering and sorting by WooCommerce featured products (available in facet custom fields).
* Updated  SVG calendar icon of the date facet input.
* Fixed    Issue with Gutenberg Fullscreen mode in WordPress 5.4 when resizing a grid.
* Fixed    Issue with Gutenberg align class name when editing a grid rendered on load in the editor.
* Fixed    Issue with read more link in card post content and excerpt.
* Fixed    Issue with Gutenberg and Google Fonts loaded from cards.
* Fixed    Issue with formatting input numbers in plugin settings.
* Fixed    Issue with select, date, range and search facets JS instantiation when conditionally hidden (with PHP filter).
* Fixed    Issue with "wp-" prefix in plugin assets folder name (to prevent issue on some servers).

= 1.2.0 - February 10, 2020 =

* Improved Accessibility with carousel keyboard navigation.
* Improved Exclude language taxonomy from taxonomy terms block of the card builder.
* Added    Support for strings translation with Polylang and WPML thanks to Multilingual add-on.
* Added    Support for [number] shortcode in toggle button label to display the number of hidden items (checkbox, radio, button, and hierarchy).
* Added    Support for [number] shortcode in load more button to display number of remaining items.
* Fixed    CSS issue with Gutenberg blocks and select/button components.
* Fixed    Issue with do_shortcode in card post content.
* Fixed    Issue with query string in asynchronous endpoint.
* Fixed    Issue with included terms in facets.
* Fixed    Issue with carousel keyboard navigation.
* Fixed    Issue when indexing taxonomy terms with WPML.

= 1.1.9 - January 20, 2020 =

* Improved Dynamic stylesheets principle to decrease numbers of generated files.
* Improved Support date and number formats for ACF repeater fields and array values in card builder.
* Improved Prevent to scroll to carousel viewport when buttons or pagination dots are focused.
* Fixed    Missing dependency from main plugin stylesheet in wp_enqueue_style() used by wpgb_render_template().
* Fixed    Issue with non numeric attachment ID when changing object attachment with wp_grid_builder/grid/the_object PHP filter.
* Fixed    Issue with missing CSS transitions in card builder from preview mode.
* Fixed    Issue with default accent color in facets if unset.
* Fixed    Issue with search facet and post status.

= 1.1.8 - January 8, 2020 =

* Improved Render blocks and shortcodes in card post content.
* Improved Preserve scrollRestoration on first load to scroll to anchor.
* Improved Preserve hash location in query string when filtering with histroy.
* Added    Draggable option to enable/disable dragging and flicking feature on carousel.
* Fixed    Issue when indexing taxonomy terms from attachment post type.
* Fixed    Issue with encoding facet values and special characters.
* Fixed    Issue with attachment post type and custom post formats from plguin settings.
* Fixed    Issue when assigning card to custom post formats.
* Fixed    Added fallback to default post ID in grid settings if missing ID from pll_get_post() function.
* Fixed    Missing datetime attribute in time HTML tag.
* Fixed    Width issue with select combobox search holder.
* Fixed    Corrected unvalid CSS property values (W3C non-compliant).
* Fixed    CSS transition flicker issue while loading cards stylesheet.

= 1.1.7 - December 2, 2019 =

* Fixed    Unset default touch action on range slider to prevent dragging issue on touch devices.
* Fixed    Missing carousel dots and navigation buttons (prev/next) in Grid Builder.
* Fixed    Missing icons for 3rd party add-ons in dashboard importer of the plugin.
* Fixed    CSS conflicts with facet unordered/ordered list style.

= 1.1.6 - November 18, 2019 =

* Improved WP Media modal keep selected media when adding new ones (does not require to hold ctrl/cmd key).
* Added    New set of SVG icons (home/buildings) for the card builder.
* Added    New hook 'wp_grid_builder/facet/orderby' to change facet query ORDER BY clause.
* Fixed    Rare query issue with term taxonomy ids used in meta_query.
* Fixed    PHP warnings when missing custom fields in facet settings and card builder.
* Fixed    JS issue when destroying range slider instance if facet is empty.
* Fixed    CSS conflict with admin notices if post options if enabled.

= 1.1.5 - November 4, 2019 =

* Improved Plugin license and updater refactor to easily register add-ons.
* Improved Preserve search relevance if no order is set.
* Improved 'noresults_callback' of wpgb_render_template() set to false prevents showing no results message.
* Added    New admin submenu to download and activate add-ons.
* Added    Support for the defer and async script attributes.
* Added    Option to reveal WooCommerce first gallery image when hovering thumbnail.
* Added    Support to sort by ACF meta key (repeaters are not supported).
* Updated  Flatpickr.js library to v4.6.3.
* Fixed    Facets not rendered in preview mode if grid not saved.

= 1.1.1 - September 12, 2019 =

* Improved Allow multiple facets selection in settings to reset facet(s).
* Improved Automatically translate custom field date format in cards.
* Added    Gutenberg block preview examples in block inserter.
* Fixed    PHP warning if missing user data when indexing.
* Fixed    PHP error when saving custom field attachment.
* Fixed    PHP issue with post permalink date structures.

= 1.1.0 - September 4, 2019 =

* Improved Settings API to allow plugins/add-ons to extend settings.
* Improved Increase limit for card spacings up to 999 in grid settings.
* Improved Allow multiple names (whitespace separated) in class attribute of wpgb_render_template() argument.
* Changed  PHP filter name for hierarchy facet.
* Fixed    Missing default Google Fonts weight (variant 400).
* Fixed    Facet not been centered when placed alone in grid builder area.
* Fixed    Issue with include parameter of WP_Term_Query set to [ 0 ] (WP Core bug: https://core.trac.wordpress.org/ticket/47719).
* Fixed    JS conflict with card preview iframe in overview page.
* Fixed    JS conflict with WordPress iris script from color picker.
* Fixed    JS issue with Internet Explorer 11.
* Fixed    CSS issue with post per page select facet.
* Fixed    PHP issue when splitting string by whitespaces for CSS classes.
* Fixed    PHP typo with orderby field name for term and user sources.

= 1.0.3 - June 17, 2019 =

* added    wp_grid_builder/card/id PHP hook to change the card ID used for a post.
* Added    Possibility to include or exclude term(s) for queried posts (grid settings).
* Added    Possibility to set is_main_query in shortcode attribute.
* added    Notice message in card builder for blocks that natively have an action (media button, social share, etc.).
* Fixed    JS issue with load more on scroll on facet refresh.
* Fixed    Card media thumbnail action which happens on click.
* Fixed    Card layer link issue when there isn't any overlay/content.
* Fixed    Rendering raw content in card overview panel.
* Fixed    Wrong default SVG play icon in cards.

= 1.0.2 - May 30, 2019 =

* Improved Grid layout performance by changing CSS stacking context.
* Added    Plugin update from subsites for multisite.
* Fixed    Force refreshing plugin info to view latest plugin details on plugins page.
* Fixed    JS load more issue on scroll with carousel.
* Fixed    CSS flickers on grid items with Safari.
* Fixed    Select dropdown position after refreshing facets.
* Fixed    JS error when highlighting select item in dropdown list on facet refresh.
* Fixed    PHP warning when deleting taxonomy terms if missing facets.

= 1.0.1 - May 23, 2019 =

* Improved Check ACF link field url key for custom field action link (card builder).
* Changed  Warning notice for asynchronous hierarchical list for select facet.
* Fixed    Prevent hierarchical list for asynchronous select facet. (Props Marie Comet)
* Fixed    Missing jQuery dependancy (in some cases) in preview mode and in cards overview iframes.
* Fixed    Autoplay issue with embedded iframes in grid.
* Fixed    Issue with upload media button and WP Media iframe.
* Fixed    Issue with post type attachment and videos not correctly fetched.

= 1.0.0 - May 14, 2019 =

* Initial release \o/
