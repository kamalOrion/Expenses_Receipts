var selected_vente = [],
timerID = null;

$('#b_vente').on('click', function(e){
    let ele = $("#vente_eff"),
    prev = $('i', "#b_vente");
    if(ele.is(':visible')){
        prev.removeClass('fa-check')
        prev.addClass('fa-times')
        ele.hide()
    }else{
        prev.removeClass('fa-times')
        prev.addClass('fa-check')
        ele.show()
    } 
});

$('#b_recette').on('click', function(e){
    let ele = $("#recette_eff"),
    prev = $('i', "#b_recette");
    if(ele.is(':visible')){
        prev.removeClass('fa-check')
        prev.addClass('fa-times')
        ele.hide()
    }else{
        prev.removeClass('fa-times')
        prev.addClass('fa-check')
        ele.show()
    } 
});


$('#tous_vente').on('click', function(e){
    $('#b_vente').trigger('click');
    $('#b_recette').trigger('click');
});

// Chargement des types de depense dans le fomulaire
$('#produit').select2({
    dropdownParent: $('#form_ajout_vente'),
    ajax: {
        url: general_data.site_url + '/ventes/get_produits',
        dataType: 'json',
    }
});

$('#form_ajout_vente').on('submit', function(e){
    e.preventDefault();
    
    let errors = validate($(this), vente_form_rules);
    errors ? set_form_error_message(errors) : (function(){
        
        let promesse = request(e.target.action, 'json', true, 'POST', $(e.target).serializeArray());
        promesse.then(function(response) {
            if(typeof response === 'object'){
                set_backend_error_message(response)
            } else {
                $('#ventes_modal').modal('hide')
                feed_vente()
                notify_on_screen(  response == 1 ? "Vente enrégistré avec succès" : "Vente modifié avec succès");
            };
        });

    })();
});

function feed_vente(text){
    $('#vente_container').html(null);
    let promesse = request(general_data.site_url + '/ventes/get_ventes_non_groupe', 'json', true, 'POST', (text ? {text: text} : null));
    promesse.then(function(response) {
        let html = to_html_vente(response);
        $('#vente_container').append(html);
        $('.vente_item').show('slow')
    });
}

function to_html_vente(data, flag){
    if(data){
        $('#total_vente').html(data.length)
        let html = '', montant_total = 0;
        for(item of data){
            montant_total += (item.prix_unitaire * item.qte)
            html += `<li class="vente_item ${ flag ? '' : 'success-element' } custom_hide" index="${ item.vente_id }" montant='${ item.prix_unitaire * item.qte }' style='padding-top: 5px'>
            <div class="row">                
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <b>
                                <span class="float-right" style="display: inline-block">
                                    <span title="Prix unitaire" class="label" style="display: inline-block">
                                        <i class="fa fa-money"></i> ${ item.mode_paiement == 'momo' ? 'Mobile Money' : item.mode_paiement} | ${ (item.prix_unitaire * item.qte).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') } FCFA
                                    </span>
                                    <span title="Date de fin" class="date_fin_activite label label-success" style="display: inline-block">
                                        <i class="fa fa-clock-o"></i> ${ format_date(item.date_vente) }
                                    </span>
                                </span>
                                <h4>#${ item.vente_id }</h4>
                            </b>
                        </div>
                        <div class='col-lg-12'>
                            <b><i class="fa fa-tag"></i> ${ item.libelle }</b>
                        </div>
                    </div>
                </div> 
                <div class="col-md-12 mb-1">
                    <small><i class="fa fa-user"></i> ${ item.nom_prenoms }</small> | <small>Qté : ${ item.qte } | Prix unitaire : ${ item.prix_unitaire } FCFA </small>
                    <div class="row">
                        <div class="col-md mb-1 mt-2">
                            <p class="text-left" style="margin-bottom: 5px">${ item.commentaire }</p>
                        </div>
                    </div>
                </div>
                ${ !flag ? `
                <div class="col-md-12">
                    
                    <span id="activite_action_btn_block">
                        ${ allowed('MV') ? `<i class="vente_item_edit fa fa-pencil" style="font-size: 15px; padding-right: 6px" title="Modifier"></i>` : '' }
                        ${ allowed('SV') ? `<i class="vente_item_delete fa fa-trash" style="font-size: 15px; padding-right: 6px" title="Supprimer"></i>` : '' }
                    </span>
                </div>
                ` : '' }
                
            </div>                            
        </li>`;
        } $('#total_vente_montant').html(montant_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' FCFA')
        return html;
    }
}

