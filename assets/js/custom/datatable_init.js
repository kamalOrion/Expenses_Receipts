//Datatable produit
var tableDashboard = $('#tableDashboard').DataTable({
    pageLength: 10,
    order: [[ 0, "desc" ]],
    responsive: true,
    dom: '<"html5buttons"B>lTfgitp',
    buttons: [
        {extend: 'copy'},
        {extend: 'csv', title: 'Liste des opérations'},
        {extend: 'excel', title: 'Liste des opérations'},
        {extend: 'pdf', title: 'Liste des opérations'},
        {extend: 'colvis',text: 'Visiblité des colonnes'},                   
    ],
    language: {
        "sProcessing":     "Traitement en cours...",
            "sSearch":         "Recherche",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments &nbsp;&nbsp;&nbsp;",
            "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur  _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {						
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            }
    },
    "processing": true,
    "serverSide": true,
    ajax:{  
        url: general_data.site_url+'/Dashboard/tableDashboardAjax',  
        type:"POST",
        dataSrc:function(j){
            let data_array = [];
            for(const item of j.data){
                data_array.push([
                    format_date(item.date),
                    item.structure,
                    item.type,
                    item.intitule,
                    item.montant,
                    item.auteur,
                    item.mode_paiement                        
                ]);
            }
            return data_array;
        } 
    }
});

//Datatable Users
var tableUsers = $('#tableUsers').DataTable({
    pageLength: 10,
    order: [[ 0, "desc" ]],
    responsive: true,
    dom: '<"html5buttons"B>lTfgitp',
    buttons: [
        {extend: 'copy'},
        {extend: 'csv', title: 'Liste des utilisateurs'},
        {extend: 'excel', title: 'Liste des utilisateurs'},
        {extend: 'pdf', title: 'Liste des utilisateurs'},
        {extend: 'colvis',text: 'Visiblité des colonnes'},                  
    ],
    language: {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "Recherche",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments &nbsp;&nbsp;&nbsp;",
        "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur  _TOTAL_ &eacute;l&eacute;ments",
        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {						
            "sFirst":      "Premier",
            "sPrevious":   "Pr&eacute;c&eacute;dent",
            "sNext":       "Suivant",
            "sLast":       "Dernier"
        },
        "oAria": {
            "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        }
    },
    "processing": true,
    "serverSide": true,
    ajax:{  
        url: general_data.site_url+'/Users/tableUsersAjax',  
        type:"POST",
        dataSrc:function(j){
            let data_array = [];
            for(const item of j.data){
                data_array.push([
                    '#'+item.user_id,
                    item.nom_prenoms,
                    item.email,
                    item.structure,
                    item.tel,
                    (item.statut == 'Actif') ? "<span class='label label-primary'>Actif</span>" : "<span class='label label-danger'>Désactivé</span>",
                    format_date(item.date_enreg)
                ]);
            }
            return data_array;
        } 
    }
});

$('#tableUsers tbody').on('click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {

        $(this).removeClass('selected');

        if($("#modifier_user").hasClass('btn-primary') ) {
        $("#modifier_user").removeClass("btn-primary");	
        $("#modifier_user").addClass("btn-default");}

        if($("#modifier_groupeUser").hasClass('btn-primary') ) {
        $("#modifier_groupeUser").removeClass("btn-primary");	
        $("#modifier_groupeUser").addClass("btn-default");}

        if($("#statut_user").hasClass('btn-primary') ) {
        $("#statut_user").removeClass("btn-primary");	
        $("#statut_user").addClass("btn-default");}
        
        if($("#mdp_user").hasClass('btn-primary') ) {
        $("#mdp_user").removeClass("btn-primary");	
        $("#mdp_user").addClass("btn-default");}

        if($("#mail_user").hasClass('btn-primary') ) {
        $("#mail_user").removeClass("btn-primary");	
        $("#mail_user").addClass("btn-default");}
    }
    else {

        $('tr.selected').removeClass('selected');

        $(this).addClass('selected');

        if ($("#modifier_user").hasClass('btn-default') ) {
        $("#modifier_user").removeClass("btn-default");
        $("#modifier_user").addClass("btn-primary");}

        if ($("#modifier_groupeUser").hasClass('btn-default') ) {
        $("#modifier_groupeUser").removeClass("btn-default");
        $("#modifier_groupeUser").addClass("btn-primary");}

        if ($("#statut_user").hasClass('btn-default') ) {
        $("#statut_user").removeClass("btn-default");
        $("#statut_user").addClass("btn-primary");}

        if ($("#mdp_user").hasClass('btn-default') ) {
        $("#mdp_user").removeClass("btn-default");
        $("#mdp_user").addClass("btn-primary");}

        if ($("#mail_user").hasClass('btn-default') ) {
        $("#mail_user").removeClass("btn-default");
        $("#mail_user").addClass("btn-primary");}
        
        general_data.table_item_selected = tableUsers.cell('.selected', 0).data();
    }
});


