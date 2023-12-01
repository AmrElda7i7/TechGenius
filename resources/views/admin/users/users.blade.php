@extends('admin.layouts.master')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
               {{session()->get('error')}}
            </div>
            @endif
            @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
               {{session()->get('success')}}
            </div>
            @endif
            @can('generate_temp_link')
                
            <div class="d-flex justify-content-center">
                <a href="{{route('generate_temp_link')}}" class="btn btn-outline-primary">generate temp link</a>
            </div>
            @endcan
            <div class="row">
                <div class="col-lg-9">
                       <!-- USER DATA-->
                       <div class="user-data m-b-30">
                        <h3 class="title-3 m-b-30">
                            <i class="zmdi zmdi-account-calendar"></i>user data</h3>
                        <div class="filters m-b-45">
                            <div class="rs-select2--dark rs-select2--md m-r-10 rs-select2--border">
                            
                                <div class="dropDownSelect2"></div>
                            </div>
                         
                        </div>
                        <div class="table-responsive table-data">
                            <table class="table">
                                <thead>
                                    <tr>
            
                                        <td>id</td>
                                        <td>name</td>
                                        <td>role</td>
                                        <td>actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        
                                    <tr>
                                        <td>
                                            {{$user->id}}
                                        </td>
                                        <td>
                                            <div class="table-data__info">
                                                <h6>{{$user->name}}</h6>
                                                <span>
                                                    <a href="#">{{$user->email}}</a>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{$user->getRoleNames()->first()}}</span>
                                        </td>
                                        @can('update_user')
                                            
                                        <td>
                                            <a href="{{route('users.edit',$user->id)}}" class="btn btn-outline-primary">edit</a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" class="btn btn-outline-danger" value="delete"></input>
                                            </form>
                                        </td>
                                        @endcan
                                    </tr>
                                    @endforeach
                                 
                                </tbody>
                            </table>
                        </div>
           
                    </div>
                    <!-- END USER DATA-->
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
