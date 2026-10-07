@extends('layouts.app')
@section('title', 'ویرایش پروژه')
@section('page_title', 'ویرایش پروژه')
@section('content')
@livewire('project.project-form', ['project' => $project])
@endsection
