<?php

  require_once (dirname(__FILE__).'/settings.php');
  require_once (dirname(__FILE__).'/class-submenu.php');
  require_once (dirname(__FILE__).'/config-data-dopdop-mail.php');

  Class List_Data_Settings_Dopdop_Mail {


  function __construct() {
      //do nothing

  }
  
  public function settings() { 

    $form_id = $_GET['form_id'];

    global $wpdb;

    $table = $wpdb->prefix.'data_dopdop_mail';

    $forms = $wpdb->get_results("SELECT id, form_data, date_created FROM $table", ARRAY_A);      
    $form2 = $wpdb->get_results("SELECT form_data_headers FROM $table ORDER BY id DESC LIMIT 1", ARRAY_A);
    $data_headers = (array)json_decode($form2[0]["form_data_headers"]);
    $headers = array_splice($data_headers["headers"], 1, count($data_headers["headers"]));
    ?>
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
          </ul>
        </div>
        <div class="row mb-0 d-flex justify-content-center flex-wrap">
          <div class="col-md-12 p-0">
            <nav aria-label="breadcrumb mt-1">
              <ol class="breadcrumb px-3 ml-0 mr-0 mt-3 mb-3 ">
                <li class="breadcrumb-item"><a href="<?php echo get_admin_url() . "options-general.php?page=settings-dopdop-mail".(isset($form_id) ? "&form_id=".$form_id : ""); ?>">Configurações</a></li>
                <li class="breadcrumb-item active" aria-current="page">Armazenamento de Dados</li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row mb-0 d-flex justify-content-start flex-wrap pb-3">
          <div class="col-md-auto pl-2 pr-2 p-auto">
            <a href="<?php echo get_admin_url()."options-general.php?page=dopdop-mail-download-xml&form_id=".$form_id; ?>" class="btn btn-primary">Download XML</a>
          </div>         
        </div>
        <div class="row mb-0 d-flex justify-content-center flex-wrap border">
          <div class="col-md-12">
            <table class="table table-hover">
              <thead>
                <tr>
                  <?php if(!empty($headers)){       
                    foreach ($headers as $header) { ?>
                    <th class="text-center"><?php echo $header; ?></th>
                    <?php } ?>      
                    <th class="text-center">data</th>    
                    <?php } ?>      
                </tr>
              </thead>
              <tbody>
                <?php
                  if(!empty($forms)){                  
                    foreach ($forms as $form) { 
                      ?>
                <tr>
                  <?php

                  $dados_forms = json_decode($form["form_data"]);
                  $campos_valores = $dados_forms->campo_valor;
                  $campos_valores_slice = array_splice($campos_valores, 1, count($campos_valores));
                                
                  foreach ($campos_valores_slice as $campo_valor) {?>
                  <td class="text-center"><?php echo $campo_valor; ?></td>
                  <?php } ?>
                  <td class="text-center"><?php echo $form["date_created"]; ?></td>
                </tr>
                <?php }}?>
              </tbody>
            </table>
          </div>
        </div>         
      </div>           
  
  <?php }} ?>