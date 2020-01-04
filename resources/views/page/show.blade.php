@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="location">
        <div class="card-header">
            <div style="text-transform:capitalize;">
               Edit your Preferred Location
            </div>
        <div>Current Preferred Location - {{ $location }}</div>
        </div>
        <div class="card">
            <div class="item">
                <p>Please enter your new preferred location:</p>
            </div>
            <div class="item">
                <form action="{{ action('HomeController@update', ['id' => $id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="location">
                        <input type="text" name="location" required>
                    </label>
                    <button>Submit</button>
                </form>
            </div>
            
        </div>
    </div>
</div>
@endsection
