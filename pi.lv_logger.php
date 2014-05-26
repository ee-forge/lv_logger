<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Link Vault Logger Class
 *
 * @package     ExpressionEngine
 * @category        Plugin
 * @author      Ron Hickson
 * @copyright       Copyright (c) 2014, Ron Hickson
 * @link        http://ee-forge.com/
 */

$plugin_info = array(
    'pi_name'         => 'Link Vault Logger',
    'pi_version'      => '1.0',
    'pi_author'       => 'Ron Hickson',
    'pi_author_url'   => 'http://ee-forge.com/',
    'pi_description'  => 'Creates a log record without serving a file',
    'pi_usage'        => Lv_logger::usage()
);

class Lv_logger {

 	/**
     * Link Vault Logger
     *
     * Creates a log record in Link Vault but does not serve a file.
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
		ee()->load->add_package_path( PATH_THIRD.'link_vault' );
		ee()->load->library('link_vault_library');
		
		ee()->load->library('logger');
		
		$record_data = array(
			'site_id'		=> ee()->TMPL->fetch_param('site_id', '1'),
			'entry_id'		=> ee()->TMPL->fetch_param('entry_id'),
			'unix_time'		=> time(),
			'member_id'		=> ee()->session->userdata('member_id'),
			'remote_ip'		=> ee()->session->userdata('ip_address'),
			'directory' 	=> ee()->TMPL->fetch_param('directory'),
			'file_name' 	=> ee()->TMPL->fetch_param('file_name'),
			'is_link_click'	=> ee()->TMPL->fetch_param('is_link_click', 'n')
		);
		
		$fields = ee()->db->list_fields('link_vault_downloads');
		
		foreach ($fields as $field) {
			if(preg_match('/^cf_/', $field)) {
				$record_data[$field] = ee()->TMPL->fetch_param($field);
			}
		}
				
		$id = ee()->link_vault_library->log_download( $record_data );
		
		if (empty($id)) {
			ee()->logger->developer('Link Vault Template failed to create a log record for '. $record_data['file_name'], FALSE);
		}
    }
    
    /**
     * Usage
     *
     * This function describes how the plugin is used.
     *
     * @access  public
     * @return  string
     */
    public static function usage()
    {
        ob_start();  ?>

The Link Vault Logger plugin simple logs a record of a download.  This is useful when item's to be downloaded are not actual files stored on the server.  For example, downloading a printer-friendly template or PDF generated on-the-fly.

    {exp:lv_logger entry_id='{entry_id}' file_name='{segment_3}'}

The following parameters can be set (and most of them should):
	
	site_id (defaults to 1)
	entry_id
	directory
	file_name
	is_link_click (defaults to 'n')
	cf_custom_field (use your custom field name as a parameter)

The following parameters are set automatically by the plugin:

	unix_time (current time)
	member_id (logged in user)
	remote_ip (logged in users IP)


    <?php
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }
    // END
}
/* End of file pi.lv_template.php */
/* Location: ./system/expressionengine/third_party/lv_template/pi.lv_template.php */