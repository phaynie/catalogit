<?php
include 'boilerplate.php';

/*Old page delete when ready*/

if($debug) {
    echo <<<_END

    <p>addCompositionCurrentBook.php-13</p>

_END;
}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';


 /*Empty form to fill out with new composition information*/  

$bookID = $_POST['bookID'];

/*THis is the first three text boxes in the add composition form*/
echo <<<_END


<div class="container-fluid bg-light pt-4 ">
 <h2 class="pb-4" >Add Composition Information below</h2>
  <form class="pb-4" action='composerSearch.php' method='post'>
   

  <div class="row">
    <div class="col-md-6">
      <div class="card  mb-3">
        <div class="card-body bg-light">   
        <div class="form-group">
_END;

if(isset($_SESSION['addCompositionCurrentBook_validationFailed'])) {
  echo <<<_END
            <label for="compositionName">Composition Name: <span class="error">{$_SESSION['compNameErr']}</span></label>
            <input type="text" class="form-control" id="compositionName" name="compName" value="{$_SESSION['addCompositionCurrentBook_compName_value']}" /><br/>

            <label for="opusLike">Opus-Like: </label>
            <input type="text" class="form-control" id="opusLike" name="opus" value="{$_SESSION['addCompositionCurrentBook_opus_value']}"/><br/>

            <label for="opusNum">Opus No.: </label>
            <input type="text" class="form-control" id="opusNum" name="opusNum" value="{$_SESSION['addCompositionCurrentBook_opusNum_value']}"/><br/>

_END;

}else{
  echo <<<_END

            <label for="compositionName">Composition Name: </label>
            <input type="text" class="form-control" id="compositionName" name="compName" /><br/>

            <label for="opusLike">Opus-Like: </label>
            <input type="text" class="form-control" id="opusLike" name="opus"/><br/>

            <label for="opusNum">Opus No.: </label>
            <input type="text" class="form-control" id="opusNum" name="opusNum"/><br/>
_END;

}/*end if isset session addCompositionCurrentBook_validationFailed*/
echo<<<_END

           </div> <!-- end form-group -->
        </div> <!-- end card-body -->
     </div> <!-- end card -->
  </div> <!-- end col -->




  <div class="col-md-6">
    <div class="card mb-3">
      <div class="card-body bg-light">   
        <div class="form-group">

_END;

/*This is the second three text boxes in the add composition form*/

            if(isset($_SESSION['addCompositionCurrentBook_validationFailed'])) {
  echo<<<_END

                <label for="compositionNum">Composition No.: </label>
                <input type="number" class="form-control" id="compositionNum" name="compNum" min="0" value="{$_SESSION['addCompositionCurrentBook_compNum_value']}"/><br/>

                <label for="subTitle">Subtitle: </label> 
                <input type="text" class="form-control" id="subTitle" name="subTitle" value="{$_SESSION['addCompositionCurrentBook_subTitle_value']}"/><br/>

                <label for="mvmnt">Movement: </label>
                <input type="text" class="form-control" id="mvmnt" name="movement" value="{$_SESSION['addCompositionCurrentBook_movement_value']}"/><br/>
_END;

            }else{
  echo<<<_END

                <label for="compositionNum">Composition No.: </label>
                <input type="number" class="form-control" id="compositionNum" name="compNum" min="0"/><br/>

                <label for="subTitle">Subtitle: </label>
                <input type="text" class="form-control" id="subTitle" name="subTitle"/><br/>

                <label for="mvmnt">Movement: </label>
                <input type="text" class="form-control" id="mvmnt" name="movement"/><br/>

_END;

            } /*end 2nd if isset session add compositionCurrent Book_validation failed*/
echo<<<_END

          </div> <!-- end form-group -->
        </div> <!-- end card-body -->
      </div> <!-- end card -->
    </div> <!-- end col -->
  </div> <!-- end row -->
    

_END;

 /*keysig checkboxes*/
 echo<<<_END

<div class="row">
  <div class="col-md-4">     
    <div class="card mb-3">
      <div class="card-body bg-light">

