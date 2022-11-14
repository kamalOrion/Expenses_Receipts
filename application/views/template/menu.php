<body class="">

    <div id="wrapper">    
             
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">

                <li class="nav-header">
                    <!-- <div class="text-center" style="color: white">
                        <i class='fa fa-user-circle' style='font-size: 25px'></i> 
                        <p class="block m-t-xs font-bold"><?php #echo $this->session->userdata('nom_prenoms') ?></p>
                    </div> -->
                    <div class="logo-element">
                        O'mel
                    </div>
                </li>

                <?php if(allowed('tableau_de_bord')): ?>
                <li>
                    <a href="<?php echo base_url() ?>index.php/Dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> </a>
                </li>
                <?php endif; ?>
                
                <?php if(allowed('recettes')): ?>
                <li>
                    <a href="<?php echo base_url() ?>index.php/Ventes"><i class="fa fa-money"></i> <span class="nav-label">Recettes</span></a>
                </li>
                <?php endif; ?>
                
                <?php if(allowed('depenses')): ?>
                <li>
                    <a href="<?php echo base_url() ?>index.php/Depenses"><i class="fa fa-credit-card"></i> <span class="nav-label">Dépenses</span></a>
                </li>
                <?php endif; ?>
                
                <?php if(allowed('administration')): ?>
                <li>
                    <a href="<?= site_url(); ?>/Administration"><i class="fa fa-gear"></i> <span class="nav-label">Administration</span></a>
                </li>
                <?php endif; ?>
                
                <?php if(allowed('profil')): ?>
                <li>
                    <a href="<?php echo base_url() ?>index.php/Profil"><i class="fa fa-address-card-o"></i> <span class="nav-label">Profil d'utilisateur</span></a>
                </li>
                <?php endif; ?>

            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="<?php echo base_url() ?>index.php/Profil"><i class="fa fa-user-circle-o"></i> <span class="m-r-sm text-muted welcome-message"><?php echo $this->session->userdata('nom_prenoms') ?></span></a>                
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>index.php/Dashboard/deconnexion">
                                <i class="fa fa-sign-out"></i> Déconnexion
                            </a>
                        </li>
                    </ul>

            </nav>
        </div>
        