@extends('template.layout')

@section('title', 'Editing Item | Just Share Roofing Media')

@section('description', 'Editing gallery item')

@section('js_additional')
    <script>
        $(document).ready(function () {
            // Handler for .ready() called.
            $('html, body').animate({
                scrollTop: $('#galleryitems').offset().top
            }, 'slow');
        });
    </script>
    <script async
            src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.key')}}&libraries=places">
    </script>
    <script>
        let idNumber = {!! count($item->prohibitedLocations) ? max($item->prohibitedLocations->pluck('id')->toArray()) + 1 : 1 !!}
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

        $(document).ready(function () {
            @foreach($item->prohibitedLocations as $location)
                initAutocompleteAddress('prohibitedAddress' + {{$location->id}})
            @endforeach
        })
    </script>
@endsection

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-9">

                    <div class="heading-block border-0">
                        <h3><a href="{{route('admin.gallery')}}">Gallery</a> > Editing: {{ $item->title }}</h3>
                        <span>Editing Gallery Item</span>
                    </div>

                    <div class="clear"></div>

                    @if (! $errors->isEmpty())
                        <div class="alert alert-danger">
                            <i class="icon-exclamation-circle"></i><strong>Sorry!</strong> An error occurred with your
                            request. Please check your fields and try again.
                            <br/>
                            @foreach ($errors->all() as $error)
                                <br/> {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="icon-exclamation-circle"></i>Gallery item updated successfully
                        </div>
                    @endif

                    <div class="row">
                        <div class="col">
                            <p>You are modifying an existing gallery item.</p>
                            <p>Leave thumbnail selection empty to keep the current thumbnail. Thumbnails are best in
                                .JPG / .JPEG for their smaller file size to optimize page load speed.</p>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-8">

                            <h2>Gallery Item Fields</h2>

                            <form method="POST" action="{{route('admin.gallery.patch', $item)}}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <div class="input-group">
                                                <input type='text'
                                                       name='title'
                                                       id='title'
                                                       maxlength='255'
                                                       class="form-control @error('title') is-invalid @enderror"
                                                       placeholder='Item Title'
                                                       value="{{ old('title') ? old('title') : $item->title }}"/>
                                                @error('title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="title">Shingle type</label>
                                            <div class="input-group">
                                                <input type='text'
                                                       name='shingle_type'
                                                       id='shingle_type'
                                                       maxlength='255'
                                                       class="form-control @error('shingle_type') is-invalid @enderror"
                                                       placeholder='Shingle type'
                                                       value="{{ old('shingle_type') ? old('shingle_type') : $item->shingle_type }}"/>

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
                                                <label for="title_video">Title video: &nbsp;</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="file" id="title_video" name="title_video"
                                                       class="file-loading @error('title_video') is-invalid @enderror"/>

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
                                                <input type="file" id="big_video" name="big_video"
                                                       class="file-loading @error('big_video') is-invalid @enderror"/>

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
                                                <input type="file" id="small_video" name="small_video"
                                                       class="file-loading @error('small_video') is-invalid @enderror"/>

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
                                                <input type="file" id="thumbnail" name="thumbnail"
                                                       class="file-loading @error('thumbnail') is-invalid @enderror"/>

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
                                                <input type="checkbox" name="public" id="public" class="switch-input"
                                                       value="1" {{ $item->public ? 'checked="checked"' : '' }}/>
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
                                        <div class="row prohibitedLocations mb-2">
                                            @foreach($item->prohibitedLocations as $location)
                                            <div class="col-12 mb-2">
                                                <input id="prohibitedAddress{{$location->id}}" type="text" style="width: 100%" value="{{$location->name}}" class="existingAutocomplete" name="prohibitedLocations[]">
                                                <div class="removeProhibitedAddress" style="cursor: pointer; font-size: 12px">Remove</div>
                                                <input type="hidden" value="{{$location->lat}}" name="prohibited[lat][]" class="lat">
                                                <input type="hidden" value="{{$location->lng}}" name="prohibited[lng][]" class="lng">
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div id="addProhibitedLocation" class="btn btn-info">Add Prohibited Location</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col form-group text-center">
                                    <button class="button button-3d m-0" type="submit" id="submit" name="submit"
                                            value="submit">Save
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-4">
                            <h4>Current Thumbnail</h4>
                            <p><img src='{{ $item->galleryUrl('thumbnail') }}' width='200px'/></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div id='galleryitems' class="section m-0 bg-transparent">
                                <div class='row'>
                                    <div class='col'>
                                        <h4>Title Video</h4>
                                        <div class="grid-inner">
                                            <div class="portfolio-image">
                                                <a href="#">
                                                    <img src="{{asset('/assets/images/video.png')}}" alt="{{ $item->title }}">
                                                </a>
                                                <div class="bg-overlay">
                                                    <div class="bg-overlay-content dark" data-hover-animate="fadeIn">
                                                        <a href="{{ $item->galleryUrl('title_video') }}"
                                                           class="overlay-trigger-icon bg-light text-dark"
                                                           data-hover-animate="fadeInDownSmall"
                                                           data-hover-animate-out="fadeOutUpSmall"
                                                           data-hover-speed="350" data-lightbox="iframe"><i
                                                                class="icon-line-play"></i></a>
                                                    </div>
                                                    <div class="bg-overlay-bg dark" data-hover-animate="fadeIn"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col'>
                                        <h4>Video 16x9</h4>
                                        <div class="grid-inner">
                                            <div class="portfolio-image">
                                                <a href="#">
                                                    <img src="{{asset('/assets/images/video.png')}}" alt="{{ $item->title }}">
                                                </a>
                                                <div class="bg-overlay">
                                                    <div class="bg-overlay-content dark" data-hover-animate="fadeIn">
                                                        <a href="{{ $item->galleryUrl('big_video') }}"
                                                           class="overlay-trigger-icon bg-light text-dark"
                                                           data-hover-animate="fadeInDownSmall"
                                                           data-hover-animate-out="fadeOutUpSmall"
                                                           data-hover-speed="350" data-lightbox="iframe"><i
                                                                class="icon-line-play"></i></a>
                                                    </div>
                                                    <div class="bg-overlay-bg dark" data-hover-animate="fadeIn"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col'>
                                        <h4>Video 1x1</h4>
                                        <div class="grid-inner">
                                            <div class="portfolio-image">
                                                <a href="#">
                                                    <img src="{{asset('/assets/images/video.png')}}" alt="{{ $item->title }}">
                                                </a>
                                                <div class="bg-overlay">
                                                    <div class="bg-overlay-content dark" data-hover-animate="fadeIn">
                                                        <a href="{{ $item->galleryUrl('small_video') }}"
                                                           class="overlay-trigger-icon bg-light text-dark"
                                                           data-hover-animate="fadeInDownSmall"
                                                           data-hover-animate-out="fadeOutUpSmall"
                                                           data-hover-speed="350" data-lightbox="iframe"><i
                                                                class="icon-line-play"></i></a>
                                                    </div>
                                                    <div class="bg-overlay-bg dark" data-hover-animate="fadeIn"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
