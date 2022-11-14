<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-8">
        <h2><i class='fa fa-money'></i> Recettes</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="<?php echo base_url() ?>index.php/Dashboard"><strong>Recettes</strong></a>
            </li>
        </ol>
    </div>
<div class="col-lg-4 custom-btn-top text-right">
    <button data-toggle="dropdown" class="btn btn-primary  btn-sm ml-2 dropdown-toggle" aria-expanded="true"><i class="fa fa-ellipsis-v"></i> Afficher</button>
    <ul class="dropdown-menu top-dd" x-placement="bottom-start">
        <li><button id='tous_vente' class="dropdown-item btn btn-sm btn-default m-2"><i class="fa fa-circle"></i> Tous</button></li>
        <li><button id='b_vente' class="dropdown-item btn btn-sm btn-default m-2"><i class="fa fa-check"></i> Block ventes</button></li>
        <li><button id='b_recette' class="dropdown-item btn btn-sm btn-default m-2"><i class="fa fa-check"></i> Block recette</button></li>
    </ul>
</div>
</div>
<div class="wrapper animated fadeInUp mb-5">

    <div class="row mt-4">
        <div class="col-md-12 alert_container">
            <div class="row justify-content-center">

            <?php if(allowed('b_vente')): ?>
                <div id='vente_eff' class="vente_bloc_size col-lg-4">
                    <div class="ibox">
                        <div class='ibox-title'>
                            <h4><i class="fa fa fa-check"></i> <span id="total_vente">0</span> ventes enrégistrés</h4>
                            <h4><i class="fa fa-money"></i> <span id="total_vente_montant"></span></h4>   
                            <div class="ibox-tools">
                                <?php if(allowed('GVR')): ?>
                                    <button data-toggle="dropdown" class="btn btn-primary  btn-sm ml-2 dropdown-toggle" aria-expanded="true"><i class="fa fa-ellipsis-v"></i> Actions</button>
                                    <ul class="dropdown-menu w-100 top-dd" x-placement="bottom-start">
                                        <li><a id='btn_select_all_vente' class="dropdown-item" href="#"><i class='fa fa-check'></i> <span id='btn_select_all_text'>Tous selectionner</span></a></li>
                                        <li><a id='btn_group_all_vente' class="dropdown-item" href="#"><i class='fa fa-lock'></i> Grouper en recette</a></li>
                                    </ul>
                                <?php endif; ?>                         
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="input-group">
                                <input id='search_vente' type="text" class="form-control form-control-sm">
                                <div class="mx-1">
                                <?php if(allowed('AV')): ?>
                                    <button class='btn-sm btn btn-primary btn-sm' data-toggle="modal" data-target="#ventes_modal">
                                        <i class='fa fa-plus'></i>
                                        Ajouter
                                    </button>
                                    <?php endif ?>
                                </div>
                            </div>
                            <ul id='vente_container' class="phase_block list-group elements-list agile-list"></ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <?php if(allowed('b_recette')): ?>
                <div id='recette_eff' class="recette_bloc_size col-lg-4">
                    <div class="ibox">
                        <div class='ibox-title'>
                            <h4><i class="fa fa fa-check"></i> <span id="total_recette">0</span> Recettes journalières</h4>
                            <h4><i class="fa fa-money"></i> <span id="total_recette_montant"></span></h4>
                        </div>
                        <div class="ibox-content">
                            <ul id='recette_container' class="phase_block list-group elements-list agile-list"></ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            </div>     
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="ventes_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style='border-radius: 5px'>
            <div class='ibox mb-0'>
                <div class='ibox-title'>
                    <h3 id="modal_title">Ajouter une vente</h3>
                </div>
                <div class="ibox-content">
                    <form id='form_ajout_vente' action='<?= base_url()."index.php/ventes/ajout" ?>' method="POST">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Date de la vente</label>
                            <div class="col-sm-8"><input id='date_vente' name='date_vente' type="date" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Produit</label>
                            <div class="col-sm-8">
                                <select id='produit' name="produit" class="form-control m-b"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Prix unitaire</label>
                            <div class="col-sm-8"><input id='prix_unitaire' name='prix_unitaire' class="form-control" autocomplete='off'></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Quantité</label>
                            <div class="col-sm-8"><input id='qte' name='qte' class="form-control" autocomplete='off'></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Mode de paiement</label>
                            <div class="col-sm-8">
                                <div><label> <input type="radio" value="Espèce" name="mode_paiement" checked> Espèce</label></div>
                                <div id='mode_paiement'><label> <input type="radio" value="momo" name="mode_paiement"> Mobile Money</label></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Commentaire</label>
                            <div class="col-sm-8"><textarea id='commentaire' name='commentaire' class="form-control"></textarea></div>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-white btn-sm" type="button" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-primary btn-sm" form='form_ajout_vente' type="submit">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</div>