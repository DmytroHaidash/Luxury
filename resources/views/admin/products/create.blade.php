@extends('layouts.admin', ['page_title' => 'Новый товар'])

@section('content')

    <section id="content">
        <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-9">
                    <block-editor title="Новый товар">
                        @foreach(config('app.locales') as $lang)
                            <fieldset slot="{{ $lang }}">
                                <div class="form-group{{ $errors->has($lang.'.title') ? ' is-invalid' : '' }}">
                                    <label for="title">Название товара</label>
                                    <input type="text" class="form-control" id="title" name="{{$lang}}[title]"
                                           value="{{ old($lang.'.title') }}"
                                           required>
                                    @if($errors->has($lang.'.title'))
                                        <div class="mt-1 text-danger">
                                            {{ $errors->first($lang.'.title') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="description">Краткое описание товара</label>
                                    <input type="text" class="form-control" id="description"
                                           name="{{$lang}}[description]" value="{{ old($lang.'.description') }}">
                                </div>

                                <label>Полное описание товара</label>
                                <wysiwyg name="{{$lang}}[body]" class="mb-0"
                                         content="{{ old($lang.'.body') }}"></wysiwyg>
                            </fieldset>
                        @endforeach
                    </block-editor>
                    @includeIf('partials.admin.meta', ['meta' => null])
                    <multi-uploader class="mt-4"></multi-uploader>
                </div>

                <div class="col-lg-3">
                    <div class="form-group{{ $errors->has('price') ? ' is-invalid' : '' }}">
                        <label for="price">Цена</label>
                        <input type="number" min="0.01" step="0.01" class="form-control" id="price" name="price"
                               value="{{ old('price') }}" required>
                        @if($errors->has('price'))
                            <div class="mt-1 text-danger">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="section">Категория</label>
                        <ul class="list-unstyled">
                            @foreach($categories as $section)
                                <li>
                                    <div class="custom-control custom-checkbox">
                                            {{ $section->title }}
                                    </div>
                                </li>

                                @if ($section->children->count())
                                    @foreach($section->children as $child)
                                        <li class="ml-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                       id="category-{{$child->id}}" name="categories[]"
                                                       value="{{ $child->id }}">
                                                <label class="custom-control-label" for="category-{{$child->id}}">
                                                    {{ $child->title }}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    </div>
                   {{-- <div class="form-group">
                        @if ($categories->count())
                            <label>Категории</label>
                            <div class="d-flex flex-wrap">
                                @foreach($categories as $category)
                                    <div class="border py-1 px-2 mr-3 mb-2 rounded">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                   id="category-{{ $category->id }}" name="categories[]"
                                                   value="{{ $category->id }}">
                                            <label class="custom-control-label"
                                                   for="category-{{ $category->id }}">
                                                {{ $category->translate('title') }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>--}}
                </div>
            </div>

            <div class="form-group my-4">
                <div class="custom-control custom-checkbox ml-3">
                    <input type="checkbox" class="custom-control-input"
                           id="stock" name="in_stock" checked>
                    <label class="custom-control-label" for="stock">Есть в наличии</label>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <button class="btn btn-primary">Сохранить</button>

                <div class="custom-control custom-checkbox ml-3">
                    <input type="checkbox" class="custom-control-input"
                           id="published" name="is_published" checked>
                    <label class="custom-control-label" for="published">Опубликовать</label>
                </div>
            </div>
        </form>
    </section>

@endsection
