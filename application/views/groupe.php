<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2><i class='fa fa-users'></i> Groupes d'utilisateurs</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= site_url(); ?>/Administration">Administration</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Groupes</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-4 custom-btn-top text-right">
        <a href='<?= site_url();?>/Administration' class='custom-btn btn btn-primary'>
            <i class='fa fa-caret-left'></i> Retour
        </a>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight" style='padding-top: 30px'>
    <div class="row justify-content-center">
        <div class="col-lg-12 alert_container">
            <div class="ibox">
                <div class="ibox-title" style='padding: 15px'>
                    <div class='row'>
                        <div class='col-3'>
                            <h4><i class='fa fa-list'></i> Liste des groupes</h4>
                        </div>
                        <div class='col-9 text-right'>
                            
                            <button class='custom-btn btn btn-primary' data-toggle="modal" data-target="#ajouter_groupe">
                                <i class='fa fa-plus'></i>
                                Ajouter
                            </button>
                            
                            <button id='modifier_groupe' class='custom-btn btn btn-default default-k'>
                                <i class='fa fa-edit'></i>
                                Modifier
                            </button>

                            <button id='statut_groupe' class='custom-btn btn btn-default default-k'>
                                <i class='fa fa-circle'></i>
                                Changer statut
                            </button>
                            
                            <button id='suppression_groupe' class='custom-btn btn btn-default default-k'>
                                <i class='fa fa-trash'></i> 
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id='tableGroupes' class="table table-bordered" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Statut</th>
                                    <th>Date de création</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="ajouter_groupe" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><span id='groupe_modal_title'><h2 id='modal_title'>Ajouter un groupe</h2></span></h4>
                <small class="font-bold">Veuillez remplir le formulaire et cliquez sur terminer pour enregistrer</small>
            </div>
            <div class="modal-body" style='padding: 0'>
                <?php echo form_open(base_url()."index.php/Groupe/ajout",array('id'=>'form_ajout_groupe','class'=>'m-t','role'=>'form'));?>
                    <div class="tab-content">
                        <div id="step1" class="p-m tab-pane active">

                            <div class="row">
                            <div class="col-lg-12">
                                    <div class="form-group position-relative">
                                        <label>Nom</label>                                    
                                        <?php 
                                        $data = array(
                                            "id"            => "nom",   
                                            'name'          => 'nom',
                                            'type'          => 'text',
                                            'class'         => 'form-control'.((form_error('nom') != "")?" is-invalid":""),
                                            'placeholder'         => 'Nom du groupe',
                                            'autocomplete'      =>'off',
                                        );
                                        echo form_input($data); ?>
                                    </div>	
                                </div>
                                <div class="col-lg-12">
                                    <div class="tabs-container">
                                        <ul class="nav nav-tabs" id='groupe_form_tabs'>
                                            <li><a class="nav-link active" data-toggle="tab" href="#tab-user"> <i class="fa fa-users"></i> Utilisateurs</a></li>
                                            <li><a class="nav-link" data-toggle="tab" href="#tab-privilege"><i class="fa fa-cog"></i> Privilèges</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="tab-user" class="tab-pane fade show active">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="ibox">
                                                                <div class="ibox-content">
                                                                    <form id="form" action="#" class="wizard-big">
                                                                    <select id='users_groupe' name='users[]' class="form-control" multiple></select>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div id="tab-privilege" class="tab-pane fade">
                                                <div id='priv' class="panel-body">
                                                    <div id='actions' class='row mt-1'>
                                                        <div class="col-12 text-left">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                <h5 style='text-decoration: underline' class="text-center">Droit d'accès</h5><hr/>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <span class="priv"> <input id='tableau_de_bord' type="checkbox" name='priv[]' value='tableau_de_bord'> Tableau de bord</span>  
                                                                            <span class="priv"> <input id='recettes' type="checkbox" name='priv[]' value='recettes'> Recettes</span>  
                                                                            <span class="priv"> <input id='b_vente' type="checkbox" name='priv[]' value='b_vente'> Bloc ventes</span>
                                                                            <span class="priv"> <input id='b_recette' type="checkbox" name='priv[]' value='b_recette'> Bloc recettes</span>
                                                                            <span class="priv"> <input id='depenses' type="checkbox" name='priv[]' value='depenses'> Dépenses</span>
                                                                            <span class="priv"> <input id='b_depense' type="checkbox" name='priv[]' value='b_depense'> Bloc dépense</span>
                                                                            <span class="priv"> <input id='b_select_depense' type="checkbox" name='priv[]' value='b_select_depense'> Bloc selection des dépenses</span>
                                                                            <span class="priv"> <input id='b_depense_valide' type="checkbox" name='priv[]' value='b_depense_valide'> Bloc dépenses validées</span>
                                                                            <span class="priv"> <input id='b_depense_effectue' type="checkbox" name='priv[]' value='b_depense_effectue'> Bloc dépenses effectuées</span>
                                                                            <span class="priv"> <input id='profil' type="checkbox" name='priv[]' value='profil'> Profil</span>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            
                                                                        <span class="priv"> <input id='administration' type="checkbox" name='priv[]' value='administration'> Administration</span>
                                                                            <span class="priv"> <input id='admin_groupe' type="checkbox" name='priv[]' value='admin_groupe'> Admin | Groupe</span>
                                                                            <span class="priv"> <input id='admin_utilisateur' type="checkbox" name='priv[]' value='admin_utilisateur'> Admin | Utilisateur</span>
                                                                            <span class="priv"> <input id='admin_structure' type="checkbox" name='priv[]' value='admin_structure'> Admin | Structure</span>
                                                                            <span class="priv"> <input id='admin_produit' type="checkbox" name='priv[]' value='admin_produit'> Admin | Produits</span>
                                                                            <span class="priv"> <input id='admin_type_depense' type="checkbox" name='priv[]' value='admin_type_depense'> Admin | Types de dépenses</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 seperate-left" >
                                                                    <h5 style='text-decoration: underline' class="text-center">Privilèges</h5><hr/>
                                                                    <div class='row'>
                                                                        <div class='col-6'>
                                                                            <div class="text-left">
                                                                                <input id='CTV' type="checkbox" name='priv[]' value='CTV'> Consulter toutes les ventes
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <input id='AV' type="checkbox" name='priv[]' value='AV'> Ajouter une vente
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <input id='MV' type="checkbox" name='priv[]' value='MV'> Modifier une vente
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <input id='SV' type="checkbox" name='priv[]' value='SV'> Supprimer une vente
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <input id='GVR' type="checkbox" name='priv[]' value='GVR'> Grouper les ventes en recette
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <input id='DVR' type="checkbox" name='priv[]' value='DVR'> Dissocier les ventes d'une recette
                                                                            </div>                                                                            
                                                                        </div>
                                                                        <div class='col-6'>
                                                                            <div class="text-left">
                                                                                <input id='CTD' type="checkbox" name='priv[]' value='CTD'> Consulter toutes les dépenses
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <input id='AD' type="checkbox" name='priv[]' value='AD'> Ajouter une dépense
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <input id='MD' type="checkbox" name='priv[]' value='MD'> Modifier une dépense
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <input id='SD' type="checkbox" name='priv[]' value='SD'> Supprimer une dépense
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <input id='VD' type="checkbox" name='priv[]' value='VD'> Validé une dépense
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <input id='ID' type="checkbox" name='priv[]' value='ID'> Invalidé une dépense
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <input id='GDE' type="checkbox" name='priv[]' value='GDE'> Grouper en dépenses effectuées
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <input id='DDE' type="checkbox" name='priv[]' value='DDE'> Dissocier les dépenses effectuées
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='tab-projets' class="tab-pane">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="ibox">
                                                                <div class="ibox-content">
                                                                    <select id='projet_groupe_priv' name='projet[]' class="form-control" multiple></select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='tab-activites' class="tab-pane">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="ibox">
                                                                <div class="ibox-content">
                                                                    <select id='activite_groupe_priv' name='activite[]' class="form-control" multiple></select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='tab-taches' class="tab-pane">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="ibox">
                                                                <div class="ibox-content">
                                                                    <select id='tache_groupe_priv' name='tache[]' class="form-control" multiple></select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>               
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Annuler</button>
                <button id='terminer_ajout_groupe' form='form_ajout_groupe' type="submit" class="btn btn-primary">Terminer</button>
            </div>
        </div>
    </div>
</div>

<script>
    let page_flag = 'admin_groupes';
</script>