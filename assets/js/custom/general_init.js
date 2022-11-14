var settings = {
    initial_base_url : 'http://' + window.location.host + '/omel'
    //initial_base_url : 'https://' + window.location.host 
},

general_data = {
    session_data: null,
    base_url : null,
    site_url : null,
    table_item_selected : null,
    confirm : false
},

dualbox_setting = {
    selectorMinimalHeight: 160,
    moveOnSelect: false,
    moveOnDoubleClick: true,
    infoText: 'Total {0}',
    infoTextFiltered: '{0} trouvés sur {1}',
    infoTextEmpty: 'Liste vide',
    removeAllLabel: 'Effacer tout',
    moveAllLabel: 'Déplacer tout',
    filterTextClear: 'Afficher tout',
    filterPlaceHolder: 'Rechercher'
},

dialog_settings = {
    autoOpen: false,
    resizable: false,
    height: "auto",
    width: 300,
    modal: true,
    show: { effect: "puff", duration: 200 },
    hide: { effect: "puff", duration: 200 },
    classes: { "ui-dialog": "modal"},
    draggable: false,
    title: "Confirmation"
}

//Setting generale data
let data = request(settings.initial_base_url + "/index.php/Profil/getSessionData", "json", false);
general_data.session_data = data[0];
general_data.base_url = data[1];
general_data.site_url = data[2],

toast_container = $('#toast_container');

toast_container.toast({
    delay: 10000,
    animation: true
});

function allowed(action){
    return general_data.session_data.user_id == 1 || general_data.session_data.privileges.includes(action);
}

function confirm_action(message, callback, data){
    dialog_settings.buttons = [
        {
            text: "Accepter",
            icon: "ui-icon-check",
            click: function(){
                let message_input = $(message).find('input');
                if(!message_input.length){
                    $( this ).dialog( "close" )
                    data ? callback(data) : callback();
                } else {
                    let date_recette = $('#date_recette').val(),
                    error = validate.single(date_recette, {presence: {allowEmpty: false}});
                    if(error){
                        $('#date_recette').change(() => $('.invalid-feedback').remove());
                        $('#date_recette').after("<span class='invalid-feedback' style='display: block'>Vous devez saisir la date de la recette</span>");
                    }else{
                        $( this ).dialog( "close" )
                        callback(date_recette)
                    }
                }
            }
        },
        {
            text: "Annuler",
            icon: "ui-icon-closethick",
            click: function() {
                $( this ).dialog( "close" );
            }
        }
    ];
    $( "#dialog-confirm" ).dialog(dialog_settings);
    $('#confirm_message_container').html(message);
    $('#dialog-confirm').dialog('open');
}

function today_date_formated() {
    var now = new Date();
    var month = (now.getMonth() + 1);               
    var day = now.getDate();
    if (month < 10) 
        month = "0" + month;
    if (day < 10) 
        day = "0" + day;
    return now.getFullYear() + '-' + month + '-' + day;
}

function english_data_format(date){
    let data = date.split('/');
    return data[2] + '-' + data[1] + '-' + data[0]
}

//Seeting dialogue confirmation

function notify_on_screen(message){
    $('#toast_message_container').html(message);
    $('#toast_container').toast('show');
}

function request(url, dataType, async = false, type = null, data = null){

    let request_type = (type != null && ['GET', 'POST'].includes(type)) ? type : 'GET', response = null;

    request_data = {
        url : url,
        type : request_type,
        async: false,
        dataType: dataType,
        success: function(data){ response = data; }
    }

    data ? request_data.data = data : '';

    if(!async) {
        $.ajax(request_data);
        return response;
    }else {
        const promesse = new Promise(function(myResolve, myReject) {
            $.ajax(request_data).done(function(){
                if (response.ajax !== 'ajax') {
                    myResolve(response);
                }else window.location.href = settings.initial_base_url + '/index.php/dashboard';

            }).fail(function(){
                myReject(response);
            });
        });

        return promesse;
    } 
}

