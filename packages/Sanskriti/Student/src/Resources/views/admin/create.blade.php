@extends('admin::layouts.master')

@section('page_title')
    Add Student
@stop

@section('content-wrapper')
    <div class="content full-page dashboard">
        <form method="POST" action="{{ route('admin.cms.store') }}" @submit.prevent="onSubmit">
            @csrf

            <div class="page-header">
                <div class="page-title">
                    <h1>Student</h1>
                </div>

                <div class="page-action fixed-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.cms.pages.create-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                        <label for="name" class="required">{{ __('admin::app.name') }}</label>

                        <input type="text" class="control" name="name" v-validate="'required'" value="{{ old('name') }}" data-vv-as="&quot;{{ __('admin::app.cms.pages.page-title') }}&quot;">

                        <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('code') ? 'has-error' : '']">
                        <label for="url-key" class="required">{{ __('admin::app.code') }}</label>

                        <input type="text" class="control" name="code" v-validate="'required'" value="{{ old('code') }}" data-vv-as="&quot;{{ __('admin::app.code') }}&quot;" v-slugify>

                        <span class="control-error" v-if="errors.has('code')">@{{ errors.first('code') }}</span>
                    </div>
                </div>
            </div>
        </form>
    </div>

@stop