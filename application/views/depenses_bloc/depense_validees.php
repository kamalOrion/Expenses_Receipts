<div id='dep_valide' class="depense_bloc_size col-lg">
    <div class="ibox">
        <div class='ibox-title'>
            <h4><i class="fa fa-check"></i> <span id="total_depense_valide">0</span> dépenses validées</h4>
            <h4><i class="fa fa-money"></i> <span id="total_depense_valide_montant"></span></h4>
            <div class="ibox-tools">
            <?php if(allowed('GDE')): ?>
                <button id='effectue_depense' class='btn btn-primary btn-sm'><i class='fa fa-shopping-cart'></i> Effectué</button>
            <?php endif; ?>
            </div>
        </div>        
        
        <div class="ibox-content">   
            <div class="m-b-sm">
                <div class="input-group">
                    <input id='search_depense_valide' type="text" class="form-control form-control-sm">
                </div>
            </div>                         
            <ul id='depense_valide_container' class="phase_block list-group elements-list agile-list connnect_tache"></ul>
        </div>
    </div>
</div>