<?php
echo <<<_END

<div class="container-fluid bg-secondary pt-3 pb-3 mt-3">
     <h4 class="display-4 text-light text-center "> "$bookTitle"</h4>
    <h4 class="display-5 text-light text-center "> Add or Edit here</h4>
    <div class="card-columns">
      <div class="card  mt-4 mb-3">
         <div class="card-body bg-light">
            Book Title: <strong>$bookTitle</strong> <br/>
                       Tag 1: $bookTag1 <br/>
                       Tag 2: $bookTag2 <br/>
                       Book Volume: $bookVolume <br/>
                       Book Number: $bookNumber <br/>
                       Editor Name: $displayEditorPeopleString<br/>
                       Publisher Name: $displayPublisherOrgString <br/>
                       Book Location: <span style="color:#EB6B42;">$physBookLocNote</span><br/><br/>
        </div>
      </div>
      <div class="card  mt-4 mb-3">
        <div class="card-body bg-light">
           <form class="mt-4" action='addBook.php' method='post'>
                      <div class="form-check">
                          <input class="btn  btn-light" type='submit' value="Edit Existing General Book Information for '$bookTitle' "/>
                          <input type='hidden' name="bookID" value='$bookID'/>
                          <input type='hidden' name="editBook" value= 'true' />
                       </div>  <!-- end form-check -->      
                   </form>  <!-- end form -->
        </div>
      </div>
     
    </div>
  </div>





_END;
/*So far this experiment failed. Might follow it through later with more time, but specs suggest it's not a perfect fit yet. */