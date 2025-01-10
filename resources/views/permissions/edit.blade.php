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
    <form action="{{ route('permission-update',['id' => $permission->id]) }}" method="POST">
       @csrf
      <div class="form-group">
        <label for="email">Role Name:</label>
        <input type="text" class="form-control" id="email" placeholder="Enter email" name="name" value="{{ $permission->name }}">
      </div>
      <div class="form-group">
         <label for="file">Permissions:</label>
        <div class="checkbox">
          <label><input type="checkbox" id="file" name="permissions[]" value="preview"
             @php echo in_array('preview', $permission->permissions) ? 'checked' : '' @endphp> Preview</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="search"
           @php echo in_array('search', $permission->permissions) ? 'checked' : '' @endphp > Search</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="download"
            @php echo in_array('download', $permission->permissions) ? 'checked' : '' @endphp> Download</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="new-file"
            @php echo in_array('new-file', $permission->permissions) ? 'checked' : '' @endphp> New File</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="upload"
            @php echo in_array('upload', $permission->permissions) ? 'checked' : '' @endphp> Upload</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="share"
            @php echo in_array('share', $permission->permissions) ? 'checked' : '' @endphp> Share</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="edit"
            @php echo in_array('edit', $permission->permissions) ? 'checked' : '' @endphp> Edit</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="delete"
            @php echo in_array('delete', $permission->permissions) ? 'checked' : '' @endphp> Delete</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="move"
            @php echo in_array('move', $permission->permissions) ? 'checked' : '' @endphp> Move</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="compress"
            @php echo in_array('compress', $permission->permissions) ? 'checked' : '' @endphp> Compression</label>
          <label><input type="checkbox" id="file" name="permissions[]" value="decompress"
            @php echo in_array('decompress', $permission->permissions) ? 'checked' : '' @endphp> Decompress</label>
        </div>
      </div>

      <button type="submit" class="btn btn-info">Update</button>
    </form>
  </div>
</div>

</body>
</html>
