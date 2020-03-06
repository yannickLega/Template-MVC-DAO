<?php 
class Controller {
	public $input;
	public $files;
	private $vars = array();

	// Déclaration du constructeur qui sera utilisé dans tout les controleurs qui etendrons Controller
	public function __construct() {
		// Si le controlleur reçois un $_POST
		if (isset($_POST)) {
			// Affectation de $_POST à l'attribut $input
			$this->input = $_POST;
		}
		// Si le controlleur reçois un $_FILES
		if (isset($_FILES)) {
			// Affectation de $_FILES à l'attribut $files
			$this->files = $_FILES;
		}
	}

	// Déclaration de la methode loadDao qui sera utilisé dans tout les controleurs qui etendrons Controller, elle sert a charger une dao en fonction de $name
	function loadDao($name) {
		// Charge le fichier dao
		require_once('dao/'.$name.'.dao.php');
		// affectation a $daoClass du nom de la classe de la dao chargé
		$daoClass = 'Dao'.$name;
		// affectation a $this->$daoClass de l'instance de la dao chargé 
		$this->$daoClass = new $daoClass();
	}

	// Déclaration de la methode loadDao qui sera utilisé dans tout les controleurs qui etendrons Controller, elle sert a affecter sauvegarder les données fournie par $d
	function set($d) {
		// affectation a $this->vars de la fusion de $this->vars avec $d
		$this->vars = array_merge($this->vars, $d);
	}

	// Déclaration de la methode render qui sera utilisé dans tout les controleurs qui etendrons Controller, elle sert a charger la vue demandée
	function render($entity, $viewFile,$param = null) {
			// Extraction de $vars
			// permet le passage de $d['maVar'] = value (côté controlleur) à $maVar = value (côté vue)
			extract($this->vars);
			// Démarrage de la mémoire tempon
			ob_start();
			// Charge le fichier vue
			require_once('vue/'.$entity.'/'.$viewFile.'.php');
			// Vide la mémoire tempon et affecte le contenue dans $content
			$content = ob_get_clean();
			// Affiche la vue
			echo $content;
			// Execution de saveUrl 
			$this->saveUrl($entity, $viewFile,$param);
	}

	// Déclaration de la methode saveUrl qui sera utilisé dans tout les controleurs qui etendrons Controller, elle sert a sauvegarder l'url
	function saveUrl($ctrl,$vue,$param = null) {
		// Affectation a la variable de session url, l'url à sauvegarder
		$_SESSION['url'] = $ctrl.'/'.$vue.'/'.$param;
	}
}

 ?>