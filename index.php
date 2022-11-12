<?php


include 'boilerplate.php';

if($debug) {
    echo <<<_END
  
   <p>index.php - 55</p>
   
_END;

} /*end debug*/



/*we will include startBeginningNav.php instead of beginningNav.php. It's different for this one page.*/

include 'beginningNav.php';

echo <<<_END

<div class=" jumbotron-fluid bg-light  ">
 
    <div class=" container-fluid bg-secondary pt-4 ">
        <div class="displayCard  card  ">
            <img class=" card-img-top" style="margin-left:0; padding-right:0;" src="images/musiclibraryCut2.jpg"  alt="Book Stacks with wooden ladder">
            <div class=" card-body  ">
                <h5 class="welcomePageText1 card-title text-center " >Welcome to Catalogit</h5>
                <h5 class="welcomePageText1 card-title text-center " >Music Library</h5>
                <p class="welcomePageText2 card-text pt-4" > Catalogit is a website that helps you create a digital catalog for your physical sheet music and music book library. Don't ever wonder if you own a piece of music again, or where to find it!</p>
                <p class="welcomePageText2 card-text " >With Catalogit you can search by title, composer, genre, instrument etc. Once you have added your music to your catalog, you can search and instantly know if you own the music and where to find it.</p>
                <p class="welcomePageText2 card-text " >Because this is a demo site, any information you add to the catalog may be deleted when the database is periodically reset. Your demo catalog includes some already existing music and plenty of room for you to add music of your own. </p>
                <p class="welcomePageText2 card-text " >Try it out when you are ready, and see how you like it. To get a feel for the catalog, try out the features listed below.You can use this User Name and Password.</p>
                <p class="welcomePageText2 card-text " style="color:red; text-align: center; ;">User name: trialUser</p>
                <p class="welcomePageText2 card-text " style="color:#2fa628; text-align: center; ">Password: trialPassword</p>
                <ul>
                    <li  class="welcomePageText2 " ">Search by book title, composer, composition title, editor, publisher, arranger, genre, instrument or ensemble.</li>
                    <li  class="welcomePageText2 " >Search for a composition from a specific book or all the compositions from a specific book.</li>
                    <li  class="welcomePageText2 " >Add a new book or composition to the library (sheet music can be added too!).</li>
                    <li  class="welcomePageText2 " >Print out : </li>
                    <ul>
                        <li  class="welcomePageText2 " >All the pieces written by a specific Composer.</li>
                        <li  class="welcomePageText2 " >All the pieces from a specific book.</li>
                        <li  class="welcomePageText2 " >All the piano or violin pieces.</li> 
                    </ul>
                    <li  class="welcomePageText2 " >*Demo does not include visual or audio samples of the music, although that would be a great addition in the future. </li>
                    <li  class="welcomePageText2 " >And, of course, use "view page source" to get a look at some of the underlying code, or click on GitHub back at the portfolio site. Enjoy!</li>   
                </ul>
            </div><!--end card-body-->
        </div><!--end card -->
    </div><!--end container-->
</div> <!-- end jumbotron-->





_END;




include 'footer.php';

include 'endingBoilerplate.php';
?>