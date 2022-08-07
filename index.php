<?php
echo ''
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="text/javascript"
            src=
"https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
  </script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <title>CRUD</title>
</head>
<body>
<?php require_once 'process.php';?>
<?php
// (session) verifier si le message de session à été ajouté et ensuite l'afficher sur une div bootstrap
if(isset($_SESSION['message'])): ?>
<div class="alert alert-<?=$_SESSION['msg_type']?>">
<?php
echo $_SESSION ['message'];
unset($_SESSION['message']);
?>
</div>
<?php endif ?>
<div class="container">
  <?php
  //afficher les données de la base de donées en form d'arrays sur le navigateur */
  $mysqli = new mysqli('localhost','root','root','crud') or die (mysqli_error($mysqli));
  // selectionner tous les elements de la table à afficher
  $result = $mysqli->query("SELECT* FROM data") or die($mysqli->error);
  ?>

  <div class=" row justify-content-center">
    <table class="table">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Adresse</th>
          <th colpan="2">Action</th>
        </tr>
      </thead>
      <?php
      // tous les elements de la table data seront afficher dans la table grace à fetch_assoc 
      while($row = $result->fetch_assoc()): ?>
      
      <tr>
        <td><?php echo $row['nom'];?></td>
        <td><?php echo $row['adresse'];?></td>
        <td>
          <a href="index.php?edit=<?php echo $row['id']; ?>"
          class="btn btn-info">Edit</a>
          <a href="index.php?delete=<?php echo $row['id']; ?>"
          class="btn btn-danger">Delete</a>
        </td>
        
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
<?php
  function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
  }
  
  ?>
  <div class="row justify-content-center">
  <form action="process.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="form-group">
    <label> nom </label>
    <input type="text" name="nom" class="form-control" value="<?php echo $nom; ?>" placeholder="entrez votre nom">
</div>
<div class="form-group">
    <label> Adresse </label>
    <input type="text" name="adresse" value ="<?php echo $adresse; ?>" class="form-control" placeholder="entrez votre adresse">
    </div>
    <div class="form-group">
      <?php
      // changement du button edit en update pour modifier les valeurs 
      if ($update == true):
      ?>
      <button type="submit" class="btn btn-info"name="UPDATE">Update</button>
      <?php else: ?>
    <button type="submit" class="btn btn-primary"name="ENVOYER">Envoyer</button>
    <?php endif; ?>
    </div>
  </form>
  </div>
  </div>
</body>
</html>