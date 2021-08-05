<!DOCTYPE html>
<html>
<style>
input, select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>
<body>

<h3>Login</h3>
<?php if(isset($message)) {
	echo $message;
}
?>

<div>
  <form method="POST" action="<?=base_url('home/login')?>">
    <label for="email">Email</label>
    <input type="text" id="email" name="email" placeholder="Your Email..">

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Your Password..">
  
    <input type="submit" value="Submit">
  </form>
	<a href="<?=base_url('home/google_login')?>"><img width="250" height="60" src="<?=base_url('assets/images/google_logo.png')?>"></a>
</div>

</body>
</html>
