<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END
  
   <p>contact - 30</p>
   
_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

echo <<<_END

<div class="jumbotron-fluid bg-light pt-3 pb-4">
  <h1 class="text-center display-4">Contact-it!</h1>     
  
  <h3 class=" text-center">Please contact us with update suggestions, errors found and best of all, Reasons you love Catalogit Music library!<h3/p>
</div> <!-- end jumbotron-->


_END;



include 'footer.html';

include 'endingBoilerplate.php';
  ?>