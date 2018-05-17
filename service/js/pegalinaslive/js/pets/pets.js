// Cuando carga el documento
$(document).ready(function() {

	// AL HACER UN CAMBIO EN EL COMBO ESTADO
	$("#pet_type").change(function(event) {
		
		// Opcion seleccionada
		var $optionSelected = $("#pet_type option:selected").val();

		// Validamos si se eligio un estado o no
		if ($optionSelected != 0 && $optionSelected != "") {
			// OBTENEMOS DELEGACIONES Y MUNICIPIOS
			getAllDistrict($optionSelected);
		}
	});

	
 
});