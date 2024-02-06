<?php
include("header.php");
include("pdo.php");

$result ="SELECT libelle, url FROM favori WHERE id_favori = " . $_GET["id_favori"];
$result = $pdo->query($result);
$favori = $result->fetch(PDO::FETCH_ASSOC);

$result =" SELECT * FROM categorie";
$result = $pdo->query($result);
$categories = $result->fetchAll(PDO::FETCH_ASSOC);

$result =" SELECT * FROM domaine";
$result = $pdo->query($result);
$domaines = $result->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_POST)) {
        $formup = true;
        if    (empty($_POST['libelle'])){
            $formup = false;
        }
        if    (empty($_POST['url'])){
            $formup = false;
        }

        if ($formup == true) {

        //      var_dump( $_POST);
        //    echo  $_POST['categories'];
        $req = "UPDATE favori SET libelle = '".$_POST['libelle'] . "', url = '".$_POST['url'] . "', id_dom = ".$_POST['domaines'] . "  WHERE id_favori = " . $_GET['id_favori'];
                $result = $pdo->query($req);

        $updatecatfav = "DELETE FROM favori_categorie WHERE id_favori =  " . $_GET['id_favori'];
                $result = $pdo->query($updatecatfav);

        $cat_favup = "INSERT INTO favori_categorie VALUES (". $_GET['id_favori'] ." , ". $_POST['categories'].");";
                $pdo->query($cat_favup);
        header('Location: index.php');


        }

}

 ?>
<form action="" method="post" class="flex  flex-col text-center mw-auto">
  
        <label class="mb-3" for="libelle">Modifier le libelee</label>
        <input value="<?php echo $favori['libelle']?>" type="text" name="libelle" id="libelle" require class="block  mx-auto w-96 text-center p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

        <label class="mb-2" for="url"> Modifier l'url: </label>
        <input   class="block mx-auto w-96 text-center p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo $favori['url']?>" type="text" name="url" id="url" require/>
        
        <select class="block mx-auto w-1/2 text-center" name="categories" id="categorie">
        <option value=""disabled selected >Choisir une Categorie</option>
            <?php
            
            foreach ($categories as $categorie) {
              
                ?> 
                   
                    <option value="<?php echo $categorie['id_categorie'] ?>"><?php echo $categorie['nom_categorie'] ?></option>
                <?php       
                }   
                
                ?>
        </select>
        <select class="block mx-auto w-1/2 text-center" name="domaines" id="domaine">
        <option value="" disabled selected >Choisir un Domaine</option>

            <?php
            foreach ($domaines as $dom) {
                
                ?>
                    <option value="<?php echo $dom['id_domaine'] ?>"><?php echo $dom['nom_domaine'] ?></option>
                <?php       
                }   
                
                ?>
        </select>

        
        <button type="submit" value="modifier">Modifier</button>

</form>