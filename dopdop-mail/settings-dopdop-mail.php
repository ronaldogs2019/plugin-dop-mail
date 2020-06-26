<?php

  require_once (dirname(__FILE__).'/settings.php');
  require_once (dirname(__FILE__).'/form-dopdop-mail.php');
  require_once (dirname(__FILE__).'/basic-settings-dopdop-mail.php');
  require_once (dirname(__FILE__).'/list-data-settings-dopdop-mail.php');
  require_once (dirname(__FILE__).'/class-submenu.php');

  Class Settings_Dopdop_Mail {


  function __construct() {
      //do nothing

  }
  
  public function settings() { 

    $form_id = $_GET['form_id'];
    ?>
      <div class="container mt-2">
        <div class="row mb-0">
          <ul class="nav nav-tabs col-sm-12 mb-0">
            <li class="nav-item col-sm-4 p-0">
              <a class="nav-link <?php echo (isset($_GET['page']) && ($_GET['page'] == "form-dopdop-mail")) ? "active" : ""; ?>" href="<?php echo get_admin_url() . "options-general.php?page=form-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>"><h5 class="text-center">Formulário</h5></a>
            </li>
            <li class="nav-item col-sm-4 p-0">
              <a class="nav-link <?php echo (isset($_GET['page']) && ($_GET['page'] == "settings-dopdop-mail")) ? "active" : ""; ?>" href="<?php echo get_admin_url() . "options-general.php?page=settings-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>"><h5 class="text-center">Configurações</h5></a>
            </li>
          </ul>
        </div>
        <div class="row mb-0 d-flex justify-content-start flex-wrap">
          <div class="col-md-4">
            <div class="card" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title">Configurações Basicas</h5>
                <p class="card-text">Neste painel você gerência as configurações basicas para o envio de emails.</p>
                <a href="<?php echo get_admin_url() . "options-general.php?page=basic-settings-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>" class="btn btn-primary">Gerir</a>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title">Armazenamento de Dados</h5>
                <p class="card-text">Neste painel você gerencia a listagem de emails recebidos para o formulário cadastrado.</p>
                <a href="<?php echo get_admin_url() . "options-general.php?page=list-data-settings-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>" class="btn btn-primary">Gerir</a>
              </div>
            </div>
          </div>

         
        </div>           
      </div>
<?php }

  function admin_menu_settings() {

    $plugin = new Submenu( new Settings_Dopdop_Mail() );
    $plugin->init();
 
  }

}
?>