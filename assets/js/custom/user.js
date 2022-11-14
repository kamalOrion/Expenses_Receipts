// Chargement des structures dans le fomulaire
$('#structure').select2({
    dropdownParent: $('#form_ajout_user'),
    ajax: {
        url: general_data.site_url + '/users/get_structures',
        dataType: 'json',
    }
});

//Initialisation du groupe dualbox de la page user
$('#groupe_User').bootstrapDualListbox(dualbox_setting);

//Reinitilisation des formulaire des modals on modal hide
reset_form($('#ajouter_user'));
reset_form($('#form_mdp_user'));

//Reinitialisation du formulaire d'ajout près configuration pour edition
$('#ajouter_user').on('hidden.bs.modal', function(){
    if($(this).hasClass('edition')) unset_edition_form('form_ajout_user', "Ajouter un utilisateur");
})

//Configuration du formaulaire d'edition
$('#modifier_user').on('click', function(){
    if($(this).hasClass('btn-primary')) {
        let promesse = request(general_data.site_url + '/users/get_user', 'json', true, 'POST', {user_id: tableUsers.cell('.selected', 0).data().slice(1)});
        promesse.then(function(response){
            set_edition_form('form_ajout_user', create_hidden_input('user_id', general_data.table_item_selected), "Modifier un utilisateur");
            set_fill_user_form(response[0].structure_id);
            $('#ajouter_user').modal('show');
        });
    }
});

//Initilisation du formulaire d'ajout dans un groupe de l'utilisateur
$('#modifier_groupeUser').on('click', function(){
    if($(this).hasClass('btn-primary')) {
        get_and_set_dualbox_groupe_user_data();
        $('#groupe_u').modal('show');
    }
});

//Affichage du formulaire d'edition de mot de passe
$('#mdp_user').on('click', function(){
    if($(this).hasClass('btn-primary')) {
        $('#mdp_form_user').modal('show');
    }
});

//Changement de statut de l'utilisateur 
$('#statut_user').on('click', function(e){
    if($(this).hasClass('btn-primary')) {
        confirm_action(`<p>Changer le statut de cet utilisateur ?</p>`, change_user_statut);
    }
});

function change_user_statut() {
    let promesse = request(general_data.site_url + '/users/user_statut', 'json', true, 'POST', {user_id: tableUsers.cell('.selected', 0).data().slice(1), statut: get_statut_from_table(tableUsers, 5)});
    promesse.then(function(response){
        if(response == 1){
            reinit_user_page();
            notify_on_screen( "Statut modifié avec succès");
        };
    });
}

//Reinitialisation du mot de passe de l'utilisateur
$('#mail_user').on('click', function(e){
    if($(this).hasClass('btn-primary')) {
        confirm_action(`<p>Réinitialiser le mot de passe de cet utilisateur ?</p>`, reinit_user);
    }
});

function reinit_user() {
    let promesse = request(general_data.site_url + '/users/reinit_pwd/' + tableUsers.cell('.selected', 0).data().slice(1), 'json', true, 'GET', $(e.target).serializeArray());
    promesse.then(function(response){
        if(response == 'user'){
            reinit_user_page();
            notify_on_screen( "Un email de réinitialisation a été envoyer à cet utilisateur");
        };
    });
}

//Enregistrement / modification d'un nouvelle utilisateur
$('#form_ajout_user').on('submit', function(e){
    e.preventDefault();
    
    let errors = validate($(this), user_form_add_rules);
    errors ? set_form_error_message(errors) : (function(){
        $('#ajouter_user').modal('hide')
        let promesse = request(e.target.action, 'json', true, 'POST', $(e.target).serializeArray());
        promesse.then(function(response) {

            if(typeof response === 'object'){
                set_backend_error_message(response)
            } else {
                reinit_user_page()
                notify_on_screen(  response != 1 ? "Utilsateur ajouté avec succès.<br/>Un email d'activation lui a été transmis" : "Utilsateur modifié avec succès");
            };

            if(typeof response === "string" && response.length == 10) request(general_data.site_url + '/users/notify_user_added', 'json', true, 'POST', {str : response});
        });
    })();
});

//Ajout de l'utilisateur dans des groupes
$('#form_ajout_groupe_user').on('submit', function(e){
    e.preventDefault();
    
    $('#groupe_u').modal('hide')
    let data = $(e.target).serializeArray();
    data.push({name: 'user_id', value: tableUsers.cell('.selected', 0).data().slice(1)})
    let promesse = request(e.target.action, 'json', true, 'POST', data);
    promesse.then(function(response) {
        if(response == 1) notify_on_screen('Opération éffectué avec succès');
    });
        
});

//Enregistrement du nouveau mot de passe 
$('#form_mdp_user').on('submit', function(e){
    e.preventDefault();
    
    let errors = validate($(this), user_form_mdp_rules);
    errors ? set_form_error_message(errors) : (function(){
        $('#mdp_form_user').modal('hide')
        let data = $(e.target).serializeArray();
        data.push({name: 'user_id', value: tableUsers.cell('.selected', 0).data().slice(1)})
        let promesse = request(e.target.action, 'json', true, 'POST', data);
        promesse.then(function(response) {
            (typeof response === 'object') ? set_backend_error_message(response) : notify_on_screen('Mot de passe mise à jour avec succès');
        });
    })();
});

//Recuperation et remplissage du dualbox
function get_and_set_dualbox_groupe_user_data(){
    //Getting data
    let groupes = request(general_data.site_url + '/users/get_groupes', 'json', false, 'POST', {user_id : tableUsers.cell('.selected', 0).data().slice(1)});
    //Setting data
    setDualBoxData(groupes, 'groupe_User', 'nom', 'groupe_id');
}

//Remplissage des champs du formulaire d'ajout pour edition
function set_fill_user_form(structure_id){
    let promesse = request(general_data.site_url + '/structures/get_structure', 'json', true, 'POST', {structure_id: structure_id});
    promesse.then(function(response) {
        console.log(response)
        let option = new Option(response[0].nom, response[0].structure_id, false, true);        
        $('#structure', '#form_ajout_user').append(option).trigger('change');     
        $('#nom_prenoms', '#form_ajout_user').val(tableUsers.cell('.selected', 1).data())
        $('#email', '#form_ajout_user').val(tableUsers.cell('.selected', 2).data())
        $('#tel', '#form_ajout_user').val(tableUsers.cell('.selected', 4).data())   
    });
}

//Reinitialisation de la page après action
function reinit_user_page(){
	tableUsers.ajax.reload();
    $('#modifier_user').removeClass('btn-primary');
    $('#modifier_user').addClass('btn-default')
    $('#modifier_groupeUser').removeClass('btn-primary');
    $('#modifier_groupeUser').addClass('btn-default')
    $('#mdp_user').removeClass('btn-primary');
    $('#mdp_user').addClass('btn-default')
    $('#statut_user').removeClass('btn-primary');
    $('#statut_user').addClass('btn-default')
    $('#mail_user').removeClass('btn-primary');
    $('#mail_user').addClass('btn-default')
}

 