_END;

        if(!isset($_POST['postKeySigID'])) {
  echo<<<_END

            <h6>Key Signature: choose as many as apply</h6>
            <span class="error">{$_SESSION['postKeySigIDErr']}</span>

            <div class="form-check">   
                <input type="checkbox" class="form-check-input" id="chk1" name="postKeySigID[]" value="1" {$_SESSION['postKeySigID1_value']}>  none<br>
                <label class="form-check-label sr-only" for="chk1"></label>
            </div> <!-- end form-check -->

            <div class="form-check"> 
                <input type="checkbox" class="form-check-input" id="chk2" name="postKeySigID[]" value="2" {$_SESSION['postKeySigID2']}>  C Major<br>
                <label class="form-check-label sr-only" for="chk2"></label>
            </div> <!-- end form-check -->

            <div class="form-check"> 
                <input type="checkbox" class="form-check-input"  id="chk3" name="postKeySigID[]" value="3" {$_SESSION['postKeySigID3_value']}>  G Major<br>
                <label class="form-check-label sr-only" for="chk3"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox" class="form-check-input"  id="chk4" name="postKeySigID[]" value="4" {$_SESSION['postKeySigID4_value']}>  D Major<br>
                <label class="form-check-label sr-only" for="chk4"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk5" name="postKeySigID[]" value="5" {$_SESSION['postKeySigID5_value']}>  A Major<br>
                <label class="form-check-label sr-only" for="chk5"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk6" name="postKeySigID[]" value="6" {$_SESSION['postKeySigID6_value']}>  E Major<br>
                <label class="form-check-label sr-only" for="chk6"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk7" name="postKeySigID[]" value="7" {$_SESSION['postKeySigID7_value']}>  B Major<br>
                <label class="form-check-label sr-only" for="chk7"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk8" name="postKeySigID[]" value="8" {$_SESSION['postKeySigID8_value']}>  Gb Major<br>
                <label class="form-check-label sr-only" for="chk8"></label>
            </div> <!-- end form-check -->

            <div class="form-check">  
                <input type="checkbox"  class="form-check-input"  id="chk9" name="postKeySigID[]" value="9" {$_SESSION['postKeySigID9_value']}>  Db Major<br>
                <label class="form-check-label sr-only" for="chk9"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk10" name="postKeySigID[]" value="10" {$_SESSION['postKeySigID10_value']}>  Ab Major<br>
                <label class="form-check-label sr-only" for="chk10"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk11" name="postKeySigID[]" value="11" {$_SESSION['postKeySigID11_value']}>  Eb Major<br>
                <label class="form-check-label sr-only" for="chk11"></label>
             </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk12" name="postKeySigID[]" value="12" {$_SESSION['postKeySigID12_value']}>  Bb Major<br>
                <label class="form-check-label sr-only" for="chk12"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk13" name="postKeySigID[]" value="13" {$_SESSION['postKeySigID13_value']}>  F Major<br>
                <label class="form-check-label sr-only" for="chk13"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk14" name="postKeySigID[]" value="14" {$_SESSION['postKeySigID14_value']}>  a minor<br>
                <label class="form-check-label sr-only" for="chk14"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk15" name="postKeySigID[]" value="15" {$_SESSION['postKeySigID15_value']}>  e minor<br>
                <label class="form-check-label sr-only" for="chk15"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk16" name="postKeySigID[]" value="16" {$_SESSION['postKeySigID16_value']}>  b minor<br>
                <label class="form-check-label sr-only" for="chk16"></label>
            </div> <!-- end form-check -->
      
            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk17" name="postKeySigID[]" value="17" {$_SESSION['postKeySigID17_value']}>  f# minor<br>
                <label class="form-check-label sr-only" for="chk17"></label>
                </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk18" name="postKeySigID[]" value="18" {$_SESSION['postKeySigID18_value']}>  c# minor<br>
                <label class="form-check-label sr-only" for="chk18"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk19" name="postKeySigID[]" value="19" {$_SESSION['postKeySigID19_value']}>  g# minor<br>
                <label class="form-check-label sr-only" for="chk19"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk20" name="postKeySigID[]" value="20" {$_SESSION['postKeySigID20_value']}>  eb minor<br>
                <label class="form-check-label sr-only" for="chk20"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk21" name="postKeySigID[]" value="21" {$_SESSION['postKeySigID21_value']}>  bb minor<br>
                <label class="form-check-label sr-only" for="chk21"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk22" name="postKeySigID[]" value="22" {$_SESSION['postKeySigID22_value']}>  f minor<br>
                <label class="form-check-label sr-only" for="chk22"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk23" name="postKeySigID[]" value="23" {$_SESSION['postKeySigID23_value']}>  c minor<br>
                <label class="form-check-label sr-only" for="chk23"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk24" name="postKeySigID[]" value="24" {$_SESSION['postKeySigID24_value']}>  g minor<br>
                <label class="form-check-label sr-only" for="chk24"></label>
            </div> <!-- end form-check -->

            <div class="form-check pb-4">
                <input type="checkbox"  class="form-check-input"  id="chk25" name="postKeySigID[]" value="25" {$_SESSION['postKeySigID25_value']}>  d minor<br>
                <label class="form-check-label sr-only" for="chk25"></label>
_END;

        }else{

  echo<<<_END

     
        h6>Key Signature: choose as many as apply</h6>
        
  
        <div class="form-check">   
          <input type="checkbox" class="form-check-input" id="chk1" name="postKeySigID[]" value="1" >  none<br>
          <label class="form-check-label sr-only" for="chk1"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check"> 
          <input type="checkbox" class="form-check-input" id="chk2" name="postKeySigID[]" value="2" >  C Major<br>
          <label class="form-check-label sr-only" for="chk2"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check"> 
          <input type="checkbox" class="form-check-input"  id="chk3" name="postKeySigID[]" value="3" >  G Major<br>
          <label class="form-check-label sr-only" for="chk3"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox" class="form-check-input"  id="chk4" name="postKeySigID[]" value="4" >  D Major<br>
          <label class="form-check-label sr-only" for="chk4"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk5" name="postKeySigID[]" value="5" >  A Major<br>
          <label class="form-check-label sr-only" for="chk5"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk6" name="postKeySigID[]" value="6" >  E Major<br>
          <label class="form-check-label sr-only" for="chk6"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk7" name="postKeySigID[]" value="7" >  B Major<br>
          <label class="form-check-label sr-only" for="chk7"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk8" name="postKeySigID[]" value="8" >  Gb Major<br>
          <label class="form-check-label sr-only" for="chk8"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">  
          <input type="checkbox"  class="form-check-input"  id="chk9" name="postKeySigID[]" value="9" >  Db Major<br>
          <label class="form-check-label sr-only" for="chk9"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk10" name="postKeySigID[]" value="10" >  Ab Major<br>
          <label class="form-check-label sr-only" for="chk10"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk11" name="postKeySigID[]" value="11" >  Eb Major<br>
          <label class="form-check-label sr-only" for="chk11"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk12" name="postKeySigID[]" value="12" >  Bb Major<br>
          <label class="form-check-label sr-only" for="chk12"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk13" name="postKeySigID[]" value="13" >  F Major<br>
          <label class="form-check-label sr-only" for="chk13"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk14" name="postKeySigID[]" value="14" >  a minor<br>
          <label class="form-check-label sr-only" for="chk14"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk15" name="postKeySigID[]" value="15" >  e minor<br>
          <label class="form-check-label sr-only" for="chk15"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk16" name="postKeySigID[]" value="16" >  b minor<br>
          <label class="form-check-label sr-only" for="chk16"></label>
        </div> <!-- end form-check -->
        
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk17" name="postKeySigID[]" value="17" >  f# minor<br>
          <label class="form-check-label sr-only" for="chk17"></label>
          </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk18" name="postKeySigID[]" value="18" >  c# minor<br>
          <label class="form-check-label sr-only" for="chk18"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk19" name="postKeySigID[]" value="19" >  g# minor<br>
          <label class="form-check-label sr-only" for="chk19"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk20" name="postKeySigID[]" value="20" >  eb minor<br>
          <label class="form-check-label sr-only" for="chk20"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk21" name="postKeySigID[]" value="21" >  bb minor<br>
          <label class="form-check-label sr-only" for="chk21"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk22" name="postKeySigID[]" value="22" >  f minor<br>
          <label class="form-check-label sr-only" for="chk22"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk23" name="postKeySigID[]" value="23" >  c minor<br>
          <label class="form-check-label sr-only" for="chk23"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check">
          <input type="checkbox"  class="form-check-input"  id="chk24" name="postKeySigID[]" value="24" >  g minor<br>
          <label class="form-check-label sr-only" for="chk24"></label>
        </div> <!-- end form-check -->
  
        <div class="form-check pb-4">
          <input type="checkbox"  class="form-check-input"  id="chk25" name="postKeySigID[]" value="25" >  d minor<br>
          <label class="form-check-label sr-only" for="chk25"></label>>  d minor<br>
        <label class="form-check-label sr-only" for="chk25"></label>

_END;

} /*end if(!isset($_POST['postKeySigID']*/

