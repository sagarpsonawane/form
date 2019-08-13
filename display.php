<html>
<head>
<title> Display </title>
</head>
<body>
<?php
require_once "conn.php";

$sql="SELECT fname,email,website,comment,gender from demo  ORDER BY ID DESC ";
if($result=mysqli_query($conn,$sql))
{
    if(mysqli_num_rows($result)>0)
    {
        echo "<table border=1>";
        echo "<tr>";
        echo "<th> name </th>";
        echo "<th> email </th>";
        echo "<th> website </th>";
        echo "<th> comment </th>";
        echo "<th> gender </th>";

        echo "</tr>";
        while($row=mysqli_fetch_array($result))
        {
            echo "<tr>";
            echo "<td>" .$row['fname']."</td>";
            echo "<td>" .$row['email']."</td>";
            echo "<td>" .$row['website']."</td>";
            echo "<td>" .$row['comment']."</td>";
            echo "<td>" .$row['gender']."</td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($result);
    }
    else
    {
        echo "No records found";
    }
}
else
{
    echo "ERROR: could not able to execute ".mysqli_error($conn);

}

mysqli_close($conn);
?>
</body>
</html>