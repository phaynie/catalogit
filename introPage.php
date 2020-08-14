<?php
include 'boilerplate.php';
if($debug) {
    echo <<<_END
  
   <p>introPage - 1</p>
   
_END;

} /*end debug*/

/*include 'beginningNav.html';*/
/*include 'beginningNav.html';*/
include 'beginningNav.php';
unset($_SESSION['bookID']);
echo <<<_END

<div class="jumbotron-fluid bg-light pt-3 pb-4">
_END;


   


echo<<<_END
  <h1 class="text-center display-4">Welcome to Catalogit</h1>     
  <h1 class="text-center display-4 pb-4">Music Library</h1>
  <h3 class=" text-center pb-5">What will you be searching for today?<h3/p>
</div> <!-- end jumbotron-->

<div class="container-fluid bg-secondary pt-4 pb-4">
<div class="row">
<div class="col-lg-9"> 
<div class="img"><img src="images/musiclibrary.jpg" class=" img-fluid rounded max-width:100% height:auto " alt="library and ladder">
 </div>          
</div>  <!-- end colOne-->


<div class="col-lg-3   pb-4 ">
<div class="container-fluid">
<div class="form-group max-width:100% height:auto">
  <form action='bookTitleSearch.php' method='post'>
    <input class="form-control btn btn-light btn-block mt-3 mb-3" type="submit" value="Find or Add a Book" />
  </form>

  <form action='compositionSearch.php' method='post'>
  <form action='compositionSearch.php' method='post'>
    <input class="form-control btn btn-light btn-block mb-3"  type="submit" value="Find or Add a Composition"/>
  </form>

  <form action="peopleSearch.php" method="post">
    <input  class="form-control btn btn-light btn-block mb-3" type="submit" value="Find or Add a Composer"/>
    <input type="hidden" name="findComposer" value= "true" />
  </form>

  <form action='advancedSearch.php' method='post'>
    <input  class="form-control btn btn-light btn-block mb-3" type='submit' value='Advanced Search'/>
    <input type='hidden' name='advSearch' value= 'true' />
  </form>

  <form action='arrangerSearch.php' method='post'>
    <input  class="btn form-control  btn-light btn-block mb-3" type='submit' value='Find or Add an Arranger'/>
  </form>

  <form action='lyricistSearch.php' method='post'>
    <input  class="btn btn-light btn-block mb-3" type='submit' value='Find or Add a Lyricist'/>
  </form>

  <form action='orgSearch.php' method='post'>
    <input  class="btn btn-light btn-block mb-3" type='submit' value='Find or Add a Publisher'/>
  </form>

  <form action='editorSearch.php' method='post'>
    <input  class="btn btn-light btn-block mb-3" type='submit' value='Find or Add an Editor'/>
  </form>

  <form action='advancedSearch.php' method='post'>
    <input  class="btn btn-light btn-block mb-3" type='submit' value='Find Music from a specific Era'/>
     <input type="hidden" name="findEra" value= "true" />
  </form>

  <form action='advancedSearch.php' method='post'>
    <input  class="btn btn-light btn-block mb-3" type='submit' value='Find Music by Instrument'/>
    <input type="hidden" name="findInstrument" value= "true" />
  </form>
  
  <form action='advancedSearch.php' method='post'>
    <input  class="btn btn-light btn-block mb-3" type='submit' value='Find Music by Difficulty Level'/>
    <input type="hidden" name="findDifficulty" value= "true" />
  </form>
  
  <form action='advancedSearch.php' method='post'>
    <input  class="btn btn-light btn-block mb-3" type='submit' value='Find Music by Genre'/>
    <input type="hidden" name="findGenre" value= "true" />
  </form>
  
  </div> <!-- end form group  -->
  </div> <!-- end container  -->
</div> <!-- end colTwo  -->
</div> <!-- end row  -->
</div> <!-- end container  -->




_END;
  



include 'footer.html';

include 'endingBoilerplate.php';
  ?>