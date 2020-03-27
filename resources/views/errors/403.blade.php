@extends('errors::minimal')

@section('title', __('Jeux Academy'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Interdit'))
