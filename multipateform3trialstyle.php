<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
      integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
      crossorigin="anonymous"
    />

    <title>Bootstrap Sandbox</title>
  </head>

<body class="container mt-5">

<?php
/*step one*/
/*Page 1  Intro*/


  require_once 'login.php';
  $conn = new mysqli($hn ,$un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

$primaryKeyName ="ID";
$tableName = "books";

/*Let's print out what is in the post array each time this page wakes up.*/
echo <<<_END
 <h5> POST VALUES </h5>
_END;

     foreach ($_POST as $key => $value)
        echo $key.'='.$value.'<br />';


if (isset($_POST['delete']) && isset($_POST[$primaryKeyName]))
  {
    $primaryKeyValue   = get_post($conn, $primaryKeyName);
    $query  = "DELETE FROM " . $tableName . " WHERE " . $primaryKeyName . "= " . $primaryKeyValue;
    $result = $conn->query($query);
    if (!$result) echo("Error description: " . mysqli_error($conn));
  }



/*Page 1 Intro*/
if (!isset($_POST['next']))
  {
    
    include 'beginningNav.html';

echo <<<_END



  <div class="container bg-light">
  <p>PAGE ONE</p>
    <h1>Welcome to MusicLibrary 3</h1>
    <h3>Will you be searching for a book or a composition?<h3/p>
    
    <form action='multipageform2.php' method='post'>
      <div class="form-group mt-3 mb-3">
        <input class="btn btn-info" type='submit' value='Composition'/>
        <input type='hidden' name="next" value='showPage12'/>  
      </div>   
    </form>

    <form action='multipageform2.php' method='post'>
      <div class="form-group">    
        <input class="btn btn-info" type='submit' value='Book'>
        <input type='hidden' name="next" value='showPage2'/> 
      </div>  
    </form>
   </div>

_END;

  }





 /*Page 2 Book title search*/
elseif (isset($_POST['next']) && $_POST['next'] == 'showPage2')
  {

echo <<<_END

    <p>PAGE TWO "Book Title Search"</p>

_END;

    include 'beginningNav.html';

echo <<<_END



  <div class="container bg-light">
  
   
   <form action='multipageform2.php' method='post'>
    <div class="form-group  pt-3 pb-3">
    
      <label class="" for="bookTitle">Book Title Search</label>
      <input class="form-control" type="text" id="bookTitle" name="bookTitle" placeholder="Please enter book title or keyword" /><br/><br/>
        
    
     <input class="btn btn-secondary" type='submit' value='Search for this Book Title'/>
     <input type='hidden' name="next" value='showPage3'/>
    </div>
   </form>
  </div>

_END;

  }






 /*Page 3 Book Options */
elseif (isset($_POST['next']) && $_POST['next'] == 'showPage3')
  {

/*Lists books with similar title
if title is there, and radio button is checked, code moves to page 4 where book information is displayed and user is asked if they would like to edit or delete or add a new composition*/     
 /*all things that are always there*/ 
   $bookID = $_POST['bookID']; 
   $searchBookTitle = $_POST['bookTitle'];

echo <<<_END
  
   <p>PAGE THREE / Book options</p>

_END;

   include 'beginningNav.html';

echo <<<_END




<div class="contaier bg-light"
   <h2>Books similar to yours</h2>
   <h3>Choose an option below</h3>

   <form action='multipageform2.php' method='post'>
    <div class="form-group mt-3 mb-3">

_END;

/*printed out header, now we will loop through results set and display one radio per row*/
    if (isset($_POST['bookTitle'])) {
        $query  = "SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix
          FROM books AS b
          LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
          LEFT JOIN roles AS r_p ON r_p.ID = B2R2P.role_ID AND r_p.role_name = 'Editor'
          LEFT JOIN people AS p ON p.ID = B2R2P.people_ID
          LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
          LEFT JOIN roles AS r_o ON r_o.ID = B2R2O.role_ID AND r_o.role_name = 'Publisher'
          LEFT JOIN organizations AS o ON o.ID = B2R2O.org_ID

         
           WHERE b.title LIKE '%" .($_POST['bookTitle'])."%'";
          echo ("\n " . $query . "\n<br/>");
        $result = $conn->query($query);

       
        if (!$result) die ("Database access failed");

        $numberOfRows = $result->num_rows;

         $BookTitleFound = ($numberOfRows  > 0);
         $BookTitleNotFound = ($numberOfRows === 0);
          if ($BookTitleNotFound) {
           
            echo "<h3>No Book by the name of  \"" . $searchBookTitle . "\"  was found. <br/><br/> Would you like to add this Book information to the Library? <br/><br/>";
          } /*END if BookTitleNotFound*/

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $result->fetch_array(MYSQLI_NUM);

            $bookID = htmlspecialchars($row[0]);
            $bookTitle = htmlspecialchars($row[1]);
            $bookTag1 = htmlspecialchars($row[2]);
            $bookTag2 = htmlspecialchars($row[3]);
            $bookVolume = htmlspecialchars($row[4]);
            $bookNumber = htmlspecialchars($row[5]);
            $publisherName = htmlspecialchars($row[6]);
            $publisherLocation = htmlspecialchars($row[7]);
            $editorFirstName = htmlspecialchars($row[8]);
            $editorMiddleName = htmlspecialchars($row[9]);
            $editorLastName = htmlspecialchars($row[10]);
            $editorSuffix = htmlspecialchars($row[11]);

            echo <<<_END

            <div class="container bg-light">
            <p>PAGE ONE</p>
              <h1>Welcome to MusicLibrary 3</h1>
              <h3>Will you be searching for a book or a composition?<h3/p>
              
              <form action='multipageform2.php' method='post'>
                <div class="form-group mt-3 mb-3">
                  <input class="btn btn-info" type='submit' value='Composition'/>
                  <input type='hidden' name="next" value='showPage12'/>  
                </div>   
              </form>
            
              <form action='multipageform2.php' method='post'>
                <div class="form-group">    
                  <input class="btn btn-info" type='submit' value='Book'>
                  <input type='hidden' name="next" value='showPage2'/> 
                </div>  
              </form>
             </div>
             
            <div class="input-group mb-3">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input type="radio" />
          </div>
        </div>
        <input class="form-control" type="text" />
      </div>
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <br/><input type="radio" name="bookID" value="$bookID" />Book Title: $bookTitle<br>Book Tag 1: $bookTag1<br>Book Tag 2: $bookTag2<br>Book Volume: $bookVolume<br>Book Number: $bookNumber<br>Editor Name: $editorFirstName $editorMiddleName $editorLastName $editorSuffix<br>Publisher Name: $publisherName<br>Publisher Location: $publisherLocation/><br><br>
          </div> 
        </div>
      </div>
    
_END;

          } /*for loop ending*/

if ($BookTitleFound) {
    echo <<<_END

    
    
      <input type='submit' value='Choose Book'/>
      <input type='hidden' name="next" value='showPage4'/> 
      </div> 
    </form><br/>
  <h2>None of these books match</h2>

_END;


  } /*END if $BookTitleFound*/

  echo <<<_END

    <form action='multipageform2.php' method='post'>
      
      <input type='submit' value='Add New Book Info'/>
      <input type='hidden' name='next' value='showPage32'/>
      
      
    </form><br/><br/>

_END;
        
  } /*If ending */

} /*elseif ending*/






  /*Page 4 display book*/
elseif (isset($_POST['next']) && $_POST['next'] == 'showPage4')
  {
    
    /*will display book record
    upon selecting edit button will go to pg 5 where form appears with information populated
    upon add composition button goes to page 7 where editor information will be prepopulated and can be edited and on to pg 9 where publisher info will be pre populated and can be edited and back to pg 4, here, where user can now choose to add a composition*/

    echo <<<_END

    <div class="form-style-10">
        <p>PAGE FOUR  Display book</p>
        <h2>Success!</h2>
        <h3>What would you like to do with this book?</h3>
    <div class="section">

_END;

  if (isset($_POST['bookID'])) {
    $query  = "SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix
      FROM books AS b
      LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
      LEFT JOIN roles AS r_p ON r_p.ID = B2R2P.role_ID AND r_p.role_name = 'Editor'
      LEFT JOIN people AS p ON p.ID = B2R2P.people_ID
      LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
      LEFT JOIN roles AS r_o ON r_o.ID = B2R2O.role_ID AND r_o.role_name = 'Publisher'
      LEFT JOIN organizations AS o ON o.ID = B2R2O.org_ID

      WHERE b.ID = " . $_POST['bookID'];
      $result = $conn->query($query);

       
      if (!$result) die ("Database access failed");

      $numberOfRows = $result->num_rows;

      for ($j = 0 ; $j < $numberOfRows ; ++$j)
      {
        $row = $result->fetch_array(MYSQLI_NUM);

        $bookID = htmlspecialchars($row[0]);
        $bookTitle = htmlspecialchars($row[1]);
        $bookTag1 = htmlspecialchars($row[2]);
        $bookTag2 = htmlspecialchars($row[3]);
        $bookVolume = htmlspecialchars($row[4]);
        $bookNumber = htmlspecialchars($row[5]);
        $publisherName = htmlspecialchars($row[6]);
        $publisherLocation = htmlspecialchars($row[7]);
        $editorFirstName = htmlspecialchars($row[8]);
        $editorMiddleName = htmlspecialchars($row[9]);
        $editorLastName = htmlspecialchars($row[10]);
        $editorSuffix = htmlspecialchars($row[11]);
  
 /*more questions*/
      }/*end for loop*/
        echo <<<_END

        Book Title: $bookTitle<br/>
        Tag 1: $bookTag1<br/>
        Tag 2: $bookTag2<br/>
        Book Volume: $bookVolume<br/>
        Book Number: $bookNumber<br/>
        Editor: $editorFirstName $editorMiddleName $editorLastName $editorSuffix<br/>
        Publisher Name: $publisherName <br/>
        Publisher Location: $publisherLocation<br/>


_END;

      

    echo <<<_END

    </div><br/> <br/>

    <form action='multipageform2.php' method='post'>
      <div class="button-section">
       <input type='submit' value='Edit this Book'/>
       <input type='hidden' name="next" value='showPage5'/>
       <input type='hidden' name="bookID" value='$bookID'/>
      </div>
    </form>

    <form action='multipageform2.php' method='post'>
     <div class="button-section">
      <input type='submit' value='Delete this Book'/>
      <input type='hidden' name="next" value='showPage12'/>
     </div>
    </form>

    <form action='multipageform2.php' method='post'>
     <div class="button-section">
      <input type='submit' value='Find a Composition from this book'/>
      <input type='hidden' name="next" value='showPage11'/>
      <input type='hidden' name="bookID" value='$bookID'/>
     </div>
    </form>

    <form action='multipageform2.php' method='post'>
     <div class="button-section">
      <input type='submit' value='Add a New Book to the Library'/>
      <input type='hidden' name="next" value='showPage2'/>
     </div>
    </form>

    <form action='multipageform2.php' method='post'>
     <div class="button-section">
      <input type='submit' value='Search the Library'/>
     </div>
    </form>

    <form action='multipageform2.php' method='post'>
     <div class="button-section">
      <input type='submit' value='Print this book information'/>
      <input type='hidden' name="next" value='showPage16'/>
     </div>
    </form>

    <form action='multipageform2.php' method='post'>
     <div class="button-section">
      <input type='submit' value='Exit Library'/>
      <input type='hidden' name="next" value='showPage15'/>
     </div>
    </form>

    </div>

_END;

  }

}







  /*Page 5 / Edit Book   
  from page 4 (display book)
  This page is for the purpose of giving the user an opportunity to edit the book displayed in the previous page (4)*/
  /*In order to Edit the book found in page 4 we will need to have the form pre populated with the information from page 4 using the book information from the query. We passed a hidden bookID in the form to facilitate this*/
elseif (isset($_POST['next']) && $_POST['next'] == 'showPage5')
  {


   if (isset($_POST['bookID'])) {

      echo <<<_END


      <div class="form-style-10">
        <h3>Edit Book info below</h3>
        <p>PAGE FIVE  Edit Book</p>
        <pre>
        <form action='multipageform2.php' method='post'>
            <div class="section">


_END;


        $query  = "SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix
          FROM books AS b
          LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
          LEFT JOIN roles AS r_p ON r_p.ID = B2R2P.role_ID AND r_p.role_name = 'Editor'
          LEFT JOIN people AS p ON p.ID = B2R2P.people_ID
          LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
          LEFT JOIN roles AS r_o ON r_o.ID = B2R2O.role_ID AND r_o.role_name = 'Publisher'
          LEFT JOIN organizations AS o ON o.ID = B2R2O.org_ID

          WHERE b.ID = '" . $_POST['bookID'] . "'";
        $result = $conn->query($query);

       
      if (!$result) die ("Database access failed");

      $numberOfRows = $result->num_rows;

      for ($j = 0 ; $j < $numberOfRows ; ++$j)
      {
       $row = $result->fetch_array(MYSQLI_NUM);

       $bookID = htmlspecialchars($row[0]);
       $bookTitle = htmlspecialchars($row[1]);
       $bookTag1 = htmlspecialchars($row[2]);
       $bookTag2 = htmlspecialchars($row[3]);
       $bookVolume = htmlspecialchars($row[4]);
       $bookNumber = htmlspecialchars($row[5]);
       $publisherName = htmlspecialchars($row[6]);
       $publisherLocation = htmlspecialchars($row[7]);
       $editorFirstName = htmlspecialchars($row[8]);
       $editorMiddleName = htmlspecialchars($row[9]);
       $editorLastName = htmlspecialchars($row[10]);
       $editorSuffix = htmlspecialchars($row[11]);


 }     
    echo <<<_END


      Book Title: <input type='text' name='bookTitle' value='$bookTitle'/><br/>
      Tag 1: <input type="text" name="tag1" value='$bookTag1'/><br/>
      Tag 2: <input type="text" name="tag2" value='$bookTag2'/><br/>
      Book Volume: <input type="text" name="bookVol" value='$bookVolume'/><br/>
      Book Number: <input type="number" name="bookNum" value='$bookNumber'/><br/>
      Publisher Name: <input type='text' name='pubName' value='$publisherName'/><br/>
      Publisher Location: <input type='text' name='pubLocation' value='$publisherLocation'/><br/>
      Editor First Name: <input type='text' name='edFirstName' value='$editorFirstName'/><br/>
      Editor Middle Name: <input type='text' name='edMiddleName' value='$editorMiddleName'/><br/>
      Editor Last Name: <input type='text' name='edLastName' value='$editorLastName'/><br/>
      Editor Suffix: <input type='text' name='edSuffix' value='$editorSuffix'/><br/>


      
      </div>


      <div class="button-section">
        <input type='submit' value='Enter this new info and Continue'/>
        <input type='hidden' name="next" value='showPage4'/>
      </div>
    </form>

  </div>

_END;

    
   
  }  /*esleif ending  isset bookID*/
}  /*else if ending*/

















  /*Page 6  Editor Search*/
  /*From page 32 "Add Book Info"*/
  /*Name value pairs sent to post array from pg 32:
  bookTitle: user input
  tag1: user input
  tag2: user input
  bookVol: user input
  bookNum: user input
  next: 'showPage6'
  */
