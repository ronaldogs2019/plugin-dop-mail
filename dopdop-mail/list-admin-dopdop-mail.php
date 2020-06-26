<?php

  require_once (dirname(__FILE__).'/settings.php');
  require_once (dirname(__FILE__).'/class-submenu.php');
  require_once (dirname(__FILE__).'/form-dopdop-mail.php');

  Class Admin_List_Dopdop_Mail {

  function __construct() {
    
  }

  public function admin_list() { 

    global $wpdb;
    $table = $wpdb->prefix.'dopdop_mail';

    $forms = $wpdb->get_results( "SELECT id, form_name FROM $table", ARRAY_A);            

    ?>


      <div class="container mt-2">
        <div class="row mb-0">
          <div class="col-md-12">
            <a href="<?php echo get_admin_url() . "options-general.php?page=form-dopdop-mail"; ?>" class="btn btn-primary mb-2 mt-2 ml-2 mr-2">Criar novo formulario</a>
          </div>
        </div>
        <div class="row mb-0">
          <div class="col-md-12">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Formulário</th>
                <th scope="col">Shorcode</th>
                <th scope="col">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($forms as $form) { ?>
              <tr>
                <td><?php echo $form['id']; ?></td>
                <td><?php echo unserialize($form['form_name']); ?></td>
                <td>[ddm id="<?php echo $form['id']; ?>" title="<?php echo unserialize($form['form_name']); ?>"]</td>
                <td><a class="btn btn-primary p-1 mr-2 ml-2" href="<?php echo get_admin_url() . "options-general.php?page=form-dopdop-mail&form_id=".$form['id']; ?>" role="button">Editar</a><a class="btn btn-danger mr-2 ml-2 p-1" href="<?php echo get_admin_url() . "options-general.php?page=delete-data-dopdop-mail&form_id=".$form['id']; ?>" role="button">Deletar</a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>   
<?php
}

}
