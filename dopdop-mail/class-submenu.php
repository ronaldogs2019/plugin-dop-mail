<?php
/**
 * Creates the submenu item for the plugin.
 *
 * @package Custom_Admin_Settings
 */
 
/**
 * Creates the submenu item for the plugin.
 *
 * Registers a new menu item under 'Tools' and uses the dependency passed into
 * the constructor in order to display the page corresponding to this menu item.
 *
 * @package Custom_Admin_Settings
 */
class Submenu {
 
        /**
     * A reference the class responsible for rendering the submenu page.
     *
     * @var    Submenu_Page
     * @access private
     */
    private $submenu_page;
 
    /**
     * Initializes all of the partial classes.
     *
     * @param Submenu_Page $submenu_page A reference to the class that renders the
     *                                                                   page for the plugin.
     */
    public function __construct( $submenu_page ) {
        ob_start();
        $this->submenu_page = $submenu_page;
    }
 
    /**
     * Adds a submenu for this plugin to the 'Tools' menu.
     */
    public function init() {
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    }
 
    /**
     * Creates the submenu item and calls on the Submenu Page object to render
     * the actual contents of the page.
     */

    public function add_options_page() {
    
        add_options_page(
            'Dop Dop Mail Form',
            'Custom Administration Page',
            'manage_options',
            'form-dopdop-mail',
            array( $this->submenu_page = 'Form_Dopdop_Mail', 'render' )
        );
        add_options_page(
            'Settings Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'settings-dopdop-mail',
            array( $this->submenu_page = 'Settings_Dopdop_Mail', 'settings' )
        );
        add_options_page(
            'Settings Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'basic-settings-dopdop-mail',
            array( $this->submenu_page = 'Basic_Settings_Dopdop_Mail', 'settings' )
        );
        add_options_page(
            'Settings Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'list-data-settings-dopdop-mail',
            array( $this->submenu_page = 'List_Data_Settings_Dopdop_Mail', 'settings' )
        );
        add_options_page(
            'Config Data Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'insert-data-dopdop-mail',
            array( $this->submenu_page = 'Config_Data_form', 'CreateForm' )
        ); 
        add_options_page(
            'Config Data Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'update-data-dopdop-mail',
            array( $this->submenu_page = 'Config_Data_form', 'updateForm' )
        ); 
        add_options_page(
            'Config Data Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'delete-data-dopdop-mail',
            array( $this->submenu_page = 'Config_Data_form', 'deleteForm' )
        ); 
        add_options_page(
            'Admin Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'dopdop-mail',
            array( $this->submenu_page = 'Admin_List_Dopdop_Mail', 'admin_list' )
        );      
        add_options_page(
            'Admin Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'manage-basic-insert-data-dopdop-mail',
            array( $this->submenu_page = 'Config_Data_form', 'insert_email' )
        );  
        add_options_page(
            'Config Data Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'manage-update-email-dopdop-mail',
            array( $this->submenu_page = 'Config_Data_form', 'updateConfig' )
        ); 
        add_options_page(
            'Config Data Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'manage-update-body-email-dopdop-mail',
            array( $this->submenu_page = 'Config_Data_form', 'updateBodyConfig' )
        ); 
        add_options_page(
            'Admin Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'dopdop-mail-send-email',
            array( $this->submenu_page = 'Config_Data_form', 'cad_form_before_send' )
        );  
        add_options_page(
            'Admin Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'dopdop-mail-download-xml',
            array( $this->submenu_page = 'Config_Data_form', 'DownloadXml' )
        );  
        add_options_page(
            'Admin Dop Dop Mail',
            'Custom Administration Page',
            'manage_options',
            'body-mail-settings-dopdop-mail',
            array( $this->submenu_page = 'Body_Mail_Settings_DopdopMail', 'settings' )
        );
        
    }
}