echo<<<_END

      </div> <!-- end form-check -->
    </div> <!-- end card-body -->
  </div> <!-- end card -->
</div> <!-- end col -->


    

 <div class="col-md-4">
   <div class="card mb-3">
      <div class="card-body bg-light">
_END;

        if(!isset($_POST['postGenreID'])) {
        echo<<<_END

        <h6>Genre: choose as many as apply</h6>
        <span class="error">{$_SESSION['postGenreIDErr']}</span>

      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chbx1" name="postGenreID[]" value="1" {$_SESSION['postGenreID1_value']}>none<br>
        <label class="form-check-label sr-only" for="chbx1"></label>
      </div> <!-- end form-check -->


      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx2" name="postGenreID[]" value="2" {$_SESSION['postGenreID2_value']}>Jazz<br>
        <label class="form-check-label sr-only" for="chbx2"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx3" name="postGenreID[]" value="3" {$_SESSION['postGenreID3_value']}>Christmas<br>
        <label class="form-check-label sr-only" for="chbx3"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx4" name="postGenreID[]" value="4" {$_SESSION['postGenreID4_value']}>Halloween<br>
        <label class="form-check-label sr-only" for="chbx4"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx5" name="postGenreID[]" value="5" {$_SESSION['postGenreID5_value']}>Blues<br>
        <label class="form-check-label sr-only" for="chbx5"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx6" name="postGenreID[]" value="6" {$_SESSION['postGenreID6_value']}>Rag<br>
        <label class="form-check-label sr-only" for="chbx6"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx7" name="postGenreID[]" value="7" {$_SESSION['postGenreID7_value']}>Pop<br>
        <label class="form-check-label sr-only" for="chbx7"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx8" name="postGenreID[]" value="8" {$_SESSION['postGenreID8_value']}>Country<br>
        <label class="form-check-label sr-only" for="chbx8"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx9" name="postGenreID[]" value="9" {$_SESSION['postGenreID9_value']}>Madrigal<br>
        <label class="form-check-label sr-only" for="chbx9"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx10" name="postGenreID[]" value="10" {$_SESSION['postGenreID10_value']}>Technique<br>
        <label class="form-check-label sr-only" for="chbx10"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx11" name="postGenreID[]" value="11" {$_SESSION['postGenreID11_value']}>Method Book<br>
        <label class="form-check-label sr-only" for="chbx11"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx12" name="postGenreID[]" value="12" {$_SESSION['postGenreID12_value']}>Classical<br>
        <label class="form-check-label sr-only" for="chbx12"></label>
      </div> <!-- end form-check -->

      <div class="form-check pb-4">
        <input type="checkbox" class="form-check-input" id="chbx13" name="postGenreID[]" value="13" {$_SESSION['postGenreID13_value']}>Other<br>
        <label class="form-check-label sr-only" for="chbx13"></label>
  
_END;

}else{
        echo<<<_END

        
        <h6>Genre: choose as many as apply</h6>

      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chbx1" name="postGenreID[]" value="1" >none<br>
        <label class="form-check-label sr-only" for="chbx1"></label>
      </div> <!-- end form-check -->


      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx2" name="postGenreID[]" value="2" >Jazz<br>
        <label class="form-check-label sr-only" for="chbx2"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx3" name="postGenreID[]" value="3" >Christmas<br>
        <label class="form-check-label sr-only" for="chbx3"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx4" name="postGenreID[]" value="4" >Halloween<br>
        <label class="form-check-label sr-only" for="chbx4"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx5" name="postGenreID[]" value="5" >Blues<br>
        <label class="form-check-label sr-only" for="chbx5"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx6" name="postGenreID[]" value="6" >Rag<br>
        <label class="form-check-label sr-only" for="chbx6"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx7" name="postGenreID[]" value="7" >Pop<br>
        <label class="form-check-label sr-only" for="chbx7"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx8" name="postGenreID[]" value="8" >Country<br>
        <label class="form-check-label sr-only" for="chbx8"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx9" name="postGenreID[]" value="9" >Madrigal<br>
        <label class="form-check-label sr-only" for="chbx9"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx10" name="postGenreID[]" value="10" >Technique<br>
        <label class="form-check-label sr-only" for="chbx10"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx11" name="postGenreID[]" value="11" >Method Book<br>
        <label class="form-check-label sr-only" for="chbx11"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx12" name="postGenreID[]" value="12" >Classical<br>
        <label class="form-check-label sr-only" for="chbx12"></label>
      </div> <!-- end form-check -->

      <div class="form-check pb-4">
        <input type="checkbox" class="form-check-input" id="chbx13" name="postGenreID[]" value="13" >Other<br>
        <label class="form-check-label sr-only" for="chbx13"></label>
_END;

}/*end if(!isset($_POST['postGenreID']*/

  echo<<<_END

        </div> <!-- end form-check -->
      </div> <!-- end card-body -->
    </div> <!-- end card -->
  </div> <!-- end col -->

 

     
      


    
  <div class="col-md-4">
    <div class="card mb-3">
       <div class="card-body bg-light">
