<?php

if($findInstrument == "true") {
    $leadText = 'What Instrument are you looking for?';
    $buttonText = 'Search for this Instrument';
    $textBoxText = 'Please enter an Instrument Name';
    $labelText = 'Instrument Search: ';
    $errorMessage = $instrumentErr;

    echo <<<_END



<div class="container-fluid bg-light">
  <div class="row">
    <div class="col-md-6">
    <h3 class='display-5 mt-4' >$leadText</h3>
      <form class="form-group  pt-3 pb-3" action='displaySearchType.php' method='post'>
         <label class="" for="searchBoxGeneral">$labelText</label>
         <input class="form-control" type="text" id="searchBoxGeneral" name="" placeholder="$textBoxText" /><br/>
         <ul id="instArray"></ul>
         <input class="btn btn-secondary" type='submit' value='$buttonText'/>
      </form>
    </div> <!-- end col -->
  </div> <!-- end row -->
</div> <!-- container -->

_END;