//Datatable Groupes
var tableGroupes = $('#tableGroupes').DataTable({
    pageLength: 10,
    order: [[ 0, "desc" ]],
    responsive: true,
    dom: '<"html5buttons"B>lTfgitp',
    buttons: [
        {extend: 'copy'},
        {extend: 'csv', title: 'Liste des groupes'},
        {extend: 'excel', title: 'Liste des groupes'},
        {extend: 'pdf', title: 'Liste des groupes'},
        {extend: 'colvis',text: 'Visiblité des colonnes'},                   
    ],
    language: {
        "sProcessing":     "Traitement en cours...",
            "sSearch":         "Recherche",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments &nbsp;&nbsp;&nbsp;",
            "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur  _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {						
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            }
    },
    "processing": true,
    "serverSide": true,
    ajax:{  
        url: general_data.site_url+'/Groupe/tableGroupesAjax',  
        type:"POST",
        dataSrc:function(j){
            let data_array = [];
            for(const item of j.data){
                data_array.push([
                        '#'+item.groupe_id,
                        item.nom,
                        (item.statut == 1) ? "<span class='label label-primary'>Actif</span>" : "<span class='label label-danger'>Désactivé</span>",
                        format_date(item.date_enreg)
                ]);
            }
            return data_array;
        } 
    }
});

$('#tableGroupes tbody').on('click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {

        $(this).removeClass('selected');

        if($("#modifier_groupe").hasClass('btn-primary') ) {
        $("#modifier_groupe").removeClass("btn-primary");	
        $("#modifier_groupe").addClass("btn-default");}

        if($("#statut_groupe").hasClass('btn-primary') ) {
        $("#statut_groupe").removeClass("btn-primary");	
        $("#statut_groupe").addClass("btn-default");}

        if($("#suppression_groupe").hasClass('btn-primary') ) {
        $("#suppression_groupe").removeClass("btn-primary");	
        $("#suppression_groupe").addClass("btn-default");}
        
    } else {

        $('tr.selected').removeClass('selected');

        $(this).addClass('selected');

        if ($("#modifier_groupe").hasClass('btn-default') ) {
        $("#modifier_groupe").removeClass("btn-default");
        $("#modifier_groupe").addClass("btn-primary");}

        if ($("#statut_groupe").hasClass('btn-default') ) {
        $("#statut_groupe").removeClass("btn-default");
        $("#statut_groupe").addClass("btn-primary");}

        if($("#suppression_groupe").hasClass('btn-default') ) {
        $("#suppression_groupe").removeClass("btn-default");
        $("#suppression_groupe").addClass("btn-primary");}

        general_data.table_item_selected = tableGroupes.cell('.selected', 0).data();
    }
});


//Datatable Groupes
var tableType_depenses = $('#tableType_depenses').DataTable({
    pageLength: 10,
    order: [[ 0, "desc" ]],
    responsive: true,
    dom: '<"html5buttons"B>lTfgitp',
    buttons: [
        {extend: 'copy'},
        {extend: 'csv', title: 'Liste des types de dépenses'},
        {extend: 'excel', title: 'Liste des types de dépenses'},
        {extend: 'pdf', title: 'Liste des types de dépenses'},
        {extend: 'colvis',text: 'Visiblité des colonnes'},                   
    ],
    language: {
        "sProcessing":     "Traitement en cours...",
            "sSearch":         "Recherche",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments &nbsp;&nbsp;&nbsp;",
            "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur  _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {						
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            }
    },
    "processing": true,
    "serverSide": true,
    ajax:{  
        url: general_data.site_url+'/basic_data/tableType_depensesAjax',  
        type:"POST",
        dataSrc:function(j){
            let data_array = [];
            for(const item of j.data){
                data_array.push([
                        '#'+item.type_depense_id,
                        item.libelle,
                        item.description,
                        format_date(item.date_enreg)
                ]);
            }
            return data_array;
        } 
    }
});

$('#tableType_depenses tbody').on('click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {

        $(this).removeClass('selected');

        if($("#modifier_type_depense").hasClass('btn-primary') ) {
        $("#modifier_type_depense").removeClass("btn-primary");	
        $("#modifier_type_depense").addClass("btn-default");}

        if($("#suppression_type_depense").hasClass('btn-primary') ) {
        $("#suppression_type_depense").removeClass("btn-primary");	
        $("#suppression_type_depense").addClass("btn-default");}
        
    } else {

        $('tr.selected').removeClass('selected');

        $(this).addClass('selected');

        if ($("#modifier_type_depense").hasClass('btn-default') ) {
        $("#modifier_type_depense").removeClass("btn-default");
        $("#modifier_type_depense").addClass("btn-primary");}

        if($("#suppression_type_depense").hasClass('btn-default') ) {
        $("#suppression_type_depense").removeClass("btn-default");
        $("#suppression_type_depense").addClass("btn-primary");}

        general_data.table_item_selected = tableType_depenses.cell('.selected', 0).data();
    }
});

