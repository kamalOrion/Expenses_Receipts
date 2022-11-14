//selected_depense
var selected_depense = [],
selected_valide_depense = [],
selected_depense_motant = 0;

// Chargement des types de depense dans le fomulaire
$('#type_depense').select2({
    dropdownParent: $('#form_ajout_depense'),
    ajax: {
        url: general_data.site_url + '/depenses/get_type_depenses',
        dataType: 'json',
    }
});

// Function de gestion de l'affichages des blocs
$('#b_depense').on('click', function(e){
    let ele = $("#dep_demnade"),
    prev = $('i', "#b_depense");
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

$('#b_total').on('click', function(e){
    let ele = $("#dep_total"),
    prev = $('i', "#b_total");
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

$('#b_valide').on('click', function(e){
    let ele = $("#dep_valide"),
    prev = $('i', "#b_valide");
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

$('#b_list').on('click', function(e){
    let ele = $("#dep_effectue"),
    prev = $('i', "#b_list");
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


$('#tous_depense').on('click', function(e){
    $('#b_depense').trigger('click');
    $('#b_total').trigger('click');
    $('#b_valide').trigger('click');
    $('#b_list').trigger('click');
});


$('#form_ajout_depense').on('submit', function(e){
    e.preventDefault();
    
    let errors = validate($(this), depense_form_rules);
    errors ? set_form_error_message(errors) : (function(){

        let form_data = $(e.target).serializeArray(),
        promesse = request(e.target.action, 'json', true, 'POST', form_data);
        promesse.then(function(response) {
            if(typeof response === 'object'){
                set_backend_error_message(response)
            } else {
                $('#depenses_modal').modal('hide')
                feed_depense()
                notify_on_screen(  response == 1 ? "Dépense ajouté avec succès" : "Dépense modifié avec succès");
            };
        });

    })();
});

$('#type_depense').on('select2:select', function(){
    let promesse = request(general_data.site_url + '/depenses/get_last_price', 'json', true, 'POST', { type_depense_id: $(this).val() });
    promesse.then(function(response) {
        $("#prix_unitaire").val(response ? response[0].prix_unitaire : '');
    });
})

function feed_depense(text){
    $('#depense_container').html(null);
    let promesse = request(general_data.site_url + '/depenses/get_depenses_non_valide', 'json', true, 'POST', text ? {text: text} : null);
    promesse.then(function(response) {
        let html = to_html_depense(response);
        $('#depense_container').append(html);
        $('.depense_item').show('slow')
    });
}

function feed_depense_valide(text){
    $('#depense_valide_container').html(null);
    let promesse = request(general_data.site_url + '/depenses/get_depenses_valide', 'json', true, 'POST', text ? {text: text} : null);
    promesse.then(function(response) {
        let html = to_html_depense(response, 'valid');
        $('#depense_valide_container').append(html);
        $('.depense_item').show('slow')
    });
}

//Cutom collapse for reponse display
function collapse_reponse(e, element){
    var ibox = element.closest('div.ibox');
    var button = element.find('i');
    var content = ibox.children('.ibox-content');
    content.slideToggle(200);
    button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
    ibox.toggleClass('').toggleClass('border-bottom');
    setTimeout(function () {
        ibox.resize();
        ibox.find('[id^=map-]').resize();
    }, 50);
}

$(document).on('click', '.collapse-reponse-depense', function (e) {
    e.preventDefault();
    get_liste_depense_effectue($(this).attr('index'))
    collapse_reponse(e, $(this))
});

function get_liste_depense_effectue(list_valid_id){
    let item = $('#depense_effectue_list_container_'+ list_valid_id);
    item.html() == '' ? (function(){
        let promesse = request(general_data.site_url + '/depenses/get_depenses_valide_list', 'json', true, 'POST', {list_valid_id: list_valid_id});
        promesse.then(function(response){
            let html = to_html_depense(response, 'eff');
            item.append(html);
            $('.depense_item ').show('slow')
        });
    })() : null;
}

function feed_liste_depense_effectue(){
    $('#depense_effectue_container').html(null);
    let promesse = request(general_data.site_url + '/depenses/get_depenses_effectue', 'json', true, 'POST');
    promesse.then(function(response) {
        let html = to_html_depense_effectue(response);
        $('#depense_effectue_container').append(html);
        $('.depense_effectue_list').show('slow')
    });
}

function to_html_depense_effectue(data){
    if(data){
        $('#total_liste_depense_effectue').html(data.length)
        let html = '', montant_total = 0;
        for(item of data){
            montant_total += Number(item.montant_total)
            html += `
            <div class="ibox collapsed info-element depense_effectue_list custom_hide w-100">
                <div class="ibox-title">
                    <h5><i class='fa fa-clock-o'></i> ${ format_date(item.date_enreg) }</h5><br/>
                    <h5><i class='fa fa-tag${ item.nbr_depense_valide > 1 ? 's' : '' }'></i> ${ item.nbr_depense_valide } dépense${ item.nbr_depense_valide > 1 ? 's' : '' } validée${ item.nbr_depense_valide > 1 ? 's' : '' }</h5><br/>
                    <small><i class='fa fa-user'></i> ${ item.nom_prenoms } | <i class='fa fa-money'></i> ${ item.montant_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' FCFA' }</small>
                    <div class="ibox-tools">
                    ${ allowed('DDE') ? 
                        `<span class='unlock_depense'>
                            <i class="annuler_depense_valide fa fa-unlock" style="font-size: 15px; padding-right: 6px" title="Dissocier"></i>
                        </span>` : '' }
                        <a class="collapse-reponse-depense" index='${ item.liste_depenses_valides_id }'>
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div id='depense_effectue_list_container_${ item.liste_depenses_valides_id}' class=" row"></div>
                </div>
            </div>`;
        } $('#total_liste_depense_effectue_montant').html(montant_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' FCFA')
        return html;
    }
}   

function to_html_depense(data, flag){
    if(data){
        if(!flag) $('#total_depense').html(data.length)
        if(flag == 'valid') $('#total_depense_valide').html(data.length)
        let html = '', montant_total = 0;
        for(item of data){
            montant_total += (item.prix_unitaire * item.qte)
            html += `<li class="depense_item ${ flag == 'eff' ? '' : ( flag == 'valid' ? 'success-element depense_valide' : 'danger-element') }  custom_hide" index="${ item.depense_id }" montant='${ item.prix_unitaire * item.qte }' style='padding-top: 5px'>
            <div class="row">                
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <b>
                                <span class="float-right" style="display: inline-block">
                                    <span title="Prix unitaire" class="label" style="display: inline-block">
                                        <i class="fa fa-money"></i>  ${ item.mode_paiement == 'momo' ? 'Mobile Money' : item.mode_paiement} | ${ (item.prix_unitaire * item.qte).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') } FCFA
                                    </span>
                                    <span title="Date de fin" class="date_fin_activite label label-success" style="display: inline-block">
                                        <i class="fa fa-clock-o"></i> ${ format_date(item.echeance) }
                                    </span>
                                </span>
                                <h4>#${ item.depense_id }</h4>
                            </b>
                        </div>
                        <div class='col-lg-12'>
                            <b><i class="fa fa-tag"></i> ${ item.libelle }</b>
                        </div>
                    </div>
                </div> 
                <div class="col-md-12 mb-1">
                    <div class="row">
                        <div class="col-md mb-1 mt-2">
                            <p class="text-left" style="margin-bottom: 5px">${ item.commentaire }</p>
                        </div>
                    </div>
                    <small><i class="fa fa-user"></i> ${ item.nom_prenoms }</small> | <small>Qté : ${ item.qte } | Prix unitaire : ${ item.prix_unitaire } FCFA </small>
                </div>

                ${ !['eff', 'valid'].includes(flag) ? 

                `<div class="col-md-12">

                    ${ allowed('b_select_depense') ? 
                    `<span id="activite_data_btn_block" class="pull-right">
                            <i class="depense_item_select fa fa-arrow-right" style="font-size: 15px; padding-right: 6px" title="Selectionner"></i>
                        </span>` : '' }
                        
                        <span id="activite_action_btn_block">
                            ${ allowed('MD') ? `<i class="depense_item_edit fa fa-pencil" style="font-size: 15px; padding-right: 6px" title="Modifier"></i>` : '' }
                            ${ allowed('SD') ? `<i class="depense_item_delete fa fa-trash" style="font-size: 15px; padding-right: 6px" title="Supprimer"></i>` : '' }
                        </span>

                    </div>` : '' }

                    ${ flag == 'valid' && allowed('ID') ? 
                        `<div class="col-md-12">
                            <span id="activite_data_btn_block" class="pull-right">
                                <i class="depense_item_invalide fa fa-undo" style="font-size: 15px; padding-right: 6px" title="Invalider"></i>
                            </span>
                        </div>` : ''
                    }
                    
                </div>                            
        </li>`;
        } 
        if(!flag) $('#total_depense_montant').html(montant_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' FCFA')
        if(flag == 'valid') $('#total_depense_valide_montant').html(montant_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' FCFA')
        return html;
    }
}

// $(document).on('click', '.depense_item', function(e){
//     $('.card_selected', '#depense_container').removeClass('card_selected');
//     $(this).addClass('card_selected');
// });

$(document).on('click', '.unlock_depense', function (e) {
    e.preventDefault();
    confirm_action(`<p>Dissocier les dépenses de ce groupe ? </p>`, dissocier_depense_valide, $(this).next().attr('index'));
});

function dissocier_depense_valide(liste_depenses_valides_id){
    promesse = request(general_data.site_url + '/depenses/dissocier_depense_effectue', 'json', true, 'POST', {liste_depenses_valides_id: liste_depenses_valides_id});
    promesse.then(function(response) {
        if(response == 1){
            feed_depense_valide();
            feed_liste_depense_effectue();
            notify_on_screen( "Validation dégroupé avec succès");
        };
    });
}

$(document).on('click', '.depense_item_edit', function(e){
    e.stopPropagation();
    let depense_id = $(this).closest('li').attr('index'),
    promesse = request(general_data.site_url + '/depenses/get_depenses_non_valide', 'json', true, 'POST', {depense_id: depense_id});
    promesse.then(function(response){
        set_edition_form_depense(response[0])
        set_edition_form('form_ajout_depense', create_hidden_input('depense_id', depense_id), "<i class='fa fa-edit'></i> Modifier une dépense");
    });
})

//Suppression dépense
$(document).on('click', '.depense_item_delete', function(e){
    e.stopPropagation();
    confirm_action(`<p>Supprimer cette dépense ?</p>`, delete_depense, this);
})

function delete_depense(element){
    let depense_id = $(element).closest('li').attr('index')
    promesse = request(general_data.site_url + '/depenses/delete_depense', 'json', true, 'POST', {depense_id: depense_id});
    promesse.then(function(response) {
        if(response){
            feed_depense();
            notify_on_screen( "Dépense supprimer avec succès");
        };
    });
}

//Invalidé une dépense 
$(document).on('click', '.depense_item_invalide', function(e){
    e.stopPropagation();
    confirm_action(`<p>Invalider cette dépense ?</p>`, invalide_depense, this);
})

function invalide_depense(element){
    let depense_id = $(element).closest('li').attr('index')
    promesse = request(general_data.site_url + '/depenses/invalide_depense', 'json', true, 'POST', {depense_id: depense_id});
    promesse.then(function(response) {
        if(response){
            feed_depense();
            feed_depense_valide();
            notify_on_screen( "Dépense invalidé avec succès");
        };
    });
}

$(document).on('click', '.depense_valide', function(e){
    if(allowed('GDE')) $(this).hasClass('card_selected') ? unselect_depense_valide($(this)) : select_depense_valide($(this));
});

function select_depense_valide(element, flag){
    
    element.addClass('card_selected');
    if(flag){
        element.each(function( index, ele ) {
            selected_valide_depense.push($(ele).attr('index'));
        });
    }else{
        selected_valide_depense.push(element.attr('index'));
    }
}

function unselect_depense_valide(element, flag){

    element.removeClass('card_selected');
    if(flag){
        element.each(function( index, ele ) {
            selected_valide_depense.splice(selected_valide_depense.indexOf($(ele).attr('index')), 1);
        });
    }else{
        selected_valide_depense.splice(selected_valide_depense.indexOf(element.attr('index')), 1);
    }
}


function set_edition_form_depense(data){
    let promesse = request(general_data.site_url + '/depenses/get_type_depense', 'json', true, 'POST', {type_depense_id: data.type_depense_id});
    promesse.then(function(response) {
        let option = new Option(response[0].libelle, response[0].type_depense_id, false, true);
        $('#type_depense', '#form_ajout_depense').append(option).trigger('change');
        $('#qte', '#form_ajout_depense').val(data.qte);
        $('#prix_unitaire', '#form_ajout_depense').val(data.prix_unitaire);
        $('input:radio[name=mode_paiement]', '#form_ajout_depense').filter('[value='+ data.mode_paiement +']').prop('checked', true);
        $('#echeance', '#form_ajout_depense').val(data.echeance);
        $('#commentaire', '#form_ajout_depense').val(data.commentaire);
    });
}

$('#depenses_modal').on('hide.bs.modal', () => reset_depense_form());

function reset_depense_form(){
    let form = $("#form_ajout_depense");
    form.get(0).reset()
    form.removeClass('edition')
    $('.for_edition', form).remove()
    $('#modal_title').html("<i class='fa fa-plus'></i> Ajouter une dépense")
    $('.invalid-feedback').remove()
    $('#form_ajout_depense').find('.form-group').removeClass('has-error')
    $('#type_depense').val(null).trigger('change.select2')
    $('input[type="date"]').val(today_date_formated())
}

$(document).on('click', '.depense_item_select', function(e){
    e.stopPropagation();
    let depense_item = $(this).closest('li');
    index = depense_item.attr('index');
    if(!selected_depense.includes(index)){
        selected_depense.push(depense_item.attr('index'))
        $('#total_depense').html(Number($('#total_depense').html()) - 1)
        select_depense(depense_item, this);
    } else {
        selected_depense.splice(selected_depense.indexOf(depense_item.attr('index')), 1);
        $('#total_depense').html(Number($('#total_depense').html()) + 1)
        unselect_depense(depense_item, this);
    }

    $('#total_depense_seleted_montant').html(selected_depense_motant.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' FCFA')
    $('#total_depense_seleted').html(selected_depense.length)
    
})

function select_depense(depense_item, arrow_element){
    selected_depense_motant += Number(depense_item.attr('montant'))
    depense_item.remove()
    $(arrow_element).removeClass('fa-arrow-right').addClass('fa-arrow-left')
    depense_item.removeClass('danger-element').addClass('success-element')
    $('#depense_selected_container').prepend(depense_item)
}

function unselect_depense(depense_item, arrow_element){
    selected_depense_motant -= Number(depense_item.attr('montant'))
    depense_item.remove()
    $(arrow_element).removeClass('fa-arrow-left').addClass('fa-arrow-right')
    depense_item.removeClass('success-element').addClass('danger-element')
    $('#depense_container').prepend(depense_item)
}

$('#valide_depense').on('click', function(){
    if(selected_depense.length){
        confirm_action(`<p>Valider les dépenses selectionnées ?</p>`, validate_depense);
    } else notify_on_screen("Aucune dépense sélectionné");
});

function validate_depense(){
    let promesse = request(general_data.site_url + '/depenses/validate_depense', 'json', true, 'POST', {selected_depense: selected_depense});
    promesse.then(function(response) {
        if(typeof response === 'object'){
            set_backend_error_message(response)
        } else {
            $('#depense_selected_container').html(null)
            $('#total_depense_seleted').html('0')
            $('#total_depense_seleted_montant').html('0')  
            
            selected_depense = [];
            selected_depense_motant = 0;

            feed_depense()
            feed_depense_valide();
            notify_on_screen(  response == 1 ? "Dépense validé avec succès" : "Echèc de l'opération");
        };
    });
}

$('#effectue_depense').on('click', function(){
    if(selected_valide_depense.length){
        confirm_action(`<p>Grouper en dépenses éffectué ?</p>`, effectue_depense);
    } else notify_on_screen("Aucune dépense sélectionné");
});

function effectue_depense(){
    let promesse = request(general_data.site_url + '/depenses/effectue_depense', 'json', true, 'POST', {selected_valide_depense: selected_valide_depense});
    promesse.then(function(response) {
        if(typeof response === 'object'){
            set_backend_error_message(response)
        } else { 
            
            selected_valide_depense = [];
            
            feed_depense_valide();
            feed_liste_depense_effectue();
            notify_on_screen(  response == 1 ? "Dépense validé avec succès" : "Echèc de l'opération");
        };
    });
}

$('#search_depense').on('keyup', function(){
    timerID ? clearTimeout(timerID) : null;
    timerID = setTimeout(() => feed_depense($(this).val()), 1000);
});

$('#search_depense_valide').on('keyup', function(){
    timerID ? clearTimeout(timerID) : null;
    timerID = setTimeout(() => feed_depense_valide($(this).val()), 1000);
});

feed_depense();
feed_depense_valide();
feed_liste_depense_effectue();
