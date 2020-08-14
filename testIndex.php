<!-- Catalogit -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css"> 
<!-- Catalogit -->

  <title>Bootstrap</title>
</head>

<body>
  <!--
  <nav class="mb-3 navbar navbar-expand-sm navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li class="nav-item">
          <li>
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </nav> -->

    <!-- NAVBAR WITH RESPONSIVE TOGGLE -->
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">
          <a class="navbar-brand"  href="#"><img class="img-responsive" src="images/crudelogo3.png"></a>
          <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Searchit</a>
            </li class="nav-item">
            <li>
              <a class="nav-link" href="#">Catalogit</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Aboutit</a>
            </li>
            <li>
              <a class="nav-link" href="#">Contactit</a>
            </li>
          </ul>
        </div>  <!-- navbar-collapse -->
        </div> <!-- container -->
      </nav>
   <div class="container mt-5 mb-5" >
    
    <h4>Welcome to Catalogit! </h4>
    <ul class="list-group list-group-flush mb-5">
      <li class="list-group-item">Organize your music books, sheet music and anthologies </li>
      <li class="list-group-item" >Easily search for composers, compositions, arrangements, difficulty levels and more </li>
      <li class="list-group-item" >Don't wonder what's in your collection anymore. Look it up and findit! </li>
    </ul>
    <form action="index.php">

      <div class="row" >  
        <div class="form-group col-xs-3 mb-0 mt-3">
          <label for="firstname">         : </label>
          <input type="text" class="form-control" id="firstname" placeholder="Your first Name"><br>
        </div> <!-- form-group -->
      </div>  <!-- row -->

      <div class="row" >  
        <div class="form-group col-xs-3">
          <label for="lastname">Last Name: </label>
          <input type="text" class="form-control mb-0" id="lastname" placeholder="Your last name"><br>
        </div>  <!-- form-group -->
      </div>  <!-- row -->

      <div class="row" >  
        <div class="form-group col-xs-3">     
          <button type="button" class="btn btn-secondary ">Secondary</button><br><br>
        </div>  <!-- form-group -->
      </div>  <!-- row -->
      
   


      <div class="row" >  
        <div class="form-check col-xs-3" id="keysig">
    
          <label for="keysig">Key Signature: </label><br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check13" value="13">F Major<br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check14" value="14">a minor<br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check15" value="15">e minor<br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check16" value="16">b minor<br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check17" value="17">f# minor<br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check18" value="18">c# minor<br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check19" value="19">g# minor<br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check20" value="20">eb minor<br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check21" value="21">bb minor<br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check22" value="22">f minor<br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check23" value="23">c minor<br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check24" value="24">g minor<br>

          <input class="form-check-input" type="checkbox" name="postKeySigID[]"  id="check25" value="25">d minor<br>

        </div>  <!-- form-check -->
      </div> <!-- row -->
    </form>
  </div>




<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>