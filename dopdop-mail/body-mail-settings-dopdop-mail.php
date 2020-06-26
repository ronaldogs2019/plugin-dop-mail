<?php

  require_once (dirname(__FILE__).'/settings.php');
  require_once (dirname(__FILE__).'/class-submenu.php');
  require_once (dirname(__FILE__).'/config-data-dopdop-mail.php');

  Class Body_Mail_Settings_DopdopMail{


  function __construct() {
      //do nothing

  }
  
  public function settings() { 

    $form_id = $_GET['form_id'];   

    if( !empty($form_id) ){
      $form_id = $_GET['form_id'];

      global $wpdb;

      $table = $wpdb->prefix.'data_dopdop_mail'; 

      $form = $wpdb->get_results("SELECT form_data_headers FROM $table WHERE form_id = $form_id ORDER BY id DESC LIMIT 1", ARRAY_A);

      $table = $wpdb->prefix.'config_dopdop_mail'; 

      $body_form = $wpdb->get_results("SELECT config_data FROM $table WHERE form_id = $form_id AND config_tipo = '2' ORDER BY id DESC LIMIT 1", ARRAY_A);     

      $data_headers = (array)json_decode($form[0]["form_data_headers"]);
      $headers = array_splice($data_headers["headers"], 1, count($data_headers["headers"]));      
    }

      //precisa ser criado ainda.
      $tipo = "manage-update-body-email-dopdop-mail";
    
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
              <a class="nav-link" href="<?php echo get_admin_url() . "options-general.php?page=settings-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>"><h5 class="text-center">Configurações</h5></a>
            </li>
            <li class="nav-item col-sm-4 p-0">
              <a class="nav-link active" href="<?php echo get_admin_url() . "options-general.php?page=body-mail-settings-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>"><h5 class="text-center">Corpo do E-mail</h5></a>
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
          <div class="col-md-12">
            <div class="form-group mt-3">
              <div class="d-flex flex-wrap justify-content-start mt-4">
                <label for="email">Digite o nome do campo no formato: [nome_do_campo] </label>
              </div>
              <div class="d-flex flex-wrap justify-content-start mt-4">
                <label>Campos dispoveis de seu formulario:</label>
              </div>
              <div class="d-flex flex-wrap justify-content-start mt-4">
                <?php if(!empty($headers)){       
                  foreach ($headers as $header) { ?>
                    <label class="mr-3">[<?php echo $header; ?>]</label>
                  <?php } ?>     
                <?php } ?>                
              </div>
            </div>        
          </div>
        </div>
        <div class="row mb-0 p-1 d-flex justify-content-center flex-wrap border">
          <div class="col-md-12">
            <div class="form-group mt-3">
              <div class="d-flex flex-wrap justify-content-start">
                <textarea class="form-control" name="form_value" id="form_value" rows="10" required><?php 
                  if(!empty($body_form)){
                    echo esc_html(json_decode($body_form[0]['config_data']));
                  }else{
                    if(!empty($headers))
                    {      
                      foreach ($headers as $header)
                      {
                        echo "\n".$header." : "."[".$header."]";   
                                
                      }     
                    }                   
                  }
                  ?></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-0 d-flex justify-content-center flex-wrap border">
          <div class="col-md-12">
            <div class="form-group mt-3">
              <button type="submit" class="btn btn-primary">Salvar Alterações</button>              
            </div>
          </div>
        </div>
      </div>         
    </div>           
  </form>  
<?php }

function admin_menu_settings() {

  $plugin = new Submenu( new Settings_Dopdop_Mail() );
  $plugin->init();

}

}
?>