elseif (isset($_POST['next']) && $_POST['next'] == 'showPage6')
  {
  echo <<<_END

  <div class="form-style-10">
    <p>PAGE SIX  editor search</p>
 

_END;


  if (isset($_POST['bookTitle']))
  {/*Clean up the values sent in the post array*/
    $bookTitle   = get_post($conn, 'bookTitle');
    $tag1    = get_post($conn, 'tag1');
    $tag2 = get_post($conn, 'tag2');
    $bookVol     = get_post($conn, 'bookVol');
    $bookNum     = get_post($conn, 'bookNum');
  /*Build the query string*/
    $query    = <<<_END
      INSERT INTO books (title, tag1, tag2, book_vol, book_num) 
    VALUES
    ('$bookTitle', '$tag1', '$tag2', '$bookVol', '$bookNum');

_END;

/*Send the query to the database*/
    $result   = $conn->query($query);
    /*Getting book ID for the book just inserted into database*/
    $bookID = $conn->insert_id;

    echo ("bookID = " . $bookID);

    if ($result) {
/*Start form for text not inside of loop*/
       echo <<<_END

    <form action='multipageform2.php' method='post'>
     <h2>So Far so good!</h2>
     <h3>This book info was added successfully!</h3>

_END;


    /*Now go right back and get the book information we just inserted by creating a Select statement*/
    /*build query*/ 
    $query  = "SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num
          FROM books AS b
          
          WHERE b.ID = $bookID";

          /*echo ("\n " . $query . "\n<br/>");*/
     /*Send query to Database*/
        $result = $conn->query($query);

      /*incase result fails*/ 
        if (!$result) die ("Database access failed");

        $numberOfRows = $result->num_rows;  /*gets the number of rows in a result*/
/*build forloop*/
        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $result->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/
/*create variables to hold each index (or column) from the given result row array*/
/*clean the information with htmlspecialchars() for security purposes*/
/*These variables can now be used in other code*/
            $bookID = htmlspecialchars($row[0]);
            $bookTitle = htmlspecialchars($row[1]);
            $bookTag1 = htmlspecialchars($row[2]);
            $bookTag2 = htmlspecialchars($row[3]);
            $bookVolume = htmlspecialchars($row[4]);
            $bookNumber = htmlspecialchars($row[5]);

/*Display book information for each book found in from the query. It should only be one.*/
            echo <<<_END
   
            Book Title: $bookTitle <br/>
            Tag 1: $tag1 <br/>
            Tag 2: $tag2<br/>
            Book Volume: $bookVol <br/>
            Book Number: $bookNum <br/>
            
_END;
          } /*for loop ending*/
          /*This will loop for each result row*/
/*ask for editor information */

echo <<<_END

    <h3>Enter Editor's LAST NAME only</h3>
    <div class="section">
      <input type="text" name="searchEditorLastName"/>
    </div>

 <div class="button-section">
     <input type='submit' value='Search for this Editor'/>
     <input type='hidden' name="next" value='showPage7'/>
     <input type='hidden' name="bookID" value="$bookID"/>
    </div>
  </form>

<form action='multipageform2.php' method='post'>
  <div class="button-section">
     <input type='submit' value='No Editor information'/>
     <input type='hidden' name="next" value='showPage8'/>
     <input type='hidden' name="bookID" value="$bookID"/>
    </div>
  </form>
</div>    
</form><br/><br/>

_END;
        
  } /*If $result - ending*/
    
/*hidden with value of $bookID passes bookID to next page*/
  }  /*end if isset bookTitle*/  

    if (!$result) echo("Error description: " . mysqli_error($conn));

} /*elseif ending*/











  /*Page 7 Editor options*/  
  
  elseif (isset($_POST['next']) && $_POST['next'] == 'showPage7')
  {
   
    /*Lists editors with similar last name*/

 
   $bookID = $_POST['bookID'];
   
   
   echo <<<_END
  
   <p>PAGE SEVEN / Editor options</p>
   
   <h3>Choose an Editor option below</h3>

   <form action='multipageform2.php' method='post'>
    <div class="section">

_END;


/*In this section we will process Editor information being submitted to the data base by the user in the form on pg 7A*/
/*If the user entered at least the lastname of the Editor in the form on page7A*/
if(isset($_POST['editorLastName'])){

/*wash the data coming in from user form pg 23*/
            $editorFirstName=  get_post($conn, 'editorFirstName');
            $editorMiddleName =  get_post($conn, 'editorMiddleName');
            $editorLastName =  get_post($conn, 'editorLastName');
            $editorSuffix =  get_post($conn, 'editorSuffix');
            

 /*create the insert query to add the users editor info into the people table*/ 
  

    $queryPeopleInsert = <<<_END

    INSERT INTO people (firstname, middlename, lastname, suffix)
    VALUES('$editorFirstName', '$editorMiddleName', '$editorLastName', '$editorSuffix');

_END;

      echo ("\n queryPeopleInsert = " . $queryPeopleInsert . "\n<br/>");
      /*Send query and place result into this variable*/
      $queryPeopleInsertResult = $conn->query($queryPeopleInsert);

      if (!$queryPeopleInsertResult) echo("\n Error description: " . mysqli_error($conn) . "\n<br/>");

      /*Need the most recent id entered for my people id for later*/
      $peopleID = $conn->insert_id;


    /*Getting the arrnger Role ID so I can use it in the insert query below*/
    $roleQuery = "SELECT ID FROM roles WHERE role_name = 'Editor'";
      echo ("\n roleQuery = " . $roleQuery . "\n<br/><br/>");
      
      /*Send the query to the database*/
      $roleQueryResult   = $conn->query($roleQuery);
     
      /*incase result fails*/ 
      if (!$roleQueryResult) die ("Database access failed");

      if ($roleQueryResult) {
      $numberOfRows = $roleQueryResult->num_rows;  /*gets the number of rows in a result*/


      /*build forloop*/
      for ($j = 0 ; $j < $numberOfRows ; ++$j){
         $row = $roleQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/

        /*create variables to hold each index (or column) from the given result row array*/
        
        /*This variable can now be used in other code*/
          $editorRoleID = ($row[0]);
          
        } /*for loop ending*/

    } /*End if Rolequery result*/

    /*create insert query to add a row to the B2R2P table to connect this person with this book as an editor*/
    $insertQuery = "INSERT INTO B2R2P (book_ID, role_ID, people_ID)
      VALUES (  $bookID,
                $editorRoleID,
                $peopleID
                )";

      echo ("\n insertQuery = " . $insertQuery . "\n<br/>");
      /*Send query and place result into this variable*/
      $insertQueryResult = $conn->query($insertQuery);

      if (!$insertQueryResult) echo("Error description: " . mysqli_error($conn)) ;



   $editorQuery1 = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM books As b
        LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
        LEFT JOIN people AS p ON B2R2P.people_ID = p.ID
        JOIN roles AS r_ed ON B2R2P.role_ID = r_ed.ID AND r_ed.role_name = 'Editor'
        WHERE p.ID = $peopleID;

_END;

        echo 'editorQuery1 = ' . $editorQuery1 . '<br/><br/>';
        /*send the query*/
        $resultEditorQuery1 = $conn->query($editorQuery1);

       
        if (!$resultEditorQuery1) die ("Database access failed editorQuery1");
        if ($resultEditorQuery1){
       
          $numberOfRows = $resultEditorQuery1->num_rows;

          $editorFound = ($numberOfRows  > 0);
          $editorNotFound = ($numberOfRows === 0);
          if ($editorNotFound) {
           
            echo "<h3>No editor by the last name of  " . $editorLastName . " was found. <br/><br/> Would you like to add this editor information to this book? <br/><br/>";
          } /*END if editor not found*/

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultEditorQuery1->fetch_array(MYSQLI_NUM);

            $editorID = ($row[0]);
            $edFirst = ($row[1]);
            $edMiddle = ($row[2]);
            $edLast = ($row[3]);
            $edSuffix = ($row[4]);
            

echo <<<_END

          <input type="radio" name="editorPeopleID" value="$editorID"/> Arranger Name: $edFirst $edMiddle $edLast $edSuffix<br><br>
_END;

          } /*for loop ending*/
      } /*End if $resultEditorQuery*/

}  /*END if isset editorlast name*/




/*In this section we will search the data base for the Editor the user is looking for. They will have submitted the last name of the Editor they want in the text box on pg 6*/
    if (isset($_POST['searchEditorLastName'])) {
    
        $searchEditorLastName =  get_post($conn, 'searchEditorLastName');
       
      
        
      $editorQuery2 = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM books As b
        LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
        LEFT JOIN people AS p ON B2R2P.people_ID = p.ID
        JOIN roles AS r_ed ON B2R2P.role_ID = r_ed.ID AND r_ed.role_name = 'Editor'
        WHERE p.lastname = '$searchEditorLastName';

_END;

       


        echo 'editorQuery2 = ' . $editorQuery2 . '<br/><br/>';
        /*send the query*/
        $resultEditorQuery2 = $conn->query($editorQuery2);

       
        if (!$resultEditorQuery2) die ("Database access failed editorQuery2");
        if ($resultEditorQuery2){
       
          $numberOfRows = $resultEditorQuery2->num_rows;

          $editorFound = ($numberOfRows  > 0);
          $editorNotFound = ($numberOfRows === 0);
          if ($editorNotFound) {
           
            echo "<h3>No editor by the last name of  " . $searchEditorLastName . " was found. <br/><br/> Would you like to add this editor information to this book? <br/><br/>";
          } /*END if editor not found*/

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultEditorQuery2->fetch_array(MYSQLI_NUM);

            $editorID2 = ($row[0]);
            $edFirst2 = ($row[1]);
            $edMiddle2 = ($row[2]);
            $edLast2 = ($row[3]);
            $edSuffix2 = ($row[4]);


            

echo <<<_END

          <input type="radio" name="editorPeopleID" value="$editorID2"/> Arranger Name: $edFirst2 $edMiddle2 $edLast2 $edSuffix2<br><br>
_END;

          } /*for loop ending*/

      } /*End ifresult editorQuery2*/ 
        
  } /*End if isset post searchEditorLastName */
      

if ($editorFound ) {

  echo <<<_END

          <input type='submit' value='Choose Editor'/>
          <input type='hidden' name="next" value='showPage8'/> 
          <input type='hidden' name='bookID' value='$bookID'/>
         
      </div> 
    </form><br/>
    <h2>None of these editors match</h2>


_END;

} /*END if $editorFound*/
  

  echo <<<_END

    <form action='multipageform2.php' method='post'>
          
          <input type='submit' value='Add Editor Info to this book'/>
          <input type='hidden' name='next' value='showPage7A'/>
          <input type='hidden' name='bookID' value='$bookID'/>
          
      
      
    </form><br/><br/>

_END;


} /*elseif ending*/






  /*Page 7A oops  Add Editor*/  
  elseif (isset($_POST['next']) && $_POST['next'] == 'showPage7A')
  {
    

echo <<<_END
<p>PAGE SEVEN A</p>
<div class="form-style-10">
<h2> Please enter Editor Information Below</h2>

_END;

$bookID = $_POST['bookID'];
echo ("bookID = " . $_POST['bookID']);

echo <<<_END
   
  <form action='multipageform2.php' method='post'>
   <div class="section">
    First Name: <input type="text" name="editorFirstName"/><br/>
    Middle Name: <input type="text" name="editorMiddleName"/><br/>
    Last Name: <input type="text" name="editorLastName"/><br/>
    Suffix: <input type="text" name="editorSuffix"/><br/>
   </div>
  <div class="button-section">
    <input type='submit' value='Submit and Continue'/><br/>
    <input type='hidden' name="next" value='showPage7'/>
    <input type='hidden' name="bookID" value="$bookID"/>
   </div>
  </form>

  
</div>

_END;

  }












/*Page 8  Publisher search*/
  elseif (isset($_POST['next']) && $_POST['next'] == 'showPage8')
  {
       
    echo <<<_END

    <div class="form-style-10">
      <p>PAGE EIGHT publisher search</p>

_END;
      $postBookID = $_POST['bookID'];
      echo ("postBookID = " . $postBookID);

    if (isset($_POST['editorPeopleID']) && isset($_POST['bookID'])) 
    {

      

      /*If user selected editor from list (pg7), Create a new connection using an INSERT  between book, role, and people by adding a new row to B2R2P with bookID, peopleID and roleID*/
      $roleQuery = "SELECT ID FROM roles WHERE role_name = 'Editor'";
      echo ("\n roleQuery = " . $roleQuery . "\n<br/>");
      
      /*Send the query to the database*/
      $roleQueryResult   = $conn->query($roleQuery);
     
      /*incase result fails*/ 
      if (!$roleQueryResult) die ("Database access failed");

      if ($roleQueryResult) 
      {
        $numberOfRows = $roleQueryResult->num_rows;  /*gets the number of rows in a result*/

        /*build forloop*/
        for ($j = 0 ; $j < $numberOfRows ; ++$j)
        {
          $row = $roleQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/

          /*create variables to hold each index (or column) from the given result row array*/
          /*clean the information with htmlspecialchars() for security purposes*/
          /*These variables can now be used in other code*/
          $roleID = htmlspecialchars($row[0]);
          
        } /*for loop ending*/
        /*This will loop for each result row in this case, only one.*/

        $insertQuery = "INSERT INTO B2R2P (book_ID, role_ID, people_ID)
        VALUES (  $postBookID,
                  $roleID,
                  {$_POST['editorPeopleID']}
                )";

        echo ("\n insertQuery = " . $insertQuery . "\n<br/>");

        $insertQueryResult = $conn->query($insertQuery);

        if (!$insertQueryResult) echo("Error description: " . mysqli_error($conn));

      }  /*end if $roleQueryResult*/
    } /*if isset post editorPeopleID ending*/

if (isset($_POST['bookID'])) {
    /*Build the query string to collect book information updated with the Editor information*/
    $displayQuery  = <<<_END
    SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, p.firstname, p.middlename, p.lastname, p.suffix
      FROM books AS b
      LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
      LEFT JOIN roles AS r_p ON r_p.ID = B2R2P.role_ID AND r_p.role_name = 'Editor'
      LEFT JOIN people AS p ON p.ID = B2R2P.people_ID

      WHERE b.ID = $postBookID;
          
_END;

    echo ("\n displayQuery = " . $displayQuery . "\n<br/>");


    /*Send the query to the database*/
    $resultDisplayQuery = $conn->query($displayQuery);

    /*incase result fails*/ 
    if (!$resultDisplayQuery) die ("Database access failed");

    if ($resultDisplayQuery) 
    {
      /*Start form for text not inside of loop*/
      echo <<<_END

        <form action='multipageform2.php' method='post'>
          <h2>Book Information</h2>

_END;

      $numberOfRows = $resultDisplayQuery->num_rows;  /*gets the number of rows in a result*/
      /*build forloop*/

      for ($j = 0 ; $j < $numberOfRows ; ++$j)
      {
        $row = $resultDisplayQuery->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/
        /*create variables to hold each index (or column) from the given result row array*/
        /*clean the information with htmlspecialchars() for security purposes*/
        /*These variables can now be used in other code*/

        $bookID = htmlspecialchars($row[0]);
        $bookTitle = htmlspecialchars($row[1]);
        $bookTag1 = htmlspecialchars($row[2]);
        $bookTag2 = htmlspecialchars($row[3]);
        $bookVolume = htmlspecialchars($row[4]);
        $bookNumber = htmlspecialchars($row[5]);
        $eFirstName = htmlspecialchars($row[6]);
        $eMiddleName = htmlspecialchars($row[7]);
        $eLastName= htmlspecialchars($row[8]);
        $eSuffix= htmlspecialchars($row[9]);
          
        } /*for loop ending*/
        /*Display book information for each book found  from the query. It should only be one.*/
        /*Not including publisher info, because it won't exist yet. */
        echo <<<_END
 
          Book Title: $bookTitle <br/>
          Tag 1: $bookTag1 <br/>
          Tag 2: $bookTag2 <br/>
          Book Volume: $bookVolume <br/>
          Book Number: $bookNumber <br/>
          Editor Name: $eFirstName $eMiddleName $eLastName $eSuffix
          
_END;
      
      /*This will loop for each result row*/


      /*ask for publisher information */

      echo <<<_END

          <h3>Is there a Publisher to add?</h3>

          <div class="section">
          <h3>YES,</h3><h4>Enter Publisher Name Below</h4>
            <input type="text" name="searchPubName"/><br/>
          </div>

       <div class="button-section">

           <input type='submit' value='Search for this Publisher'/>
           <input type='hidden' name="next" value='showPage9'/>
           <input type='hidden' name="bookID" value='$bookID'/>
          </div>
        </form>

      <form action='multipageform2.php' method='post'>
        <div class="button-section">
        <h3>NO,</h3>
           <input type='submit' value='No Publisher information'/>
           <input type='hidden' name="next" value='showPage4'/>
           <input type='hidden' name="bookID" value='$bookID'/>
          </div>
        </form>
      </div>
          
_END;
        
    } /*If $resultDisplayQuery - ending*/
    } /*end if isset bookID*/
  } /*elseif ending*/











/*Page 9  Publisher options*/
elseif (isset($_POST['next']) && $_POST['next'] == 'showPage9')
  {
     /*Lists Publishers with similar last name*/

 
   $bookID = $_POST['bookID'];
   
   
   echo <<<_END
  
   <p>PAGE NINE / Publisher options</p>
   
   <h3>Choose an Publisher option below</h3>

   <form action='multipageform2.php' method='post'>
    <div class="section">

_END;


/*In this section we will process Publisher information being submitted to the data base by the user in the form on pg 10*/
/*If the user entered at least the Publisher name in the form on page10*/
if(isset($_POST['pubName'])){

/*wash the data coming in from user form pg 23*/
            $publisherName=  get_post($conn, 'pubName');
            $publisherLocation =  get_post($conn, 'pubLoc');
           
            

 /*create the insert query to add the users publisher info into the organizations table*/ 
  

    $orgInsertQuery = <<<_END

    INSERT INTO organizations (org_name, location)
    VALUES('$publisherName', '$publisherLocation');

_END;

      echo ("\n orgInsertQuery = " . $orgInsertQuery . "\n<br/>");
      /*Send query and place result into this variable*/
      $resultOrgInsertQuery = $conn->query($orgInsertQuery);

      if (!$resultOrgInsertQuery) echo("\n Error description: " . mysqli_error($conn) . "\n<br/>");

      /*Need the most recent id entered for my org id for later*/
      $orgID = $conn->insert_id;


    /*Getting the organization Role ID so I can use it in the insert query below*/
    $publisherRoleQuery = "SELECT ID FROM roles WHERE role_name = 'Publisher'";
      echo ("\n publisherRoleQuery = " . $publisherRoleQuery . "\n<br/><br/>");
      
      /*Send the query to the database*/
      $publisherRoleQueryResult   = $conn->query($publisherRoleQuery);
     
      /*incase result fails*/ 
      if (!$publisherRoleQueryResult) die ("Database access failed");

      if ($publisherRoleQueryResult) {
      $numberOfRows = $publisherRoleQueryResult->num_rows;  /*gets the number of rows in a result*/


      /*build forloop*/
      for ($j = 0 ; $j < $numberOfRows ; ++$j){
         $row = $publisherRoleQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/

        /*create variables to hold each index (or column) from the given result row array*/
        
        /*This variable can now be used in other code*/
          $publisherRoleID = ($row[0]);
          
        } /*for loop ending*/

    } /*End if publisherRoleQueryResult result*/

    /*create insert query to add a row to the B2R2O table to connect this organization with this book as a publisher*/
    $insertQuery1 = "INSERT INTO B2R2O (book_ID, role_ID, org_ID)
      VALUES (  $bookID,
                $publisherRoleID,
                $orgID
                )";

      echo ("\n insertQuery1 = " . $insertQuery1 . "\n<br/>");
      /*Send query and place result into this variable*/
      $insertQueryResult1 = $conn->query($insertQuery1);

      if (!$insertQueryResult1) echo("Error description: " . mysqli_error($conn)) ;



   $publisherQuery1 = <<<_END

        SELECT  o.ID, o.org_name, o.location
        FROM books As b
        LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
        LEFT JOIN organizations AS o ON B2R2O.org_ID = o.ID
        JOIN roles AS r_pub ON B2R2O.role_ID = r_pub.ID AND r_pub.role_name = 'Publisher'
        WHERE o.org_name = '$publisherName';

_END;

        echo 'publisherQuery1 = ' . $publisherQuery1 . '<br/><br/>';
        /*send the query*/
        $resultPublisherQuery1 = $conn->query($publisherQuery1);

       
        if (!$resultPublisherQuery1) die ("Database access failed publisherQuery1");
        if ($resultPublisherQuery1){
       
          $numberOfRows = $resultPublisherQuery1->num_rows;

          $publisherFound = ($numberOfRows  > 0);
          $publisherNotFound = ($numberOfRows === 0);
          if ($publisherNotFound) {
           
            echo "<h3>No publisher by the name of  " . $publisherName . " was found. <br/><br/> Would you like to add this publisher information to this book? <br/><br/>";
          } /*END ifpublisheNotFound*/

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultPublisherQuery1->fetch_array(MYSQLI_NUM);

            $publisherID = ($row[0]);
            $publisherName = ($row[1]);
            $publisherLocation = ($row[2]);
            

echo <<<_END

          <input type="radio" name="publisherOrganizationID1" value="$publisherID"/> Publisher Name: $publisherName <br>Publisher Location: $publisherLocation<br><br>
_END;

          } /*for loop ending*/
      } /*End ifresultPublisherQuery*/

}  /*END if isset post pubName name*/




/*In this section we will search the data base for the Publisher the user is looking for. They will have submitted the  name of the Publisher they want in the text box on pg 8*/
    if (isset($_POST['searchPubName'])) {
    
        $searchPublisherName =  get_post($conn, 'searchPubName');
       
      
        
      $publisherQuery2 = <<<_END

        SELECT  o.ID, o.org_name, o.location
        FROM books As b
        LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
        LEFT JOIN organizations AS o ON B2R2O.org_ID = o.ID
        JOIN roles AS r_pub ON B2R2O.role_ID = r_pub.ID AND r_pub.role_name = 'Publisher'
        WHERE o.org_name = '$searchPublisherName';

_END;

       


        echo 'publisherQuery2 = ' . $publisherQuery2 . '<br/><br/>';
        /*send the query*/
        $resultPublisherQuery2 = $conn->query($publisherQuery2);

       
        if (!$resultPublisherQuery2) die ("Database access failed publisherQuery2");
        if ($resultPublisherQuery2){
       
          $numberOfRows = $resultPublisherQuery2->num_rows;

          $publisherFound = ($numberOfRows  > 0);
          $publisherNotFound = ($numberOfRows === 0);
          if ($publisherNotFound) {
           
            echo "<h3>No publisher by the name of  " . $searchPublisherName . " was found. <br/><br/> Would you like to add this publisher information to this book? <br/><br/>";
          } /*END if editor not found*/

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultPublisherQuery2->fetch_array(MYSQLI_NUM);

            $publisherID2 = ($row[0]);
            $publisherName2 = ($row[1]);
            $publisherLocation2 = ($row[2]);
           

            

echo <<<_END

          <input type="radio" name="publisherOrganizationID2" value="$editorID2"/> Publisher Name: $publisherID2<br>Publisher Location: $publisherLocation2 <br><br>
_END;

          } /*for loop ending*/

      } /*End resultPublisherQuery2*/ 
        
  } /*End ifissetpost searchPubName */
      