_END;

        if(!isset($_POST['postInstrumentID'])) {
        echo<<<_END

      <h6>Instrument:choose as many as apply</h6>
      <span class="error">{$_SESSION['postInstrumentIDErr']}</span>

      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx7" name="postInstrumentID[]" value="7" {$_SESSION['postInstrumentID7_value']}>  none<br>
        <label class="form-check-label sr-only" for="chkbx7"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx1" name="postInstrumentID[]" value="1" {$_SESSION['postInstrumentID1_value']}>  Piano<br>
        <label class="form-check-label sr-only" for="chkbx1"></label>
      </div> <!-- end form-check -->


      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx2" name="postInstrumentID[]" value="2" {$_SESSION['postInstrumentID2_value']}>  Voice<br>
        <label class="form-check-label sr-only" for="chkbx2"></label>
      </div> <!-- end form-check -->


      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx3" name="postInstrumentID[]" value="3" {$_SESSION['postInstrumentID3_value']}>  Trumpet<br>
        <label class="form-check-label sr-only" for="chkbx3"></label>
      </div> <!-- end form-check -->


      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx4" name="postInstrumentID[]" value="4" {$_SESSION['postInstrumentID4_value']}>  Violin<br>
        <label class="form-check-label sr-only" for="chkbx4"></label>
      </div> <!-- end form-check -->


      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx5" name="postInstrumentID[]" value="5" {$_SESSION['postInstrumentID5_value']}>  Viola<br>
        <label class="form-check-label sr-only" for="chkbx5"></label>
      </div> <!-- end form-check -->


      <div class="form-check pb-4">
        <input type="checkbox"  class="form-check-input" id="chkbx6" name="postInstrumentID[]" value="6" {$_SESSION['postInstrumentID6_value']}>  Guitar<br>
        <label class="form-check-label sr-only" for="chkbx6"></label>

_END;

}else{
        echo<<<_END

        <h6>Instrument:choose as many as apply</h6>
        
            <div class="form-check">
              <input type="checkbox"  class="form-check-input" id="chkbx7" name="postInstrumentID[]" value="7" >  none<br>
              <label class="form-check-label sr-only" for="chkbx7"></label>
            </div> <!-- end form-check -->
      
            <div class="form-check">
              <input type="checkbox"  class="form-check-input" id="chkbx1" name="postInstrumentID[]" value="1" >  Piano<br>
              <label class="form-check-label sr-only" for="chkbx1"></label>
            </div> <!-- end form-check -->
      
      
            <div class="form-check">
              <input type="checkbox"  class="form-check-input" id="chkbx2" name="postInstrumentID[]" value="2" >  Voice<br>
              <label class="form-check-label sr-only" for="chkbx2"></label>
            </div> <!-- end form-check -->
      
      
            <div class="form-check">
              <input type="checkbox"  class="form-check-input" id="chkbx3" name="postInstrumentID[]" value="3" >  Trumpet<br>
              <label class="form-check-label sr-only" for="chkbx3"></label>
            </div> <!-- end form-check -->
      
      
            <div class="form-check">
              <input type="checkbox"  class="form-check-input" id="chkbx4" name="postInstrumentID[]" value="4" >  Violin<br>
              <label class="form-check-label sr-only" for="chkbx4"></label>
            </div> <!-- end form-check -->
      
      
            <div class="form-check">
              <input type="checkbox"  class="form-check-input" id="chkbx5" name="postInstrumentID[]" value="5" >  Viola<br>
              <label class="form-check-label sr-only" for="chkbx5"></label>
            </div> <!-- end form-check -->
      
      
            <div class="form-check pb-4">
              <input type="checkbox"  class="form-check-input" id="chkbx6" name="postInstrumentID[]" value="6" >  Guitar<br>
              <label class="form-check-label sr-only" for="chkbx6"></label>

_END;

}/* end if(!isset($_POST['postInstrumentID']*/

      echo<<<_END

          </div> <!-- end form-check -->
        </div> <!-- end card-body -->
      </div> <!-- end card -->
    </div> <!-- end col -->
  </div> <!-- end row -->




  <div class="row">
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-body bg-light">
          <div class="form-group pt-2">
