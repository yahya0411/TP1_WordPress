(()=>{var e={27418:e=>{"use strict";var t=Object.getOwnPropertySymbols,r=Object.prototype.hasOwnProperty,n=Object.prototype.propertyIsEnumerable;e.exports=function(){try{if(!Object.assign)return!1;var e=new String("abc");if(e[5]="de","5"===Object.getOwnPropertyNames(e)[0])return!1;for(var t={},r=0;r<10;r++)t["_"+String.fromCharCode(r)]=r;if("0123456789"!==Object.getOwnPropertyNames(t).map((function(e){return t[e]})).join(""))return!1;var n={};return"abcdefghijklmnopqrst".split("").forEach((function(e){n[e]=e})),"abcdefghijklmnopqrst"===Object.keys(Object.assign({},n)).join("")}catch(e){return!1}}()?Object.assign:function(e,o){for(var u,i,c=function(e){if(null==e)throw new TypeError("Object.assign cannot be called with null or undefined");return Object(e)}(e),l=1;l<arguments.length;l++){for(var a in u=Object(arguments[l]))r.call(u,a)&&(c[a]=u[a]);if(t){i=t(u);for(var f=0;f<i.length;f++)n.call(u,i[f])&&(c[i[f]]=u[i[f]])}}return c}},92703:(e,t,r)=>{"use strict";var n=r(50414);function o(){}function u(){}u.resetWarningCache=o,e.exports=function(){function e(e,t,r,o,u,i){if(i!==n){var c=new Error("Calling PropTypes validators directly is not supported by the `prop-types` package. Use PropTypes.checkPropTypes() to call them. Read more at http://fb.me/use-check-prop-types");throw c.name="Invariant Violation",c}}function t(){return e}e.isRequired=e;var r={array:e,bigint:e,bool:e,func:e,number:e,object:e,string:e,symbol:e,any:e,arrayOf:t,element:e,elementType:e,instanceOf:t,node:e,objectOf:t,oneOf:t,oneOfType:t,shape:t,exact:t,checkPropTypes:u,resetWarningCache:o};return r.PropTypes=r,r}},45697:(e,t,r)=>{e.exports=r(92703)()},50414:e=>{"use strict";e.exports="SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED"},72408:(e,t,r)=>{"use strict";var n=r(27418),o="function"==typeof Symbol&&Symbol.for,u=o?Symbol.for("react.element"):60103,i=o?Symbol.for("react.portal"):60106,c=o?Symbol.for("react.fragment"):60107,l=o?Symbol.for("react.strict_mode"):60108,a=o?Symbol.for("react.profiler"):60114,f=o?Symbol.for("react.provider"):60109,s=o?Symbol.for("react.context"):60110,p=o?Symbol.for("react.forward_ref"):60112,y=o?Symbol.for("react.suspense"):60113,d=o?Symbol.for("react.memo"):60115,b=o?Symbol.for("react.lazy"):60116,v="function"==typeof Symbol&&Symbol.iterator;function m(e){for(var t="https://reactjs.org/docs/error-decoder.html?invariant="+e,r=1;r<arguments.length;r++)t+="&args[]="+encodeURIComponent(arguments[r]);return"Minified React error #"+e+"; visit "+t+" for the full message or use the non-minified dev environment for full errors and additional helpful warnings."}var h={isMounted:function(){return!1},enqueueForceUpdate:function(){},enqueueReplaceState:function(){},enqueueSetState:function(){}},g={};function w(e,t,r){this.props=e,this.context=t,this.refs=g,this.updater=r||h}function _(){}function O(e,t,r){this.props=e,this.context=t,this.refs=g,this.updater=r||h}w.prototype.isReactComponent={},w.prototype.setState=function(e,t){if("object"!=typeof e&&"function"!=typeof e&&null!=e)throw Error(m(85));this.updater.enqueueSetState(this,e,t,"setState")},w.prototype.forceUpdate=function(e){this.updater.enqueueForceUpdate(this,e,"forceUpdate")},_.prototype=w.prototype;var S=O.prototype=new _;S.constructor=O,n(S,w.prototype),S.isPureReactComponent=!0;var j={current:null},E=Object.prototype.hasOwnProperty,k={key:!0,ref:!0,__self:!0,__source:!0};function P(e,t,r){var n,o={},i=null,c=null;if(null!=t)for(n in void 0!==t.ref&&(c=t.ref),void 0!==t.key&&(i=""+t.key),t)E.call(t,n)&&!k.hasOwnProperty(n)&&(o[n]=t[n]);var l=arguments.length-2;if(1===l)o.children=r;else if(1<l){for(var a=Array(l),f=0;f<l;f++)a[f]=arguments[f+2];o.children=a}if(e&&e.defaultProps)for(n in l=e.defaultProps)void 0===o[n]&&(o[n]=l[n]);return{$$typeof:u,type:e,key:i,ref:c,props:o,_owner:j.current}}function C(e){return"object"==typeof e&&null!==e&&e.$$typeof===u}var x=/\/+/g,R=[];function $(e,t,r,n){if(R.length){var o=R.pop();return o.result=e,o.keyPrefix=t,o.func=r,o.context=n,o.count=0,o}return{result:e,keyPrefix:t,func:r,context:n,count:0}}function T(e){e.result=null,e.keyPrefix=null,e.func=null,e.context=null,e.count=0,10>R.length&&R.push(e)}function I(e,t,r,n){var o=typeof e;"undefined"!==o&&"boolean"!==o||(e=null);var c=!1;if(null===e)c=!0;else switch(o){case"string":case"number":c=!0;break;case"object":switch(e.$$typeof){case u:case i:c=!0}}if(c)return r(n,e,""===t?"."+q(e,0):t),1;if(c=0,t=""===t?".":t+":",Array.isArray(e))for(var l=0;l<e.length;l++){var a=t+q(o=e[l],l);c+=I(o,a,r,n)}else if(null===e||"object"!=typeof e?a=null:a="function"==typeof(a=v&&e[v]||e["@@iterator"])?a:null,"function"==typeof a)for(e=a.call(e),l=0;!(o=e.next()).done;)c+=I(o=o.value,a=t+q(o,l++),r,n);else if("object"===o)throw r=""+e,Error(m(31,"[object Object]"===r?"object with keys {"+Object.keys(e).join(", ")+"}":r,""));return c}function A(e,t,r){return null==e?0:I(e,"",t,r)}function q(e,t){return"object"==typeof e&&null!==e&&null!=e.key?function(e){var t={"=":"=0",":":"=2"};return"$"+(""+e).replace(/[=:]/g,(function(e){return t[e]}))}(e.key):t.toString(36)}function D(e,t){e.func.call(e.context,t,e.count++)}function F(e,t,r){var n=e.result,o=e.keyPrefix;e=e.func.call(e.context,t,e.count++),Array.isArray(e)?L(e,n,r,(function(e){return e})):null!=e&&(C(e)&&(e=function(e,t){return{$$typeof:u,type:e.type,key:t,ref:e.ref,props:e.props,_owner:e._owner}}(e,o+(!e.key||t&&t.key===e.key?"":(""+e.key).replace(x,"$&/")+"/")+r)),n.push(e))}function L(e,t,r,n,o){var u="";null!=r&&(u=(""+r).replace(x,"$&/")+"/"),A(e,F,t=$(t,u,n,o)),T(t)}var N={current:null};function B(){var e=N.current;if(null===e)throw Error(m(321));return e}var U={ReactCurrentDispatcher:N,ReactCurrentBatchConfig:{suspense:null},ReactCurrentOwner:j,IsSomeRendererActing:{current:!1},assign:n};t.Children={map:function(e,t,r){if(null==e)return e;var n=[];return L(e,n,null,t,r),n},forEach:function(e,t,r){if(null==e)return e;A(e,D,t=$(null,null,t,r)),T(t)},count:function(e){return A(e,(function(){return null}),null)},toArray:function(e){var t=[];return L(e,t,null,(function(e){return e})),t},only:function(e){if(!C(e))throw Error(m(143));return e}},t.Component=w,t.Fragment=c,t.Profiler=a,t.PureComponent=O,t.StrictMode=l,t.Suspense=y,t.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED=U,t.cloneElement=function(e,t,r){if(null==e)throw Error(m(267,e));var o=n({},e.props),i=e.key,c=e.ref,l=e._owner;if(null!=t){if(void 0!==t.ref&&(c=t.ref,l=j.current),void 0!==t.key&&(i=""+t.key),e.type&&e.type.defaultProps)var a=e.type.defaultProps;for(f in t)E.call(t,f)&&!k.hasOwnProperty(f)&&(o[f]=void 0===t[f]&&void 0!==a?a[f]:t[f])}var f=arguments.length-2;if(1===f)o.children=r;else if(1<f){a=Array(f);for(var s=0;s<f;s++)a[s]=arguments[s+2];o.children=a}return{$$typeof:u,type:e.type,key:i,ref:c,props:o,_owner:l}},t.createContext=function(e,t){return void 0===t&&(t=null),(e={$$typeof:s,_calculateChangedBits:t,_currentValue:e,_currentValue2:e,_threadCount:0,Provider:null,Consumer:null}).Provider={$$typeof:f,_context:e},e.Consumer=e},t.createElement=P,t.createFactory=function(e){var t=P.bind(null,e);return t.type=e,t},t.createRef=function(){return{current:null}},t.forwardRef=function(e){return{$$typeof:p,render:e}},t.isValidElement=C,t.lazy=function(e){return{$$typeof:b,_ctor:e,_status:-1,_result:null}},t.memo=function(e,t){return{$$typeof:d,type:e,compare:void 0===t?null:t}},t.useCallback=function(e,t){return B().useCallback(e,t)},t.useContext=function(e,t){return B().useContext(e,t)},t.useDebugValue=function(){},t.useEffect=function(e,t){return B().useEffect(e,t)},t.useImperativeHandle=function(e,t,r){return B().useImperativeHandle(e,t,r)},t.useLayoutEffect=function(e,t){return B().useLayoutEffect(e,t)},t.useMemo=function(e,t){return B().useMemo(e,t)},t.useReducer=function(e,t,r){return B().useReducer(e,t,r)},t.useRef=function(e){return B().useRef(e)},t.useState=function(e){return B().useState(e)},t.version="16.14.0"},67294:(e,t,r)=>{"use strict";e.exports=r(72408)}},t={};function r(n){var o=t[n];if(void 0!==o)return o.exports;var u=t[n]={exports:{}};return e[n](u,u.exports,r),u.exports}r.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return r.d(t,{a:t}),t},r.d=(e,t)=>{for(var n in t)r.o(t,n)&&!r.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},r.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{"use strict";var e=r(67294);const t=window.wp.i18n;const n={align:{type:"string",default:"wide"},accent_color:{type:"string",default:"#68bb6c"}};var o=r(45697),u=r.n(o),i=["color","size"];function c(){return c=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var n in r)Object.prototype.hasOwnProperty.call(r,n)&&(e[n]=r[n])}return e},c.apply(this,arguments)}function l(e,t){if(null==e)return{};var r,n,o=function(e,t){if(null==e)return{};var r,n,o={},u=Object.keys(e);for(n=0;n<u.length;n++)r=u[n],t.indexOf(r)>=0||(o[r]=e[r]);return o}(e,t);if(Object.getOwnPropertySymbols){var u=Object.getOwnPropertySymbols(e);for(n=0;n<u.length;n++)r=u[n],t.indexOf(r)>=0||Object.prototype.propertyIsEnumerable.call(e,r)&&(o[r]=e[r])}return o}var a={white:"#fff",grey:"#555d66",give:"#66bb6a"},f=function(t){var r=t.color,n=void 0===r?"give":r,o=t.size,u=void 0===o?"24px":o,f=l(t,i);return e.createElement("svg",c({xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 157.2 157.2",width:u,height:u},f),e.createElement("circle",{fill:a[n],cx:"78.6",cy:"78.6",r:"78.6"}),e.createElement("path",{fill:"#fff",d:"M89.8 84.2c.3.7 1 1.3 1 1.3 13.9 1.7 33.6-.2 48.6-2.2-8.6 18.5-24 30.8-38.1 30.8-26.5 0-46.9-32.1-46.9-32.1 8.2-7.2 21.7-30.8 41.2-30.8s28 10.7 28 10.7l2.2-3.5s-9.1-31.9-34.9-31.9-53.2 42.3-69.2 52c0 0 22 52.2 70.2 52.2 40.4 0 50.6-38.6 52.5-48.2 5.4-.8 9.9-1.6 12.8-2.1 1-2.2 2.1-6.1 1.3-11.3-16.1 6.2-40.5 13.2-69.1 13.2-.1 0 0 1 .4 1.9z"}))};f.propTypes={color:u().oneOf(Object.keys(a)),size:u().oneOfType([u().number,u().string])};const s=f;var p=wp.compose.useInstanceId,y=wp.components,d=y.BaseControl,b=y.ColorPalette,v=function t(r){var n=r.name,o=r.label,u=r.help,i=r.className,c=r.value,l=r.hideLabelFromVision,a=r.onChange,f=r.colors,s=p(t),y="give-color-control-".concat(n,"-").concat(s);return e.createElement(d,{label:o,hideLabelFromVision:l,id:y,help:u,className:i},e.createElement(b,{value:c,colors:f,onChange:function(e){return a(e)},clearable:!0}))};v.propTypes={label:u().string,value:u().any.isRequired,onChange:u().func,name:u().string.isRequired,help:u().string,className:u().string,hideLabelFromVision:u().bool},v.defaultProps={onChange:null,options:null};const m=v;function h(e){return h="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},h(e)}function g(e,t,r){return(t=function(e){var t=function(e,t){if("object"!==h(e)||null===e)return e;var r=e[Symbol.toPrimitive];if(void 0!==r){var n=r.call(e,t||"default");if("object"!==h(n))return n;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===t?String:Number)(e)}(e,"string");return"symbol"===h(t)?t:String(t)}(t))in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}var w=wp.blockEditor.InspectorControls,_=wp.components,O=_.PanelBody,S=(_.ToggleControl,giveProgressBarThemeSupport.editorColorPalette);const j=function(r){var n=r.attributes,o=r.setAttributes,u=n.accent_color;return e.createElement(w,{key:"inspector"},e.createElement(O,{title:(0,t.__)("Appearance","give"),initialOpen:!0},e.createElement(m,{colors:S,name:"color",label:(0,t.__)("Accent Color","give"),onChange:function(e){return function(e,t){o(g({},e,t))}("accent_color",e)},value:u})))};var E=wp.element.Fragment,k=wp.serverSideRender;const P=function(t){var r=t.attributes,n=t.setAttributes;return e.createElement(E,null,e.createElement(j,{attributes:r,setAttributes:n}),e.createElement(k,{block:"give/donor-dashboard",attributes:r}))};(0,wp.blocks.registerBlockType)("give/donor-dashboard",{title:(0,t.__)("Donor Dashboard","give"),description:(0,t.__)("The Donor Dashboard block allows donors to modify and review their donor information from the front-end.","give"),category:"give",icon:e.createElement(s,{color:"grey"}),keywords:[(0,t.__)("donor","give"),(0,t.__)("dashboard","give")],attributes:n,supports:{align:["wide"]},edit:P,save:function(){return null}})})()})();