if ($publisherFound ) {

  echo <<<_END

          <input type='submit' value='Choose Publisher'/>
          <input type='hidden' name="next" value='showPage4'/> 
          <input type='hidden' name='bookID' value='$bookID'/>
         
      </div> 
    </form><br/>
    <h2>None of these publishers match</h2>


_END;

} /*END if $publisherFound*/
  

  echo <<<_END

    <form action='multipageform2.php' method='post'>
          
          <input type='submit' value='Add Publisher Info to this book'/>
          <input type='hidden' name='next' value='showPage10'/>
          <input type='hidden' name='bookID' value='$bookID'/>
          
      
      
    </form><br/><br/>

_END;


} /*elseif ending*/











  /*Page 10 Add Publisher*/  
  elseif (isset($_POST['next']) && $_POST['next'] == 'showPage10')
  {
 
$bookID = $_POST['bookID'];
echo <<<_END
<p>PAGE TEN  add publisher</p>
<h2>Enter Publisher information Below</h2>
<div class="form-style-10">
   
  <form action='multipageform2.php' method='post'>
   <div class="section">
    Publisher Name: <input type="text" name="pubName"/><br/>
    Publisher Location: <input type="text" name="pubLoc"/><br/>
    
   </div>
   <div class="button-section">
    <input type='submit' value='Submit & Continue'/>
    <input type='hidden' name="next" value='showPage9'/>
    <input type='hidden' name="bookID" value='$bookID'/>
   </div>
  </form>

  
</div>
_END;

  }












/*Page 11 / Composition Options*/
elseif (isset($_POST['next']) && $_POST['next'] == 'showPage11')
  {
   

  echo <<<_END
  <p>PAGE ELEVEN / Add Composition to Book</p>
  <div class="form-style-10">
  <h2>Book Information</h2>

_END;

$postBookID = $_POST['bookID'];
  if (isset($_POST['bookID'])) {
    $query  = "SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix
      FROM books AS b
      LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
      LEFT JOIN roles AS r_p ON r_p.ID = B2R2P.role_ID AND r_p.role_name = 'Editor'
      LEFT JOIN people AS p ON p.ID = B2R2P.people_ID
      LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
      LEFT JOIN roles AS r_o ON r_o.ID = B2R2O.role_ID AND r_o.role_name = 'Publisher'
      LEFT JOIN organizations AS o ON o.ID = B2R2O.org_ID

      WHERE b.ID = " . $_POST['bookID'];
      $result = $conn->query($query);

       
      if (!$result) die ("Database access failed");

      $numberOfRows = $result->num_rows;

      


      for ($j = 0 ; $j < $numberOfRows ; ++$j)
      {
        $row = $result->fetch_array(MYSQLI_NUM);
/*Don't need to sanitize,right?*/
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

        Book Title: $bookTitle<br/>
        Tag 1: $bookTag1<br/>
        Tag 2: $bookTag2<br/>
        Book Volume: $bookVolume<br/>
        Book Number: $bookNumber<br/>
        Editor: $editorFirstName $editorMiddleName $editorLastName $editorSuffix<br/>
        Publisher: $publisherName $publisherLocation<br/>

_END;


echo <<<_END

  <form action='multipageform2.php' method='post'>
    <div class="section">
    <h2>Choose a composition option below</h2>
    

_END;

/*printed out header, now we will loop through results set and display one radio per row*/

/*this page is similar to the book display page (3) but now we are displaying the compositions belonging to a specific book. The query should reflect the compositions belonging to a particular book. Also the variables below should be changed to reflect the composition table info and the radio button included in the for loop should be altered to reflect composititons not books. */

/*echo ("bookID = " .$_POST['bookID'] . '<br/><br/>');*/







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

        WHERE c.book_ID = $bookID;

_END;

      $resultCompositionQuery = $conn->query($compositionQuery);
     /* echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';*/


      if (!$resultCompositionQuery) die ("Database access failed3 <br/>");

      if ($resultCompositionQuery) {     

        $numberOfRows = $resultCompositionQuery->num_rows; 
                  /*  echo 'rows = ' . $numberOfRows . '<br/><br/>'; */   
      $compositionsFound = ($numberOfRows  > 0);
      $compositionsNotFound = ($numberOfRows === 0);
      if ($compositionsNotFound) {
           
            echo "<h3>No compositions from this book,   \"" . $bookTitle . "\", were found. <br/><br/><br/> Would you like to add a new composition to this book? <br/>";
          } /*END if editor not found*/

        /*Composition Loop: Now loop through each row returned by the query. Each row is one composition.*/
        for ($i = 0 ; $i < $numberOfRows ; ++$i)
          {

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
           
          /*  echo 'Composition ID = ' . $compositionID . '<br/><br/>';   */ 

/*Retrieving all key signatures for this composition
I will also be creating a comma separated list to use in the displayed information*/
      $selectKeySigQuery = <<<_END
       
        SELECT  k.key_name
        FROM C2K 
        LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
        WHERE C2K.composition_ID = $compositionID;

_END;

      $resultSelectKeySigQuery = $conn->query($selectKeySigQuery);
    /*  echo '$selectKeySigQuery = ' . $selectKeySigQuery . '<br/><br/>';*/

        if (!$resultSelectKeySigQuery) die ("Database access failed1 <br/>");

        if ($resultSelectKeySigQuery) {     

            $numKeySigRows = $resultSelectKeySigQuery->num_rows;
            /*Build comma separated list of key signatures in a string*/

            $keySignatureString = "";

            for ($j = 0 ; $j < $numKeySigRows ; ++$j)
              {
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
     /* echo '$selectGenresQuery = ' . $selectGenresQuery . '<br/><br/>';*/


      if (!$resultSelectGenresQuery) die ("Database access failed2 <br/>");

      if ($resultSelectGenresQuery) {     

        $numGenreRows = $resultSelectGenresQuery->num_rows;
        /*Build comma separated list of genres in a string*/

        $genreString= "";

        for ($j = 0 ; $j < $numGenreRows ; ++$j)
        {
          $row = $resultSelectGenresQuery->fetch_array(MYSQLI_NUM);

         /* var_dump ($row);*/

        
          $genreName = ($row[0]);

        } /*for loop ending*/

        $genreString .= $genreName.",";
    
      } /*End if result kesig query*/

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
     /* echo '$selectInstrumentQuery = ' . $selectInstrumentQuery . '<br/><br/>';*/


      if (!$resultSelectInstrumentQuery) die ("Database access failed3 <br/>");

      if ($resultSelectInstrumentQuery) {     

        $numInstrumentRows = $resultSelectInstrumentQuery->num_rows;
        /*Build comma separated list of instruments in a string*/
        $instrumentString= "";

        for ($j = 0 ; $j < $numInstrumentRows ; ++$j)
        {
          $row = $resultSelectInstrumentQuery->fetch_array(MYSQLI_NUM);

          /*var_dump ($row);*/

         
          $instrumentName = ($row[0]);

          /*$instrumentString = implode(',',$instVal);*/
          $instrumentString .= $instrumentName.",";
              
        } /*for loop ending*/


    
      } /*End if result instrument query*/

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
     /* echo '$selectGenDiffQuery = ' . $selectGenDiffQuery . '<br/><br/>';*/

       
      if (!$resultselectGenDiffQuery) die ("Database access failed4 <br/>");

      if ($resultselectGenDiffQuery) {     

      $numGDiffRows = $resultselectGenDiffQuery->num_rows;

      for ($j = 0 ; $j < $numGDiffRows ; ++$j)
      {
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
      /*echo '$selectASPDiffQuery = ' . $selectASPDiffQuery . '<br/><br/>';*/

      if (!$resultselectASPDiffQuery) die ("Database access failed5 <br/>");

      if ($resultselectASPDiffQuery) {     

        $numASPDiffRows = $resultselectASPDiffQuery->num_rows;


        for ($j = 0 ; $j < $numASPDiffRows ; ++$j) {
          $row = $resultselectASPDiffQuery->fetch_array(MYSQLI_NUM);

         /* var_dump ($row);*/

         
          $ASPDiffName = ($row[0]);
            
         } /*for loop ending*/
    
      } /*End if result select ASPdiff query*/





/*This is the radio button that will hold all of the information about each composition belonging to a specfic book. Because it is in our for loop, each composition found with the bookID we are working with, will have this block of information displayed on our page.*/
        echo <<<_END


        <br/><input type="radio" name="compositionID" value=$compositionID/>Composition Title: $compName<br>Opus or sim: $opusLike<br>Opus Number or sim: $compNum<br>Composition No.: $compNo<br>Subtitle: $subTitle<br>Key Signature: $displayKeySigString<br>Movement: $movement<br>Era: $era <br>Genre: $displayGenreString <br>Voice: $voice <br>Ensemble: $ensemble <br>Instrument: $displayInstrumentString <br>Composer: $composerFirstName $composerMiddleName $composerLastName $composerSuffix <br>Arranger: $arrangerFirstName $arrangerMiddleName $arrangerLastName $arrangerSuffix <br>Lyricist: $lyricistFirstName $lyricistMiddleName $lyricistLastName $lyricistSuffix <br>ASP difficulty: $ASPDiffName <br>General difficulty: $GenDiffName <br><br>

_END;
 
                     


  } /*End Composition Loop :for loop ending that processes each composition*/

  /*Our first button is still part of the form that has our radio button with all our existing composition information inside it. This radio button is part of our loop and each composition (and its accompanying information) that is associated with this book ID appears as a radio button. When user selects a radio button (thereby selecting a specific composition) and clicks on Choose Composition button, the composition ID is passed along as the value of the radio button. We also send the connected bookID in a hidden input.

  Our second button  is also in a form with a radio button choice. (Maybe this doesn't need to be a radio button??? ) The  bookID is sent as the value in the radio button. By clicking the "Add New Composition to this book", We are sent to a page (page 13) that allows us to add a composition to this specific book. Our bookID goes along with us a hidden input in our form.

  Our third button, "Add a new book", directs us back to page 2 where we can begin the process of adding an entirely new book.

  */

   } /*End if result composition query*/

  } /*End if isset post bookID*/

  if ($compositionsFound ) {

echo <<<_END

      <input type='submit' value='Choose Composition'/>
      <input type='hidden' name="next" value='showPage14'/> 
      <input type="hidden" name="bookID" value="$bookID"/><br> 
    </form><br/><br/>
    <h2>None of these compositions match<h2/>

_END;

} /*END if $compositionsFound*/
  

  echo <<<_END

    <form action='multipageform2.php' method='post'>
      <input type="hidden" name="bookID" value="$bookID"><br>
      <input type='submit' value='Add  a New Composition to this book'/>
      <input type='hidden' name="next" value='showPage13'/>    
    </form><br/><br/>

    <form action='multipageform2.php' method='post'>
      <input type='submit' value='Add a New Book'/>
      <input type='hidden' name="next" value='showPage2'/>    
    </form><br/><br/>

_END;

 

} /*End elseif*/













/*Page 12  Delete message*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage12')
  {
    echo ("ARE YOU SURE YOU WANT TO DELETE THIS INFORMATION? flash flash flash");

echo <<<_END
<div class="form-style-10">
 <p>PAGE TWELVE</p>
  <form action='multipageform2.php' method='post'>
    <div class="button-section">
      <input type='submit' value='Yes, Delete'/>
    <input type='hidden' name="next" value='showPage3'/>
    </div>
  </form>
    <form action='multipageform2.php' method='post'>
    <div class="button-section">
    <input type='submit' value='No! Cancel'/>
    <input type='hidden' name="next" value='showPage4'/>
   </div>
  </form>
  </div>
_END;

  }















/*Page 13  Add Composition to current book*/
/* saved just incase I still want to use. replaced with check boxes.
Key Signature:<select multiple size="3" name="postKeySigID2">
        <option value="none">none</option>
        <option value="CM">C Major</option>
        <option value="GM">G Major</option>
        <option value="DM">D Major</option>
        <option value="AM">A Major</option>
        <option value="EM">E Major</option>
        <option value="BM">B Major</option>
        <option value="GbM">Gb Major</option>
        <option value="DbM">Db Major</option>
        <option value="AbM">Ab Major</option>
        <option value="EbM">Eb Major</option>
        <option value="BbM">Bb Major</option>
        <option value="FM">F Major</option>

        <option value="am">a minor</option>
        <option value="em">e minor</option>
        <option value="bm">b minor</option>
        <option value="f#m">f# minor</option>
        <option value="c#m">c# minor</option>
        <option value="g#m">g# minor</option>
        <option value="ebm">eb minor</option>
        <option value="bbm">bb minor</option>
        <option value="fm">f minor</option>
        <option value="cm">c minor</option>
        <option value="gm">g minor</option>
        <option value="dm">d minor</option>
</select><br/>*/

/*From page 11 "None of the compositions match Add new composition to this book*/

elseif (isset($_POST['next']) && $_POST['next'] == 'showPage13')
  {

 /*Empty form to fill out with new composition information*/  
 /*Finish rest of form. Find out what kinds of info needs to go in the rest of the form. Drop downs? if so, what. etc. */
$bookID = $_POST['bookID'];
echo <<<_END

<div class="form-style-10">
 <p>PAGE THIRTEEN Add new composition to current book</p>
 <h2>Add Composition Information below</h2>
  <form action='multipageform2.php' method='post'>
    <div class="section">

      Composition Name: <input type="text" name="compName"/><br/>

      Opus-Like:<input type="text" name="opus"/><br/>

      Opus No.: <input type="text" name="opusNum"/><br/>

      Composition No.: <input type="number" name="compNum" min="0"/><br/>

      Subtitle:<input type="text" name="subTitle"/><br/>

     

      Key Signature:
        <input type="checkbox" name="postKeySigID[]" value="1">none<br>
        <input type="checkbox" name="postKeySigID[]" value="2">C Major<br>
        <input type="checkbox" name="postKeySigID[]" value="3">G Major<br>
        <input type="checkbox" name="postKeySigID[]" value="4">D Major<br>
        <input type="checkbox" name="postKeySigID[]" value="5">A Major<br>
        <input type="checkbox" name="postKeySigID[]" value="6">E Major<br>
        <input type="checkbox" name="postKeySigID[]" value="7">B Major<br>
        <input type="checkbox" name="postKeySigID[]" value="8">Gb Major<br>
        <input type="checkbox" name="postKeySigID[]" value="9">Db Major<br>
        <input type="checkbox" name="postKeySigID[]" value="10">Ab Major<br>
        <input type="checkbox" name="postKeySigID[]" value="11">Eb Major<br>
        <input type="checkbox" name="postKeySigID[]" value="12">Bb Major<br>
        <input type="checkbox" name="postKeySigID[]" value="13">F Major<br>

        <input type="checkbox" name="postKeySigID[]" value="14">a minor<br>
        <input type="checkbox" name="postKeySigID[]" value="15">e minor<br>
        <input type="checkbox" name="postKeySigID[]" value="16">b minor<br>
        <input type="checkbox" name="postKeySigID[]" value="17">f# minor<br>
        <input type="checkbox" name="postKeySigID[]" value="18">c# minor<br>
        <input type="checkbox" name="postKeySigID[]" value="19">g# minor<br>
        <input type="checkbox" name="postKeySigID[]" value="20">eb minor<br>
        <input type="checkbox" name="postKeySigID[]" value="21">bb minor<br>
        <input type="checkbox" name="postKeySigID[]" value="22">f minor<br>
        <input type="checkbox" name="postKeySigID[]" value="23">c minor<br>
        <input type="checkbox" name="postKeySigID[]" value="24">g minor<br>
        <input type="checkbox" name="postKeySigID[]" value="26">d minor<br>



      Movement:<input type="text" name="mvmnt"/><br/>

      
      Era:<select name="postEraID">
        <option value="7">none</option>
        <option value="1">Ancient pre 1600</option>
        <option value="2">Baroque 1600-1750</option>
        <option value="3">Classical 1750-1810</option>
        <option value="4">Romantic 1780-1910</option>
        <option value="5">Modern 1890-1930</option>
        <option value="6">Contemporary 1930-Present</option>
</select><br/>

      Genre:
        <input type="checkbox" name="postGenreID[]" value="1">none<br>
        <input type="checkbox" name="postGenreID[]" value="2">Jazz<br>
        <input type="checkbox" name="postGenreID[]" value="3">Christmas<br>
        <input type="checkbox" name="postGenreID[]" value="4">Halloween<br>
        <input type="checkbox" name="postGenreID[]" value="5">Blues<br>
        <input type="checkbox" name="postGenreID[]" value="6">Rag<br>
        <input type="checkbox" name="postGenreID[]" value="7">Pop<br>
        <input type="checkbox" name="postGenreID[]" value="8">Country<br>
        <input type="checkbox" name="postGenreID[]" value="9">Madrigal<br>
        <input type="checkbox" name="postGenreID[]" value="10">Technique<br>
        <input type="checkbox" name="postGenreID[]" value="11">Method Book<br>
        <input type="checkbox" name="postGenreID[]" value="12">Classical<br>
        <input type="checkbox" name="postGenreID[]" value="13">Other<br>
        

      Voice:<select name="postVoiceID">
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
</select><br/>

      Ensemble:<select name="postEnsembleID">
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
        <option value="13">other</option>
</select><br/>


      Instrument:<br/>
        <input type="checkbox" name="postInstrumentID[]" value="7">none<br>
        <input type="checkbox" name="postInstrumentID[]" value="1">Piano<br>
        <input type="checkbox" name="postInstrumentID[]" value="2">Voice<br>
        <input type="checkbox" name="postInstrumentID[]" value="3">Trumpet<br>
        <input type="checkbox" name="postInstrumentID[]" value="4">Violin<br>
        <input type="checkbox" name="postInstrumentID[]" value="5">Viola<br>
        <input type="checkbox" name="postInstrumentID[]" value="6">Guitar<br>
        

        
      General Difficulty Level:<select name="postGenDiffID">
        <option value="34">none</option>
        <option value="1">EE</option>
        <option value="2">E</option>
        <option value="3">LE</option>
        <option value="4">EI</option>
        <option value="5">I</option>
        <option value="6">LI</option>
        <option value="7">EA</option>
        <option value="8">A</option>
        <option value="9">LA</option>
</select><br/>

      ASP difficulty level:<select name="postASPDiffID">
        <option value="33">none</option>
        <option value="10">1</option>
        <option value="11">1-2</option>
        <option value="12">2</option>
        <option value="13">2-3</option>
        <option value="14">3</option>
        <option value="15">3-4</option>
        <option value="16">4</option>
        <option value="17">4-5</option>
        <option value="18">5</option>
        <option value="19">5-6</option>
        <option value="20">6</option>
        <option value="21">6-7</option>
        <option value="22">7</option>
        <option value="23">7-8</option>
        <option value="24">8</option>
        <option value="25">8-9</option>
        <option value="26">9</option>
        <option value="27">9-10</option>
        <option value="28">10</option>
        <option value="29">10-11</option>
        <option value="30">11</option>
        <option value="31">11-12</option>
        <option value="32">12</option>
</select><br/>        

    </div>

  
   <div class="button-section">
    <input type='submit' value='Submit & Continue'/>
    <input type='hidden' name="next" value='showPage18'/>
    <input type='hidden' name="bookID" value='$bookID'/>
    

   </div>
  </form>
</div>
</div>
_END;



/*When button is clicked, the form continues on to adding a composer, editor or lyricist after checking to see if they already exist. */


  }
















/*Page 14 Display composition*/





elseif (isset($_POST['next']) && $_POST['next'] == 'showPage14')
  {
   

echo <<<_END
<div class="form-style-10">
<p>PAGE FOURTEEN</p>


<form action='multipageform2.php' method='post'>
   <div class="section">
_END;

  $compositionID = $_POST['compositionID'];
  $bookID = $_POST['bookID'];
  $composerPeopleID = $_POST['composerPeopleID'];



      /*Retrieving all key signatures for this composition
I will also be creating a comma separated list to use in the displayed information*/
      $selectKeySigQuery = <<<_END
      SELECT  k.key_name
      FROM C2K
      LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
      WHERE C2K.composition_ID = $compositionID;

_END;

 $resultSelectKeySigQuery = $conn->query($selectKeySigQuery);
        echo '$selectKeySigQuery = ' . $selectKeySigQuery . '<br/><br/>';

         if (!$resultSelectKeySigQuery) die ("Database access failed1 <br/>");
         if ($resultSelectKeySigQuery) {     

        $numberOfRows = $resultSelectKeySigQuery->num_rows;
/*Build comma separated list of key signatures in a string*/

        $keySignatureString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultSelectKeySigQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

            
            $keySigName = ($row[0]);

            $keySignatureString .= $keySigName .", ";
            
          } /*for loop ending*/


 
    
} /*End if result kesig query*/

$displayKeySigString = rtrim($keySignatureString,', ');




/*Retrieving all key genres for this composition
I will also be creating a comma separated list to use in the displayed information*/
$selectGenresQuery = <<<_END

        SELECT  g.genre_type
        FROM C2G 
        LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
        WHERE C2G.composition_ID = $compositionID;


_END;

 $resultSelectGenresQuery = $conn->query($selectGenresQuery);
        echo '$selectGenresQuery = ' . $selectGenresQuery . '<br/><br/>';


         if (!$resultSelectGenresQuery) die ("Database access failed2 <br/>");
         if ($resultSelectGenresQuery) {     

        $numberOfRows = $resultSelectGenresQuery->num_rows;
/*Build comma separated list of genres in a string*/

        $genreString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultSelectGenresQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

           
            $genreName = ($row[0]);

            $genreString .= $genreName .", ";
            
          } /*for loop ending*/
    
} /*End if result kesig query*/

$displayGenreString = rtrim($genreString,', ');


/*Retrieving all instruments for this composition
I will also be creating a comma separated list to use in the displayed information*/
$selectInstrumentQuery = <<<_END
      SELECT  i.instr_name
      FROM C2I 
      LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID
      WHERE C2I.composition_ID = $compositionID;


_END;

 $resultSelectInstrumentQuery = $conn->query($selectInstrumentQuery);
        echo '$selectInstrumentQuery = ' . $selectInstrumentQuery . '<br/><br/>';

        /*TODO  change query names*/

         if (!$resultSelectInstrumentQuery) die ("Database access failed3 <br/>");
         if ($resultSelectInstrumentQuery) {     

        $numberOfRows = $resultSelectInstrumentQuery->num_rows;
/*Build comma separated list of instruments in a string*/
        $instrumentString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultSelectInstrumentQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

          
            $instrumentName = ($row[0]);
            
            $instrumentString .= $instrumentName .", ";
            
          } /*for loop ending*/


    
} /*End if result instrument query*/

$displayInstrumentString = rtrim($instrumentString,', ');





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
        echo '$selectGenDiffQuery = ' . $selectGenDiffQuery . '<br/><br/>';


         if (!$resultselectGenDiffQuery) die ("Database access failed4 <br/>");
         if ($resultselectGenDiffQuery) {     

        $GenNumberOfRows = $resultselectGenDiffQuery->num_rows;


        for ($j = 0 ; $j < $GenNumberOfRows ; ++$j)
          {
            $row = $resultselectGenDiffQuery->fetch_array(MYSQLI_NUM);

          /*  var_dump ($row);*/
           
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
        echo '$selectASPDiffQuery = ' . $selectASPDiffQuery . '<br/><br/>';


         if (!$resultselectASPDiffQuery) die ("Database access failed5 <br/>");
         if ($resultselectASPDiffQuery) {     

        $ASPNumberOfRows = $resultselectASPDiffQuery->num_rows;


        for ($j = 0 ; $j < $ASPNumberOfRows ; ++$j)
          {
            $row = $resultselectASPDiffQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

           
            $ASPDiffName = ($row[0]);
            
          } /*for loop ending*/
    
} /*End if result select ASPdiff query*/



/*G- Retrieve book and Composition information to display in browser.
1- Book Information
2- Composition information minus the composer, Arranger, or Lyricist*/
        $bookQuery = <<<_END

        SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, p.firstname, p.middlename, p.lastname, p.suffix, org_pub.org_name, org_pub.location
           FROM books AS b
           LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
           LEFT JOIN roles AS r_ed ON B2R2P.role_ID = r_ed.ID AND r_ed.role_name = 'Editor'
           LEFT JOIN people AS p ON B2R2P.people_ID = p.ID
           
           LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
           LEFT JOIN roles AS r_pub ON B2R2O.role_ID = r_pub.ID AND r_pub.role_name = 'Publisher'
           LEFT JOIN organizations AS org_pub ON B2R2O.org_ID = org_pub.ID              

            WHERE b.ID = $bookID  

_END;

      $resultBookQuery = $conn->query($bookQuery);
        echo 'bookQuery = ' . $bookQuery . '<br/><br/>';

         if (!$resultBookQuery) die ("Database access failed3 <br/>");
         if ($resultBookQuery) {     

        $numberOfRows = $resultBookQuery->num_rows;

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultBookQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/
        /*We do not need to sanitze these*/
            $queryBookID = ($row[0]);
            $bookTitle = ($row[1]);
            $bookTag1 = ($row[2]);
            $bookTag2 = ($row[3]);
            $bookVolume = ($row[4]);
            $bookNumber = ($row[5]);
            $editorFirstName = ($row[6]);
            $editorMiddleName= ($row[7]);
            $editorLastName = ($row[8]);
            $editorSuffix = ($row[9]);
            $publisherName = ($row[10]);
            $publisherLocation = ($row[11]);

          } /*End Book Query for loop*/
        } /*End if resultBookQuery*/

       $compositionQuery = <<<_END
        SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, e.description,v.voicing_type, ens.ensemble_type, c.book_ID 
        FROM compositions AS c
        LEFT JOIN eras AS e ON c.era_ID = e.ID
        LEFT JOIN voicing AS v ON c.voice_ID = v.ID
        LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
        LEFT JOIN books AS b ON c.book_ID = b.ID

        WHERE c.ID = $compositionID;
       
_END;

      $resultCompositionQuery = $conn->query($compositionQuery);
        echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';

         if (!$resultCompositionQuery) die ("Database access failed3 <br/>");
         if ($resultCompositionQuery) {     

        $numberOfRows = $resultCompositionQuery->num_rows;

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);

          /*  var_dump ($row);*/

            $queryCompositionID = ($row[0]);
            $compName = ($row[1]);            
            $opusLike = ($row[2]);
            $compNum = ($row[3]);
            $compNo = ($row[4]);
            $subTitle = ($row[5]);                          
            $movement = ($row[6]);
            $era = ($row[7]);            
            $voice = ($row[8]);
            $ensemble = ($row[9]); 
            $CompbookID = ($row[10]);
            
           
          } /*for loop ending*/
        } /*END result Composition Query*/

 $composerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID AND r_composer.role_name = 'Composer'
        WHERE c.ID = $compositionID;

_END;

        echo 'composerQuery = ' . $composerQuery . '<br/><br/>';
        /*send the query*/
        $resultComposerQuery = $conn->query($composerQuery);

       
        if (!$resultComposerQuery) die ("Database access failed composerQuery");
        if ($resultComposerQuery){
        echo 'Hooray';
          $numberOfRows = $resultComposerQuery->num_rows;

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

            $composerID = ($row[0]);
            $compFirst = ($row[1]);
            $compMiddle = ($row[2]);
            $compLast = ($row[3]);
            $compSuffix = ($row[4]);
            
          } /*for loop ending*/
        } /*END if result composer query*/


    
        
       
        /*create query to select the arranger from the database */
        
      $arrangerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_arr ON C2R2P.role_ID = r_arr.ID AND r_arr.role_name = 'Arranger'
        WHERE c.ID = $compositionID;

_END;

        echo 'arrangerQuery = ' . $arrangerQuery . '<br/><br/>';
        /*send the query*/
        $resultArrangerQuery = $conn->query($arrangerQuery);

       
        if (!$resultArrangerQuery) die ("Database access failed arrangerQuery");
        if ($resultArrangerQuery){
        echo 'Hooray';
          $numberOfRows = $resultArrangerQuery->num_rows;

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultArrangerQuery->fetch_array(MYSQLI_NUM);

            $arrangerID = ($row[0]);
            $arrFirst = ($row[1]);
            $arrMiddle = ($row[2]);
            $arrLast = ($row[3]);
            $arrSuffix = ($row[4]);

          } /*for loop ending*/

        } /*END if result arranger QUery*/



           /*create query to select the arranger from the database */
        
      $lyricistQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_lyr ON C2R2P.role_ID = r_lyr.ID AND r_lyr.role_name = 'Lyricist'
        WHERE c.ID = $compositionID;

