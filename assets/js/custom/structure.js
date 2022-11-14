// Chargement des structures dans le fomulaire
$('#administrateur').select2({
    dropdownParent: $('#form_ajout_structure'),
    ajax: {
        url: general_data.site_url + '/structures/get_users',
        dataType: 'json',
    }
});

//Enregistrement de la nouvelle structure
$('#form_ajout_structure').on('submit', function(e){
    e.preventDefault();
    
    let errors = validate($(this), structure_form_rules);
    errors ? set_form_error_message(errors) : (function(){
        
        let data = $(e.target).serializeArray();
        $('#ajouter_structure').modal('hide')
        let promesse = request(e.target.action, 'json', true, 'POST', data);
        promesse.then(function(response) {
            if(typeof response === 'object'){
                set_backend_error_message(response)
            }else{
                notify_on_screen('Structure ajouté avec succès')
                tableStructures.ajax.reload();

            }
        });
    })();
});

//Configuration du formaulaire d'edition
$('#modifier_structure').on('click', function(e){
    e.stopPropagation();
    promesse = request(general_data.site_url + '/structures/get_structure', 'json', true, 'POST', {structure_id: general_data.table_item_selected.slice(1)});
    promesse.then(function(response) {
        console.log(response)
        set_edition_form_structure(response[0])
        set_edition_form('form_ajout_structure', create_hidden_input('structure_id', general_data.table_item_selected.slice(1)), "<h2 class='modal_title'>Modifier une structure</h2>");
    });
})

function set_edition_form_structure(data){
    let promesse = request(general_data.site_url + '/users/get_user', 'json', true, 'POST', {user_id: data.admin_id});
    promesse.then(function(response) {
        $('#nom', '#form_ajout_structure').val(data.nom);
        let option = new Option(response[0].nom_prenoms, response[0].user_id, false, true);
        $('#administrateur', '#form_ajout_structure').append(option).trigger('change');        
    });
}

//Changement de statut de la structure 
$('#statut_structure').on('click', function(e){
    if($(this).hasClass('btn-primary')) {
        confirm_action(`<p>Changer le statut de cette structure ?</p>`, change_structure_statut);
    }
});

function change_structure_statut() {
    let promesse = request(general_data.site_url + '/structures/structure_statut', 'json', true, 'POST', {structure_id: general_data.table_item_selected.slice(1), statut: get_statut_from_table(tableStructures, 3)});
    promesse.then(function(response){
        if(response == 1){
            reinit_structure_page();
            notify_on_screen( "Statut modifié avec succès");
        };
    });
}

$('#ajouter_structure').on('hide.bs.modal', () => reset_structure_form());

function reset_structure_form(){
    let form = $("#form_ajout_structure");
    form.get(0).reset()
    form.removeClass('edition')
    $('.for_edition', form).remove()
    $('#modal_title').html("<h2 class='modal_title'>Ajouter une structure</h2>")
    $('.invalid-feedback').remove()
    $('#form_ajout_structure').find('.form-group').removeClass('has-error')
    $('#administrateur').val(null).trigger('change.select2')
};

//Reinitialisation de la page après action
function reinit_structure_page(){
	tableStructures.ajax.reload();
    $('#modifier_structure').removeClass('btn-primary');
    $('#modifier_structure').addClass('btn-default')
    $('#statut_structure').removeClass('btn-primary');
    $('#statut_structure').addClass('btn-default')
}