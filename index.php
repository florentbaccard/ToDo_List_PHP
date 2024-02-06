<?php
// Inclusion du fichier de connexion à la base de données
// Including the database connection file
require 'db_conn.php';
?>

<!DOCTYPE html>

<html lang="en">

   <head>

      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>To-Do List</title>
      <!-- Inclusion de la feuille de style CSS -->
      <!-- Including the CSS stylesheet -->
      <link rel="stylesheet" href="css/styles.css">

   </head>

   <body>

      <div class="main-section">
         <div class="add-section">
            <!-- Formulaire pour ajouter une tâche -->
            <!-- Form for adding a task -->
            <form action="app/add.php" method="POST" autocomplete="off">
               <?php if (isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
                  <!-- Affichage d'un message d'erreur si nécessaire -->
                  <!-- Displaying an error message if necessary -->
                  <input type="text" name="title" style="border-color: #ff6666" placeholder="This field is required" />
                  <button type="submit">Add &nbsp; <span>&#43;</span></button>

               <?php } else { ?>
                  <!-- Champ de saisie pour le titre de la tâche -->
                  <!-- Input field for the task title -->
                  <input type="text" name="title" placeholder="What do you need to do?" />
                  <button type="submit">Add &nbsp; <span>&#43;</span></button>
               <?php } ?>
            </form>
         </div>
         <?php
         // Récupération de toutes les tâches depuis la base de données
         // Retrieving all tasks from the database
         $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
         ?>
         <div class="show-todo-section">
            <?php if ($todos->rowCount() <= 0) { ?>
               <!-- Affichage si aucune tâche n'est disponible -->
               <!-- Display if no tasks are available -->
               <div class="todo-item">
                  <div class="empty">
                     <!-- Image d'illustration -->
                     <!-- Illustration image -->
                     <img src="img/todo.png" width="100%" />
                     <!-- Animation de chargement -->
                     <!-- Loading animation -->
                     <img src="img/charg.gif" width="80px">
                  </div>
               </div>
            <?php } ?>

            <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
               <!-- Affichage de chaque tâche -->
               <!-- Displaying each task -->
               <div class="todo-item">
                  <!-- Bouton de suppression de la tâche -->
                  <!-- Task removal button -->
                  <span id="<?php echo $todo['id']; ?>" class="remove-to-do">x</span>
                  <?php if ($todo['checked']) { ?>
                     <!-- Case à cocher pour indiquer l'état de la tâche -->
                     <!-- Checkbox to indicate the task state -->
                     <input type="checkbox" class="check-box" data-todo-id="<?php echo $todo['id']; ?>" checked />
                     <!-- Titre de la tâche -->
                     <!-- Task title -->
                     <h2 class="checked">
                        <?php echo $todo['title'] ?>
                     </h2>
                  <?php } else { ?>
                     <!-- Case à cocher pour indiquer l'état de la tâche -->
                     <!-- Checkbox to indicate the task state -->
                     <input type="checkbox" data-todo-id="<?php echo $todo['id']; ?>" class="check-box" />
                     <!-- Titre de la tâche -->
                     <!-- Task title -->
                     <h2>
                        <?php echo $todo['title'] ?>
                     </h2>
                  <?php } ?>
                  <br>
                  <!-- Date de création de la tâche -->
                  <!-- Date of task creation -->
                  <small>created:
                     <?php echo $todo['date_time'] ?>
                  </small>
               </div>
            <?php } ?>
         </div>
      </div>

      <!-- Inclusion du script JavaScript -->
      <!-- Including the JavaScript script -->
      <script src="js/script.js"></script>

      <script>
         $(document).ready(function () {
            $('.remove-to-do').click(function () {
               const id = $(this).attr('id');

               $.post("app/remove.php",
                  {
                     id: id
                  },
                  (data) => {
                     if (data) {
                        $(this).parent().hide(600);
                     }
                  }
               );
            });

            $(".check-box").click(function (e) {
               const id = $(this).attr('data-todo-id');

               $.post('app/check.php',
                  {
                     id: id
                  },
                  (data) => {
                     if (data != 'error') {
                        const h2 = $(this).next();
                        if (data === '1') {
                           h2.removeClass('checked');
                        } else {
                           h2.addClass('checked');
                        }
                     }
                  }
               );
            });
         });
      </script>
      
   </body>

</html>