_END;

        echo 'lyricistQuery = ' . $lyricistQuery . '<br/><br/>';
        /*send the query*/
        $resultLyricistQuery = $conn->query($lyricistQuery);

       
        if (!$resultLyricistQuery) die ("Database access failed arrangerQuery");
        if ($resultLyricistQuery){
        echo 'Hooray';
          $numberOfRows = $resultLyricistQuery->num_rows;

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultLyricistQuery->fetch_array(MYSQLI_NUM);

            $lyricistID = ($row[0]);
            $lyrFirst = ($row[1]);
            $lyrMiddle = ($row[2]);
            $lyrLast = ($row[3]);
            $lyrSuffix = ($row[4]);

          } /*for loop ending*/

        } /*END if result arranger QUery*/

   /* H- Display Book information and Composition info Using HTML*/  
  echo <<<_END

      <h3>Book Info</h3>
     Book Title: $bookTitle <br/>
     Tag 1: $bookTag1 <br/>
     Tag 2: $bookTag2 <br/>
     Book Volume: $bookVolume <br/>
     Book Number: $bookNumber <br/>
     Book Editor name: $editorFirstName $editoryMiddleName $editorLastName $editorSuffix<br/>
     Book Publisher: $publisherName<br/>
     Publisher Location: $publisherLocation<br/>

      <h3>Compsition Info</h3>
    Composition Name: $compName <br/>
    Opus-Like: $opusLike <br/>
    Opus No.: $compNum <br/>
    Composition No.: $compNo <br/>
    Subtitle: $subTitle <br/>
    Key Signature: $displayKeySigString <br/>
    Movement: $movement <br/>
    Era: $era <br/>
    Genre: $displayGenreString<br/>
    Voice: $voice <br/>
    Ensemble: $ensemble <br/>
    Instrument: $displayInstrumentString <br/>
    General difficulty: $GenDiffName <br/>
    ASP difficulty: $ASPDiffName<br/>
    Composer Name: $compFirst $compMiddle $compLast $compSuffix <br/>
    Arranger Name: $arrFirst $arrMiddle $arrLast $arrSuffix <br/>
    Lyricist Name: $lyrFirst $lyrMiddle $lyrLast $lyrSuffix<br/><br/>

_END;

/*Button options for our new composition*/

echo <<<_END
<div class="form-style-10">
 <h3>What would you like to do with this composition information?</h3><br/>
  <form action='multipageform2.php' method='post'>
   <div class="button-section">
    <input type='submit' value='Edit this composition'/>
    <input type='hidden' name="next" value='showPage13'/>
    <input type='hidden' name="compositionID" value='$compositionID'/>
    <input type='hidden' name="bookID" value='$bookID'/>
   </div>
  </form>

  <form action='multipageform2.php' method='post'>
   <div class="button-section">
    <input type='submit' value='Add a New composition to this book'/>
    <input type='hidden' name="next" value='showPage13'/>
    <input type='hidden' name="bookID" value='$bookID'/>
   </div>
  </form>

  <form action='multipageform2.php' method='post'>
   <div class="button-section">
    <input type='submit' value='Delete this composition'/>
    <input type='hidden' name="next" value='showPag12'/>
    <input type='hidden' name="compositionID" value='$compositionID'/>
   </div>
  </form>

  <form action='multipageform2.php' method='post'>
   <div class="button-section">
    <input type='submit' value='View all compositions from this book'/>
    <input type='hidden' name="next" value='showPage11'/>
    <input type='hidden' name="bookID" value='$bookID'/>
   </div>
  </form>

  <form action='multipageform2.php' method='post'>
   <div class="button-section">
    <input type='submit' value='Add a new book to the Library'/>
    <input type='hidden' name="next" value='showPage2'/>
   </div>
  </form>

  <form action='multipageform2.php' method='post'>
   <div class="button-section">
    <input type='submit' value='Search Library'/>
    <input type='hidden' name="next" value='showPage1'/>
   </div>
  </form>

  <form action='multipageform2.php' method='post'>
   <div class="button-section">
    <input type='submit' value='Print'/>
    <input type='hidden' name="next" value='showPage16'/>
    <input type='hidden' name="compositionID" value='$compositionID'/>
    <input type='hidden' name="bookID" value='$bookID'/>
   </div>
  </form>

  <form action='multipageform2.php' method='post'>
   <div class="button-section">
    <input type='submit' value='Exit Library'/>
    <input type='hidden' name="next" value='showPage15'/>
   </div>
  </form>
  </div>
_END;

  } /*End else if pg 14*/














/*Page 15  Exit Message*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage15')
  {
    echo ("Thank you for using MusicLibrary3");

    /*there is no hidden value for the home button because no value allows it to be !isset returning our code to the first page of our file. */
    /*Exit button has not yet been worked out how to exit from the web site.*/

echo <<<_END
<div class="form-style-10">
 <p>PAGE FIFTEEN</p>
  <form action='multipageform2.php' method='post'>
   <div class="button-section">
    <input type='submit' value='HOME'/>
   </div>
  </form>

  <form action='multipageform2.php' method='post'>
   <div class="button-section">
    <input type='submit' value='Exit'/> 
    <input type='hidden' name="next" value=''/>
   </div>
  </form>
