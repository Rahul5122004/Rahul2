<?php
session_start();
// Connect to food_recipes database (for recipes)
$recipesConn = new mysqli("localhost", "root", "", "food_recipes");
if (!isset($_SESSION['namee'])) {
    header("Location: admin.html");
    exit();
}

// Fetch user recipes from userrecipes table
$recipeQuery = "SELECT id, rcname, rcdes, rcing, rcins, ddd FROM userrecipes";
$recipeResult = $recipesConn->query($recipeQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Added Recipes By User's</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: white;
        }
        .delete-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">User Added Recipes</h2>
    <center>
        <table>
            <tr>
                <th>Recipes Name</th>
                <th>Description</th>
                <th>Ingredients</th>
                <th>Instruction</th>
                <th>Video Link</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $recipeResult->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['rcname']; ?></td>
                <td><?php echo $row['rcdes']; ?></td>
                <td><?php echo $row['rcing']; ?></td>
                <td><?php echo $row['rcins']; ?></td>
                <td><?php echo $row['ddd']; ?></td>
                <td>
                    <a href="delete_user_recipe.php?id=<?php echo $row['id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete this recipe?')">
                        <button class="delete-btn">Delete</button>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </center>
</body>
</html>
