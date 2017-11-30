<html>
<head>
    <title>我是表单</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
<form method="post" action="{{ url('form') }}">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Username">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="exampleInputFile">File input</label>
        <input type="file" name="photo" id="exampleInputFile">
        <p class="help-block">Example block-level help text here.</p>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
</body>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</html>
