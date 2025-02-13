@extends('layouts.forms')

@section('title', __('User Permissions'))

@section('form')
    {{ forms()->create('permissions.users', $model ?? null) }}
    <div>
        <label for="">{{ __('Name')  }}:</label> {{ $model->name }}
    </div>
    <div>
        <label for="">{{ __('Email')  }}:</label> {{ $model->email }}
    </div>
    {{ forms()->field('Roles', 'roles', 'checkboxes', null, role_dropdown_options()) }}
    {{ forms()->submit('Save')  }}
    {{ forms()->end() }}
@endsection
