
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2><i class='fa fa-user'></i> Utilisateurs</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
               <a href="<?= site_url(); ?>/Administration"> Administration</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Utilisateurs</strong>
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
                            <h4><i class='fa fa-list'></i> Liste des utilisateurs</h4>
                        </div>
                        <div class='col-9 text-right'>
                            
                            <button class='custom-btn btn btn-primary' data-toggle="modal" data-target="#ajouter_user">
                                <i class='fa fa-plus'></i>
                                Ajouter
                            </button>
                            
                            <button id='modifier_user' class='custom-btn btn btn-default default-k'>
                                <i class='fa fa-edit'></i>
                                Modifier
                            </button>
                            
                            <button id='modifier_groupeUser' class='custom-btn btn btn-default default-k'>
                                <i class='fa fa-users'></i>
                                Groupe
                            </button>
                            
                            <button id='mdp_user' class='custom-btn btn btn-default default-k'>
                                <i class='fa fa-dot-circle-o'></i> 
                                Changer mot de passe
                            </button>
                            
                            <button id='statut_user' class='custom-btn btn btn-default default-k'>
                                <i class='fa fa-circle'></i> 
                                Changer statut
                            </button>
                            
                            <button id='mail_user' class='custom-btn btn btn-default default-k'>
                                <i class='fa fa-paper-plane'></i> 
                                Renvoyer mail d'activation
                            </button>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id='tableUsers' class="table table-bordered" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom et prénoms</th>
                                    <th>E-mail</th>
                                    <th>Structure</th>  
                                    <th>Téléphone</th>  
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

<div class="modal inmodal fade" id="ajouter_user" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><span id='users_modal_title'><h2 id='modal_title'>Ajouter un utilisateur</h2></span></h4>
                <small class="font-bold">Veuillez remplir le formulaire et cliquez sur terminer pour enregistrer</small>
            </div>
            <div class="modal-body">
                <?php echo form_open(base_url()."index.php/Users/ajout",array('id'=>'form_ajout_user','class'=>'m-t','role'=>'form'));?>
                    <div class="tab-content">
                        <div class="p-0">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group position-relative">
                                            <label>Nom</label>                                    
                                            <?php 
                                            $data = array(
                                                    "id"            => "nom_prenoms",   
                                                    'name'          => 'nom_prenoms',
                                                    'type'          => 'text',
                                                    'class'         => 'form-control'.((form_error('nom') != "")?" is-invalid":""),
                                                    'placeholder'         => 'Nom et prénoms',
                                                    'autocomplete'      =>'off',
                                            );
                                            echo form_input($data); ?>
                                            </div>	
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group position-relative">
                                            <label>E-mail</label>                                    
                                            <?php 
                                            $data = array(
                                                    "id"            => "email",   
                                                    'name'          => 'email',
                                                    'type'          => 'text',
                                                    'class'         => 'form-control'.((form_error('email') != "")?" is-invalid":""),
                                                    'placeholder'   => 'E-mail',
                                                    'autocomplete'      =>'off',
                                            );
                                            echo form_input($data); ?>
                                            </div>	
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group position-relative">
                                                <label>Structure</label>
                                                <select id='structure' name="structure" class="form-control m-b"></select>
                                            </div>	
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group position-relative">
                                            <label>Téléphone</label>                                    
                                            <?php 
                                            $data = array(
                                                    "id"            => "tel",   
                                                    'name'          => 'tel',
                                                    'type'          => 'text',
                                                    'class'         => 'form-control'.((form_error('titre') != "")?" is-invalid":""),
                                                    'placeholder'         => 'Téléphone',
                                                    'autocomplete'      =>'off',
                                            );
                                            echo form_input($data); ?>
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
                <button id='terminer_ajout_user' form='form_ajout_user' type="submit" class="btn btn-primary">Terminer</button>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal fade" id="mdp_form_user" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><span id='users_mdp_modal_title'><h2>Changer le mot de passe de l'utilisateur</h2></span></h4>
                <small class="font-bold">Veuillez remplir le formulaire et cliquez sur terminer pour enregistrer</small>
            </div>
            <div class="modal-body">
                <?php echo form_open(base_url()."index.php/Users/mdp_user",array('id'=>'form_mdp_user','class'=>'m-t','role'=>'form'));?>
                    <div class="tab-content">
                        <div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">                                        
                                        <div class="col-lg-12">
                                            <div class="form-group position-relative">
                                            <label>Mot de passe</label>                                    
                                            <?php 
                                            $data = array(
                                                    "id"            => "pass",   
                                                    'name'          => 'pass',
                                                    'type'          => 'password',
                                                    'class'         => 'form-control mot_de_passe'.((form_error('pass') != "")?" is-invalid":""),
                                                    'placeholder'   => 'Mot de passe',
                                                    'autocomplete'      =>'off',
                                            );
                                            echo form_input($data); ?>
                                            </div>	
                                        </div> 

                                        <div class="col-lg-12">
                                            <div class="form-group position-relative">
                                            <label>Confirmez le mot de passe</label>                                    
                                            <?php 
                                            $data = array(
                                                    "id"            => "confirme",   
                                                    'name'          => 'confirme',
                                                    'type'          => 'password',
                                                    'class'         => 'form-control'.((form_error('confirme') != "")?" is-invalid":""),
                                                    'placeholder'   => 'Confirmez',
                                                    'autocomplete'      =>'off',
                                            );
                                            echo form_input($data); ?>
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
                <button id='terminer_mdp_user' form='form_mdp_user' type="submit" class="btn btn-primary">Terminer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="groupe_u" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><span id='groupe_modal_title_non'><h2>Groupes de l'utilisateur</h2></span></h4>
                <small class="font-bold">Veuillez remplir le formulaire et cliquez sur terminer pour enregistrer</small>
            </div>
            <div class="modal-body" style='padding: 0'>
                <?php echo form_open(base_url()."index.php/Users/maj_user_groupe",array('id'=>'form_ajout_groupe_user','class'=>'m-t','role'=>'form'));?>
                    <div class="tab-content">
                        <div id="step1" class="p-m tab-pane active">
                            <div class="row">
                                <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <form id="form" action="#" class="wizard-big">
                                            <select id='groupe_User' name='groupe[]' class="form-control" multiple></select>
                                        </form>
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
                <button id='terminer_ajout_groupe' form='form_ajout_groupe_user' type="submit" class="btn btn-primary">Terminer</button>
            </div>
        </div>
    </div>
</div>

 