function to_html_recette(data){
    if(data){
        $('#total_recette').html(data.length)
        let html = '', montant_total = 0;
        for(item of data){
            montant_total += Number(item.montant_total)
            html += `
            <div class="ibox collapsed info-element recette_item custom_hide w-100">
                <div class="ibox-title">
                    <h5><i class='fa fa-clock-o'></i> ${ format_date(item.date_recette) }</h5><br/>
                    <h5><i class='fa fa-tag${ item.nbr_recette > 1 ? 's' : '' }'></i> ${ item.nbr_recette } vente${ item.nbr_recette > 1 ? 's' : '' } </h5><br/>
                    <small><i class='fa fa-user'></i> ${ item.nom_prenoms } | <i class='fa fa-money'></i> ${ item.montant_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' FCFA' }</small>
                    <div class="ibox-tools">
                    ${ allowed('DVR') ? 
                        `<span class='unlock_recette'>
                            <i class="recette_unlock fa fa-unlock" style="font-size: 15px; padding-right: 6px" title="Selectionner"></i>
                        </span>` : '' }
                        <a class="collapse-reponse-recette" index='${ item.recette_id }'>
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                
                <div class="ibox-content">
                    <div id='recette_list_container_${ item.recette_id}' class=" row"></div>
                </div>
            </div>`;
        } $('#total_recette_montant').html(montant_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' FCFA')
        return html;
    }
} 

function feed_recette(){
    $('#recette_container').html(null);
    let promesse = request(general_data.site_url + '/ventes/get_recette', 'json', true, 'POST');
    promesse.then(function(response) {
        let html = to_html_recette(response);
        $('#recette_container').append(html);
        $('.recette_item').show('slow')
    });
}

$(document).on('click', '.vente_item_edit', function(e){
    e.stopPropagation();
    let vente_id = $(this).closest('li').attr('index'),
    promesse = request(general_data.site_url + '/ventes/get_ventes_non_groupe', 'json', true, 'POST', {vente_id: vente_id});
    promesse.then(function(response) {
        set_edition_form_vente(response[0])
        set_edition_form('form_ajout_vente', create_hidden_input('vente_id', vente_id), "<i class='fa fa-edit'></i> Modifier une vente");
    });
})

//Suppression vente
$(document).on('click', '.vente_item_delete', function(e){
    e.stopPropagation();
    confirm_action(`<p>Supprimer cette vente ?</p>`, delete_vente, this);
})

function set_edition_form_vente(data){
    let promesse = request(general_data.site_url + '/ventes/get_produit', 'json', true, 'POST', {produit_id: data.produit_id});
    promesse.then(function(response) {
        let option = new Option(response[0].libelle, response[0].produit_id, false, true);
        $('#produit', '#form_ajout_vente').append(option).trigger('change');
        $('#qte', '#form_ajout_vente').val(data.qte);
        $('#prix_unitaire', '#form_ajout_vente').val(data.prix_unitaire);
        $('input:radio[name=mode_paiement]', '#form_ajout_vente').filter('[value='+ data.mode_paiement +']').prop('checked', true);
        $('#date_vente', '#form_ajout_vente').val(data.date_vente);
        $('#commentaire', '#form_ajout_vente').val(data.commentaire);
    });
}

$('#produit').on('select2:select', function(){
    let promesse = request(general_data.site_url + '/ventes/get_last_price', 'json', true, 'POST', {produit_id: $(this).val()});
    promesse.then(function(response) {
        $("#prix_unitaire").val(response ? response[0].prix_unitaire : '');
    });
})

