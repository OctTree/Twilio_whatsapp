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
                <div class="col">
                    <div class="card" style="height:414px;">
                        <div class="card-header">
                            Add Phone Number
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Enter Phone Number</label>
                                    <input type="tel" class="form-control" name="phone_number" placeholder="Enter Phone Number">
                                </div>
                                <button type="submit" class="btn btn-primary">Register User</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Send SMS message
                        </div>
                        <div class="card-body">
                            <form method="POST" action="/custom">
                                @csrf
                                <div class="form-group">
                                    <label>Select users to notify</label>
                                    <select name="users[]" multiple class="form-control">
                                        @foreach ($users as $user)
                                        <option>{{$user->phone_number}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Notification Message</label>
                                    <textarea name="body" class="form-control" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Notification</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="col-md-12">
                            <div class="card">
                                    {{-- @if($current_lists = Session::get('current_lists')) --}}
                                    <div class="table-responsive">
                                        <div class="card-header">
                                            Message Log
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

                                                        <?php foreach ($current_lists as $current_list) { ?>
                                                            <tr>
                                                                <td><?php echo $current_list->id;?></td>
                                                                <td><?php echo $current_list->from_number;?></td>
                                                                <td><?php echo $current_list->to_number;?></td>
                                                                <td><?php echo $current_list->content;?></td>
                                                                <td><?php echo $current_list->created_at;?></td>
                                                                @if($current_list->status == 'queued')
                                                                    <td><span class="badge badge-danger" >Queued</span></td>
                                                                @elseif($current_list->status == 'failed')
                                                                    <td><span class="badge badge-warning" >Failed</span></td>
                                                                @elseif($current_list->status == 'read')
                                                                    <td><span class="badge badge-warning" >Read</span></td>
                                                                @elseif($current_list->status == 'sent')
                                                                    <td><span class="badge badge-success" >Sent</span></td>
                                                                @elseif($current_list->status == 'delivered')
                                                                    <td><span class="badge badge-info" >Delivered</span></td>
                                                                @elseif($current_list->status == 'undelivered')
                                                                    <td><span class="badge badge-warning" > Undelivered</span></td>

                                                                @elseif($current_list->status == 'received')
                                                                    <td><span class="badge badge-info"><a href="{{ route('replies.show', $current_list->id) }}" style="color:#FFF">Received ({{$current_list->replies->count()}})</a></span></td>
                                                                @endif
                                                            </tr>
                                                        <?php } ?>


                                                    </tbody>
                                            </table>
                                    </div>
                                    {{-- @endif --}}
                                </div>
                    </div>

            </div>
        </div>
    </div>
</body>
</html>
