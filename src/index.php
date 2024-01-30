<?php
    include("header.php");
    include("pdo.php");

    $result= "SELECT * FROM favori INNER JOIN domaine ON favori.id_dom = domaine.id_domaine ORDER BY id_favori ASC";
    $favori = $pdo->query($result);


    $result = $pdo->query("SELECT * FROM domaine ");
    $domaines = $result->fetchAll(PDO::FETCH_ASSOC); 


    $result = $pdo->query("SELECT * FROM categorie");
    $categories = $result->fetchAll(PDO::FETCH_ASSOC); 

    

        
      // Affichage (SELECT) :
    if(!empty($_GET['search'])){
        $result = $pdo->query("SELECT domaine.nom_domaine, favori.libelle, favori.url, favori.date_creation, favori.id_favori FROM favori INNER JOIN domaine ON favori.id_dom = domaine.id_domaine WHERE libelle LIKE '%".$_GET['search']."%' OR nom_domaine LIKE '%".$_GET['search']."%' OR url LIKE '%".$_GET['search']."%'");
        $favoris = $result->fetchAll(PDO::FETCH_ASSOC);
    }else{
        
        if(isset($_GET['categorie']) && $_GET['categorie'] !== "none" && $_GET['domaine'] !== "none"){
            echo "hello";
            $result = $pdo->query("SELECT * FROM favori INNER JOIN favori_categorie ON favori.id_favori = favori_categorie.id_favori INNER JOIN domaine ON favori.id_dom=domaine.id_domaine INNER JOIN categorie ON favori_categorie.id_categorie=categorie.id_categorie WHERE categorie.id_categorie=".$_GET['categorie']." AND domaine.id_domaine=".$_GET['domaine'].";");
            $favoris = $result->fetchAll(PDO::FETCH_ASSOC);  
        }else{
            if(isset($_GET['domaine']) && $_GET['domaine'] !== "none" && $_GET['categorie'] == "none"){
                $result = $pdo->query("SELECT * FROM favori INNER JOIN domaine ON favori.id_dom=domaine.id_domaine WHERE domaine.id_domaine=".$_GET['domaine']." ORDER BY id_favori ASC;");
                $favoris = $result->fetchAll(PDO::FETCH_ASSOC);
            }else{
                if(isset($_GET['categorie']) && $_GET['categorie'] !== "none" && $_GET['domaine'] == "none"){
                    $result = $pdo->query("SELECT * FROM favori INNER JOIN favori_categorie ON favori.id_favori=favori_categorie.id_favori INNER JOIN domaine ON favori.id_dom=domaine.id_domaine INNER JOIN categorie ON favori_categorie.id_categorie=categorie.id_categorie WHERE categorie.id_categorie=".$_GET['categorie'].";");  
                    $favoris = $result->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $requestsql= "SELECT * FROM favori INNER JOIN domaine ON favori.id_dom = domaine.id_domaine ORDER BY id_favori ASC";
                    $result = $pdo->query($requestsql);
                    $favoris = $result->fetchAll(PDO::FETCH_ASSOC);
                }
            }     
        }
    }
?>
    <section class="overflow-x-auto ">

    <div class="rounded-md mt-5 ml-20">
        <a href="insert.php" aria-current="page" class="px-4 py-2 text-3xl font-extrabold leading-none tracking-tight text-gray-900 text-blue-700 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
            Ajouter un favoris
        </a>
  
        <a href="index.php" class="px-4 py-2 text-3xl font-extrabold leading-none tracking-tight text-gray-900 text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
            Refresh
        </a>
    </div>
    
    <!-- The Modal -->
    <div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Voulez vous supprimer ?</p>
        <form action="delete.php" method="get">
             <button id="bouton_envoyer" type="submit" name="id_favori" value="" class="text-gray-900 bg-gradient-to-r from-red-200 via-red-300 to-yellow-200 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Oui</button>
        </form>
            <button id="btnClose" onclick="fermeture()"  type="button" class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Non</button>

    </div>
</div>


</div>
    <form  action="" method="GET" class="max-w-sm text-center mx-auto px-auto">
            <span  class="block mb-2 text-3xl font-extrabold leading-none tracking-tight text-gray-900 text-gray-900 dark:text-white">Select categorie</span>
                <select id="categorie" name="categorie" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="none">categorie</option>

           <?php 
                foreach($categories as $categorie){

                ?>

                    
                <option value="<?php echo $categorie['id_categorie']?>"><?php echo $categorie['nom_categorie']?></option>      


            <?php } ?>
                </select>
                
    

            <span class="block mb-2 text-3xl font-extrabold leading-none tracking-tight text-gray-900 text-gray-900 dark:text-white">Select domaine</span>
                <select id="domaine" name="domaine" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="none">Domaine</option>
                <?php 

                foreach($domaines as $domaine){

                ?>
             
                    
             <option value="<?php echo $domaine['id_domaine']?>"><?php echo $domaine['nom_domaine']?></option>      
           
            <?php } ?>
                </select>

                <button type="submit" class="text-white text-3xl  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>

            <span class="mb-2 text-3xl font-medium text-gray-900 sr-only dark:text-white">Search</span>
            <div class="relative">                
                <input type="search" name="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Recherche par libellé">
                <button type="submit" class="text-white text-3xl bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
    </form>
    
    
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 hover:bg-gray-50 dark:hover:bg-gray-600">
                    Id favoris
                </th>
                <th scope="col" class="px-6 py-3 hover:bg-gray-50 dark:hover:bg-gray-600">
                    libellé
                </th>
                <th scope="col" class="px-6 py-3 hover:bg-gray-50 dark:hover:bg-gray-600">
                    Date d'ajout
                </th>
                <th scope="col" class="px-6 py-3 hover:bg-gray-50 dark:hover:bg-gray-600">
                    lien
                </th>
          
                <th scope="col" class="px-6 py-3 hover:bg-gray-50 dark:hover:bg-gray-600">
                    update
                </th>
                <th scope="col" class="px-6 py-3 hover:bg-gray-50 dark:hover:bg-gray-600">
                    delete
                </th>
            </tr>
            
            <?php 
            $index = 1;
                foreach($favoris as $favori){
            ?>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white hover:bg-gray-50 dark:hover:bg-gray-600">
                    <?=$favori['id_favori']; ?>
                </td>
                
                <td scope="row" class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <?=$favori['libelle']; ?>
                </td>
                <td scope="row" class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <?=$favori['date_creation']; ?>
                </td>
                <td scope="row" class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <?=$favori['url']; ?>
                </td>
        
                <td scope="row" class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-600">                                    
                    <button name="actiondelete" value="actiondelete" data-modal-target="popup-modal" data-modal-toggle="popup-modal" onClick="ConfirmDelete();" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="submit">
                        <i  class="fa-solid fa-trash-can">Edit</i>
                    </button>
                </td>


                
                <td scope="row" class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-600">                                    
                    <button onclick="afficher_modal(<?php echo $favori['id_favori']?>)" id="myBtn<?php echo $favori['id_favori']?>" name="actiondelete" value="<?php echo $favori['id_favori']?>" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="submit">
                        <i  class="fa-solid fa-trash-can">Delete</i>
                    </button>
                </td>
            </tr>
        <?php
        $index = $index++;
        }
        ?>
        </table>
    </section>
    
</body>
</html>