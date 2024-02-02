<?php 
include("header.php");
include("pdo.php"); 


if (!empty($_POST)){
    $formulaire_soumis = true;
}else{
    $formulaire_soumis = false;
   
}
 if (!empty($_POST['saisie_libelle'])){
        $valeur_du_libelle = htmlspecialchars($_POST['saisie_libelle']);
    }else{
        $valeur_du_libelle = "";
    }
    if (!empty($_POST['saisie_url'])){
        $valeur_du_url = htmlspecialchars($_POST['saisie_url']);
    }else{
        $valeur_du_url = "";
    }
    if (!empty($_POST['saisie_nom_domaine'])){
        $presence_nom_domaine = true;
        $id_dom =  htmlspecialchars($_POST['saisie_nom_domaine']);
    }else{
        $presence_nom_domaine = false;
    }


$saisie_table_id_categorie = array();
$presence_categorie_cocher = false;

$Requete_SQL = "SELECT count(id_categorie) as nomb_categorie FROM categorie";
    
$result =  $pdo->query($Requete_SQL);
$nomb_categorie = $result->fetch(PDO::FETCH_ASSOC);

if ($formulaire_soumis == true){

    $formulaireValide = true;

    

    $Requete_SQL = "SELECT count(id_categorie) as nomb_categorie FROM categorie";
    
    $result =  $pdo->query($Requete_SQL);
    $nomb_categorie = $result->fetch(PDO::FETCH_ASSOC);
    
        $index_id_cat =0;
        for ($index = 1 ; $index <= $nomb_categorie['nomb_categorie']; $index++){
            if (!empty($_POST['saisie_categorie_n°'.$index])){
            $saisie_table_id_categorie[$index_id_cat] = $index;
            $index_id_cat = $index_id_cat + 1 ;

            };
        };


        print_r( $saisie_table_id_categorie);
        if (count($saisie_table_id_categorie) == 0 ){
            $formulaireValide = false;
            $erreur_categorie = "Il faut sélectionner au moins une catégorie. Ceci est obligatoire";
           
        }else{
          $erreur_categorie = "";
          $presence_categorie_cocher = true ;
        }

        
        if (!empty($_POST['saisie_libelle'])){
            if (strlen($_POST['saisie_libelle']) > 100){
                $erreur_libelle = "Le libelle ne doit pas exéder 100 caractères";
                $formulaireValide = false;
            }else{
                 $libelle =  htmlspecialchars($_POST['saisie_libelle']);
            }
        }else{
            $erreur_libelle = "Veuillez écrire un libéllé , ce champs est obligatoire";
            $formulaireValide = false;
        };


       


        if (!empty($_POST['saisie_url'])){
            $erreur_url = "";
            if (strlen($_POST['saisie_url']) > 1000){
                $erreur_url = "L' URL ne doit pas exéder 1000 caractères";
                $formulaireValide = false;
            }else{
               
                $url =  htmlspecialchars($_POST['saisie_url']);
            }
        }else{
            $erreur_url = "L'url est un champs obligatoire Veuillez saisir un lien";
            $formulaireValide = false;
        }

        $date = date("Y-m-d");

        $domaine="";
        if (!empty($_POST['saisie_nom_domaine'])){
            $domaine = intval($_POST['saisie_nom_domaine']);
            echo gettype($domaine);
            $erreur_nom_dom ="";
        }else{
            $erreur_nom_dom = "Veuillez choisir un domaine dans la liste déroulante ce champs est obligatoire";
            $formulaireValide = false;
        };




        if ($formulaireValide == true){

            echo "VRAI §§§";

            $Requete_SQL_Preparation = "INSERT INTO favori VALUES ('',:libelle,:date,:url,:domaine)";

            $Requete_prete = $pdo->prepare($Requete_SQL_Preparation);

            $Tableau_parametre = array(
                ':libelle' => $libelle,
                ':date' => $date,
                ':url' => $url,
                ':domaine' => $domaine );


            $Requete_prete->execute($Tableau_parametre);
            /**$Requete_SQL = "INSERT INTO favori VALUES ('','".$libelle."','".$date."','".$url."',".$domaine.")";
            echo $Requete_SQL;
            $pdo->query($Requete_SQL);*/
        
            $dernier_id = $pdo -> lastInsertId();

            for ($index = 0 ; $index < count($saisie_table_id_categorie); $index++){
                $Requete_SQL_preparation = " INSERT INTO favori_categorie VALUES (:dernier_id,:id_categorie_assosier)";

                $RequetePreparer = $pdo->prepare($Requete_SQL_preparation);

                $Tableau_parametre = array(
                    ':dernier_id' => $dernier_id,
                    'id_categorie_assosier' => $saisie_table_id_categorie[$index]
                );


                $RequetePreparer -> execute($Tableau_parametre);
            }



           /**  for ($index = 0 ; $index < count($saisie_table_id_categorie); $index++){
               * $Requete_SQL = " INSERT INTO favori_categorie VALUES ('".$dernier_id."','".$saisie_table_id_categorie[$index]."')";
               * $pdo->query($Requete_SQL);
            *}
            */


            header('Location: index.php');

        }else{
            echo "faux";
        }
       

}





    /**function VerificationObligatoire($nom_du_champ){
        if (!empty($_POST($nom_du_champ))){
            $nom_du_champ = $_POST($nom_du_champ
        }else{
            $erreur
        }
    }*/

   




