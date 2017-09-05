<!doctype html>
<html>
<head>
    
</head>
<meta charset="UTF-8">
    <title>HEY</title>
    
<body>
    

    
<?php
    
if($cmd = filter_input(INPUT_POST, 'cmd')) {
    if($cmd == 'rename_category') {
        $cid = filter_input(INPUT_GET, 'categoryid', FILTER_VALIDATE_INT)
            or die('Missing categoryid parameter');
        
        $cnam = filter_input(INPUT_POST, 'categoryname')
            or die('Missing categoryname parameter');
        require_once('dbcon.php');
        $sql = 'UPDATE category SET name=? WHERE category_id=?;';
        $stmt = $link->prepare($sql);
        $stmt->bind_param('si', $cnam, $cid);
        $stmt->execute();
        
        if($stmt->affected_rows >0) {
            echo 'Category name updated to '.$cnam;
        }
        else {
            echo 'Could not change name' .$cid;
        }
    }
    else {
        die('Unknown cmd paramter: '.$cmd);
    }
}
$cid = filter_input(INPUT_GET, 'categoryid', FILTER_VALIDATE_INT)
    or die('Missing categoryid parameter');
    
?>
    <p>
    <form action="<? $_SERVER['PHP_SELF'] ?>" method="post">
        <fieldset>
            <legend>Rename category</legend>
            <input type="hidden" name="categoryid" value="<?$cid?>" />
            <input name="categoryname" placeholder="Categoryname" type="text" required />
            <button name="cmd" value="rename_category" type="submit">Update</button>
        </fieldset>
    </form>
    <p>
        
    </body>
</html>