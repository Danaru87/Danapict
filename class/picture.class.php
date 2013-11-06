<?php
require_once('data.class.php');
Class Picture
{
	private $id;
	private $titre;
	private $description;
	private $url;
	private $visible;
	private $urlMini;

	public function __construct($p_id = null, $p_titre = null, $p_description = null, $p_url = null, $p_urlMini = null, $p_visible = null) // Constructeur de l'objet
	{
		$this->id = $p_id;
		$this->titre = $p_titre;
		$this->description = "".$p_description;
		$this->url = $p_url;
		$this->visible = $p_visible;
		$this->urlMini =$p_urlMini;
	}

	public function GetID()
	{
		return $this->id;
	}
	public function SetID($id)
	{
		$this->id = $id;
	}
	public function GetTitre()
	{
		return $this->titre;
	}
	public function SetTitre($titre)
	{
		$this->titre = $titre;
		$data = new DATA();
		$data->ModifierPicture($this);
	}
	public function GetDescription()
	{
		return $this->description;
	}
	public function SetDescription($texte)
	{
		$this->description = $texte;
		$data = new DATA();
		$data->ModifierPicture($this);
	}
	public function GetURL()
	{
		return $this->url;
	}
	public function SetURL($url)
	{
		$this->url = $url;
		$data = new DATA();
		$data->ModifierPicture($this);
	}
	public function GetURLMini()
	{
		return $this->urlMini;
	}
	public function SetURLMini($urlMini)
	{
		$this->urlMini = $urlMini;
		$data = new DATA();
		$data->ModifierPicture($this);
	}
	public function GetVisible()
	{
		return $this->visible;
	}
	public function SetVisible($visible)
	{
		$this->visible = $visible;
		$data = new DATA();
		$data->ModifierPicture($this);
	}
}
?>