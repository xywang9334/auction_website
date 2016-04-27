<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 9/28/15
 * Time: 12:06 AM
 */
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <title>pay for your items</title>
    <link rel="stylesheet" href="stylesheet/style.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="stylesheet/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine"/>
</head>
<body>
<header>
    <div class="head_only">
        <div>
            <h1 class="TangerineFont">Payment page</h1>
        </div>
    </div>
</header>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="manage.php">Manage your list</a></li>
        <li><a href="settings.php">Buy it</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="seller.php">Sell Here</a></li>
    </ul>
</nav>
<hr>
<ul class="breadcrumb">
    <li><a href="index.php">Shopping Main Page</a></li>
    <li><a href="settings.php">Find the best one</a></li>
    <li><a href="book.php">Details</a></li>
    <li><a href="complete.php">Complete your order</a></li>
    <li><a href="payment.php">Payment method</a></li>
</ul>
<section id="middle">
    <header>
        <h2>Payment</h2>
    </header>
    <form method="post" action="thankyou.php" enctype="multipart/form-data">
        <div class="big-box">
            <fieldset>
                Select payment method<br>
                <div class="radio-left">
                    <input type="radio" name="card"> Visa
                </div>
                <div class="radio-right">
                    <input type="radio" name="card"> Master Card
                </div>
                <br><br>
                <?php
                $error = $_SESSION['error_message'];
                if (!empty($error)) {
                    echo $error;
                }
                ?>
                <input class="big-input" type="number" name="cardNumber" placeholder="card number" required>
                <br>
                <br>
                <div>
                    Expiration Date
                    <select name="Month" required="required" class="btn btn-mini">
                        <option value="">mm</option>
                        <option value="01">1</option>
                        <option value="02">2</option>
                        <option value="03">3</option>
                        <option value="04">4</option>
                        <option value="05">5</option>
                        <option value="06">6</option>
                        <option value="07">7</option>
                        <option value="08">8</option>
                        <option value="09">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <select name="Year" required="required" class="btn btn-mini">
                        <option value="">yy</option>
                        <option value="01">11</option>
                        <option value="02">12</option>
                        <option value="03">13</option>
                        <option value="04">14</option>
                        <option value="05">15</option>
                        <option value="06">16</option>
                        <option value="07">17</option>
                        <option value="08">18</option>
                        <option value="09">19</option>
                        <option value="10">20</option>
                        <option value="11">21</option>
                        <option value="12">22</option>
                    </select>
                    <input name="cvv" placeholder="cvv" type="number" class="radio-right" required>
                </div>
                <br>
                <br>
                <?PHP $price = $_POST['price'];?>
                <?PHP echo"<p>Price: {$price}</p>";?>
                <br>
                <br>
                <input class="big-input" name="delieverAddress" placeholder="deliever address" required>
                <br>
                <br>
            </fieldset>
            <input type="submit" name="Complete" value="Complete">
        </div>
        <br>
    </form>
    <br><br><br><br><br><br><br><br><br><br>
    <hr>
    <footer>
        <div class="foot">Not ready? You are always welcome to contact us
            <br>
            Copyright someone
        </div>
    </footer>
</section>
</body>
</html>

