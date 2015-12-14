/*
 * SimpleModal Basic Modal Dialog
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2010 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: basic.js 254 2010-07-23 05:14:44Z emartin24 $
 */

jQuery(function ($) {
	// Load dialog on page load
	//$('#basic-modal-content').modal();

	// Load dialog on click
	$('#basic-modal .basic').click(function (e) {
		$('#basic-modal-content').modal({
			appendTo: 'body',
			position: [10,],
			onShow: function(dialog) {
			 if (!dialog) dialog = $.modal.impl.d
				dialog.container.css('position', 'absolute');
				dialog.origHeight = 0;
				$.modal.setContainerDimensions();
				$.modal.setPosition();
			},
			onOpen: function (dialog) {
				dialog.overlay.fadeIn('slow', function () {
					dialog.container.slideDown('slow', function () {
						dialog.data.fadeIn('slow');
					});
				});
			},
			onClose: function (dialog) {
				//var flg = document.getElementById("flagModificado").value;
				//if(flg == "S") if(confirm("¿Desea salir sin guardar los cambios?")) flg = "N";
				//if(flg == "N") {
					dialog.data.fadeOut('slow', function () {
						dialog.container.slideUp('slow', function () {
							dialog.overlay.fadeOut('slow', function () {
								$.modal.close(); // must call this!
								document.getElementById("accion").value = "";
								document.forms["formDOP"].submit();
							});
						});
					});
				//}
			}
		});
		return false;
	});
});