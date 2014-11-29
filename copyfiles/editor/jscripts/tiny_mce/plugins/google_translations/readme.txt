TinyMCE Google Translations plugin 

    Author: Miroslaw Ksiezyk <nsp@h4h.pl>
powered by: Google Translations from Google

version: 1.0
   date: 2008-07-25


HOW TO USE 
==========================
1. Unpack atrchiwe to plugins directory of TinyMCE


2. Put this input fields in TinyMCE loading file:

<input type="hidden" id="sLang" value="ISO_LANG">
<input type="hidden" id="dLang" value="ISO_LANG">

EXAMPLE:

(...)
<input type="hidden" id="sLang" value="en">
<input type="hidden" id="dLang" value="de">
<script type="text/javascript">
dojo.addOnLoad(function () {
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "google_translations",
(...)


Will be translating from English to German.

3. Remember to add plugin definition to TinyMCE:

        plugins : "google_translations",

   and place button into toolbar:

        ...,strikethrough,|,google_translations,|,justifyleft,....