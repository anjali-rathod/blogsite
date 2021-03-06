<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Calcutta');

/*LOGIN*/
function login($uid, $upd)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');

    $sql = "SELECT uid FROM credentials WHERE uid = :uid and upd = :upd ";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(array(':uid'=>$uid,':upd'=>sha1($upd)));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}
/*Admin check*/
function admin($uid)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $sql = "SELECT admin FROM credentials WHERE uid='". $uid."'";
    $stmt=$pdo->query($sql);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row["admin"];
}

/*uno*/
function uno($uid)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $sql = "SELECT uno FROM credentials WHERE uid='". $uid."'";
    $stmt=$pdo->query($sql);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row["uno"];
}

/*SIGN-UP*/
function sign_up($name,$email,$uid, $upd)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $stmt2 = $pdo->query('SELECT * FROM credentials where uid="'. $uid.'"');
    $hashedpassword = sha1($upd);
    if ($row=$stmt2->fetch(PDO::FETCH_ASSOC))
    {
        echo "<p id='e'><br>User Id Already Exists!<br><p>";
    }
    else
    {
        $sql = 'INSERT INTO credentials (uid,upd,name,admin, email) VALUES ("'.$uid.'","'.$hashedpassword.'","'.$name.'","no", "'.$email.'")';
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
    include_once("db_credentials.php");
    $pdo= new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
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
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
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
function disp_account_blog($uid,$uno)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $stmt2 = $pdo->query('SELECT blogid, blogname, blogdate, blogcontent,uid FROM blog where uno="'. $uno.'" ORDER BY blogdate DESC');
    while($row=$stmt2->fetch(PDO::FETCH_ASSOC))
    {
            echo '<h1><a href="viewpost.php?id='.$row['blogid'].'">'.$row['blogname'].'</a></h1>';
            echo '<p>Posted on '.$row['blogdate'].'</p>';
            echo '<p>Posted by '.$row['uid'].'</p>';
            echo '<p>'.$row['blogcontent'].'</p>';                
            echo '<p><a href="viewpost.php?id='.$row['blogid'].'">Read More</a></p>';    
            echo '<p><a href="edit.php?id='.$row['blogid'].'"> Edit Blog</a></p>';    
            echo '<p><a href="delete.php?id='.$row['blogid'].'">Delete Blog</a></p>';    
            echo '<hr>'; 

    }
}  

/*VIEW-POST*/   
function view_post($blogid,$admin,$logged_in,$uid)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $stmt2 = $pdo->query('SELECT blogid, blogname, blogdate, blogcontent,uid FROM blog where blogid='. $blogid);
    while($row=$stmt2->fetch(PDO::FETCH_ASSOC))
    {
        if ($admin=="yes" && $logged_in=="pass")
        {
            echo '<h1>'.$row['blogname'].'</a></h1>';
            echo '<p>Posted on '.$row['blogdate'].'</p>';
            echo '<p>Posted by '.$row['uid'].'</p>';
            echo '<p>'.$row['blogcontent'].'</p>';          
            echo '<p><a href="account.php"> Back</a></p>';   
            echo '<p><a href="edit.php?id='.$row['blogid'].'"> Edit Blog</a></p>';    
            echo '<p><a href="delete.php?id='.$row['blogid'].'">Delete Blog</a></p>';  
            echo '<hr>';   
        }
        else
        {
            echo '<h1>'.$row['blogname'].'</a></h1>';
            echo '<p>Posted on '.$row['blogdate'].'</p>';
            echo '<p>Posted by '.$row['uid'].'</p>';
            echo '<p>'.$row['blogcontent'].'</p>';          
            echo '<p><a href="blogs.php"> Back</a></p>';   
            echo '<hr>'; 
        }

    }
}     

/*DELETE*/
function delete_post($blogid,$uid,$uno)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $stmt1 = $pdo->query('SELECT blogid FROM blog where uno="'. $uno.'"');
    $count=0;
    while ($row1=$stmt1->fetch(PDO::FETCH_ASSOC))
    {
        if ($row1["blogid"]===$blogid)
        {
            $count=$count+1;
        }
    }
    if ($count>0)
    {
        $stmt2 = $pdo->query('DELETE FROM blog where blogid='. $blogid);
        $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
        echo "<p id='g'>Blog deleted successfully !<p>";
    }
    else
    {
        echo "<p id='e'>NOT ALLOWED !<p>";
    }
    
}  

