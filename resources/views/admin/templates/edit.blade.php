@extends('template.layout')

@section('title', 'Editing Item | Just Share Roofing Media')

@section('description', 'Editing template item')

@section('content')

@section('js_additional')
    <script>
        $(document).ready(function () {

        });

        $('#allUsers').click(function() {
            const allUsersSelected = $(this).is(':checked');
            if(allUsersSelected) {
                $('#usersList option').prop('selected', true);
                $('#userSelectionSection').hide();
            } else {
                $('#usersList option').prop('selected', false);
                $('#userSelectionSection').show();
            }
        })
    </script>
@endsection
<style>
    #allUsers {
        margin-left: 20px;
        margin-top: 3px;
    }
    #usersList {
        margin-left: 20px;
    }
</style>

    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-9">

                    <div class="heading-block border-0">
                        <h3><a href="{{route('admin.templates')}}">Templates</a> > Editing: {{ $data['template']->title }}</h3>
                        <span>Editing Template Item</span>
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
                            <i class="icon-exclamation-circle"></i>Template item updated successfully
                        </div>
                    @endif

                    <div class="row">
                        <div class="col">
                            <p>You are modifying an existing template item.</p>
{{--                            <p>Leave thumbnail selection empty to keep the current thumbnail. Thumbnails are best in--}}
{{--                                .JPG / .JPEG for their smaller file size to optimize page load speed.</p>--}}
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-8">

                            <h2>Template Item Fields</h2>

                            <form method="POST" action="{{route('admin.templates.patch', $data['template'])}}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col">
                                        <label for="title">Title</label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type='text'
                                                       name='title'
                                                       maxlength='255'
                                                       class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                                       placeholder='Item Title'
                                                       value="{{ $data['template']->title }}">

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
                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="image">Template: &nbsp;</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="file" id="image" name="template" class="file-loading @error('template') is-invalid @enderror" />

                                                @error('template')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-9">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label>Template available to:</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="">All users</label>
                                                <input type="checkbox" id="allUsers" {!! count($data['assignedUsers']) == 0 ? 'checked' : '' !!} >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="userSelectionSection" style="display: {!! count($data['assignedUsers']) == 0 ? 'none' : 'block' !!}">
                                    <div class="col-9">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="">Users from the list</label>
                                                <select id="usersList" name="users[]" multiple>
                                                    @foreach($data['allUsers'] as $user)
                                                        <option
                                                            {!! in_array($user->id, $data['assignedUsers']) || count($data['assignedUsers']) == 0 ? 'selected' : '' !!}
                                                            value="{{ $user->id }}">{{ $user->email }}</option>
                                                    @endforeach
                                                </select>

                                                @error('users')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
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
                            <h4>Current Template</h4>
                            <p><img src='{{ Storage::url($data['template']->path) }}' width='200px'/></p>
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
