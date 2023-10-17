@extends('template.layout')

@section('title', 'Adding Gallery Item | Just Share Roofing Media')

@section('description', 'Adding a new gallery item')

{{-- @section('css_additional')
    <link rel="stylesheet" href="/assets/css/components/bs-filestyle.css" type="text/css" />
@endsection--}}

@section('js_additional')
    <script async
            src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.key')}}&libraries=places">
    </script>
    <script>
        let idNumber = 1
        $('#addProhibitedLocation').click(function() {
            idNumber = idNumber + 1
            const id = 'prohibitedAddress' + idNumber
            const newLocation = `
                <div class="col-12 mb-2">
                    <input id="${id}" type="text" style="width: 100%" name="prohibitedLocations[]">
                    <div class="removeProhibitedAddress" style="cursor: pointer; font-size: 12px">Remove</div>
                    <input type="hidden" name="prohibited[lat][]" class="lat">
                    <input type="hidden" name="prohibited[lng][]" class="lng">
               </div>`
            $('.prohibitedLocations').append(newLocation)
            initAutocompleteAddress(id)
        })

        $(document).on('click', '.removeProhibitedAddress', function() {
            $(this).parent().remove()
        })

        function initAutocompleteAddress(id) {
            let element = document.getElementById(id)
            let autocomplete = new google.maps.places.Autocomplete(element, {
                componentRestrictions: { country: ["us"] },
                fields: ["address_components", "geometry"],
                types: ["address"],
            });
            autocomplete.addListener("place_changed", function () {
                let place = autocomplete.getPlace();
                $('#'+id).parent().children('.lat').val(place.geometry.location.lat())
                $('#'+id).parent().children('.lng').val(place.geometry.location.lng())
            });
        }
    </script>
@endsection

@section('content')

<div class="content-wrap">
    <div class="container clearfix">

        <div class="row clearfix">

            <div class="col-md-9">

                <div class="heading-block border-0">
                    <h3><a href="{{route('admin.gallery')}}">Gallery</a> > Adding New Item</h3>
                    <span>Adding a Gallery Item</span>
                </div>

                <div class="clear"></div>

                @if (! $errors->isEmpty())
                    <div class="alert alert-danger">
                        <i class="icon-exclamation-circle"></i><strong>Sorry!</strong> An error occurred with your request. Please check your fields and try again.
                        <br/>
                        @foreach ($errors->all() as $error)
                            <br/> {{ $error }}
                        @endforeach
                    </div>
                @endif

                <div class="row">
                    <div class="col">
                        <p>You are adding a new gallery item.</p>
                        <p>Thumbnails are best in .JPG / .JPEG for their smaller file size to optimize page load speed.</p>
                    </div>
                </div>

                <div class="row clearfix">

                    <div class="col">

                        <h2>Gallery Item Fields</h2>

                        <form method="POST" action="{{route('admin.gallery.post')}}" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type='text'
                                                name='title'
                                                maxlength='255'
                                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                                placeholder='Item Title'
                                                value="{{ old('title') }}">

                                            @if ($errors->has('title'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('title') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type='text'
                                                name='shingle_type'
                                                maxlength='255'
                                                class="form-control @error('shingle_type') is-invalid @enderror"
                                                placeholder='Shingle type'
                                                value="{{ old('shingle_type') }}">

                                            @error('shingle_type')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="title_image">Square Thumbnail: &nbsp;</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="file" id="title_image" name="title_image" class="file-loading @error('title_image') is-invalid @enderror" />

                                            @error('title_image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="title_video">Watermarked Video: &nbsp;</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="file" id="title_video" name="title_video" class="file-loading @error('title_video') is-invalid @enderror" />

                                            @error('title_video')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="big_video">Video format 16x9: &nbsp;</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="file" id="big_video" name="big_video" class="file-loading @error('big_video') is-invalid @enderror" />

                                            @error('big_video')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="small_video">Video format 1x1: &nbsp;</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="file" id="small_video" name="small_video" class="file-loading @error('small_video') is-invalid @enderror" />

                                            @error('small_video')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="thumbnail">Thumbnail: &nbsp;</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="file" id="thumbnail" name="thumbnail" class="file-loading @error('thumbnail') is-invalid @enderror" />

                                            @error('thumbnail')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="public">Public video: &nbsp;</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="checkbox" name="public" id="public" class="switch-input" value="1" {{ old('public') ? 'checked="checked"' : '' }}/>

                                            @error('public')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row prohibitedLocations mb-2"></div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="addProhibitedLocation" class="btn btn-info">Add Prohibited Location</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col form-group text-center">
                                <button class="button button-3d m-0" type="submit" id="submit" name="submit" value="submit">Add Gallery Item</button>
                            </div>
                        </form>

                    </div>

                </div>

            </div>

            <div class="w-100 line d-block d-md-none"></div>

            <div class="col-md-3">

                <x-dashboard-menu/>

            </div>

        </div>

    </div>
</div>

@endsection
