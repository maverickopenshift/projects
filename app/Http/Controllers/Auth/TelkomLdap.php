<?php 
namespace App\Http\Controllers\Auth;

class TelkomLdap
{

	var $err_msg = "";

	function connect($servername)
	{
		$ds = @ldap_connect($servername);  // must be a valid LDAP server!
		return $ds;
	}
	
	function bind($ds,$rdn,$pwd)
	{
		if (!$ds)
			return FALSE;
		$r = @ldap_bind($ds,$rdn,$pwd);
		return $r;
	}
	
	function close($ds)
	{
		@ldap_close($ds);
	}
	
	function set_error($err_str)
	{
		$this->$err_msg = $err_str;
	}
	
	function clear_error()
	{
		$this->$err_msg = '';
	}
	
	function get_last_error()
	{
		return $this->$err_msg;
	}
	
	function authenticate($ds,$rdn,$pwd)
	{
		$ldap_con = $this->connect($ds);
		if ($ldap_con == FALSE)
		{
			return ldap_error($ldap_con) . " ldap_con error";
		}
		$ldap_bind = $this->bind($ldap_con,$rdn,$pwd);
		if ($ldap_bind == FALSE)
		{
			return ldap_error($ldap_con) . " ldap_bind error";
		}
		$this->close($ldap_con);
		return "OK";
	}
}