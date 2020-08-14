<?php
include 'boilerplate.php';

// following is example code for dumping a source database to a file
// then changing the names in the source dump to the target database
// then running the dump file to create or overwrite the target database

// these variables are defined in login.php -  $hn, $un, $pw

// DANGER DANGER - WASH THESE VARIABLES

$sourceDBname = $_POST['sourceDBname']; // hardcoding to test $_POST['sourceDBname']
$targetDBname = $_POST['targetDBname']; // hardcoding to test $_POST['targetDBname']

if($debug) {
    echo 'sourceDBname = ' . $sourceDBname . '<br/>';
    echo 'targetDBname = ' . $targetDBname . '<br/>';
} /*end debug*/

if (isset($_REQUEST['sourceDBname'])) {

    $backup_path = "../backups/"; // folder where we store backups
    $date_string = date("Y-m-d-H-i-s");
    $filePath = "{$backup_path}{$date_string}_{$sourceDBname}.sql";

    echo 'filepath = ' . $filePath . '<br/>';

    $cmd = "mysqldump -h {$hn} -u {$un} -p {$pw} -B {$sourceDBname} -f --skip-lock-tables > {$filePath}";

    echo 'dump command = ' . $cmd . '<br/>';

    exec($cmd);  // using command line to run the command

// read dump as string
    $dump = file_get_contents($filePath);

// replace db name used in CREATE and USE statements
    $dump = str_replace($sourceDBname, $targetDBname, $dump);

// write modified dump back to file
    file_put_contents($filePath, $dump);

    $cmd = "mysql -h {$hn} -u {$un} -p{$pw} {$sourceDBname} < {$filePath}";
    exec($cmd);  // using command line to run the command

}



