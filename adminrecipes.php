<?php
session_start();
// Connect to food_recipes database (for recipes)
$recipesConn = new mysqli("localhost", "root", "", "food_recipes");

// Connect to sign database (for signup details)
$usersConn = new mysqli("localhost", "root", "", "sign");

// Check if admin is logged in
if (!isset($_SESSION['namee'])) {
    header("Location: admin.html");
    exit();
}

// Fetch user details from sign.signup table
$userQuery = "SELECT user, email FROM signup";
$userResult = $usersConn->query($userQuery);

// Fetch all recipes from food_recipes.recipes table
$recipeQuery = "SELECT id, name FROM recipes ORDER BY id ASC";
$recipeResult = $recipesConn->query($recipeQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <h3 class="navbar-brand">Admin Dashboard</h3>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="home.html">Home</a>
                </li>
                <li class="nav-item active">
                <a class="nav-link">             </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="menu.html">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Admin Only Access</h1>

        <!-- User Management -->
        <div class="card mt-4">
            <div class="card-header">
                User's Details
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $userResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['user']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <a href="delete_user.php?email=<?php echo urlencode($row['email']); ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <a href="added.php" class="btn btn-primary">View Recipes Added by Users</a>
            </div>
        </div>

        <!-- Recipe Management -->
        <div class="card mt-4">
            <div class="card-header">
                Manage Recipes
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $recipeResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td>
                                <a href="edit_recipe.php?id=<?php echo $row['id']; ?>" class="edit-btn">View/Edit</a>
                                <a href="delete_recipe.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