</div>
_END;

  }










  /*Page 16  Print*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage16')
  {
    echo ("This page allows you to print");

echo <<<_END
<div class="form-style-10">
 <p>PAGE SIXTEEN</p>
  <form action='multipageform2.php' method='post'>
  
  
   <div class="button-section">
    <input type='submit' value='Back'/>
    <input type='hidden' name="next" value='showPage17'/>
   </div>
  </form>
</div>
_END;

  }









  /*Page 17   Edit composition*/
 
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage17')
  {
    echo <<<_END

    <div class="form-style-10">
    <p>PAGE SEVENTEEN</p>
    <h3>SUCCESS!</h3>
    
    <p>Your book and composition Info</p>
  
  
   
_END;

    
     if (isset($_POST['compositionID'])) {
        $query  = "SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix, c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.keySignature, c.movement, e.description, g.genre_type, v.voicing_type, ens.ensemble_type, i.instr_name, p_composer.firstname, p_composer.middlename, p_composer.lastname, p_composer.suffix, p_arranger.firstname, p_arranger.middlename, p_arranger.lastname, p_arranger.suffix, p_lyricist.firstname, p_lyricist.middlename, p_lyricist.lastname, p_lyricist.suffix, d_a.difficulty_level AS a_difficulty, d_g.difficulty_level AS g_difficulty
          FROM compositions AS c
           LEFT JOIN C2B ON c.ID = C2B.composition_ID
           LEFT JOIN books AS b ON C2B.book_ID = b.ID 
           LEFT JOIN ensembles AS ens ON b.ID = ens.ID
           LEFT JOIN C2I ON c.ID = C2I.composition_ID
           LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID 
           LEFT JOIN C2G ON c.ID = C2G.composition_ID
           LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
           LEFT JOIN voicing AS v ON c.ID = v.ID
           LEFT JOIN eras AS e ON c.ID = e.ID 
           LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID 
           LEFT JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID 
           LEFT JOIN roles AS r_arranger ON C2R2P.role_ID = r_arranger.ID 
           LEFT JOIN roles AS r_lyricist ON C2R2P.role_ID = r_lyricist.ID 
           LEFT JOIN people AS p_composer ON C2R2P.people_ID = p_composer.ID AND r_composer.role_name = 'Composer'
           LEFT JOIN people AS p_arranger ON C2R2P.people_ID = p_arranger.ID AND r_arranger.role_name = 'Arranger'
           LEFT JOIN people AS p_lyricist ON C2R2P.people_ID = p_lyricist.ID AND r_lyricist.role_name = 'Lyricist'
           
           LEFT JOIN C2D ON c.ID = C2D.composition_ID
           
           LEFT JOIN difficulties AS d_a ON C2D.difficulty_ID = d_a.ID AND d_a.ID in (select d.ID from difficulties as d join organizations as o on d.org_ID = o.ID and o.org_name = 'ASP')
           
           LEFT JOIN difficulties AS d_g ON C2D.difficulty_ID = d_g.ID AND d_g.ID in (select d.ID from difficulties as d join organizations as o on d.org_ID = o.ID and o.org_name = 'General')
        
          WHERE c.ID = 9";
          

 
         /* echo ("\n " . $query . "\n<br/>");*/
        $result = $conn->query($query);

       
        if (!$result) die ("Database access failed");

        $numberOfRows = $result->num_rows;

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $result->fetch_array(MYSQLI_NUM);

            $bookID = htmlspecialchars($row[0]);
            $bookTitle = htmlspecialchars($row[1]);
            $bookTag1 = htmlspecialchars($row[2]);
            $bookTag2 = htmlspecialchars($row[3]);
            $bookVolume = htmlspecialchars($row[4]);
            $bookNumber = htmlspecialchars($row[5]);
            $publisherName = htmlspecialchars($row[6]);
            $publisherLocation = htmlspecialchars($row[7]);
            $editorFirstName = htmlspecialchars($row[8]);
            $editorMiddleName = htmlspecialchars($row[9]);
            $editorLastName = htmlspecialchars($row[10]);
            $editorSuffix = htmlspecialchars($row[11]);
  


            $compositionID = htmlspecialchars($row[12]);
            $compName= htmlspecialchars($row[13]);
            $opusLike = htmlspecialchars($row[14]);
            $compNum = htmlspecialchars($row[15]);
            $compNo = htmlspecialchars($row[16]);
            $subTitle = htmlspecialchars($row[17]);
            $keySig = htmlspecialchars($row[18]);
            $movement = htmlspecialchars($row[19]);
            $era = htmlspecialchars($row[20]);
            $genre = htmlspecialchars($row[21]);
            $voice = htmlspecialchars($row[22]);
            $ensemble = htmlspecialchars($row[23]);

            $instrument = htmlspecialchars($row[24]);
            $composerFirstName = htmlspecialchars($row[25]);
            $composerMiddleName= htmlspecialchars($row[26]);
            $composerLastName = htmlspecialchars($row[27]);
            $composerSuffix = htmlspecialchars($row[28]);
            $arrangerFirstName = htmlspecialchars($row[29]);
            $arrangerMiddleName= htmlspecialchars($row[30]);
            $arrangerLastName = htmlspecialchars($row[31]);
            $arrangerSuffix = htmlspecialchars($row[32]);
            $lyricistFirstName = htmlspecialchars($row[33]);
            $lyricistMiddleName= htmlspecialchars($row[34]);
            $lyricistLastName = htmlspecialchars($row[35]);
            $lyricistSuffix = htmlspecialchars($row[36]);
            $diffASP = htmlspecialchars($row[37]);
            $diffGen = htmlspecialchars($row[38]);
            
} /*for loop ending*/

echo <<<_END

 

  
<p>Book Info</p>
    Book Title: $bookTitle <br/>
    Tag 1: $bookTag1 <br/>
    Tag 2: $bookTag2 <br/>
    Book Volume: $bookVolume <br/>
    Book Number: $bookNumber <br/>
    Book Editor: $editorFirstName $editorMiddleName $editorLastName $editorSuffix <br/>
    Book Publisher: $publisherName $publisherLocation<br/><br/>


    <p>Compsition Info</p>
    Composition Name: $compName <br/>
    Opus-Like: $opusLike <br/>
    Opus No.: $compNum <br/>
    Composition No.: $compNo <br/>
    Subtitle:$subTitle <br/>
    Key Signature:$keySig <br/>
    Movement:$movement <br/>
    Era: $era <br/>
    Genre:$genre<br/>
    Voice: $voice <br/>
    Ensemble:$ensemble <br/>
    Composer: $composerFirstName $composerMiddleName $composerLastName $composerSuffix <br/>
    Arranger: $arrangerFirstName $arrangerMiddleName $arrangerLastName $arrangerSuffix<br/>
    Lyricist: $lyricistFirstName $lyricistMiddleName $lyricistLastName $lyricistSuffix<br/>
    Instrument: $instrument <br/>
    General difficulty: $diffASP <br/>
    ASP difficulty: $diffGen <br/><br/>

    <h3>What would you like to do with this book and composition info?<h3/>


    <form action='multipageform2.php' method='post'>
      <div class="button-section">
        <input type='submit' value='Print'/>
        <input type='hidden' name="next" value='showPage16'/>
      </div>
    </form>
    <form action='multipageform2.php' method='post'>
      <div class="button-section">
        <input type='submit' value='Exit'/>
        <input type=implo'hidden' name="next" value='showPage15'/>
      </div>
    </form>
    <form action='multipageform2.php' method='post'>
      <div class="button-section">
        <input type='submit' value='Search'/>
        <input type='hidden' name="next" value='showPage1'/>
      </div>
    </form>
    <form action='multipageform2.php' method='post'>
      <div class="button-section">
        <input type='submit' value='Add New Composition to this book'/>
        <input type='hidden' name="next" value='showPage11'/>
      </div>
    </form>
    <form action='multipageform2.php' method='post'>
      <div class="button-section">
        <input type='submit' value='Add New Book'/>
        <input type='hidden' name="next" value='showPage2'/>
      </div>
    </form>
</div>
_END;

  }

 }












  /*Page 18 Composer search*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage18')
  {

echo<<<_END

<h3>PAGE EIGHTEEN</h3>
_END;

  if (isset($_POST['compName']))
  {/* A-  Clean up the values sent in the post array minus Keysig, genre, instrument they are arrays and will be handled in a bit*/
            
            $compName=  get_post($conn, 'compName');
            $opusLike =  get_post($conn, 'opus');
            $compNum =  get_post($conn, 'opusNum');
            $compNo =  get_post($conn, 'compNum');
            $subTitle =  get_post($conn, 'subTitle');
            $bookID= get_post($conn, 'bookID');
            $movement =  get_post($conn, 'mvmnt');
            $eraID =  get_post($conn, 'postEraID');
            $voiceID =  get_post($conn, 'postVoiceID');
            $ensembleID =  get_post($conn, 'postEnsembleID');
            $diffASPID =  get_post($conn, 'postASPDiffID');
            $diffGenID =  get_post($conn, 'postGenDiffID'); 


/*B- Insert records into tables referenced in the compositions table by foreign keys to capture the ids we will need.
We won't actually be entering any information into these tables this time, because the post values were id's and so we don't need to capture the ids we already have them. */


/*C-  Now that we have all our ids and the post values are washed, Create a query to insert information into the compositions table then grab the composition ID and store it into a variable.*/

$querycomp    = <<<_END
      INSERT INTO compositions (comp_name, opus_like, comp_num, comp_no, parent_comp_ID, subtitle, book_ID, movement, era_ID, voice_ID, ensemble_ID) 
      VALUES
      ('$compName', '$opusLike', '$compNum', '$compNo', NULL, '$subTitle', '$bookID', '$movement', '$eraID', '$voiceID', '$ensembleID');

_END;

    /*Send the query to the database*/
    $resultcomp   = $conn->query($querycomp);
    /*Here is where I collect my compositionID for later*/
    $compositionID = $conn->insert_id; 

     if (!$resultcomp) echo("Error description: " . mysqli_error($conn));

    if ($resultcomp) {

/*These help me see what was actually sent to the server and if I, in fact, have a composition ID. They will be commented out once I am sure the page is working.*/
    echo 'querycomp = ' . $querycomp . '<br/><br/>';
    echo 'compositionID = ' . $compositionID .'<br/>';

    } /*end if resultcomp*/

    /*QUESTION end if compname here?*/
  




/*D-  This is where the arrays should be looped through. Keysignature, Genres, Instruments
Purpose of foreach loop:
   -separate each value
   -wash each value for security purposes
   -store each value in a variable
   -insert each value into its junction table, using the compositionID we grabbed earlier, as a connection to the compositions table
   -create comma separated lists
   Do this for C2K, C2G, C2I.*/


/*Insert for C2K*/

if(!empty($_POST['postKeySigID'])) {
  $keySigArray = $_POST['postKeySigID'];
  /*This will insert keysigs from form into database*/
  /*now I have an array of keysignature ids loop through an array of ks arrays and insert each keysignature Ids*/
 
  foreach($keySigArray as $sigVal){
    /*washes the sigval value*/
    $keySigID = htmlspecialchars($sigVal);
    
    $keySigQuery = <<<_END
    INSERT INTO C2K (composition_ID, keysig_ID)
    VALUES ($compositionID, $sigVal);

_END;
    $resultkeySigArray = $conn->query($keySigQuery);
    echo 'keySigQuery =' . $keySigQuery . '<br/>';
    echo 'sigVal =' . $sigVal . '<br/>';
    
    if (!$resultkeySigArray) echo("Error description: " . mysqli_error($conn));
    if ($resultkeySigArray) {
   
    } /*end if resultkeysigarray*/
  } /*end foreach sigval*/
}/*end if !empty postkeysigId*/
    /*echo $displayKeySigString;
    
 /*Insert for C2G*/

if(!empty($_POST['postGenreID'])) {
  $genreArray = $_POST['postGenreID'];
  /*This will insert Genres from form into database*/
  /*now that I have an array of Genre ids, loop through an array of genres and insert each genre Id*/
 
  foreach($genreArray as $genreVal){
    /*washes the genreVal value*/
    $genreID = htmlspecialchars($genreVal);
    
    $genreQuery = <<<_END
    INSERT INTO C2G (composition_ID, genre_ID)
    VALUES ($compositionID, $genreVal);

_END;
    $resultGenreArray = $conn->query($genreQuery);
      echo 'genreQuery =' . $genreQuery . '<br/>';
      echo 'genreVal =' . $genreVal . '<br/>';

    
    if (!$resultGenreArray) echo("Error description: " . mysqli_error($conn));
    if ($resultGenreArray) {
    
    } /*end if resultGenrearray*/
  } /*end foreach genreval*/
}/*end if !empty postGenreId*/
  
       

       /*Insert for C2I*/

if(!empty($_POST['postInstrumentID'])) {
  $InstrumentArray = $_POST['postInstrumentID'];
  /*This will insert Instruments from form into database*/
  /*now that I have an array of Instrument ids, loop through an array of instruments and insert each instrument Id*/
 
  foreach($InstrumentArray as $instrumentVal){
    /*washes the instrumentVal value*/
    $InstrumentID = htmlspecialchars($instrumentVal);
    
    $instrumentQuery = <<<_END
    INSERT INTO C2I (composition_ID, instrument_ID)
    VALUES ($compositionID, $instrumentVal);

_END;
    $resultInstrumentArray = $conn->query($instrumentQuery);
    echo 'instrumentQuery=' . $instrumentQuery . '<br/>';
    echo 'instrumentVal =' . $instrumentVal . '<br/>';
    
    if (!$resultInstrumentArray) echo("Error description: " . mysqli_error($conn));
    if ($resultInstrumentArray) {
    
    } /*end if resultInstrumentarray*/
  } /*end foreach insgrumentval*/
}/*end if !empty postInstrumentId*/
    

    

/* E-Insert into remaining juction tables using our composition ID we obtained earlier*/
if(!empty($_POST['postASPDiffID'])) {
 
  /*This will insert the ASP difficulty from form into database*/
 
    /*washes the ASP difficulty value*/
    $ASPDiffID = htmlspecialchars($postASPDiffID);
    
    $ASPDiffInsertQuery = <<<_END

    INSERT INTO C2D (composition_ID, difficulty_ID)
    VALUES ($compositionID, $diffASPID);

_END;

    $resultASPDiffInsertQuery = $conn->query($ASPDiffInsertQuery);
    echo 'ASPDiffInsertQuery =' . $ASPDiffInsertQuery . '<br/>';
    
    if (!$resultASPDiffInsertQuery) echo("Error description: " . mysqli_error($conn));
    if ($resultASPDiffInsertQuery) {

      echo 'ASP difficulty successfully Inserted<br/>';
    
    } /*end if resultASPDiffInsertQuery*/
  
}/*end if !empty postASPDiffID*/
    

if(!empty($_POST['postGenDiffID'])) {
 
  /*This will insert the ASP difficulty from form into database*/
 
    /*washes the ASP difficulty value*/
    $GenDiffID = htmlspecialchars($postGenDiffID);
    
    $GendiffInsertQuery = <<<_END

    INSERT INTO C2D (composition_ID, difficulty_ID)
    VALUES ($compositionID, $diffGenID);

_END;

    $resultGenDiffInsertQuery = $conn->query($GendiffInsertQuery);
    echo 'GendiffInsertQuery =' . $GendiffInsertQuery . '<br/>';
    
    if (!$resultGenDiffInsertQuery) echo("Error description: " . mysqli_error($conn));
    if ($resultGenDiffInsertQuery) {

      echo 'Gen difficulty successfully Inserted';
    
    } /*end if resultGenDiffInsertQuery*/
  
}/*end if !empty postGenDiffID*/

    
    echo <<<_END

  <div class="form-style-10">
    <p>PAGE EIGHTEEN composer Search</p>
    <h2>So Far so good!</h2>
  
_END;

    echo 'querycomp = ' . $querycomp . '<br/><br/>';
    echo 'compositionID = ' . $compositionID .'<br/>';

}/*end if compname*/
  
/*F-  Retrieve Information to display First from junction tables. Store each in a variable.*/
/*keeping this for the time being so I won't have to re-write the code if I need it*/
  
/*will need to insert into the difficulties table too*/
/*will need to insert into C2B so I can connect the book and the composition?*/

   
    /*Now go right back and get the book information we just inserted by creating a Select statement*/
    /*Why is this not if(!result) echo "INSERT failed <br><br>"; like the original code?*/
   
    /*Don't need the lyricist or arranger info yet*/
    /*$query3 = <<<_END

    SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix, c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.keySignature, c.movement, e.description, g.genre_type, v.voicing_type, ens.ensemble_type, i.instr_name, p_composer.firstname, p_composer.middlename, p_composer.lastname, p_composer.suffix, p_arranger.firstname, p_arranger.middlename, p_arranger.lastname, p_arranger.suffix, p_lyricist.firstname, p_lyricist.middlename, p_lyricist.lastname, p_lyricist.suffix, d_a.difficulty_level AS a_difficulty, d_g.difficulty_level AS g_difficulty
          FROM compositions AS c
           LEFT JOIN C2B ON c.ID = C2B.composition_ID
           LEFT JOIN books AS b ON C2B.book_ID = b.ID 
           LEFT JOIN ensembles AS ens ON b.ID = ens.ID
           LEFT JOIN C2I ON c.ID = C2I.composition_ID
           LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID 
           LEFT JOIN C2G ON c.ID = C2G.composition_ID
           LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
           LEFT JOIN voicing AS v ON c.ID = v.ID
           LEFT JOIN eras AS e ON c.ID = e.ID 
           LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID 
           LEFT JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID 
           LEFT JOIN roles AS r_arranger ON C2R2P.role_ID = r_arranger.ID 
           LEFT JOIN roles AS r_lyricist ON C2R2P.role_ID = r_lyricist.ID 
           LEFT JOIN people AS p_composer ON C2R2P.people_ID = p_composer.ID AND r_composer.role_name = 'Composer'
           LEFT JOIN people AS p_arranger ON C2R2P.people_ID = p_arranger.ID AND r_arranger.role_name = 'Arranger'
           LEFT JOIN people AS p_lyricist ON C2R2P.people_ID = p_lyricist.ID AND r_lyricist.role_name = 'Lyricist'
          


 
          /* LEFT JOIN C2D ON c.ID = C2D.composition_ID
           
           LEFT JOIN difficulties AS d_a ON C2D.difficulty_ID = d_a.ID AND d_a.ID in (select d.ID from difficulties as d join organizations as o on d.org_ID = o.ID and o.org_name = 'ASP')
           
           LEFT JOIN difficulties AS d_g ON C2D.difficulty_ID = d_g.ID AND d_g.ID in (select d.ID from difficulties as d join organizations as o on d.org_ID = o.ID and o.org_name = 'General')


          WHERE c.ID = $compositionID  And b.ID = $bookID;

_END;

    */ 
/*Retrieving all key signatures for this composition
I will also be creating a comma separated list to use in the displayed information*/
$selectKeySigQuery = <<<_END
        SELECT  k.key_name
        FROM C2K
        LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
        WHERE C2K.composition_ID = $compositionID;

_END;

 $resultSelectKeySigQuery = $conn->query($selectKeySigQuery);
        echo '$selectKeySigQuery = ' . $selectKeySigQuery . '<br/><br/>';

         if (!$resultSelectKeySigQuery) die ("Database access failed1 <br/>");
         if ($resultSelectKeySigQuery) {     

        $numberOfRows = $resultSelectKeySigQuery->num_rows;
/*Build comma separated list of key signatures in a string*/

        $keySignatureString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultSelectKeySigQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

            
            $keySigName = ($row[0]);

            $keySignatureString .= $keySigName .", ";
            
          } /*for loop ending*/

/*$keySigString = implode(',',$sigVal);*/
 
    
} /*End if result kesig query*/

$displayKeySigString = rtrim($keySignatureString,', ');




/*Retrieving all key genres for this composition
I will also be creating a comma separated list to use in the displayed information*/
$selectGenresQuery = <<<_END

        SELECT  g.genre_type
        FROM C2G 
        LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
        WHERE C2G.composition_ID = $compositionID;


_END;

 $resultSelectGenresQuery = $conn->query($selectGenresQuery);
        echo '$selectGenresQuery = ' . $selectGenresQuery . '<br/><br/>';


         if (!$resultSelectGenresQuery) die ("Database access failed2 <br/>");
         if ($resultSelectGenresQuery) {     

        $numberOfRows = $resultSelectGenresQuery->num_rows;
/*Build comma separated list of genres in a string*/

        $genreString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultSelectGenresQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

           
            $genreName = ($row[0]);

            $genreString .= $genreName .", ";
            
          } /*for loop ending*/



    
} /*End if result kesig query*/

$displayGenreString = rtrim($genreString,', ');






/*Retrieving all instruments for this composition
I will also be creating a comma separated list to use in the displayed information*/
$selectInstrumentQuery = <<<_END
      SELECT  i.instr_name
      FROM C2I 
      LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID
      WHERE C2I.composition_ID = $compositionID;


_END;

 $resultSelectInstrumentQuery = $conn->query($selectInstrumentQuery);
        echo '$selectInstrumentQuery = ' . $selectInstrumentQuery . '<br/><br/>';

        /*TODO  change query names*/

         if (!$resultSelectInstrumentQuery) die ("Database access failed3 <br/>");
         if ($resultSelectInstrumentQuery) {     

        $numberOfRows = $resultSelectInstrumentQuery->num_rows;
/*Build comma separated list of instruments in a string*/
        $instrumentString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultSelectInstrumentQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

          
            $instrumentName = ($row[0]);
            
            $instrumentString .= $instrumentName .", ";
            
          } /*for loop ending*/


    
} /*End if result instrument query*/

