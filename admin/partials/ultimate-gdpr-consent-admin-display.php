<?php

/**
* Provide a admin area view for the plugin
*
* This file is used to markup the admin-facing aspects of the plugin.
*
* @link       https://www.wpexec.com
* @since      1.0.0
*
* @package    Ultimate_Gdpr_Consent
* @subpackage Ultimate_Gdpr_Consent/admin/partials
*/

if( isset( $_GET[ 'tab' ] ) ) {
    $active_tab = $_GET[ 'tab' ];
} // end if

$options = get_option($this->plugin_name);

?>
<script type="text/javascript">
    var admin_url = "<?=admin_url();?>";
    var plugin_name = "<?=$this->plugin_name;?>";
</script>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div ng-app="ugcApp">
    <div class="wrap ultimate-gdpr-consent ugc-admin-page page-ugc" ng-controller="GeneralSetting">
        <h1 id="ugc-title"><?php echo esc_html(get_admin_page_title()); ?></h1>

        <h2 id="ugc-nav-tab-wrapper" class="nav-tab-wrapper">
            <a href="#ugc-general" class="ugc-nav-tab nav-tab nav-tab-active">General Options</a>
            <a href="#ugc-cookie-bar" class="ugc-nav-tab nav-tab">Cookie Bar</a>
            <a href="#ugc-toggle-button" class="ugc-nav-tab nav-tab">Cookie Toggle Button</a>
            <a href="#ugc-accept-button" class="ugc-nav-tab nav-tab">Accept Button</a>
            <a href="#ugc-decline-button" class="ugc-nav-tab nav-tab">Decline Button</a>
        </h2>
        <div class="ugc_content_wrapper">
            <div class="ugc_content_cell">
                <form action="options.php" method="post" name="ugc-settings" id="ugc-conf" accept-charset="UTF-8">
                    <?php
                        $options = get_option($this->plugin_name);
                        // settings_fields($this->plugin_name);
                        // do_settings_sections($this->plugin_name);
                    ?>
                    <div id="features">
                        <div style="max-width:1000px">
                            <div class="ugc-tabs-container">
                                <div id="ugc-general" class="ugc-tab ugc-tab-active">
                                    <?php
                                        settings_fields( $this->plugin_name );
                                        do_settings_sections( $this->plugin_name );
                                    ?>
                                    <h2><?php esc_attr_e('General Options', $this->plugin_name); ?></h2>

                                    <!-- General Options -->
                                    <fieldset>
                                        <label class="ugc-label" for="<?=$this->plugin_name;?>[cookie_bar_status]"><?php esc_attr_e('Activate Cookie Bar', $this->plugin_name); ?></label>
                                        <div class="toggle-radio">
                                            <input name="<?=$this->plugin_name;?>[cookie_bar_status]" ng-model="form.cookie_bar_status" id="cookie_bar_status_yes" class="radio_yes" type="radio" value="1" <?php checked($options['cookie_bar_status'], 1); ?> />
                                            <input name="<?=$this->plugin_name;?>[cookie_bar_status]" ng-model="form.cookie_bar_status" id="cookie_bar_status_no" class="radio_no" type="radio" value="0" <?php checked($options['cookie_bar_status'], 0); ?> />
                                            <div class="switch">
                                                <label class="yes" for="cookie_bar_status_yes"><?php esc_attr_e('Enable', $this->plugin_name); ?></label>
                                                <label class="no" for="cookie_bar_status_no"><?php esc_attr_e('Disable', $this->plugin_name); ?></label>
                                                <span></span>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <table class="form-table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar_position]">
                                                        <?php esc_attr_e('Cookie Bar Position', $this->plugin_name); ?>
                                                    </label>
                                                </th>
                                                <td>
                                                    <select name="<?=$this->plugin_name;?>[cookie_bar_position]" ng-model="form.cookie_bar_position" id="cookie_bar_position">
                                                        <option value="header"><?php esc_attr_e('Header', $this->plugin_name); ?></option>
                                                        <option value="footer"><?php esc_attr_e('Footer', $this->plugin_name); ?></option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr ng-show="form.cookie_bar_position == 'header'">
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar_header_float]"><?php esc_attr_e('Floating Cookie Bar', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[cookie_bar_header_float]" ng-model="form.cookie_bar_header_float" value="float" > <?php esc_attr_e('Yes', $this->plugin_name); ?>
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[cookie_bar_header_float]" ng-model="form.cookie_bar_header_float" value="static" > <?php esc_attr_e('No', $this->plugin_name); ?>
                                                        </label>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar_header_float]"><?php esc_attr_e('Show condition', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[cookie_bar_show_condition]" ng-model="form.cookie_bar_show_condition" value="instant">
                                                            <?php esc_attr_e('Show Instantly after page is loaded', $this->plugin_name); ?>
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[cookie_bar_show_condition]" ng-model="form.cookie_bar_show_condition" value="scroll">
                                                            <?php esc_attr_e('Show when user scrolls down the page', $this->plugin_name); ?>
                                                        </label>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar][scroll_offset]"><?php esc_attr_e('How many pixels from top user has to scroll before the cookie bar starting to appear', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <input name="<?=$this->plugin_name;?>[cookie_bar][scroll_offset]" ng-model="form.cookie_bar.scroll_offset" type="text" id="cookie_bar_scroll_offset" class="regular-text ltr" />
                                                    <p class="cookie_bar_scroll_offset"><?php esc_attr_e('This box accepts value in pixels. In example, a value of 150 is for 150 pixels', $this->plugin_name); ?></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar_auto_hide]"><?php esc_attr_e('Auto-Hide Features', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[cookie_bar_auto_hide]" ng-model="form.cookie_bar_auto_hide" value="1"> <?php esc_attr_e('Yes', $this->plugin_name); ?>
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[cookie_bar_auto_hide]" ng-model="form.cookie_bar_auto_hide" value="0"> <?php esc_attr_e('No', $this->plugin_name); ?>
                                                        </label>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr ng-show="form.cookie_bar_auto_hide == '1'">
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar_auto_hide_delay]"><?php esc_attr_e('Auto-Hide Delay', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <input name="cookie_bar_auto_hide_delay" ng-model="form.cookie_bar_auto_hide_delay" type="number" id="cookie_bar_auto_hide_delay" class="regular-text ltr" />
                                                    <p class="cookie_bar_auto_hide_delay"><?php esc_attr_e('This box accepts value in milliseconds. In example, a value of 1000 is for 1 second', $this->plugin_name); ?></p>
                                                </td>
                                            </tr ng-show="form.cookie_bar_status == '1'">
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar_header_float]"><?php esc_attr_e('Hide Animation', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[cookie_bar_hide_animation]" ng-model="form.cookie_bar_hide_animation" value="1" checked="checked">
                                                            <?php _e("Hide the cookie bar <i><strong>with</strong></i> animation.", $this->plugin_name); ?>
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[cookie_bar_hide_animation]" ng-model="form.cookie_bar_hide_animation" value="0" checked="checked">
                                                            <?php _e("Hide the cookie bar <i><strong>without</strong></i> animation.", $this->plugin_name); ?>
                                                        </label>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar_header_float]"><?php esc_attr_e('Custom Allowed Cookies', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <input type="text" name="<?=$this->plugin_name;?>[custom_allowed_cookies]" ng-model="form.custom_allowed_cookies" id="custom_allowed_cookies" />
                                                    <p><?php esc_attr_e('Separate by commas. In example: cookies_one,cookies_two', $this->plugin_name); ?></p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <p class="submit"><input type="button" name="submit" id="submit" class="button button-primary" value="Save all changes" ng-click="saveChanges();"></p>

                                    <!-- End General Options -->
                                </div>
                                <div id="ugc-cookie-bar" class="ugc-tab">
                                    <!-- Cookie Bar Customization -->
                                    <h3 style="margin-bottom: 30px"><?php esc_attr_e('Cookie Bar Customization', $this->plugin_name); ?></h3>

                                    <table class="form-table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar]['message']"><?php esc_attr_e('Message', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <textarea name="<?=$this->plugin_name;?>[cookie_bar]['message']" ng-model="form.cookie_bar.message" id="cookie_bar_message"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar]['background_color']"><?php esc_attr_e('Background Color', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <color-picker options="colorPickerOptions" ng-model="form.cookie_bar.background_color"></color-picker>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar]['text_color']"><?php esc_attr_e('Text Color', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <color-picker options="colorPickerOptions" ng-model="form.cookie_bar.text_color"></color-picker>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar]['show_border']"><?php esc_attr_e('Show Borders', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[cookie_bar][show_border]" ng-model="form.cookie_bar.show_border" value="1" checked="checked"> <?php esc_attr_e('Yes', $this->plugin_name); ?>
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[cookie_bar][show_border]" ng-model="form.cookie_bar.show_border" value="0" checked="checked"> <?php esc_attr_e('No', $this->plugin_name); ?>
                                                        </label>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr ng-show="form.cookie_bar.show_border == '1'">
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_bar]['border_color']"><?php esc_attr_e('Border Color', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <color-picker options="colorPickerOptions" ng-model="form.cookie_bar.border_color"></color-picker>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <p class="submit"><input type="button" name="submit" id="submit" class="button button-primary" value="Save all changes" ng-click="saveChanges();"></p>
                                    <!-- End Cookie Bar Customization -->
                                </div>
                                <div id="ugc-toggle-button" class="ugc-tab">
                                    <!-- Cookie Bar Toggle Button Customization -->
                                    <h3 style="margin-bottom: 30px"><?php esc_attr_e('Cookie Bar Toggle Button Customization', $this->plugin_name); ?></h3>

                                    <fieldset>
                                        <label class="ugc-label" for="<?=$this->plugin_name;?>['cookie_toggle_button']['status']"><?php esc_attr_e('Activate Cookie Bar Toggle Button', $this->plugin_name); ?></label>
                                        <div class="toggle-radio">
                                            <input name="<?=$this->plugin_name;?>['cookie_toggle_button']['status']" ng-model="form.cookie_toggle_button.status" id="cookie_toggle_button_yes" class="radio_yes" type="radio" value="1" <?php checked($options['cookie_toggle_button']['status'], 1); ?> />
                                            <input name="<?=$this->plugin_name;?>['cookie_toggle_button']['status']" ng-model="form.cookie_toggle_button.status" id="cookie_toggle_button_no" class="radio_no" type="radio" value="0" <?php checked($options['cookie_toggle_button']['status'], 0); ?> />
                                            <div class="switch">
                                                <label class="yes" for="cookie_toggle_button_yes"><?php esc_attr_e('Enable', $this->plugin_name); ?></label>
                                                <label class="no" for="cookie_toggle_button_no"><?php esc_attr_e('Disable', $this->plugin_name); ?></label>
                                                <span></span>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <table class="form-table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_toggle_button]['text']"><?php esc_attr_e('Button Text', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <input type="text" name="<?=$this->plugin_name;?>[cookie_toggle_button]['text']" ng-model="form.cookie_toggle_button.text" id="cookie_toggle_button_text" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_toggle_button]['background_color']"><?php esc_attr_e('Background Color', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <color-picker options="colorPickerOptions" ng-model="form.cookie_toggle_button.background_color"></color-picker>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_toggle_button]['text_color']"><?php esc_attr_e('Text Color', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <color-picker options="colorPickerOptions" ng-model="form.cookie_toggle_button.text_color"></color-picker>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_toggle_button]['show_border']"><?php esc_attr_e('Show Borders', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[cookie_toggle_button][show_border]" ng-model="form.cookie_toggle_button.show_border" value="1" checked="checked"> <?php esc_attr_e('Yes', $this->plugin_name); ?>
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[cookie_toggle_button][show_border]" ng-model="form.cookie_toggle_button.show_border" value="0" checked="checked"> <?php esc_attr_e('No', $this->plugin_name); ?>
                                                        </label>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr ng-show="form.cookie_toggle_button.show_border == '1'">
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[cookie_toggle_button]['border_color']"><?php esc_attr_e('Border Color', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <color-picker options="colorPickerOptions" ng-model="form.cookie_toggle_button.border_color"></color-picker>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <p class="submit"><input type="button" name="submit" id="submit" class="button button-primary" value="Save all changes" ng-click="saveChanges();"></p>
                                    <!-- End Cookie Bar Toggle Button Customization -->
                                </div>
                                <div id="ugc-accept-button" class="ugc-tab">
                                    <!-- Accept Button -->
                                    <h3 style="margin-bottom: 30px"><?php esc_attr_e('Accept Button', $this->plugin_name); ?></h3>

                                    <table class="form-table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[accept_button][text]"><?php esc_attr_e('Button Text', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <input type="text" name="<?=$this->plugin_name;?>[accept_button][text]" ng-model="form.accept_button.text" id="accept_button_text" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[accept_button][action]"><?php esc_attr_e('Button Action', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[accept_button][action]" ng-model="form.accept_button.action" value="hide" checked="checked"> <?php esc_attr_e('Hide Cookie Bar', $this->plugin_name); ?>
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[accept_button][action]" ng-model="form.accept_button.action" value="url" checked="checked"> <?php esc_attr_e('Open a New URL', $this->plugin_name); ?>
                                                        </label>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr ng-show="form.accept_button.action == 'url'">
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[accept_button][action]"><?php esc_attr_e('Destination URL', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <input type="text" name="<?=$this->plugin_name;?>[accept_button][url]" ng-model="form.accept_button.url" id="accept_button_url" />
                                                </td>
                                            </tr>
                                            <tr ng-show="form.accept_button.action == 'url'">
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[accept_button][target]"><?php esc_attr_e('Open Link in a New Window', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[accept_button][target]" ng-model="form.accept_button.target" value="_blank" checked="checked"> <?php esc_attr_e('Yes', $this->plugin_name); ?>
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[accept_button][target]" ng-model="form.accept_button.target" value="_self" checked="checked"> <?php esc_attr_e('No', $this->plugin_name); ?>
                                                        </label>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[accept_button][text_color]"><?php esc_attr_e('Text Color', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <color-picker options="colorPickerOptions" ng-model="form.accept_button.text_color"></color-picker>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[accept_button][show_as]"><?php esc_attr_e('Show Button as', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[accept_button][show_as]" ng-model="form.accept_button.show_as" value="button" checked="checked"> <?php esc_attr_e('Button', $this->plugin_name); ?>
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[accept_button][show_as]" ng-model="form.accept_button.show_as" value="link" checked="checked"> <?php esc_attr_e('Text Link', $this->plugin_name); ?>
                                                        </label>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[accept_button][background_color]"><?php esc_attr_e('Background Color', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <color-picker options="colorPickerOptions" ng-model="form.accept_button.background_color"></color-picker>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <p class="submit"><input type="button" name="submit" id="submit" class="button button-primary" value="Save all changes" ng-click="saveChanges();"></p>
                                    <!-- End Accept Button -->
                                </div>
                                <div id="ugc-decline-button" class="ugc-tab">
                                    <!-- Decline Button -->
                                    <h3 style="margin-bottom: 30px"><?php esc_attr_e('Decline Button', $this->plugin_name); ?></h3>

                                    <fieldset>
                                        <label class="ugc-label" for="<?=$this->plugin_name;?>[cookie_decline_button]"><?php esc_attr_e('Show Decline Button', $this->plugin_name); ?></label>
                                        <div class="toggle-radio">
                                            <input name="<?=$this->plugin_name;?>[cookie_decline_button]" ng-model="form.cookie_decline_button" id="cookie_decline_button_yes" class="radio_yes" type="radio" value="1" <?php checked($options['cookie_decline_button'], 1); ?> />
                                            <input name="<?=$this->plugin_name;?>[cookie_decline_button]" ng-model="form.cookie_decline_button" id="cookie_decline_button_no" class="radio_no" type="radio" value="0" <?php checked($options['cookie_decline_button'], 0); ?> />
                                            <div class="switch">
                                                <label class="yes" for="cookie_decline_button_yes"><?php esc_attr_e('Yes', $this->plugin_name); ?></label>
                                                <label class="no" for="cookie_decline_button_no"><?php esc_attr_e('No', $this->plugin_name); ?></label>
                                                <span></span>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <table class="form-table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[decline_button][text]"><?php esc_attr_e('Button Text', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <input type="text" name="<?=$this->plugin_name;?>[decline_button][text]" ng-model="form.decline_button.text" id="decline_button_text" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[decline_button][action]"><?php esc_attr_e('Button Action', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[decline_button][action]" ng-model="form.decline_button.action" value="hide" checked="checked"> <?php esc_attr_e('Hide Cookie Bar', $this->plugin_name); ?>
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[decline_button][action]" ng-model="form.decline_button.action" value="url" checked="checked"> <?php esc_attr_e('Open a New URL', $this->plugin_name); ?>
                                                        </label>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr ng-show="form.decline_button.action == 'url'">
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[decline_button][action]"><?php esc_attr_e('Destination URL', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <input type="text" name="<?=$this->plugin_name;?>[decline_button][url]" ng-model="form.decline_button.url" id="decline_button_url" />
                                                </td>
                                            </tr>
                                            <tr ng-show="form.decline_button.action == 'url'">
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[decline_button][target]"><?php esc_attr_e('Open Link in a New Window', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[decline_button][target]" ng-model="form.decline_button.target" value="_blank" checked="checked"> <?php esc_attr_e('Yes', $this->plugin_name); ?>
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[decline_button][target]" ng-model="form.decline_button.target" value="_self" checked="checked"> <?php esc_attr_e('No', $this->plugin_name); ?>
                                                        </label>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[decline_button][text_color]"><?php esc_attr_e('Text Color', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <color-picker options="colorPickerOptions" ng-model="form.decline_button.text_color"></color-picker>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[decline_button][show_as]"><?php esc_attr_e('Show Button as', $this->plugin_name); ?></label>
                                                </th>
                                                <td>
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[decline_button][show_as]" ng-model="form.decline_button.show_as" value="button" checked="checked"> <?php esc_attr_e('Button', $this->plugin_name); ?>
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="<?=$this->plugin_name;?>[decline_button][show_as]" ng-model="form.decline_button.show_as" value="link" checked="checked"> <?php esc_attr_e('Text Link', $this->plugin_name); ?>
                                                        </label>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="<?=$this->plugin_name;?>[decline_button][background_color]">
                                                        <?php esc_attr_e('Background Color', $this->plugin_name); ?>
                                                    </label>
                                                </th>
                                                <td>
                                                    <color-picker options="colorPickerOptions" ng-model="form.decline_button.background_color"></color-picker>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <p class="submit"><input type="button" name="submit" id="submit" class="button button-primary" value="Save all changes" ng-click="saveChanges();"></p>
                                    <!-- End Decline Button -->
                                </div>
                            </div><!-- .ugc-tabs-container -->
                        </div>
                    </div><!-- .features -->
                </form>
            </div><!-- .ugc_content_cell -->
        </div><!-- .ugc_content_wrapper -->
    </div><!-- .wrap -->
</div>
