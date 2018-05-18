// Cuando carga el documento
$(document).ready(function() {

	// AL HACER UN CAMBIO EN EL COMBO ESTADO
	$("#state_of_mexico").change(function(event) {
		
		// Opcion seleccionada
		var $optionSelected = $("#state_of_mexico option:selected").val();

		// Validamos si se eligio un estado o no
		if ($optionSelected != 0 && $optionSelected != "") {
			// OBTENEMOS DELEGACIONES Y MUNICIPIOS
			getAllDistrict($optionSelected);
		} else {
			// Limpiar combo de delegacion y municipio
			$("#district").html('<option value="0">seleccione</option>');

			// Inicializamos el combo
			$("select").material_select();

			// Quitamos foco al campo codigo postal
			$("#postal_code").blur();
		}
	});

	// AL HACER UN CAMBIO EN EL COMBO DELEGACIONES Y MUNICIPIOS
	$("#district").change(function(event) {
		
		// Opcion seleccionada
		var $optionSelectedDistrict = $("#district option:selected").val();

		// Validamos si se eligio una delegacion o municipio
		if ($optionSelectedDistrict != 0 && $optionSelectedDistrict) {
			// OBTENEMOS LAS COLONIAS
			getAllNeighborhood($optionSelectedDistrict);
		} else {

			// Inicializamos el combo
			$("select").material_select();

			// Quitamos foco al campo codigo postal
			$("#postal_code").blur();
		}

	});
 
});

// OBTENEMOS TODAS LAS DELEGACIONES Y MUNICIPIOS
function getAllDistrict($id_state)
{
	// Combo delegaciones y municipios
	var $select_district 		= $('#district');
	
	// Opciones para agregar en el combo
	var $optionsComboDistrict 	= '<option value="0">seleccione</option>';

	// Llamada ajax
	$.ajax({
		url 		: $basePath + "/application/addresses/getalldistrict",
		type 		: 'POST',
		dataType 	: 'json',
		data 		: {id_state : $id_state},
	})
	.done(function(response) {
		//console.log("success");

		// Validamos la respuesta
		if (response.response == "ok") {
			
			// Recorremos datos
			$.each(response.data, function(index, val) {

				// Generamos opciones del combo
				$optionsComboDistrict 	+= '<option value="' + val.id + '"  data-state="' + val.state_id + '">'
							 	 		+ val.name 
							 	 		+ '</option>' ;

			});
			
			// Agregamos las opciones al combo
			$select_district.html($optionsComboDistrict);

			// Limpiar campo de codigo postal
			$("#postal_code").val("");

			// Inicializamos el combo
			$("select").material_select();

			// Quitamos foco al campo codigo postal
			$("#postal_code").blur();

			// Inicializamos el combo
			//$select_district.material_select();
		}

	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
	
}

