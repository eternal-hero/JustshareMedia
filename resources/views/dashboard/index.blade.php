@extends('template.layout')

@section('title', 'Dashboard | ' . config('app.name'))

@section('description', 'Your account and settings')

@section('content')

<div class="content-wrap">
    <div class="container clearfix">
        <div class="row clearfix">
            <div class="col-md-9">
                <div class="heading-block border-0">
                    <h3>{{ $user->email }}</h3>
                    <span>Welcome to your account <b>{{$user->first_name . ' ' . $user->last_name}}</b>!</span>
                    @if($subscription->status == 'canceled')
                        <span>Your subscription is canceled, reactivate it <a href="{{ route('subscriptions.reactivate') }}">here</a></span>
                    @endif
                </div>
                <div class="clear"></div>
                <div class="row clearfix">
                    <div class="col-lg-6">
                        <p>Email: <b>{{$user->email}}</b></p>
                        <div class="additionalEmails">
                            @foreach($additionalEmails as $email)
                            <p id="email-id-{{ $email->id }}">Additional Email: <b>{{ $email->email }}</b><span class="deleteEmail">Remove</span></p>
                            @endforeach
                        </div>
                        <div class="newEmailPlaceholder">
                            <input type="email" class="newEmail" placeholder="Email">
                            <div class="saveNewEmail">Save</div>
                            <div class="cancelNewEmail">Cancel</div>
                        </div>
                        <div class="addEmailPlaceholderTrigger">+ Add Email</div>
                        <p>Company <b>{{$user->company}}</b></p>
                        <p>Address Line 1 <b>{{$user->address}}</b></p>
                        <p>Address Line 2 <b>{{$user->address2}}</b></p>
                        <p>City <b>{{$user->city}}</b></p>
                        <p>State <b>{{$user->state}}</b></p>
                        <p>Zip <b>{{$user->zip}}</b></p>
                    </div>
                    <div class="col-lg-6">
{{--                        <p>Facebook <b>{{$user->social_facebook}}</b></p>--}}
{{--                        <p>Twitter <b>{{$user->social_twitter}}</b></p>--}}
{{--                        <p>Instagram <b>{{$user->social_instagram}}</b></p>--}}
                        <p>Subscription Start Date: <b>{{ $subscription->created_at->format('M d Y') }}</b></p>
                        <p>License Renewal Day <b>{{$renewalDate->format('M d Y')}}</b></p>
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

<div class="deleteEmailConfirmationWrapper">
    <div class="deleteEmailConfirmation">
        <div class="deleteEmailConfirmation-title">Are you sure?</div>
        <div class="deleteEmailConfirmation-text">If you delete this email we will not send reminders to it.</div>
        <div class="deleteEmailConfirmation-btns">
            <div class="deleteEmailConfirmation-confirm-btn">Yes</div>
            <div class="deleteEmailConfirmation-cancel-btn">No</div>
        </div>
    </div>
</div>

@endsection

@section('js_additional')
    <script>
        function validateEmail(email)
        {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        }
        $(document).ready(function () {
            let isEmailAddingNow = false;
            let emailToDelete = false;

            $('.deleteEmailConfirmation-cancel-btn').click(function() {
                $('.deleteEmailConfirmationWrapper').css('display', 'none');
                emailToDelete = false
            })

            $('.deleteEmailConfirmation-confirm-btn').click(function() {
                if( $('.deleteEmailConfirmation-confirm-btn').html() != 'Deleting') {
                    $('.deleteEmailConfirmation-confirm-btn').html('Deleting')
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        type: "DELETE",
                        url: '{{ route('additional-emails.delete') }}',
                        data: {
                            email: emailToDelete
                        },
                        success: function(resp) {
                            $('.deleteEmailConfirmationWrapper').css('display', 'none');
                            $('#email-id-' + emailToDelete).remove();
                            emailToDelete = false
                            $('.deleteEmailConfirmation-confirm-btn').html('Yes')
                        },
                    }).fail(function() {
                        $('.deleteEmailConfirmationWrapper').css('display', 'none');
                    });
                }
            })

            $('.addEmailPlaceholderTrigger').click(function() {
                if(!isEmailAddingNow) {
                    $('.newEmailPlaceholder').css('display', 'flex');
                    $('.newEmail').val('')
                    $('.addEmailPlaceholderTrigger').css('cursor', 'not-allowed')
                    isEmailAddingNow = true;
                }
            });
            $('.cancelNewEmail').click(function () {
                $('.newEmailPlaceholder').css('display', 'none');
                isEmailAddingNow = false;
                $('.addEmailPlaceholderTrigger').css('cursor', 'pointer')
            });
            $('.saveNewEmail').click(function() {
                if($('.saveNewEmail').html() != 'Please wait'){
                    if(validateEmail($('.newEmail').val())) {
                        $('.saveNewEmail').html('Please wait')
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: "POST",
                            url: '{{ route('additional-emails.add') }}',
                            data: {
                                email: $('.newEmail').val()
                            },
                            success: function(resp) {
                                $('.saveNewEmail').html('Save')
                                $('.newEmailPlaceholder').css('display', 'none');
                                isEmailAddingNow = false;
                                $('.additionalEmails').append(`<p id="email-id-${resp.id}">Additional Email: <b>${resp.email}</b><span class="deleteEmail">Remove</span></p>`)
                                $('.addEmailPlaceholderTrigger').css('cursor', 'pointer')
                            },
                        }).fail(function() {
                            console.log('failed')
                        });
                    } else {

                    }
                }
            });
            $(document).on('click', '.deleteEmail', function() {
                emailToDelete = $(this).parent().attr('id').replace('email-id-', '');
                $('.deleteEmailConfirmationWrapper').css('display', 'flex')
            })
        })
    </script>
@endsection

@section('css_additional')
    <style>
        .deleteEmailConfirmationWrapper {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            background: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            z-index: 9999;
        }

        .deleteEmailConfirmation {
            width: 300px;
            display: flex;
            flex-direction: column;
            background: white;
            padding: 30px;
        }

        .deleteEmailConfirmation-title {
            font-size: 34px;
            text-align: center;
            margin-bottom: 20px;
        }

        .deleteEmailConfirmation-text {
            text-align: center;
        }

        .deleteEmailConfirmation-btns {
            display: flex;
            justify-content: space-evenly;
            margin-top: 30px;
        }

        .deleteEmailConfirmation-btns div {
            flex: 1;
            text-align: center;
        }

        .deleteEmailConfirmation-confirm-btn {
            border: solid 1px red;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 30px;
        }

        .deleteEmailConfirmation-cancel-btn {
            border: solid 1px black;
            border-radius: 4px;
            cursor: pointer;
        }

        .addEmailPlaceholderTrigger {
            text-align: center;
            border: solid 1px black;
            padding: 5px;
            border-radius: 4px;
            margin-bottom: 25px;
            cursor: pointer;
        }
        .newEmailPlaceholder {
            display: none;
            margin-bottom: 25px;
        }
        .newEmail {
            flex: 2;
            margin-right: 5px;
        }
        .saveNewEmail {
            flex: 1;
            text-align: center;
            border: solid 1px black;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }
        .cancelNewEmail {
            flex: 1;
            text-align: center;
            border: solid 1px red;
            border-radius: 4px;
            cursor: pointer;
        }
        .additionalEmails p {
            display: flex;
        }
        .deleteEmail {
            font-size: 12px;
            cursor: pointer;
            color: red;
            margin-left: auto;
        }
    </style>
@endsection
