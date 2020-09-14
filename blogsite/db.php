<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
$pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
date_default_timezone_set('Asia/Calcutta');

/*LOGIN*/
function login($uid, $upd)
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');

    $sql = "SELECT uid FROM credentials WHERE uid = :uid and upd = :upd ";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(array(':uid'=>$uid,':upd'=>$upd));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}
/*Admin check*/
function admin($uid)
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
    $sql = "SELECT admin FROM credentials WHERE uid='". $uid."'";
    $stmt=$pdo->query($sql);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row["admin"];
}

/*SIGN-UP*/
function sign_up($name,$email,$uid, $upd)
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
    $stmt2 = $pdo->query('SELECT * FROM credentials where uid="'. $uid.'"');
    if ($row=$stmt2->fetch(PDO::FETCH_ASSOC))
    {
        echo "<p id='e'><br>User Id Already Exists!<br><p>";
    }
    else
    {
        $sql = 'INSERT INTO credentials (uid,upd,name,admin, email) VALUES ("'.$uid.'","'.$upd.'","'.$name.'","no", "'.$email.'")';
        if ($pdo->query($sql) === FALSE) 
        {
            echo "<br >Error <br>";
        }
        else
        {
            echo "<p id='g'>New account created successfully. Please login !<p>";
        }
       
    }
}

/*ALL-BLOGS*/
function disp_all_blog()
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
    $stmt2 = $pdo->query('SELECT blogid, blogname, blogdate, blogcontent FROM blog ORDER BY blogdate DESC');
    while($row=$stmt2->fetch(PDO::FETCH_ASSOC))
    {
        echo '<h1><a href="viewpost.php?id='.$row['blogid'].'">'.$row['blogname'].'</a></h1>';
        echo '<p>Posted on '.$row['blogdate'].'</p>';
        echo '<p>'.$row['blogcontent'].'</p>';                
        echo '<p><a href="viewpost.php?id='.$row['blogid'].'">Read More</a></p>';                
    }
}

/*RECENT-BLOGS */
function disp_recent_blog()
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
    $stmt2 = $pdo->query('SELECT blogid, blogname, blogdate, blogcontent FROM blog ORDER BY blogdate DESC');
    $count=0;
    while($row=$stmt2->fetch(PDO::FETCH_ASSOC))
    {
        if ($count<3)
        {
            echo '<h1><a href="viewpost.php?id='.$row['blogid'].'">'.$row['blogname'].'</a></h1>';
            echo '<p>Posted on '.$row['blogdate'].'</p>';
            echo '<p>'.$row['blogcontent'].'</p>';                
            echo '<p><a href="viewpost.php?id='.$row['blogid'].'">Read More</a></p>';    
            $count=$count+1;    
        }        
    }
}   

/*ACCOUNT-BLOGS */  
function disp_account_blog($uid)
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
    $stmt2 = $pdo->query('SELECT blogid, blogname, blogdate, blogcontent FROM blog where uid="'. $uid.'" ORDER BY blogdate DESC');
    while($row=$stmt2->fetch(PDO::FETCH_ASSOC))
    {
            echo '<h1><a href="viewpost.php?id='.$row['blogid'].'">'.$row['blogname'].'</a></h1>';
            echo '<p>Posted on '.$row['blogdate'].'</p>';
            echo '<p>'.$row['blogcontent'].'</p>';                
            echo '<p><a href="viewpost.php?id='.$row['blogid'].'">Read More</a></p>';    
            echo '<p><a href="edit.php?id='.$row['blogid'].'"> Edit Blog</a></p>';    
            echo '<p><a href="delete.php?id='.$row['blogid'].'">Delete Blog</a></p>';    

    }
}  

/*VIEW-POST*/   
function view_post($blogid,$admin,$logged_in,$uid)
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
    $stmt2 = $pdo->query('SELECT blogid, blogname, blogdate, blogcontent FROM blog where blogid='. $blogid);
    while($row=$stmt2->fetch(PDO::FETCH_ASSOC))
    {
        if ($admin=="yes" && $logged_in=="pass")
        {
            echo '<h1>'.$row['blogname'].'</a></h1>';
            echo '<p>Posted on '.$row['blogdate'].'</p>';
            echo '<p>'.$row['blogcontent'].'</p>';          
            echo '<p><a href="account.php"> Back</a></p>';   
            echo '<p><a href="edit.php?id='.$row['blogid'].'"> Edit Blog</a></p>';    
            echo '<p><a href="delete.php?id='.$row['blogid'].'">Delete Blog</a></p>';    
        }
        else
        {
            echo '<h1>'.$row['blogname'].'</a></h1>';
            echo '<p>Posted on '.$row['blogdate'].'</p>';
            echo '<p>'.$row['blogcontent'].'</p>';          
            echo '<p><a href="blogs.php"> Back</a></p>';   
        }

    }
}     

