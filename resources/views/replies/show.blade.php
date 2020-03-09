<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Portal With Twilio</title>
    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
        crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            
            @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success!</strong>{{ session('success') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <ul>
                    @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="row">
                    <div class="col-md-12">
                            <a href="{{ route('home') }}">Back</a>
                            <div class="card">
                                    
                                    <div class="table-responsive">
                                        <div class="card-header">
                                           Recieved Msg
                                        </div>

                                            <table class="table table-bordered" style="text-align:center;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:1%">No</th>
                                                            <th style="width:10%">From</th>
                                                            <th style="width:15%">To</th>
                                                            <th style="width:50%">Message</th>
                                                            <th style="width:20%">Time</th>
                                                            <th style="width:10%">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                   
                                                    @foreach($content->replies()->get() as $reply) 
                                                        <tr>
                                                            <td>{{ $reply->id }}</td>
                                                            <td>{{ $reply->From }}</td>
                                                            <td>{{ $reply->To }}</td>
                                                            <td>{{ $reply->Body }}</td>
                                                            <td>{{ $reply->created_at }}</td>
                                                            <td>{{ $reply->SmsStatus }}</td>

                                                        
                                                        </tr>


                                                    @endforeach
                                                    </tbody>
                                            </table>
                                    </div>
                                    
                                </div>
                    </div>

            </div>
        </div>
    </div>
</body>
</html>