_END;

            if(!isset($_POST['postEraID'])) {

  echo<<<_END

      <label for="era">Era: choose one</label>
      <span class="error">{$_SESSION['postEraIDErr']}</span>

      <select  class="form-control" id="era" name="postEraID">
      <option value="7" {$_SESSION['postEraID7_value']}>none</option>
      <option value="1" {$_SESSION['postEraID1_value']}>Ancient pre 1600</option>
      <option value="2" {$_SESSION['postEraID2_value']}>Baroque 1600-1750</option>
      <option value="3" {$_SESSION['postEraID3_value']}>Classical 1750-1810</option>
      <option value="4" {$_SESSION['postEraID4_value']}>Romantic 1780-1910</option>
      <option value="5" {$_SESSION['postEraID5_value']}>Modern 1890-1930</option>
      <option value="6" {$_SESSION['postEraID6_value']}>Contemporary 1930-Present</option>
      </select>

_END;

}else{
  
  echo<<<_END

      <label for="era">Era: choose one</label>

      <select  class="form-control" id="era" name="postEraID">
      <option value="7" >none</option>
      <option value="1" >Ancient pre 1600</option>
      <option value="2" >Baroque 1600-1750</option>
      <option value="3" >Classical 1750-1810</option>
      <option value="4" >Romantic 1780-1910</option>
      <option value="5" >Modern 1890-1930</option>
      <option value="6" >Contemporary 1930-Present</option>
      </select>

_END;

}/*end if(!isset($_POST['postEraID']*/

echo<<<_END

        </div>  <!-- end form-group -->
      </div> <!-- end card-body -->
    </div> <!-- end card -->
  </div> <!-- end col -->



  <div class="col-md-6">
    <div class="card mb-3">
      <div class="card-body bg-light">
        <div class="form-group pt-2">

_END;

        if(empty($_POST['postVoiceID'])) {

        echo<<<_END

        <label for="voice">Voice: choose one</label>
        <span class="error">{$_SESSION['postVoiceIDErr']}</span>
        <select  class="form-control" id="voice"  name="postVoiceID">
          <option value="12" {$_SESSION['postVoiceID12_value']}>none</option>
          <option value="1" {$_SESSION['postVoiceID1_value']}>SA</option>
          <option value="2" {$_SESSION['postVoiceID2_value']}>SSA</option>
          <option value="3" {$_SESSION['postVoiceID3_value']}>SSAA</option>
          <option value="4" {$_SESSION['postVoiceID4_value']}>ST</option>
          <option value="5" {$_SESSION['postVoiceID5_value']}>TTBB</option>
          <option value="6" {$_SESSION['postVoiceID6_value']}>SB</option>
          <option value="7" {$_SESSION['postVoiceID7_value']}>SAB</option>
          <option value="8" {$_SESSION['postVoiceID8_value']}>SATB</option>
          <option value="9" {$_SESSION['postVoiceID9_value']}>TBB</option>
          <option value="10" {$_SESSION['postVoiceID10_value']}>TBB</option>
          <option value="11" {$_SESSION['postVoiceID11_value']}>TB</option>
        </select>

_END;


}else{

        echo<<<_END

        <label for="voice">Voice: choose one</label>
        <select  class="form-control" id="voice"  name="postVoiceID">
          <option value="12">none</option>
          <option value="1">SA</option>
          <option value="2">SSA</option>
          <option value="3">SSAA</option>
          <option value="4">ST</option>
          <option value="5">TTBB</option>
          <option value="6">SB</option>
          <option value="7">SAB</option>
          <option value="8">SATB</option>
          <option value="9">TBB</option>
          <option value="10">TBB</option>
          <option value="11">TB</option>
        </select>

_END;

        } /*end if(!isset($_POST['postVoiceID']*/
      
echo<<<_END

          </div> <!-- end form-group -->
        </div> <!-- end card-body -->
      </div> <!-- end card -->
    </div> <!-- end col -->
  </div> <!-- end row -->

  
  <div class="row">
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-body bg-light">
          <div class="form-group pt-2">

_END;

            if(!isset($_POST['postEnsembleID'])) {

        echo<<<_END

           <label for="ens">Ensemble: choose one</label>
           <span class="error">{$_SESSION['postEnsembleIDErr']}</span>
           <select  class="form-control" id="voice" name="postEnsembleID">
              <option value="18" {$_SESSION['postEnsembleID18_value']}>none</option>
              <option value="1" {$_SESSION['postEnsembleID1_value']}>Solo a capella</option>
              <option value="2" {$_SESSION['postEnsembleID2_value']}>Duet a capella</option>
              <option value="3" {$_SESSION['postEnsembleID3_value']}>Trio a capella</option>
              <option value="4" {$_SESSION['postEnsembleID4_value']}>Quartet a capella</option>
              <option value="5" {$_SESSION['postEnsembleID5_value']}>Quintet a capella</option>
              <option value="6" {$_SESSION['postEnsembleID6_value']}>Ensemble</option>
              <option value="7" {$_SESSION['postEnsembleID7_value']}>Solo-Accompanied</option>
              <option value="8" {$_SESSION['postEnsembleID8_value']}>Duet-Accompanied</option>
              <option value="9" {$_SESSION['postEnsembleID9_value']}>Trio-Accompanied</option>
              <option value="10" {$_SESSION['postEnsembleID10_value']}>Quartet-Accompanied</option>
              <option value="11" {$_SESSION['postEnsembleID11_value']}>Quintet-Accompanied</option>
              <option value="12" {$_SESSION['postEnsembleID12_value']}>Ensemble-Accompanied</option>
              <option value="13" {$_SESSION['postEnsembleID13_value']}>Band</option>
              <option value="14" {$_SESSION['postEnsembleID14_value']}>Orchestra</option>
              <option value="15" {$_SESSION['postEnsembleID15_value']}>Choir</option>
              <option value="16" {$_SESSION['postEnsembleID16_value']}>Choir-Accompanied</option>
              <option value="17" {$_SESSION['postEnsembleID17_value']}>other</option>
      </select>

_END;

      }else{

        echo<<<_END

        <label for="ens">Ensemble: choose one</label>
        <select  class="form-control" id="voice" name="postEnsembleID">
           <option value="18">none</option>
           <option value="1">Solo a capella</option>
           <option value="2">Duet a capella</option>
           <option value="3">Trio a capella</option>
           <option value="4">Quartet a capella</option>
           <option value="5">Quintet a capella</option>
           <option value="6">Ensemble</option>
           <option value="7">Solo-Accompanied</option>
           <option value="8">Duet-Accompanied</option>
           <option value="9">Trio-Accompanied</option>
           <option value="10">Quartet-Accompanied</option>
           <option value="11">Quintet-Accompanied</option>
           <option value="12">Ensemble-Accompanied</option>
           <option value="13">Band</option>
           <option value="14">Orchestra</option>
           <option value="15">Choir</option>
           <option value="16">Choir-Accompanied</option>
           <option value="17">other</option>
   </select>

_END;

} /*end if(!isset($_POST['postEnsembleID']*/
echo<<<_END

          </div> <!-- end form-group -->
        </div> <!-- end card-body -->
      </div> <!-- end card -->
    </div> <!-- end col -->
    


      
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-body bg-light">
          <div class="form-group pt-2">

