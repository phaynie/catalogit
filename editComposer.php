<?php
include 'boilerplate.php';
/*Not Current. Edit composer is done from  editComposition.php at addPeople.php*/
if($debug) {
    echo <<<_END

<p>editComposer-29</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

 /*From pg19  make form pre-populate*/

echo <<<_END
<div class="form-style-10">
  <h2></h2>
  <form action='composerOptions.php' method='post'>
   <div class="section">
    First Name: <input type="text" name="firstName"/><br/>
    Middle Name: <input type="text" name="middleName"/><br/>
    Last Name: <input type="text" name="lastName"/><br/>
    Suffix: <input type="text" name="suffix"/><br/>
   </div>
  <div class="button-section">
    <input type='submit' value='Continue'/>
   </div>
  </form>
</div>

_END;

include 'footer.html';
include 'endingBoilerplate.php';

?>




