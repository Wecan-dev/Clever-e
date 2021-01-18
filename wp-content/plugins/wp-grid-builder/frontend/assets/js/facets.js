/*!
* WP Grid Builder Plugin
*
* @package   WP Grid Builder
* @author    Loïc Blascos
* @link      https://www.wpgridbuilder.com
* @copyright 2019-2020 Loïc Blascos
*
*/
!function(e){var t={};function n(r){if(t[r])return t[r].exports;var i=t[r]={i:r,l:!1,exports:{}};return e[r].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var i in e)n.d(r,i,function(t){return e[t]}.bind(null,i));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=6)}([function(e,t,n){"use strict";function r(e){return(r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}n.d(t,"a",(function(){return r}))},function(e,t,n){"use strict";(function(e,t){var r=n(0);!function(e,i){"object"==("undefined"==typeof exports?"undefined":Object(r.a)(exports))?t.exports=i(e):"function"==typeof define&&n(4)?define([],i.bind(e,e)):i(e)}(void 0!==e?e:void 0,(function(e){if(e.CSS&&e.CSS.escape)return e.CSS.escape;var t=function(e){if(0==arguments.length)throw new TypeError("`CSS.escape` requires an argument.");for(var t,n=String(e),r=n.length,i=-1,a="",s=n.charCodeAt(0);++i<r;)0!=(t=n.charCodeAt(i))?a+=t>=1&&t<=31||127==t||0==i&&t>=48&&t<=57||1==i&&t>=48&&t<=57&&45==s?"\\"+t.toString(16)+" ":(0!=i||1!=r||45!=t)&&(t>=128||45==t||95==t||t>=48&&t<=57||t>=65&&t<=90||t>=97&&t<=122)?n.charAt(i):"\\"+n.charAt(i):a+="�";return a};return e.CSS||(e.CSS={}),e.CSS.escape=t,t}))}).call(this,n(2),n(3)(e))},function(e,t){var n;n=function(){return this}();try{n=n||new Function("return this")()}catch(e){"object"==typeof window&&(n=window)}e.exports=n},function(e,t){e.exports=function(e){if(!e.webpackPolyfill){var t=Object.create(e);t.children||(t.children=[]),Object.defineProperty(t,"loaded",{enumerable:!0,get:function(){return t.l}}),Object.defineProperty(t,"id",{enumerable:!0,get:function(){return t.i}}),Object.defineProperty(t,"exports",{enumerable:!0}),t.webpackPolyfill=1}return t}},function(e,t){(function(t){e.exports=t}).call(this,{})},function(e,t){window.WP_Grid_Builder.on("init",(function(e){e.facets.on("render",(function(e){var t=this.facet,n=t.type,r=t.focused;if(["radio","checkbox","button"].includes(n)&&function(e){var t=e.querySelector("button.wpgb-toggle-hidden");if(!t)return;var n=t.previousElementSibling,r="wpgb-".concat(Math.random().toString(36).substr(2,9));t.setAttribute("aria-controls",r),n.id=r}(e),r&&e)switch(n){case"load_more":!function(e){var t=e.querySelector(".wpgb-load-more");t&&t.focus({preventScroll:!0})}(e);break;case"pagination":!function(e,t){var n=parseInt(t.getAttribute("data-page")||0,10);if(n){var r=t.textContent;isNaN(n);e.querySelectorAll('a[data-page="'.concat(n-1,'"], a[data-page="').concat(n,'"], a[data-page="').concat(n+1,'"]')).forEach((function(e){return r===e.textContent&&e.focus({preventScroll:!0})}))}}(e,r);break;case"select":case"sort":case"selection":case"range":case"date":case"search":case"per_page":case"result_count":case"reset":break;default:!function(e,t){var n=t.facet.focused.querySelector("input"),r=n&&n.value;if(n){var i=e.querySelector('[role="button"] input[type="hidden"][value="'.concat(r,'"]')),a=i&&i.closest('[role="button"]');a&&a.closest("[hidden]")&&t.toggleHidden(t.facet),a&&a.focus({preventScroll:!0})}}(e,this)}}))}))},function(e,t,n){"use strict";n.r(t);var r=function(e){var t;"function"==typeof Event?t=new CustomEvent(e):(t=document.createEvent("CustomEvent")).initEvent(e,!0,!0),window.dispatchEvent(t)};n(1);function i(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function a(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function s(e,t,n){return t&&a(e.prototype,t),n&&a(e,n),e}var o=[],c=function(){function e(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null;if(i(this,e),t&&(this.library=t,this.callback=n,this.getScript(),this.script))return this.isLoaded()?this.callback&&this.callback():void(this.isLoading()?this.bindEvents(o[this.script.handle].element):this.loadScript())}return s(e,[{key:"getScript",value:function(){var e=this;this.script=wpgb_settings.vendors.filter((function(t){return t.handle===e.library})),this.script=this.script.shift()}},{key:"isLoaded",value:function(){return o[this.library]&&o[this.library].loaded}},{key:"isLoading",value:function(){return o[this.library]&&o[this.library].loading}},{key:"loadScript",value:function(){var e=document.createElement("css"===this.script.type?"link":"script"),t=this.script.version?"?v=".concat(this.script.version):"";this.bindEvents(e),"css"===this.script.type?(e.href=this.script.source+t,e.rel="stylesheet"):e.src=this.script.source+t,document.head.appendChild(e),o[this.script.handle]={loading:!0,element:e}}},{key:"onLoad",value:function(){o[this.script.handle].loaded=!0,this.callback&&this.callback()}},{key:"onError",value:function(){o[this.script.handle].error=!0}},{key:"bindEvents",value:function(e){var t=this;e.addEventListener("load",(function(){return t.onLoad()})),e.addEventListener("error",(function(){return t.onerror()}))}}]),e}();function u(e){return(u=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}function l(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}var f=n(0);function d(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}function h(e,t){return!t||"object"!==Object(f.a)(t)&&"function"!=typeof t?d(e):t}function p(e){return function(){var t,n=u(e);if(l()){var r=u(this).constructor;t=Reflect.construct(n,arguments,r)}else t=n.apply(this,arguments);return h(this,t)}}function g(e,t){return(g=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function v(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&g(e,t)}function y(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}function m(e,t){if(e){if("string"==typeof e)return y(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(n):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?y(e,t):void 0}}function b(e){return function(e){if(Array.isArray(e))return y(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||m(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}var w=function(){function e(){i(this,e),this.listeners=new Map}return s(e,[{key:"canListen",value:function(e,t){return!("function"!=typeof t||!e)||(!("object"!==Object(f.a)(t)||!t[e])||(console.error('Invalid listener for event name: "'.concat(e,'"')),!1))}},{key:"exists",value:function(e,t){if(this.listeners.has(e))return this.listeners.get(e).find((function(e){return e.listener===t}))}},{key:"on",value:function(e,t){var n=arguments.length>2&&void 0!==arguments[2]&&arguments[2];return this.canListen(e,t)?(this.listeners.has(e)||this.listeners.set(e,[]),this.exists(e,t)||this.listeners.get(e).push({listener:t,once:n}),this):this}},{key:"once",value:function(e,t){return this.on(e,t,!0)}},{key:"off",value:function(e,t){var n=this.listeners.get(e)||[],r=n.findIndex((function(e){return e.listener===t}));return r>-1&&n.splice(r,1),n.length<1&&this.listeners.delete(e),this}},{key:"offAll",value:function(){return this.listeners.clear(),this}},{key:"emit",value:function(e){for(var t=this,n=arguments.length,r=new Array(n>1?n-1:0),i=1;i<n;i++)r[i-1]=arguments[i];var a=this.listeners.get(e)||[];return b(a).forEach((function(n){var i,a;(n.once&&t.off(e,n.listener),"object"===Object(f.a)(n.listener))?(i=n.listener[e]).apply.apply(i,[n.listener].concat(r)):(a=n.listener).apply.apply(a,[t].concat(r))})),this}}]),e}(),S=function(e){v(n,e);var t=p(n);function n(){var e;return i(this,n),(e=t.call(this)).vendors={},e.instances={},e}return s(n,[{key:"get",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,t=this.instances,n=[];if(!Object.keys(t).length)return[];for(var r in t)(t[r].id||"").toString()===e.toString()&&n.push(t[r]);return n}},{key:"instance",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0;return Object.keys(this.instances).length&&this.instances[e]?this.instances[e]:{}}}]),n}(w),k=Math.sign&&Array.from&&Array.prototype.fill&&Array.prototype.find&&Array.prototype.findIndex&&Array.prototype.includes&&Element.prototype.matches&&Element.prototype.closest&&NodeList.prototype.forEach&&window.Map&&window.URLSearchParams;function _(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function P(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function O(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?P(Object(n),!0).forEach((function(t){_(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):P(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}window.WP_Grid_Builder||(window.WP_Grid_Builder=k?new S:{get:function(){return[]},instance:function(){return[]},instances:function(){return[]},instantiate:function(){return[]},on:function(){return null},off:function(){return null},once:function(){return null},offAll:function(){return null},emit:function(){return null},vendors:{},unsupported:!0});var E={},x={},j={},A=0,C=function(e){v(n,e);var t=p(n);function n(e){var r,a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return i(this,n),r=t.call(this),e?e.instance?h(r,j[e.instance]):(r.element=e,r.options=O({},x,{},a),r.htmlInit(),r.id=r.options.id,r.setInstance(),r.setComment(),r.intiFacets(),r):h(r)}return s(n,[{key:"setInstance",value:function(){this.instance=++A,this.element.instance=this.instance,j[this.instance]=this}},{key:"setComment",value:function(){var e=this.element.previousSibling,t=e&&e.previousSibling,n=document.createComment(" Gridbuilder ᵂᴾ Plugin (https://wpgridbuilder.com) ");e&&8===e.nodeType||t&&8===t.nodeType||this.element.parentElement.insertBefore(n,this.element)}},{key:"htmlInit",value:function(){var e=this.element.getAttribute("data-options");e&&(e=JSON.parse(e),this.options=O({},this.options,{},e),this.element.removeAttribute("data-options"))}},{key:"intiFacets",value:function(){this.facets=WP_Grid_Builder.Facets(this.element,this.options)}},{key:"init",value:function(){this.element&&(this.element.classList.add("wpgb-enabled"),this.element.setAttribute("data-instance",this.instance),window.WP_Grid_Builder.emit("init",[this]),this.facets&&this.facets.init())}},{key:"destroy",value:function(){var e=Object.getOwnPropertyNames(this);if(this.element){this.facets.destroy(),this.element.classList.remove("wpgb-enabled"),this.element.setAttribute("data-options",JSON.stringify(this.options)),delete WP_Grid_Builder.instances[this.instance],delete this.element.instance,delete E[this.instance],delete j[this.instance];for(var t=0;t<e.length;t++)delete this[e[t]]}}}]),n}(w);function L(e,t){var n=0;return function(){var r=(new Date).getTime();if(!(r-n<t))return n=r,e.apply(void 0,arguments)}}var q=function(e){v(n,e);var t=p(n);function n(){return i(this,n),t.apply(this,arguments)}return s(n,[{key:"bindEvents",value:function(){var e=!(arguments.length>0&&void 0!==arguments[0])||arguments[0];e=e?"addEventListener":"removeEventListener",this.history&&window[e]("popstate",this),document[e]("click",this,!1),document[e]("change",this,!1),document[e]("keydown",this,!1)}},{key:"handleEvent",value:function(e){var t="on"+e.type;this[t]&&this[t](e)}},{key:"isFacet",value:function(e){var t=this,n='.wpgb-facet[data-grid="'.concat(CSS.escape(this.options.id),'"]'),r=e&&e.closest(n),i=r&&r.closest(".wp-grid-builder");if(!r)return!1;if(i&&i!==this.element)return!1;var a=this.getFacet(r.getAttribute("data-facet"));return a&&a.forEach((function(e){e.holder!==r||(t.facet=e)})),!!this.facet}},{key:"onpopstate",value:function(e){var t=e.state;t&&t.WP_Grid_Builder&&(delete this.loadMoreSlug,delete this.loadPageSlug,this.getURLParams(),this.fetch())}},{key:"onclick",value:function(e){if(this.isFacet(e.target)){switch(this.facet.type){case"pagination":this.handlePagination(e);break;case"load_more":this.handleLoadMore(e);break;case"reset":this.handleReset(e)}e.target.closest(".wpgb-toggle-hidden")&&this.toggleHidden(this.facet),this.toggleButton(e),delete this.facet}}},{key:"onchange",value:function(e){if(this.isFacet(e.target)){var t,n=e.target,r=n.value,i=n.name.replace("[]",""),a=this.getInputType(e.target,this.facet);t="select-multiple"===a?this.getSelectValues(e):this.getValues(e,r),"checkbox"===a?this.diffParams(i,t):this.setParams(i,t),this.emit("change",[i,t]),this.refresh(),delete this.facet}}},{key:"onkeydown",value:function(e){var t=e.keyCode;[13,32].includes(t)&&this.isFacet(e.target)&&(this.toggleButton(e),delete this.facet)}},{key:"handlePagination",value:function(e){var t=e.target.getAttribute("data-page");t&&(e.preventDefault(),this.loadPage(t))}},{key:"handleLoadMore",value:function(e){var t=this.facet.settings;!t||t.offset+t.number<1||e.target.closest(".wpgb-load-more")&&this.loadMore()}},{key:"handleReset",value:function(e){var t=this,n=this.facet.settings,r=n&&n.reset_facet;e.target.closest(".wpgb-reset")&&(r=(r=r.length&&"object"!==Object(f.a)(r)?[r]:r).length&&r.map((function(e){return(e=t.getFacet(parseInt(e,10)))&&e[0]&&e[0].slug})),this.reset(r))}},{key:"toggleButton",value:function(e){var t=e,n=(t.keyCode,t.target),r=n.closest('[role="button"]');if(r){var i="true"===r.getAttribute("aria-pressed"),a=r.querySelector("input");if(e.preventDefault(),e.stopImmediatePropagation(),a){var s=a.value,o=this.getInputType(a,this.facet);if(!i||"radio"!==o||""!==s){var c=n.closest(".wpgb-facet");if("radio"===o){var u=c.querySelectorAll('[role="button"][aria-pressed="true"]');if(u.forEach((function(e){return e.setAttribute("aria-pressed",!1)})),i&&u){var l=c.querySelector('[role="button"] input[type="hidden"][value=""]');l&&l.parentElement.setAttribute("aria-pressed",!0)}}else{if(c.querySelectorAll('[role="button"][aria-pressed="true"] input[type="hidden"][value=""]').forEach((function(e){return e.parentElement.setAttribute("aria-pressed",!1)})),i&&1===c.querySelectorAll('[role="button"][aria-pressed="true"]').length){var f=c.querySelector('[role="button"] input[type="hidden"][value=""]');f&&f.parentElement.setAttribute("aria-pressed",!0)}}r.setAttribute("aria-pressed",(!i).toString()),a.checked=!i,i&&"radio"===o&&(a.value=""),"function"==typeof Event?e=new Event("change",{bubbles:!0}):(e=document.createEvent("Event")).initEvent("change",!0,!0),a.dispatchEvent(e),a.value=s}}}}},{key:"toggleHidden",value:function(e){var t=e.holder,n=e.settings,r=t.querySelector("ul"),i=r&&t.querySelector(".wpgb-toggle-hidden"),a=r&&r.classList.contains("wpgb-expanded"),s=r&&a&&r.querySelectorAll("[hidden]");r&&(i.textContent=a?n.show_more_label.replace("[number]",s.length):n.show_less_label,i.setAttribute("aria-expanded",a?"false":"true"),r.classList.toggle("wpgb-expanded"))}},{key:"getValues",value:function(e,t){var n=[];return""===t?n:(n="range"===this.facet.type?this.getRange(e):this.getInput(t)).map(String).filter((function(e,t,n){return n.indexOf(e)===t}))}},{key:"getSelectValues",value:function(e){return b(e.target.closest("select").options).filter((function(e){return e.selected})).map((function(e){return e.value}))}},{key:"getInput",value:function(e){var t=[];try{e=JSON.parse(e)}catch(e){}return Array.isArray(e)?t=e:t.push(e),t}},{key:"getInputType",value:function(e,t){var n=e.type;return"select-multiple"===n||("checkbox"===t.type||"selection"===t.type||t.settings&&t.settings.multiple&&e.value?n="checkbox":"hidden"===n&&(n="radio")),n}},{key:"getRange",value:function(e){return b(e.target.closest(".wpgb-facet").querySelectorAll('input[type="range"]')).map((function(e){return e.value}))}}]),n}(function(e){v(n,e);var t=p(n);function n(){var e;i(this,n);for(var r=arguments.length,a=new Array(r),s=0;s<r;s++)a[s]=arguments[s];return _(d(e=t.call.apply(t,[this].concat(a))),"onscroll",L((function(){return e.check()}),100)),e}return s(n,[{key:"canObserve",value:function(){return"IntersectionObserver"in window&&"isIntersecting"in window.IntersectionObserverEntry.prototype}},{key:"observe",value:function(){this.canObserve()?this.loader&&this.observer().observe(this.loader):(window.addEventListener("scroll",this),this.check())}},{key:"unObserve",value:function(){if(this.intersection)return this.intersection.disconnect(),void delete this.intersection;window.removeEventListener("scroll",this)}},{key:"observer",value:function(){var e=this;return this.intersection=new IntersectionObserver((function(t,n){t.forEach((function(t){t.isIntersecting&&e.loader&&e.loader.click()}))}),{rootMargin:"600px"}),this.intersection}},{key:"check",value:function(){this.loader&&this.inView()&&this.loader&&this.loader.click()}},{key:"inView",value:function(e){var t=this.loader.getBoundingClientRect(),n=t.top,r=t.bottom,i=window.innerHeight;return n>=600&&n<=i||r>=0&&r<=i}}]),n}(w)),G={};Math.max,Math.min;function D(e,t,n){var r,i,a,s,o,c=!1,u=!0;if("function"!=typeof e)throw new TypeError(FUNC_ERROR_TEXT);function l(t){var n=r,s=i;return r=i=void 0,t,a=e.apply(s,n)}function d(e){return e,s=setTimeout(p,t),c?l(e):a}function h(e){var n=e-o;return void 0===o||n>=t||n<0||!1}function p(){var e=Date.now();if(h(e))return function(e){if(s=void 0,u&&r)return l(e);return r=i=void 0,a}(e);s=setTimeout(p,function(e){var n=t-(e-o);return n}(e))}return t=Number(t)||0,"object"===Object(f.a)(n)&&(c=!!n.leading,u="trailing"in n?!!n.trailing:u),function(){var e=Date.now(),n=h(e);if(r=arguments,i=this,o=e,n){if(void 0===s)return d(o);0}return void 0===s&&(s=setTimeout(p,t)),a}}var B=function(e){v(n,e);var t=p(n);function n(e){var r,a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return i(this,n),(r=t.call(this)).options=a,r.element=e,r.autoRefresh=!0,r.query(),Object.keys(r.facets).length?(r.setInstance(),r.canPush(),r):h(r)}return s(n,[{key:"setInstance",value:function(){this.element.facetGUID||(this.facetGUID=Object.keys(G).length+1,this.element.facetGUID=this.facetGUID)}},{key:"init",value:function(){var e=this.element.facetGUID;if(G[e]){var t=G[e].toString();this.params=new URLSearchParams(t)}else this.getURLParams(),this.getQueryString()&&this.pushState("replace");Object.keys(this.facets).length&&(this.bindEvents(),this.emit("init",[this.facets]),this.fetch("render"))}},{key:"destroy",value:function(){this.abort(),this.unObserve(),this.bindEvents(!1),this.loading(!1),delete this.loader,delete this.loadMoreSlug,delete this.loadPageSlug}},{key:"canPush",value:function(){var e=document.querySelectorAll(".wp-grid-builder");this.history=window.wpgb_settings&&wpgb_settings.history&&e.length<2}},{key:"refresh",value:function(){this.autoRefresh&&(this.unsetLoaders(),this.pushState(),this.fetch())}},{key:"reset",value:function(e){var t=this,n=this.getQueryString();n&&(e||(e=(e=Object.keys(this.facets)).map((function(e){return t.facets[e][0]&&t.facets[e][0].slug}))),"string"==typeof e&&(e=[e]),e.forEach((function(e){return t.deleteParams(e)})),n!==this.getQueryString()&&(this.emit("reset",[e]),this.unsetLoaders(),this.pushState(),this.fetch()))}},{key:"unsetLoaders",value:function(){var e=this,t=["pagination","load_more"],n=this.facets;(n=Object.keys(n).map((function(e){var r=n[e][0];return r&&t.includes(r.type)&&r.slug}))).forEach((function(t){return t&&e.deleteParams(t)}))}},{key:"loadMore",value:function(){if(!this.xhr||4===this.xhr.readyState){var e=this.facet,t=e.slug,n=e.settings,r=e.holder.querySelector(".wpgb-load-more"),i=(r&&r.getBoundingClientRect()).width;if(r){r.classList.add("wpgb-loading"),n.loading_text&&(r.style.minWidth="".concat(i,"px"),r.textContent=n.loading_text);var a=(n.number+n.offset).toString();this.loadMoreSlug=t,this.deleteParams(this.loadPageSlug),this.setParams(t,[a]),this.emit("change",[t,[a]]),this.fetch()}}}},{key:"loadPage",value:function(e){var t=this.facet.slug;this.getParam(t)[0]!==(e=e<2?"":e)&&(this.loadPageSlug=t,this.deleteParams(this.loadMoreSlug),this.setParams(t,[e]),this.emit("change",[t,e]),this.pushState(),this.fetch())}}]),n}(function(e){v(n,e);var t=p(n);function n(){return i(this,n),t.apply(this,arguments)}return s(n,[{key:"query",value:function(e){var t=this,n='.wpgb-facet[data-grid="'.concat(CSS.escape(this.options.id),'"]'),r=document.querySelectorAll(n);this.facets={},r.forEach((function(e){var n=e.getAttribute("data-facet"),r=e.closest(".wp-grid-builder");r&&r!==t.element||(t.facets.hasOwnProperty(n)||(t.facets[n]=[]),t.facet={id:n,init:!0,holder:e},t.facets[n].push(t.facet),WP_Grid_Builder.emit("prerender",[e,t.facet,t]))})),delete this.facet}},{key:"preFilter",value:function(){var e=this.facets;if(!this.getQueryString()){for(var t in e){var n=e[t],r=n.selected;r&&r.length&&this.setParams(n.slug,r)}this.pushState("replace")}}},{key:"getFacet",value:function(e){var t=this.facets,n=[];if(!Object.keys(t).length)return{};if(!e)return t;if(!isNaN(parseFloat(e))&&isFinite(e))return t.hasOwnProperty(e)&&(n=t[e]),n;for(var r in t){if(t.hasOwnProperty(r))if(t[r].filter((function(t){return t.slug===e})))return t[r]}return n}},{key:"hasFacet",value:function(e){return!!e&&!!this.getFacet(e).length}},{key:"render",value:function(e){var t=this;this.setFocused();var n=function(n){if(!e.hasOwnProperty(n)||!t.facets.hasOwnProperty(n))return"continue";t.facets[n].forEach((function(r,i){t.facet=O({},r,{},e[n]),t.facet.html&&t.facet.rendered||(t.remove(t.facet.holder),t.append(t.facet.holder)),"reset"===t.facet.type&&(t.facet.rendered=!!t.facet.html),t.emit("render",[t.facet.holder]),delete t.facet.focused,t.facets[n][i]=t.facet,t.initLoader()}))};for(var r in e)n(r);delete this.facet}},{key:"setFocused",value:function(){var e=document.activeElement;this.isFacet(e)&&(this.facet.focused=e)}},{key:"remove",value:function(e){for(;e.firstChild;)e.removeChild(e.firstChild)}},{key:"append",value:function(e){var t=document.createRange().createContextualFragment(this.facet.html);e.appendChild(t)}},{key:"initLoader",value:function(){var e=this.facet,t=e.type,n=e.settings,r=e.holder,i=this.options.layout;"load_more"===t&&(this.loader=r.querySelector(".wpgb-load-more"),this.loader&&!wpgb_settings.renderBlocks&&"onscroll"===n.load_more_event&&(this.loader.onScroll=!0,"horizontal"!==i&&(this.unObserve(),this.observe())))}}]),n}(function(e){v(n,e);var t=p(n);function n(){return i(this,n),t.apply(this,arguments)}return s(n,[{key:"getURLParams",value:function(){var e=window.location.search,t=this.history?e.slice(1):"";this.params=new URLSearchParams(t)}},{key:"getParams",value:function(e){var t,n={},r=function(e){if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(e=m(e))){var t=0,n=function(){};return{s:n,n:function(){return t>=e.length?{done:!0}:{done:!1,value:e[t++]}},e:function(e){throw e},f:n}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var r,i,a=!0,s=!1;return{s:function(){r=e[Symbol.iterator]()},n:function(){var e=r.next();return a=e.done,e},e:function(e){s=!0,i=e},f:function(){try{a||null==r.return||r.return()}finally{if(s)throw i}}}}(this.params.entries());try{for(r.s();!(t=r.n()).done;){var i=t.value,a=i[0].substring(1),s=i[1].split(",");if(e===a)return s;n[a]=s}}catch(e){r.e(e)}finally{r.f()}return e?[]:n}},{key:"getParam",value:function(e){return(this.params.get("_"+e)||"").split(",")}},{key:"hasParam",value:function(e){return e&&this.params.has("_"+e)}},{key:"setParams",value:function(e,t){t=(t=this.validateParams(t)).filter((function(e,t,n){return n.indexOf(e)===t})),this.updateParams(e,t)}},{key:"deleteParams",value:function(e,t){(t=this.validateParams(t)).length&&(t=this.getParam(e).filter((function(e){return t.indexOf(e)<0}))),this.updateParams(e,t)}},{key:"diffParams",value:function(e,t){var n=this.getParam(e);(t=this.validateParams(t)).forEach((function(e){var t=n.indexOf(e);-1===t?n.push(e):n.splice(t,1)})),this.updateParams(e,n)}},{key:"updateParams",value:function(e,t){e="_"+e,(t=t.filter((function(e){return e.trim().length})))&&t.length?this.params.set(e,t.join(",")):this.params.delete(e)}},{key:"validateParams",value:function(e){return Array.isArray(e)?(e=e.filter((function(e){return"string"==typeof e||"number"==typeof e&&!isNaN(e)}))).map(String):[]}},{key:"getQueryString",value:function(){return this.params.toString()}}]),n}(function(e){v(n,e);var t=p(n);function n(){var e;i(this,n);for(var r=arguments.length,a=new Array(r),s=0;s<r;s++)a[s]=arguments[s];return _(d(e=t.call.apply(t,[this].concat(a))),"loadContent",D((function(t){e.emit("refresh");var n=e.formData(),r=e.getQueryString(),i=wpgb_settings.ajaxUrl+"&action="+t+(r?"&"+r:"");e.loading(!0,t),e.xhr=new XMLHttpRequest,e.xhr.onload=function(n){return e.onLoad(n,t)},e.xhr.open("POST",i),e.xhr.send(n)}),150,{leading:!0})),e}return s(n,[{key:"isLoadingMore",value:function(){return this.hasParam(this.loadMoreSlug)}},{key:"isLoadingPage",value:function(){return this.hasParam(this.loadPageSlug)}},{key:"pushState",value:function(){var e,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"push";this.history&&("scrollRestoration"in history&&(window.history.scrollRestoration="manual"),e=""!==(e=this.getQueryString())?"?"+e:"",e+=window.location.hash,window.history["".concat(t,"State")]({WP_Grid_Builder:!0},null,window.location.pathname+e))}},{key:"formData",value:function(){var e=new FormData,t=this.getSettings();return e.append("wpgb",JSON.stringify(t)),e}},{key:"getSettings",value:function(){var e=window.wpgb_preview_settings||{},t=window.wpgb_settings||{},n=Object.keys(this.facets);return e.is_main_query=this.options.isMainQuery,e.main_query=t.mainQuery,e.facet_args=this.getParams(),e.permalink=t.permalink,e.facets=n.map(Number),e.lang=t.lang,e.id=this.options.id,this.options.isGutenberg&&(e.is_gutenberg=!0),this.options.isPreview&&(e.is_preview=!0),this.options.isTemplate&&(e.is_template=this.options.isTemplate,e.source_type=this.options.sourceType,e.query_args=this.options.queryArgs,e.render_callback=this.options.renderCallback,e.noresults_callback=this.options.noresultsCallback),e}},{key:"fetch",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"refresh";this.abort(),this.loadContent(e)}},{key:"abort",value:function(){this.xhr&&this.xhr.abort(),delete this.xhr}},{key:"loading",value:function(e,t){var n=this.facets;if(("add"!==(e=e?"add":"remove")||"render"!==t&&!this.isLoadingMore())&&(this.element.classList[e]("wpgb-loading"),"add"!==e||!this.isLoadingPage()))for(var r in n){var i=n[r];["pagination","load_more","search"].includes(i.type)||i.forEach((function(t){return t.holder.classList[e]("wpgb-loading")}))}}},{key:"onLoad",value:function(e,t){var n=JSON.parse(e.target.responseText),r=n.facets,i=n.posts,a=this.isLoadingMore()?"append":"replace";this.loading(),this.render(r),this.emit("loaded",[this.facets]),"refresh"===t?this.appendItems(i,a):this.preFilter(),G[this.element.facetGUID]=this.getQueryString()}},{key:"appendItems",value:function(e,t){if(e){var n=document.createRange().createContextualFragment(e);if(this.options.isTemplate)this.appendTemplate(n,t);else if((e=n.querySelectorAll(".wpgb-card")).length){var r=this.element.querySelector(".wpgb-viewport > div");r&&(r.appendChild(n),this.emit("appended",[e,t]))}}}},{key:"appendTemplate",value:function(e,t){if("replace"===t)for(;this.element.firstChild;){var n=this.element.firstChild;this.element.removeChild(n),n=null}this.element.appendChild(e),this.emit("appended",[e,t])}}]),n}(q)))),I="undefined"!=typeof Map&&new Map,R={};function F(e){return I.has(e.instance)}function W(e,t){e.instance=function(e){return R[e.type]||(R[e.type]=0),"".concat(e.type,"-").concat(++R[e.type])}(e),I.set(e.instance,t)}function M(e){return I.get(e.instance)}function T(e){I.delete(e.instance)}function N(e){"date"===this.facet.type&&(this.facet.html?U.apply(this,[e,this.facet]):V.apply(this,[e,this.facet]))}function U(e,t){e.querySelector(".wpgb-date-facet")&&(t.rendered?J(e,t):Q.apply(this,[e,t]),t.rendered=!0)}function Q(e,t){var n=this;WP_Grid_Builder.Date((function(r){var i=n.getFacet(t.id),a=e.querySelector("input.wpgb-date"),s=document.activeElement===a;i.length&&a?(t.selected=i[0].selected||t.selected,t.settings.locale=t.settings.locale.substring(0,2),t.settings.locale="ca"===t.settings.locale?"cat":t.settings.locale,n.emit("date.options",[t.settings,t]),r=r(a,t.settings),s&&r._input&&r._input.focus(),W(t,r),function(e,t){var n=e.querySelector(".wpgb-date-clear"),r=e.querySelector("input"),i=M(t),a=i.config.mode,s="";i.config.onOpen.push((function(){return s=i.selectedDates})),i.config.onClose.push((function(){if("range"===a&&1===i.selectedDates.length){var e=s.map((function(e){return i.formatDate(e,"Y-m-d")}));i.setDate(e)}})),r.addEventListener("change",(function(e){if("range"===a&&1===i.selectedDates.length)return e.preventDefault(),void e.stopPropagation();var t=i.selectedDates.map((function(e){return i.formatDate(e,"Y-m-d")}));t=t.filter((function(e,t,n){return n.indexOf(e)===t})),r.value="range"===a?t.length?t:"":t.length?t[0]:"",n.style.display=t.length?"block":""})),n&&n.addEventListener("click",(function(e){e.preventDefault(),i.clear(),i.altInput.focus(),i.close()}))}(e,t),J(e,t),n.emit("date.init",[r,t])):V.apply(n,[e,t])}))}function V(e,t){F(t)&&(M(t).destroy(),T(t),this.emit("date.destroy",[t])),t.rendered=!1}function J(e,t){if(F(t)){var n=t.selected,r=e.querySelector(".wpgb-date-clear");M(t).setDate(n),r&&(r.style.display=n&&n.length?"block":"")}}function H(e){"range"===this.facet.type&&(this.facet.html?z.apply(this,[e,this.facet]):Y.apply(this,[e,this.facet]))}function z(e,t){e.querySelector(".wpgb-range-facet")&&(t.rendered?function(e,t){var n=M(t),r=document.createRange().createContextualFragment(t.html).querySelectorAll(".wpgb-range-facet input"),i=["step","min","max","value"];r.forEach((function(e,t){return i.forEach((function(e){return n.inputs[t][e]=r[t][e]}))})),n.previous=[n.inputs[0].value,n.inputs[1].value],n.setValues(),n.getSliderSize(),n.updateSlider()}(0,t):X.apply(this,[e,t]),t.rendered=!0)}function X(e,t){var n=this;WP_Grid_Builder.Range((function(r){var i=n.getFacet(t.id),a=e.querySelector(".wpgb-range-facet"),s=e.querySelector(".wpgb-range-facet-loader");i.length&&a?(t.selected=i[0].selected||t.selected,n.emit("range.options",[t.settings,t]),r=r(a,t.settings),W(t,r),s&&s.parentElement.removeChild(s),n.emit("range.init",[r,t])):Y.apply(n,[e,n.facet])}))}function Y(e,t){F(t)&&(M(t).destroy(),T(t),this.emit("range.destroy",[t])),t.rendered=!1}window.WP_Grid_Builder.on("prerender",(function(e,t,n){e.querySelector(".wpgb-date-facet")&&WP_Grid_Builder.Date()})),window.WP_Grid_Builder.on("init",(function(e){e.facets.on("render",N)})),window.WP_Grid_Builder.on("prerender",(function(e,t,n){e.querySelector(".wpgb-range-facet")&&WP_Grid_Builder.Range()})),window.WP_Grid_Builder.on("init",(function(e){e.facets.on("render",H)}));var $,K,Z;n(5);function ee(e){"search"===this.facet.type&&(this.facet.html?(te.apply(this,[e,this.facet]),this.facet.rendered=!0):this.facet.rendered=!1)}function te(e,t){var n=this,r=e.querySelector('input[type="search"]');r&&(r!==document.activeElement&&function(e,t){var n=document.createRange().createContextualFragment(t.html).querySelector('input[type="search"]');e&&n&&(e.value=n.value,t.search=n.value)}(r,t),t.settings.instant_search&&!t.rendered&&(r.addEventListener("input",D((function(e){return ne.apply(n,[e,t])}),350)),r.addEventListener("change",(function(e){return e.stopPropagation()}))))}function ne(e,t){var n=e.target.value.trim();t.search!==n?(t.search=n,this.setParams(t.slug,[n]),this.emit("change",[t.slug,n?[n]:[]]),this.refresh()):e.stopPropagation()}function re(e){"sort"!==this.facet.type&&"select"!==this.facet.type&&"per_page"!==this.facet.type||(this.facet.html?ie.apply(this,[e,this.facet]):se.apply(this,[e,this.facet]))}function ie(e,t){e.querySelector("select.wpgb-combobox")&&(t.rendered?function(e,t){var n=t.settings,r=t.html,i=M(t),a=i.element,s=document.createRange().createContextualFragment(r).querySelectorAll("select option"),o=[];Array.from(a.options).forEach((function(e){return a.remove(e)})),s.forEach((function(e,t){e.selected&&o.push(e.value),a.add(e,t)})),a.multiple||(a.value=o[0]||"");i&&(!n.async&&i.Data.parse(),n.async&&i.close(),i.DOM.clearDropDown(),requestAnimationFrame((function(){return i.update()})))}(0,t):ae.apply(this,[e,t]),t.rendered=!0)}function ae(e,t){var n=this;WP_Grid_Builder.Select((function(r){var i=n.getFacet(t.id),a=e.querySelector("select.wpgb-combobox");i.length&&a?(t.selected=i[0].selected||t.selected,n.emit("select.options",[t.settings,t]),(r=r(a,oe.apply(n,[e,t]))).init(),W(t,r),n.emit("select.init",[r,t])):se.apply(n,[e,n.facet])}))}function se(e,t){F(t)&&(M(t).destroy(),T(t),this.emit("select.destroy",[t])),t.rendered=!1}function oe(e,t){var n=this,r={messages:O({},wpgb_settings.combobox)};return t&&t.settings?(r.messages.noResults=t.settings.no_results,r.messages.loading=t.settings.loading,r.messages.search=t.settings.search,r.searchable=t.settings.searchable,r.clearable=t.settings.clearable,t.settings.async&&(r.async={url:wpgb_settings.ajaxUrl.replace("?wpgb-ajax=wpgb_front",""),data:function(e){var t=n.getParams(),r={"wpgb-ajax":"wpgb_front",action:"search"};for(var i in t)r["_"+i]=t[i];return r},post:function(t){var r=new FormData,i=n.getSettings();return i.search={facet:Number(e.getAttribute("data-facet")),string:t},r.append("wpgb",JSON.stringify(i)),r},response:function(e){var t=[];return e.length&&e.forEach((function(e){t.push({value:e.facet_value,textContent:e.facet_name,disabled:e.disabled})})),t}}),r):r}window.WP_Grid_Builder.on("init",(function(e){e.facets.on("render",ee)})),window.WP_Grid_Builder.on("prerender",(function(e,t,n){e.querySelector("select.wpgb-combobox")&&WP_Grid_Builder.Select()})),window.WP_Grid_Builder.on("init",(function(e){e.facets.on("render",re)})),WP_Grid_Builder.unsupported?($=document.querySelectorAll(".wpgb-facet"),K=document.querySelectorAll(".wpgb-sidebar"),$&&$.forEach((function(e){var t=e.firstElementChild;t&&"wpgb-pagination-facet"!==t.className?e.style.display="none":e.classList.remove("wpgb-loading")})),K&&K.forEach((function(e){return e.parentElement.removeChild(e)}))):(Z=wpgb_settings.hasGrids,WP_Grid_Builder.Facets=function(e,t){return new B(e,t)},WP_Grid_Builder.Range=function(e,t){new c("wpgb-range",(function(){return e&&e(WP_Grid_Builder.vendors.range,t)}))},WP_Grid_Builder.Date=function(e,t){new c("wpgb-date-css"),new c("wpgb-date",(function(){return e&&e(WP_Grid_Builder.vendors.date,t)}))},WP_Grid_Builder.Select=function(e,t){new c("wpgb-select",(function(){return e&&e(WP_Grid_Builder.vendors.select,t)}))},Z?r("wpgb.facets.loaded"):(WP_Grid_Builder.instantiate=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=++Object.keys(this.instances).length;return this.instances[n]=new C(e,t)},function(e){if("complete"===document.readyState||"interactive"===document.readyState)return e();document.addEventListener("DOMContentLoaded",e)}((function(){return r("wpgb.loaded")}))))}]);