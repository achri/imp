$(document).ready(function(){
	$('body').layout({ 
		applyDefaultStyles: false,
		// HEADER
		north: {
			size: 140,
			closable: true,
			resizable: false,
			slidable: true
		},
		// FOOTER
		south: {
			size: 40,
		},
		// RIGHR
		east: {
			size: 200,
			slideTrigger_open: "mouseover"
		},
		// LEFT
		west: {
			size: 150,
			resizable: false,
			slideTrigger_open: "mouseover"
		},
		// CENTER
		center: {
			resizable: false,
		}
	});
});