<div id='dep_total' class="depense_bloc_size col-lg">
    <div class="ibox">
        <div class='ibox-title'>
            <h4><i class="fa fa-circle"></i> <span id="total_depense_seleted">0</span> items</h4>
            <h4><i class="fa fa-money"></i> <span id="total_depense_seleted_montant">0</span></h4>
            <div class="ibox-tools">
            <?php if(allowed('VD')): ?>
                <button id='valide_depense' class='btn btn-primary btn-sm'><i class='fa fa-check'></i> Validé</button>
            <?php endif; ?>
            </div>
        </div>
        <div class="ibox-content">                            
            <ul id='depense_selected_container' class="phase_block list-group elements-list agile-list connnect_tache"></ul>
        </div>
    </div>
</div>