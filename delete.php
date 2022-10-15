<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END

<p>delete.php-12</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

/*Initialize Variables*/
$bookID = "";
$compositionID = "";
$peopleID = "";
$orgID = "";
$compName = "";
$bookTitle = "";
$deleteEditor = "";
$deleteComposer = "";
$deleteArranger = "";
$deleteLyricist = "";
$deleteBook = "";
$deleteComposition = "";


$editBook = "";
$editComposition = "";
$oldOrgID = "";
$oldPeopleID = "";
$deletePublisher = "";




if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['compositionID']) && is_numeric($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}

if(isset($_REQUEST['peopleID']) && is_numeric($_REQUEST['peopleID'])) {
    $peopleID = $_REQUEST['peopleID'];
}

if(isset($_REQUEST['orgID']) && is_numeric($_REQUEST['orgID'])) {
    $orgID = $_REQUEST['orgID'];
}

if(isset($_REQUEST['oldOrgID']) && is_numeric($_REQUEST['oldOrgID'])) {
    $oldOrgID = $_REQUEST['oldOrgID'];
}

if(isset($_REQUEST['oldPeopleID']) && is_numeric($_REQUEST['oldPeopleID'])) {
    $oldPeopleID = $_REQUEST['oldPeopleID'];
}

if(isset($_REQUEST['compName'])) {
    $compName = $_REQUEST['compName'];
}

if(isset($_REQUEST['bookTitle'])) {
    $bookTitle = $_REQUEST['bookTitle'];
}

if(isset($_REQUEST['deleteEditor'])) {
    $deleteEditor = $_REQUEST['deleteEditor'];
}

if(isset($_REQUEST['deleteComposer'])) {
    $deleteComposer = $_REQUEST['deleteComposer'];
}

if(isset($_REQUEST['deleteArranger'])) {
    $deleteArranger = $_REQUEST['deleteArranger'];
}

if(isset($_REQUEST['deleteLyricist'])) {
    $deleteLyricist = $_REQUEST['deleteLyricist'];
}

if(isset($_REQUEST['deletePublisher'])) {
    $deletePublisher = $_REQUEST['deletePublisher'];
}

if(isset($_REQUEST['deleteBook'])) {
    $deleteBook = $_REQUEST['deleteBook'];
}

if(isset($_REQUEST['deleteComposition'])) {
    $deleteComposition = $_REQUEST['deleteComposition'];
}

if(isset($_REQUEST['editBook'])) {
    $editBook = $_REQUEST['editBook'];
}

if(isset($_REQUEST['editComposition'])) {
    $editComposition = $_REQUEST['editComposition'];
}

if(isset($_REQUEST['deletePublisher'])) {
    $deletePublisher = $_REQUEST['deletePublisher'];
}




/*Create logic for different situations*/
if($deleteEditor == 'true') {
    $role = 'Editor';
    $roleID = 4;
    $sendDelete = "<input type='hidden' name='deleteEditor' value='true' /> ";
    /*$deletePeople = $deleteEditor;*/  /*commenting this out because editor is different than composer, arranger, and Lyricist in that it is not from the composition. Don't always want editor to be defined by $deletePeople.*/
}

if($deleteComposer == 'true') {
    $role = 'Composer';
    $roleID = 1;
    $sendDelete = "<input type='hidden' name='deleteComposer' value='true' /> ";
    $deletePeople = $deleteComposer;
}

if($deleteArranger == 'true') {
    $role = 'Arranger';
    $roleID = 2;
    $sendDelete = "<input type='hidden' name='deleteArranger' value='true' /> ";
    $deletePeople = $deleteArranger;
}

if($deleteLyricist == 'true') {
    $role = 'Lyricist';
    $roleID = 3;
    $sendDelete = "<input type='hidden' name='deleteLyricist' value='true' /> ";
    $deletePeople = $deleteLyricist;
}


