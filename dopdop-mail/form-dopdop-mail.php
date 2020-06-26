<?php

  require_once (dirname(__FILE__).'/settings.php');
  require_once (dirname(__FILE__).'/class-submenu.php');
  require_once (dirname(__FILE__).'/settings-dopdop-mail.php');
  require_once (dirname(__FILE__).'/config-data-dopdop-mail.php');

  Class Form_Dopdop_Mail {

  function __construct() {

  }

  public function render() { 

    $form_id = $_GET['form_id'];

    if( empty($form_id) ){
      $page_url = "insert-data-dopdop-mail";
    }else{
      $page_url = "update-data-dopdop-mail&form_id=".$form_id;
    }
    ?>
    <form action="<?php echo get_admin_url() . "options-general.php?page=".$page_url; ?>" name="dopdop-mail-form" method="POST">
     <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields('wporg_options'); 

        if( !empty($form_id) ){
          global $wpdb;

          $table_name = $wpdb->prefix . "dopdop_mail";

          $sql = $wpdb->prepare("SELECT id, form_name, form_value, form_css FROM $table_name WHERE id = %d", array(esc_attr($form_id)));
          $results = $wpdb->get_results($sql);
        }

        if( !empty($results[0]) ){
          foreach ($results as $result) {
      ?>
      <input class="hide" name="form_id" type="hidden" value="<?php echo $result->id; ?>">
      <div class="container mt-2">
        <div class="row mb-0">
          <ul class="nav nav-tabs col-sm-12 mb-0 p-0 d-flex justify-content-between">
            <li class="nav-item col-sm-4 p-0">
              <a class="nav-link <?php echo (isset($_GET['page']) && ($_GET['page'] == "form-dopdop-mail")) ? "active" : ""; ?>" href="<?php echo get_admin_url() . "options-general.php?page=form-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>"><h5 class="text-center">Formulário</h5></a>
            </li>
            <?php if( isset($form_id) && !empty($form_id) ){ ?>
            <li class="nav-item col-sm-4 p-0">
              <a class="nav-link <?php echo (isset($_GET['page']) && ($_GET['page'] == "settings-dopdop-mail")) ? "active" : ""; ?>" href="<?php echo get_admin_url() . "options-general.php?page=settings-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>"><h5 class="text-center">Configurações</h5></a>
            </li>
            <?php } ?>
            <li class="nav-item col-sm-4 p-0 d-flex justify-content-end">
              <a class="nav-link" href="<?php echo get_admin_url() . "options-general.php?page=dopdop-mail"; ?>"><img src="<?php echo plugins_url('dopdop-mail/images/back.png'); ?>" class="back-img-dopdop-mail"></a>
            </li>
          </ul>
        </div>
        <div class="row mt-0 border-bottom border-left border-right bg-light border-top-zero">
          <div class="col-md-12 mt-3 border-top-zero">
            <div class="form-group">
              <textarea class="form-control" name="form_value" id="form_value" rows="10" required><?php echo esc_html(unserialize($result->form_value)); ?></textarea>
            </div>
          </div>
        </div>
        
        <div class="row mt-0 border-bottom border-left border-right bg-light border-top-zero">
          <div class="col-md-12 mt-3 border-top-zero">
            <div id="accordion">
              <div class="card col-md-12">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0">                    
                      <a href="#" class="btn btn-primary" data-toggle="collapse" data-target="#collapseCSSForm">Code CSS</a>
                  </h5>
                </div>
                <div id="collapseCSSForm" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="card-body pl-0 pr-0">
                    <div class="form-group">
                      <textarea class="form-control" name="form_css" id="form_css" rows="10" required><?php echo esc_html($result->form_css); ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row mt-3 mb-3 d-flex justify-content-start">
          <div class="col-md-12 border">
            <label class="px-3 mt-3">Nome do formulário:</label> 
            <input type="text" class="form-control mt-3 mb-3 col-md-6" name="form_name" id="form_name" placeholder="Nome do formulário" value="<?php echo unserialize($result->form_name); ?>" required>
          </div>         
        </div>
        <div class="row border">
          <div class="col-md-12 px-1 d-flex justify-content-between">
            <button class="btn btn-primary mr-2 ml-2 mt-2 mb-2" type="submit">Alterar</button>
          </div>
        </div>
      </div>
      <?php } }else{ ?>
      <div class="container mt-2">
        <div class="row mb-0">
          <ul class="nav nav-tabs col-sm-12 mb-0 p-0 d-flex justify-content-between">
            <li class="nav-item col-sm-4 p-0">
              <a class="nav-link <?php echo (isset($_GET['page']) && ($_GET['page'] == "form-dopdop-mail")) ? "active" : ""; ?>" href="<?php echo get_admin_url() . "options-general.php?page=form-dopdop-mail"; ?>"><h5 class="text-center">Formulário</h5></a>
            </li>
            <?php if( isset($form_id) && !empty($form_id) ){ ?>
            <li class="nav-item col-sm-4 p-0">
              <a class="nav-link <?php echo (isset($_GET['page']) && ($_GET['page'] == "settings-dopdop-mail")) ? "active" : ""; ?>" href="<?php echo get_admin_url() . "options-general.php?page=settings-dopdop-mail"; ?>"><h5 class="text-center">Configurações</h5></a>
            </li>
            <?php } ?>
            <li class="nav-item col-sm-4 p-0 d-flex justify-content-end">
              <a class="nav-link" href="<?php echo get_admin_url() . "options-general.php?page=dopdop-mail"; ?>"><img src="<?php echo plugins_url('dopdop-mail/images/back.png'); ?>" class="back-img-dopdop-mail"></a>
            </li>
          </ul>
        </div>
        <div class="row mt-0 border-bottom border-left border-right bg-light border-top-zero">
          <div class="col-md-12 mt-3 border-top-zero">
            <div class="form-group">
              <textarea class="form-control" name="form_value" id="form_value" rows="10" required>Insert only your code html here...</textarea>
            </div>
          </div>
        </div>
        <div class="row mt-0 border-bottom border-left border-right bg-light border-top-zero">
          <div class="col-md-12 mt-3 pb-3 border-top-zero">
            <div id="accordion">
              <div class="card col-md-12">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0">                    
                      <a href="#" class="btn btn-primary" data-toggle="collapse" data-target="#collapseCSSForm">Code CSS</a>  
                  </h5>
                </div>
                <div id="collapseCSSForm" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="card-body pl-0 pr-0">
                    <div class="form-group">
                      <textarea class="form-control" name="form_css" id="form_css" rows="10" required>Insert your code css here...</textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3 mb-3">
          <div class="col-md border">
            <input type="text" class="form-control mt-3 mb-3 col-md-6" name="form_name" id="form_name" placeholder="Nome do formulário" required>
          </div>
        </div>
        <div class="row border">
          <div class="col-md-12 px-1 d-flex justify-content-between">
            <button class="btn btn-primary mr-2 ml-2 mt-2 mb-2" type="submit">Salvar</button>
          </div>
        </div>
      </div><?php } ?>
    </form>   
  <?php  }
} ?>

