<?php
require('./config/db_connection.php');

// isset to to check data is been sent
// $_GET is global variable , associative array of the input name
//only if you click submit button code will run
// if (isset($_GET['submit'])){
//     echo $_GET['email'];
//     echo $_GET['title'];
//     echo $_GET['ingredients'];
// }

// $_POSt is global variable , associative array of the input name
// XSS Attacks = Cross-Site Scripting
// use htmlspecialchars() = htmlspecialchars($_POST['email']) to prevent Xss Attacks
// if (isset($_POST['submit'])){
//     echo htmlspecialchars($_POST['email']) ;
//     echo htmlspecialchars($_POST['title']) ;
//     echo htmlspecialchars($_POST['ingredients']);
// }

// title,email,ingredients
$title = $email = $ingredients = '';

// Array for any Errors
$errors = array('email' => '', 'title' => '', 'ingredients' => '');
if (isset($_POST['submit'])) {
    //empty() = to check if value is empty on sever side instead of using required on input field
    // check email
    if (empty($_POST['email'])) {
        $errors['email'] = 'Please enter an email';
    } else {
        // echo htmlspecialchars($_POST['email']);
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // if not an email
            // filter_variable(value,built in filter email)
            // FILTER_VALIDATE_EMAIL checks if email is an email
            $errors['email'] = 'email must be a vaild email address';
        }
    }
    // check title
    if (empty($_POST['title'])) {
        $errors['title'] = 'Please enter a title';
    } else {
        // echo htmlspecialchars($_POST['title']);
        $title = $_POST['title'];
        $patten = '/^[a-zA-Z\s]+$/';
        // using regular expression
        if (!preg_match($patten, $title)) {
            $errors['title'] = 'Title msut be letters and spaces only';
        }
    }

    // check ingredients
    if (empty($_POST['ingredients'])) {
        $errors['ingredients'] = 'Give at least 1 ingredient';
    } else {
        // echo htmlspecialchars($_POST['ingredients']);
        $ingredients = $_POST['ingredients'];
        $patten = '/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/';
        // using regular expression
        if (!preg_match($patten, $ingredients)) {
            $errors['ingredients'] = 'Ingredients must be a comma sperated list';
        }
    }

    // check form for errors
    if (array_filter($errors)) {
    } else {
        // protecting db form mysql injection
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

        // creating query in add data
        $sql = "INSERT INTO pizzas(title,ingredients,email) VALUES ('$title','$ingredients','$email')";

        // check sql and data
        if (mysqli_query($conn, $sql)) {
            // success
            // Redirect using header
            header('Location: index.php');
        } else {
            // err
            echo 'query error' . mysqli_error($conn);
        }

        // Redirect using header
        // header('Location: order.php');
        // echo 'form is valid';
    }
} // end of POST checking


?>

<!-- Header -->
<?php require('./templates/header.php') ?>

<!-- Form -->
<section class="add_form">
    <center>
        <h3>Add a Pizza</h3>
    </center>
    <div class="container">
        <form action="add_form.php" method="POST">
            <div>
                <label for="name">Your Email:</label>
                <br>
                <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">

                <div style="color:red">
                    <?php echo $errors['email']; ?>
                </div>
                <br>
            </div>

            <div>
                <label for="name">Pizza Title:</label>
                <br>
                <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">

                <div style="color:red">
                    <?php echo $errors['title']; ?>
                </div>
                <br>
            </div>

            <div>
                <label for="name">Ingredients:</label>
                <br>
                <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients); ?>">

                <div style="color:red">
                    <?php echo $errors['ingredients']; ?>
                </div>
                <br>
            </div>

            <center>
                <button type="submit" name="submit" id="submit_btn">Submit</button>
            </center>
        </form>
    </div>
</section>

</section>
<!-- Footer -->
<?php require('./templates/footer.php') ?>