?>



<form action="" method="POST">
    
<div class="mx-8">
<div class="rounded-md mt-20 ml-20">
        <a href="insert.php" aria-current="page" class="px-4 py-2 text-3xl font-extrabold leading-none tracking-tight text-gray-900 text-blue-700 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
            Refresh
        </a>

        <a href="index.php" class="px-4 py-2 text-3xl font-extrabold leading-none tracking-tight text-gray-900 text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
            Retour
        </a>
    </div>
            <div class="flex ">
                <div class="w-1/4  h-max flex justify-between border-b font-PE_libre_baskerville_italique border-black p-4 font-bold items-center"><p>ID du favori </p><i class="flex justify-center items-center text-red-600  fa-solid fa-lock"></i></div>
                <p type="text" class=" w-full pl-5 border-b  border-black flex justify-start items-center">Automatique</p>
            </div>
            <div class="flex flex-col">
                <div class="flex">
                    <div class="w-1/4 h-max flex border-b font-PE_libre_baskerville_italique border-black p-4 font-bold justify-between items-center"><p>Libelle du  favori </p><i id="champ_libelle_icone" class="fa-solid fa-pencil"></i> </div>
                    <input type="text" name="saisie_libelle" class=" w-full pl-5 border-b  border-black flex  items-center" onchange="ChangerCouleurIcone('champ_libelle')" placeholder="Entrer un nom de libelle" id="champ_libelle" value="<?php echo $valeur_du_libelle ?>"></input>
                </div>
                    <?php if (!empty($erreur_libelle) && $formulaire_soumis == true ){ ?>
                    <div class="bg-red-600 flex justify-center">
                        <?php echo $erreur_libelle ?>
                    </div>
                <?php } ?>
            </div>
            <div class="flex">
                <div class="w-1/4 h-max flex justify-between border-b font-PE_libre_baskerville_italique items-center border-black p-4 font-bold"><p>Date de création </p><i class="flex justify-center items-center text-red-600  fa-solid fa-lock"></i></div>
                 <?php
                    setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                    $date = date("d-F-Y");

                 ?>
                <input type="text"  name="saisie_date_creation" disabled="disabled" class=" w-full pl-5 border-b  border-black flex items-center" value="<?php echo $date ?>"></input>
            </div>
            <div class="flex flex-col">
                <div class="flex">
                    <div class="w-1/4  h-max  border-b font-PE_libre_baskerville_italique border-black p-4 font-bold flex justify-between items-center"><p >URL </p><i id="champ_url_icone" class="fa-solid fa-pencil"></i></div>
                    <input id="champ_url" name="saisie_url" placeholder = "Entrer ou copier votre url..." class="w-full pl-5 border-b  border-black flex justify-start  items-center"  onchange="ChangerCouleurIcone('champ_url')" value ="<?php echo $valeur_du_url ?>"> </input>
                </div>
                    <?php if (!empty($erreur_url) && $formulaire_soumis == true ){ ?>
                        <div class="bg-red-600 flex justify-center">
                            <?php echo $erreur_url ?>
                        </div>
                <?php } ?>
            </div>
            <div class="flex ">
                    <div class="w-1/4  h-max flex fle  border-b font-PE_libre_baskerville_italique border-black p-4 font-bold justify-between items-center"><p>Domaine associé </p><i id="saisie_nom_domaine_icone" class="fa-solid fa-pencil"></i></div>
                        <?php 
                            $table_dom = "domaine" ;
                            $result = $pdo->query(" SELECT * 
                            FROM $table_dom 
                            ;");
                            $domaine = $result->fetchAll(PDO::FETCH_ASSOC); 
                            $numero_dom =1;
                            if ($presence_nom_domaine == true){
                                $couleur_selection = "couleur-noir-custom";
                            }else{
                                $couleur_selection = "";
                            }
                        ?> 
                        <select id="saisie_nom_domaine" name="saisie_nom_domaine" class="w-full pl-5 border-b  border-black flex items-center text-[#9caabc]">
                            <option value="" class="font-PE_libre_baskerville text-[#9caabc]" selected>-- Veillez sélectionner un domaine (obligatoire) --</option>
                            <?php $selection_nom_dom ="" ?>
                            <?php foreach($domaine as $unDomaine) { ?>
                                <?php if ($presence_nom_domaine == true){
                                    if ($id_dom == $unDomaine['id_domaine'] ){
                                        $selection_nom_dom = "selected=selected";
                                    }else{
                                        $selection_nom_dom = "";
                                    }
                                }
                                ?>
                            
                                <option <?php echo $selection_nom_dom ?>  id="<?php echo "domaine_n°".$numero_dom ?>" class="text-black" value="<?php echo $unDomaine['id_domaine'] ?>" ><?php echo $unDomaine['nom_domaine'] ?></option>
                                <?php $numero_dom = $numero_dom + 1 ?>
                                <?php } ?>
                        </select>
                    </div>
                    <?php if ( !empty($erreur_nom_dom) && $formulaire_soumis == true ){ ?>
                        <div class="bg-red-600 flex justify-center">
                            <?php echo $erreur_nom_dom ?>
                        </div>
                    <?php } ?>
            <div class="flex ">
                <div class="w-1/4 flex  font-PE_libre_baskerville_italique items-center p-4 font-bold justify-between"><p> Catégorie associées </p><i id="categorie_icone" class="fa-solid fa-pencil"></i></div>
                <?php 
                    $table_cat = "categorie" ;
                    $result = $pdo->query(" SELECT * 
                    FROM $table_cat 
                    ;");
                    $categorie = $result->fetchAll(PDO::FETCH_ASSOC); 
                ?>
                <div class="flex flex-col w-full pl-5 border-b   items-start">  
                    <?php  $numero_cat = 1;
                        foreach($categorie as $uneCategorie) { 
                            $case_cocher = "";
                            if ($presence_categorie_cocher == true){
                                $case_cocher = "";
                                for ($index = 0 ; $index < count($saisie_table_id_categorie); $index++){
                                    if ($uneCategorie['id_categorie'] == $saisie_table_id_categorie[$index]){
                                        $case_cocher = "checked=checked";
                                    }
                                }
                            }
                            
                            
                            ?>
                        <div class="flex mr-5 "> 
                            <input <?php echo  $case_cocher ?> name="<?php echo "saisie_categorie_n°".$numero_cat ?>" value="<?php echo  $uneCategorie['id_categorie']?>" type="checkbox" id="<?php echo "categorie".$numero_cat ?>" onchange="changercouleur_categorie(<?php echo $nomb_categorie['nomb_categorie']?>)" >
                            <label id="<?php echo "Label_categorie_n°".$numero_cat ?>" class="ml-2 font-PE_libre_baskerville" for="<?php echo "categorie_n°".$numero_cat ?>"><?php echo $uneCategorie['nom_categorie'] ?></label>
                        </div>
                        <?php $numero_cat = $numero_cat + 1 ?>
                    <?php }; ?>
                    <?php if ( !empty($erreur_categorie) && $formulaire_soumis == true ){ ?>
                        <div class="bg-red-600 flex justify-center">
                            <?php echo $erreur_categorie ?>
                        </div>
                    <?php } ?>
                </div>
                </div>
            <div class="flex ">
                <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-600">
          
          

                    <button  class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="submit">
                    Ajouter un favori</i>
                    </button>
                </div>
            
            </div>
        
    </div>
    
    </div>

   
</div>

</form>


