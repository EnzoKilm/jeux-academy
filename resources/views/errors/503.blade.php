@extends('errors::app-layout')

@section('title', __('Jeux Academy'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Service inaccessible'))