_END;

      if(!isset($_POST['postGenDiffID'])) {

        echo<<<_END

      <label for="genDiff">General Difficulty Level: choose one</label> 
      <span class="error">{$_SESSION['postGenDiffIDErr']}</span>
      <select  class="form-control" id="genDiff" name="postGenDiffID">
        <option value="10" {$_SESSION['postGenDiffID10_value']}>none</option>
        <option value="1" {$_SESSION['postGenDiffID1_value']}>Gen EE / ASP 1</option>
        <option value="2" {$_SESSION['postGenDiffID2_value']}>Gen E / ASP 2</option>
        <option value="3" {$_SESSION['postGenDiffID3_value']}>Gen LE / ASP 3</option>
        <option value="4" {$_SESSION['postGenDiffID4_value']}>Gen EI / ASP 4</option>
        <option value="5" {$_SESSION['postGenDiffID5_value']}>Gen I / ASP 5-6</option>
        <option value="6" {$_SESSION['postGenDiffID6_value']}>Gen LI / ASP 7</option>
        <option value="7" {$_SESSION['postGenDiffID7_value']}>Gen EA / ASP 8</option>
        <option value="8" {$_SESSION['postGenDiffID8_value']}>Gen A / ASP 9-19</option>
        <option value="9" {$_SESSION['postGenDiffID9_value']}>Gen LA / ASP 11-12</option>
</select>

_END;

      }else{

        echo<<<_END

      <label for="genDiff">General Difficulty Level: choose one</label> 
      <select  class="form-control" id="genDiff" name="postGenDiffID">
        <option value="10">none</option>
        <option value="1">Gen EE / ASP 1</option>
        <option value="2">Gen E / ASP 2</option>
        <option value="3">Gen LE / ASP 3</option>
        <option value="4">Gen EI / ASP 4</option>
        <option value="5">Gen I / ASP 5-6</option>
        <option value="6">Gen LI / ASP 7</option>
        <option value="7">Gen EA / ASP 8</option>
        <option value="8">Gen A / ASP 9-10</option>
        <option value="9">Gen LA / ASP 11-12</option>
</select>

_END;

      }/*end if(!isset($_POST['postGenDiffID']*/

      echo<<<_END

        </div> <!-- end form-group -->
      </div> <!-- end card-body -->
    </div> <!-- end card -->
  </div> <!-- end col -->
 </div> <!-- end row -->
      

  <div class="row">
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-body bg-light">     
          <div class="form-group pt-2">

