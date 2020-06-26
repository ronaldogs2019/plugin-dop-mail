<?php

  require_once (dirname(__FILE__).'/settings.php');
  require_once (dirname(__FILE__).'/class-submenu.php');
  require_once (dirname(__FILE__).'/form-dopdop-mail.php');

  Class Config_Data_form {
  
  public $send;

  function __construct($send) {
      $this->send = $send;

  }
  
  public function CreateForm() { 

      global $wpdb;
      $table = $wpdb->prefix.'dopdop_mail';

      $form_value = $_REQUEST['form_value'];
      $form_css = $_REQUEST['form_css'];
      $form_author = wp_get_current_user();

      $str1   = array('\"',"\'");
      $sub_str   = array('"','"');

      $new_form_data = str_replace($str1, $sub_str, $form_value );
      $new_css_data = str_replace($str1, $sub_str, $form_css );  

      $data = array(
        'form_name'  => serialize($_REQUEST['form_name']),
        'form_value' => serialize($new_form_data),
        'form_css' => $new_css_data,
        'form_author' => $form_author->user_login,
        'date_created'  => date("Y-m-d h:i"),
      );

      //$format = array('%s','%d'); 
      
      $wpdb->insert($table,$data);
      $last_id = $wpdb->insert_id;      

      $url = $_SERVER['HTTP_REFERER']."&form_id=".$last_id;

      echo '<meta http-equiv="refresh" content="1;URL=' . $url . '">';
  }
 
  public function updateForm() { 
    $form_id = $_POST['form_id'];

    global $wpdb;
      $table = $wpdb->prefix.'dopdop_mail';

      $form_value = $_REQUEST['form_value'];
      $form_css = $_REQUEST['form_css'];

      $str1   = array('\"',"\'");
      $sub_str   = array('"','"');

      $new_form_data = str_replace($str1, $sub_str, $form_value );
      $new_css_data = str_replace($str1, $sub_str, $form_css );  
      
      $data = array(
        'form_name'  => serialize($_REQUEST['form_name']),
        'form_value' => serialize($new_form_data),
        'form_css' => $new_css_data,
        'date_updated'  => date("Y-m-d h:i"),
      );

    if( isset($form_id) && !empty($form_id) ){
      $wpdb->update($table, $data, array('id'=>$form_id));
    }

    $url = $_SERVER['HTTP_REFERER']."&form_id=".$form_id;
        
    echo '<meta http-equiv="refresh" content="1;URL=' . $url . '">';
  }

  public function deleteForm() { 
    $form_id = $_GET['form_id'];

    global $wpdb;
    $table = $wpdb->prefix.'dopdop_mail';

    if( isset($form_id) && !empty($form_id) ){
      $wpdb->delete($table, array('id'=>$form_id));
    }

    $url = $_SERVER['HTTP_REFERER'];
        
    echo '<meta http-equiv="refresh" content="1;URL=' . $url . '">';
  }

  public function insert_email() { 

    global $wpdb;
    $table = $wpdb->prefix.'config_dopdop_mail';

    $form_author = wp_get_current_user();

    $email = $_REQUEST['email'];
    $form_id = $_REQUEST['form_id'];

    foreach ($emails as $email) {
      if( !empty($email) ){
        $dados[] .= $email;
      }      
    }

    $data = array(
      'config_data'  => json_encode($dados),
      'config_tipo' => '1',
      'form_id'=> $form_id,
      'form_author' => $form_author->user_login,
      'date_created'  => date("Y-m-d h:i"),
    );   

    $wpdb->insert($table, $data);

    $url = $_SERVER['HTTP_REFERER']."&form_id=".$form_id;

    echo '<meta http-equiv="refresh" content="1;URL=' . $url . '">';
  }

  public function updateConfig() { 

    global $wpdb;
    $table = $wpdb->prefix.'config_dopdop_mail';

    $form_author = wp_get_current_user();

    $emails = $_REQUEST['email'];
    $form_id = $_REQUEST['form_id'];


    foreach ($emails as $email) {
      if( !empty($email) ){
        $dados[] .= $email;
      }      
    }

    $data = array(
      'config_data'  => json_encode($dados),
      'config_tipo' => '1',
      'form_id'=> $form_id,
      'form_author' => $form_author->user_login,
      'date_updated'  => date("Y-m-d h:i"),
    );

    $wpdb->update($table, $data, array('id'=>$form_id));   

    $url = $_SERVER['HTTP_REFERER']."&form_id=".$form_id;

    echo '<meta http-equiv="refresh" content="1;URL=' . $url . '">';
  }

  public function updateBodyConfig() { 

    global $wpdb;
    $table = $wpdb->prefix.'config_dopdop_mail';

    $form_author = wp_get_current_user();

    $body = $_REQUEST['form_value'];
    $form_id = $_REQUEST['form_id'];


    $data = array(
      'config_data'  => json_encode($body),
      'config_tipo' => '2',
      'form_id' => $form_id,
      'form_author' => $form_author->user_login,
      'date_created' => date("Y-m-d h:i"),
    );
   
    $wpdb->insert($table, $data);

    $url = $_SERVER['HTTP_REFERER']."&form_id=".$form_id;

    echo '<meta http-equiv="refresh" content="1;URL=' . $url . '">';
  }

  public function cad_form_before_send() {
      
    global $wpdb;
    $table = $wpdb->prefix.'data_dopdop_mail';

    $form_headers = $wpdb->get_results( "SELECT form_data_headers FROM $table ORDER BY id DESC LIMIT 1", ARRAY_A);

    $headers = (array)json_decode($form_headers[0]["form_data_headers"]);

    foreach ($_POST as $name => $val)
    {
      if( empty($name) || empty($val) ){
        $url = $_SERVER['HTTP_REFERER'];

        echo '<meta http-equiv="refresh" content="1;URL=' . $url . '">';
        exit;
      }

      if($name == "form_id"){
        $form_id = $val;
      } 

      if(!empty($headers)){
        if(!in_array($name, $headers["headers"]) ){

          $headers["headers"][] .= $name;
        }
      }else{
        $headers["headers"][] .= $name;
      }

      $dados["campo_nome"][] .= $name; 
      $dados["campo_valor"][] .= $val;
    }
        

    $data = array(
      'form_data' => json_encode($dados),
      'form_data_headers' => json_encode($headers),
      'form_id'=> $form_id,
      'date_created'  => date("Y-m-d h:i"),
    );   

    $wpdb->insert($table, $data);

    $url = $_SERVER['HTTP_REFERER'];

    echo '<meta http-equiv="refresh" content="1;URL=' . $url . '">';
  }

  public function send_email() {

    
     // $to = "ronaldogs2019@gmail.com";
     // $subject = "teste";
     // $message = $dados;

    //user posted variables
    //$name = $_POST['message_name'];
    $email = "ronaldogs2019@gmail.com";
    $message = $dados;

    //php mailer variables
    $to = get_option('admin_email');
    $subject = "Some text in subject...";
    $headers = 'From: '. $email . "\r\n" .
      'Reply-To: ' . $email . "\r\n";

    //Here put your Validation and send mail
    $sent = wp_mail($to, $subject, strip_tags($message), $headers);
        if($sent) {
          print_r("teste1");
          exit;
        }//message sent!
        else  {
          print_r("teste2");
          exit;
        }//message wasn't sent
  }
  
  public function wp_get_current_user() {
    
    return _wp_get_current_user();
  }

  public function DownloadXml(){

    global $wpdb;
    $table = $wpdb->prefix.'dopdop_mail';
    $table2 =$wpdb->prefix.'data_dopdop_mail';

    $form_id = $_GET["form_id"];

    $dados_form = $wpdb->get_results( "SELECT form_data, date_created FROM $table2 WHERE form_id = $form_id", OBJECT );

    $dom = new DOMDocument("1.0", "ISO-8859-1");
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $root = $dom->createElement("formulario");
    $formulario = $dom->createElement("conteudo"); 

    foreach ($dados_form as $form) {
      
      $dados = json_decode($form->form_data);     
      $campo_nome = array_splice($dados->campo_nome, 1, count($dados->campo_nome));
      $campo_valor = array_splice($dados->campo_valor, 1, count($dados->campo_valor));
     
      $item = $dom->createElement("item");

      for($i=0;$i < count($campo_nome);$i++){
        $campo = $dom->createElement($campo_nome[$i], $campo_valor[$i]);
        $item->appendChild($campo);
      }   

      $campo = $dom->createElement("data", $form->date_created);
      $item->appendChild($campo);

      $formulario->appendChild($item);
    }

    $root->appendChild($formulario);
    $dom->appendChild($root);
    $dom->save(dirname(__FILE__)."/downloads/formulario.xml");
    
    $target_dir = plugin_dir_path( __FILE__).'downloads/';
    $filename = 'formulario.xml';

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($target_dir.$filename));

    while (ob_get_level()) {
        ob_end_clean();
        @readfile($target_dir.$filename);
    }

    unlink($target_dir.$filename);
    $url = $_SERVER['HTTP_REFERER'];

    echo '<meta http-equiv="refresh" content="1;URL=' . $url . '">';
  }
}
?>