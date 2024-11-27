<?php 
require "connexion.php";
 ?>

<?php 
    if (isset($_POST['ajouter'])) {
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $ville=$_POST['ville'];
        $age=$_POST['age'];
        $email=$_POST['email'];

        $q=$cnt->prepare("INSERT INTO personnel (nom,prenom,ville,age,email) value(?,?,?,?,?)");
        $q->execute(array($nom,$prenom,$ville,$age,$email));
     
      
        header("Refresh:3; url=formulaire.php");
        echo' <div class="alert alert-info"> Contacte enregistere avec succès </div>  ';  
    }
 ?>


<?php 
                require "connexion.php";

                if (isset($_POST['supprimer'])) {
                    $idgrud=$_POST['idgrud'];

                    $q=$cnt->prepare("delete from personnel where idgrud=?");
                    $q->execute(array($idgrud));
                    header("Refresh:3");
                    echo '<div class="alert alert-success">information supprimé ...</div>';
                }
                if (isset($_POST['update'])) {
                    $idgrud=$_POST['idgrud'];
                    $nom=$_POST['nom'];
                    $prenom=$_POST['prenom'];
                    $ville=$_POST['ville'];
                    $age=$_POST['age'];
                    $email=$_POST['email'];

                    $q=$cnt->prepare("update personnel set nom=?,prenom=?,ville=?,age=?,email=? where idgrud=?");
                    $q->execute(array($nom,$prenom,$ville,$age,$email,$idgrud));
                  

                    header("Refresh:1");
                    echo '<div class="alert alert-success">information modifié ...</div>';
                }
       ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>formulaire</title>
</head>

<body>
    <div class="container col-md-12">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <br>
                <h3 class="text-center">FORMULAIRE DES PERSONNELS DE L'ENTREPRISE</h3>
                <hr>
            </div>
            <div class="row">


                <div class="col-md-8">
                    <h3 class="text-center">Afficher les données de la BD</h3>
                    <hr>

                    <table class="table table-border">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Ville</th>
                                <th>Age</th>
                                <th>Email</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php 
                              $q=$cnt->prepare("SELECT idgrud,nom,prenom,ville,age,email FROM personnel order by idgrud desc");
                              $q->execute();
                              while ($d=$q->fetch()) {
                                
                              
                        ?>
                            <tr>
                                <td>
                                    <?php echo $d['nom'] ?>
                                </td>
                                <td>
                                    <?php echo $d['prenom'] ?>
                                </td>
                                <td>
                                    <?php echo $d['ville'] ?>
                                </td>
                                <td>
                                    <?php echo $d['age'] ?>
                                </td>
                                <td>
                                    <?php echo $d['email'] ?>
                                </td>
                                <td>
                                    <form action="" method="POST">
                                    <input type="hidden" name="id_mod" value=" <?php echo $d['idgrud'] ?>">
                                        <input type="submit" name="modifier" value="MODIFIER"
                                            class="btn btn-info btn-sm text-white">
                                    </form>
                                </td>
                                <td>
                                    <form action="" method="POST"
                                        onsubmit="return confirm('Voulez-vous supprimer ce champ')">
                                        <input type="hidden" name="idgrud" value=" <?php echo $d['idgrud'] ?>">
                                        <input type="submit" name="supprimer" value="SUPPRIMER" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                            <?php 
      }
     ?>
                        </tbody>
                    </table>
                </div>



                <?php

             
                if (isset($_POST['modifier'])) {
                    $id=$_POST["id_mod"];
                    $q=$cnt->prepare("SELECT nom,prenom,ville,age,email,idgrud FROM personnel where idgrud=? order by idgrud desc");
                    $q->execute(array($id));
                    $d=$q->fetch();
                    
                   
                     
                ?>

                <div class="col-md-4">
                    <h3 class="text-center">Ajouter des personnels</h3>
                    <hr>
                    <form action="" method="POST">
                        <input type="hidden" name="idgrud" value="<?php echo $d['idgrud'] ?>">
                        <div class="form-group">
                            <label>Nom :</label>
                            <input type="text" name="nom" placeholder="votre nom" value="<?php echo $d['nom'] ?>"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>prénom :</label>
                            <input type="text" name="prenom" placeholder="votre prenom"
                                value="<?php echo $d['prenom'] ?>" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Ville :</label>
                            <input type="text" name="ville" placeholder="votre ville" value="<?php echo $d['ville'] ?>"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Age :</label>
                            <input type="number" name="age" placeholder="votre age" value="<?php echo $d['age'] ?>"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Email :</label>
                            <input type="text" name="email" placeholder="votre email" value="<?php echo $d['email'] ?>"
                                class="form-control">
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="submit" name="update" value="Enregister la modification"
                                class="btn  btn-primary btn-block">
                        </div>
                    </form>
                </div>

       

                <?php   
            }

            else {
         ?>

                <div class="col-md-4">
                    <h3 class="text-center">Ajouter des personnels</h3>
                    <hr>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>Nom :</label>
                            <input type="text" name="nom" placeholder="votre nom" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>prénom :</label>
                            <input type="text" name="prenom" placeholder="votre prenom" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Ville :</label>
                            <input type="text" name="ville" placeholder="votre ville" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Age :</label>
                            <input type="number" name="age" placeholder="votre age" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Email :</label>
                            <input type="text" name="email" placeholder="votre email" class="form-control">
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="submit" name="ajouter" value="Enregister" class="btn  btn-primary btn-block">
                        </div>
                    </form>
                </div>
                <?php   
            }
         ?>


            </div>

        </div>
    </div>



</body>

</html>