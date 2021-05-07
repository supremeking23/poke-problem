<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <style>
      fieldset{
        background-color: #dcdcdc;
        padding: 20px;
      }

      legend {
        background-color: #2c2d2f;
        color: white;
        padding: 5px 10px;
        width: 50%;
      }
    </style>
    <title>Login / Registration</title>
  </head>
  <body>
    <!-- As a heading -->
    <nav class="navbar navbar-dark bg-danger">
      <span class="navbar-brand mb-0 h1">Welcome!</span>
    </nav>
      
    <div class="container mt-5">
     

      <div class="row">
        <div class="col-md-12">
<?php if($this->session->has_userdata("errors")):?>
          <div class="alert alert-danger">
            <h3><?= $this->session->userdata("error-type");?></h3>
            <p>Please fix the following errors:</p>
<?= $this->session->userdata("errors");?>
          </div>
<?php endif; ?>
<?= $this->session->userdata("add-user-success");?>
        </div>
      </div>


      <div class="row">
        <div class="col-md-6">
<?= form_open("pokes/register_process");?>
            <fieldset>
                <legend>Register:</legend>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="">
                </div>

                <div class="form-group">
                    <label for="alias">Alias</label>
                    <input type="text" class="form-control" id="alias" name="alias" placeholder="">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="">
                </div>
              
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Pasword">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Password Confirmation</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="">
                </div>

                <div class="form-group">
                    <label for="date">Date of Birth</label>
                    <input type="date" class="form-control" id="date" name="date" placeholder="">
                </div>
                
                <button type="submit" class="btn btn-primary float-right">Register</button>
            </fieldset>
          </form>
        </div>

        <div class="col-md-6">
<?= form_open("pokes/login_process");?>
            <fieldset>
                <legend>Login:</legend>
              
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="">
                </div>
               
                <button type="submit" class="btn btn-primary float-right">Login</button>
                
            </fieldset>
          </form>
        </div>

      </div>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

  </body>
</html>