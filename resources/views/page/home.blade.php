@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div>{{ $location }} Weather Forcast</div>
                    <div>
                        <form action="/" method="POST">
                            @csrf
                            <button type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                            <input type="text" placeholder="search" name="search">
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif  
                    <current
                        :current="{{ json_encode($current) }}"
                        :icon="{{ json_encode($current['icon']) }}"                        
                        :summary="{{ json_encode($current['icon']) }}">
                    </current>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
