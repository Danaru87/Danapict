<?php

Class User
{
	private $loggin;
	private $mdp;

	public function __construct($p_loggin = null, $p_mdp = null)
	{
		$login = $p_loggin;
		$mdp = $p_mdp;
	}		

	public function GetLoggin()
	{
		return $this->loggin;
	}

	public function SetLoggin($mloggin)
	{
		$this->loggin = $mloggin;
	}

	public function GetMDP()
	{
		return $this->mdp;
	}

	public function SetMDP($mmdp)
	{
		$this->mdp = $mmdp;
	}
}
?>