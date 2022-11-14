//Reinitilisation des formulaire des modals on modal hide
reset_form($('#form_ajout_produit'));

//Reinitialisation du formulaire d'ajout près configuration pour edition
$('#modal_ajouter_produit').on('hidden.bs.modal', function(){
    if($(this).hasClass('edition')) unset_edition_form('form_ajout_produit', "Ajouter un produit");
})

//Enregistrement du produit
$('#form_ajout_produit').on('submit', function(e){
    e.preventDefault();
    
    let errors = validate($(this), produit_form_rules);
    errors ? set_form_error_message(errors) : (function(){
        $('#modal_ajouter_produit').modal('hide')
        let data = $(e.target).serializeArray();
        //data.push({name: 'user_id', value: tableUsers.cell('.selected', 0).data().slice(1)})
        let promesse = request(e.target.action, 'json', true, 'POST', data);
        promesse.then(function(response) {
            if(typeof response === 'object'){
                set_backend_error_message(response)
            }else{
                notify_on_screen('Produit ajouté avec succès')
                tableProduits.ajax.reload();

            }
        });
    })();
});

$('#modifier_produit').on('click', function(e){
    if($(this).hasClass('btn-primary')) {
        set_edition_form('form_ajout_produit', create_hidden_input('produit_id', general_data.table_item_selected), "Modifier un produit");
        $('#libelle').val(tableProduits.cell('.selected', 1).data())
        $('#prix_unitaire').val(tableProduits.cell('.selected', 2).data().split(' ')[0])
        $('#modal_ajouter_produit').modal('show');
    }
});

//Suppression du produit
$('#suppression_produit').on('click', function(e){
    if($(this).hasClass('btn-primary')) {
        confirm_action(`<p>Supprimer définitivement ce produit ?</p>`, delete_produit);
    }
})

function delete_produit(){
    let promesse = request(general_data.site_url + '/basic_data/delete_produit', 'json', true, 'POST', {produit_id: tableProduits.cell('.selected', 0).data().slice(1)});
    promesse.then(function(response){
        
        if(response == 1){
            reinit_produit_page();
            notify_on_screen( "Produit suppimer avec succès");
        };
    });
}

function reinit_produit_page(){
	tableProduits.ajax.reload();
    $('#modifier_produit').removeClass('btn-primary');
    $('#modifier_produit').addClass('btn-default')
    $('#suppression_produit').removeClass('btn-primary');
    $('#suppression_produit').addClass('btn-default')
}

