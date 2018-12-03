<?php include "../inc/dbinfo.inc";?>
<html>
<title>Cloud Computing News</title>
<?php

/* Connect to MySQL and select the database. */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$database = mysqli_select_db($connection, DB_DATABASE);

/* Ensure that the Employees table exists. */
VerifyArticleTable($connection, DB_DATABASE);

/* If input fields are populated, add a row to the Employees table. */
$article_title = htmlentities($_POST['Title']);
$article_url = htmlentities($_POST['URL']);

if (strlen($article_title) || strlen($article_url)) {
    AddArticle($connection, $article_title, $article_url);
}
?>



</body>
</html>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}


* {
    box-sizing: border-box;
}

form.example input[type=text] {
    padding: 10px;
    font-size: 17px;
    border: 1px solid grey;
    float: left;
    width: 80%;
    background: #f1f1f1;
}

form.example button {
    float: left;
    width: 20%;
    padding: 10px;
    background: black;
    color: white;
    font-size: 17px;
    border: 1px solid grey;
    border-left: none;
    cursor: pointer;

}

form.example button:hover {
    background: #ddd;
}

form.example::after {
    content: "";
    clear: both;
    display: table;
}
.button {
    background-color: #ddd;
    border: none;
    color: black;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 16px;
        width: 100%;
</style>
<body class="w3-light-grey">

<div class="w3-content" style="max-width:1400px">


<header class="w3-container w3-center w3-padding-32">
  <a href="/" style="text-decoration:none"><h1><b>CLOUD COMPUTING NEWS</b></h1></a>
  <p>made by <span class="w3-tag">delf</span></p>
</header>


<div class="w3-row">

<div class="w3-col l8 s12">
  <div class=" w3-margin-top">
    <div class="w3-container">
	    <a href="/form.html" button class="button">Add Article</button></a>
    <hr></div>
  </div>

  <?php
$search_word = htmlentities($_GET['search']);
if(empty(trim($search_word))) {
    $result = mysqli_query($connection, "SELECT * FROM ARTICLES");
} else {
    $result = mysqli_query($connection, "SELECT * FROM ARTICLES WHERE TITLE LIKE '%".$search_word."%'");
}

while ($query_data = mysqli_fetch_row($result)) {
    echo "<div class=\"w3-card-4 w3-margin w3-white\">",
    "<div class=\"w3-container\">",
    "<a href=", $query_data[2], "> <h3><b>", $query_data[1], "</b></h3></a>",
    /* <h5>Title description, <span class="w3-opacity">April 7, 2014</span></h5>  */
    "</div>",
        "</div>";
}
?>

</div>

<div class="w3-col l4">


  <div class="w3-card w3-margin w3-margin-top">
	    <form class="example" action="/">
      <input type="text" placeholder="Search" name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div><hr>



</div>

</div><br>

</div>

<footer class="w3-container w3-dark-grey w3-padding-32 w3-margin-top">
  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
</footer>

</body>
</html>

<?php

/* Add an employee to the table. */
function AddArticle($connection, $title, $url)
{
    $t = mysqli_real_escape_string($connection, $title);
    $u = mysqli_real_escape_string($connection, $url);

    $query = "INSERT INTO `ARTICLES` (`TITLE`, `URL`) VALUES ('$t', '$u');";
    if (!mysqli_query($connection, $query)) {
        echo ("<p>Error adding article data.</p>");
    }

}

/* Check whether the table exists and, if not, create it. */
function VerifyArticleTable($connection, $dbName)
{
    if (!TableExists("ARTICLES", $connection, $dbName)) {
        $query = "CREATE TABLE `ARTICLES` (
         `ID` int(11) NOT NULL AUTO_INCREMENT,
         `TITLE` varchar(150) DEFAULT NULL,
         `URL` varchar(150) DEFAULT NULL,
         PRIMARY KEY (`ID`),
         UNIQUE KEY `ID_UNIQUE` (`ID`)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

        if (!mysqli_query($connection, $query)) {
            echo ("<p>Error creating table.</p>");
        }

    }
}

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName)
{
    $t = mysqli_real_escape_string($connection, $tableName);
    $d = mysqli_real_escape_string($connection, $dbName);

    $checktable = mysqli_query($connection,
        "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

    if (mysqli_num_rows($checktable) > 0) {
        return true;
    }

    return false;
}
?>