_END;

            if(!isset($_POST['postASPDiffID'])) {
  echo<<<_END

<label for="aspDiff">ASP difficulty level: choose one</label>
<span class="error">{$_SESSION['postASPDiffIDErr']}</span>
<select  class="form-control" id="aspDiff" name="postASPDiffID">
        <option value="34" {$_SESSION['postASPDiffID34_value']}>none</option>
        <option value="11" {$_SESSION['postASPDiffID11_value']}>ASP 1 / Gen EE</option>
        <option value="12" {$_SESSION['postASPDiffID12_value']}>ASP 1-2 / Gen EE-E</option>
        <option value="13" {$_SESSION['postASPDiffID13_value']}>ASP 2 / Gen E</option>
        <option value="14" {$_SESSION['postASPDiffID14_value']}>ASP 2-3 / Gen E-LE </option>
        <option value="15" {$_SESSION['postASPDiffID15_value']}>ASP 3 / Gen LE</option>
        <option value="16" {$_SESSION['postASPDiffID16_value']}>ASP 3-4 / Gen LE-EI</option>
        <option value="17" {$_SESSION['postASPDiffID17_value']}>ASP 4 / Gen EI</option>
        <option value="18" {$_SESSION['postASPDiffID18_value']}>ASP 4-5 / Gen EI-I</option>
        <option value="19" {$_SESSION['postASPDiffID19_value']}>ASP 5 / Gen I</option>
        <option value="20" {$_SESSION['postASPDiffID20_value']}>ASP 5-6 / Gen I</option>
        <option value="21" {$_SESSION['postASPDiffID21_value']}>ASP 6 / Gen I</option>
        <option value="22" {$_SESSION['postASPDiffID22_value']}>ASP 6-7 / Gen I-LI</option>
        <option value="23" {$_SESSION['postASPDiffID23_value']}>ASP 7 / Gen LI</option>
        <option value="24" {$_SESSION['postASPDiffID24_value']}>ASP 7-8 / Gen LI-EA</option>
        <option value="25" {$_SESSION['postASPDiffID25_value']}>ASP 8 / Gen EA</option>
        <option value="26" {$_SESSION['postASPDiffID26_value']}>ASP 8-9 / Gen EA-A</option>
        <option value="27" {$_SESSION['postASPDiffID27_value']}>ASP 9 / Gen A</option>
        <option value="28" {$_SESSION['postASPDiffID28_value']}>ASP 9-10 / Gen A</option>
        <option value="29" {$_SESSION['postASPDiffID29_value']}>ASP 10 / Gen A</option>
        <option value="30" {$_SESSION['postASPDiffID30_value']}>ASP 10-11 / Gen A-LA</option>
        <option value="31" {$_SESSION['postASPDiffID31_value']}>ASP 11 / Gen LA</option>
        <option value="32" {$_SESSION['postASPDiffID32_value']}>ASP 11-12 / Gen LA</option>
        <option value="33" {$_SESSION['postASPDiffID33_value']}>ASP 12 / Gen LA</option>
</select>

_END;

        }else{

  echo<<<_END

      <label for="aspDiff">ASP difficulty level: choose one</label>
      <select  class="form-control" id="aspDiff" name="postASPDiffID">
        <option value="34">none</option>
        <option value="11">ASP 1 / Gen EE</option>
        <option value="12">ASP 1-2 / Gen EE-E</option>
        <option value="13">ASP 2 / Gen E</option>
        <option value="14">ASP 2-3 / Gen E-LE </option>
        <option value="15">ASP 3 / Gen LE</option>
        <option value="16">ASP 3-4 / Gen LE-EI</option>
        <option value="17">ASP 4 / Gen EI</option>
        <option value="18">ASP 4-5 / Gen EI-I</option>
        <option value="19">ASP 5 / Gen I</option>
        <option value="20">ASP 5-6 / Gen I</option>
        <option value="21">ASP 6 / Gen I</option>
        <option value="22">ASP 6-7 / Gen I-LI</option>
        <option value="23">ASP 7 / Gen LI</option>
        <option value="24">ASP 7-8 / Gen LI-EA</option>
        <option value="25">ASP 8 / Gen EA</option>
        <option value="26">ASP 8-9 / Gen EA-A</option>
        <option value="27">ASP 9 / Gen A</option>
        <option value="28">ASP 9-10 / Gen A</option>
        <option value="29">ASP 10 / Gen A</option>
        <option value="30">ASP 10-11 / Gen A-LA</option>
        <option value="31">ASP 11 / Gen LA</option>
        <option value="32">ASP 11-12 / Gen LA</option>
        <option value="33">ASP 12 / Gen LA</option>
</select>

_END;

        }/*end if(!isset($_POST['postASPDiffID']*/

echo<<<_END

          </div> <!-- end form-group -->  
        </div> <!-- end card-body -->
      </div> <!-- end card -->     
    </div> <!-- end col -->
  </div> <!--end row-->
_END;


    if(isset($_SESSION['addCompositionCurrentBook_validationFailed'])) {
  
  echo<<<_END

    <input class="btn btn-secondary" type='submit' value='Submit & Continue'/>
    <input type='hidden' name="bookID" value='{$_SESSION['bookID']}'/>

_END;

    }else{
      echo<<<_END

    <input class="btn btn-secondary" type='submit' value='Submit & Continue'/>
    <input type='hidden' name="bookID" value='$bookID'/>
_END;

    } /*end third if isset session add compositon cureent book validatiaon failed*/

    echo<<<_END
   
  </form>  <!--end form-->
</div>  <!--end container-->

_END;

/*When button is clicked, the form continues on to adding a composer, editor or lyricist after checking to see if they already exist. */




/*ask Ken about parent session variables   $_SESSION['parentKey']['key'] */
/*destroy session variables*/

/*text box session vriables*/
unset($_SESSION['compNameErr']);

unset($_SESSION['postKeySigIDErr']);

unset($_SESSION['postGenreIDErr']);

unset($_SESSION['postInstrumentIDErr']);

unset($_SESSION['postEraIDErr']);

unset($_SESSION['postVoiceIDErr']);

unset($_SESSION['postEnsembleIDErr']);

unset($_SESSION['postGenDiffIDErr']);

unset($_SESSION['postASPDiffIDErr']);

unset($_SESSION['addCompositionCurrentBook_validationFailed']);
 
unset($_SESSION['addCompositionCurrentBook_compName_value']);
 
unset($_SESSION['addCompositionCurrentBook_opus_value']);

unset($_SESSION['addCompositionCurrentBook_opusNum_value']); 

unset($_SESSION['addCompositionCurrentBook_compNum_value']);

unset($_SESSION['addCompositionCurrentBook_subTitle_value']);

unset($_SESSION['addCompositionCurrentBook_movement_value']);
 
unset($_SESSION['bookID']);
 


/*key sig checkbox session variables*/
unset($_SESSION['postKeySigID1_value']);

unset($_SESSION['postKeySigID2_value']);

unset($_SESSION['postKeySigID3_value']);

unset($_SESSION['postKeySigID4_value']);

unset($_SESSION['postKeySigID5_value']);

unset($_SESSION['postKeySigID6_value']);

unset($_SESSION['postKeySigID7_value']);

unset($_SESSION['postKeySigID8_value']);

unset($_SESSION['postKeySigID9_value']);

unset($_SESSION['postKeySigID10_value']);

unset($_SESSION['postKeySigID11_value']);

unset($_SESSION['postKeySigID12_value']);

unset($_SESSION['postKeySigID13_value']);

unset($_SESSION['postKeySigID14_value']);

unset($_SESSION['postKeySigID15_value']);

unset($_SESSION['postKeySigID16_value']);