function format_date(string_date){
    if(string_date){
        if(string_date.split(' ').length == 2){
            let date_parts1 = string_date.split(' '), date_parts2 = date_parts1[0].split('-');
            return date_parts2[2]+"/"+date_parts2[1]+"/"+date_parts2[0]+" "+date_parts1[1];
        }else{
            let date_parts = string_date.split('-');
            return date_parts[2]+"/"+date_parts[1]+"/"+date_parts[0];
        }
    } return '';
}

function reset_form(element_jq, additional_action){
    
    if(element_jq.get(0)){
        let element = element_jq.get(0),
    
        modal = element.nodeName === 'FORM' ? element.closest('.modal') : element;

        $(modal).on('hidden.bs.modal', function(){
            element.nodeName !== 'FORM' ? element_jq.find('form').get(0).reset() : element_jq.get(0).reset()
            element_jq.find('.form-group').removeClass('has-error');
            element_jq.find('.invalid-feedback').remove();

            if(additional_action) additional_action()
        })
    }
}

function create_hidden_input(name, value){
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = name;
    input.className = 'for_edition';
    input.value = value.includes('#') ? value.slice(1) : value;
    return input;
}

function set_edition_form(form_id, hidden_input, edition_title){
    let form = $('#' + form_id),
    modal = form.get(0).closest('.modal');
    form.prepend(hidden_input);
    form.addClass('edition');
    modal ? (function(){
        $(modal).find('#modal_title').html(edition_title)
        $(modal).modal('show')
    }()) : $('#action_title').html(edition_title);
    modal ? $(modal).addClass('edition') : '';
}

function unset_edition_form(form_id, add_title){
    let form = $('#' + form_id),
    modal = form.get(0).closest('.modal');
    $('.for_edition', form).remove();
    form.removeClass('edition');
    $(modal).find('#modal_title').html(add_title);
    $(modal).removeClass('edition');
}

function set_form_error_message(errors){
    let particulier = [
        'type_depense',
        'produit',
        'administrateur'
    ]
    $('.invalid-feedback').remove();
    for(field in errors){
        let field_element = !particulier.includes(field) ? $('#'+field) : $('#'+field).next();
        field_element.closest('.form-group').addClass('has-error');
        field_element.after("<span class='invalid-feedback' style='display: block'>"+ errors[field][0] +"</span>");
        field_element.on('keydown change', () => { 
            field_element.next().remove();
            field_element.closest('.form-group').removeClass('has-error');
         });
    }
}

function set_backend_error_message(errors){
    if(errors){
        let error_message = '';
        for(error of errors){	
            error != "" ? error_message += error+'<br/>' : '';
        }
        let alert = `<div id='error_block' class='alert alert-danger alert-dismissable p-0'>
                        <button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
                        <div id='error_container' class='p-2'>${ error_message }</div>
                    </div>`;
                    
        $(".alert_container").prepend(alert);;
    }
}

function setDualBoxData(data, input_id, data_name, value_name){
    $('#' + input_id).html(null);
    for(index in data){
        let option = new Option("option text", "value");
        $(option).val(data[index][value_name]);
        if(data[index]['selected'] != undefined) $(option).attr('selected', true);
        $(option).html(data[index][data_name]);
        $('#' + input_id).append(option);
    }
    $('#' + input_id).trigger('bootstrapDualListbox.refresh');
}

//Recuperation du statut de l'utilisateur selectionner
function get_statut_from_table(table, position){
    return $(table.cell('.selected', position).data()).hasClass('label-danger') ? 'Desactive' : 'Actif';
}


$( document ).ready(function(){

    $(".default-k").on("click", function(e){
        e.preventDefault();
        if($(this).hasClass("btn-default") && !$(this).attr('href')){
            notify_on_screen("Aucune ligne selectionné !!!");
        }else if($(this).attr('href')){
            window.location.replace($(this).attr('href'));
        }
    });
    
    $(".navbar-minimalize").trigger('click');
});


//Setting all date input to today's date

$('input[type="date"]').val(today_date_formated())



  

