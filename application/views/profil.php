<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><i class='fa fa-user-circle'></i> Profil de l'utilisateur</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                Dashboard
            </li>
            <li class="breadcrumb-item active">
                <strong>Profil</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight" style='padding-bottom: 5px;'>
    <div class='row'>
        <div class='col-lg-12 alert_container'></div>
        <div class="col-lg-4">
            <div class='row'>
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Vos informations</h5>
                        </div>
                        <div class="ibox-content">
                            <div><span><h3><i class='fa fa-user-circle' style='margin-right: 10px'></i> <?= $this->session->userdata('nom_prenoms').' '.$this->session->userdata('prenoms') ?></h3></span></div>
                            <div><span><h3><i class='fa fa-envelope' style='margin-right: 10px'></i> <?= $this->session->userdata('email') ?></h3></span></div>
                            <div><span><h3><i class='fa fa-phone' style='margin-right: 10px'></i> <?= $this->session->userdata('tel') ?></h3></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="row">
            <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Modifiez votre mot de passe</h5>
                        </div>
                        <div class="ibox-content">
                            <form id='profil_mdp_form' action='<?= site_url(); ?>/Profil/change_pass' method='POST'>
                                <div class='text-center mb-2'><small>Veuillez remplir le formulaire puis cliquez sur terminer pour enregister</small></div>
                                <div class="form-group position-relative">                                  
                                    <?php 
                                    $data = array(
                                            "id"            => "actuel_pass",   
                                            'name'          => 'actuel_pass',
                                            'type'          => 'password',
                                            'class'         => 'form-control'.((form_error('actuel_pass') != "")?" is-invalid":""),
                                            'placeholder'   => 'Mot de passe actuel',
                                            'autocomplete'  =>'off',
                                    );
                                    echo form_input($data); ?>
                                </div>
                                <div class="form-group position-relative">                                  
                                    <?php 
                                    $data = array(
                                            "id"            => "nouveau_pass",
                                            'name'          => 'nouveau_pass',
                                            'type'          => 'password',
                                            'class'         => 'form-control mot_de_passe'.((form_error('nouveau_pass') != "")?" is-invalid":""),
                                            'placeholder'   => 'Nouveau mot de passe',
                                            'autocomplete'  =>'off',
                                    );
                                    echo form_input($data); ?>
                                </div>
                                <div class="form-group position-relative">                                  
                                    <?php 
                                    $data = array(
                                            "id"            => "confirm_pass",   
                                            'name'          => 'confirm_pass',
                                            'type'          => 'password',
                                            'class'         => 'form-control'.((form_error('confirm_pass') != "")?" is-invalid":""),
                                            'placeholder'   => 'Confirmez le mot de passe',
                                            'autocomplete'  =>'off',
                                    );
                                    echo form_input($data); ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-offset-2 col-lg-12 text-center">
                                        <button id='profil_mdp_form_terminer' class="btn btn-sm btn-primary" type="submit">Terminer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> 
    