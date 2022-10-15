<?php
include 'boilerplate.php';
if($debug) {
    echo <<<_END
  
    <p>about-it - 38</p>
   
_END;
}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

echo <<<_END

<div class="jumbotron-fluid bg-light pt-3 pb-4">
  <h1 class="text-center display-4">ABOUT-it!</h1>     
  
  <h3 class=" text-center">All about Catalogit Music Library and how we came to be.<h3/p>
</div> <!-- end jumbotron-->
<p>Hi, I am Patti. I have been involved in music all of my life and have taught MusikGarten and traditional piano lessons for the last 12 years. You can imagine the kind of music library you begin to accumulate when you are a professional Musician! How do you file all that music? And, more importantly, how do you find it when you want it?</p>
<p>This is a database made for cataloging your physical music; method books, sheet music and anthologies. No digital Recordings or images of the music.  That's a project for another day!</p>
<p>I'm a programmer now, and this is a project I have wanted to do forever! Now, I know how.  </p>
<p>I hope you love it! This project was from the heart.  </p>



_END;



include 'footer.php';

include 'endingBoilerplate.php';
?>