//Datatable produit
var tableProduits = $('#tableProduits').DataTable({
    pageLength: 10,
    order: [[ 0, "desc" ]],
    responsive: true,
    dom: '<"html5buttons"B>lTfgitp',
    buttons: [
        {extend: 'copy'},
        {extend: 'csv', title: 'Liste des groupes'},
        {extend: 'excel', title: 'Liste des groupes'},
        {extend: 'pdf', title: 'Liste des groupes'},
        {extend: 'colvis',text: 'Visiblité des colonnes'},                   
    ],
    language: {
        "sProcessing":     "Traitement en cours...",
            "sSearch":         "Recherche",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments &nbsp;&nbsp;&nbsp;",
            "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur  _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {						
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            }
    },
    "processing": true,
    "serverSide": true,
    ajax:{  
        url: general_data.site_url+'/basic_data/tableProduitsAjax',  
        type:"POST",
        dataSrc:function(j){
            let data_array = [];
            for(const item of j.data){
                data_array.push([
                        '#'+item.produit_id,
                        item.libelle,
                        // item.prix_unitaire + ' FCFA',
                        format_date(item.date_enreg)
                ]);
            }
            return data_array;
        } 
    }
});

$('#tableProduits tbody').on('click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {

        $(this).removeClass('selected');

        if($("#modifier_produit").hasClass('btn-primary') ) {
        $("#modifier_produit").removeClass("btn-primary");	
        $("#modifier_produit").addClass("btn-default");}

        if($("#suppression_produit").hasClass('btn-primary') ) {
        $("#suppression_produit").removeClass("btn-primary");	
        $("#suppression_produit").addClass("btn-default");}
        
    } else {

        $('tr.selected').removeClass('selected');

        $(this).addClass('selected');

        if ($("#modifier_produit").hasClass('btn-default') ) {
        $("#modifier_produit").removeClass("btn-default");
        $("#modifier_produit").addClass("btn-primary");}

        if($("#suppression_produit").hasClass('btn-default') ) {
        $("#suppression_produit").removeClass("btn-default");
        $("#suppression_produit").addClass("btn-primary");}

        general_data.table_item_selected = tableProduits.cell('.selected', 0).data();
    }
});


//Datatable produit
var tableStructures = $('#tableStructures').DataTable({
    pageLength: 10,
    order: [[ 0, "desc" ]],
    responsive: true,
    dom: '<"html5buttons"B>lTfgitp',
    buttons: [
        {extend: 'copy'},
        {extend: 'csv', title: 'Liste des groupes'},
        {extend: 'excel', title: 'Liste des groupes'},
        {extend: 'pdf', title: 'Liste des groupes'},
        {extend: 'colvis',text: 'Visiblité des colonnes'},                   
    ],
    language: {
        "sProcessing":     "Traitement en cours...",
            "sSearch":         "Recherche",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments &nbsp;&nbsp;&nbsp;",
            "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur  _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {						
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            }
    },
    "processing": true,
    "serverSide": true,
    ajax:{  
        url: general_data.site_url+'/Structures/tableStructuresAjax',  
        type:"POST",
        dataSrc:function(j){
            let data_array = [];
            for(const item of j.data){
                data_array.push([
                        '#'+item.structure_id,
                        item.nom,
                        item.administrateur,
                        (item.statut == 1) ? "<span class='label label-primary'>Actif</span>" : "<span class='label label-danger'>Désactivé</span>",
                        format_date(item.date_enreg)
                ]);
            }
            return data_array;
        } 
    }
});

$('#tableStructures tbody').on('click', 'tr', function () {

    if ( $(this).hasClass('selected') ) {

        $(this).removeClass('selected');

        if($("#modifier_structure").hasClass('btn-primary') ) {
        $("#modifier_structure").removeClass("btn-primary");	
        $("#modifier_structure").addClass("btn-default");}

        if($("#statut_structure").hasClass('btn-primary') ) {
        $("#statut_structure").removeClass("btn-primary");	
        $("#statut_structure").addClass("btn-default");}
        
    } else {

        $('tr.selected').removeClass('selected');

        $(this).addClass('selected');

        if ($("#modifier_structure").hasClass('btn-default') ) {
        $("#modifier_structure").removeClass("btn-default");
        $("#modifier_structure").addClass("btn-primary");}

        if($("#statut_structure").hasClass('btn-default') ) {
        $("#statut_structure").removeClass("btn-default");
        $("#statut_structure").addClass("btn-primary");}

        general_data.table_item_selected = tableStructures.cell('.selected', 0).data();
    }
});




