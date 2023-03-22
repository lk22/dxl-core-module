<?php 

/**
 * Global DXL Settings
 * @package DXL Core
 * @version: 1.0  
 */

 if ( ! defined('ABSPATH') ) {
  exit;
 }

 if ( ! function_exists('dxl_esttings_page_register') ) {
  /**
   * Register DXL settings page to admin menu
   *
   * @return void
   */
  function dxl_settings_page_register() {
    add_menu_page(
      "DXL Indstillinger",
      "DXL Indstillinger",
      "manage_options",
      "dxl_settings",
      "dxl_settings_page_callback",
      "dashicons-admin-generic",
      20
    );
  }
 }

 add_action('admin_menu', 'dxl_settings_page_register');

/**
 * Register custom settings field
 */
if ( ! function_exists('dxl_settings_fields_register') ) {
  /**
   * Register settings fields
   *
   * @return void
   */
  function dxl_settings_fields_register() {
    register_setting('dxl_settings', 'dxl_membership_email');
    register_setting('dxl_settings', 'dxl_developer_mail');

    add_settings_section(
      'dxl_mail_options',
'',
      'dxl_mail_settings_section_callback',
      'dxl_settings'
    );

    add_settings_field(
      'dxl_membership_email',
      'Medlemsskabs mail',
      'dxl_membership_mail_field_callback',
      'dxl_settings',
      'dxl_mail_options'
    );

    add_settings_field(
      'dxl_developer_mail',
      'DXL udvikler mail',
      'dxl_developer_mail_field_callback',
      'dxl_settings',
      'dxl_mail_options'
    );
  }
}

add_action('admin_init', 'dxl_settings_fields_register');

if ( ! function_exists('dxl_mail_settings_section_callback') ) {
  /**
   * Initializing DXL mail settings sections
   *
   * @return void
   */
  function dxl_mail_settings_section_callback() {
    echo "<h4>Mail indstillinger</h4>";
  }
}

if ( ! function_exists('dxl_membership_mail_field_callback') ) {
  /**
   * Initializing Membership mail field
   *
   * @return void
   */
  function dxl_membership_mail_field_callback() {
    $mail = get_option("dxl_membership_mail", 'medlemsskab@danishxboxleague.dk');
    echo "<input type='email' name='dxl_membership_email' value='" . $mail . "'/>";
    echo "<p class='description'>Mailen som bruges til at sende medlemsskabs mails til</p>";
  }
}

if ( ! function_exists('dxl_developer_mail_field_callback') ) {
  /**
   * Initializing Membership mail field
   *
   * @return void
   */
  function dxl_developer_mail_field_callback() {
    $mail = get_option("dxl_developer_mail");
    echo "<input type='email' name='dxl_developer_mail' value='" . $mail . "'/>";
    echo "<p class='description'>Mailen som bruges til at sende administrations mails til</p>";
  }
}

if ( ! function_exists('dxl_settings_page_callback') ) {
  /**
   * Render settings page content
   *
   * @return void
   */
  function dxl_settings_page_callback() {
    ?> 
      <div class="wrap">
        <div class="container">
          <div class="row bg-white">
            <div class="col-12">
              <h1>Danish Xbox League Indstillinger</h1>
              <hr>
              <form action="post" action="options.php">
                <?php 
                  settings_fields('dxl_settings');
                  do_settings_sections("dxl_settings");
                  submit_button();
                ?>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php 
  }
}