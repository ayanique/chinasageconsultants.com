<?php
?>.dzsap-main-con.loaded-item {
opacity: 1;
visibility: visible; }

.dzsap-main-con.loading-item {
opacity: 1;
visibility: visible; }

.dzsap-main-con {
z-index: 5555;
position: fixed;
width: 100%;
height: 100%;
opacity: 0;
visibility: hidden;
top: 0;
left: 0;
transition-property: opacity, visibility;
transition-duration: 0.3s;
transition-timing-function: ease-out; }

.dzsap-main-con .overlay-background {
background-color: rgba(50, 50, 50, 0.5);
position: absolute;
width: 100%;
height: 100%; }

.dzsap-main-con .box-mains-con {
position: absolute;
width: 100%;
height: 100%;
top: 0;
left: 0;
pointer-events: none; }

.dzsap-main-con .box-main {
pointer-events: auto;
max-width: 100%;
position: absolute;
top: 50%;
left: 50%;
transform: translate3d(-50%, -50%, 0);
transition-property: left, opacity;
transition-duration: 0.3s;
transition-timing-function: ease-out; }

.dzsap-main-con.transition-slideup.loaded-item .transition-target {
opacity: 1;
visibility: visible;
transform: translate3d(0, 0, 0); }

.dzsap-main-con.transition-slideup .transition-target {
opacity: 0;
visibility: hidden;
transform: translate3d(0, 50px, 0);
transition-property: all;
transition-duration: 0.3s;
transition-timing-function: ease-out; }

.dzsap-main-con .box-main-media-con {
max-width: 100%; }

.dzsap-main-con .box-main .close-btn-con {
position: absolute;
right: -15px;
top: -15px;
z-index: 5;
cursor: pointer;
width: 30px;
height: 30px;
background-color: #dadada;
border-radius: 50%; }

.dzsap-main-con.gallery-skin-default .box-main-media {
box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.3); }

.dzsap-main-con .box-main-media-con .box-main-media {
transition-property: width, height;
transition-duration: 0.3s;
transition-timing-function: ease-out; }

.box-main-media.type-inlinecontent {
background-color: #ffffff;
padding: 15px; }

.dzsap-main-con.skin-default .box-main:not(.with-description) .real-media {
border-radius: 5px; }

.dzsap-main-con .box-main-media-con .box-main-media > .real-media {
width: 100%;
height: 100%; }





.real-media .hidden-content-for-zoombox, .real-media > .hidden-content {
display: block !important; }

.hidden-content {
display: none !important; }

.social-icon {
margin-right: 3px;
position: relative; }

.social-icon > .fa {
font-size: 30px;
color: #999;
transition-property: color;
transition-duration: 0.3s;
transition-timing-function: cubic-bezier(0.165, 0.84, 0.44, 1); }

.social-icon > .the-tooltip {
line-height: 1;
padding: 6px 5px;
background: rgba(0, 0, 0, 0.7);
color: #FFFFFF;
font-family: "Lato", "Open Sans", arial;
font-size: 11px;
font-weight: bold;
position: absolute;
left: 8px;
white-space: nowrap;
pointer-events: none;
bottom: 100%;
margin-bottom: 7px;
opacity: 0;
visibility: hidden;
transition-property: opacity,visibility;
transition-duration: 0.3s;
transition-timing-function: cubic-bezier(0.165, 0.84, 0.44, 1); }


.social-icon:hover > .the-tooltip{
opacity:1;
visibility: visible;
}

.social-icon > .the-tooltip:before {
content: "";
width: 0;
height: 0;
border-style: solid;
border-width: 6px 6px 0 0;
border-color: rgba(0, 0, 0, 0.7) transparent transparent transparent;
position: absolute;
left: 0;
top: 100%; }

h6.social-heading {
display: block;
text-transform: uppercase;
font-family: "Lato",sans-sarif;
font-size: 11px;
font-weight: bold;
margin-top: 20px;
margin-bottom: 10px;
color: #222222; }

.field-for-view {
background-color: #f0f0f0;
line-height: 1;
color: #555;
padding: 8px;
white-space: nowrap;
font-size: 13px;
overflow: hidden;
text-overflow: ellipsis;
font-family: 'Monospaced', Arial; }

textarea.field-for-view {
width: 100%;
white-space: pre-line;
line-height: 1.75; }