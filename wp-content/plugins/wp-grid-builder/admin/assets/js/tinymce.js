/*!
* WP Grid Builder Plugin
*
* @package   WP Grid Builder
* @author    Loïc Blascos
* @link      https://www.wpgridbuilder.com
* @copyright 2019-2020 Loïc Blascos
*
*/
!function(r){r(function(){"use strict";var e,a,o;function c(t){return t.map(function(t){return{text:t.label,value:t.value}})}function t(t){return r.ajax({url:wpApiSettings.root+"wp_grid_builder/v1/get/?type="+t,method:"GET",beforeSend:function(t){t.setRequestHeader("X-WP-Nonce",wpApiSettings.nonce)}})}window.wpApiSettings&&window.wpgb_tinymce&&(wpgb_tinymce.settings[0].onSelect=function(){var t=e.find("#facet")[0];"facet"===this.value()?t.parent().show():t.parent().hide()},r(document).ready(function(){"undefined"!=typeof tinymce&&tinymce.PluginManager.add("wpgb",function(d){d.addCommand("wpgb-grid-shortcode",function(){(e=d.windowManager.open({id:"wpgb-grid-shortcode",title:"Gridbuilder ᵂᴾ",icon:"dashicons-screenoptions",fixedWidth:!1,width:580,height:200,popup_css:!1,resizable:!0,inline:!0,autoScroll:!1,body:wpgb_tinymce.settings,onsubmit:function(t){var e=t.data.type,n=t.data.grid,i=t.data.facet;"grid"===e&&n?d.insertContent('[wpgb_grid id="'+n+'"]'):"facet"===e&&n&&i&&d.insertContent('[wpgb_facet id="'+i+'" grid="'+n+'"]')}})).find("#facet").parent().hide(),function(){if(!a&&!o){var n=e.find("#grid")[0],i=e.find("#facet")[0];r.when(t("grids"),t("facets")).then(function(t,e){t[0]&&e[0]&&(a=c(t[0]),o=c(e[0]),n.state.data.menu=a,n.settings.values=a,i.state.data.menu=o,i.settings.values=o,wpgb_tinymce.settings[2].values=a,wpgb_tinymce.settings[1].values=o)},function(){o=a=!0})}}()}),d.addButton("wpgb",{tooltip:"Gridbuilder ᵂᴾ",image:wpgb_tinymce.icon,onclick:function(){d.execCommand("wpgb-grid-shortcode","",{name:""})}})})}))})}(jQuery);