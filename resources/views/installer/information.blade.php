@extends('installer.index')

@section('content')
	<h3>Web Information</h3>
    <div class="mt-3">
        <form action="{{ route('set.information') }}" method="post">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="web-name">Name</label>
                    <input id="web-name" class="form-control" type="text" name="name" placeholder="Web name">
                </div>
                <div class="form-group col-md-6">
                    <label for="web-category">Category</label>
                    <select id="web-category" class="form-control" name="category">
                        <option selected>Please choose a category</option>
                        <option value="1">Category 1</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="web-language">Language</label>
                    <select id="web-language" class="form-control" name="language">
                        <option value="en" selected>English</option>
                        <option value="es">Spanish</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="web-country">Country</label>
                    <select id="web-country" class="form-control" name="country">
                        <option value="us" selected>United states</option>
                        <option value="cl" >Chile</option>
                    </select>
                </div>
            </div>
            <h3>Your Account</h3>
            <p>You can use this account on our website to get modules and templates.</p>
            <input type="hidden" name="sign" value="sign-up" id="sign-input">
            <div id="sign-up" class="sign-content">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="firstname">Firstname</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastname">Lastname</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm_password" placeholder="Confirm Password">
                    </div>
                </div>
                <p>Already have an account? <a href="#sign-in" class="display-sign">Sign in</a></p>
            </div>
            <div id="sign-in" class="sign-content" style="display: none;">
                <div class="form-group">
                    <label for="email-login">Email</label>
                    <input type="email" class="form-control" id="email-login" placeholder="example@example.com">
                </div>
                <div class="form-group">
                    <label for="password-login">Password</label>
                    <input type="password" class="form-control" id="password-login" placeholder="Password">
                </div>
                <p>Don’t have an account? <a href="#sign-up" class="display-sign">Sign up</a></p>
            </div>
            <div class="row justify-content-between">
                <div class="col-6 text-left">
                    <a href="#" class="btn btn-outline-secondary" style="padding: 0 30px;">Back</a>
                </div>
                <div class="col-6 text-right">
                    <button type="submit" class="btn btn-primary" style="padding: 0 30px;">Next</button>
                </div>
            </div>
        </form>
    </div>
@endsection