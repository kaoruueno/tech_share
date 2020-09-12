<!DOCTYPE html>
<html lang="ja">
<head>
  <title>post</title>
</head>
<body>
  <form method="post" action="test2.php">
    <input type="text" name="text2" value="text2">
    <a href="test2.php?page=2" class="btn btn-secondary" role="button">test2</a>
    <input type="hidden" name="hidden" value="hidden2">
    <input type="submit" class="btn btn-success" value="test2">
    
    <form method="post" action="test3.php">
      <input type="text" name="text3" value="text3">
      <a href="test3.php?page=3" class="btn btn-secondary" role="button">test3</a>
      <input type="hidden" name="hidden" value="hidden3">
      <input type="submit" class="btn btn-success" value="test3">
    </form>
    
    
  </form>
</body>
</html>
