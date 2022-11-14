

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2><i class='fa fa-bank'></i> Structure</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
               <a href="<?= site_url(); ?>/Administration"> Administration</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Structure</strong>
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
                            <h4><i class='fa fa-list'></i> Liste des structure</h4>
                        </div>
                        <div class='col-9 text-right'>
                            
                            <button class='custom-btn btn btn-primary' data-toggle="modal" data-target="#ajouter_structure">
                                <i class='fa fa-plus'></i>
                                Ajouter
                            </button>
                            
                            <button id='modifier_structure' class='custom-btn btn btn-default default-k'>
                                <i class='fa fa-edit'></i>
                                Modifier
                            </button>
                            
                            <button id='statut_structure' class='custom-btn btn btn-default default-k'>
                                <i class='fa fa-circle'></i> 
                                Changer statut
                            </button>

                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id='tableStructures' class="table table-bordered" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom </th>
                                    <th>Administrateur</th> 
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

<div class="modal inmodal fade" id="ajouter_structure" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4><span id='modal_title'><h2 class='modal_title'>Ajouter une structure</h2></span></h4>
                <small class="font-bold">Veuillez remplir le formulaire et cliquez sur terminer pour enregistrer</small>
            </div>
            <div class="modal-body">
                <?php echo form_open(base_url()."index.php/Structures/ajout_structure", array('id'=>'form_ajout_structure','class'=>'m-t','role'=>'form')); ?>
                    <div class="tab-content">
                        <div class="p-0">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group position-relative">
                                            <label>Nom de la structure </label>                                    
                                            <?php 
                                            $data = array(
                                                    "id"            => "nom",   
                                                    'name'          => 'nom',
                                                    'type'          => 'text',
                                                    'class'         => 'form-control'.((form_error('nom') != "")?" is-invalid":""),
                                                    'placeholder'         => 'Structure',
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
                                                <label>Administrateur</label>
                                                <select id='administrateur' name="administrateur" class="form-control m-b"></select>
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
                <button id='terminer_ajout_user' form='form_ajout_structure' type="submit" class="btn btn-primary">Terminer</button>
            </div>
        </div>
    </div>
</div>
