<?php
session_start();
include('connection.php');

$select = '';
$option = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $option = $_POST['DB'];
    $select = $_POST['select'];
    $server = $_SESSION['server'];
    $user = $_SESSION['user'];
    $password = $_SESSION['password'];
    $connection = new Connection($server, $user, $password);

    if (isset($_POST['selectbutton'])) {
        // Inside your existing code
        $_SESSION['selected_table'] = $_POST['select'];
        $_SESSION['selected_db'] = $_POST['DB'];
        $connection->selectTable($_POST['select'], $_POST['DB']);
        header('location: selectTABLE.php');
        exit();
    } elseif (isset($_POST['delete'])) {
        $result = $connection->deleteDB($_POST['DB']);
        if (!$result) {
            echo '<script>alert("Error deleting DB: ' . $connection->getLastError() . '")</script>';
        }
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
            background-color: #292929;
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: #ebebeb;
        }

        /* Header and Footer Styles */
        header, footer {
            background-color: #292929;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h4 {
            margin: 0;
        }

        .link {
            color: #ebebeb;
            text-decoration: none;
            margin-left: 20px;
        }

        .link:hover {
            text-decoration: underline;
        }

        /* Main Search Input Styles */
        .main-search-input-wrap {
            max-width: 500px;
            margin: 20px auto;
            position: relative;
            padding: 0 20px;
        }

        .database-list {
            background: #f5f5f5;
            border: 2px solid #c3c6ce;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 20px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .database-list h3 {
            color: #008bf8;
            margin-bottom: 10px;
        }

        .database-list select {
            border: 1px solid #ccc;
            border-radius: 4px;
            height: 30px;
            padding: 5px;
            margin-right: 10px;
        }

        /* Main Search Input Styles Continued */
        .main-search-input {
            background: #fff;
            border-radius: 1px;
            margin-top: 20px;
            box-shadow: 0px 0px 0px 6px rgba(255, 255, 255, 0.3);
            display: flex;
            position: relative;
        }

        .main-search-input-item {
            flex: 1;
            box-sizing: border-box;
            border-right: 1px solid #eee;
            height: 50px;
            position: relative;
        }

        .main-search-input-item input {
            border: none;
            width: calc(100% - 20px);
            height: 50px;
            padding-left: 20px;
            border-radius: 0;
        }

        .main-search-button {
            background: #4DB7FE;
            color: #fff;
            border: none;
            height: 50px;
            width: 120px;
            cursor: pointer;
            position: absolute;
            right: 0;
            top: 0;
            border-top-right-radius: 1px;
            border-bottom-right-radius: 1px;
        }

        /* Responsive Styles */
        @media only screen and (max-width: 768px) {
            .main-search-input {
                background: rgba(255, 255, 255, 0.2);
                padding: 14px 20px 10px;
                border-radius: 10px;
                box-shadow: 0px 0px 0px 10px rgba(255, 255, 255, 0.0);
                flex-direction: column;
            }

            .main-search-input-item {
                width: 100%;
                border: 1px solid #eee;
                height: 50px;
                border: none;
                margin-bottom: 10px;
            }

            .main-search-input-item input {
                border-radius: 6px !important;
                background: #fff;
            }

            .main-search-button {
                position: relative;
                float: left;
                width: 100%;
                border-radius: 6px;
                margin-top: 10px;
                position: static;
            }
        }

        /* Button Styles */
        .delete {
            background-color: #000;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 0;
            margin-left: 10px;
        }
    </style>
    <title>DB</title>
</head>
<body>
    <header>
        <h4>YOUR DATA</h4>
        <nav>
            <a href="create.php" class="link">CREATEDB</a>
            <a href="table.php" class="link">CREATETABLE</a>
        </nav>
    </header>
    
    <br><br><br><br><br><br><br>
    <form method="post" class="main-search-input-wrap">
        <div class="database-list">
            <?php
                $server = $_SESSION['server'];
                $user = $_SESSION['user'];
                $password = $_SESSION['password'];
                $connection = new Connection($server, $user, $password);

                $db = $connection->listDatabases();

                if ($db) {
                    echo "<select name='DB'>";
                    while ($row = $db->fetch_assoc()) {
                        $selected = ($row['Database'] == $option) ? 'selected' : '';
                        echo "<option value='" . $row['Database'] . "' $selected>" . $row['Database'] . "</option>";
                    }
                    echo "</select>";
                } else {
                    echo '<script>alert("Error lesting DB: ' . $connection->getLastError() . '")</script>';
                }                            
            ?>
            <button class="delete" name='delete'>Delete</button>
        </div>
        <div class="main-search-input fl-wrap">
            <div class="main-search-input-item">
                <input type="text" id="select" name="select" value="" placeholder="Select your table">
            </div>
            <button class="main-search-button" name="selectbutton">Select</button>
        </div>
    </form>
    <footer>
        <p>If you want <a href="#" target="_blank">contact</a> me.</p>
    </footer>
</body>
</html>