/*here we will wash variables that will be used in the dbqueries below*/
$washPostVar = cleanup_post($oldPeopleID);
$oldPeopleIDAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($oldOrgID);
$oldOrgIDAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($bookID);
$bookIDAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($compositionID);
$compositionIDAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($roleID);
$roleIDAltered = strip_before_insert($conn, $washPostVar);



/*Deleting an entire book*/
   if($deleteBook=='true'){


       $deleteB2R2P= <<<_END
         DELETE FROM b2r2p
         WHERE b2r2p.book_ID = '$bookIDAltered';

_END;

       if($debug) {
           echo 'deleteB2R2P = ' . $deleteB2R2P . '<br/><br/>';
       }/*end debug*/

       /*send the query*/
       $deleteB2R2PResult = $conn->query($deleteB2R2P);

       if($debug) {
           if (!$deleteB2R2PResult) echo("\n Error description deleteB2R2P: " . mysqli_error($conn) . "\n<br/>");
       }/*end debug*/

       failureToExecute ($deleteB2R2PResult, 'D804', 'Delete ' );



       if ($deleteB2R2PResult) {
           $deleteB2R2O = <<<_END
             DELETE FROM b2r2o
             WHERE b2r2o.book_ID = '$bookIDAltered';

_END;

           if ($debug) {
               echo 'deleteB2R2O = ' . $deleteB2R2O . '<br/><br/>';
           }/*end debug*/

           /*send the query*/
           $deleteB2R2OResult = $conn->query($deleteB2R2O);

           if ($debug) {
               if (!$deleteB2R2OResult) echo("\n Error description deleteB2R2O: " . mysqli_error($conn) . "\n<br/>");
           }/*end debug*/

           failureToExecute ($deleteB2R2OResult, 'D805', 'Delete ' );



           if ($deleteB2R2OResult) {
               $deleteC2I = <<<_END
                    DELETE FROM c2i
                    WHERE c2i.composition_ID  
                        IN (SELECT compositions.ID  FROM compositions WHERE book_ID  = '$bookIDAltered');
_END;

               if ($debug) {
                   echo 'deleteC2I = ' . $deleteC2I . '<br/><br/>';
               }/*end debug*/

               /*send the query*/
               $deleteC2IResult = $conn->query($deleteC2I);

               if ($debug) {
                   if (!$deleteC2IResult) echo("\n Error description deleteC2I: " . mysqli_error($conn) . "\n<br/>");
               }/*end debug*/

               failureToExecute ($deleteC2IResult, 'D806', 'Delete ' );



               if ($deleteC2IResult) {
                   $deleteC2K = <<<_END
                        DELETE FROM c2k
                        WHERE c2k.composition_ID  
                            IN (SELECT compositions.ID  FROM compositions WHERE book_ID  = '$bookIDAltered');
_END;

                   if ($debug) {
                       echo 'deleteC2K = ' . $deleteC2K . '<br/><br/>';
                   }/*end debug*/

                   /*send the query*/
                   $deleteC2KResult = $conn->query($deleteC2K);

                   if ($debug) {
                       if (!$deleteC2KResult) echo("\n Error description deleteC2K: " . mysqli_error($conn) . "\n<br/>");
                   }/*end debug*/

                   failureToExecute ($deleteC2KResult, 'D807', 'Delete ' );



                   if ($deleteC2KResult) {
                       $deleteC2D = <<<_END
                            DELETE FROM c2d
                            WHERE c2d.composition_ID  
                            IN (SELECT compositions.ID  FROM compositions WHERE book_ID  = '$bookIDAltered');
_END;

                       if ($debug) {
                           echo 'deleteC2D = ' . $deleteC2D . '<br/><br/>';
                       }/*end debug*/

                       /*send the query*/
                       $deleteC2DResult = $conn->query($deleteC2D);

                       if ($debug) {
                           if (!$deleteC2DResult) echo("\n Error description deleteC2D: " . mysqli_error($conn) . "\n<br/>");
                       }/*end debug*/

                       failureToExecute ($deleteC2DResult, 'D808', 'Delete ' );



                       if ($deleteC2DResult) {
                           $deleteC2G = <<<_END
                                DELETE FROM c2g
                                WHERE c2g.composition_ID  
                                    IN (SELECT compositions.ID  FROM compositions WHERE book_ID  = '$bookIDAltered');
_END;

                           if ($debug) {
                               echo 'deleteC2G = ' . $deleteC2G . '<br/><br/>';
                           }/*end debug*/

                           /*send the query*/
                           $deleteC2GResult = $conn->query($deleteC2G);

                           if ($debug) {
                               if (!$deleteC2GResult) echo("\n Error description deleteC2G: " . mysqli_error($conn) . "\n<br/>");
                           }/*end debug*/

                           failureToExecute ($deleteC2GResult, 'D809', 'Delete ' );



                           if ($deleteC2GResult) {
                                $deleteC2R2P = <<<_END
                                        DELETE FROM c2r2p
                                        WHERE c2r2p.composition_ID  
                                        IN (SELECT compositions.ID  FROM compositions WHERE book_ID  = '$bookIDAltered');
_END;

                                if ($debug) {
                                    echo 'deleteC2R2P = ' . $deleteC2R2P . '<br/><br/>';
                                }/*end debug*/

                                /*send the query*/
                                $deleteC2R2PResult = $conn->query($deleteC2R2P);

                                if ($debug) {
                                if (!$deleteC2R2PResult) echo("\n Error description deleteC2R2P: " . mysqli_error($conn) . "\n<br/>");
                                }/*end debug*/

                               failureToExecute ($deleteC2R2PResult, 'D810', 'Delete ' );


                                if ($deleteC2R2PResult) {
                                    $deleteCompositions = <<<_END
                                            DELETE FROM compositions
                                            WHERE compositions.book_ID = '$bookIDAltered';
_END;

                                    if ($debug) {
                                        echo 'deleteCompositions = ' . $deleteCompositions . '<br/><br/>';
                                    }/*end debug*/

                                    /*send the query*/
                                    $deleteCompositionsResult = $conn->query($deleteCompositions);

                                    if ($debug) {
                                    if (!$deleteCompositionsResult) echo("\n Error description deleteCompositions: " . mysqli_error($conn) . "\n<br/>");
                                        }/*end debug*/

                                    failureToExecute ($deleteCompositionsResult, 'D811', 'Delete ' );



                                    if ($deleteCompositionsResult) {

                                            $deleteBooks = <<<_END
                                                    DELETE FROM books
                                                    WHERE books.ID = '$bookIDAltered';
_END;

                                            if ($debug) {
                                                echo 'deleteBooks = ' . $deleteBooks . '<br/><br/>';
                                            }/*end debug*/

                                            /*send the query*/
                                            $deleteBooksResult = $conn->query($deleteBooks);

                                            if ($debug) {
                                                if (!$deleteBooksResult) echo("\n Error description deleteBooks: " . mysqli_error($conn) . "\n<br/>");
                                            }/*end debug*/

                                        failureToExecute ($deleteBooksResult, 'D812', 'Delete ' );



                                        if ($deleteBooksResult) {

                                                echo<<<_END
                                                   
                                                <h5 class="mt-4">"$bookTitle" and all its compositions has been deleted from the Library</h5></br></br>
      

                                                  <form action="introPage.php" method="post">
                                                     <input class="btn btn-secondary mt-4" type="submit" value="Search Library "/>
                                                  </form>  <!-- end form --></br>
                                                
                                                  <form action="exitMessage.php" method="post">
                                                     <input class="btn btn-secondary mt-4" type="submit" value="Exit Library "/>
                                                  </form>  <!-- end form --></br></br>
_END;


                                            } /*end $deleteBooksResult */
                                        } /*end $deleteCompositionsResult */
                                    } /*end $deleteC2R2PResult */
                                } /*end $deleteC2GResult */
                            } /*end $deleteC2DResult */
                        } /*end $deleteC2KResult */
                    } /*end $deleteC2IResult */
                } /*end $deleteB2R2OResult */
            }  /*end $deleteB2R2PResult */





        } /*end if $deleteBook == 'true' */