if($debug) {
    echo <<<_END

 <p>admin.php-48</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

?>

    <main>
        <div class="container-fluid bg-light pt-4 pb-4">
            <div class="row">
                <div class="col-sm-10 offset-sm-1 text-center">
                    <img class="img-responsive" src="images/crudelogo3.png"/>
                    <h1 class="display-3 pb-4">Admin</h1>
                </div><!--end col 1-->
                <?php
                if(isset($_GET['error'])) {
                    if($_GET['error'] == "emptyfields") {
                        echo "<p class='error'>Fill in all fields!</p>";
                    }else if ($_GET['error'] == "invaliduidmail"){
                        echo "<p class='error'>Invalid username and email!</p>";
                    }else if ($_GET['error'] == "invaliduid"){
                        echo "<p class='error'>Invalid username!</p>";
                    }else if ($_GET['error'] == "invalidmail"){
                        echo "<p class='error'>Invalid e-mail!</p>";
                    }else if ($_GET['error'] == "passwordcheck"){
                        echo "<p class='error'>Your passwords do not match!</p>";
                    }else if ($_GET['error'] == "usertaken"){
                        echo "<p class='error'>Username is already taken!</p>";
                    }
                }else if($_GET['admin'] == "success") {
                    echo "<p class='signupsuccess'>Signup successful!</p>";
                }
                ?>
                <div class="col-sm-6 offset-sm-3 ">
                    <div class="info-form "></div>

                    <form class="justify-content-center" action="admin.php" method="post">
                        <div class="form-group">
                            <h3>Create New Catalogit Database</h3>
                            <label for="sourceDBname">Source Database Name:</label>
                            <input class="form-control" type="text" name="sourceDBname" id="sourceDBname" value="<?echo $_GET['sourceDBname']?>"><br/>

                            <label for="targetDBname">Target Database Name:</label>
                            <input class="form-control" type="text" name="targetDBname" id="targetDBname"value="<?echo $_GET['targetDBname']?>"><br/>

                            <button class="btn btn-secondary-outline btn-sm mb-4" role="button" type="submit" name="admin-submit">Create New Database</button><br>
                    </form>
                </div><!--end info-form-->
            </div><!--end col-->

            <div class="col-sm-6 offset-sm-3 ">
                <div class="info-form"></div>
                <form class="justify-content-center" action="admin_func.php" method="post">
                    <div class="form-group">
                        <h3>Add Login Information to a database</h3>

                        <select  class="form-control" id="existdb" name="existdb">
                            <option value="1" {$_SESSION['postGenDiffID34_value']}>catalogit</option>
                            <option value="2" {$_SESSION['postGenDiffID1_value']}>catalogit-b</option>
                            <option value="3" {$_SESSION['postGenDiffID2_value']}>catalogit-c</option>
                        </select><br/>

                        <label for="uid">Username</label>
                        <input class="form-control" type="text" name="uid" value="<?echo $_GET['uid']?>"><br/>

                        <label for="mail">E-mail Address</label>
                        <input class="form-control" type="text" name="mail" value="<?echo $_GET['mail']?>"><br/>

                        <label for="pwd">Password</label>
                        <input class="form-control" type="password" name="pwd"><br/>

                        <label for="pwd-repeat">Repeat Password</label>
                        <input class="form-control" type="password" name="pwd-repeat"><br/>

                        <button class="btn btn-secondary-outline btn-sm mb-4" role="button" type="submit" name="admin-submit">Add Login Info</button><br>
                    </div> <!--end form-group-->
                </form>
            </div><!--end info-form-->
        </div><!--end col-->


        <div class="col-sm-6 offset-sm-3 ">
            <div class="info-form"></div>
            <form class="justify-content-center" action="admin_func.php" method="post">
                <div class="form-group">
                    <h3>Refresh Database:</h3>
                    <span style="color:red;">WARNING!</span>
                    <span>  Refreshing the database will erase all but the default data.</span><br/>
                    <span >ALL BUT DEFAULT DATA WILL BE LOST.</span><br/><br/>
                    <label for="refreshdb">Choose one or more</label>
                    <select  class="form-control" id="refreshdb" name="refreshdb">
                        <option value="1" {$_SESSION['postGenDiffID34_value']}>catalogit</option>
                        <option value="2" {$_SESSION['postGenDiffID1_value']}>catalogit-b</option>
                        <option value="3" {$_SESSION['postGenDiffID2_value']}>catalogit-c</option>
                    </select><br/>
                    <button class="btn btn-secondary-outline btn-sm mb-4" role="button" type="submit">Refresh Database</button><br>
                </div> <!--end form-group-->
            </form>
        </div><!--end info-form-->
        </div><!--end col-->


        <div class="col-sm-6 offset-sm-3 ">
            <div class="info-form"></div>
            <form class="justify-content-center" action="admin_func.php" method="post">
                <div class="form-group">
                    <h3>Delete Database:</h3>
                    <span style="color:red; ">WARNING!</span><br/>
                    <span>Deleting the database will erase it permanently.</span><br/>
                    <span >DATA BASE AND ALL DATA WILL BE LOST.</span><br/><br/>
                    <label for="deletedb">Choose one or more</label>
                    <select  class="form-control" id="deletedb" name="deletedb">
                        <option value="1" {$_SESSION['postGenDiffID34_value']}>catalogit</option>
                        <option value="2" {$_SESSION['postGenDiffID1_value']}>catalogit-b</option>
                        <option value="3" {$_SESSION['postGenDiffID2_value']}>catalogit-c</option>
                    </select><br/>
                    <button class="btn btn-secondary-outline btn-sm mb-4" role="button" type="submit">Delete Database</button><br>
                </div> <!--end form-group-->
            </form>
        </div><!--end info-form-->
        </div><!--end col-->


        </div><!--end row-->
        </div> <!--end container-->

    </main>



<?php
//-TODO add code to create / over-write new db from old db using submitted db names

/*
 * pseudo code for creating db
 *
 * get source db name from form
 *
 * use source db name and mysql dump library to dump source db into variable DUMP (sting)
 *
 * get target db name from form
 *
 * look for source db name in DUMP and replace it with target db name (string operation - str_replace)
 *
 * run the modified DUMP string as sql command to create new database
 *
 *
 *
 * */
?>



<?php
//-TODO make sure to add a warning when someone clicks on delete database. 'ARE YOU SURE YOU WANT TO DELETE' .  $databaseName . '?'


include 'footer.html';
include 'endingBoilerplate.php';



?>