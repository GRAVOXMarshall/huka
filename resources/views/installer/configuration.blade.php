@extends('installer.index')

@section('content')
	<h3>System configuration</h3>
    <div class="mt-3">
        <form method="post" action="{{ route('set.configuration') }}">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="db-connection">Database Connection</label>
                    <select id="db-connection" class="form-control" name="connection">
                        <option value="mysql" selected>mysql</option>
                        <option value="sqlite">sqlite</option>
                        <option value="pgsql">pgsql</option>
                        <option value="sqlsrv">sqlsrv</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="db-name">Database Name</label>
                    <input id="db-name" name="name" type="text" class="form-control" placeholder="homestead" value="homestead">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="db-host">Database Host</label>
                    <input id="db-host" name="host" type="text" class="form-control" placeholder="127.0.0.1" value="127.0.0.1">
                </div>
                <div class="form-group col-md-6">
                    <label for="db-port">Database Port</label>
                    <input id="db-port" name="port" type="text" class="form-control" placeholder="3306" value="3306">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="db-user">Database User Name</label>
                    <input id="db-user" name="user" type="text" class="form-control" placeholder="homestead" value="root">
                </div>
                <div class="form-group col-md-6">
                    <label for="db-password">Database Password</label>
                    <input id="db-password" name="password" type="password" class="form-control">
                </div>
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