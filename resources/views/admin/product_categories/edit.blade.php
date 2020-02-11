@extends('layouts.admin', ['page_title' => $product_category->title])

@section('content')

    <section id="content">
        <form action="{{ route('admin.product_categories.update', $product_category) }}" method="post">
            @csrf
            @method('patch')
            <block-editor title="{{ $product_category->title}}">
                @foreach(config('app.locales') as $lang)
                    <fieldset slot="{{ $lang }}">
                        <div class="form-group{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}">
                            <label for="title">Название категории</label>
                            <input type="text" id="title" name="{{$lang}}[title]"
                                   class="form-control{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}"
                                   value="{{ old($lang.'.title') ?? $product_category->getTranslation('title', $lang) }}"
                                   required>
                            @if($errors->has($lang.'.title'))
                                <div class="mt-1 text-danger">
                                    {{ $errors->first($lang.'.title') }}
                                </div>
                            @endif
                        </div>
                    </fieldset>
                @endforeach
            </block-editor>
            <div class="mt-3">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
