@extends('layouts.app')
@section('content')
<script>
    $( function() {
        var text = 'Kein Ton';
        $( "#slider" ).slider({
            value: {{ old('sound') ? old('sound') : 2 }},
            min: 0,
            max: 3,
            step: 1,
            slide: function( event, ui ) {
                switch(ui.value) {
                    case 0:
                        text = 'Kein Ton';
                        break;
                    case 1:
                        text = 'Schlechte Qualität';
                        break;
                    case 2:
                        text = 'Mittlere Qualität';
                        break;
                    case 3:
                        text = 'Hohe Qualität';
                        break;
                }
                $( "#sound" ).val( text );
                $( "#refsound" ).val(ui.value);
            }
        });
        switch($( "#slider" ).slider( "value" )) {
            case 0:
                text = 'Kein Ton';
                break;
            case 1:
                text = 'Schlechte Qualität';
                break;
            case 2:
                text = 'Mittlere Qualität';
                break;
            case 3:
                text = 'Hohe Qualität';
                break;
        }
        $( "#sound" ).val( text );
        $( "#refsound" ).val( $( "#slider" ).slider( "value" ) );
    } );
</script>
    <div class="content">
        <div class="title m-b-md">
            mp4 Converter
        </div>

        <p>
            Wandelt Videos ins mp4 Format um.
            Maximale Videogröße 100MB. Maximale Länge 180 Sekunden. <br>
            Die Konvertierung kann je nach Videolänge bis zu einer Minute Dauern ¯\_(ツ)_/¯
        </p>
        <div class="container">
            <form action="{{ route('convert') }}" method="POST" id="upload_form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="container-fluid panel-container">
                                    <h3 class="panel-title col-md-5">Fileupload:</h3>
                                    <h3 class="panel-title col-md-2">ODER</h3>
                                    <h3 class="panel-title col-md-5">URL</h3>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-5">
                                    <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                        <label class="btn btn-default btn-file">
                                            Video Auswählen <input type="file" class="form-control" value="{{ old('file') }}" name="file" id="file" style="display: none;" />
                                        </label>
                                        @if ($errors->has('file'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('file') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-5 col-md-offset-2">
                                    <div id="urlerror" class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                        <input type="text" class="form-control" size=30 name="url" id="url" value="{{ old('url') }}"/>
                                    </div>
                                    <span id="urlerrhelp" class="help-block" style="display: none;">
                                        <!-- <strong>{{ $errors->first('url') }}</strong> -->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="container-fluid panel-container">
                                    <h3 class="panel-title col-md-5">Größe des Videos am Ende:</h3>
                                    <h3 class="panel-title col-md-5 col-md-offset-2">Zusatzinfos:</h3>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-5">
                                    <div style="margin-top: 15px;" class="form-group input-group row-group {{ $errors->has('limit') ? ' has-error' : '' }}">
                                        <div class="input-group-addon">1 - 30</div>
                                        <input type="number" id="limit" name="limit" min="1" max="30" value="{{ $errors->has('limit') ? old('url') : '6'}}" class="form-control"/>
                                        <div class="input-group-addon">MB</div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-md-offset-2">
                                    <div class="form-group">
                                        <label for="sound">
                                            Ton:
                                        </label>
                                        <input type="text" id="sound" value="{{ old('sound') }}" readonly style="background-color: #161618; border: 0px;">
                                        <input type="hidden" id="refsound" name="sound" value="{{ old('sound') }}">
                                        <div id="slider">

                                        </div>
                                        <div class="checkbox row">
                                            <label>
                                                <input name="autoResolution" type="checkbox" {{ old('autoResolution') ? 'checked' : '' }}> Auflösung beibehalten
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <input class="btn btn-danger" type="submit" value="Konvertieren">
                    </div>
                </div>
            </form>
        </div>
        <div class="container-fluid" id="full">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 text-center" id="progress">
                    <h2>lade hoch ...</h2>
                    <br>
                    <div class="progress">
                        <div id="upload_bar" class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                            0%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="status" style="display: none;"></div>
@endsection