$displayInstrumentString = rtrim($instrumentString,', ');





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
        echo '$selectGenDiffQuery = ' . $selectGenDiffQuery . '<br/><br/>';


         if (!$resultselectGenDiffQuery) die ("Database access failed4 <br/>");
         if ($resultselectGenDiffQuery) {     

        $GenNumberOfRows = $resultselectGenDiffQuery->num_rows;


        for ($j = 0 ; $j < $GenNumberOfRows ; ++$j)
          {
            $row = $resultselectGenDiffQuery->fetch_array(MYSQLI_NUM);

          /*  var_dump ($row);*/
           
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
        echo '$selectASPDiffQuery = ' . $selectASPDiffQuery . '<br/><br/>';


         if (!$resultselectASPDiffQuery) die ("Database access failed5 <br/>");
         if ($resultselectASPDiffQuery) {     

        $ASPNumberOfRows = $resultselectASPDiffQuery->num_rows;


        for ($j = 0 ; $j < $ASPNumberOfRows ; ++$j)
          {
            $row = $resultselectASPDiffQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

           
            $ASPDiffName = ($row[0]);
            
          } /*for loop ending*/
    
} /*End if result select ASPdiff query*/



/*G- Retrieve book and Composition information to display in browser.
1- Book Information
2- Composition information minus the composer, Arranger, or Lyricist*/
        $bookQuery = <<<_END

        SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, p.firstname, p.middlename, p.lastname, p.suffix, org_pub.org_name, org_pub.location
           FROM books AS b
           LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
           LEFT JOIN roles AS r_ed ON B2R2P.role_ID = r_ed.ID AND r_ed.role_name = 'Editor'
           LEFT JOIN people AS p ON B2R2P.people_ID = p.ID
           
           LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
           LEFT JOIN roles AS r_pub ON B2R2O.role_ID = r_pub.ID AND r_pub.role_name = 'Publisher'
           LEFT JOIN organizations AS org_pub ON B2R2O.org_ID = org_pub.ID              

            WHERE b.ID = $bookID  

_END;

      $resultBookQuery = $conn->query($bookQuery);
        echo 'bookQuery = ' . $bookQuery . '<br/><br/>';

         if (!$resultBookQuery) die ("Database access failed3 <br/>");
         if ($resultBookQuery) {     

        $numberOfRows = $resultBookQuery->num_rows;

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultBookQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/
        /*We do not need to sanitze these*/
            $bookID = ($row[0]);
            $bookTitle = ($row[1]);
            $bookTag1 = ($row[2]);
            $bookTag2 = ($row[3]);
            $bookVolume = ($row[4]);
            $bookNumber = ($row[5]);
            $editorFirstName = ($row[6]);
            $editorMiddleName= ($row[7]);
            $editorLastName = ($row[8]);
            $editorSuffix = ($row[9]);
            $publisherName = ($row[10]);
            $publisherLocation = ($row[11]);

} /*End if resultBookQuery*/

       $compositionQuery = <<<_END
        SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, e.description,v.voicing_type, ens.ensemble_type, c.book_ID
        FROM compositions AS c
        LEFT JOIN eras AS e ON c.era_ID = e.ID
        LEFT JOIN voicing AS v ON c.voice_ID = v.ID
        LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
        LEFT JOIN books AS b ON c.book_ID = b.ID

        WHERE c.ID = $compositionID;

_END;

      $resultCompositionQuery = $conn->query($compositionQuery);
        echo 'bookQuery = ' . $bookQuery . '<br/><br/>';

         if (!$resultCompositionQuery) die ("Database access failed3 <br/>");
         if ($resultCompositionQuery) {     

        $numberOfRows = $resultCompositionQuery->num_rows;

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);

          /*  var_dump ($row);*/

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
           
          } /*for loop ending*/

/* H- Display Book information and Composition info Using HTML*/
    echo <<<_END

 <form action='multipageform2.php' method='post'>
     
      <h3>Book Info</h3>
     Book Title: $bookTitle <br/>
     Tag 1: $bookTag1 <br/>
     Tag 2: $bookTag2 <br/>
     Book Volume: $bookVolume <br/>
     Book Number: $bookNumber <br/>
     Book Editor name: $editorFirstName $editoryMiddleName $editorLastName $editorSuffix<br/>
     Book Publisher: $publisherName<br/>
     Publisher Location: $publisherLocation<br/>

      <h3>Compsition Info</h3>
    Composition Name: $compName <br/>
    Opus-Like: $opusLike <br/>
    Opus No.: $compNum <br/>
    Composition No.: $compNo <br/>
    Subtitle: $subTitle <br/>
    Key Signature: $displayKeySigString <br/>
    Movement: $movement <br/>
    Era: $era <br/>
    Genre: $displayGenreString<br/>
    Voice: $voice <br/>
    Ensemble: $ensemble <br/>
    Instrument: $displayInstrumentString <br/>
    General difficulty: $GenDiffName <br/>
    ASP difficulty: $ASPDiffName<br/>

_END;
    
/* I- Display form with text box for composer’s last name and Button “Search for this composer”
And Pass hidden values needed for next page.*/

echo<<<_END

    <h3>Enter Composer's LAST NAME only</h3>
    <div class="section">
      <input type="text" name="searchComposerLastName"/>
    </div>

 <div class="button-section">
     <input type='submit' value='Search for this composer'/>
     <input type='hidden' name="next" value='showPage19'/>
     <input type='hidden' name="bookID" value='$bookID'/>
     <input type='hidden' name="compositionID" value='$compositionID'/>

    </div>
  </form>
</div>
      
      
    </form><br/><br/>

_END;
        
  } /*End If $resultcomposition query*/
  

} /*End if isset post compname*/


} /*elseif ending*/






  




/*Page 19  Composer Options*/

  elseif (isset($_POST['next']) && $_POST['next'] == 'showPage19')
  {
/*Lists composers with similar last name*/
 
   $bookID = $_POST['bookID'];
   $compositionID = $_POST['compositionID']; 
   echo <<<_END
  
   <p>PAGE NINETEEN / Composer options</p>
   
   <h3>Choose a Composer option below</h3>

   <form action='multipageform2.php' method='post'>
    <div class="section">

_END;



/*If the user entered at least the lastname of the composer*/
if(isset($_POST['composerLastName'])){

/*wash the data coming in from user table pg 20*/
            $composerFirstName=  get_post($conn, 'composerFirstName');
            $composerMiddleName =  get_post($conn, 'composerMiddleName');
            $composerLastName =  get_post($conn, 'composerLastName');
            $composerSuffix =  get_post($conn, 'composerSuffix');
            

 /*create the insert query to add the users composer info into the people table*/ 
  /*$queryPeopleInsert = <<<_END

    INSERT INTO people (firstname, middlename, lastname, suffix)
    VALUES('{$_POST['composerFirstName']}','{$_POST['composerMiddleName']}','{$_POST['composerLastName']}','{$_POST['composerSuffix']}');
_END;*/

    $queryPeopleInsert = <<<_END

    INSERT INTO people (firstname, middlename, lastname, suffix)
    VALUES('$composerFirstName', '$composerMiddleName', '$composerLastName', '$composerSuffix');

_END;

      echo ("\n queryPeopleInsert = " . $queryPeopleInsert . "\n<br/>");
      /*Send query and place result into this variable*/
      $queryPeopleInsertResult = $conn->query($queryPeopleInsert);

      if (!$queryPeopleInsertResult) echo("\n Error description: " . mysqli_error($conn) . "\n<br/>");

      /*Need the most recent id entered for my people id for later*/
      $peopleID = $conn->insert_id;


    /*Getting the composer Role ID so I can use it in the insert query below*/
    $roleQuery = "SELECT ID FROM roles WHERE role_name = 'Composer'";
      echo ("\n roleQuery = " . $roleQuery . "\n<br/><br/>");
      
      /*Send the query to the database*/
      $roleQueryResult   = $conn->query($roleQuery);
     
      /*incase result fails*/ 
      if (!$roleQueryResult) die ("Database access failed");

      if ($roleQueryResult) {
      $numberOfRows = $roleQueryResult->num_rows;  /*gets the number of rows in a result*/

        
      /*build forloop*/
      for ($j = 0 ; $j < $numberOfRows ; ++$j){
         $row = $roleQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/

        /*create variables to hold each index (or column) from the given result row array*/
        
        /*This variable can now be used in other code*/
          $composerRoleID = ($row[0]);
          
        } /*for loop ending*/

    } /*End if Rolequery result*/

    /*create insert query to add a row to the B2R2P table to connect this person with this book as an editor*/
    $insertQuery = "INSERT INTO C2R2P (composition_ID, role_ID, people_ID)
      VALUES (  $compositionID,
                $composerRoleID,
                $peopleID
                )";

      echo ("\n insertQuery = " . $insertQuery . "\n<br/>");
      /*Send query and place result into this variable*/
      $insertQueryResult = $conn->query($insertQuery);

      if (!$insertQueryResult) echo("Error description: " . mysqli_error($conn));





        $composerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID AND r_composer.role_name = 'Composer'
        WHERE p.lastname = '$composerLastName';

_END;

        echo 'composerQuery = ' . $composerQuery . '<br/><br/>';
        /*send the query*/
        $resultComposerQuery = $conn->query($composerQuery);

       
        if (!$resultComposerQuery) die ("Database access failed composerQuery");
        if ($resultComposerQuery){
     
          $numberOfRows = $resultComposerQuery->num_rows;

          $composerFound = ($numberOfRows  > 0);
          $composerNotFound = ($numberOfRows === 0);
          if ($composerNotFound) {
           
            echo "<h3>No composer by the last name of  " . $composerLastName . " was found. <br/><br/> Would you like to add this composer information to this composition? <br/><br/>";
          } /*END if composer not found*/
         

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

            $composerID = ($row[0]);
            $compFirst = ($row[1]);
            $compMiddle = ($row[2]);
            $compLast = ($row[3]);
            $compSuffix = ($row[4]);
            

echo <<<_END

          <input type="radio" name="composerPeopleID" value="$composerID"/> Composer Name: $compFirst $compMiddle $compLast $compSuffix<br><br>
_END;

          } /*for loop ending*/
      } /*End if $resultComposerQuery*/

}  /*END if isset composerlast name*/





/*printed out header, now we will loop through results set and display one radio per row*/
    if (isset($_POST['searchComposerLastName'])) {
    
        $searchComposerLastName =  get_post($conn, 'searchComposerLastName');
       
        /*create query to select the editor from the database if it comes from either pg 7a or 6*/
        
      $composerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID AND r_composer.role_name = 'Composer'
        WHERE p.lastname = '$searchComposerLastName';

_END;

       


        echo 'composerQuery = ' . $composerQuery . '<br/><br/>';
        /*send the query*/
        $resultComposerQuery = $conn->query($composerQuery);

       
        if (!$resultComposerQuery) die ("Database access failed composerQuery");
        if ($resultComposerQuery){
       
          $numberOfRows = $resultComposerQuery->num_rows;
          
          $composerFound = ($numberOfRows  > 0);
          $composerNotFound = ($numberOfRows === 0);
          if ($composerNotFound) {
           
            echo "<h3>No composer by the last name of  \"" . $searchComposerLastName . "\" was found. <br/><br/> Would you like to add this composer information to this composition? <br/><br/>";
          } /*END if composer not found*/

          

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

            $composerID = ($row[0]);
            $compFirst = ($row[1]);
            $compMiddle = ($row[2]);
            $compLast = ($row[3]);
            $compSuffix = ($row[4]);


            

echo <<<_END

          <input type="radio" name="composerPeopleID" value="$composerID"/> Composer Name: $compFirst $compMiddle $compLast $compSuffix<br><br>
_END;

          } /*for loop ending*/

      } /*End ifresult ComposerQuery*/
        
  } /*End if isset post composerLastName */
      
if($composerFound ) {

echo <<<_END

          <input type='submit' value='Choose Composer'/>
          <input type='hidden' name="next" value='showPage21'/> 
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
      </div> 
    </form><br/>

      <h2>None of these composers match</h2>

_END;

  } /*END if $composerFound*/

  echo <<<_END

    <form action='multipageform2.php' method='post'>
          
          <input type='submit' value='Add Composer Info to this composition'/>
          <input type='hidden' name='next' value='showPage20'/>
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
      
      
    </form><br/><br/>

_END;

 

} /*elseif ending*/


 















  /*Page 20  Add Composer*/

   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage20')
  {
    

echo <<<_END
<p>TWENTY add composer</p>
<div class="form-style-10">
<h2> Enter Composer Information Below</h2>

_END;

$bookID = $_POST['bookID'];
$compositionID = $_POST['compositionID'];
echo ("bookID = " . $_POST['bookID']);

echo <<<_END
   
  <form action='multipageform2.php' method='post'>
   <div class="section">
    First Name: <input type="text" name="composerFirstName"/><br/>
    Middle Name: <input type="text" name="composerMiddleName"/><br/>
    Last Name: <input type="text" name="composerLastName"/><br/>
    Suffix: <input type="text" name="composerSuffix"/><br/>
   </div>
  <div class="button-section">
    <input type='submit' value='Submit and Continue'/><br/>
    <input type='hidden' name="next" value='showPage19'/>
    <input type='hidden' name="bookID" value="$bookID"/>
    <input type='hidden' name="compositionID" value="$compositionID"/>
   </div>
  </form>

  
</div>

_END;

  }


/*   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage20')
  {
    echo ("Enter Composer Information");

echo <<<_END
<div class="form-style-10">
<p>PAGE TWENTY</p>
  <form action='multipageform2.php' method='post'>
   <div class="section">
    First Name: <input type="text" name="firstName"/><br/>
    Middle Name: <input type="text" name="middleName"/><br/>
    Last Name: <input type="text" name="lastName"/><br/>
    Suffix: <input type="text" name="suffix"/><br/>
   </div>
  <div class="button-section">
    <input type='submit' value='submit'/>
    <input type='hidden' name="next" value='showPage21'/>
   </div>
  </form>

  
</div>
_END;

  }*/











   /*Page 21  Arranger Search*/
elseif (isset($_POST['next']) && $_POST['next'] == 'showPage21') {
$compositionID = $_POST['compositionID'];
$bookID = $_POST['bookID'];
$composerPeopleID = $_POST['composerPeopleID'];
echo <<<_END
  <div class="form-style-10">
    <p>PAGE TWENTYONE</p>
    <form action='multipageform2.php' method='post'>
    <div class="section"> 

_END;

      /*Retrieving all key signatures for this composition
I will also be creating a comma separated list to use in the displayed information*/
      $selectKeySigQuery = <<<_END
      SELECT  k.key_name
      FROM C2K
      LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
      WHERE C2K.composition_ID = $compositionID;

_END;

 $resultSelectKeySigQuery = $conn->query($selectKeySigQuery);
        echo '$selectKeySigQuery = ' . $selectKeySigQuery . '<br/><br/>';

         if (!$resultSelectKeySigQuery) die ("Database access failed1 <br/>");
         if ($resultSelectKeySigQuery) {     

        $numberOfRows = $resultSelectKeySigQuery->num_rows;
/*Build comma separated list of key signatures in a string*/

        $keySignatureString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultSelectKeySigQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

            
            $keySigName = ($row[0]);

            $keySignatureString .= $keySigName .", ";
            
          } /*for loop ending*/

/*$keySigString = implode(',',$sigVal);*/
 
    
} /*End if result kesig query*/

$displayKeySigString = rtrim($keySignatureString,', ');




/*Retrieving all key genres for this composition
I will also be creating a comma separated list to use in the displayed information*/
$selectGenresQuery = <<<_END

        SELECT  g.genre_type
        FROM C2G 
        LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
        WHERE C2G.composition_ID = $compositionID;


_END;

 $resultSelectGenresQuery = $conn->query($selectGenresQuery);
        echo '$selectGenresQuery = ' . $selectGenresQuery . '<br/><br/>';


         if (!$resultSelectGenresQuery) die ("Database access failed2 <br/>");
         if ($resultSelectGenresQuery) {     

        $numberOfRows = $resultSelectGenresQuery->num_rows;
/*Build comma separated list of genres in a string*/

        $genreString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultSelectGenresQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

           
            $genreName = ($row[0]);

            $genreString .= $genreName .", ";
            
          } /*for loop ending*/
    
} /*End if result kesig query*/

$displayGenreString = rtrim($genreString,', ');


/*Retrieving all instruments for this composition
I will also be creating a comma separated list to use in the displayed information*/
$selectInstrumentQuery = <<<_END
      SELECT  i.instr_name
      FROM C2I 
      LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID
      WHERE C2I.composition_ID = $compositionID;


_END;

 $resultSelectInstrumentQuery = $conn->query($selectInstrumentQuery);
        echo '$selectInstrumentQuery = ' . $selectInstrumentQuery . '<br/><br/>';

        /*TODO  change query names*/

         if (!$resultSelectInstrumentQuery) die ("Database access failed3 <br/>");
         if ($resultSelectInstrumentQuery) {     

        $numberOfRows = $resultSelectInstrumentQuery->num_rows;
/*Build comma separated list of instruments in a string*/
        $instrumentString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultSelectInstrumentQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

          
            $instrumentName = ($row[0]);
            
            $instrumentString .= $instrumentName .", ";
            
          } /*for loop ending*/


    
} /*End if result instrument query*/

