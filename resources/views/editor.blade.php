@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="editor">
                <div class="card-header">Création de jeu</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Amuse toi bien !
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="render">
                <div class="card-header">Création de jeu</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Amuse toi bien !
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
