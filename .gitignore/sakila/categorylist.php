<!doctype html>
<html>
<head>
    
</head>
<meta charset="UTF-8">
    <title>HEY</title>
    
<body>
    
<?php
    
if($cmd = filter_input(INPUT_POST, 'cmd')) {
    
    if($cmd == 'create_category') { // med dobbelt = spørger man om det er det samme som $cmd 
        $cnam = filter_input(INPUT_POST, 'categoryname')
            or die('Missing categoryname parameter');
        
        echo 'create: '.$cnam;
        
        require_once('dbcon.php');
        $sql = 'INSERT INTO category (name) VALUES (?)';
        $stmt = $link->prepare($sql);
        $stmt->bind_param('s', $cnam);
        $stmt->execute();
        
        if($stmt->affected_rows > 0) {
            echo 'Created category '.$cnam.' with id:'.$stmt->insert_id;
        }
}
    elseif ($cmd == 'delete_category') {
        $cid = filter_input(INPUT_POST, 'categoryid',  FILTER_VALIDATE_INT)
            or die('Missing categoryid parameter');
        
        require_once('dbcon.php');
        $sql = 'DELETE FROM category WHERE category_id=?';
        $stmt = $link->prepare($sql);
        $stmt->bind_param('i', $cid);
        $stmt->execute();
        
        if($stmt->affected_rows > 0){
            echo 'Deleted category '.$cid;
        }
        else {
            echo 'Error deleting category';
        }
    } else {
        die('Unknown cmd parameter'.$cmd);
    }
}
    
    
    
?>
    
    <h1>Categories</h1>
    
    <ul>
    
    <?php
        require_once('dbcon.php');
        $sql = 'SELECT category_id, name FROM category ORDER BY name ASC';
        $stmt = $link->prepare($sql);
        // $stmt->bind_param('',); // only if params
        $stmt->execute();
        $stmt->bind_result($cid, $nam);
        while($stmt->fetch()) {
        ?>
            <li>
                <a href="filmlist.php?categoryid=<?=$cid?>"><?=$nam?></a>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="hidden" name="categoryid" value="<?=$cid?>">
                <button type="submit" name="cmd" value="delete_category">DELETE</button></form>
                <a href="renamecategory.php?categoryid=<?=$cid?>">Rename</a>
            </li>
       <?php } ?>
    </ul>
<hr>
    
    <p>
    <form action="<? $_SERVER['PHP_SELF'] ?>" method="post">
        <fieldset>
            <legend>Create new category</legend>
            <input name="categoryname" placeholder="Categoryname" type="text" required />
            <button name="cmd" value="create_category" type="submit">Create</button>
        </fieldset>
    </form>
    <p>
    
    
    
</body>      
</html>