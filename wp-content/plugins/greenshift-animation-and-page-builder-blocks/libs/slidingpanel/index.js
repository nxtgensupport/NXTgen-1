"use strict";function GSPBtoggleBgScroll(e){"block"!=e&&"modal"!=e&&document.body.classList.toggle("scrollhidden")}function GSPBtogglemodaldialog(e,t,l="toggle"){"modal"==t&&(e.open&&"toggle"==l||"close"==l?e.close():e.showModal())}let gsslidingpanel=document.getElementsByClassName("gspb_button_wrapper");for(let i=0;i<gsslidingpanel.length;i++){let e=gsslidingpanel[i],t=e.dataset.paneltype;if(void 0===t)continue;let l=e.getAttribute("id"),a=e.querySelector(".gspb_slidingPanel"),o=a.dataset.hover,n=document.documentElement.clientWidth,s=a.dataset.autotrigger,c=a.dataset.closeintent,d=a.dataset.closeintentonce,g=a.dataset.autotriggertime,r=a.dataset.placebody,p=a.dataset.clickselector,v=a.dataset.closeselector,u=a.dataset.dynamicbefore,f=a.dataset.dynamicafter,S=e.querySelector('[data-panelid="'+l+'"]');S||(S=document.querySelector('[data-panelid="'+l+'"]'));let L=e.querySelector(".gspb_slidingPanel-close"),y=e.querySelectorAll(".gspb-custom-close");if(v&&(y=document.querySelectorAll(v)),u||f){let m=S.querySelector(".gspb_slidingPanel-inner");if(u){let k=document.querySelector(u);if(k){let B=document.createElement("div");B.classList.add("gspb-dynamic-content-before"),B.innerHTML=k.innerHTML,m.firstChild?m.insertBefore(B,m.firstChild):m.appendChild(B)}}if(f){let b=document.querySelector(f);if(b){let E=document.createElement("div");E.classList.add("gspb-dynamic-content-after"),E.innerHTML=b.innerHTML,m.appendChild(E)}}}if("block"!=t&&"modal"!=t&&r){let h=document.createElement("div");h.classList.add(l),h.setAttribute("data-paneltype",t),h.appendChild(S),document.body.appendChild(h)}if(e){let P=e.querySelector(".gspb-buttonbox");if("true"==o&&n>1024?(e.addEventListener("mouseenter",function(e){S.classList.add("active"),GSPBtogglemodaldialog(S,t,"open"),"block"!=t&&"modal"!=t&&document.body.classList.add("scrollhidden")},!1),e.addEventListener("mouseleave",function(e){S.classList.remove("active"),GSPBtogglemodaldialog(S,t,"close"),document.body.classList.remove("scrollhidden")},!1)):P.addEventListener("click",function(l){l.preventDefault(),S.classList.toggle("active"),GSPBtogglemodaldialog(S,t),e.classList.toggle("panelactive"),GSPBtoggleBgScroll(t)},!1),P.addEventListener("keydown",function(e){let t=void 0!==e.key?e.key:e.keyCode;("Enter"===t||13===t||["Spacebar"," "].indexOf(t)>=0||32===t)&&(e.preventDefault(),this.click())}),p){let G=document.querySelectorAll(p);G.length&&G.forEach(l=>{l.addEventListener("click",a=>{a.preventDefault(),S.classList.toggle("active"),GSPBtogglemodaldialog(S,t),e.classList.toggle("panelactive"),l.classList.toggle("panelactive"),GSPBtoggleBgScroll(t)}),l.addEventListener("keydown",function(e){let t=void 0!==e.key?e.key:e.keyCode;("Enter"===t||13===t||["Spacebar"," "].indexOf(t)>=0||32===t)&&(e.preventDefault(),this.click())})})}if(L&&(L.addEventListener("click",function(l){S.classList.toggle("active"),GSPBtogglemodaldialog(S,t),e.classList.toggle("panelactive"),GSPBtoggleBgScroll(t)},!1),L.addEventListener("keydown",function(e){let t=void 0!==e.key?e.key:e.keyCode;("Enter"===t||13===t||["Spacebar"," "].indexOf(t)>=0||32===t)&&(e.preventDefault(),this.click())})),a.addEventListener("click",function(l){l.target.classList.contains("gspb_slidingPanel")&&(S.classList.toggle("active"),GSPBtogglemodaldialog(S,t),e.classList.toggle("panelactive"),GSPBtoggleBgScroll(t))},!1),y&&y.length>0&&y.forEach(l=>{l.addEventListener("click",function(l){S.classList.toggle("active"),GSPBtogglemodaldialog(S,t),e.classList.toggle("panelactive"),GSPBtoggleBgScroll(t)},!1),l.addEventListener("keydown",function(e){let t=void 0!==e.key?e.key:e.keyCode;("Enter"===t||13===t||["Spacebar"," "].indexOf(t)>=0||32===t)&&(e.preventDefault(),this.click())})}),s&&g&&setTimeout(()=>{S.classList.toggle("active"),GSPBtogglemodaldialog(S,t),e.classList.toggle("panelactive"),GSPBtoggleBgScroll(t)},1e3*parseFloat(g)),c){let $=l=>{let a=!l.toElement&&!l.relatedTarget&&l.clientY<10;if(d){let o=localStorage.getItem(d);o&&"1"==o&&(a=!1)}a&&(document.removeEventListener("mouseout",$),S.classList.toggle("active"),GSPBtogglemodaldialog(S,t),e.classList.toggle("panelactive"),GSPBtoggleBgScroll(t),d&&localStorage.setItem(d,"1"))};setTimeout(()=>{document.addEventListener("mouseout",$)},2e3)}"modal"==t&&S.addEventListener("click",e=>{let l=S.getBoundingClientRect();(e.clientX<l.left||e.clientX>l.right||e.clientY<l.top||e.clientY>l.bottom)&&(S.close(),S.classList.remove("active"),GSPBtoggleBgScroll(t))})}}document.addEventListener("keydown",function(e){if("Escape"===e.key){let t=document.querySelectorAll(".gspb_slidingPanel");t.length&&t.forEach(e=>{let t=e.parentNode.dataset.paneltype;e.classList.remove("active"),GSPBtoggleBgScroll(t)});let l=document.querySelectorAll(".clickWrapNode");l.length&&l.forEach(e=>{e.classList.remove("panelactive")})}});