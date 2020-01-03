@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div style="text-transform:capitalize;">
                Weather Forcast - {{ $location }}
            </div>
            <div class="search">
                <form action="/" method="POST">
                    @csrf
                    <button type="submit">
                        <i class="las la-search"></i>
                    </button>
                    <input type="text" placeholder="search" name="search">
                </form>
            </div>
        </div>
        <current :daily="{{json_encode($forecast['daily']['data'])}}"></current>
    </div>
</div>
@endsection
