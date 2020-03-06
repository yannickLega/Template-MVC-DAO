<?php 
  // déclaration de constantes
	define('DB_HOST', 'localhost');
	define('DB_NAME', '');
	define('DB_USER', 'root');
	define('DB_PASS', '');


// Déclaration de l'objet DB
class DB {
  // Attibut statique (qui peut etre utilisé sans intancier l'objet, pas besoin de new DB)
  private static $db;
  
  // déclaration de la fonction statique connect
  public static function connect(){
        // Si l'attribut statique $db de cette objet (self) est vide, self:: sert à ciblé un element statique d'un objet
        if(empty(self::$db)){
            // affectation a l'attribut $db de l'intanciation de l'objet PDO hydraté avec les paramètres de connexion.  
            self::$db = new PDO(
            "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", 
            DB_USER, DB_PASS, [
              // paramètre pour affiher les erreur en lien avec la bdd
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              // paramètre pour retourner un tableau associatif lors du fetch
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
              // paramètre pour desactiver l'emulation des requêtes préparés
              PDO::ATTR_EMULATE_PREPARES => false,
            ]
          );  
        }
        return self::$db;
    }

    // Declaration de la methode statique select qui prend 2 arguments, une requete sql et un tableau de paramètre (qui peut etre null)
  public static function select($sql, $param=null) {
    $result = false;
    try {
      // préparation de la requête avec le paramètre $sql
      $request = self::connect()->prepare($sql);
      // execution de la requête avec le paramètre $param
      $request->execute($param);
      // fetchAll sur la requête pour organiser les résultats en tableau à 2 dimensions
      $result = $request->fetchAll();
      // catch des erreurs avec arret et affichage des erreurs
    } catch (PDOException $ex) { die($ex->getMessage()); }
      $request = null;
    return $result;
  }
  // Déclaration de la methode lastId qui retourne le dernier id inséré dans la bdd
  public static function lastId() {
    return self::connect()->lastInsertId();
  }

 
}
 ?>