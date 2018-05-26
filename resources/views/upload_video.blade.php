@extends('layout')
@section('content')
    <div class="wrapper">
        <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">
            <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="http://www.creative-tim.com" class="simple-text">
                        Creative Tim
                    </a>
                </div>
                
                <ul class="nav">
                    <li>
                        <a href="dashboard.html">
                            <i class="pe-7s-graph"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="user.html">
                            <i class="pe-7s-user"></i>
                            <p>User Profile</p>
                        </a>
                    </li>
                    <li>
                        <a href="table.html">
                            <i class="pe-7s-note2"></i>
                            <p>Table List</p>
                        </a>
                    </li>
                    <li>
                        <a href="typography.html">
                            <i class="pe-7s-news-paper"></i>
                            <p>Typography</p>
                        </a>
                    </li>
                    <li>
                        <a href="icons.html">
                            <i class="pe-7s-science"></i>
                            <p>Icons</p>
                        </a>
                    </li>
                    <li>
                        <a href="maps.html">
                            <i class="pe-7s-map-marker"></i>
                            <p>Maps</p>
                        </a>
                    </li>
                    <li>
                        <a href="notifications.html">
                            <i class="pe-7s-bell"></i>
                            <p>Notifications</p>
                        </a>
                    </li>
                    <li class="active-pro">
                        <a href="upgrade.html">
                            <i class="pe-7s-rocket"></i>
                            <p>Upgrade to PRO</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="main-panel">
            <nav class="navbar navbar-default navbar-fixed">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">User</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-left">
                            {{--<li>--}}
                            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                            {{--<i class="fa fa-dashboard"></i>--}}
                            {{--<p class="hidden-lg hidden-md">Dashboard</p>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="dropdown">--}}
                            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                            {{--<i class="fa fa-globe"></i>--}}
                            {{--<b class="caret hidden-sm hidden-xs"></b>--}}
                            {{--<span class="notification hidden-sm hidden-xs">5</span>--}}
                            {{--<p class="hidden-lg hidden-md">--}}
                            {{--5 Notifications--}}
                            {{--<b class="caret"></b>--}}
                            {{--</p>--}}
                            {{--</a>--}}
                            {{--<ul class="dropdown-menu">--}}
                            {{--<li><a href="#">Notification 1</a></li>--}}
                            {{--<li><a href="#">Notification 2</a></li>--}}
                            {{--<li><a href="#">Notification 3</a></li>--}}
                            {{--<li><a href="#">Notification 4</a></li>--}}
                            {{--<li><a href="#">Another notification</a></li>--}}
                            {{--</ul>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<a href="">--}}
                            {{--<i class="fa fa-search"></i>--}}
                            {{--<p class="hidden-lg hidden-md">Search</p>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                        </ul>
                        
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="">
                                    <p>Account</p>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <p>
                                        Dropdown
                                        <b class="caret"></b>
                                    </p>
                                
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <p>Log out</p>
                                </a>
                            </li>
                            <li class="separator hidden-lg hidden-md"></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">

                                <div class="content table-responsive table-full-width">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <th>Tên Video</th>
                                            <th>Link</th>
                                            <th>Trạng thái upload</th>
                                            <th>Upload</th>
                                        </thead>
                                        <tbody id="search_resuilts">
                                                @foreach($allVideos as $video)
                                                    <tr>
                                                        <td>{!! $video->tittle !!}</td>
                                                        <td>{!! $video->link_to_file !!}</td>
                                                        <td>{!! $video->upload_status !!}</td>
                                                        <td><button class="btn btn-danger" onclick="upload(this)" data-link="{!! $video->link_to_file !!}">Upload lên kênh</button></td>
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
        </div>
    </div>
@endsection
@section('script')
    <script>
        function  upload(obj) {
            $link_to_file = $(obj).data('link');
            $.ajax({
                url:'{!! route('upload_file') !!}',
                data:{_token:'{!! csrf_token() !!}',link_to_file:$link_to_file},
                type:"POST",
                success:function(data){
                
                },
                error: function (request, status, error) {
                    $message = request.responseJSON.message ;
                    $error = JSON.parse($message);
                    console.log($error);
                    console.log($error.message);
                    if($error.error.message == 'Invalid Credentials'){
                        $.ajax({
                            url:'{!! route('clear_token') !!}',
                            type:"get",
                            success:function(data){
                                window.location.reload();
                            }
                        });
                    }
                    
                }
            });
        }
    </script>
@endsection