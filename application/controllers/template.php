<?php
class Template extends CI_controller
{
	
	function template()
	{
		parent :: __construct();
		$autoload['helper'] = array('url');
	}

	function index()
	{
		$this ->load->view ('tampilan');
	}
}


?>