$displayInstrumentString = rtrim($instrumentString,', ');





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
        echo '$selectGenDiffQuery = ' . $selectGenDiffQuery . '<br/><br/>';


         if (!$resultselectGenDiffQuery) die ("Database access failed4 <br/>");
         if ($resultselectGenDiffQuery) {     

        $GenNumberOfRows = $resultselectGenDiffQuery->num_rows;


        for ($j = 0 ; $j < $GenNumberOfRows ; ++$j)
          {
            $row = $resultselectGenDiffQuery->fetch_array(MYSQLI_NUM);

          /*  var_dump ($row);*/
           
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
        echo '$selectASPDiffQuery = ' . $selectASPDiffQuery . '<br/><br/>';


         if (!$resultselectASPDiffQuery) die ("Database access failed5 <br/>");
         if ($resultselectASPDiffQuery) {     

        $ASPNumberOfRows = $resultselectASPDiffQuery->num_rows;


        for ($j = 0 ; $j < $ASPNumberOfRows ; ++$j)
          {
            $row = $resultselectASPDiffQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

           
            $ASPDiffName = ($row[0]);
            
          } /*for loop ending*/
    
} /*End if result select ASPdiff query*/



/*G- Retrieve book and Composition information to display in browser.
1- Book Information
2- Composition information minus the composer, Arranger, or Lyricist*/
        $bookQuery = <<<_END

        SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, p.firstname, p.middlename, p.lastname, p.suffix, org_pub.org_name, org_pub.location
           FROM books AS b
           LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
           LEFT JOIN roles AS r_ed ON B2R2P.role_ID = r_ed.ID AND r_ed.role_name = 'Editor'
           LEFT JOIN people AS p ON B2R2P.people_ID = p.ID
           
           LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
           LEFT JOIN roles AS r_pub ON B2R2O.role_ID = r_pub.ID AND r_pub.role_name = 'Publisher'
           LEFT JOIN organizations AS org_pub ON B2R2O.org_ID = org_pub.ID              

            WHERE b.ID = $bookID  

_END;

      $resultBookQuery = $conn->query($bookQuery);
        echo 'bookQuery = ' . $bookQuery . '<br/><br/>';

         if (!$resultBookQuery) die ("Database access failed3 <br/>");
         if ($resultBookQuery) {     

        $numberOfRows = $resultBookQuery->num_rows;

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultBookQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/
        /*We do not need to sanitze these*/
            $queryBookID = ($row[0]);
            $bookTitle = ($row[1]);
            $bookTag1 = ($row[2]);
            $bookTag2 = ($row[3]);
            $bookVolume = ($row[4]);
            $bookNumber = ($row[5]);
            $editorFirstName = ($row[6]);
            $editorMiddleName= ($row[7]);
            $editorLastName = ($row[8]);
            $editorSuffix = ($row[9]);
            $publisherName = ($row[10]);
            $publisherLocation = ($row[11]);

          } /*End Book Query for loop*/
        } /*End if resultBookQuery*/

       $compositionQuery = <<<_END
        SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, e.description,v.voicing_type, ens.ensemble_type, c.book_ID 
        FROM compositions AS c
        LEFT JOIN eras AS e ON c.era_ID = e.ID
        LEFT JOIN voicing AS v ON c.voice_ID = v.ID
        LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
        LEFT JOIN books AS b ON c.book_ID = b.ID

        WHERE c.ID = $compositionID;
       
_END;

      $resultCompositionQuery = $conn->query($compositionQuery);
        echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';

         if (!$resultCompositionQuery) die ("Database access failed3 <br/>");
         if ($resultCompositionQuery) {     

        $numberOfRows = $resultCompositionQuery->num_rows;

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);

          /*  var_dump ($row);*/

            $queryCompositionID = ($row[0]);
            $compName = ($row[1]);            
            $opusLike = ($row[2]);
            $compNum = ($row[3]);
            $compNo = ($row[4]);
            $subTitle = ($row[5]);                          
            $movement = ($row[6]);
            $era = ($row[7]);            
            $voice = ($row[8]);
            $ensemble = ($row[9]); 
            $CompbookID = ($row[10]);
            
           
          } /*for loop ending*/
        } /*END result Composition Query*/

 $composerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID AND r_composer.role_name = 'Composer'
        WHERE p.ID = $composerPeopleID;

_END;

        echo 'composerQuery = ' . $composerQuery . '<br/><br/>';
        /*send the query*/
        $resultComposerQuery = $conn->query($composerQuery);

       
        if (!$resultComposerQuery) die ("Database access failed composerQuery");
        if ($resultComposerQuery){
        echo 'Hooray';
          $numberOfRows = $resultComposerQuery->num_rows;

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

            $composerID = ($row[0]);
            $compFirst = ($row[1]);
            $compMiddle = ($row[2]);
            $compLast = ($row[3]);
            $compSuffix = ($row[4]);
            
          } /*for loop ending*/
        } /*END if result composer query*/

/* H- Display Book information and Composition info Using HTML*/
    echo <<<_END
     
      <h3>Book Info</h3>
     Book Title: $bookTitle <br/>
     Tag 1: $bookTag1 <br/>
     Tag 2: $bookTag2 <br/>
     Book Volume: $bookVolume <br/>
     Book Number: $bookNumber <br/>
     Book Editor name: $editorFirstName $editoryMiddleName $editorLastName $editorSuffix<br/>
     Book Publisher: $publisherName<br/>
     Publisher Location: $publisherLocation<br/>

      <h3>Compsition Info</h3>
    Composition Name: $compName <br/>
    Opus-Like: $opusLike <br/>
    Opus No.: $compNum <br/>
    Composition No.: $compNo <br/>
    Subtitle: $subTitle <br/>
    Key Signature: $displayKeySigString <br/>
    Movement: $movement <br/>
    Era: $era <br/>
    Genre: $displayGenreString<br/>
    Voice: $voice <br/>
    Ensemble: $ensemble <br/>
    Instrument: $displayInstrumentString <br/>
    General difficulty: $GenDiffName <br/>
    ASP difficulty: $ASPDiffName<br/>
    Composer Name: $compFirst $compMiddle $compLast $compSuffix <br/>


    
        <h3>Is there an arranger for this composition?</h3>
        NO, No Arranger for this Composition<br/>
      </div>
      <div class="button-section">
        <input type='submit' value='Continue'/>
         <input type='hidden' name='bookID' value= '$bookID'/>
        <input type='hidden' name='compositionID' value= '$compositionID'/>
        <input type='hidden' name="next" value='showPage24'/>
      </div>
      </form>

      <form action='multipageform2.php' method='post'>
      <div class="section">      
        <p>YES, Enter LAST NAME of Arranger</p>
        <input type="text" name="searchArrangerLastName" />
      </div>
      <div class="button-section">
        <input type='submit' value='Search for this ARRANGER'/>
        <input type='hidden' name="next" value='showPage22'/>
        <input type='hidden' name='bookID' value= '$bookID'/>
        <input type='hidden' name='compositionID' value= '$compositionID'/>
      </div>
      </form>
    
    </div> 
  

_END;

  }/*END else if page 21*/












  /*Page 22  Arranger Options*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage22')
  {
    /*Lists composers with similar last name*/

 
   $bookID = $_POST['bookID'];
   $compositionID = $_POST['compositionID'];
   
   echo <<<_END
  
   <p>PAGE TWENTYTWO / Arranger options</p>
   
   <h3>Choose an arranger option below</h3>

   <form action='multipageform2.php' method='post'>
    <div class="section">

_END;


/*In this section we will process Arranger information being submitted to the data base by the user in the form on pg 23*/
/*If the user entered at least the lastname of the arranger in the form on page23*/
if(isset($_POST['arrangerLastName'])){

/*wash the data coming in from user form pg 23*/
            $arrangerFirstName=  get_post($conn, 'arrangerFirstName');
            $arrangerMiddleName =  get_post($conn, 'arrangerMiddleName');
            $arrangerLastName =  get_post($conn, 'arrangerLastName');
            $arrangerSuffix =  get_post($conn, 'arrangerSuffix');
            

 /*create the insert query to add the users arranger info into the people table*/ 
  

    $queryPeopleInsert = <<<_END

    INSERT INTO people (firstname, middlename, lastname, suffix)
    VALUES('$arrangerFirstName', '$arrangerMiddleName', '$arrangerLastName', '$arrangerSuffix');

_END;

      echo ("\n queryPeopleInsert = " . $queryPeopleInsert . "\n<br/>");
      /*Send query and place result into this variable*/
      $queryPeopleInsertResult = $conn->query($queryPeopleInsert);

      if (!$queryPeopleInsertResult) echo("\n Error description: " . mysqli_error($conn) . "\n<br/>");

      /*Need the most recent id entered for my people id for later*/
      $peopleID = $conn->insert_id;


    /*Getting the arrnger Role ID so I can use it in the insert query below*/
    $roleQuery = "SELECT ID FROM roles WHERE role_name = 'Arranger'";
      echo ("\n roleQuery = " . $roleQuery . "\n<br/><br/>");
      
      /*Send the query to the database*/
      $roleQueryResult   = $conn->query($roleQuery);
     
      /*incase result fails*/ 
      if (!$roleQueryResult) die ("Database access failed");

      if ($roleQueryResult) {
      $numberOfRows = $roleQueryResult->num_rows;  /*gets the number of rows in a result*/


      /*build forloop*/
      for ($j = 0 ; $j < $numberOfRows ; ++$j){
         $row = $roleQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/

        /*create variables to hold each index (or column) from the given result row array*/
        
        /*This variable can now be used in other code*/
          $arrangerRoleID = ($row[0]);
          
        } /*for loop ending*/

    } /*End if Rolequery result*/

    /*create insert query to add a row to the C2R2P table to connect this person with this composition as an arranger*/
    $insertQuery = "INSERT INTO C2R2P (composition_ID, role_ID, people_ID)
      VALUES (  $compositionID,
                $arrangerRoleID,
                $peopleID
                )";

      echo ("\n insertQuery = " . $insertQuery . "\n<br/>");
      /*Send query and place result into this variable*/
      $insertQueryResult = $conn->query($insertQuery);

      if (!$insertQueryResult) echo("Error description: " . mysqli_error($conn)) ;



   $arrangerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_arr ON C2R2P.role_ID = r_arr.ID AND r_arr.role_name = 'Arranger'
        WHERE p.ID = $peopleID;

_END;

        echo 'arrangerQuery = ' . $arrangerQuery . '<br/><br/>';
        /*send the query*/
        $resultArrangerQuery = $conn->query($arrangerQuery);

       
        if (!$resultArrangerQuery) die ("Database access failed arrangerQuery");
        if ($resultArrangerQuery){
       
          $numberOfRows = $resultArrangerQuery->num_rows;

          $arrangerFound = ($numberOfRows  > 0);
          $arrangerNotFound = ($numberOfRows === 0);
          if ($arrangerNotFound) {
           
            echo "<h3>No arranger by the last name of  " . $arrangerLastName . " was found. <br/><br/> Would you like to add this arranger information to this composition? <br/><br/>";
          } /*END if arranger not found*/

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultArrangerQuery->fetch_array(MYSQLI_NUM);

            $arrangerID = ($row[0]);
            $arrFirst = ($row[1]);
            $arrMiddle = ($row[2]);
            $arrLast = ($row[3]);
            $arrSuffix = ($row[4]);
            

echo <<<_END

          <input type="radio" name="arrangerPeopleID" value="$arrangerID"/> Arranger Name: $arrFirst $arrMiddle $arrLast $arrSuffix<br><br>
_END;

          } /*for loop ending*/
      } /*End if $resultArrangerQuery*/

}  /*END if isset arrangerlast name*/




/*In this section we will search the data base for the Arranger the user is looking for. They will have submitted the last name of the Arranger they want in the text box on pg 21*/
    if (isset($_POST['searchArrangerLastName'])) {
    
        $searchArrangerLastName =  get_post($conn, 'searchArrangerLastName');
       
      
        
      $arrangerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_arr ON C2R2P.role_ID = r_arr.ID AND r_arr.role_name = 'Arranger'
        WHERE p.lastname = '$searchArrangerLastName';

_END;

       


        echo 'arrangerQuery = ' . $arrangerQuery . '<br/><br/>';
        /*send the query*/
        $resultArrangerQuery = $conn->query($arrangerQuery);

       
        if (!$resultArrangerQuery) die ("Database access failed arrangerQuery");
        if ($resultArrangerQuery){
       
          $numberOfRows = $resultArrangerQuery->num_rows;

          $arrangerFound = ($numberOfRows  > 0);
          $arrangerNotFound = ($numberOfRows === 0);
          if ($arrangerNotFound) {
           
            echo "<h3>No arranger by the last name of  " . $searchArrangerLastName . " was found. <br/><br/> Would you like to add this arranger information to this composition? <br/><br/>";
          } /*END if arranger not found*/

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultArrangerQuery->fetch_array(MYSQLI_NUM);

            $arrangerID = ($row[0]);
            $arrFirst = ($row[1]);
            $arrMiddle = ($row[2]);
            $arrLast = ($row[3]);
            $arrSuffix = ($row[4]);


            

echo <<<_END

          <input type="radio" name="arrangerPeopleID" value="$arrangerID"/> Arranger Name: $arrFirst $arrMiddle $arrLast $arrSuffix<br><br>
_END;

          } /*for loop ending*/

      } /*End ifresult arrangerQuery*/ 
        
  } /*End if isset post searchArrangerLastName */
      

if ($arrangerFound ) {

  echo <<<_END

          <input type='submit' value='Choose Arranger'/>
          <input type='hidden' name="next" value='showPage24'/> 
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
      </div> 
    </form><br/>
    <h2>None of these arrangers match</h2>


_END;

} /*END if $arrangerFound*/
  

  echo <<<_END

    <form action='multipageform2.php' method='post'>
          
          <input type='submit' value='Add Arranger Info to this composition'/>
          <input type='hidden' name='next' value='showPage23'/>
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
      
      
    </form><br/><br/>

_END;


} /*elseif ending*/


  

  /*Page 23  Add Arranger*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage23')
  {
$bookID = $_POST['bookID'] ; 
$compositionID = $_POST['compositionID']; 

echo <<<_END
<div class="form-style-10">
<p>PAGE TWENTYTHREE</p>
<h2>Add arranger info below</h2>
  <form action='multipageform2.php' method='post'>
   <div class="section">
    First Name: <input type="text" name="arrangerFirstName"/><br/>
    Middle Name: <input type="text" name="arrangerMiddleName"/><br/>
    Last Name: <input type="text" name="arrangerLastName"/><br/>
    Suffix: <input type="text" name="arrangerSuffix"/><br/>
   </div>
  <div class="button-section">
    <input type='submit' value='Continue'/>
    <input type='hidden' name="next" value='showPage22'/>
    <input type='hidden' name='bookID' value='$bookID'/>
    <input type='hidden' name='compositionID' value='$compositionID'/>
   </div>
  </form>

  
</div>

_END;

  }/*END else if show pg 23*/










   /*Page 24  Lyricist Search*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage24')
  {
    
   

echo <<<_END
<div class="form-style-10">
<p>PAGE TWENTYFOUR</p>
<h2>Your Arranger information has been added to your current book</h2>

<form action='multipageform2.php' method='post'>
   <div class="section">
_END;

  $compositionID = $_POST['compositionID'];
  $bookID = $_POST['bookID'];
  $composerPeopleID = $_POST['composerPeopleID'];
  $searchArrangerLastName = $_POST['searchArrangerLastName'];



      /*Retrieving all key signatures for this composition
I will also be creating a comma separated list to use in the displayed information*/
      $selectKeySigQuery = <<<_END
      SELECT  k.key_name
      FROM C2K
      LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
      WHERE C2K.composition_ID = $compositionID;

_END;

 $resultSelectKeySigQuery = $conn->query($selectKeySigQuery);
        echo '$selectKeySigQuery = ' . $selectKeySigQuery . '<br/><br/>';

         if (!$resultSelectKeySigQuery) die ("Database access failed1 <br/>");
         if ($resultSelectKeySigQuery) {     

        $numberOfRows = $resultSelectKeySigQuery->num_rows;
/*Build comma separated list of key signatures in a string*/

        $keySignatureString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultSelectKeySigQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

            
            $keySigName = ($row[0]);

            $keySignatureString .= $keySigName .", ";
            
          } /*for loop ending*/

/*$keySigString = implode(',',$sigVal);*/
 
    
} /*End if result kesig query*/

$displayKeySigString = rtrim($keySignatureString,', ');




/*Retrieving all key genres for this composition
I will also be creating a comma separated list to use in the displayed information*/
$selectGenresQuery = <<<_END

        SELECT  g.genre_type
        FROM C2G 
        LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
        WHERE C2G.composition_ID = $compositionID;


_END;

 $resultSelectGenresQuery = $conn->query($selectGenresQuery);
        echo '$selectGenresQuery = ' . $selectGenresQuery . '<br/><br/>';


         if (!$resultSelectGenresQuery) die ("Database access failed2 <br/>");
         if ($resultSelectGenresQuery) {     

        $numberOfRows = $resultSelectGenresQuery->num_rows;
/*Build comma separated list of genres in a string*/

        $genreString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultSelectGenresQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

           
            $genreName = ($row[0]);

            $genreString .= $genreName .", ";
            
          } /*for loop ending*/
    
} /*End if result kesig query*/

$displayGenreString = rtrim($genreString,', ');


/*Retrieving all instruments for this composition
I will also be creating a comma separated list to use in the displayed information*/
$selectInstrumentQuery = <<<_END
      SELECT  i.instr_name
      FROM C2I 
      LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID
      WHERE C2I.composition_ID = $compositionID;


_END;

 $resultSelectInstrumentQuery = $conn->query($selectInstrumentQuery);
        echo '$selectInstrumentQuery = ' . $selectInstrumentQuery . '<br/><br/>';

        /*TODO  change query names*/

         if (!$resultSelectInstrumentQuery) die ("Database access failed3 <br/>");
         if ($resultSelectInstrumentQuery) {     

        $numberOfRows = $resultSelectInstrumentQuery->num_rows;
/*Build comma separated list of instruments in a string*/
        $instrumentString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultSelectInstrumentQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

          
            $instrumentName = ($row[0]);
            
            $instrumentString .= $instrumentName .", ";
            
          } /*for loop ending*/


    
} /*End if result instrument query*/

$displayInstrumentString = rtrim($instrumentString,', ');





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
        echo '$selectGenDiffQuery = ' . $selectGenDiffQuery . '<br/><br/>';


         if (!$resultselectGenDiffQuery) die ("Database access failed4 <br/>");
         if ($resultselectGenDiffQuery) {     

        $GenNumberOfRows = $resultselectGenDiffQuery->num_rows;


        for ($j = 0 ; $j < $GenNumberOfRows ; ++$j)
          {
            $row = $resultselectGenDiffQuery->fetch_array(MYSQLI_NUM);

          /*  var_dump ($row);*/
           
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
        echo '$selectASPDiffQuery = ' . $selectASPDiffQuery . '<br/><br/>';


         if (!$resultselectASPDiffQuery) die ("Database access failed5 <br/>");
         if ($resultselectASPDiffQuery) {     

        $ASPNumberOfRows = $resultselectASPDiffQuery->num_rows;


        for ($j = 0 ; $j < $ASPNumberOfRows ; ++$j)
          {
            $row = $resultselectASPDiffQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

           
            $ASPDiffName = ($row[0]);
            
          } /*for loop ending*/
    
} /*End if result select ASPdiff query*/



/*G- Retrieve book and Composition information to display in browser.
1- Book Information
2- Composition information minus the composer, Arranger, or Lyricist*/
        $bookQuery = <<<_END

        SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, p.firstname, p.middlename, p.lastname, p.suffix, org_pub.org_name, org_pub.location
           FROM books AS b
           LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
           LEFT JOIN roles AS r_ed ON B2R2P.role_ID = r_ed.ID AND r_ed.role_name = 'Editor'
           LEFT JOIN people AS p ON B2R2P.people_ID = p.ID
           
           LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
           LEFT JOIN roles AS r_pub ON B2R2O.role_ID = r_pub.ID AND r_pub.role_name = 'Publisher'
           LEFT JOIN organizations AS org_pub ON B2R2O.org_ID = org_pub.ID              

            WHERE b.ID = $bookID  

_END;

      $resultBookQuery = $conn->query($bookQuery);
        echo 'bookQuery = ' . $bookQuery . '<br/><br/>';

         if (!$resultBookQuery) die ("Database access failed3 <br/>");
         if ($resultBookQuery) {     

        $numberOfRows = $resultBookQuery->num_rows;

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultBookQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/
        /*We do not need to sanitze these*/
            $queryBookID = ($row[0]);
            $bookTitle = ($row[1]);
            $bookTag1 = ($row[2]);
            $bookTag2 = ($row[3]);
            $bookVolume = ($row[4]);
            $bookNumber = ($row[5]);
            $editorFirstName = ($row[6]);
            $editorMiddleName= ($row[7]);
            $editorLastName = ($row[8]);
            $editorSuffix = ($row[9]);
            $publisherName = ($row[10]);
            $publisherLocation = ($row[11]);

          } /*End Book Query for loop*/
        } /*End if resultBookQuery*/

       $compositionQuery = <<<_END
        SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, e.description,v.voicing_type, ens.ensemble_type, c.book_ID 
        FROM compositions AS c
        LEFT JOIN eras AS e ON c.era_ID = e.ID
        LEFT JOIN voicing AS v ON c.voice_ID = v.ID
        LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
        LEFT JOIN books AS b ON c.book_ID = b.ID

        WHERE c.ID = $compositionID;
       
_END;

      $resultCompositionQuery = $conn->query($compositionQuery);
        echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';

         if (!$resultCompositionQuery) die ("Database access failed3 <br/>");
         if ($resultCompositionQuery) {     

        $numberOfRows = $resultCompositionQuery->num_rows;

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);

          /*  var_dump ($row);*/

            $queryCompositionID = ($row[0]);
            $compName = ($row[1]);            
            $opusLike = ($row[2]);
            $compNum = ($row[3]);
            $compNo = ($row[4]);
            $subTitle = ($row[5]);                          
            $movement = ($row[6]);
            $era = ($row[7]);            
            $voice = ($row[8]);
            $ensemble = ($row[9]); 
            $CompbookID = ($row[10]);
            
           
          } /*for loop ending*/
        } /*END result Composition Query*/

 $composerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID AND r_composer.role_name = 'Composer'
        WHERE c.ID = $compositionID;