unset($_SESSION['postKeySigID17_value']);  

unset($_SESSION['postKeySigID18_value']);

unset($_SESSION['postKeySigID19_value']);

unset($_SESSION['postKeySigID20_value']);

unset($_SESSION['postKeySigID21_value']);

unset($_SESSION['postKeySigID22_value']);

unset($_SESSION['postKeySigID23_value']);

unset($_SESSION['postKeySigID24_value']);

unset($_SESSION['postKeySigID25_value']);


/*Genre checkbox session variables*/
unset($_SESSION['postGenreID1_value']);

unset($_SESSION['postGenreID2_value']); 

unset($_SESSION['postGenreID3_value']); 

unset($_SESSION['postGenreID4_value']); 

unset($_SESSION['postGenreID5_value']);

unset($_SESSION['postGenreID6_value']);

unset($_SESSION['postGenreID7_value']);

unset($_SESSION['postGenreID8_value']);

unset($_SESSION['postGenreID9_value']);

unset($_SESSION['postGenreID10_value']);

unset($_SESSION['postGenreID11_value']);

unset($_SESSION['postGenreID12_value']);

unset($_SESSION['postGenreID13_value']);



/*instrument checkbox session variables*/
unset($_SESSION['postInstrumentID7_value']);

unset($_SESSION['postInstrumentID1_value']);

unset($_SESSION['postInstrumentID2_value']);

unset($_SESSION['postInstrumentID3_value']);

unset($_SESSION['postInstrumentID4_value']);

unset($_SESSION['postInstrumentID5_value']);

unset($_SESSION['postInstrumentID6_value']);



/*era selectbox session variables*/
unset($_SESSION['postEraID7_value']);

unset($_SESSION['postEraID1_value']);

unset($_SESSION['postEraID2_value']);

unset($_SESSION['postEraID3_value']);
  
unset($_SESSION['postEraID4_value']);

unset($_SESSION['postEraID5_value']);

unset($_SESSION['postEraID6_value']);



/*Voice selectbox session variables*/
unset($_SESSION['postVoiceID12_value']);

unset($_SESSION['postVoiceID1_value']);

unset($_SESSION['postVoiceID2_value']);

unset($_SESSION['postVoiceID3_value']);
   
unset($_SESSION['postVoiceID4_value']);

unset($_SESSION['postVoiceID5_value']);

unset($_SESSION['postVoiceID6_value']);

unset($_SESSION['postVoiceID7_value']);

unset($_SESSION['postVoiceID8_value']);
   
unset($_SESSION['postVoiceID9_value']);

unset($_SESSION['postVoiceID10_value']);

unset($_SESSION['postVoiceID11_value']);



/*Ensemble selectbox session variables*/
unset($_SESSION['postEnsembleID18_value']);

unset($_SESSION['postEnsembleID1_value']);

unset($_SESSION['postEnsembleID2_value']);

unset($_SESSION['postEnsembleID3_value']);

unset($_SESSION['postEnsembleID4_value']);

unset($_SESSION['postEnsembleID5_value']);

unset($_SESSION['postEnsembleID6_value']);

unset($_SESSION['postEnsembleID7_value']);

unset($_SESSION['postEnsembleID8_value']);

unset($_SESSION['postEnsembleID9_value']);

unset($_SESSION['postEnsembleID10_value']);

unset($_SESSION['postEnsembleID11_value']);

unset($_SESSION['postEnsembleID12_value']);

unset($_SESSION['postEnsembleID13_value']);

unset($_SESSION['postEnsembleID14_value']);

unset($_SESSION['postEnsembleID15_value']);

unset($_SESSION['postEnsembleID16_value']);

unset($_SESSION['postEnsembleID17_value']);




/*GenDiff selectbox session variables*/
unset($_SESSION['postGenDiffID10_value']);

unset($_SESSION['postGenDiffID1_value']);

unset($_SESSION['postGenDiffID2_value']);

unset($_SESSION['postGenDiffID3_value']);

unset($_SESSION['postGenDiffID4_value']);

unset($_SESSION['postGenDiffID5_value']);

unset($_SESSION['postGenDiffID6_value']);

unset($_SESSION['postGenDiffID7_value']);

unset($_SESSION['postGenDiffID8_value']);

unset($_SESSION['postGenDiffID9_value']);


/*ASPDiff selectbox session variables*/
unset($_SESSION['postASPDiffID34_value']);

unset($_SESSION['postASPDiffID11_value']);

unset($_SESSION['postASPDiffID12_value']);

unset($_SESSION['postASPDiffID13_value']);

unset($_SESSION['postASPDiffID14_value']);

unset($_SESSION['postASPDiffID15_value']);

unset($_SESSION['postASPDiffID16_value']);

unset($_SESSION['postASPDiffID17_value']);

unset($_SESSION['postASPDiffID18_value']);

unset($_SESSION['postASPDiffID19_value']);

unset($_SESSION['postASPDiffID20_value']);

unset($_SESSION['postASPDiffID21_value']);

unset($_SESSION['postASPDiffID22_value']);

unset($_SESSION['postASPDiffID23_value']);

unset($_SESSION['postASPDiffID24_value']);

unset($_SESSION['postASPDiffID25_value']);

unset($_SESSION['postASPDiffID26_value']);

unset($_SESSION['postASPDiffID27_value']);

unset($_SESSION['postASPDiffID28_value']);

unset($_SESSION['postASPDiffID29_value']);

unset($_SESSION['postASPDiffID30_value']);

unset($_SESSION['postASPDiffID31_value']);

unset($_SESSION['postASPDiffID32_value']);

unset($_SESSION['postASPDiffID33_value']);











include 'footer.html';
include 'endingBoilerplate.php';



?>







