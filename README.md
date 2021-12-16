Link_Vault_Logger
=================

The Link Vault Logger plugin simply logs a record of a download.  This is useful when item's to be downloaded are not actual files stored on the server.  For example, downloading a printer-friendly template or PDF generated on-the-fly.

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
	
This plugin was inspired by the need to log downloads when PDFs were being created dynamically from an EE template.
