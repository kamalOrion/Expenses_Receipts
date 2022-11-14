<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title;?></title>
    
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
    <style>
        body{
            background-image: url(<?php echo base_url('assets/img/bg_water.png') ?>)
        }
    </style>

</head>

<body class="gray-bg" style="background: url(<?php #echo base_url("assets/noukon/img/login.jpg") ?>);">
    <div class="loginColumns loginColumns-custom animated fadeInDown">
        
    <div class="row">
            <div class="middle-box text-center loginscreen animated fadeInDown"><div>
            <div>

                <h1 class="logo-name logo-name-custom">O'Mel</h1>
                <!-- <div>
                    <img src="<?php echo base_url() ?>assets/imgs/omelLogo.jpg">
                </div> -->

            </div>
            <h3>Bienvenue à O'Mel</h3>
            
            <p>Veuillez vous connecter pour continuer.</p>
            <div class="col-md-12" style='padding: 0'>
                <?php if(isset($error)):?>
                    <div class="alert alert-danger alert-dismissable" style="font-size: 12px;">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $error;?>
                    </div>
                <?php endif;?> 
                <?php if($this->session->flashdata('error')):?>
                    <div class="alert alert-danger alert-dismissable" style="font-size: 12px;">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $this->session->flashdata('error');?>
                    </div>
                <?php endif;?>  
                <?php if($this->session->flashdata('success')):?>
                    <div class="alert alert-success alert-dismissable" style="font-size: 12px;">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $this->session->flashdata('success');?>
                    </div>
                <?php endif;?>
            </div>
            <form class="m-t" role="form" action="<?php echo site_url('Dashboard/connexion') ?>"  method="post">
                <div class="form-group">
                    <?php 
                                    
                        $data = array(
                            'name'          => 'email',
                            'type'          => 'text',
                            'class'         => 'form-control',
                            'placeholder'   => 'e-mail',
                            'autocomplete'  => 'on',
                            'value'         => set_value('email'),
                            'required'      => 'required'
                        );

                        echo form_input($data); ?>                                  
                        
                        <?php if (form_error('email') != "" ): ?>
                            <div style="color: red"><i class="fa fa-warning"></i> <?php echo form_error('email'); ?></div>
                        <?php endif ?>
                </div>
                <div class="form-group">
                    <?php 
                        $data = array(
                                'name'          => 'mdp',
                                'type'          => 'password',
                                'class'         => 'form-control ',
                                'placeholder'   => 'Mot de passe',
                                'autocomplete'  => 'off',
                                'value'         => set_value('mdp'),
                                'required'      => 'required'
                        );

                        echo form_input($data); ?>
                        
                        <?php if (form_error('mdp') != "" ): ?>
                            <div style="color: red"><i class="fa fa-warning"></i> <?php echo form_error('mdp'); ?></div>
                        <?php endif ?>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Connexion</button>

                <a href="#"><small>Mot de passe oublié ?</small></a>
                
            </form>
        </div>
    </div>

        </div>
        <hr/>
        <div class="row" style="margin-top: 20px">
            <div class="col text-center">
                <strong>Copyright</strong> O'mel &copy; 2020
            </div>            
        </div>
    </div>
</div>

</body>

</html>
