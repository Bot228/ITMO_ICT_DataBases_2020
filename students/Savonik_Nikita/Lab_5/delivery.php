<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Lab 5</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
$output = false;
$dbuser = 'postgres';
$dbpass = '1';
$host = 'localhost';
$dbname = 'Newspaper';

if (isset($_POST['delete'])){
	$id = $_POST['delete'];
	delete_($id);
}


if (isset($_GET['search'])){
	$delivery_number = $_GET['search'];
	$output = true;
}

if (isset($_POST['delivery_number'])){
	$post_office_number = $_POST['post_office_number'];
	$delivery_number = $_POST['delivery_number'];
	$edition_number = $_POST['edition_number'];
	$newspaper_name = $_POST['newspaper_name'];
	$amount = $_POST['amount'];
	put_($post_office_number, $delivery_number, $edition_number, $newspaper_name, $amount);
}



?>



<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Newspaper</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="query.php"><b>QUERY</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="edition.php">Edition</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="post_office.php">Post office</a>
      </li>
	  <li class="nav-item active">
        <a class="nav-link" href="delivery.php"><span class="sr-only">(current)</span>Delivery</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="printing_office.php">Printing office</a>
      </li>
    </ul>
  </div>
</nav>
<br>
<br>
<br>
<br>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <h3 align='center'>????????????????????</h3>
	  <br>
	  <form method='post' action='delivery.php'>
	  <table border='1px' cellspacing='2' cellpadding='10' width='100%'>
	  <tr>
			<th>post office number</th>
			<th>delivery number</th>
			<th>edition number</th>
			<th>newspaper_name</th>
			<th>amount</th>
			<th><p align='center'>????????????????</p></th>
		</tr>
	  <tr>
			<td><input required type='text' name='post_office_number' value=''></td>
			<td><input required type='text' name='delivery_number' value=''></td>
			<td><input required type='text' name='edition_number' value=''></td>
			<td><input required type='text' name='newspaper_name' value=''></td>
			<td><input required type='text' name='amount' value=''></td>
			<td><input required type='submit' name='button' value='????????????????'></td>
	  </tr>
	  </table>
	  </form>
    </div>
  </div>
</div>
<br>
<hr>
<br>
<div class="container">
  <div class="row">
    <div class="col-sm">
	  <h3 align='center'>??????????</h3>
	  <br>
	    
		<?php
		if ($output)
		{
			$query = "SELECT post_office_number, delivery_number, edition_number, newspaper_name, amount FROM delivery WHERE delivery_number='$delivery_number'";
			$rows = fetch_data($query);
				echo "<table border='1px' cellspacing='2' cellpadding='10' width='100%'>";
				echo 
				"
				<tr>
					<th>post_office_number</th>
					<th>delivery_number</th>
					<th>edition_number</th>
					<th>newspaper_name</th>
					<th>amount</th>
					<th><p align='center'>??????????????</p></th>
				</tr>
		
				";
				foreach($rows as $row)
				{	
					$id = $row['delivery_number'];
					echo "<tr>";
					echo "<form method='post' action='delivery.php'>";
					foreach($row as $name)
					{
						echo "<td>";
						echo $name . " ";
						echo "</td>";
				
					}
					echo"<td>";
					echo"<input type='hidden' name='delete' value=$id>";
					echo"<input type='submit' name='button' value='??????????????'>";
					echo"</td>";
					echo"</tr>";
					echo "</form>";
				}
				echo "</table>";
		}
		
		?>
		
	  
    </div>
	<div class="col-sm">
	  <h3 align='center'>??????????</h3>
	  <br>
	    <form method='get' action='delivery.php' align="center">
		
		<p><b>Delivery number:</b> <input type='text' name='search' value=''> <input type='submit' name='button' value='??????????'></p>
		
		</form>
    </div>
  </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<hr>
<footer>Evgenii Gutin - 2020(C)</footer>


 
</body>
</html>


<?php

function put_($post_office_number, $delivery_number, $edition_number, $newspaper_name, $amount)
{
	global $dbuser, $dbpass, $host, $dbname;
	$pdo = new PDO("pgsql:host=$host;dbname=$dbname", $dbuser, $dbpass);
	$query = "INSERT INTO delivery (post_office_number, delivery_number, edition_number, newspaper_name, amount)
			  VALUES (:post_office_number, :delivery_number, :edition_number, :newspaper_name, :amount)";
	$params = [
    ':newspaper_name' => $newspaper_name,
	':edition_number' => $edition_number,
	':delivery_number' => $delivery_number,
	':post_office_number' => $post_office_number,
	':amount' => $amount
	];
	$stmt = $pdo->prepare($query);
	$stmt->execute($params);
	
}

function delete_($id)
{
	global $dbuser, $dbpass, $host, $dbname;
	$pdo = new PDO("pgsql:host=$host;dbname=$dbname", $dbuser, $dbpass);
	$query = "DELETE FROM delivery WHERE delivery_number = ?";
	$params = [$id];
	$stmt = $pdo->prepare($query);
	$stmt->execute($params);
}

function fetch_data($query)
{
	
		global $dbuser, $dbpass, $host, $dbname;
		$pdo = new PDO("pgsql:host=$host;dbname=$dbname", $dbuser, $dbpass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$data = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	
	
	
}
?>