function delete_vente(element){
    let vente_id = $(element).closest('li').attr('index')
    promesse = request(general_data.site_url + '/ventes/delete_vente', 'json', true, 'POST', {vente_id: vente_id});
    promesse.then(function(response) {
        if(response){
            feed_vente();
            notify_on_screen( "Vente supprimer avec succès");
        };
    });
}

function select_vente(element, flag){
    element.addClass('card_selected');
    if(flag){
        element.each(function( index, ele ) {
            selected_vente.push($(ele).attr('index'));
        });
    }else{
        selected_vente.push(element.attr('index'));
    }
}

function unselect_vente(element, flag){
    element.removeClass('card_selected');
    if(flag){
        element.each(function( index, ele ) {
            selected_vente.splice(selected_vente.indexOf($(ele).attr('index')), 1);
        });
    }else{
        selected_vente.splice(selected_vente.indexOf(element.attr('index')), 1);
    }
}

$(document).on('click', '.vente_item', function(e){
    if(allowed('GVR')) $(this).hasClass('card_selected') ? unselect_vente($(this)) : select_vente($(this));
});

$('#btn_select_all_vente').on('click', function(e){
    $('.card_selected').length ? unselect_vente($('.vente_item'), true) : select_vente($('.vente_item'), true); 
});

$('#btn_group_all_vente').on('click', function(e){
    if(selected_vente.length){
        confirm_action(
            `<p>Grouper les ventes sélectionnées en recettes ?</p>
            <div class="form-group row m-0">
                <div class="col-sm-12"><input id='date_recette' name='date_recette' type="date" class="form-control" placeholder='Date de la recette'></div>
            </div>`
            , groupe_vente_as_recette);
    } else  notify_on_screen("Aucune vente sélectionner");
});

function groupe_vente_as_recette(date_recette){
    promesse = request(general_data.site_url + '/ventes/groupe_as_recette', 'json', true, 'POST', {selected_vente: selected_vente, date_recette: date_recette});
    promesse.then(function(response) {
        if(response == 1){

            $('#btn_select_all_vente').trigger('click')
            feed_vente();
            feed_recette();
            notify_on_screen( "Recette créé avec succès");
        };
    });
}

$(document).on('click', '.collapse-reponse-recette', function (e) {
    e.preventDefault();
    get_liste_vente_recette($(this).attr('index'))
    collapse_reponse(e, $(this))
});

$(document).on('click', '.unlock_recette', function (e) {
    e.preventDefault();
    confirm_action(`<p>Dissocier les éléments de cette recettes ?</p>`, degroupe_vente_as_recette, $(this).next().attr('index'));
});

function degroupe_vente_as_recette(recette_id){
    promesse = request(general_data.site_url + '/ventes/degroupe_recette', 'json', true, 'POST', {recette_id: recette_id});
    promesse.then(function(response) {
        if(response == 1){
            feed_vente();
            feed_recette();
            notify_on_screen( "Recette dégroupé avec succès");
        };
    });
}

function get_liste_vente_recette(recette_id){
    let item = $('#recette_list_container_'+ recette_id);
    item.html() == '' ? (function(){
        let promesse = request(general_data.site_url + '/ventes/get_liste_vente_recette', 'json', true, 'POST', {recette_id: recette_id});
        promesse.then(function(response){
            let html = to_html_vente(response, true);
            item.append(html);
            $('.vente_item ').show('slow')
        });
    })() : null;
}

$('#ventes_modal').on('hide.bs.modal', () => reset_vente_form());

function reset_vente_form(){
    let form = $("#form_ajout_vente");
    form.get(0).reset()
    form.removeClass('edition')
    $('.for_edition', form).remove()
    $('#modal_title').html("<i class='fa fa-plus'></i> Enrégistré une vente")
    $('.invalid-feedback').remove()
    $('#form_ajout_vente').find('.form-group').removeClass('has-error')
    $('#produit').val(null).trigger('change.select2')
    $('input[type="date"]').val(today_date_formated())
};

$('#search_vente').on('keyup', function(){
    timerID ? clearTimeout(timerID) : null;
    timerID = setTimeout(() => feed_vente($(this).val()), 1000);
});

feed_vente()
feed_recette()