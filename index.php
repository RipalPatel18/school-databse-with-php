<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Schools</title>
</head>
<body>
    <h1>All Schools</h1>
    <hr>
    <div>
        <?php
        require ('connect.php');
      $query = 'SELECT * FROM schools'; 
        $schools = mysqli_query($connect, $query);

        // echo '<pre>' . print_r($schools) . '</pre>';

foreach($schools as $school){
  echo $school['School Name'] . 
  '<form>
      <input type="hidden" name="id" value="' . $school['id'] . '">
      <input type="submit" value="Edit">
    </form><br>';
}




        ?>
       
        <div class="box">

        <h3>School Name</h3>
        </div>
        </div>
</body>
</html>