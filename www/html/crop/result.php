<?php include 'filesLogic.php';?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="style.css">
  <title>Download files</title>
</head>
<body>
<table>
<tbody>
  <?php foreach ($images as $key => $image): ?>
    <tr>
      <td><?php echo (sizeof($images) - $key); ?></td>
      <td>
        <a href="<?php echo $image; ?>" download="file-<?php echo (sizeof($images) - $key).'__'.date("Y-m-d_H-i-s");?>">
          <img src="<?php echo $image; ?>" alt="file">
        </a>  
      </td>
    </tr>
  <?php endforeach;?>

</tbody>
</table>

</body>
</html>