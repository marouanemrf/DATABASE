<?php
session_start();
include('connection.php');

if (isset($_SESSION['selected_table']) && isset($_SESSION['selected_db'])) {
    $selectedTable = $_SESSION['selected_table'];
    $selectedDB = $_SESSION['selected_db'];

    $server = $_SESSION['server'];
    $user = $_SESSION['user'];
    $password = $_SESSION['password'];
    $connection = new Connection($server, $user, $password);
} else {
    echo "No table selected.";
    exit; // Exit the script if no table is selected
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['update'])){
    header('update.php');
    exit();
    }
} 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="DB.css">
    <style>
         body {
            /* Add background color or any other body styles if needed */
            background-color: #292929;
            font-family: "Arial", sans-serif; /* Add a preferred font family */
        }

        header {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #292929; /* Add a background color for the header */
            padding: 10px;
        }

        h4 {
            color: #ebebeb; /* Set text color to white */
            margin-right: auto;
        }

        .link {
            color: #ebebeb; /* Set link color to white */
            text-decoration: none;
            margin-left: 20px; /* Add margin for spacing between links */
        }

        .link:hover {
            text-decoration: underline; /* Add underline on hover */
        }

        footer {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #292929; /* Add a background color for the footer */
            padding: 10px;
        }

        .replay {
            color: #ebebeb; /* Set text color to white */
            cursor: pointer;
            margin-right: 5px;
        }

        p {
            color: #ebebeb; /* Set text color to white */
            margin-left: 5px; /* Add margin for spacing */
        }

        a {
            color: #ebebeb; /* Set link color to white */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline; /* Add underline on hover */
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
.btn-57,
.btn-57 *,
.btn-57 :after,
.btn-57 :before,
.btn-57:after,
.btn-57:before {
  border: 0 solid;
  box-sizing: border-box;
}

.btn-57 {
  -webkit-tap-highlight-color: transparent;
  -webkit-appearance: button;
  background-color: #000;
  background-image: none;
  color: #fff;
  cursor: pointer;
  font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
    Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif,
    Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
  font-size: 100%;
  line-height: 1.5;
  margin: 0cm;
  -webkit-mask-image: -webkit-radial-gradient(#000, #fff);
  padding: 0;
}

.btn-57:disabled {
  cursor: default;
}

.btn-57:-moz-focusring {
  outline: auto;
}

.btn-57 svg {
  display: block;
  vertical-align: middle;
}

.btn-57 [hidden] {
  display: none;
}

.btn-57 {
  background: none;
  border: 3px solid;
  border-radius: 999px;
  box-sizing: border-box;
  color: #000;
  display: block;
  font-weight: 900;
  -webkit-mask-image: none;
  padding: 20px 50px;
  position: relative;
  text-transform: uppercase;
 
}

.btn-57:before {
  background: #fff;
  border-radius: 999px;
  content: "";
  inset: 0;
  position: absolute;
  transform: translate(10px, 10px);
  transition: transform 0.2s;
  z-index: -1;
}

.btn-57:hover:before {
  transform: translate(0);
}

.btn-58,
.btn-58 *,
.btn-58 :after,
.btn-58 :before,
.btn-58:after,
.btn-58:before {
  border: 0 solid;
  box-sizing: border-box;
}

.btn-58 {
  -webkit-tap-highlight-color: transparent;
  -webkit-appearance: button;
  background-color: #000;
  background-image: none;
  color: #fff;
  cursor: pointer;
  font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
    Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif,
    Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
  font-size: 100%;
  line-height: 1.5;
  margin: 0;
  -webkit-mask-image: -webkit-radial-gradient(#000, #fff);
  padding: 0;
}

.btn-58:disabled {
  cursor: default;
}

.btn-58:-moz-focusring {
  outline: auto;
}

.btn-58 svg {
  display: block;
  vertical-align: middle;
}

.btn-58 [hidden] {
  display: none;
}

.btn-58 {
  background: none;
  border: 3px solid;
  border-radius: 999px;
  box-sizing: border-box;
  color: #000;
  display: block;
  font-weight: 900;
  -webkit-mask-image: none;
  padding: 20px 50px;
  position: relative;
  text-transform: uppercase;
}

.btn-58:before {
  background: #fff;
  border-radius: 999px;
  content: "";
  inset: 0;
  position: absolute;
  transform: translate(10px, 10px);
  transition: transform 0.2s;
  z-index: -1;
}

.btn-58:hover:before {
  transform: translate(0);
}
.btn-container {
    display: flex;
    justify-content: space-between;
    margin-top: 4.5cm; 
}

    </style>
    <title>Selected Table</title>
</head>
<body>
<header>
        <h4>YOUR DATA</h4>
        <a href="create.php" class="link">CREATEDB</a>
        <a href="DB.php" class="link">DATABASE</a>
</header>
<br>
<br>
<br>
<br>
<br>
    <h2 >Selected Table: <?php echo $selectedTable; ?> (Database: <?php echo $selectedDB; ?>)</h2>
    <br>
    <br>
    <form method="post" action="">
    <?php
    // Retrieve column names dynamically
    $columnsResult = $connection->selectTable($selectedTable, $selectedDB);

    if ($columnsResult) {
        echo "<table><thead><tr>";
        $numColumns = $columnsResult->field_count;
        for ($i = 0; $i < $numColumns; $i++) {
            $columnInfo = $columnsResult->fetch_field();
            echo "<th>" . $columnInfo->name . "</th>";
        }
        echo "</tr></thead><tbody>";

        // Retrieve and display data
        $dataResult = $connection->selectTable($selectedTable, $selectedDB);
        if ($dataResult) {
            while ($row = $dataResult->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . $value . "</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "Error retrieving data.";
        }

        echo "</tbody></table>";
    } else {
        echo "Error retrieving column names.";
    }
    ?>
    
    <div class="btn-container">
        <button type="submit" class="btn-57" name="delete">delete</button>
        <button type="submit" class="btn-58" name="update">update</button>
    </div>
    </form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {

    $result = $connection->deletetable($selectedTable);
     
    if (!$result) {
        echo '<script>alert("error delete table: ' . $connection->getLastError() . '")</script>';
    } else {
        echo '<script>alert("delete valide")</script>';
        header('Location: DB.php');
        exit();
    }

}
?>

    <footer>
        <p>if you want <a href="" target="_blank">contact</a> me.</p>
    </footer>    
</body>
</html>
