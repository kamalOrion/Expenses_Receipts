
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2><i class="fa fa-gear"></i> Administration</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="<?php echo base_url() ?>index.php/Dashboard"><strong>Administration</strong></a>
                </li>
            </ol>
        </div>
    </div>

<div class="wrapper wrapper-content animated fadeInRight" style='padding-bottom: 5px;'>
    <div class="row text-center">

    <?php if(allowed('admin_groupe')) :?>
        <div class="col-lg-3 admin-card-container">
            <a href="<?= site_url(); ?>/Groupe">
                <div class="row admin-card">
                <div class="col-12">
                    <i class="fa fa-users"></i>
                </div>
                <div class="col-12">
                Groupe d'utilisateurs
                </div>
            </div>
            </a> 
        </div>
    <?php endif; ?>

    <?php if(allowed('admin_utilisateur')) :?>
        <div class="col-lg-3 admin-card-container">
            <a href="<?= site_url(); ?>/Users">
                <div class="row admin-card">
                <div class="col-12">
                    <i class="fa fa-user"></i>
                </div>
                <div class="col-12">
                    Utilisateurs     
                </div>
            </div>
            </a>
        </div>
    <?php endif; ?>

    <?php if(allowed('admin_type_depense')) :?>
        <div class="col-lg-3 admin-card-container">
            <a href="<?= site_url(); ?>/basic_data/type_depense">
                <div class="row admin-card">
                <div class="col-12">
                    <i class="fa fa-tags"></i>
                </div>
                <div class="col-12">
                    Types de dépenses
                </div>
            </div>
            </a> 
        </div>
    <?php endif; ?>

    <?php if(allowed('admin_produit')) :?>
        <div class="col-lg-3 admin-card-container">
            <a href="<?= site_url(); ?>/basic_data/produit">
                <div class="row admin-card">
                <div class="col-12">
                    <i class="fa fa-cubes"></i>
                </div>
                <div class="col-12">
                    Produits
                </div>
            </div>
            </a> 
        </div>
    <?php endif; ?>

    <?php if(allowed('admin_structure')) :?>
        <div class="col-lg-3 admin-card-container">
            <a href="<?= site_url(); ?>/structures">
                <div class="row admin-card">
                <div class="col-12">
                    <i class="fa fa-bank"></i>
                </div>
                <div class="col-12">
                Structures
                </div>
            </div>
            </a> 
        </div>
    <?php endif; ?>
    
    </div>
</div>