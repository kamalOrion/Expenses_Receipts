<div id='dep_demnade' class="depense_bloc_size col-lg">
    <div class="ibox">
        <div class='ibox-title'>
            <h4><i class="fa fa fa-credit-card"></i> <span id="total_depense">0</span> dépenses demandées </h4>
            <h4><i class="fa fa-money"></i> <span id="total_depense_montant"></span></h4>
        </div>
        <div class="ibox-content">
            <div class="m-b-sm">
                <div class="input-group">
                    <input id='search_depense' type="text" class="form-control form-control-sm">
                    <div class="mx-1">
                    <?php if(allowed('AD')): ?>
                        <button class='btn-sm btn btn-primary btn-sm' data-toggle="modal" data-target="#depenses_modal">
                            <i class='fa fa-plus'></i>
                            Ajouter
                        </button>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <ul id='depense_container' class="phase_block list-group elements-list agile-list"></ul>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="depenses_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style='border-radius: 5px'>
            <div class='ibox mb-0'>
                <div class='ibox-title'>
                    <h3 id="modal_title">Ajouter une dépense</h3>
                </div>
                <div class="ibox-content">
                    <form id='form_ajout_depense' action='<?= base_url()."index.php/depenses/ajout" ?>' method="POST">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Date échéance</label>    
                            <div class="col-sm-8"><input id='echeance' name='echeance' type="date" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Types de dépenses</label>
                            <div class="col-sm-8">
                                <select id='type_depense' name="type_depense" class="form-control m-b"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Prix unitaire</label>
                            <div class="col-sm-8"><input id='prix_unitaire' name='prix_unitaire' class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Quantité</label>
                            <div class="col-sm-8"><input id='qte' name='qte' class="form-control"></div>
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
                    <button class="btn btn-primary btn-sm" form='form_ajout_depense' type="submit">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</div>



