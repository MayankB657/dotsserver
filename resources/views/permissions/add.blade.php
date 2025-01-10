<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Document Permissions List</h2>
  <p>Please add permissions as per requirment</p>
  <a href="{{ route('permissions') }}"><button type="button" class="btn btn-default">Back</button></a>
  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4"></div>
    <div class="col-sm-4"></div>
  </div>                                                                                      
  <div class="table-responsive">          
    <form action="{{ route('permission-create') }}" method="POST">
       @csrf
      <div class="form-group">
        <label for="email">Role Name:</label>
        <input type="text" class="form-control" id="email" placeholder="Enter email" name="name">
      </div>
      <div class="form-group">
         <label for="file">Permissions:</label>
        <div class="checkbox">
          <label><input type="checkbox" id="file" name="permissions[]" value="preview"> Preview</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="search"> Search</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="download"> Download</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="new-file"> New File</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="upload"> Upload</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="share"> Share</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="edit"> Edit</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="delete"> Delete</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="move"> Move</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="compress"> Compression</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="decompress"> Decompress</label>
        </div>
      </div>

      <button type="submit" class="btn btn-info">Create</button>
    </form>
  </div>
</div>

</body>
</html>
