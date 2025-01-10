<!DOCTYPE html>
<html>
<body>

<h2>HTML Forms</h2>

<form action="{{url('submit')}}" method="POST" enctype="multipart/form-data">
	 @csrf
  <label for="fname">Name:</label><br>
  <input type="text" id="fname" name="name" ><br>
  <label for="lname">WEBSITE LINK:</label><br>
  <input type="text" id="lname" name="website_link"><br><br>
  <label for="lname">APP GR :</label><br>
  <input type="text" id="lname" name="app_group"><br><br>
  <label for="lname">APPLICATION INFO :</label><br>
  <input type="text" id="lname" name="app_description"><br><br>
  <label for="lname">PICTURE name:</label><br>
  <input type="file" id="lname" name="picture_icon"><br><br>
  <label for="lname">Open Type:</label><br>
  <input type="text" id="lname" name="open_type"><br><br>
  <input type="submit" value="Submit">
</form> 

<p>If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".</p>

</body>
</html>

