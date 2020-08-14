<?php
include 'boilerplate.php';
/*Not current. See compositionOptions2.php*/
if($debug) {
  echo <<<_END

  <p>Composition Options-11</p>

_END;

}/*end debug*/


include 'beginningNav.php';

/*Initialize variables coming from other pages*/

$bookID = $_POST['bookID'];
$searchCompositionTitle = $_POST['searchCompositionTitle'];
$validationFailed= false;
/*This is no longer a validation page
However, we will be displaying the book and the composition*/


/*boilerplate over, now validate if needed*/
if(isset($_POST['compName'])) {
  /*perform all validations needed for all fields*/
  if(empty($_POST['compName'])) {
    $_SESSION['compNameErr'] = " * Name of Composition is required";
    $validationFailed = true;
  }/*end if empty post composerLastName*/
  
  /*add check box validations here*/
  /*if checkbox validation fails, set checkbox error message and validationFailed = true*/
  
  if(!isset($_POST['postKeySigID'])) {
    /*if not set, then no checkboxes checked*/
    $_SESSION['postKeySigIDErr'] = " * At least one box must be checked";
    $validationFailed = true;
  }/*end if !not isset post postKeySigID*/
  
  if(!isset($_POST['postGenreID'])) {
    /*if not set, then no checkboxes checked*/
    $_SESSION['postGenreIDErr'] = " * At least one box must be checked";
    $validationFailed = true;
  }/*end if not isset post postGenreID*/

  if(!isset($_POST['postInstrumentID'])) {
    /*if not set, then no checkboxes checked*/
    $_SESSION['postInstrumentIDErr'] = " * At least one box must be checked";
    $validationFailed = true;
  }/*end if not isset  postInstrumentID*/

  if(!isset($_POST['postEraID'])) {
      $_SESSION['postEraIDErr'] = " * One item must be selected";
      $validationFailed = true;
  }/*end if isset post postEraID*/

  if(!isset($_POST['postVoiceID'])) {
    $_SESSION['postVoiceIDErr'] = " * One item must be selected";
    $validationFailed = true;
  }/*end if not isset post postVoiceID*/

  if(!isset($_POST['postEnsembleID'])) {
    $_SESSION['postEnsembleIDErr'] = " * One item must be selected";
    $validationFailed = true;
  }/*end if not isset post postEnsembleID*/

  if(!isset($_POST['postGenDiffID'])) {
    $_SESSION['postGenDiffIDErr'] = " * One item must be selected";
    $validationFailed = true;
  }/*end if not isset post postGenDiffID*/

  if(!isset($_POST['postASPDiffID'])) {
    $_SESSION['postASPDiffIDErr'] = " * One item must be selected";
    $validationFailed = true;
  }/*end if not isset post postASPDiffID*/

 
  
  if($validationFailed) {
    /*store submitted form values so we can pre-populate the form after re-directing*/
    $_SESSION['addCompositionCurrentBook_validationFailed'] = true; 
    $_SESSION['addCompositionCurrentBook_compName_value'] = $_POST['compName']; 
    $_SESSION['addCompositionCurrentBook_opus_value'] = $_POST['opus']; 
    $_SESSION['addCompositionCurrentBook_opusNum_value'] = $_POST['opusNum']; 
    $_SESSION['addCompositionCurrentBook_compNum_value'] = $_POST['compNum']; 
    $_SESSION['addCompositionCurrentBook_subTitle_value'] = $_POST['subTitle']; 
    $_SESSION['addCompositionCurrentBook_movement_value'] = $_POST['movement']; 
    $_SESSION['bookID'] = $_POST['bookID']; 


    /*Now let's look at all the checkboxes related to keySig*/
    if(isset($_POST['postKeySigID'])) {

      if (in_array("1", $_POST['postKeySigID'])) { /*if the user didn't check it, it won't be in the array*/
        $_SESSION['postKeySigID1_value'] = "checked";
      }
    
      if (in_array("2", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID2_value'] = "checked";
      }
    
      if (in_array("3", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID3_value'] = "checked";
      }
    
      if (in_array("4", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID4_value'] = "checked";
      }
      
      if (in_array("5", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID5_value'] = "checked";
      }
      
      if (in_array("6", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID6_value'] = "checked";
      }
      
      if (in_array("7", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID7_value'] = "checked";
      }
      
      if (in_array("8", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID8_value'] = "checked";
      }
      
      if (in_array("9", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID9_value'] = "checked";
      }
      
      if (in_array("10", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID10_value'] = "checked";
      }
      
      if (in_array("11", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID11_value'] = "checked";
      }
      
      if (in_array("12", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID12_value'] = "checked";
      }
      
      if (in_array("13", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID13_value'] = "checked";
      }
      
      if (in_array("14", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID14_value'] = "checked";
      }
      
      if (in_array("15", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID15_value'] = "checked";
      }
      
      if (in_array("16", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID16_value'] = "checked";
      }

      if (in_array("17", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID17_value'] = "checked";
      }
      
      if (in_array("18", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID18_value'] = "checked";
      }
      
      if (in_array("194", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID19_value'] = "checked";
      }
      
      if (in_array("20", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID20_value'] = "checked";
      }
      
      if (in_array("21", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID21_value'] = "checked";
      }
      
      if (in_array("22", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID22_value'] = "checked";
      }
      
      if (in_array("23", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID23_value'] = "checked";
      }
      
      if (in_array("24", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID24_value'] = "checked";
      }
    
      if (in_array("25", $_POST['postKeySigID'])) {
        $_SESSION['postKeySigID25_value'] = "checked";
      }
    
    }/*end if isset post postkeySigID*/




/*Now let's look at all the checkboxes related to genre*/
    if(isset($_POST['postGenreID'])) {
     
      if (in_array("1", $_POST['postGenreID'])) {
        $_SESSION['postGenreID1_value'] = "checked";
      }
      
      if (in_array("2", $_POST['postGenreID'])) {
        $_SESSION['postGenreID2_value'] = "checked";
      }
      
      if (in_array("3", $_POST['postGenreID'])) {
        $_SESSION['postGenreID3_value'] = "checked";
      }
      
      if (in_array("4", $_POST['postGenreID'])) {
        $_SESSION['postGenreID4_value'] = "checked";
      }
      
      if (in_array("5", $_POST['postGenreID'])) {
        $_SESSION['postGenreID5_value'] = "checked";
      }
      
      if (in_array("6", $_POST['postGenreID'])) {
        $_SESSION['postGenreID6_value'] = "checked";
      }
      
      if (in_array("7", $_POST['postGenreID'])) {
        $_SESSION['postGenreID7_value'] = "checked";
      }
      
      if (in_array("8", $_POST['postGenreID'])) {
        $_SESSION['postGenreID8_value'] = "checked";
      }
     
      if (in_array("9", $_POST['postGenreID'])) {
        $_SESSION['postGenreID9_value'] = "checked";
      }
      
      if (in_array("10", $_POST['postGenreID'])) {
        $_SESSION['postGenreID10_value'] = "checked";
      }
      
      if (in_array("11", $_POST['postGenreID'])) {
        $_SESSION['postGenreID11_value'] = "checked";
      }
      
      if (in_array("12", $_POST['postGenreID'])) {
        $_SESSION['postGenreID12_value'] = "checked";
      }
      
      if (in_array("13", $_POST['postGenreID'])) {
        $_SESSION['postGenreID13_value'] = "checked";
      }


    }/*end if isset post postGenreID*/


     /*Now let's look at all the checkboxes related to instrument*/
    /*Still in the if validation failed clause*/
    if(isset($_POST['postInstrumentID'])) {

      if (in_array("7", $_POST['postInstrumentID'])) { /*if the user didn't check it, it won't be in the array*/
        $_SESSION['postInstrumentID7_value'] = "checked";
      }

      if (in_array("1", $_POST['postInstrumentID'])) {
        $_SESSION['postInstrumentID1_value'] = "checked";
      }

      if (in_array("2", $_POST['postInstrumentID'])) {
        $_SESSION['postInstrumentID2_value'] = "checked";
      }

      if (in_array("3", $_POST['postInstrumentID'])) {
        $_SESSION['postInstrumentID3_value'] = "checked";
      }

      if (in_array("4", $_POST['postInstrumentID'])) {
        $_SESSION['postInstrumentID4_value'] = "checked";
      }

      if (in_array("5", $_POST['postInstrumentID'])) {
        $_SESSION['postInstrumentID5_value'] = "checked";
      }

      if (in_array("6", $_POST['postInstrumentID'])) {
        $_SESSION['postInstrumentID6_value'] = "checked";
      }

    }/*end if isset post postInstrumentID*/


    /*Now let's look at all the options related to era*/
    if(isset($_POST['postEraID'])) {

      if($_POST['postEraID'] == 7) {
        $_SESSION['postEraID7_value'] = "selected";
      }

      if($_POST['postEraID'] == 1) {
        $_SESSION['postEraID1_value'] = "selected";
      }

      if($_POST['postEraID'] == 2) {
      $_SESSION['postEraID2_value'] = "selected";
      }

      if($_POST['postEraID'] == 3) {
        $_SESSION['postEraID3_value'] = "selected";
      }   

      if($_POST['postEraID'] == 4) {
        $_SESSION['postEraID4_value'] = "selected";
      }

      if($_POST['postEraID'] == 5) {
        $_SESSION['postEraID5_value'] = "selected";
      }

      if($_POST['postEraID'] == 6) {
        $_SESSION['postEraID6_value'] = "selected";
      }

    }/*end if isset post postEraID*/




    /*Now let's look at all the options related to voice*/
    if(isset($_POST['postVoiceID'])) {

      if($_POST['postVoiceID'] == 12) {
        $_SESSION['postVoiceID12_value'] = "selected";
      }

      if($_POST['postVoiceID'] == 1) {
        $_SESSION['postVoiceID1_value'] = "selected";
      }

      if($_POST['postVoiceID'] == 2) {
      $_SESSION['postVoiceID2_value'] = "selected";
      }

      if($_POST['postVoiceID'] == 3) {
        $_SESSION['postVoiceID3_value'] = "selected";
      }   

      if($_POST['postVoiceID'] == 4) {
        $_SESSION['postVoiceID4_value'] = "selected";
      }

      if($_POST['postVoiceID'] == 5) {
        $_SESSION['postVoiceID5_value'] = "selected";
      }

      if($_POST['postVoiceID'] == 6) {
        $_SESSION['postVoiceID6_value'] = "selected";
      }

      if($_POST['postVoiceID'] == 7) {
        $_SESSION['postVoiceID7_value'] = "selected";
      }
  
      if($_POST['postVoiceID'] == 8) {
        $_SESSION['postVoiceID8_value'] = "selected";
      }   
  
      if($_POST['postVoiceID'] == 9) {
        $_SESSION['postVoiceID9_value'] = "selected";
      }
  
      if($_POST['postVoiceID'] == 10) {
       $_SESSION['postVoiceID10_value'] = "selected";
      }
  
      if($_POST['postVoiceID'] == 11) {
        $_SESSION['postVoiceID11_value'] = "selected";
      }

    }/*end if isset post postVoiceID*/


 /*Now let's look at all the options related to ensemble*/
    if(isset($_POST['postEnsembleID'])) {
      
      if($_POST['postEnsembleID'] == 18) {
        $_SESSION['postEnsembleID18_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 1) {
        $_SESSION['postEnsembleID1_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 2) {
        $_SESSION['postEnsembleID2_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 3) {
        $_SESSION['postEnsembleID3_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 4) {
        $_SESSION['postEnsembleID4_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 5) {
        $_SESSION['postEnsembleID5_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 6) {
        $_SESSION['postEnsembleID6_value'] = "selected";
      }

      if($_POST['postEnsembleID'] == 7) {
        $_SESSION['postEnsembleID17_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 8) {
        $_SESSION['postEnsembleID7_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 9) {
        $_SESSION['postEnsembleID8_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 10) {
        $_SESSION['postEnsembleID9_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 11) {
        $_SESSION['postEnsembleID10_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 12) {
        $_SESSION['postEnsembleID11_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 13) {
        $_SESSION['postEnsembleID12_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 14) {
        $_SESSION['postEnsembleID13_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 15) {
        $_SESSION['postEnsembleID14_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 16) {
        $_SESSION['postEnsembleID15_value'] = "selected";
      }
      
      if($_POST['postEnsembleID'] == 17) {
        $_SESSION['postEnsembleID16_value'] = "selected";
      }

      

      }/*end if isset post postEnsembleID*/



       /*Now let's look at all the options related to GenDiff*/
    if(isset($_POST['postGenDiffID'])) {
      
      if($_POST['postGenDiffID'] == 10) {
        $_SESSION['postGenDiffID10_value'] = "selected";
      }
      
      if($_POST['postGenDiffID'] == 1) {
        $_SESSION['postGenDiffID1_value'] = "selected";
      }
      
      if($_POST['postGenDiffID'] == 2) {
        $_SESSION['postGenDiffID2_value'] = "selected";
      }
      
      if($_POST['postGenDiffID'] == 3) {
        $_SESSION['postGenDiffID3_value'] = "selected";
      }
      
      if($_POST['postGenDiffID'] == 4) {
        $_SESSION['postGenDiffID4_value'] = "selected";
      }
      
      if($_POST['postGenDiffID'] == 5) {
        $_SESSION['postGenDiffID5_value'] = "selected";
      }
      
      if($_POST['postGenDiffID'] == 6) {
        $_SESSION['postGenDiffID6_value'] = "selected";
      }
      
      if($_POST['postGenDiffID'] == 7) {
        $_SESSION['postGenDiffID7_value'] = "selected";
      }
      
      if($_POST['postGenDiffID'] == 8) {
        $_SESSION['postGenDiffID8_value'] = "selected";
      }
      
      if($_POST['postGenDiffID'] == 9) {
        $_SESSION['postGenDiffID9_value'] = "selected";
      }

    }/*end if(!isset($_POST['postGenDiffID']*/




     /*Now let's look at all the checkboxes related to ASPDiff*/
     if(isset($_POST['postASPDiffID'])) {
      
      if($_POST['postASPDiffID'] == 34) {
        $_SESSION['postASPDiffID33_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 11) {
        $_SESSION['postASPDiffID11_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 12) {
        $_SESSION['postASPDiffID12_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 13) {
        $_SESSION['postASPDiffID13_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 14) {
        $_SESSION['postASPDiffID14_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 15) {
        $_SESSION['postASPDiffID15_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 16) {
        $_SESSION['postASPDiffID16_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 17) {
        $_SESSION['postASPDiffID17_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 18) {
        $_SESSION['postASPDiffID18_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 19) {
        $_SESSION['postASPDiffID19_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 20) {
        $_SESSION['postASPDiffID20_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 21) {
        $_SESSION['postASPDiffID21_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 22) {
        $_SESSION['postASPDiffID22_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 23) {
        $_SESSION['postASPDiffID23_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 24) {
        $_SESSION['postASPDiffID24_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 25) {
        $_SESSION['postASPDiffID25_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 26) {
        $_SESSION['postASPDiffID26_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 27) {
        $_SESSION['postASPDiffID27_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 28) {
        $_SESSION['postASPDiffID28_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 29) {
        $_SESSION['postASPDiffID29_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 30) {
        $_SESSION['postASPDiffID30_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 31) {
        $_SESSION['postASPDiffID31_value'] = "selected";
      }
      
      if($_POST['postASPDiffID'] == 32) {
        $_SESSION['postASPDiffID32_value'] = "selected";
      }

       if($_POST['postASPDiffID'] == 33) {
         $_SESSION['postASPDiffID33_value'] = "selected";
       }

     }/*end if(!isset($_POST['postASPDiffID']*/
     

    header('Location: addCompositionCurrentBook.php');
    exit();

  }/*end if $validationFailed*/
  






/*here I am attempting to create an insert for the Composition info from add composition*/

/*EXAMPLE*/
 /*create the insert query to add the user's book info into the books table
 $bookInsertQuery = <<<_END

 INSERT INTO books (title, tag1, tag2, book_vol, book_num)
 VALUES('$BookTitle','$Tag1', '$Tag2', '$BookVolume', '$BookNumber');

_END;

 echo ("\n bookInsertQuery= " . $bookInsertQuery . "\n<br/>");

 /*send query and place result into this variable
 $bookInsertQueryResult = $conn->query($bookInsertQuery);


 if (!$bookInsertQueryResult) echo ("\n Error description bookInsertQueryResult: " . mysqli_error($conn) . "\n<br/>");

/*Now, get fresh book info from the database */


/*create the insert query to add the composition information into the compositions table*/

/*Get all the fields from the form*/
  /*wash the data coming in from user form pg 32 addBookInfo.php*/

  $washPostVar = cleanup_post($_POST['compName']);
  $compName = strip_before_insert($conn, $washPostVar); 
  
  $washPostVar = cleanup_post($_POST['opus']);
  $opusLike = strip_before_insert($conn, $washPostVar);
  
  $washPostVar = cleanup_post($_POST['opusNum']);
  $opusNum = strip_before_insert($conn, $washPostVar);
  


  if(!is_int(filter_input(INPUT_POST, "opusNum", FILTER_VALIDATE_INT))) {
    $opusNum = 'NULL';
  }

  $washPostVar = cleanup_post($_POST['compNum']);
  $compNo = strip_before_insert($conn, $washPostVar);

  if(!is_int(filter_input(INPUT_POST, "compNum", FILTER_VALIDATE_INT))) {
    $compNo = 'NULL';
  }

  
  $washPostVar = cleanup_post($_POST['subTitle']);
  $subtitle = strip_before_insert($conn, $washPostVar);
  
  $washPostVar = cleanup_post($_POST['bookID']);
  $thisBookID = strip_before_insert($conn, $washPostVar);
  
  $washPostVar = cleanup_post($_POST['movement']);
  $movement = strip_before_insert($conn, $washPostVar);
  
  $washPostVar = cleanup_post($_POST['postEraID']);
  $eraID = strip_before_insert($conn, $washPostVar);

  $washPostVar = cleanup_post($_POST['postVoiceID']);
  $voiceID = strip_before_insert($conn, $washPostVar);
  
  $washPostVar = cleanup_post($_POST['postEnsembleID']);
  $ensembleID = strip_before_insert($conn, $washPostVar);


  $washPostArrayElement = cleanup_post_array($_POST['postKeySigID']);
  $keySigID = strip_array_before_insert($conn, $washPostArrayElement);


  $washPostArrayElement = cleanup_post_array($_POST['postGenreID']);
  $genreID = strip_array_before_insert($conn, $washPostArrayElement);

  $washPostArrayElement = cleanup_post_array($_POST['postInstrumentID']);
  $instrumentID = strip_array_before_insert($conn, $washPostArrayElement);

  if($debug) {
    echo 'hello 4' . '<br/>';
  }/*end debug*/

  $washPostVar = cleanup_post($_POST['postGenDiffID']);
  $genDiffID = strip_before_insert($conn, $washPostVar);

if($debug) {
  echo 'hello 5' . '<br/>';
}/*end debug*/

  $washPostVar = cleanup_post($_POST['postASPDiffID']);
  $ASPDiffID = strip_before_insert($conn, $washPostVar);


if($debug) {
  echo 'hello 6' . '<br/>';
   }/*end debug*/
  




$compositionInsertQuery = <<<_END
INSERT INTO compositions (comp_name, opus_like, comp_num, comp_no, parent_comp_ID, subtitle, book_ID, movement, era_ID, voice_ID, ensemble_ID)
VALUES('$compName' , '$opusLike', $opusNum , $compNo , NULL , '$subtitle' , $thisBookID , '$movement' , $eraID , $voiceID , $ensembleID);

_END;

if($debug) {
echo ("\n compositionInsertQuery= " . $compositionInsertQuery . "\n<br/>");
}/*end debug*/

 /*send query and place result into this variable*/
 $compositionInsertQueryResult = $conn->query($compositionInsertQuery);

if($debug) {
 if (!$compositionInsertQueryResult) echo ("\n Error description compositionInsertQuery: " . mysqli_error($conn) . "\n<br/>");
 }/*end debug*/

 /*Here I will want to get the composition ID I just created*/
 $compositionID = $conn->insert_id;

if($debug) {
echo 'compositionID = ' . $compositionID . '<br/>';
}/*end debug*/

/*for testing purposes only, I'm creating fake key sig id Array*/
  /*$keySigID = [1, 2, 3];*/

 /*Now, insert into   C2K*/

 /*Here i must go find the id number for each key signature entered by the user and insert a row into the C2K table */
  if(!is_array($keySigID)) {
    if($debug) {
      echo '$keySigID is not an array' . $keySigID;
    }/*end debug*/
  }else{
    foreach ($keySigID as &$value) {
      if($debug) {
        echo $keySigID . " = " . $value;
      }/*end debug*/
      $C2KInsertQuery = <<<_END
        INSERT INTO C2K (composition_ID, keysig_ID)
        VALUES ('$compositionID', '$value');

_END;

      if($debug) {
        echo("\n C2KInsertQuery= " . $C2KInsertQuery . "\n<br/>");
      }/*end debug*/

      /*send query and place result into this variable*/
      $C2KInsertQueryResult = $conn->query($C2KInsertQuery);

      if($debug) {
        if (!$C2KInsertQueryResult) echo("\n Error description C2KInsertQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/
    }/*end foreach keysig Array*/
  }/*end if is array*/




  /*Now, insert into    C2G*/

 /*Here i must go find the id number for each genre entered by the user and insert a row into the C2G table */
if(!is_array($keySigID)) {
  if($debug) {
    echo '$keySigID is not an array' . $keySigID;
  }/*end debug*/
}else{
  foreach ($genreID as &$value) {
    $C2GInsertQuery = <<<_END
    INSERT INTO C2G (composition_ID, genre_ID)
    VALUES ('$compositionID', '$value');

_END;

    if($debug) {
      echo("\n C2GInsertQuery= " . $C2GInsertQuery . "\n<br/>");
    }/*end debug*/

    /*send query and place result into this variable*/
    $C2GInsertQueryResult = $conn->query($C2GInsertQuery);

    if($debug) {
    if (!$C2GInsertQueryResult) echo("\n Error description C2GInsertQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

  }/*end foreach genre Array*/

}/*!is_array($keySigID)*/


 /*Now, insert into C2I*/
 /*Here i must go find the id number for each instrument entered by the user and insert a row into the C2I table */
  if(!is_array($instrumentID)) {
    if($debug) {
      echo '$instrumentID is not an array' . $instrumentID;
    }/*end debug*/

  }else{
    foreach ($instrumentID as &$value) {
      $C2IInsertQuery = <<<_END
        INSERT INTO C2I (composition_ID, instrument_ID)
        VALUES ('$compositionID', '$value');

_END;

      if($debug) {
        echo("\n C2IInsertQuery= " . $C2IInsertQuery . "\n<br/>");
      }/*end debug*/

      /*send query and place result into this variable*/
      $C2IInsertQueryResult = $conn->query($C2IInsertQuery);

      if($debug) {
        if (!$C2IInsertQueryResult) echo("\n Error description C2IInsertQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/
    }/*end foreach instrument Array*/
  }/* end instrument is array*/

 /*Now, insert into C2D the first time for General difficulty*/
 $C2DInsertQuery = <<<_END
 INSERT INTO C2D (composition_ID, difficulty_ID)
 VALUES ('$compositionID', '$genDiffID');

_END;

if($debug) {
  echo ("\n C2DInsertQuery= " . $C2DInsertQuery . "\n<br/>");
}/*end debug*/

  /*send query and place result into this variable*/
  $C2DInsertQueryResult = $conn->query($C2DInsertQuery);

if($debug) {
 if (!$C2DInsertQueryResult) echo ("\n Error description C2DInsertQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/




 /*Now, insert into C2D for a second time for ASP difficulty*/
 $C2DInsertQuery = <<<_END
 INSERT INTO C2D (composition_ID, difficulty_ID)
 VALUES ('$compositionID', '$ASPDiffID');

_END;

if($debug) {
  echo ("\n C2DInsertQuery= " . $C2DInsertQuery . "\n<br/>");
}/*end debug*/

 /*send query and place result into this variable*/
 $C2DInsertQueryResult = $conn->query($C2DInsertQuery);

if($debug) {
 if (!$C2DInsertQueryResult) echo ("\n Error description C2DInsertQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/




/*Now, get fresh book and composition info from the database */




/*Get new book information for book with the id of post 'bookID' from database*/
/*if(isset($_POST['bookID'])) {*/

  $bookQuery  = "SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix
    FROM books AS b
    LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
    LEFT JOIN roles AS r_p ON r_p.ID = B2R2P.role_ID AND r_p.role_name = 'Editor'
    LEFT JOIN people AS p ON p.ID = B2R2P.people_ID
    LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
    LEFT JOIN roles AS r_o ON r_o.ID = B2R2O.role_ID AND r_o.role_name = 'Publisher'
    LEFT JOIN organizations AS o ON o.ID = B2R2O.org_ID

    WHERE b.ID = " . $_POST['bookID'];

  /*Send Query*/
  $resultBookQuery = $conn->query($bookQuery);

if($debug) {
  echo 'bookQuery = ' . $bookQuery . '<br/><br/>';

  if (!$resultBookQuery) echo ("\n Error description bookQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

  if ($resultBookQuery) {
    $numberOfBookRows = $resultBookQuery->num_rows;

    for ($j = 0 ; $j < $numberOfBookRows ; ++$j) {
      $row = $resultBookQuery->fetch_array(MYSQLI_NUM);
      /*Don't need to sanitize these they come from the db not the user*/
      $bookID = ($row[0]);
      $bookTitle = ($row[1]);
      $bookTag1 = ($row[2]);
      $bookTag2 = ($row[3]);
      $bookVolume = ($row[4]);
      $bookNumber = ($row[5]);
      $publisherName = ($row[6]);
      $publisherLocation = ($row[7]);
      $editorFirstName = ($row[8]);
      $editorMiddleName = ($row[9]);
      $editorLastName = ($row[10]);
      $editorSuffix = ($row[11]);
  
    }  /*end forloop*/


    echo <<<_END
    <!-- first div container of the page -->
        <div class="container-fluid bg-light pt-4 pb-2"> 
          
          <div class="row">
            <div class="col-md-6 ">
              <h3>Book Info</h3>
              Book Title: $bookTitle<br/>
              Tag 1: $bookTag1<br/>
              Tag 2: $bookTag2<br/>
              Book Volume: $bookVolume<br/>
              Book Number: $bookNumber<br/>
              Editor: $editorFirstName $editorMiddleName $editorLastName $editorSuffix<br/>
              Publisher: $publisherName $publisherLocation<br/><br/><br/> 
            </div> <!-- end col -->
          </div> <!-- end row -->
        </div> <!-- end container 1 -->

_END;

 } /* end if result book query */


 

/*printed out header, now we will loop through results set and display one loop per row*/

/*this page is similar to the book display page (3) but now we are displaying the compositions belonging to a specific book. The query should reflect the compositions belonging to a particular book.  */




/*Create a query string that gets all the easy composition info for every composition in the specific book*/
if($debug) {
  echo 'Testing 1' . "<br/>";
}/*end debug*/

  $compositionQuery = <<<_END
    SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, e.description,v.voicing_type, ens.ensemble_type, c.book_ID, p_composer.firstname,p_composer.middlename, p_composer.lastname, p_composer.suffix, p_arranger.firstname, p_arranger.middlename, p_arranger.lastname, p_arranger.suffix, p_lyricist.firstname,p_lyricist.middlename, p_lyricist.lastname, p_lyricist.suffix
    FROM compositions AS c
    LEFT JOIN eras AS e ON c.era_ID = e.ID
    LEFT JOIN voicing AS v ON c.voice_ID = v.ID
    LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
    LEFT JOIN books AS b ON c.book_ID = b.ID
    LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID 
    LEFT JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID 
    LEFT JOIN roles AS r_arranger ON C2R2P.role_ID = r_arranger.ID 
    LEFT JOIN roles AS r_lyricist ON C2R2P.role_ID = r_lyricist.ID 
    LEFT JOIN people AS p_composer ON C2R2P.people_ID = p_composer.ID AND r_composer.role_name = 'Composer'
    LEFT JOIN people AS p_arranger ON C2R2P.people_ID = p_arranger.ID AND r_arranger.role_name = 'Arranger'
    LEFT JOIN people AS p_lyricist ON C2R2P.people_ID = p_lyricist.ID AND r_lyricist.role_name = 'Lyricist'

    WHERE c.book_ID = $bookID;

_END;

  $resultCompositionQuery = $conn->query($compositionQuery);
  if($debug) {
  echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';
 
  if (!$resultCompositionQuery) echo ("\n Error description resultCompositionQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  if ($resultCompositionQuery) {     
    $numberOfCompositionRows = $resultCompositionQuery->num_rows;
    if($debug) {
        echo 'rows = ' . $numberOfCompositionRows . '<br/><br/>';
        }/*end debug*/

    $compositionsFound1 = ($numberOfCompositionRows > 0);
    $compositionsNotFound1 = ($numberOfCompositionRows === 0);

    if($compositionsFound1) {

      echo <<<_END

      <div class="container-fluid bg-secondary pt-4 pb-2"> 
        <h5 class="text-light pb-2">Choose a composition below. Then click on the "Choose this Composition" button to continue.</h5>
      </div> <!--end container-->

_END;

    } /*end if compositionsFound1*/

    if ($compositionsNotFound1) {
        if($debug) {
            echo 'Testing 2' . "<br/>";
            }/*end debug*/

      echo <<<_END
      
      <div class="container-fluid bg-secondary pt-4 pb-2"> 
        <h3 class= "display-4 text-light" > Bummer! </h3>
        <h3>No composition with the title of "$bookTitle" was found. <br/><br/><br/></h3> 
        <h4 class="text-light pb-3">Choose an option below <br/></h4>
        <form action='compositionSearch.php' method='post'>
          <button class="btn btn-light" type='submit'>Try another Composition Search</button><br/>
          <input type="hidden" name="bookID" value="$bookID"> 
        </form><br/>
        <form action='addCompositionCurrentBook.php' method='post'>
          <button class="btn btn-light" type='submit'>Add New Composition Information</button><br/>
          <input type="hidden" name="bookID" value="$bookID">    
        </form>
    
      
_END;
      
      
    } /*End if compositionsNotFound1*/

    echo <<<_END

    <div class="container-fluid bg-secondary pt-4 pb-2">

_END;

    /*Composition Loop: Now loop through each row returned by the query. Each row is one composition.*/
    for ($i = 0 ; $i < $numberOfCompositionRows ; ++$i) {
      /*  echo 'i at start of loop = ' . $i . '<br/><br/>';    */
      $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);
      /* var_dump ($row);*/
      $compositionID = ($row[0]);
      $compName = ($row[1]);            
      $opusLike = ($row[2]);
      $compNum = ($row[3]);
      $compNo = ($row[4]);
      $subTitle = ($row[5]);                          
      $movement = ($row[6]);
      $era = ($row[7]);            
      $voice = ($row[8]);
      $ensemble = ($row[9]);
      $bookIDCheck = ($row[10]); 
      $composerFirstName = ($row[11]);
      $composerMiddleName = ($row[12]);
      $composerLastName = ($row[13]);
      $composerSuffix = ($row[14]);
      $arrangerFirstName = ($row[15]);
      $arrangerMiddleName = ($row[16]);
      $arrangerLastName = ($row[17]);
      $arrangerSuffix = ($row[18]);
      $lyricistFirstName = ($row[19]);
      $lyricistMiddleName = ($row[20]);
      $lyricistLastName = ($row[21]);
      $lyricistSuffix = ($row[22]);

  




    /*Retrieving all key signatures for this composition
    I will also be creating a comma separated list to use in the displayed information*/
   
    $selectKeySigQuery = <<<_END
       
      SELECT  k.key_name
      FROM C2K 
      LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
      WHERE C2K.composition_ID = $compositionID;

_END;

    $resultSelectKeySigQuery = $conn->query($selectKeySigQuery);
    /*echo '$selectKeySigQuery = ' . $selectKeySigQuery . '<br/><br/>';*/

    if($debug) {
    if (!$resultSelectKeySigQuery) echo ("\n Error description selectKeySigQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    if ($resultSelectKeySigQuery) {     

      $numKeySigRows = $resultSelectKeySigQuery->num_rows;
      /*Build comma separated list of key signatures in a string*/

      $keySignatureString = "";

      for ($j = 0 ; $j < $numKeySigRows ; ++$j) {
        $row = $resultSelectKeySigQuery->fetch_array(MYSQLI_NUM);
        /* var_dump ($row);*/
        $keySigName = ($row[0]);
                              
      } /*for loop ending*/

      /*$keySigString = implode(',',$sigVal);*/
      $keySignatureString .= $keySigName.","; 
    
    } /*End if result kesig query*/

    $displayKeySigString = rtrim($keySignatureString,',');



    /*Retrieving all key genres for this composition
    I will also be creating a comma separated list to use in the displayed information*/
    $selectGenresQuery = <<<_END

      SELECT  g.genre_type
      FROM C2G 
      LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
      WHERE C2G.composition_ID = $compositionID;

_END;

  $resultSelectGenresQuery = $conn->query($selectGenresQuery);
  if($debug) {
     echo '$selectGenresQuery = ' . $selectGenresQuery . '<br/><br/>';

    if (!$resultSelectGenresQuery) echo ("\n Error description selectGenresQuery: " . mysqli_error($conn) . "\n<br/>");
     }/*end debug*/

    if ($resultSelectGenresQuery) {     

      $numGenreRows = $resultSelectGenresQuery->num_rows;
      /*Build comma separated list of genres in a string*/
      $genreString= "";

      for ($j = 0 ; $j < $numGenreRows ; ++$j) {
        $row = $resultSelectGenresQuery->fetch_array(MYSQLI_NUM);
        /* var_dump ($row);*/

          
        $genreName = ($row[0]);

      } /*for loop ending*/

      $genreString .= $genreName.",";
      
    } /*End if resultSelectGenreQuery*/

    $displayGenreString = rtrim($genreString,',');






    /*Retrieving all instruments for this composition
    I will also be creating a comma separated list to use in the displayed information*/
    $selectInstrumentQuery = <<<_END
      SELECT  i.instr_name
      FROM C2I 
      LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID
      WHERE C2I.composition_ID = $compositionID;

_END;

    $resultSelectInstrumentQuery = $conn->query($selectInstrumentQuery);
    if($debug) {
        echo '$selectInstrumentQuery = ' . $selectInstrumentQuery . '<br/><br/>';

    if (!$resultSelectInstrumentQuery) echo ("\n Error description selectInstrumentQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    if ($resultSelectInstrumentQuery) {     
      $numInstrumentRows = $resultSelectInstrumentQuery->num_rows;
      /*Build comma separated list of instruments in a string*/
      $instrumentString= "";

      for ($j = 0 ; $j < $numInstrumentRows ; ++$j) {
        $row = $resultSelectInstrumentQuery->fetch_array(MYSQLI_NUM);
        /*var_dump ($row);*/
        $instrumentName = ($row[0]);
        /*$instrumentString = implode(',',$instVal);*/
        $instrumentString .= $instrumentName.",";
                
      } /*for loop ending*/

    } /*End if resultSelectinstrument query*/

    $displayInstrumentString = rtrim($instrumentString,',');





    /*Retrieving the General difficulty for this composition*/

    $selectGenDiffQuery = <<<_END
      SELECT  d.difficulty_level
      FROM compositions AS c 
      LEFT JOIN C2D ON c.ID = C2D.composition_ID
      LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
      JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'General'
      WHERE C2D.composition_ID = $compositionID;
        
_END;

    $resultselectGenDiffQuery = $conn->query($selectGenDiffQuery);

    if($debug) {
        echo '$selectGenDiffQuery = ' . $selectGenDiffQuery . '<br/><br/>';

    if (!$resultselectGenDiffQuery) echo ("\n Error description selectGenDiffQuery: " . mysqli_error($conn) . "\n<br/>");
     }/*end debug*/

    if ($resultselectGenDiffQuery) {     
      $numGDiffRows = $resultselectGenDiffQuery->num_rows;

      for ($j = 0 ; $j < $numGDiffRows ; ++$j)  {
        $row = $resultselectGenDiffQuery->fetch_array(MYSQLI_NUM);
        /* var_dump ($row);*/
        $GenDiffName = ($row[0]);
      } /*for loop ending*/
      
    } /*End if result select gendiff query*/

    /*Retrieving the ASP difficluty for this composition*/
    $selectASPDiffQuery = <<<_END

      SELECT  d.difficulty_level
      FROM compositions AS c 
      LEFT JOIN C2D ON c.ID = C2D.composition_ID
      LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
      JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'ASP'
      WHERE C2D.composition_ID = $compositionID;
        
_END;

    $resultselectASPDiffQuery = $conn->query($selectASPDiffQuery);
    if($debug) {
        echo '$selectASPDiffQuery = ' . $selectASPDiffQuery . '<br/><br/>';

    if (!$resultselectASPDiffQuery) echo ("\n Error description selectASPDiffQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    if ($resultselectASPDiffQuery) {     
      $numASPDiffRows = $resultselectASPDiffQuery->num_rows;

      for ($j = 0 ; $j < $numASPDiffRows ; ++$j) {
        $row = $resultselectASPDiffQuery->fetch_array(MYSQLI_NUM);
        /* var_dump ($row);*/
  
        $ASPDiffName = ($row[0]);
              
      } /*for loop ending*/
      
    } /*End if result select ASPdiff query*/


    /*Here we hold all of the information about each composition belonging to a specfic book. Because it is in our for loop, each composition found with the bookID we are working with, will have this block of information displayed on our page.*/
        echo <<<_END
         
    <div class="row">
      <div class="col">
        <div class="card  mb-3">
          <div class="card-body bg-light">
            <form class="mt-4" action='composerSearch.php' method='post'>
            <div class="form-check">
              Composition Title: $compName<br>
              Opus or sim: $opusLike<br>
              Opus Number or sim: $compNum<br>
              Composition No.: $compNo<br>
              Subtitle: $subTitle<br>
              Key Signature: $displayKeySigString<br>
              Movement: $movement<br>
              Era: $era <br>
              Genre: $displayGenreString <br>
              Voice: $voice <br>
              Ensemble: $ensemble <br>
              Instrument: $displayInstrumentString <br>
              Composer: $composerFirstName $composerMiddleName $composerLastName $composerSuffix <br>
              Arranger: $arrangerFirstName $arrangerMiddleName $arrangerLastName $arrangerSuffix <br>
              Lyricist: $lyricistFirstName $lyricistMiddleName $lyricistLastName $lyricistSuffix <br>
              ASP difficulty: $ASPDiffName <br>
              General difficulty: $GenDiffName <br>

            
              <input class="mt-4 btn btn-secondary" type='submit' value='Choose this Composition'/>
              <input type="hidden" name="bookID" value="$bookID"/><br> 
              <input type="hidden" name="compositionID" value="$compositionID"/><br>
              </div> <!-- end form-check -->
            </form><br/><br/>
          </div> <!-- end card body -->
        </div> <!-- end card -->
      </div> <!-- end col -->
    </div> <!--end row-->
    
  
    

        

_END;
 
              


    } /*End Composition Loop :for loop ending that processes each composition*/

  echo <<<_END

  </div> <!--end container-->

_END;

  
  } /*End if result composition query*/

 
  if ($compositionsFound1) {


  echo <<<_END
  <div class="container-fluid bg-secondary pt-4 pb-2">
    <h2 class="pb-3 text-light" >None of these compositions match<h2/>
    <div class="form-row"> 
      <div class="col-auto ">
        <form action='addCompositionCurrentBook.php' method='post'>
            <button class="btn btn-light" type='submit'>Add a New Composition to this book</button>
            <input type="hidden" name="bookID" value="$bookID"><br>    
        </form>
      </div> <!-- end col -->
      </div> <!-- end row -->
    </div> <!-- end container -->
 

_END;


  
  }/*end if $compositionsFound1*/

/*}*/ /*end if isset Post book ID*/

}/*end if post compName*/














  /*In this section we will first handle any validation for the 'searchCompositionTitle" text field (from compositionSearch 34). Then we will search the data base for the Composition the user is looking for. They will have submitted the name of the composition they want in the text on pg 34, compositionSearch.php.*/

  $validationFailed = false;  /*A single place to track whether any validataion has failed*/
  $bookID = $_POST['bookID'];
 

  /*boilerplate is over, now validate, if needed.*/
  

if(isset($_POST['searchCompositionTitle'])) {
/*perform all validations needed for all fields*/

  if(empty($_POST['searchCompositionTitle'])) {
    $_SESSION['searchCompositionTitleErr'] = " * The Composition Title is required";
    $validationFailed = true;
  } /*end if empty post searchCompositionTitle*/

  /*If any validation failed, save all form values in sessions*/

  if($validationFailed) {
    $_SESSION['compositionSearch_validationFailed'] = true;
    $_SESSION['compositionSearch_searchCompositionTitle_value'] = $_POST['searchCompositionTitle'];
    $_SESSION['bookID'] = $_POST['bookID'];

    header('Location:compositionSearch.php');
    exit();
  }/*end if validationFailed*/
  



if(empty($bookID)) {
  $bookID = $_SESSION['bookID'];
} /*end if empty $bookID*/


/*Validation Over, now wash form A ('searchCompositionTitle') Post value and place in variable to be used later.*/

/*washes this user data*/

  $washPostVar = cleanup_post($_POST['searchCompositionTitle']);
  $searchCompositionTitle = strip_before_insert($conn, $washPostVar);

/*searches the database for the Composition the user is looking for*/

/*Create a query string that gets all the easy composition info for every composition in the specific book*/

$compositionQuery = <<<_END
  SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, e.description,v.voicing_type, ens.ensemble_type, c.book_ID, p_composer.firstname, p_composer.middlename, p_composer.lastname, p_composer.suffix, p_arranger.firstname, p_arranger.middlename, p_arranger.lastname, p_arranger.suffix, p_lyricist.firstname, p_lyricist.middlename, p_lyricist.lastname, p_lyricist.suffix
  FROM compositions AS c
  LEFT JOIN eras AS e ON c.era_ID = e.ID
  LEFT JOIN voicing AS v ON c.voice_ID = v.ID
  LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
  LEFT JOIN books AS b ON c.book_ID = b.ID
  LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID 
  LEFT JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID 
  LEFT JOIN roles AS r_arranger ON C2R2P.role_ID = r_arranger.ID 
  LEFT JOIN roles AS r_lyricist ON C2R2P.role_ID = r_lyricist.ID 
  LEFT JOIN people AS p_composer ON C2R2P.people_ID = p_composer.ID AND r_composer.role_name = 'Composer'
  LEFT JOIN people AS p_arranger ON C2R2P.people_ID = p_arranger.ID AND r_arranger.role_name = 'Arranger'
  LEFT JOIN people AS p_lyricist ON C2R2P.people_ID = p_lyricist.ID AND r_lyricist.role_name = 'Lyricist'

  WHERE c.book_ID = $bookID AND c.comp_name = '$searchCompositionTitle';

_END;

$resultCompositionQuery = $conn->query($compositionQuery);

if($debug) {
echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';

if (!$resultCompositionQuery) echo ("\n Error description compositionQuery2: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

if ($resultCompositionQuery) {     
$numberOfCompositionRows = $resultCompositionQuery->num_rows;

if($debug) {
echo 'rows = ' . $numberOfCompositionRows . '<br/><br/>';
}/*end debug*/

$compositionsFound1 = ($numberOfCompositionRows > 0);
$compositionsNotFound1 = ($numberOfCompositionRows === 0);

if($compositionsFound1) {

echo <<<_END

<div class="container-fluid bg-secondary pt-4 pb-2"> 
<h5 class="text-light pb-2"> Click on the "Choose this Composition" button to continue.</h5>
</div> <!--end container-->

_END;

} /*end if compositionsFound1*/

if ($compositionsNotFound1) {

echo <<<_END

  <div class="container-fluid bg-secondary pt-4 pb-2"> 
    <h3 class= "display-4 text-light" > Bummer! </h3>
    <h3>No composition with the title of "$searchCompositionTitle" was found. <br/><br/><br/></h3> 
    <h4 class="text-light pb-3">Choose an option below <br/></h4>
    <form action='compositionSearch.php' method='post'>
      <button class="btn btn-light" type='submit'>Try another Composition Search</button><br/>
      <input type="hidden" name="bookID" value="$bookID"> 
    </form><br/>
    <form action='addCompositionCurrentBook.php' method='post'>
      <button class="btn btn-light" type='submit'>Add New Composition Information</button><br/>
      <input type="hidden" name="bookID" value="$bookID">    
    </form>


_END;


} /*End if compositionsNotFound1*/

echo <<<_END

<div class="container-fluid bg-secondary pt-4 pb-2">

_END;

/*Composition Loop: Now loop through each row returned by the query. Each row is one composition.*/
for ($i = 0 ; $i < $numberOfCompositionRows ; ++$i) {
/*  echo 'i at start of loop = ' . $i . '<br/><br/>';    */
$row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);
/* var_dump ($row);*/
$compositionID = ($row[0]);
$compName = ($row[1]);            
$opusLike = ($row[2]);
$compNum = ($row[3]);
$compNo = ($row[4]);
$subTitle = ($row[5]);                          
$movement = ($row[6]);
$era = ($row[7]);            
$voice = ($row[8]);
$ensemble = ($row[9]);
$bookIDCheck = ($row[10]); 
$composerFirstName = ($row[11]);
$composerMiddleName = ($row[12]);
$composerLastName = ($row[13]);
$composerSuffix = ($row[14]);
$arrangerFirstName = ($row[15]);
$arrangerMiddleName = ($row[16]);
$arrangerLastName = ($row[17]);
$arrangerSuffix = ($row[18]);
$lyricistFirstName = ($row[19]);
$lyricistMiddleName = ($row[20]);
$lyricistLastName = ($row[21]);
$lyricistSuffix = ($row[22]);






/*Retrieving all key signatures for this composition
I will also be creating a comma separated list to use in the displayed information*/

$selectKeySigQuery = <<<_END

SELECT  k.key_name
FROM C2K 
LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
WHERE C2K.composition_ID = $compositionID;

_END;

$resultSelectKeySigQuery = $conn->query($selectKeySigQuery);

if($debug) {
    echo '$selectKeySigQuery = ' . $selectKeySigQuery . '<br/><br/>';

if (!$resultSelectKeySigQuery) echo ("\n Error description selectKeySigQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

if ($resultSelectKeySigQuery) {     

$numKeySigRows = $resultSelectKeySigQuery->num_rows;
/*Build comma separated list of key signatures in a string*/

$keySignatureString = "";

for ($j = 0 ; $j < $numKeySigRows ; ++$j) {
$row = $resultSelectKeySigQuery->fetch_array(MYSQLI_NUM);
/* var_dump ($row);*/
$keySigName = ($row[0]);
                    
} /*for loop ending*/

/*$keySigString = implode(',',$sigVal);*/
$keySignatureString .= $keySigName.","; 

} /*End if result kesig query*/

$displayKeySigString = rtrim($keySignatureString,',');



/*Retrieving all key genres for this composition
I will also be creating a comma separated list to use in the displayed information*/
$selectGenresQuery = <<<_END

SELECT  g.genre_type
FROM C2G 
LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
WHERE C2G.composition_ID = $compositionID;

_END;

$resultSelectGenresQuery = $conn->query($selectGenresQuery);
if($debug) {
    echo '$selectGenresQuery = ' . $selectGenresQuery . '<br/><br/>';
    if (!$resultSelectGenresQuery) echo ("\n Error description selectGenresQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

if ($resultSelectGenresQuery) {     

$numGenreRows = $resultSelectGenresQuery->num_rows;
/*Build comma separated list of genres in a string*/
$genreString= "";

for ($j = 0 ; $j < $numGenreRows ; ++$j) {
$row = $resultSelectGenresQuery->fetch_array(MYSQLI_NUM);
/* var_dump ($row);*/


$genreName = ($row[0]);

} /*for loop ending*/

$genreString .= $genreName.",";

} /*End if resultSelectGenreQuery*/

$displayGenreString = rtrim($genreString,',');






/*Retrieving all instruments for this composition
I will also be creating a comma separated list to use in the displayeinformation*/
$selectInstrumentQuery = <<<_END
SELECT  i.instr_name
FROM C2I 
LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID
WHERE C2I.composition_ID = $compositionID;

_END;

$resultSelectInstrumentQuery = $conn->query($selectInstrumentQuery);

if($debug) {
    echo '$selectInstrumentQuery = ' . $selectInstrumentQuery . '<br/><br/>';
    if (!$resultSelectInstrumentQuery) echo ("\n Error description selectInstrumentQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

if ($resultSelectInstrumentQuery) {     
$numInstrumentRows = $resultSelectInstrumentQuery->num_rows;
/*Build comma separated list of instruments in a string*/
$instrumentString= "";

for ($j = 0 ; $j < $numInstrumentRows ; ++$j) {
$row = $resultSelectInstrumentQuery->fetch_array(MYSQLI_NUM);
/*var_dump ($row);*/
$instrumentName = ($row[0]);
/*$instrumentString = implode(',',$instVal);*/
$instrumentString .= $instrumentName.",";
      
} /*for loop ending*/

} /*End if resultSelectinstrument query*/

$displayInstrumentString = rtrim($instrumentString,',');





/*Retrieving the General difficluty for this composition*/

$selectGenDiffQuery = <<<_END
SELECT  d.difficulty_level
FROM compositions AS c 
LEFT JOIN C2D ON c.ID = C2D.composition_ID
LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'General'
WHERE C2D.composition_ID = $compositionID;

_END;

$resultselectGenDiffQuery = $conn->query($selectGenDiffQuery);
if($debug) {
    echo '$selectGenDiffQuery = ' . $selectGenDiffQuery . '<br/><br/>';
    if (!$resultselectGenDiffQuery) echo ("\n Error description selectGenDiffQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

if ($resultselectGenDiffQuery) {     
$numGDiffRows = $resultselectGenDiffQuery->num_rows;

for ($j = 0 ; $j < $numGDiffRows ; ++$j)  {
$row = $resultselectGenDiffQuery->fetch_array(MYSQLI_NUM);
/* var_dump ($row);*/
$GenDiffName = ($row[0]);
} /*for loop ending*/

} /*End if result select gendiff query*/

/*Retrieving the ASP difficulty for this composition*/
$selectASPDiffQuery = <<<_END

SELECT  d.difficulty_level
FROM compositions AS c 
LEFT JOIN C2D ON c.ID = C2D.composition_ID
LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'ASP'
WHERE C2D.composition_ID = $compositionID;

_END;

$resultselectASPDiffQuery = $conn->query($selectASPDiffQuery);

if($debug) {
    echo '$selectASPDiffQuery = ' . $selectASPDiffQuery . '<br/><br/>';
    if (!$resultselectASPDiffQuery) echo ("\n Error description selectASPDiffQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

if ($resultselectASPDiffQuery) {     
$numASPDiffRows = $resultselectASPDiffQuery->num_rows;

for ($j = 0 ; $j < $numASPDiffRows ; ++$j) {
$row = $resultselectASPDiffQuery->fetch_array(MYSQLI_NUM);
/* var_dump ($row);*/

$ASPDiffName = ($row[0]);
    
} /*for loop ending*/

} /*End if result select ASPdiff query*/


/*Here we hold all of the information about each composition belonging to a specfic book. Because it is in our for loop, each composition found with the bookID we are working with, will have this block of information displayed on our page.*/
echo <<<_END
 
<div class="row">
<div class="col">
<div class="card  mb-3">
  <div class="card-body bg-light">
    <form class="mt-4" action='composerSearch.php' method='post'>
    <div class="form-check">
      Composition Title: $compName<br>
      Opus or sim: $opusLike<br>
      Opus Number or sim: $compNum<br>
      Composition No.: $compNo<br>
      Subtitle: $subTitle<br>
      Key Signature: $displayKeySigString<br>
      Movement: $movement<br>
      Era: $era <br>
      Genre: $displayGenreString <br>
      Voice: $voice <br>
      Ensemble: $ensemble <br>
      Instrument: $displayInstrumentString <br>
      Composer: $composerFirstName $composerMiddleName $composerLastName $composerSuffix <br>
      Arranger: $arrangerFirstName $arrangerMiddleName $arrangerLastName $arrangerSuffix <br>
      Lyricist: $lyricistFirstName $lyricistMiddleName $lyricistLastName $lyricistSuffix <br>
      ASP difficulty: $ASPDiffName <br>
      General difficulty: $GenDiffName <br>

    
      <input class="mt-4 btn btn-secondary" type='submit' value='Choose this Composition'/>
      <input type="hidden" name="bookID" value="$bookID"/><br> 
      <input type="hidden" name="compositionID" value="$compositionID"/><br>
      </div> <!-- end form-check -->
    </form><br/><br/>
  </div> <!-- end card body -->
</div> <!-- end card -->
</div> <!-- end col -->
</div> <!--end row-->

_END;


} /*End Composition Loop :for loop ending that processes each composition*/



echo <<<_END

</div> <!--end container-->

_END;


} /*End if result composition query*/



if ($compositionsFound1) {


echo <<<_END
<div class="container-fluid bg-secondary pt-4 pb-2">
<h2 class="pb-3 text-light" >None of these compositions match<h2/>
<div class="form-row"> 
<div class="col-auto ">
<form action='addCompositionCurrentBook.php' method='post'>
  <button class="btn btn-light" type='submit'>Add a New Composition to this book</button>
  <input type="hidden" name="bookID" value="$bookID"><br>    
</form>
</div> <!-- end col -->
</div> <!-- end row -->
</div> <!-- end container -->


_END;



} /*end if $compositionsFound1*/

} /*end isset post searchCompositionTitle*/

 
include 'footer.html';
include 'endingBoilerplate.php';

?>






