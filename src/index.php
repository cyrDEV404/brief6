<?php
    include("header.php");
    include("pdo.php");

    $result = $pdo->query("SELECT * FROM favori ORDER BY favori.date_creation DESC");
    $favoris = $result->fetchAll(PDO::FETCH_ASSOC); 


    $result = $pdo->query("SELECT * FROM domaine ");
    $domaines = $result->fetchAll(PDO::FETCH_ASSOC); 


    $result = $pdo->query("SELECT * FROM categorie");
    $categories = $result->fetchAll(PDO::FETCH_ASSOC); 

    

        
      // Affichage (SELECT) :
      if(!empty($_GET['search'])){
        $result = $pdo->query("SELECT domaine.nom_domaine, favori.libelle, favori.url, favori.date_creation, favori.id_favori FROM favori INNER JOIN domaine ON favori.id_dom = domaine.id_domaine WHERE libelle LIKE '%".$_GET['search']."%' OR nom_domaine LIKE '%".$_GET['search']."%' OR url LIKE '%".$_GET['search']."%'");
      } else{
          if(isset($_GET['categorie'],$_GET['categorie']) && $_GET['categorie'] !== "none" && $_GET['domaine'] !== "none"){
              $result = $pdo->query("SELECT * FROM favori INNER JOIN favori_categorie ON favori.id_favori = favori_categorie.id_favori INNER JOIN domaine ON favori.id_dom=domaine.id_domaine INNER JOIN categorie ON favori_categorie.id_categorie=categorie.id_categorie WHERE categorie.id_categorie=".$_GET['categorie']." AND domaine.id_domaine=".$_GET['domaine'].";");
           }else{
              if(isset($_GET['domaine']) && $_GET['domaine'] !== "none" && $_GET['categorie'] == "none"){
                  $result = $pdo->query("SELECT * FROM favori INNER JOIN domaine ON favori.id_dom=domaine.id_domaine WHERE domaine.id_domaine=".$_GET['domaine']." ORDER BY id_favori ASC;");
          }else{
              if(isset($_GET['categorie']) && $_GET['categorie'] !== "none" && $_GET['domaine'] == "none"){
                  $result = $pdo->query("SELECT * FROM favori INNER JOIN favori_categorie ON favori.id_favori=favori_categorie.id_favori INNER JOIN domaine ON favori.id_dom=domaine.id_domaine INNER JOIN categorie ON favori_categorie.id_categorie=categorie.id_categorie WHERE categorie.id_categorie=".$_GET['categorie'].";");  
          }else{
            $requestsql= "SELECT * FROM favori INNER JOIN domaine ON favori.id_dom = domaine.id_domaine ORDER BY id_favori ASC";
            $result = $pdo->query($requestsql);
        }
          
        }
        }}


        
    
       

?>




    <section id="relative overflow-x-auto">
        

    <form  action="" method="GET" class="max-w-sm text-center mx-auto px-auto">
            <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select categorie</label>
                <select id="categorie" name="categorie" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="none">categorie</option>

           <?php 
                foreach($categories as $categorie){

                ?>

                    
                <option value="<?php echo $categorie['id_categorie']?>"><?php echo $categorie['nom_categorie']?></option>      


            <?php } ?>
                </select>
                
    

            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select domaine</label>
                <select id="domaine" name="domaine" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="none">Domaine</option>
                <?php 

                foreach($domaines as $domaine){

                ?>8
             
                    
             <option value="<?php echo $domaine['id_domaine']?>"><?php echo $domaine['nom_domaine']?></option>      
           
            <?php } ?>
                </select>

                <button type="submit" class="text-white   bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>

            <label class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">                
                <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Recherche par mots clé">
                <button type="submit" class="text-white  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
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
                     <i class="fa-solid fa-rotate">edit</i>
                </td>
                <td scope="row" class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-600">
                     <i class="fa-solid fa-trash-can">delete</i>
                </td>
            </tr>
        <?php
        }
        ?>
        </table>
    </section>
    
</body>
</html>