/*Deleting a Composition*/

/*Where have we come from?
editComposition.php*/


if($deleteComposition =='true') {




    $deleteC2I  =  <<<_END

    DELETE FROM c2i
    WHERE c2i.composition_ID = '$compositionIDAltered';

_END;

    if($debug) {
        echo 'deleteC2I = ' . $deleteC2I . '<br/><br/>';
    }/*end debug*/

    /*send the query*/
    $deleteC2IResult = $conn->query($deleteC2I);

    if($debug) {
        if (!$deleteC2IResult) echo("\n Error description deleteC2I: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    failureToExecute ($deleteC2IResult, 'D813', 'Delete ' );



    if ($deleteC2IResult){
        $deleteC2K  =  <<<_END

            DELETE FROM c2k
            WHERE c2k.composition_ID = '$compositionIDAltered';

_END;

        if($debug) {
            echo '$deleteC2K = ' . $deleteC2K . '<br/><br/>';
        }/*end debug*/

        /*send the query*/
        $deleteC2KResult = $conn->query($deleteC2K);

        if($debug) {
            if (!$deleteC2KResult) echo("\n Error description deleteC2K: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        failureToExecute ($deleteC2KResult, 'D814', 'Delete ' );



        if ($deleteC2KResult){
            $deleteC2D  =  <<<_END

                DELETE FROM c2d
                WHERE c2d.composition_ID = '$compositionIDAltered';

_END;

            if($debug) {
                echo 'deleteC2D = ' . $deleteC2D . '<br/><br/>';
            }/*end debug*/

            /*send the query*/
            $deleteC2DResult = $conn->query($deleteC2D);

            if($debug) {
                if (!$deleteC2DResult) echo("\n Error description deleteC2D: " . mysqli_error($conn) . "\n<br/>");
            }/*end debug*/

            failureToExecute ($deleteC2DResult, 'D815', 'Delete ' );



            if ($deleteC2DResult){
                $deleteC2G  =  <<<_END

                DELETE FROM c2g
                WHERE c2g.composition_ID  = '$compositionIDAltered';

_END;

                if($debug) {
                    echo 'deleteC2G = ' . $deleteC2G . '<br/><br/>';
                }/*end debug*/

                /*send the query*/
                $deleteC2GResult = $conn->query($deleteC2G);

                if($debug) {
                    if (!$deleteC2GResult) echo("\n Error description deleteC2G: " . mysqli_error($conn) . "\n<br/>");
                }/*end debug*/

                failureToExecute ($deleteC2GResult, 'D816', 'Delete ' );



                if ($deleteC2GResult){
                    $deleteC2R2P  =  <<<_END

                    DELETE FROM c2r2p
                    WHERE c2r2p.composition_ID =  '$compositionIDAltered';

_END;

                    if($debug) {
                        echo 'deleteC2R2P = ' . $deleteC2R2P . '<br/><br/>';
                    }/*end debug*/

                    /*send the query*/
                    $deleteC2R2PResult = $conn->query($deleteC2R2P);

                    if($debug) {
                        if (!$deleteC2R2PResult) echo("\n Error description deleteC2R2P: " . mysqli_error($conn) . "\n<br/>");
                    }/*end debug*/

                    failureToExecute ($deleteC2R2PResult, 'D817', 'Delete ' );



                    if ($deleteC2R2PResult){
                        $deleteCompositions  =  <<<_END

                        DELETE FROM compositions
                        WHERE compositions.ID = '$compositionIDAltered';

_END;

                        if($debug) {
                            echo 'deleteCompositions = ' . $deleteCompositions . '<br/><br/>';
                        }/*end debug*/

                        /*send the query*/
                        $deleteCompositionsResult = $conn->query($deleteCompositions);

                        if($debug) {
                            if (!$deleteCompositionsResult) echo("\n Error description deleteCompositions: " . mysqli_error($conn) . "\n<br/>");
                        }/*end debug*/

                        failureToExecute ($deleteCompositionsResult, 'D818', 'Delete ' );



                        if ($deleteCompositionsResult){
                            echo<<<_END
<h5>"$compName" has been deleted from the book "$bookTitle"</h5></br></br>

_END;





                            
                        } /*end if deleteCompositionsResult */
                    } /*end if deleteC2R2PResult */
                } /*end if deleteC2GResult */
            } /*end if deleteC2DResult */
        } /*end if deleteC2KResult */
    }/*end if delete C2I results */


    echo<<<_END

    <div class="form-style-10">
        <form action='displayBook.php' method='post'>
            <div class="button-section">
            <input class="btn btn-secondary mb-3"type='submit' value='Return to current Book'/>
            <input type='hidden' name='bookID' value= '$bookID'/>
            </div>
        </form>
    </div>

_END;

}/*end if isset deleteComposition*/








/*Deleting an Editor or Publisher from an existing Book*/

/*Where have we come from?
peopleOptions.php if we are deleting the editor
orgOptions.php if we re deleting the Publisher*/

if($editBook == 'true') {
    if ($deleteEditor == 'true') {


        $deleteEditorQuery =
            <<<_END
            DELETE FROM b2r2p
            WHERE b2r2p.book_ID = '$bookIDAltered'
            AND b2r2p.role_ID = 4
            AND b2r2p.people_ID = '$oldPeopleIDAltered';
            
_END;

        $deleteEditorQueryResult = $conn->query($deleteEditorQuery);

        if ($debug) {
            if (!$deleteEditorQueryResult) echo("\n Error description deleteEditorQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        failureToExecute ($deleteEditorQueryResult, 'D819', 'Delete ' );


        header('Location: editBook.php?bookID=' . $bookID . '&peopleID=' . $peopleID . '&editBook=true');
        exit();
    }elseif($deletePublisher =='true') {
        $deletePublisherQuery=
            <<<_END
 
        DELETE FROM b2r2o
        WHERE b2r2o.book_ID = '$bookIDAltered'
        AND b2r2o.role_ID = 5
        AND b2r2o.org_ID = '$oldOrgIDAltered';
        
_END;

        $deletePublisherQueryResult = $conn->query($deletePublisherQuery);

        if($debug) {
            if (!$deletePublisherQueryResult) echo("\n Error description deletePublisherQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        failureToExecute ($deletePublisherQueryResult, 'D820', 'Delete ' );


        if($deletePublisherQueryResult) {
            $deletePublisherFromBookSuccess = 'true';
        }

        header('Location: editBook.php?bookID=' . $bookID . '&orgID=' . $orgID . '&editBook=true' . '&deletePublisherFromBookSuccess=' . $deletePublisherFromBookSuccess);
        exit();
    }/*End if ($deleteEditor == 'true')*/


} /*End if($editBook == 'true')





/*Deleting a Composer, Arranger or Lyricist from an existing Composition*/

/*Where have we come from?
peopleOptions.php*/

if($editComposition == 'true') {
    if ($deletePeople == 'true') {
        $deletePeopleQuery =
            <<<_END
            DELETE FROM c2r29
            WHERE c2r2p.composition_ID = '$compositionIDAltered'
            AND c2r2p.role_ID = '$roleIDAltered'
            AND c2r2p.people_ID = '$oldPeopleIDAltered';
            
_END;

        $deletePeopleQueryResult = $conn->query($deletePeopleQuery);

        if ($debug) {
            if (!$deletePeopleQueryResult) echo("\n Error description deletePeopleQueryQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        failureToExecute ($deletePeopleQueryResult, 'D821', 'Delete ' );


        header('Location: editComposition.php?bookID=' . $bookID . '&compositionID=' . $compositionID . '&peopleID=' . $peopleID . '&editComposition=true');
        exit();
    } /*End if ($deleteEditor == 'true')*/
} /*End if($editBook == 'true')*/












include 'footer.php';
include 'endingBoilerplate.php';

?>










