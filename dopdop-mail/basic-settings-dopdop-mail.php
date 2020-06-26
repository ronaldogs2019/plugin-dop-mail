<?php

  require_once (dirname(__FILE__).'/settings.php');
  require_once (dirname(__FILE__).'/class-submenu.php');
  require_once (dirname(__FILE__).'/config-data-dopdop-mail.php');
  require_once (dirname(__FILE__).'/body-mail-settings-dopdop-mail.php');

  Class Basic_Settings_Dopdop_Mail {


  function __construct() {
      //do nothing

  }
  
  public function settings() { 

    $form_id = $_GET['form_id'];   

    if( !empty($form_id) ){
      global $wpdb;

      $table_name = $wpdb->prefix . "config_dopdop_mail";

      $sql = $wpdb->prepare("SELECT config_data FROM $table_name WHERE config_tipo = '1' AND form_id = %d", array(esc_attr($form_id)));
      $results = $wpdb->get_results($sql);

    }

    if( !empty($results[0]) ){
      $tipo = "manage-update-email-dopdop-mail";
    }else{
      $tipo = "manage-basic-insert-data-dopdop-mail";
    }
    ?>
    <form action="<?php echo get_admin_url() . "options-general.php?page=".$tipo; ?>" method="POST">
      <input class="hide" name="form_id" type="hidden" value="<?php echo $form_id; ?>">
      <div class="container mt-2">
        <div class="row mb-0">
          <ul class="nav nav-tabs col-sm-12 mb-0">
            <li class="nav-item col-sm-4 p-0">
              <a class="nav-link <?php echo (isset($_GET['page']) && ($_GET['page'] == "form-dopdop-mail")) ? "active" : ""; ?>" href="<?php echo get_admin_url() . "options-general.php?page=form-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>"><h5 class="text-center">Formulário</h5></a>
            </li>
            <li class="nav-item col-sm-4 p-0">
              <a class="nav-link active" href="<?php echo get_admin_url() . "options-general.php?page=settings-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>"><h5 class="text-center">Configurações</h5></a>
            </li>
            <li class="nav-item col-sm-4 p-0">
              <a class="nav-link" href="<?php echo get_admin_url() . "options-general.php?page=body-mail-settings-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>"><h5 class="text-center">Corpo do E-mail</h5></a>
            </li>
          </ul>
        </div>
        <div class="row mb-0 d-flex justify-content-center flex-wrap">
          <div class="col-md-12 p-0">
            <nav aria-label="breadcrumb mt-1">
              <ol class="breadcrumb px-3 ml-0 mr-0 mt-3 mb-3 ">
                <li class="breadcrumb-item"><a href="<?php echo get_admin_url() . "options-general.php?page=settings-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>">Configurações</a></li>
                <li class="breadcrumb-item active" aria-current="page">Configurações Basicas</li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row mb-0 d-flex justify-content-center flex-wrap border">
          <div class="col-md-12 formMail">
            <div class="form-group mt-3">
              <label for="email[]">Digite seu email no formato: example@hotmail.com </label>
            </div>
            <?php

            if( !empty($results[0]) ){
              $emails = json_decode($results[0]->config_data);
              foreach ($emails as $email) {              
            ?>
            <div class="form-group">
              <input type="email" class="form-control" name="email[]" placeholder="Your Email" value="<?php echo $email; ?>">
            </div>
          <?php } }else{ ?>
            <div class="form-group">
              <input type="email" class="form-control" name="email[]" placeholder="Your Email">
            </div>
          <?php } ?>


          </div>
          <div class="col-md-12">
            <div class="form-group mt-3">
              <button type="submit" class="btn btn-primary">Salvar Alterações</button>
              <button type="button" class="btn btn-success" id="create_email_component">Adicionar Outro Email</button>
            </div>
          </div>
        </div>         
      </div>           
    </div>
  </form>   
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#create_email_component").click(function() {
        $(".formMail").append("<div class='form-group'><input type='email' class='form-control' name='email[]' placeholder='Your Email'></div>");
      });
    });
  </script>
<?php }

function admin_menu_settings() {

  $plugin = new Submenu( new Settings_Dopdop_Mail() );
  $plugin->init();

}

}
?>