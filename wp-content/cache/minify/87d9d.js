var kirkiPostMessage={fields:{},styleTag:{add:function(id){id=id.replace(/[^\w\s]/gi,'-');if(null===document.getElementById('kirki-postmessage-'+id)||'undefined'===typeof document.getElementById('kirki-postmessage-'+id)){jQuery('head').append('<style id="kirki-postmessage-'+id+'"></style>');}},addData:function(id,styles){id=id.replace('[','-').replace(']','');kirkiPostMessage.styleTag.add(id);jQuery('#kirki-postmessage-'+id).text(styles);}},util:{processValue:function(output,value){var self=this,settings=window.parent.wp.customize.get(),excluded=false;if('object'===typeof value){_.each(value,function(subValue,key){value[key]=self.processValue(output,subValue);});return value;}
output=_.defaults(output,{prefix:'',units:'',suffix:'',value_pattern:'$',pattern_replace:{},exclude:[]});if(1<=output.exclude.length){_.each(output.exclude,function(exclusion){if(value==exclusion){excluded=true;}});}
if(excluded){return false;}
value=output.value_pattern.replace(new RegExp('\\$','g'),value);_.each(output.pattern_replace,function(id,placeholder){if(!_.isUndefined(settings[id])){value=value.replace(placeholder,settings[id]);}});return output.prefix+value+output.units+output.suffix;},backgroundImageValue:function(url){return(-1===url.indexOf('url('))?'url('+url+')':url;}},css:{fromOutput:function(output,value,controlType){var styles='',mediaQuery=false,processedValue;try{value=JSON.parse(value);}catch(e){}
if(output.js_callback&&'function'===typeof window[output.js_callback]){value=window[output.js_callback[0]](value,output.js_callback[1]);}
styles=wp.hooks.applyFilters('kirkiPostMessageStylesOutput',styles,value,output,controlType);if(''===styles){switch(controlType){case'kirki-multicolor':case'kirki-sortable':styles+=output.element+'{';_.each(value,function(val,key){if(output.choice&&key!==output.choice){return;}
processedValue=kirkiPostMessage.util.processValue(output,val);if(''===processedValue){if('background-color'===output.property){processedValue='unset';}else if('background-image'===output.property){processedValue='none';}}
var customProperty=controlType==='kirki-sortable'?output.property+'-'+key:output.property;if(false!==processedValue){styles+=output.property?customProperty+":"+processedValue+";":key+":"+processedValue+";";}});styles+='}';break;default:if('kirki-image'===controlType){value=(!_.isUndefined(value.url))?kirkiPostMessage.util.backgroundImageValue(value.url):kirkiPostMessage.util.backgroundImageValue(value);}
if(_.isObject(value)){styles+=output.element+'{';_.each(value,function(val,key){var property;if(output.choice&&key!==output.choice){return;}
processedValue=kirkiPostMessage.util.processValue(output,val);property=output.property?output.property:key;if(''===processedValue){if('background-color'===property){processedValue='unset';}else if('background-image'===property){processedValue='none';}}
if(false!==processedValue){styles+=property+':'+processedValue+';';}});styles+='}';}else{processedValue=kirkiPostMessage.util.processValue(output,value);if(''===processedValue){if('background-color'===output.property){processedValue='unset';}else if('background-image'===output.property){processedValue='none';}}
if(false!==processedValue){styles+=output.element+'{'+output.property+':'+processedValue+';}';}}
break;}}
if(output.media_query&&'string'===typeof output.media_query&&!_.isEmpty(output.media_query)){mediaQuery=output.media_query;if(-1===mediaQuery.indexOf('@media')){mediaQuery='@media '+mediaQuery;}}
if(mediaQuery){return mediaQuery+'{'+styles+'}';}
return styles;}},html:{fromOutput:function(output,value){if(output.js_callback&&'function'===typeof window[output.js_callback]){value=window[output.js_callback[0]](value,output.js_callback[1]);}
if(_.isObject(value)||_.isArray(value)){if(!output.choice){return;}
_.each(value,function(val,key){if(output.choice&&key!==output.choice){return;}
value=val;});}
value=kirkiPostMessage.util.processValue(output,value);if(output.attr){jQuery(output.element).attr(output.attr,value);}else{jQuery(output.element).html(value);}}},toggleClass:{fromOutput:function(output,value){if('undefined'===typeof output.class||'undefined'===typeof output.value){return;}
if(value===output.value&&!jQuery(output.element).hasClass(output.class)){jQuery(output.element).addClass(output.class);}else{jQuery(output.element).removeClass(output.class);}}}};jQuery(document).ready(function(){var styles;_.each(kirkiPostMessageFields,function(field){var fieldSetting=field.settings;if("option"===field.option_type&&field.option_name&&0!==fieldSetting.indexOf(field.option_name+'[')){fieldSetting=field.option_name+"["+fieldSetting+"]";}
wp.customize(fieldSetting,function(value){value.bind(function(newVal){styles='';_.each(field.js_vars,function(output){output.function=(!output.function||'undefined'===typeof kirkiPostMessage[output.function])?'css':output.function;field.type=(field.choices&&field.choices.parent_type)?field.choices.parent_type:field.type;if('css'===output.function){styles+=kirkiPostMessage.css.fromOutput(output,newVal,field.type);}else{kirkiPostMessage[output.function].fromOutput(output,newVal,field.type);}});kirkiPostMessage.styleTag.addData(fieldSetting,styles);});});});});;jQuery(document).ready((function(){wp.hooks.addFilter("kirkiPostMessageStylesOutput","kirki",(function(e,t,i,o){var r;return"kirki-dimensions"===o&&(e+=i.element+"{",_.each(t,(function(t,o){i.choice&&o!==i.choice||!1!==(r=kirkiPostMessage.util.processValue(i,t))&&(i.property?(e+=i.property,""===i.property||"top"!==o&&"bottom"!==o&&"left"!==o&&"right"!==o||(e+="-"+o),e+=":"+r+";"):e+=o+":"+r+";")})),e+="}"),e}))}));;!function(){var o;o=function(o){return"number"==typeof o||"string"==typeof o&&!isNaN(o)&&!isNaN(parseFloat(o))},wp.hooks.addFilter("kirkiPostMessageStylesOutput","kirki",(function(a,e,r,l){if("kirki-react-colorful"!==l)return a;if("string"==typeof e||"number"==typeof e)return a;var s=r.prefix?r.prefix:"",p=r.suffix?r.suffix:"";return a+=r.element+"{"+r.property+": "+s+function(a){return alphaEnabled=!1,a.r||a.g||a.b?(colorMode=void 0!==a.a?"rgba":"rgb",alphaEnabled="rgba"===colorMode||alphaEnabled,pos1=a.r,pos2=a.g,pos3=a.b,pos4="rgba"===colorMode?a.a:1):(a.h||a.s)&&(pos1=a.h,a.l?(colorMode=void 0!==a.a?"hsla":"hsl",pos2=o(a.l)?a.l+"%":a.l):a.v&&(colorMode=void 0!==a.a?"hvla":"hvl",pos2=o(a.v)?a.v+"%":a.v),alphaEnabled="hsla"===colorMode||"hsva"===colorMode||alphaEnabled,pos3=o(a)?a.s+"%":a.s,pos4=alphaEnabled?a.a:1),alphaEnabled?formattedValue=colorMode+"("+pos1+", "+pos2+", "+pos3+", "+pos4+")":formattedValue=colorMode+"("+pos1+", "+pos2+", "+pos3+")",formattedValue}(e)+p+";\t\t}",a}))}();;jQuery(document).ready(function(){wp.hooks.addFilter('kirkiPostMessageStylesOutput','kirki',function(styles,value,output,controlType){var processedValue;if('kirki-background'===controlType){styles+=output.element+'{';_.each(value,function(val,key){if(output.choice&&key!==output.choice){return;}
if('background-image'===key){val=-1===val.indexOf('url(')?'url('+val+')':val;}
processedValue=kirkiPostMessage.util.processValue(output,val);if(''===processedValue){if('background-color'===output.property){processedValue='unset';}else if('background-image'===output.property){processedValue='none';}}
if(false!==processedValue){styles+=output.property?output.property+':'+processedValue+';':key+':'+processedValue+';';}});styles+='}';}
return styles;});});
;/*! This file is auto-generated */
window.addComment=function(v){var I,C,h,E=v.document,b={commentReplyClass:"comment-reply-link",commentReplyTitleId:"reply-title",cancelReplyId:"cancel-comment-reply-link",commentFormId:"commentform",temporaryFormId:"wp-temp-form-div",parentIdFieldId:"comment_parent",postIdFieldId:"comment_post_ID"},e=v.MutationObserver||v.WebKitMutationObserver||v.MozMutationObserver,r="querySelector"in E&&"addEventListener"in v,n=!!E.documentElement.dataset;function t(){d(),e&&new e(o).observe(E.body,{childList:!0,subtree:!0})}function d(e){if(r&&(I=g(b.cancelReplyId),C=g(b.commentFormId),I)){I.addEventListener("touchstart",l),I.addEventListener("click",l);function t(e){if((e.metaKey||e.ctrlKey)&&13===e.keyCode)return C.removeEventListener("keydown",t),e.preventDefault(),C.submit.click(),!1}C&&C.addEventListener("keydown",t);for(var n,d=function(e){var t=b.commentReplyClass;e&&e.childNodes||(e=E);e=E.getElementsByClassName?e.getElementsByClassName(t):e.querySelectorAll("."+t);return e}(e),o=0,i=d.length;o<i;o++)(n=d[o]).addEventListener("touchstart",a),n.addEventListener("click",a)}}function l(e){var t,n,d=g(b.temporaryFormId);d&&h&&(g(b.parentIdFieldId).value="0",t=d.textContent,d.parentNode.replaceChild(h,d),this.style.display="none",n=(d=(d=g(b.commentReplyTitleId))&&d.firstChild)&&d.nextSibling,d&&d.nodeType===Node.TEXT_NODE&&t&&(n&&"A"===n.nodeName&&n.id!==b.cancelReplyId&&(n.style.display=""),d.textContent=t),e.preventDefault())}function a(e){var t=g(b.commentReplyTitleId),t=t&&t.firstChild.textContent,n=this,d=m(n,"belowelement"),o=m(n,"commentid"),i=m(n,"respondelement"),r=m(n,"postid"),n=m(n,"replyto")||t;d&&o&&i&&r&&!1===v.addComment.moveForm(d,o,i,r,n)&&e.preventDefault()}function o(e){for(var t=e.length;t--;)if(e[t].addedNodes.length)return void d()}function m(e,t){return n?e.dataset[t]:e.getAttribute("data-"+t)}function g(e){return E.getElementById(e)}return r&&"loading"!==E.readyState?t():r&&v.addEventListener("DOMContentLoaded",t,!1),{init:d,moveForm:function(e,t,n,d,o){var i,r,l,a,m,c,s,e=g(e),n=(h=g(n),g(b.parentIdFieldId)),y=g(b.postIdFieldId),p=g(b.commentReplyTitleId),u=(p=p&&p.firstChild)&&p.nextSibling;if(e&&h&&n){void 0===o&&(o=p&&p.textContent),a=h,m=b.temporaryFormId,c=g(m),s=(s=g(b.commentReplyTitleId))?s.firstChild.textContent:"",c||((c=E.createElement("div")).id=m,c.style.display="none",c.textContent=s,a.parentNode.insertBefore(c,a)),d&&y&&(y.value=d),n.value=t,I.style.display="",e.parentNode.insertBefore(h,e.nextSibling),p&&p.nodeType===Node.TEXT_NODE&&(u&&"A"===u.nodeName&&u.id!==b.cancelReplyId&&(u.style.display="none"),p.textContent=o),I.onclick=function(){return!1};try{for(var f=0;f<C.elements.length;f++)if(i=C.elements[f],r=!1,"getComputedStyle"in v?l=v.getComputedStyle(i):E.documentElement.currentStyle&&(l=i.currentStyle),(i.offsetWidth<=0&&i.offsetHeight<=0||"hidden"===l.visibility)&&(r=!0),"hidden"!==i.type&&!i.disabled&&!r){i.focus();break}}catch(e){}return!1}}}}(window);
;!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):e("object"==typeof exports?require("jquery"):window.jQuery||window.Zepto)}(function(c){function e(){}function d(e,t){f.ev.on(n+e+w,t)}function u(e,t,n,o){var i=document.createElement("div");return i.className="mfp-"+e,n&&(i.innerHTML=n),o?t&&t.appendChild(i):(i=c(i),t&&i.appendTo(t)),i}function p(e,t){f.ev.triggerHandler(n+e,t),f.st.callbacks&&(e=e.charAt(0).toLowerCase()+e.slice(1),f.st.callbacks[e]&&f.st.callbacks[e].apply(f,c.isArray(t)?t:[t]))}function m(e){return e===t&&f.currTemplate.closeBtn||(f.currTemplate.closeBtn=c(f.st.closeMarkup.replace("%title%",f.st.tClose)),t=e),f.currTemplate.closeBtn}function r(){c.magnificPopup.instance||((f=new e).init(),c.magnificPopup.instance=f)}var f,o,g,i,h,t,l="Close",v="BeforeClose",y="MarkupParse",C="Open",a="Change",n="mfp",w="."+n,b="mfp-ready",s="mfp-removing",I="mfp-prevent-close",x=!!window.jQuery,k=c(window);e.prototype={constructor:e,init:function(){var e=navigator.appVersion;f.isLowIE=f.isIE8=document.all&&!document.addEventListener,f.isAndroid=/android/gi.test(e),f.isIOS=/iphone|ipad|ipod/gi.test(e),f.supportsTransition=function(){var e=document.createElement("p").style,t=["ms","O","Moz","Webkit"];if(void 0!==e.transition)return!0;for(;t.length;)if(t.pop()+"Transition"in e)return!0;return!1}(),f.probablyMobile=f.isAndroid||f.isIOS||/(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent),g=c(document),f.popupsCache={}},open:function(e){if(!1===e.isObj){f.items=e.items.toArray(),f.index=0;for(var t,n=e.items,o=0;o<n.length;o++)if((t=n[o]).parsed&&(t=t.el[0]),t===e.el[0]){f.index=o;break}}else f.items=c.isArray(e.items)?e.items:[e.items],f.index=e.index||0;if(!f.isOpen){f.types=[],h="",e.mainEl&&e.mainEl.length?f.ev=e.mainEl.eq(0):f.ev=g,e.key?(f.popupsCache[e.key]||(f.popupsCache[e.key]={}),f.currTemplate=f.popupsCache[e.key]):f.currTemplate={},f.st=c.extend(!0,{},c.magnificPopup.defaults,e),f.fixedContentPos="auto"===f.st.fixedContentPos?!f.probablyMobile:f.st.fixedContentPos,f.st.modal&&(f.st.closeOnContentClick=!1,f.st.closeOnBgClick=!1,f.st.showCloseBtn=!1,f.st.enableEscapeKey=!1),f.bgOverlay||(f.bgOverlay=u("bg").on("click"+w,function(){f.close()}),f.wrap=u("wrap").attr("tabindex",-1).on("click"+w,function(e){f._checkIfClose(e.target)&&f.close()}),f.container=u("container",f.wrap)),f.contentContainer=u("content"),f.st.preloader&&(f.preloader=u("preloader",f.container,f.st.tLoading));var i=c.magnificPopup.modules;for(o=0;o<i.length;o++){var r=(r=i[o]).charAt(0).toUpperCase()+r.slice(1);f["init"+r].call(f)}p("BeforeOpen"),f.st.showCloseBtn&&(f.st.closeBtnInside?(d(y,function(e,t,n,o){n.close_replaceWith=m(o.type)}),h+=" mfp-close-btn-in"):f.wrap.append(m())),f.st.alignTop&&(h+=" mfp-align-top"),f.fixedContentPos?f.wrap.css({overflow:f.st.overflowY,overflowX:"hidden",overflowY:f.st.overflowY}):f.wrap.css({top:k.scrollTop(),position:"absolute"}),!1!==f.st.fixedBgPos&&("auto"!==f.st.fixedBgPos||f.fixedContentPos)||f.bgOverlay.css({height:g.height(),position:"absolute"}),f.st.enableEscapeKey&&g.on("keyup"+w,function(e){27===e.keyCode&&f.close()}),k.on("resize"+w,function(){f.updateSize()}),f.st.closeOnContentClick||(h+=" mfp-auto-cursor"),h&&f.wrap.addClass(h);var a=f.wH=k.height(),s={};f.fixedContentPos&&f._hasScrollBar(a)&&((l=f._getScrollbarSize())&&(s.marginRight=l)),f.fixedContentPos&&(f.isIE7?c("body, html").css("overflow","hidden"):s.overflow="hidden");var l=f.st.mainClass;return f.isIE7&&(l+=" mfp-ie7"),l&&f._addClassToMFP(l),f.updateItemHTML(),p("BuildControls"),c("html").css(s),f.bgOverlay.add(f.wrap).prependTo(f.st.prependTo||c(document.body)),f._lastFocusedEl=document.activeElement,setTimeout(function(){f.content?(f._addClassToMFP(b),f._setFocus()):f.bgOverlay.addClass(b),g.on("focusin"+w,f._onFocusIn)},16),f.isOpen=!0,f.updateSize(a),p(C),e}f.updateItemHTML()},close:function(){f.isOpen&&(p(v),f.isOpen=!1,f.st.removalDelay&&!f.isLowIE&&f.supportsTransition?(f._addClassToMFP(s),setTimeout(function(){f._close()},f.st.removalDelay)):f._close())},_close:function(){p(l);var e=s+" "+b+" ";f.bgOverlay.detach(),f.wrap.detach(),f.container.empty(),f.st.mainClass&&(e+=f.st.mainClass+" "),f._removeClassFromMFP(e),f.fixedContentPos&&(e={marginRight:""},f.isIE7?c("body, html").css("overflow",""):e.overflow="",c("html").css(e)),g.off("keyup.mfp focusin"+w),f.ev.off(w),f.wrap.attr("class","mfp-wrap").removeAttr("style"),f.bgOverlay.attr("class","mfp-bg"),f.container.attr("class","mfp-container"),!f.st.showCloseBtn||f.st.closeBtnInside&&!0!==f.currTemplate[f.currItem.type]||f.currTemplate.closeBtn&&f.currTemplate.closeBtn.detach(),f.st.autoFocusLast&&f._lastFocusedEl&&c(f._lastFocusedEl).focus(),f.currItem=null,f.content=null,f.currTemplate=null,f.prevHeight=0,p("AfterClose")},updateSize:function(e){var t;f.isIOS?(t=document.documentElement.clientWidth/window.innerWidth,t=window.innerHeight*t,f.wrap.css("height",t),f.wH=t):f.wH=e||k.height(),f.fixedContentPos||f.wrap.css("height",f.wH),p("Resize")},updateItemHTML:function(){var e=f.items[f.index];f.contentContainer.detach(),f.content&&f.content.detach(),e.parsed||(e=f.parseEl(f.index));var t=e.type;p("BeforeChange",[f.currItem?f.currItem.type:"",t]),f.currItem=e,f.currTemplate[t]||(n=!!f.st[t]&&f.st[t].markup,p("FirstMarkupParse",n),f.currTemplate[t]=!n||c(n)),i&&i!==e.type&&f.container.removeClass("mfp-"+i+"-holder");var n=f["get"+t.charAt(0).toUpperCase()+t.slice(1)](e,f.currTemplate[t]);f.appendContent(n,t),e.preloaded=!0,p(a,e),i=e.type,f.container.prepend(f.contentContainer),p("AfterChange")},appendContent:function(e,t){(f.content=e)?f.st.showCloseBtn&&f.st.closeBtnInside&&!0===f.currTemplate[t]?f.content.find(".mfp-close").length||f.content.append(m()):f.content=e:f.content="",p("BeforeAppend"),f.container.addClass("mfp-"+t+"-holder"),f.contentContainer.append(f.content)},parseEl:function(e){var t,n=f.items[e];if((n=n.tagName?{el:c(n)}:(t=n.type,{data:n,src:n.src})).el){for(var o=f.types,i=0;i<o.length;i++)if(n.el.hasClass("mfp-"+o[i])){t=o[i];break}n.src=n.el.attr("data-mfp-src"),n.src||(n.src=n.el.attr("href"))}return n.type=t||f.st.type||"inline",n.index=e,n.parsed=!0,f.items[e]=n,p("ElementParse",n),f.items[e]},addGroup:function(t,n){function e(e){e.mfpEl=this,f._openClick(e,t,n)}var o="click.magnificPopup";(n=n||{}).mainEl=t,n.items?(n.isObj=!0,t.off(o).on(o,e)):(n.isObj=!1,n.delegate?t.off(o).on(o,n.delegate,e):(n.items=t).off(o).on(o,e))},_openClick:function(e,t,n){if((void 0!==n.midClick?n:c.magnificPopup.defaults).midClick||!(2===e.which||e.ctrlKey||e.metaKey||e.altKey||e.shiftKey)){var o=(void 0!==n.disableOn?n:c.magnificPopup.defaults).disableOn;if(o)if(c.isFunction(o)){if(!o.call(f))return!0}else if(k.width()<o)return!0;e.type&&(e.preventDefault(),f.isOpen&&e.stopPropagation()),n.el=c(e.mfpEl),n.delegate&&(n.items=t.find(n.delegate)),f.open(n)}},updateStatus:function(e,t){var n;f.preloader&&(o!==e&&f.container.removeClass("mfp-s-"+o),t||"loading"!==e||(t=f.st.tLoading),p("UpdateStatus",n={status:e,text:t}),e=n.status,t=n.text,f.preloader.html(t),f.preloader.find("a").on("click",function(e){e.stopImmediatePropagation()}),f.container.addClass("mfp-s-"+e),o=e)},_checkIfClose:function(e){if(!c(e).hasClass(I)){var t=f.st.closeOnContentClick,n=f.st.closeOnBgClick;if(t&&n)return!0;if(!f.content||c(e).hasClass("mfp-close")||f.preloader&&e===f.preloader[0])return!0;if(e===f.content[0]||c.contains(f.content[0],e)){if(t)return!0}else if(n&&c.contains(document,e))return!0;return!1}},_addClassToMFP:function(e){f.bgOverlay.addClass(e),f.wrap.addClass(e)},_removeClassFromMFP:function(e){this.bgOverlay.removeClass(e),f.wrap.removeClass(e)},_hasScrollBar:function(e){return(f.isIE7?g.height():document.body.scrollHeight)>(e||k.height())},_setFocus:function(){(f.st.focus?f.content.find(f.st.focus).eq(0):f.wrap).focus()},_onFocusIn:function(e){return e.target===f.wrap[0]||c.contains(f.wrap[0],e.target)?void 0:(f._setFocus(),!1)},_parseMarkup:function(i,e,t){var r;t.data&&(e=c.extend(t.data,e)),p(y,[i,e,t]),c.each(e,function(e,t){return void 0===t||!1===t||void(1<(r=e.split("_")).length?0<(n=i.find(w+"-"+r[0])).length&&("replaceWith"===(o=r[1])?n[0]!==t[0]&&n.replaceWith(t):"img"===o?n.is("img")?n.attr("src",t):n.replaceWith(c("<img>").attr("src",t).attr("class",n.attr("class"))):n.attr(r[1],t)):i.find(w+"-"+e).html(t));var n,o})},_getScrollbarSize:function(){var e;return void 0===f.scrollbarSize&&((e=document.createElement("div")).style.cssText="width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;",document.body.appendChild(e),f.scrollbarSize=e.offsetWidth-e.clientWidth,document.body.removeChild(e)),f.scrollbarSize}},c.magnificPopup={instance:null,proto:e.prototype,modules:[],open:function(e,t){return r(),(e=e?c.extend(!0,{},e):{}).isObj=!0,e.index=t||0,this.instance.open(e)},close:function(){return c.magnificPopup.instance&&c.magnificPopup.instance.close()},registerModule:function(e,t){t.options&&(c.magnificPopup.defaults[e]=t.options),c.extend(this.proto,t.proto),this.modules.push(e)},defaults:{disableOn:0,key:null,midClick:!1,mainClass:"",preloader:!0,focus:"",closeOnContentClick:!1,closeOnBgClick:!0,closeBtnInside:!0,showCloseBtn:!0,enableEscapeKey:!0,modal:!1,alignTop:!1,removalDelay:0,prependTo:null,fixedContentPos:"auto",fixedBgPos:"auto",overflowY:"auto",closeMarkup:'<button title="%title%" type="button" class="mfp-close">&#215;</button>',tClose:"Close (Esc)",tLoading:"Loading...",autoFocusLast:!0}},c.fn.magnificPopup=function(e){r();var t,n,o,i=c(this);return"string"==typeof e?"open"===e?(t=x?i.data("magnificPopup"):i[0].magnificPopup,n=parseInt(arguments[1],10)||0,o=t.items?t.items[n]:(o=i,t.delegate&&(o=o.find(t.delegate)),o.eq(n)),f._openClick({mfpEl:o},i,t)):f.isOpen&&f[e].apply(f,Array.prototype.slice.call(arguments,1)):(e=c.extend(!0,{},e),x?i.data("magnificPopup",e):i[0].magnificPopup=e,f.addGroup(i,e)),i};function T(){S&&(P.after(S.addClass(_)).detach(),S=null)}var _,P,S,E="inline";c.magnificPopup.registerModule(E,{options:{hiddenClass:"hide",markup:"",tNotFound:"Content not found"},proto:{initInline:function(){f.types.push(E),d(l+"."+E,function(){T()})},getInline:function(e,t){if(T(),e.src){var n,o=f.st.inline,i=c(e.src);return i.length?((n=i[0].parentNode)&&n.tagName&&(P||(_=o.hiddenClass,P=u(_),_="mfp-"+_),S=i.after(P).detach().removeClass(_)),f.updateStatus("ready")):(f.updateStatus("error",o.tNotFound),i=c("<div>")),e.inlineElement=i}return f.updateStatus("ready"),f._parseMarkup(t,{},e),t}}});function z(){M&&c(document.body).removeClass(M)}function O(){z(),f.req&&f.req.abort()}var M,B="ajax";c.magnificPopup.registerModule(B,{options:{settings:null,cursor:"mfp-ajax-cur",tError:'<a href="%url%">The content</a> could not be loaded.'},proto:{initAjax:function(){f.types.push(B),M=f.st.ajax.cursor,d(l+"."+B,O),d("BeforeChange."+B,O)},getAjax:function(o){M&&c(document.body).addClass(M),f.updateStatus("loading");var e=c.extend({url:o.src,success:function(e,t,n){n={data:e,xhr:n};p("ParseAjax",n),f.appendContent(c(n.data),B),o.finished=!0,z(),f._setFocus(),setTimeout(function(){f.wrap.addClass(b)},16),f.updateStatus("ready"),p("AjaxContentAdded")},error:function(){z(),o.finished=o.loadError=!0,f.updateStatus("error",f.st.ajax.tError.replace("%url%",o.src))}},f.st.ajax.settings);return f.req=c.ajax(e),""}}});var L;c.magnificPopup.registerModule("image",{options:{markup:'<div class="mfp-figure"><div class="mfp-close"></div><figure><div class="mfp-img"></div><figcaption><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></figcaption></figure></div>',cursor:"mfp-zoom-out-cur",titleSrc:"title",verticalFit:!0,tError:'<a href="%url%">The image</a> could not be loaded.'},proto:{initImage:function(){var e=f.st.image,t=".image";f.types.push("image"),d(C+t,function(){"image"===f.currItem.type&&e.cursor&&c(document.body).addClass(e.cursor)}),d(l+t,function(){e.cursor&&c(document.body).removeClass(e.cursor),k.off("resize"+w)}),d("Resize"+t,f.resizeImage),f.isLowIE&&d("AfterChange",f.resizeImage)},resizeImage:function(){var e,t=f.currItem;t&&t.img&&f.st.image.verticalFit&&(e=0,f.isLowIE&&(e=parseInt(t.img.css("padding-top"),10)+parseInt(t.img.css("padding-bottom"),10)),t.img.css("max-height",f.wH-e))},_onImageHasSize:function(e){e.img&&(e.hasSize=!0,L&&clearInterval(L),e.isCheckingImgSize=!1,p("ImageHasSize",e),e.imgHidden&&(f.content&&f.content.removeClass("mfp-loading"),e.imgHidden=!1))},findImageSize:function(t){var n=0,o=t.img[0],i=function(e){L&&clearInterval(L),L=setInterval(function(){return 0<o.naturalWidth?void f._onImageHasSize(t):(200<n&&clearInterval(L),void(3===++n?i(10):40===n?i(50):100===n&&i(500)))},e)};i(1)},getImage:function(e,t){var n,o=0,i=function(){e&&(e.img[0].complete?(e.img.off(".mfploader"),e===f.currItem&&(f._onImageHasSize(e),f.updateStatus("ready")),e.hasSize=!0,e.loaded=!0,p("ImageLoadComplete")):++o<200?setTimeout(i,100):r())},r=function(){e&&(e.img.off(".mfploader"),e===f.currItem&&(f._onImageHasSize(e),f.updateStatus("error",a.tError.replace("%url%",e.src))),e.hasSize=!0,e.loaded=!0,e.loadError=!0)},a=f.st.image,s=t.find(".mfp-img");return s.length&&((n=document.createElement("img")).className="mfp-img",e.el&&e.el.find("img").length&&(n.alt=e.el.find("img").attr("alt")),e.img=c(n).on("load.mfploader",i).on("error.mfploader",r),n.src=e.src,s.is("img")&&(e.img=e.img.clone()),0<(n=e.img[0]).naturalWidth?e.hasSize=!0:n.width||(e.hasSize=!1)),f._parseMarkup(t,{title:function(e){if(e.data&&void 0!==e.data.title)return e.data.title;var t=f.st.image.titleSrc;if(t){if(c.isFunction(t))return t.call(f,e);if(e.el)return e.el.attr(t)||""}return""}(e),img_replaceWith:e.img},e),f.resizeImage(),e.hasSize?(L&&clearInterval(L),e.loadError?(t.addClass("mfp-loading"),f.updateStatus("error",a.tError.replace("%url%",e.src))):(t.removeClass("mfp-loading"),f.updateStatus("ready"))):(f.updateStatus("loading"),e.loading=!0,e.hasSize||(e.imgHidden=!0,t.addClass("mfp-loading"),f.findImageSize(e))),t}}});var H;c.magnificPopup.registerModule("zoom",{options:{enabled:!1,easing:"ease-in-out",duration:300,opener:function(e){return e.is("img")?e:e.find("img")}},proto:{initZoom:function(){var e,t,n,o,i,r,a=f.st.zoom,s=".zoom";a.enabled&&f.supportsTransition&&(o=a.duration,i=function(e){var t=e.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),n="all "+a.duration/1e3+"s "+a.easing,o={position:"fixed",zIndex:9999,left:0,top:0,"-webkit-backface-visibility":"hidden"},e="transition";return o["-webkit-"+e]=o["-moz-"+e]=o["-o-"+e]=o[e]=n,t.css(o),t},r=function(){f.content.css("visibility","visible")},d("BuildControls"+s,function(){f._allowZoom()&&(clearTimeout(t),f.content.css("visibility","hidden"),(e=f._getItemToZoom())?((n=i(e)).css(f._getOffset()),f.wrap.append(n),t=setTimeout(function(){n.css(f._getOffset(!0)),t=setTimeout(function(){r(),setTimeout(function(){n.remove(),e=n=null,p("ZoomAnimationEnded")},16)},o)},16)):r())}),d(v+s,function(){if(f._allowZoom()){if(clearTimeout(t),f.st.removalDelay=o,!e){if(!(e=f._getItemToZoom()))return;n=i(e)}n.css(f._getOffset(!0)),f.wrap.append(n),f.content.css("visibility","hidden"),setTimeout(function(){n.css(f._getOffset())},16)}}),d(l+s,function(){f._allowZoom()&&(r(),n&&n.remove(),e=null)}))},_allowZoom:function(){return"image"===f.currItem.type},_getItemToZoom:function(){return!!f.currItem.hasSize&&f.currItem.img},_getOffset:function(e){var t=e?f.currItem.img:f.st.zoom.opener(f.currItem.el||f.currItem),n=t.offset(),o=parseInt(t.css("padding-top"),10),e=parseInt(t.css("padding-bottom"),10);n.top-=c(window).scrollTop()-o;o={width:t.width(),height:(x?t.innerHeight():t[0].offsetHeight)-e-o};return void 0===H&&(H=void 0!==document.createElement("p").style.MozTransform),H?o["-moz-transform"]=o.transform="translate("+n.left+"px,"+n.top+"px)":(o.left=n.left,o.top=n.top),o}}});function A(e){var t;!f.currTemplate[F]||(t=f.currTemplate[F].find("iframe")).length&&(e||(t[0].src="//about:blank"),f.isIE8&&t.css("display",e?"block":"none"))}var F="iframe";c.magnificPopup.registerModule(F,{options:{markup:'<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',srcAction:"iframe_src",patterns:{youtube:{index:"youtube.com",id:"v=",src:"//www.youtube.com/embed/%id%?autoplay=1"},vimeo:{index:"vimeo.com/",id:"/",src:"//player.vimeo.com/video/%id%?autoplay=1"},gmaps:{index:"//maps.google.",src:"%id%&output=embed"}}},proto:{initIframe:function(){f.types.push(F),d("BeforeChange",function(e,t,n){t!==n&&(t===F?A():n===F&&A(!0))}),d(l+"."+F,function(){A()})},getIframe:function(e,t){var n=e.src,o=f.st.iframe;c.each(o.patterns,function(){return-1<n.indexOf(this.index)?(this.id&&(n="string"==typeof this.id?n.substr(n.lastIndexOf(this.id)+this.id.length,n.length):this.id.call(this,n)),n=this.src.replace("%id%",n),!1):void 0});var i={};return o.srcAction&&(i[o.srcAction]=n),f._parseMarkup(t,i,e),f.updateStatus("ready"),t}}});function j(e){var t=f.items.length;return t-1<e?e-t:e<0?t+e:e}function N(e,t,n){return e.replace(/%curr%/gi,t+1).replace(/%total%/gi,n)}c.magnificPopup.registerModule("gallery",{options:{enabled:!1,arrowMarkup:'<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',preload:[0,2],navigateByImgClick:!0,arrows:!0,tPrev:"Previous (Left arrow key)",tNext:"Next (Right arrow key)",tCounter:"%curr% of %total%"},proto:{initGallery:function(){var r=f.st.gallery,e=".mfp-gallery";return f.direction=!0,!(!r||!r.enabled)&&(h+=" mfp-gallery",d(C+e,function(){r.navigateByImgClick&&f.wrap.on("click"+e,".mfp-img",function(){return 1<f.items.length?(f.next(),!1):void 0}),g.on("keydown"+e,function(e){37===e.keyCode?f.prev():39===e.keyCode&&f.next()})}),d("UpdateStatus"+e,function(e,t){t.text&&(t.text=N(t.text,f.currItem.index,f.items.length))}),d(y+e,function(e,t,n,o){var i=f.items.length;n.counter=1<i?N(r.tCounter,o.index,i):""}),d("BuildControls"+e,function(){var e,t;1<f.items.length&&r.arrows&&!f.arrowLeft&&(t=r.arrowMarkup,e=f.arrowLeft=c(t.replace(/%title%/gi,r.tPrev).replace(/%dir%/gi,"left")).addClass(I),t=f.arrowRight=c(t.replace(/%title%/gi,r.tNext).replace(/%dir%/gi,"right")).addClass(I),e.click(function(){f.prev()}),t.click(function(){f.next()}),f.container.append(e.add(t)))}),d(a+e,function(){f._preloadTimeout&&clearTimeout(f._preloadTimeout),f._preloadTimeout=setTimeout(function(){f.preloadNearbyImages(),f._preloadTimeout=null},16)}),void d(l+e,function(){g.off(e),f.wrap.off("click"+e),f.arrowRight=f.arrowLeft=null}))},next:function(){f.direction=!0,f.index=j(f.index+1),f.updateItemHTML()},prev:function(){f.direction=!1,f.index=j(f.index-1),f.updateItemHTML()},goTo:function(e){f.direction=e>=f.index,f.index=e,f.updateItemHTML()},preloadNearbyImages:function(){for(var e=f.st.gallery.preload,t=Math.min(e[0],f.items.length),n=Math.min(e[1],f.items.length),o=1;o<=(f.direction?n:t);o++)f._preloadItem(f.index+o);for(o=1;o<=(f.direction?t:n);o++)f._preloadItem(f.index-o)},_preloadItem:function(e){var t;e=j(e),f.items[e].preloaded||((t=f.items[e]).parsed||(t=f.parseEl(e)),p("LazyLoad",t),"image"===t.type&&(t.img=c('<img class="mfp-img" />').on("load.mfploader",function(){t.hasSize=!0}).on("error.mfploader",function(){t.hasSize=!0,t.loadError=!0,p("LazyLoadError",t)}).attr("src",t.src)),t.preloaded=!0)}}});var W="retina";c.magnificPopup.registerModule(W,{options:{replaceSrc:function(e){return e.src.replace(/\.\w+$/,function(e){return"@2x"+e})},ratio:1},proto:{initRetina:function(){var n,o;1<window.devicePixelRatio&&(n=f.st.retina,o=n.ratio,1<(o=isNaN(o)?o():o)&&(d("ImageHasSize."+W,function(e,t){t.img.css({"max-width":t.img[0].naturalWidth/o,width:"100%"})}),d("ElementParse."+W,function(e,t){t.src=n.replaceSrc(t,o)})))}}}),r()});
;!function(){"use strict";var s,c,o,a,e=(s={},c={},o=document.getElementsByTagName("head")[0],a=function(t){return new Promise(function(e,n){var r=document.createElement("script");r.type="text/javascript",r.async=!0,r.src=t,o.appendChild(r),r.onload=e,r.onerror=n})},{register:function(e,n){n&&(s[n]=e)},require:function(e,n){var r,t=(e=e.push?e:[e]).length,o=[];if(e.every(u)){for(var i=0;i<t;i++)r=e[i],c.hasOwnProperty(r)||(c[e[i]]=a(s[e[i]])),o.push(c[e[i]]);Promise.all(o).then(function(){n.call()})}else console.log("Scripts not Registered")},getRegistredScripts:function(){return s}});function u(e){if(s.hasOwnProperty(e))return!0;console.log("Script "+e+" has not been registered")}window.asyncloader=e}();
;!function(e){var r,a=e.event,u=a.special.debouncedresize={setup:function(){e(this).on("resize",u.handler)},teardown:function(){e(this).off("resize",u.handler)},handler:function(e,n){function t(){e.type="debouncedresize",a.dispatch.apply(o,i)}var o=this,i=arguments;r&&clearTimeout(r),n?t():r=setTimeout(t,u.threshold)},threshold:150}}(jQuery),jQuery.throttle=function(n,t){var o=null,t=t||200;return function(){var e;null==o?(o=+new Date,n.call(this,arguments)):(e=+new Date,o+t<e&&(o=e,n.call(this,arguments)))}},jQuery.debounce=function(o,i,r){var a;return function(){var e=this,n=arguments,t=r&&!a;clearTimeout(a),a=setTimeout(function(){a=null,r||o.apply(e,n)},i),t&&o.apply(e,n)}},function(e){var n,t,o;e(".be-youtube-embed").length&&((n=document.createElement("script")).src="https://www.youtube.com/iframe_api",(t=document.getElementsByTagName("script")[0]).parentNode.insertBefore(n,t),o=window.onYouTubeIframeAPIReady,window.onYouTubeIframeAPIReady=function(){"function"==typeof o&&o(),e(document).trigger("YTAPIReady")})}(jQuery),function(r){"use strict";var a=r(window);r.fn.isVisible=function(e){var n=r(this),t=a.scrollTop(),o=t+window.innerHeight,i=n.offset().top,n=i+n.height(),t=t-e,e=o+e;return t<=n&&n<=e||i<=e&&t<=i}}(jQuery),function(t){function e(){var e;0<n.length&&(0<(e=n.filter(function(e,n){return t(this).isVisible(200)})).length&&(e.one("load",function(){t(this).addClass("be-lazy-loaded")}).each(function(e){var n=t(this);n.attr("src",n.attr("data-src"))}),n=n.not(e)))}var n=t(".be-lazy-load");t(window).on("scroll",function(){e()}),window.BeLazyLoad={add:function(e){null!=e&&0<e.length&&(n=n.add(e))},lazyLoad:e},t(function(){n=t(".be-lazy-load"),e()})}(jQuery);
;!function(e){"use strict";var s,o=e.event,u=o.special.debouncedresize={setup:function(){e(this).on("resize",u.handler)},teardown:function(){e(this).off("resize",u.handler)},handler:function(e,t){function n(){e.type="debouncedresize",o.dispatch.apply(i,r)}var i=this,r=arguments;s&&clearTimeout(s),t?n():s=setTimeout(n,u.threshold)},threshold:150}}(jQuery);