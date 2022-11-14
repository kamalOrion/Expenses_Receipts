<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2><i class='fa fa-tags'></i> Types de dépenses</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= site_url(); ?>/Administration">Administration</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Types de dépenses</strong>
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
                            <h4><i class='fa fa-list'></i> Liste des types de dépenses</h4>
                        </div>
                        <div class='col-9 text-right'>
                            
                            <button class='custom-btn btn btn-primary' data-toggle="modal" data-target="#modal_ajouter_type_depense">
                                <i class='fa fa-plus'></i>
                                Ajouter
                            </button>
                            
                            <button id='modifier_type_depense' class='custom-btn btn btn-default default-k'>
                                <i class='fa fa-edit'></i>
                                Modifier
                            </button>
                            
                            <button id='suppression_type_depense' class='custom-btn btn btn-default default-k'>
                                <i class='fa fa-trash'></i> 
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id='tableType_depenses' class="table table-bordered" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Libelle</th>
                                    <th>Description</th>
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

<div class="modal inmodal fade" id="modal_ajouter_type_depense" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><span id='type_depense_modal_title'><h2 id='modal_title'>Ajouter un type depense</h2></span></h4>
                <small class="font-bold">Veuillez remplir le formulaire et cliquez sur terminer pour enregistrer</small>
            </div>
            <div class="modal-body" style='padding: 0'>
                <?php echo form_open(base_url()."index.php/basic_data/ajout_type_depense",array('id'=>'form_ajout_type_depense','class'=>'m-t','role'=>'form'));?>
                    <div class="tab-content">
                        <div id="step1" class="p-m tab-pane active">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group position-relative">
                                        <label>Nom</label>                                    
                                        <?php 
                                        $data = array(
                                            "id"            => "libelle",   
                                            'name'          => 'libelle',
                                            'type'          => 'text',
                                            'class'         => 'form-control'.((form_error('nom') != "")?" is-invalid":""),
                                            'placeholder'         => 'Nom du type',
                                            'autocomplete'      =>'off',
                                        );
                                        echo form_input($data); ?>
                                    </div>	
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group position-relative">
                                        <label>Description</label>
                                        <textarea id='description' name='description' class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>               
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Annuler</button>
                <button id='terminer_ajout_type_depense' form='form_ajout_type_depense' type="submit" class="btn btn-primary">Terminer</button>
            </div>
        </div>
    </div>
</div>