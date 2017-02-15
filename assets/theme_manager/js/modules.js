$(document).ready(function() {


	$(".switchModule").on('click', function() {
		var post = {};
		post.mod_id = $(this).prop('id');
		post.value = ($(this).prop('checked') == true) ? 1 : 0;
		var button = $(this);

		if (post.value == 0) {
			sweetAlertInitialize();
			swal({
				title: "Désactivation d'un module.",
				text: "La désactivation d'un module supprime définitivement toutes les données que vous avez configurées pour ce module. Souhaitez vous réellement désactiver ce module ?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Désactiver ce module",
				cancelButtonText: "Annuler"
			}, function(isConfirm) {
				if (isConfirm) {
					switchModule(post);
				} else {
					var id = button[0].id;
					$('input.switchModule#' + id).prop('checked', true);
				}
			});
		} else {
			switchModule(post);
		}
	});

	function switchModule(post) {
		$.ajax({
			url: '/manager/modules_selection',
			data: post,
			method: 'POST',
			complete: function(jqXHR, textStatus) {
				modules_selection_modified(jqXHR.responseText);
			}
		});
	}


	function modules_selection_modified(_type) {
		notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Votre modification a bien été pris en compte.');
		setTimeout('location.reload()', 500);
	}

});