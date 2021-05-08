<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Pokes</title>
    <style>
        nav a {
            color:#fff;
        }

        .people-poke-you{
            padding:10px;
            border:1px solid #333
        }

        ul li {
            list-style-type:none;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function(){
            $.get(`pokes/poke_ajax`,function(res){
                $(".user-list").html(res);
            });

            $(document).on('submit','form',function(){
                // alert("submit");
                $.post($(this).attr("action"),$(this).serialize(),function(res){
                    $(".user-list").html(res);
                });
                return false;
            });
        });
    </script>


  </head>
  <body>
    <!-- As a heading -->
    <nav class="navbar navbar-dark bg-danger">
        <span class="navbar-brand mb-0 h1">Welcome!, <?= $this->session->userdata("alias")?></span>
        <a href="<?= base_url();?>/logout">Logout</a>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
               <h4> <?= $number_of_people_who_poke_you['poke_count']; ?> people poke you</h4>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4 people-poke-you">
                <ul>
<?php foreach($get_all_user_who_poke_you as $users):?>
                    <li><?= $users["name"]?> poked you <?= $users["n_poke"]?>  times</li>
<?php endforeach;?>
                </ul>

            </div>
        </div>


        <div class="row mt-5">
            <div class="col-md-12">
                <h4>People you might wanna poke</h4>
            </div>

            <div class="col-md-12">

                <table class="table">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Alias</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Poke History</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="user-list">

                    </tbody>
                </table>
            </div>
        </div>

    </div>


  </body>
</html>