/*Do Edit*/
function edit($blogid,$blogn,$content)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $sql='UPDATE blog SET blogcontent=?,blogname=? where blogid=?';
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$content,$blogn,$blogid]) === TRUE )
    {
        header("LOCATION: account.php");
    }
    else
    {
        echo "<p id='e'>Blog edit unsuccessfully. Try Again !<p>";
    }
}

/*Edit Display*/
function edit_post($blogid,$uid,$uno)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');

    $stmt1 = $pdo->query('SELECT blogid FROM blog where uno="'. $uno.'"');
    $count=0;
    while ($row1=$stmt1->fetch(PDO::FETCH_ASSOC))
    {
        if ($row1["blogid"]===$blogid)
        {
            $count=$count+1;
        }
    }
    if ($count>0)
    {

        $stmt2 = $pdo->query('SELECT * FROM blog where blogid='. $blogid);
        $row=$stmt2->fetch(PDO::FETCH_ASSOC);

        echo '<form method="post">';
        echo '<input type="text" name="blogn" value="'.$row['blogname'].'"></input>';
        echo '<p>Posted on '.$row['blogdate'].'</p>'; 
        echo '<p>Posted by '.$row['uid'].'</p>'; 
        echo '<textarea name="blogv" rows="20" class="content_textarea">'.$row['blogcontent'].'</textarea><br>';   
        echo '<button name="edit_button"> Edit Blog</button>';
        echo '</form>';       
        echo '<p><a href="account.php"> Back</a></p>';
        echo '<hr>';    
        if (isset($_POST['edit_button']))
        {
            edit($blogid,$_POST['blogn'],$_POST['blogv']);
        }
    }
    else
    {
        echo "<p id='e'>NOT ALLOWED !<p>";
    }

}

/*Create Blog*/
function create_post($uid,$uno)
{
    include_once("db_credentials.php");
    echo '<h1>Create your new blog</h1>';
    echo '<form method="post">';
    echo '<input type="text" name="c_title" placeholder="Enter blog title here"/>';
    echo '<textarea name="c_content" rows="20" class="content_textarea" placeholder="Enter blog text here . . . . ."></textarea><br>';   
    echo '<button name="create_button"> Create Blog</button>';
    echo '</form>';       
    echo '<p><a href="account.php"> Back</a></p>';  

    if   (isset($_POST['create_button']))
    {
        creating($uid,$uno,$_POST["c_title"],$_POST["c_content"]);
    }
}

/*Creating*/
function creating($uid,$uno,$title,$content)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $sql = 'INSERT INTO blog (blogname,blogdate,blogcontent,uid,uno) VALUES ("'.$title.'","'.date("Y-m-d").'","'.$content.'", "'.$uid.'","'.$uno.'")';
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
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $stmt2 = $pdo->query('SELECT * FROM credentials');
    echo "<table>";
    echo "<tr>";
    echo "<th>User No.</th>";
    echo "<th>User ID</th>";
    echo "<th>User Password</th>";
    echo "<th>Name</th>";
    echo "<th>Admin</th>";
    echo "<th>Admin Update</th>";
    echo "<th>Email</th>";
    echo "<th>Update</th>";
    echo "<th>Delete</th>";
    echo "</tr>";
    
    while ($row=$stmt2->fetch(PDO::FETCH_ASSOC))
    {
        echo '<form method="post">';
        echo "<tr>";
        echo '<td><input type="text" name="uno" value="'.$row['uno'].'" readonly></input></td>';
        echo '<td><input type="text" name="uid" value="'.$row['uid'].'"></input></td>';
        echo '<td><input type="password" name="upd" placeholder="Password"></input></td>';
        echo '<td><input type="text" name="name" value="'.$row['name'].'"></input></td>';
        echo '<td><input type="text" name="ad" value="'.$row['admin'].'" readonly></td>';
        echo '<td><input type="radio" name="admin" value="yes">YES  </input>';
        echo '<input type="radio" name="admin" value="no">  NO</input></td>';
        echo '<td><input type="email" name="email" value="'.$row['email'].'""></input></td>';
        echo '<td><button name="update_button"> Update Information</button></td>';
        echo '<td><button name="delete_button"> Delete Information</button></td>';
        echo "</tr>"; 
        echo '</form>';
    }
        
    echo "</table>";
    echo "<br>";
    echo "<a href='account.php'> Back </a>";
    if (isset($_POST["update_button"]))
    {
        if (!isset($_POST["admin"]))
        {
            $_POST["admin"]=$_POST["ad"];
        }
        if (empty($_POST["upd"]))
        {
            updating_no_pass_info($_POST["uno"],$_POST["uid"],$_POST["name"],$_POST["admin"],$_POST["email"]);
        
        }
        else
        {
            updating_user_info($_POST["uno"],$_POST["uid"],sha1($_POST["upd"]),$_POST["name"],$_POST["admin"],$_POST["email"]);
        }
    }
    if (isset($_POST["delete_button"]))
    {
        delete_user_info($_POST["uno"]);
    }
}

