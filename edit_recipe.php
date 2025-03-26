<?php
session_start();
include 'db.php';

if (!isset($_SESSION['namee'])) {
    header("Location: admin.html");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM recipes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_assoc();

    if (!$recipe) {
        echo "<script>alert('Recipe not found!'); window.location.href='adminrecipes.php';</script>";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $image = $_POST['image'];
        $ingredients = $_POST['ingredients'];
        $instructions = $_POST['instructions'];
        $video_url = $_POST['video_url'];
        $suggestions = $_POST['suggestions'];

        $updateSQL = "UPDATE recipes SET name=?, image=?, ingredients=?, instructions=?, video_url=?, suggestions=? WHERE id=?";
        $stmt = $conn->prepare($updateSQL);
        $stmt->bind_param("ssssssi", $name, $image, $ingredients, $instructions, $video_url, $suggestions, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Recipe updated successfully!'); window.location.href='adminrecipes.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='adminrecipes.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
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
        .update-btn {
            background-color: green;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .update-btn:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Edit Recipe</h2>
    <center>
        <form method="POST">
            <table>
                <tr>
                    <th>Recipes Name</th>
                    <th>Image Path</th>
                    <th>Ingredients</th>
                    <th>Instructions</th>
                    <th>Recipe Video URL</th>
                    <th>Suggestions</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td><input type="text" name="name" value="<?php echo htmlspecialchars($recipe['name']); ?>" required></td>
                    <td><input type="text" name="image" value="<?php echo htmlspecialchars($recipe['image']); ?>" required></td>
                    <td><textarea name="ingredients" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea></td>
                    <td><textarea name="instructions" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea></td>
                    <td><textarea name="video_url" required><?php echo htmlspecialchars($recipe['video_url']); ?></textarea></td>
                    <td><textarea name="suggestions"><?php echo htmlspecialchars($recipe['suggestions']); ?></textarea></td>
                    <td>
                        <button type="submit" class="update-btn">Update Recipe</button>
                    </td>
                </tr>
            </table>
        </form>
    </center>
</body>
</html>
