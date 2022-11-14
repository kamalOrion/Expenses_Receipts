
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-md-8">
        <h2><i class='fa fa fa-credit-card'></i> Dépenses</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <strong>Dépenses</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-4 custom-btn-top text-right">
        <button data-toggle="dropdown" class="btn btn-primary  btn-sm ml-2 dropdown-toggle" aria-expanded="true"><i class="fa fa-ellipsis-v"></i> Afficher</button>
        <ul class="dropdown-menu top-dd" x-placement="bottom-start">
            <li><button id='tous_depense' class="dropdown-item btn btn-sm btn-default m-2"><i class="fa fa-circle"></i> Tous</button></li>
            <li><button id='b_depense' class="dropdown-item btn btn-sm btn-default m-2"><i class="fa fa-check"></i> Block dépenses</button></li>
            <li><button id='b_total' class="dropdown-item btn btn-sm btn-default m-2"><i class="fa fa-check"></i> Block total</button></li>
            <li><button id='b_valide' class="dropdown-item btn btn-sm btn-default m-2"><i class="fa fa-check"></i> Block dépenses validées</button></li>
            <li><button id='b_list' class="dropdown-item btn btn-sm btn-default m-2"><i class="fa fa-check"></i> Block liste</button></li>
        </ul>
    </div>
</div>

<div class="wrapper animated fadeInUp mb-5">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="row justify-content-center">

                <?php if(allowed('b_depense')) $this->load->view('depenses_bloc/depense_demandees'); ?>

                <?php if(allowed('b_select_depense')) $this->load->view('depenses_bloc/depense_selectionnees'); ?>

                <?php if(allowed('b_depense_valide')) $this->load->view('depenses_bloc/depense_validees'); ?>

                <?php if(allowed('b_depense_effectue')) $this->load->view('depenses_bloc/depense_effectue'); ?>

            </div>     
        </div>
    </div>
</div>