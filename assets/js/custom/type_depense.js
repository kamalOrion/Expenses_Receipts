//Reinitilisation des formulaire des modals on modal hide
reset_form($('#form_ajout_type_depense'));

//Reinitialisation du formulaire d'ajout près configuration pour edition
$('#modal_ajouter_type_depense').on('hidden.bs.modal', function(){
    if($(this).hasClass('edition')) unset_edition_form('form_ajout_type_depense ', "Ajouter un type de dépense");
})

//Enregistrement du nouveau mot de passe 
$('#form_ajout_type_depense').on('submit', function(e){
    e.preventDefault();
    
    let errors = validate($(this), type_depense_form_rules);
    errors ? set_form_error_message(errors) : (function(){
        $('#modal_ajouter_type_depense').modal('hide')
        let data = $(e.target).serializeArray();
        let promesse = request(e.target.action, 'json', true, 'POST', data);
        promesse.then(function(response) {
            if(typeof response === 'object'){
                set_backend_error_message(response)
            }else{
                notify_on_screen('Type de dépense ajouté avec succès')
                tableType_depenses.ajax.reload();

            }
        });
    })();
});

$('#modifier_type_depense').on('click', function(e){
    if($(this).hasClass('btn-primary')) {
        set_edition_form('form_ajout_type_depense', create_hidden_input('type_depense_id', general_data.table_item_selected), "Modifier un type de dépense");
        $('#libelle').val(tableType_depenses.cell('.selected', 1).data())
        $('#description').val(tableType_depenses.cell('.selected', 2).data())
        $('#modal_ajouter_type_depense').modal('show');
    }
});


//Suppression du type de depense
$('#suppression_type_depense').on('click', function(e){
    if($(this).hasClass('btn-primary')) {
        confirm_action(`<p>Supprimer définitivement définitivement ce type de dépense ?</p>`, delete_type_depense);
    }
})

function delete_type_depense(){
    let promesse = request(general_data.site_url + '/basic_data/delete_type_depense', 'json', true, 'POST', {type_depense_id: tableType_depenses.cell('.selected', 0).data().slice(1)});
    promesse.then(function(response){
        
        if(response == 1){
            reinit_type_depense_page();
            notify_on_screen( "Type de dépense suppimer avec succès");
        };
    });
}

function reinit_type_depense_page(){
	tableType_depenses.ajax.reload();
    $('#modifier_type_depense').removeClass('btn-primary');
    $('#modifier_type_depense').addClass('btn-default')
    $('#suppression_type_depense').removeClass('btn-primary');
    $('#suppression_type_depense').addClass('btn-default')
}