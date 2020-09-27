<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <section style="padding-top:60px">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-header">
                           Update User
                        </div>
                        <div class="card-body">
                            @if(Session::has('user_err'))
                                <div class="alert alert-danger">
                                @foreach( Session::get('user_err') as $err )
                                    <p>*{{$err}}<p>
                                @endforeach
                                </div>
                            @endif
                            @if(Session::has('user_sucess'))
                                <div class="alert alert-success">
                                    <p>{{Session::get('user_sucess')}}<p>
                                </div>
                            @endif
                            <form action="{{route('user.create')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$Data->name}}" placeholder="Enter Name" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{$Data->email}}" placeholder="Enter Email" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control"  placeholder="Enter Password" required>
                                </div>
                                <div class="form-group">
                                    <label>Father's Name</label>
                                    <input type="text" name="fname" class="form-control" value="{{$Data->fname}}" placeholder="Enter Father's Name" required>
                                </div>
                                <div class="form-group">
                                    <label>Mother's Name</label>
                                    <input type="text" name="mname" class="form-control" value="{{$Data->mname}}" placeholder="Enter Mother's Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <textarea class="form-control" name="address" id="{{$Data->id}}" rows="3" value="" placeholder="Enter Address" required>{{$Data->address}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Profile Image</label>
                                    <input type="file" name="profileImg" class="form-control-file" id="">
                                </div>
                                <input type="hidden" name="id" value="{{$Data->id}}">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>