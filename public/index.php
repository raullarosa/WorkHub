<?php

    // configuration
    require("../includes/config.php"); 
    
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    
    // email subscription
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render form
        render("workhub_form.php", ["title" => "WorkHub"]);
    }
    
    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // email submitted
        $email = ($_POST["email"]);
        
        // validate submission
        if (empty($email))
        {
            apologize("You must provide a valid e-mail.");
        }
        
        // check if e-mail address syntax is valid
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
        {
            apologize("Invalid email format.");
        }
        
        // if validations pass then do the following
        // query database for subscriber
        $rows = query("INSERT INTO subscribers (id, email, signup_date) VALUES(?, ?, NOW())","id", $email);
        
        // render successful entry form
        render("subscription.php", ["title" => "Successful Subscription", "email" => $email]);
    }
?>
