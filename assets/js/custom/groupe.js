//Initialisation du groupe dualbox de la page groupe
$('#users_groupe').bootstrapDualListbox(dualbox_setting);

//Reinitilisation des formulaire des modals on modal hide
reset_form($('#form_ajout_groupe'), set_groupe_active_tab);

//Reinitialisation du formulaire d'ajout près configuration pour edition
$('#ajouter_groupe').on('hidden.bs.modal', function(){
    if($(this).hasClass('edition')) unset_edition_form('form_ajout_groupe', "Ajouter un groupe");
})

//Reactivation de la tab principale du formulaire de le page groupe
function set_groupe_active_tab() {
    get_and_set_dualbox_groupe_data();
    genTabEl = document.querySelector('#groupe_form_tabs li:first-child a'),
    genTab = new bootstrap.Tab(genTabEl);
    genTab.show();
}

//Recuperation et remplissage du dualbox
function get_and_set_dualbox_groupe_data(groupe_id) {

    let groupes = request(general_data.site_url + '/groupe/get_users', 'json', false, 'POST', (groupe_id ? {groupe_id: groupe_id} : null));

    if(groupe_id) $('#users_groupe').html(null)

    setDualBoxData(groupes, 'users_groupe', 'nom_prenoms', 'user_id');
}

//Remplissage du dualbox pour ajout de groupe
get_and_set_dualbox_groupe_data();


//Configuration du formaulaire d'edition
$('#modifier_groupe').on('click', function(){
    if($(this).hasClass('btn-primary')) {
        set_edition_form('form_ajout_groupe', create_hidden_input('groupe_id', general_data.table_item_selected), "Modifier un groupe");
        set_fill_groupe_form(general_data.table_item_selected.slice(1));
        $('#ajouter_groupe').modal('show');
    }
});

//Enregistrement / modification d'un nouvelle utilisateur
$('#form_ajout_groupe').on('submit', function(e) {
    e.preventDefault();
    let errors = validate($(this), groupe_form_add_rules);
    errors ? set_form_error_message(errors) : (function() {

        $('#ajouter_groupe').modal('hide')
        let promesse = request(e.target.action, 'json', true, 'POST', $(e.target).serializeArray());
        
        promesse.then(function(response) {

            if(typeof response === 'object') {
                set_backend_error_message(response)
            } else {
                reinit_groupe_page()
                notify_on_screen(  response != 1 ? "Groupe ajouté avec succès" : "Groupe modifié avec succès");
            };
            if(typeof response === "string" && response.length == 10) request(general_data.site_url + '/users/notify_user_added', 'json', true, 'POST', {str : response});
        });

    })();
});

//Changement de statut de l'utilisateur 
$('#statut_groupe').on('click', function(e){
    if($(this).hasClass('btn-primary')) {
        confirm_action(`<p>Changer le statut de ce groupe ?</p>`, change_groupe_statut);
    }
});

function change_groupe_statut() {
    let promesse = request(general_data.site_url + '/groupe/groupe_statut', 'json', true, 'POST', {groupe_id: tableGroupes.cell('.selected', 0).data().slice(1), statut: get_statut_from_table(tableGroupes, 2)});
    promesse.then(function(response){
        
        if(response == 1){
            reinit_groupe_page();
            notify_on_screen( "Statut modifié avec succès");
        };
    });
}

//Changement de statut de l'utilisateur 
$('#suppression_groupe').on('click', function(e){
    if($(this).hasClass('btn-primary')) {
        confirm_action(`<p>Supprimer définitivement ce groupe ?</p>`, delete_groupe);
    }
});

function delete_groupe() {
    let promesse = request(general_data.site_url + '/groupe/delete_groupe', 'json', true, 'POST', {groupe_id: tableGroupes.cell('.selected', 0).data().slice(1)});
    promesse.then(function(response){
        
        if(response == 1){
            reinit_groupe_page();
            notify_on_screen( "Groupe suppimer avec succès");
        };
    });
}

//Remplissage des champs du formulaire d'ajout pour edition
function set_fill_groupe_form(selected_groupe_id){
    $('#nom').val(tableGroupes.cell('.selected', 1).data())
    //Remplissage du dualbox pour edition
    get_and_set_dualbox_groupe_data(selected_groupe_id);
    //Selection des privilèges du groupe
    set_privileges_for_edition(selected_groupe_id)

}

function set_privileges_for_edition(groupe_id){
    let promesse = request(general_data.site_url + '/groupe/get_privileges', 'json', true, 'POST', {groupe_id: groupe_id});
    promesse.then(function(response){
        console.log(response)
        for(priv of response){
            $('#'+priv).prop('checked', true);
        }
    });
}

//Reinitialisation de la page après action
function reinit_groupe_page(){
	tableGroupes.ajax.reload();
    $('#modifier_groupe').removeClass('btn-primary');
    $('#modifier_groupe').addClass('btn-default')
    $('#statut_groupe').removeClass('btn-primary');
    $('#statut_groupe').addClass('btn-default')
    $('#suppression_groupe').removeClass('btn-primary');
    $('#suppression_groupe').addClass('btn-default')
}