<?php

    require_once 'connection.php';

    if (!isset($_SESSION['admin_id'])) {
        header('location: index.php');
        exit();
    }

    // Promenljive za select opcije
    $sql = "SELECT members.*, 
                    training_plans.name AS training_plan_name, 
                    trainers.first_name AS trainer_name,
                    trainers.last_name AS trainer_lastname
                    FROM members
                    LEFT JOIN training_plans ON members.training_plan_id = training_plans.plan_id
                    LEFT JOIN trainers ON members.trainer_id = trainers.trainer_id
                    ;";
    $run = $connection -> query($sql);
    $results = $run -> fetch_all(MYSQLI_ASSOC);
    $select_members = $results;

    $sql = "SELECT * FROM trainers";
    $run = $connection -> query($sql);
    $results = $run -> fetch_all(MYSQLI_ASSOC);
    $select_trainers = $results;

?>

<!doctype html>
<html>
  <head>
    <title>Gym</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
  </head>

  <body>

  <?php if (isset($_SESSION['success_message'])) : ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo $_SESSION['success_message']; 
           unset($_SESSION['success_message']);
    ?>
    <button type = "button" class= "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden="true">&times;</span></button>
  </div>
  <?php endif; ?>

  <h1 style = "text-align: center; margin: 30px">WELCOME BACK</h1><hr>                
  <a href="logout.php" class="btn float-right" style="background-color: #0A1737; color: white;">Log Out</a>

  <div class = "container">
    <div class = "row mb-5">
        <div class = "col-md-6">
          <h2>Register Member</h2>
          <form action = "register_member.php" method = "POST" enctype="multipart/form-data">
            First Name: <input class = "form-control" type = "text" name = "first_name"><br>
            Last Name: <input class = "form-control" type = "text" name = "last_name"><br>
            Email: <input class = "form-control" type = "email" name = "email"><br>
            Phone Number: <input class = "form-control" type = "text" name = "phone"><br>
            Training Plan:
            <select class = "form-control" name = "training_plan_id">
              <option value = "" disabled> Training Plan</option>
              <?php
                $sql = "SELECT * FROM training_plans";
                $run = $connection -> query($sql);
                $results = $run -> fetch_all(MYSQLI_ASSOC);

                foreach ($results as $result) {
                  echo "<option value = '" . $result['plan_id'] . "'>" . $result['name']  . " </option>";
                }
              ?></select><br>
            Trainer:
            <select name = "trainer" class = "form-control">
            <option value = "Without trainer">Without trainer</option>
                      <?php 
                        foreach($select_trainers as $trainer) : ?>
                          <option value = " <?php echo $trainer['trainer_id']; ?> ">
                            <?php echo $trainer['first_name'] . " " .  $trainer['last_name']; ?>
                          </option>
                      <?php endforeach; ?>
                </select><br>
            <input type = "hidden" name = "photo_path" id = "photoPathInput">
            <div id = "dropzone-upload" class = "dropzone"></div>
            
            <input class = "btn btn-secondary mt-3" type = "submit" value = "Register Member">
          </form>
        </div>

        <div class="col-md-6">
          <h2>Register Trainer</h2>
          <form action = "register_trainer.php" method = "POST">
            First Name: <input class = "form-control" type = "text" name = "first_name"><br>
            Last Name: <input class = "form-control" type = "text" name = "last_name"><br>
            Email: <input class = "form-control" type = "email" name = "email"><br>
            Phone Number: <input class = "form-control" type = "text" name = "phone"><br>
            <input class = "btn btn-secondary mt-3" type = "submit" value = "Register Trainer">
          </form><br><br>

          <h2>Assing Trainer to Member</h2>
          <form action = "assign_trainer.php" method = "POST">
                <label for = "">Select Member</label>
                <select name = "member" class = "form-control">
                  <?php 
                    foreach($select_members as $member) : ?>
                    <option value = "<?php echo $member['member_id'] ?>" >
                      <?php echo $member['first_name'] . " " . $member['last_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              <br>
                <label for = "">Select Trainer</label>
                <select name = "trainer" class = "form-control">
                      <?php 
                        foreach($select_trainers as $trainer) : ?>
                          <option value = " <?php echo $trainer['trainer_id']; ?> ">
                            <?php echo $trainer['first_name'] . " " .  $trainer['last_name']; ?>
                          </option>
                      <?php endforeach; ?>
                </select>
                <br>
                <button type = "submit" class = "btn btn-secondary">Assign Trainer</button>
          </form>
        </div>
      </div>
      <hr>
       <div class = "row">
          <div class = "col-md-12">
              <h2>Member List <a href = "export.php?what=members" class = "btn" style="background-color: #0A1737; color: white;">Export</a></h2>

              <table class = "table table-striped">
                <thead>
                  <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Trainer</th>
                    <th>Photo</th>
                    <th>Training Plan</th>
                    <th>Access Card</th>
                    <th>Created at</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT members.*, 
                    training_plans.name AS training_plan_name, 
                    trainers.first_name AS trainer_name,
                    trainers.last_name AS trainer_lastname
                    FROM members
                    LEFT JOIN training_plans ON members.training_plan_id = training_plans.plan_id
                    LEFT JOIN trainers ON members.trainer_id = trainers.trainer_id
                    ;";
                    $run = $connection -> query($sql);
                    $results = $run -> fetch_all(MYSQLI_ASSOC);
                    $select_members = $results;

                    foreach ($results as $result) : ?>
                      <tr>
                        <td><?php echo $result['first_name']; ?></td>
                        <td><?php echo $result['last_name']; ?></td>
                        <td><?php echo $result['email']; ?></td>
                        <td><?php echo $result['phone']; ?></td>
                        <td><?php 
                          if ($result['trainer_name']) {
                            echo $result['trainer_name'] . " " . $result['trainer_lastname'] ;    
                          } else {
                            echo 'Without plan';
                          }
                         ?></td>
                        <td><img src="<?php echo $result['photo_path']; ?>" style="width: 60px;"></td>
                        <td><?php 
                          if ($result['training_plan_name']) {
                            echo $result['training_plan_name'];    
                          } else {
                            echo 'Without plan';
                          }
                         ?></td>
                        <td><a href = "<?php echo $result['access_card_pdf_path'];  ?>">Access Card</td>
                        <td><?php echo $result['created_at']; ?></td>
                        <form action = "delete_member.php" method = "POST">
                          <input type = "hidden" name = "member_id" value = "<?php echo $result['member_id']; ?>">
                          <td><button type = "submit">Delete</button></td>
                        </form>
                      </tr>
                    <?php endforeach; ?>
                </tbody>
              </table>
          </div>
          
          <div class = "col-md-12">
          <hr><h2>Trainers List <a href = "export.php?what=trainers" class = "btn" style="background-color: #0A1737; color: white;">Export</a></h2>
            <table class = "table table-striped">
                <thead>
                  <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM trainers";
                    $run = $connection -> query($sql);
                    $results = $run -> fetch_all(MYSQLI_ASSOC);
                    $select_trainers = $results;

                    foreach ($results as $result) : ?>
                      <tr>
                        <td><?php echo $result['first_name']; ?></td>
                        <td><?php echo $result['last_name']; ?></td>
                        <td><?php echo $result['email']; ?></td>
                        <td><?php echo $result['phone']; ?></td>
                        <form action = "delete_trainer.php" method = "POST">
                          <input type = "hidden" name = "trainer_id" value = "<?php echo $result['trainer_id']; ?>">
                          <td><button type = "submit">Delete</button></td>
                        </form>
                      </tr>
                    <?php endforeach; ?>
                </tbody>
              </table>
          </div>
          <hr>
       </div>
    </div>

    <?php $connection -> close(); ?>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- prekucan kod  -->
    <script>
      Dropzone.options.dropzoneUpload = {
        url: "upload_photo.php",
        paramName: "photo",
        maxFilesize: 20 * 1024 * 1024,
        acceptedFilesize: "image/*",
        init: function () {
          this.on("success", function(file, response) {
            const jsonResponse = JSON.parse(response);
            if (jsonResponse.success) {
              document.getElementById('photoPathInput').value = jsonResponse.photo_path;
            } else {
              console.error(jsonResponse.error);
            }
          });
        }
      }
    </script>

  </body>
</html>