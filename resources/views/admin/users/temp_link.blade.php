@extends('admin.layouts.master')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">

          
            <div class="row">
                <div class="col-lg-9">
                    <form method="GET" action="{{route('show_temp_link')}}">
                        @csrf
                        <div class="row mb-3">
                            <label for ="hours" class="col-sm-2 col-form-label">hours </label> 
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="hours" value="{{ old('hours') }}" id="hours">
                             
                                @error('hours') 
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-10">

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="selectSm" class=" form-control-label">roles</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="role" id="SelectLm" class="form-control-smform-control">
                                            @foreach ($roles as $role)
                                          
                                            <option value="{{$role->hash->hash}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    @error('roles')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                        <input type="submit" class="btn btn-primary" value="submit"></input>
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
