<?php

 require_once "conn.php";

$name=$email=$website=$comment=$gender="";
$nameerr=$emailerr=$websiteerr=$commenterr=$gendererr="";

if($_SERVER["REQUEST_METHOD"] == "POST")
//if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["website"]) && isset($_POST["comment"]) && isset($_POST["gender"]))
{
    $input_name=trim($_POST["fname"]);
    if(empty($input_name))
    {
        $nameerr="please enter a name";
    }
    else if(!preg_match("/^[a-zA-Z\s]+$/",$input_name))
    {
        $nameerr="please enter a valid name";

    }
    else
    {
        $name=$input_name;
    }

    $input_email=trim($_POST["email"]);
    if(empty($input_email))
    {
        $emailerr="please enter an email";
    }
    elseif(!filter_var($input_email,FILTER_VALIDATE_EMAIL))
    {
        $emailerr="please enter a valid email address";
    }
    else
    {
        $email=$input_email;
    }

    $input_website=trim($_POST["website"]);
    if(empty($input_website))
    {
        $websiteerr="please enter a website";
    }
    elseif(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$input_website))
    {
        $websiteerr="please enter a valid email address";
    }
    else
    {
        $website=$input_website;
    }

    $input_comment=trim($_POST["comment"]);
    if(empty($input_comment))
    {
        $commenterr="";
    }
    else
    {
        $comment=$input_comment;
    }

    $input_gender=trim($_POST["gender"]);
    if(empty($input_gender))
    {
        $gendererr="please select a gender";
    }
    else
    {
        $gender=$input_gender;
        if($gender=="male")
        {
            $mchecked="checked";
        }
        else if($gender=="female")
        {
            $fchecked="checked";
        }
    }


    if(empty($nameerr) && empty($emailerr) && empty($websiteerr) && empty($commenterr)&& empty($gendererr))
    {

        $sql="INSERT INTO demo(fname,email,website,comment,gender) VALUES(?,?,?,?,?)" ;
        if($stmt=mysqli_prepare($conn,$sql))
        {
            mysqli_stmt_bind_param($stmt,"sssss",$param_name,$param_email,$param_website,$param_comment,$param_gender);

            $param_name=$name;
            $param_email=$email;
            $param_website=$website;
            $param_comment=$comment;
            $param_gender=$gender;

            if(mysqli_stmt_execute($stmt))
            {
                header("location:http://localhost/saar/display.php");
                exit();
            }
            else
            {
                echo "something went wrong . try again later";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);    
}
?>
<!DOCTYPE HTML>  
<html>
  <head>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <style>
    .error {color: red;}
  </style>
<body>
<div class="container" style="width: 500px; background-color: #f2f2f2; padding-bottom: 20px padding-top: 20px">
	<div class="header text-center"><h2>please fill the form</h2></div>
	  <p class="text-center" style="color: red"></p>
    <form  method="POST" name="myform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="form-group <?php echo(!empty($nameerr))? 'has-error' : ' ' ; ?>">
      <label for="name">Full Name : </label>
      <input type="text" class="form-control" name="fname" placeholder="Enter Your Full Name Here.*">
      <span class="error"> <?php echo $nameerr;?></span>
    </div>
    <div class="form-group <?php echo(!empty($emailerr))? 'has-error' : ' ' ; ?>">
      <label for="email">Email :</label>
      <input type="email" class="form-control" name="email" placeholder="Enter Your Email Here.*">
      <span class="error"> <?php echo $emailerr;?></span>
    </div>  

    <div class="form-group <?php echo(!empty($websiteerr))? 'has-error' : ' ' ; ?>">
      <label for="website">Website : </label>
      <input type="text" class="form-control" name="website" placeholder="Enter Your Website Here.*">
      <span class="error"> <?php echo $websiteerr;?></span>
    </div>

    <div class="form-group <?php echo(!empty($commenterr))? 'has-error' : ' ' ; ?>">
      <label for="comment">Comment :</label>
      <textarea name="comment" class="form-control"></textarea>
      <span class="help"><?php echo $commenterr; ?></span>

    </div>
    <div class="form-group <?php echo(!empty($gendererr))? 'has-error' : ' ' ; ?>">
    <label> Gender </label>
    <input type="radio" name="gender" value="male" <?php echo $gender; ?>>male
    <input type="radio" name="gender" value="female" <?php echo $gender; ?>>female
    <span class="error"><?php echo $gendererr; ?></span>
</div>  
    <button type="submit" name="submit" value="submit">Submit</button> 
</form>
</body>
</html>