/*Updating user info*/
function updating_user_info($uno,$uid,$upd,$name,$admin,$email)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $sql='UPDATE credentials SET uid=?,upd=?,name=?,admin=?,email=? where uno=?';
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$uid,$upd,$name,$admin,$email,$uno]) === TRUE )
    {
        "<p id='g'>Information Update successful. Please  Refresh !<p>";
        return "pass";
    }
    else
    {
        echo "<p id='e'>Information Update unsuccessful. Try Again !<p>";
    }
}

function updating_no_pass_info($uno,$uid,$name,$admin,$email)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $sql='UPDATE credentials SET uid=?,name=?,admin=?,email=? where uno=?';
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$uid,$name,$admin,$email,$uno]) === TRUE )
    {
        "<p id='g'>Information Update successful. Please  Refresh !<p>";
        return "pass";
    }
    else
    {
        echo "<p id='e'>Information Update unsuccessful. Try Again !<p>";
    }
}


/*Delete User Info*/
function delete_user_info($uno)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $stmt2 = $pdo->query('DELETE FROM credentials where uno='. $uno);
    $row=$stmt2->fetch(PDO::FETCH_ASSOC);
    echo "<p id='g'>User deleted successfully . Please refresh!<p>";
}

/*personal info*/
function personal_info($uid,$uno)
{
    include_once("db_credentials.php");
    $pdo=new PDO('mysql:host=localhost;port=3307;dbname="database name"', '"id"', '"password"');
    $stmt2 = $pdo->query('SELECT * FROM credentials where uno="'.$uno.'"');
    $ad="";
    echo "<table>";
    echo "<tr>";
    echo "<th>User No. </th>";
    echo "<th>User ID</th>";
    echo "<th>User Password</th>";
    echo "<th>Name</th>";
    echo "<th>Admin</th>";
    echo "<th>Email</th>";
    echo "<th>Update</th>";
    echo "</tr>";
    
    while ($row=$stmt2->fetch(PDO::FETCH_ASSOC))
    {
         echo '<form method="post">';
        echo "<tr>";
        echo '<td><input type="text" name="uno" value="'.$row['uno'].'" readonly></input></td>';
        echo '<td><input type="text" name="uid" value="'.$row['uid'].'"></input></td>';
        echo '<td><input type="password" name="upd" placeholder="Password"></input></td>';
        echo '<td><input type="text" name="name" value="'.$row['name'].'"></input></td>';
        echo '<td><input type="text" name="admin" value="'.$row['admin'].'" readonly></td>';
        echo '<td><input type="email" name="email" value="'.$row['email'].'""></input></td>';
        echo '<td><button name="update_button"> Update Information</button></td>';
        echo "</tr>"; 
        echo '</form>';
        $ad=$row['admin'];
    }
        
    echo "</table>";
    echo "<br>";
    echo "<a href='account.php'> Back </a>";
    if (isset($_POST["update_button"]))
    {
        if (empty($_POST["upd"]))
        {
            updating_no_pass_info($_POST["uno"],$_POST["uid"],$_POST["name"],$_POST["admin"],$_POST["email"]);
        
        }
        else
        {
            if (updating_user_info($_POST["uno"],$_POST["uid"],sha1($_POST["upd"]),$_POST["name"],$ad,$_POST["email"])=="pass")
            {
                header("LOCATION: logout.php");
            }

        }
    }
}