/*DELETE*/
function delete_post($blogid)
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
    $stmt2 = $pdo->query('DELETE FROM blog where blogid='. $blogid);
    $row=$stmt2->fetch(PDO::FETCH_ASSOC);
    echo "<p id='g'>Blog deleted successfully !<p>";
}  

/*Do Edit*/
function edit($blogid,$content)
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
    $sql='UPDATE blog SET blogcontent=? where blogid=?';
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$content,$blogid]) === TRUE )
    {
        header("LOCATION: account.php");
    }
    else
    {
        echo "<p id='e'>Blog edit unsuccessfully. Try Again !<p>";
    }
}

/*Edit Display*/
function edit_post($blogid)
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
    $stmt2 = $pdo->query('SELECT * FROM blog where blogid='. $blogid);
    $row=$stmt2->fetch(PDO::FETCH_ASSOC);

    
    echo '<h1>'.$row['blogname'].'</a></h1>';
    echo '<p>Posted on '.$row['blogdate'].'</p>';
    echo '<form method="post">';
    echo '<textarea name="blogv" rows="20" class="content_textarea">'.$row['blogcontent'].'</textarea><br>';   
    echo '<button name="edit_button"> Edit Blog</button>';
    echo '</form>';       
    echo '<p><a href="account.php"> Back</a></p>';    
    if (isset($_POST['edit_button']))
    {
        edit($blogid,$_POST['blogv']);
    }

}

/*Create Blog*/
function create_post($uid)
{
    echo '<h1>Create your new blog</h1>';
    echo '<form method="post">';
    echo '<input type="text" name="c_title" placeholder="Enter blog title here"/>';
    echo '<textarea name="c_content" rows="20" class="content_textarea" placeholder="Enter blog text here . . . . ."></textarea><br>';   
    echo '<button name="create_button"> Create Blog</button>';
    echo '</form>';       
    echo '<p><a href="account.php"> Back</a></p>';  

    if   (isset($_POST['create_button']))
    {
        creating($uid,$_POST["c_title"],$_POST["c_content"]);
    }
}

/*Creating*/
function creating($uid,$title,$content)
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
    $sql = 'INSERT INTO blog (blogname,blogdate,blogcontent,uid) VALUES ("'.$title.'","'.date("Y-m-d").'","'.$content.'", "'.$uid.'")';
    if ($pdo->query($sql) === FALSE) 
    {
        echo "<p id='e'>Error!<p><br>";
    }
    else
    {
        echo "<p id='g'>New blog created successfully.!<p>";
        header("LOCATION: account.php");
    }
}

/* user info*/
function user_info()
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
    $stmt2 = $pdo->query('SELECT * FROM credentials');
    $user="";
    echo "<table>";
    echo "<tr>";
    echo "<th>User Number</th>";
    echo "<th>User ID</th>";
    echo "<th>User Password</th>";
    echo "<th>Name</th>";
    echo "<th>Admin</th>";
    echo "<th>Admin Update</th>";
    echo "<th>Email</th>";
    echo "</tr>";
    
    while ($row=$stmt2->fetch(PDO::FETCH_ASSOC))
    {
        echo '<form method="post">';
        echo "<tr>";
        echo '<td><input type="text" name="uno" value="'.$row['uno'].'" hidden></input></td>';
        echo '<td><input type="text" name="uid" value="'.$row['uid'].'"></input></td>';
        echo '<td><input type="text" name="upd" value="'.$row['upd'].'"></input></td>';
        echo '<td><input type="text" name="name" value="'.$row['name'].'"></input></td>';
        echo '<td>'.$row['admin'].'</td>';
        echo '<td><input type="radio" name="admin" value="yes">YES  </input>';
        echo '<input type="radio" name="admin" value="no">  NO</input></td>';
        echo '<td><input type="email" name="email" value="'.$row['email'].'""></input></td>';
        echo "</tr>"; 
        echo '<td><button name="update_button"> Update Information</button></td>';
        echo '</form>';
    }
        
    echo "</table>";
    if (isset($_POST["update_button"]))
    {
        if (!isset($_POST["admin"]))
        {
            $_POST["admin"]="no";
        }
        updating_user_info($_POST["uno"],$_POST["uid"],$_POST["upd"],$_POST["name"],$_POST["admin"],$_POST["email"]);
        
    }
}

/*Updating user info*/
function updating_user_info($uno,$uid,$upd,$name,$admin,$email)
{
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname=people','anjali','ctc');
    $sql='UPDATE credentials SET uid=?,upd=?,name=?,admin=?,email=? where uno=?';
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$uid,$upd,$name,$admin,$email,$uno]) === TRUE )
    {
        "<p id='g'>Information Update successful. Please  Refresh !<p>";
    }
    else
    {
        echo "<p id='e'>Information Update unsuccessful. Try Again !<p>";
    }
}