_END;

        echo 'composerQuery = ' . $composerQuery . '<br/><br/>';
        /*send the query*/
        $resultComposerQuery = $conn->query($composerQuery);

       
        if (!$resultComposerQuery) die ("Database access failed composerQuery");
        if ($resultComposerQuery){
        echo 'Hooray';
          $numberOfRows = $resultComposerQuery->num_rows;

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

            $composerID = ($row[0]);
            $compFirst = ($row[1]);
            $compMiddle = ($row[2]);
            $compLast = ($row[3]);
            $compSuffix = ($row[4]);
            
          } /*for loop ending*/
        } /*END if result composer query*/


    
        $arrangerLastName =  get_post($conn, 'searchComposerLastName');
        $arrangerPeopleID = $_POST['arrangerPeopleID'];
       
        /*create query to select the editor from the database if it comes from either pg 7a or 6*/
        
      $arrangerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_arr ON C2R2P.role_ID = r_arr.ID AND r_arr.role_name = 'Arranger'
        WHERE p.ID = $arrangerPeopleID;

_END;

        echo 'arrangerQuery = ' . $arrangerQuery . '<br/><br/>';
        /*send the query*/
        $resultArrangerQuery = $conn->query($arrangerQuery);

       
        if (!$resultArrangerQuery) die ("Database access failed arrangerQuery");
        if ($resultArrangerQuery){
       
          $numberOfRows = $resultArrangerQuery->num_rows;

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultArrangerQuery->fetch_array(MYSQLI_NUM);

            $arrangerID = ($row[0]);
            $arrFirst = ($row[1]);
            $arrMiddle = ($row[2]);
            $arrLast = ($row[3]);
            $arrSuffix = ($row[4]);

          } /*for loop ending*/

        } /*END if result arranger QUery*/

   /* H- Display Book information and Composition info Using HTML*/  
  echo <<<_END

      <h3>Book Info</h3>
     Book Title: $bookTitle <br/>
     Tag 1: $bookTag1 <br/>
     Tag 2: $bookTag2 <br/>
     Book Volume: $bookVolume <br/>
     Book Number: $bookNumber <br/>
     Book Editor name: $editorFirstName $editoryMiddleName $editorLastName $editorSuffix<br/>
     Book Publisher: $publisherName<br/>
     Publisher Location: $publisherLocation<br/>

      <h3>Compsition Info</h3>
    Composition Name: $compName <br/>
    Opus-Like: $opusLike <br/>
    Opus No.: $compNum <br/>
    Composition No.: $compNo <br/>
    Subtitle: $subTitle <br/>
    Key Signature: $displayKeySigString <br/>
    Movement: $movement <br/>
    Era: $era <br/>
    Genre: $displayGenreString<br/>
    Voice: $voice <br/>
    Ensemble: $ensemble <br/>
    Instrument: $displayInstrumentString <br/>
    General difficulty: $GenDiffName <br/>
    ASP difficulty: $ASPDiffName<br/>
    Composer Name: $compFirst $compMiddle $compLast $compSuffix <br/>
    Arranger Name: $arrFirst $arrMiddle $arrLast $arrSuffix <br/><br/>

  <h2>Is there a Lyricist to add?</h2>
   </div>
   <div class="button-section">
   <br/><p>NO, No Lyricist for this compostion</p>
    <input type='submit' value='No Lyricist-Continue'/>
    <input type='hidden' name="next" value='showPage14'/>
    <input type='hidden' name='bookID' value= $bookID />
    <input type='hidden' name='compositionID' value= $compositionID />
   </div>
  </form>

  <form action='multipageform2.php' method='post'>
   <div class="section">
    
    <br/><p>YES, Enter LAST NAME of Lyricist</p>
    <input type="text" name="searchLyricistLastName" />
   </div>
   <div class="button-section">
    <input type='submit' value='Continue'/>
    <input type='hidden' name="next" value='showPage25'/>
    <input type='hidden' name='bookID' value= $bookID />
    <input type='hidden' name='compositionID' value= $compositionID />
   </div>
  </form>
    
</div>
  

_END;



  }/*END Else if pg 24*/














  /*Page 25 Lyricist Options*/
 
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage25')
  {
   /*Lists lyricists with similar last name*/


 
   $bookID = $_POST['bookID'];
   $compositionID = $_POST['compositionID'];
   
   echo <<<_END
  
   <p>PAGE TWENTYFIVE / Lyricist options</p>
   
   <h3>Choose an Lyricist option below</h3>

   <form action='multipageform2.php' method='post'>
    <div class="section">

_END;


/*In this section we will process Lyricist information being submitted to the data base by the user in the form on pg 26*/
/*If the user entered at least the lastname of the Lyricisst in the form on page26*/
if(isset($_POST['lyricistLastName'])){

/*wash the data coming in from user form pg 23*/
            $lyricistFirstName=  get_post($conn, 'lyricistFirstName');
            $lyricistMiddleName =  get_post($conn, 'lyricistMiddleName');
            $lyricistLastName =  get_post($conn, 'lyricistLastName');
            $lyricistSuffix =  get_post($conn, 'lyricistSuffix');
            

 /*create the insert query to add the users lyricist info into the people table*/ 
  

    $queryPeopleInsert = <<<_END

    INSERT INTO people (firstname, middlename, lastname, suffix)
    VALUES('$lyricistFirstName', '$lyricistMiddleName', '$lyricistLastName', '$lyricistSuffix');

_END;

      echo ("\n queryPeopleInsert = " . $queryPeopleInsert . "\n<br/>");
      /*Send query and place result into this variable*/
      $queryPeopleInsertResult = $conn->query($queryPeopleInsert);

      if (!$queryPeopleInsertResult) echo("\n Error description: " . mysqli_error($conn) . "\n<br/>");

      /*Need the most recent id entered for my people id for later*/
      $peopleID = $conn->insert_id;


    /*Getting the lyricist Role ID so I can use it in the insert query below*/
    $roleQuery = "SELECT ID FROM roles WHERE role_name = 'Lyricist'";
      echo ("\n roleQuery = " . $roleQuery . "\n<br/><br/>");
      
      /*Send the query to the database*/
      $roleQueryResult   = $conn->query($roleQuery);
     
      /*incase result fails*/ 
      if (!$roleQueryResult) die ("Database access failed");

      if ($roleQueryResult) {
      $numberOfRows = $roleQueryResult->num_rows;  /*gets the number of rows in a result*/

      /*build forloop*/
      for ($j = 0 ; $j < $numberOfRows ; ++$j){
         $row = $roleQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/

        /*create variables to hold each index (or column) from the given result row array*/
        
        /*This variable can now be used in other code*/
          $lyricistRoleID = ($row[0]);
          
        } /*for loop ending*/

    } /*End if Rolequery result*/

    /*create insert query to add a row to the C2R2P table to connect this person with this composition as an lyricist*/
    $insertQuery = "INSERT INTO C2R2P (composition_ID, role_ID, people_ID)
      VALUES (  $compositionID,
                $lyricistRoleID,
                $peopleID
                )";

      echo ("\n insertQuery = " . $insertQuery . "\n<br/>");
      /*Send query and place result into this variable*/
      $insertQueryResult = $conn->query($insertQuery);

      if (!$insertQueryResult) echo("Error description: " . mysqli_error($conn));



   $lyricistQuery1 = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_lyr ON C2R2P.role_ID = r_lyr.ID AND r_lyr.role_name = 'Lyricist'
        WHERE p.ID = $peopleID;

_END;

        echo 'lyricistQuery1 = ' . $lyricistQuery1 . '<br/><br/>';
        /*send the query*/
        $resultLyricistQuery1 = $conn->query($lyricistQuery1);

       
        if (!$resultLyricistQuery1) die ("Database access failed lyricistQuery1");
        if ($resultLyricistQuery1){
      echo 'Hooray';
          $numberOfRows = $resultLyricistQuery1->num_rows;

          $lyricistFound = ($numberOfRows  > 0);
          $lyricistNotFound = ($numberOfRows === 0);
          if ($lyricistNotFound) {
           
            echo "<h3>No lyricist by the last name of  " . $lyricistLastName . " was found. <br/><br/> Would you like to add this lyricist information to this composition? <br/><br/>";
          } /*END if lyricist not found*/


          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultLyricistQuery1->fetch_array(MYSQLI_NUM);

            $lyricistID = ($row[0]);
            $lyrFirst = ($row[1]);
            $lyrMiddle = ($row[2]);
            $lyrLast = ($row[3]);
            $lyrSuffix = ($row[4]);
            

echo <<<_END

          <input type="radio" name="lyricistPeopleID" value="$lyricistID"/> Arranger Name: $lyrFirst $lyrMiddle $lyrLast $lyrSuffix<br><br>
_END;

          } /*for loop ending*/
      } /*End if $resultLyricistrQuery*/

}  /*END if isset lyricistLastName*/




/*In this section we will search the data base for the lyricist the user is looking for. They will have submitted the last name of the lyricist they want in the text box on pg 21*/
    if (isset($_POST['searchLyricistLastName'])) {
    
        $lyricistLastName =  get_post($conn, 'searchLyricistLastName');
       
        
        
      $lyricistQuery2 = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_lyr ON C2R2P.role_ID = r_lyr.ID AND r_lyr.role_name = 'Lyricist'
        WHERE p.lastname = '$lyricistLastName';

_END;

       


        echo 'lyricistQuery2 = ' . $lyricistQuery2 . '<br/><br/>';
        /*send the query*/
        $resultLyricistQuery2 = $conn->query($lyricistQuery2);

       
        if (!$resultLyricistQuery2) die ("Database access failed lyricistQuery2");
        if ($resultLyricistQuery2) {
          echo 'Hooray!';
       
          $numberOfRows = $resultLyricistQuer2->num_rows;

          $lyricistFound = ($numberOfRows  > 0);
          $lyricistNotFound = ($numberOfRows === 0);
          if ($lyricistNotFound) {
           
            echo "<h3>No lyricist by the last name of  " . $lyricistLastName . " was found. <br/><br/> Would you like to add this lyricist information to this composition? <br/><br/>";
          } /*END if lyricist not found*/

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultLyricistQuery->fetch_array(MYSQLI_NUM);

            $lyricistID = ($row[0]);
            $lyrFirst = ($row[1]);
            $lyrMiddle = ($row[2]);
            $lyrLast = ($row[3]);
            $lyrSuffix = ($row[4]);


            

echo <<<_END

         <input type="radio" name="lyricistPeopleID" value="$lyricistID"/> Arranger Name: $lyrFirst $lyrMiddle $lyrLast $lyrSuffix<br><br>
_END;

          } /*for loop ending*/

      } /*End ifresult lyricistQuery2*/ 
        
  } /*End if isset post searchLyricistLastName */
      

if($lyricistFound) {

  echo <<<_END

  </div>
   <div class="button-section">
    <input type='submit' value='Choose Lyricist'/>
    <input type='hidden' name="next" value='showPage14'/>
    <input type='hidden' name='bookID' value= $bookID />
    <input type='hidden' name='compositionID' value= $compositionID />
   </div>
  </form><br/>
   <h3>None of these Lyricists Match</h3>

_END;

 } /*END if $lyricistFound*/

 echo <<<_END

 <form action='multipageform2.php' method='post'>
   
  <div class="button-section">
    <input type='submit' value='Add Lyricist Info to this composition'/>
    <input type='hidden' name="next" value='showPage26'/>
    <input type='hidden' name='bookID' value= $bookID />
    <input type='hidden' name='compositionID' value= $compositionID />
   </div>
  </form><br/><br/>

  
</div>

_END;

}/*END Else if pg 25*/










   /*Page 26  Add Lyricist*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage26')
  {
  $bookID = $_POST['bookID'];
  $compositionID = $_POST['compositionID'];  

echo <<<_END
<div class="form-style-10">
<p>PAGE TWENTYSIX</p>
<h2>Add Lyricist Info Below</h2>
  <form action='multipageform2.php' method='post'>
   <div class="section">
    First Name: <input type="text" name="lyricistFirstName"/><br/>
    Middle Name: <input type="text" name="lyricistMiddleName"/><br/>
    Last Name: <input type="text" name="lyricistLastName"/><br/>
    Suffix: <input type="text" name="lyricistSuffix"/><br/>
   </div>
  <div class="button-section">
    <input type='submit' value='Continue'/>
    <input type='hidden' name="next" value='showPage25'/>
    <input type='hidden' name='bookID' value= $bookID />
    <input type='hidden' name='compositionID' value= $compositionID />
   </div>
  </form>
</div>
_END;

  }





   /*Page 27  Edit Arranger*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage27')
  {
 /*From pg22  make form prepopulate*/   

echo <<<_END
<div class="form-style-10">
<p>PAGE TWENTYSEVEN</p>
<h2></h2>
  <form action='multipageform2.php' method='post'>
   <div class="section">
    First Name: <input type="text" name="firstName"/><br/>
    Middle Name: <input type="text" name="middleName"/><br/>
    Last Name: <input type="text" name="lastName"/><br/>
    Suffix: <input type="text" name="suffix"/><br/>
   </div>
  <div class="button-section">
    <input type='submit' value='Continue'/>
    <input type='hidden' name="next" value='showPage22'/>
   </div>
  </form>
</div>
_END;

  }



 /*Page 28  Edit Lyricist*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage28')
  {
 /*From pg25  make form prepopulate*/    

echo <<<_END
<div class="form-style-10">
<p>PAGE TWENTYEIGHT</p>
<h2></h2>
  <form action='multipageform2.php' method='post'>
   <div class="section">
    First Name: <input type="text" name="firstName"/><br/>
    Middle Name: <input type="text" name="middleName"/><br/>
    Last Name: <input type="text" name="lastName"/><br/>
    Suffix: <input type="text" name="suffix"/><br/>
   </div>
  <div class="button-section">
    <input type='submit' value='Continue'/>
    <input type='hidden' name="next" value='showPage25'/>
   </div>
  </form>
</div>
_END;

  }







   /*Page 29  Edit Composer*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage29')
  {
 /*From pg19  make form prepopulate*/    

echo <<<_END
<div class="form-style-10">
<p>PAGE TWENTYNINE</p>
<h2></h2>
  <form action='multipageform2.php' method='post'>
   <div class="section">
    First Name: <input type="text" name="firstName"/><br/>
    Middle Name: <input type="text" name="middleName"/><br/>
    Last Name: <input type="text" name="lastName"/><br/>
    Suffix: <input type="text" name="suffix"/><br/>
   </div>
  <div class="button-section">
    <input type='submit' value='Continue'/>
    <input type='hidden' name="next" value='showPage19'/>
   </div>
  </form>
</div>
_END;

  }






   /*Page 30  Edit Publisher*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage30')
  {
 /*From pg9  make form prepopulate*/    

echo <<<_END
<div class="form-style-10">
<p>PAGE THIRTY</p>
<h2></h2>
  <form action='multipageform2.php' method='post'>
   <div class="section">
    First Name: <input type="text" name="firstName"/><br/>
    Middle Name: <input type="text" name="middleName"/><br/>
    Last Name: <input type="text" name="lastName"/><br/>
    Suffix: <input type="text" name="suffix"/><br/>
   </div>
  <div class="button-section">
    <input type='submit' value='Continue'/>
    <input type='hidden' name="next" value='showPage9'/>
   </div>
  </form>
</div>
_END;

  }





   /*Page 31  Edit Editor*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage31')
  {
 /*From pg7  make form prepopulate*/    

echo <<<_END
<div class="form-style-10">
<p>PAGE THIRTYONE</p>
<h2></h2>
  <form action='multipageform2.php' method='post'>
   <div class="section">
    First Name: <input type="text" name="firstName"/><br/>
    Middle Name: <input type="text" name="middleName"/><br/>
    Last Name: <input type="text" name="lastName"/><br/>
    Suffix: <input type="text" name="suffix"/><br/>
   </div>
  <div class="button-section">
    <input type='submit' value='Continue'/>
    <input type='hidden' name="next" value='showPage7'/>
   </div>
  </form>
</div>
_END;

  }













  /*Page 32  Add Book Info*/
   elseif (isset($_POST['next']) && $_POST['next'] == 'showPage32')
  {
    
/*From page 3*/

echo <<<_END
<div class="form-style-10">
<p>PAGE THIRTYTWO add book info</p>
<h2>Add Book Info Below</h2>
  <form action='multipageform2.php' method='post'>
   <div class="section">
      Book Title: <input type='text' name='bookTitle' value='$bookTitle'/><br/>
      Tag 1: <input type="text" name="tag1" value='$bookTag1'/><br/>
      Tag 2: <input type="text" name="tag2" value='$bookTag2'/><br/>
      Book Volume: <input type="text" name="bookVol" value='$bookVolume'/><br/>
      Book Number: <input type="text" name="bookNum" value='$bookNumber'/><br/><br/>
  </div>
  <div class="button-section">
    <input type='submit' value='Submit and Continue'/>
    <input type='hidden' name="next" value='showPage6'/>
   </div>
  </form>
</div>
_END;

  }
  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }


?>

<script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
      integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
      integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
