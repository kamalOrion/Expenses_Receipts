    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Dashboard</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="<?php echo base_url() ?>index.php/Dashboard"><strong>Dashboard</strong></a>
                </li>
            </ol>
        </div>
    </div>
    
<div class="wrapper wrapper-content animated fadeInRight" style='padding-top: 30px'>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Graphique ventes</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content text-center">
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <div class="form-group" id="bar_chart_month">
                                <div class="input-group date">
                                    <sapn class="input-group-addon"><i class="fa fa-calendar"></i></sapn>
                                    <input id='chart_date' type="text" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <canvas id="barChart" height="70"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 alert_container">            
            <div class="ibox">
                <div class="ibox-title" style='padding: 15px'>
                    <div class='row'>
                        <div class='col'>
                            <h4><i class='fa fa-list'></i> Tableau des opération effectuées</h4>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id='tableDashboard' class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Structure</th>
                                    <th>Type</th>
                                    <th>Intitulé</th>  
                                    <th>Montant</th>
                                    <th>Auteur</th>
                                    <th>Mode de paiement</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    