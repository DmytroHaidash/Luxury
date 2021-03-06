<header class="app-header">
    <div class="logo">
        <a href="{{ url('/') }}">
            <img src="/images/LWC.png" alt="" width="160" height="82">

        </a>
    </div>

    <nav class="px-6 flex-1 app-nav">
        <a href="#" class="app-nav__close" data-close-nav>
            <svg width="24" height="24" class="fill-current">
                <use xlink:href="#close"></use>
            </svg>
        </a>
        <ul class="nav list-reset -mx-4">
            @foreach(app('nav')->header() as $nav)
                <li class="nav-item px-4">
                    <a href="{{ $nav->link ?? '#' }}" class="font-bold uppercase tracking-widest">
                        {{ $nav->name }}
                    </a>

                    @if (isset($nav->submenu) && count($nav->submenu))
                        <a href="{{ $nav->link ?? '#' }}" class="font-bold uppercase tracking-widest">
                            <svg width="12" height="11" class="fill-current ml-2 -mt-px inline-flex">
                                <use xlink:href="#caret"></use>
                            </svg>
                        </a>

                        <div class="submenu leading-tight" style="display: none">
                            <ul class="list-reset">
                                @foreach($nav->submenu as $item)
                                    @if (!$loop->first)
                                        <li class="my-3">
                                            <hr class="border-b border-white opacity-25">
                                        </li>
                                    @endif
                                    <li class="my-1">
                                        <a href="{{ $item->link }}" class="font-bold">{{ $item->name }}</a>

                                        @if (isset($item->children) && count($item->children))
                                            <ul class="list-unstyled">
                                                @foreach($item->children as $child)
                                                    <li class="my-1">
                                                        <a href="{{ $child->link }}">{{ $child->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="w-20 lg:w-10 flex items-center ml-auto">
        {{--<div class="language-switcher px-3 ml-auto">
            {{ app()->getLocale() }}

            @php
                $locales = collect(config('app.locales'))->filter(function ($locale) {
                    return $locale != app()->getLocale();
                });
            @endphp

            <ul>
                @foreach($locales as $locale)
                    <li>
                        <a href="{{ url('/'.$locale) }}">{{ $locale }}</a>
                    </li>
                @endforeach
            </ul>
        </div>--}}
        <div class="toggle-nav mr-4">
            <a href="#" data-toggle-nav>
                <svg width="24" height="24" class="fill-current">
                    <use xlink:href="#nav"></use>
                </svg>
            </a>
        </div>
        <div class="search">
            <a href="#" data-show-search>
                <svg width="24" height="24" class="fill-current">
                    <use xlink:href="#search"></use>
                </svg>
            </a>
        </div>

    </div>

    <form action="{{ route('client.search.index') }}" method="get"
          class="search-panel absolute inset-x-0 top-0 flex items-center p-4 bg-gray-900 z-50"
          style="display: none">
        <input type="search" name="search" class="form-control text-lg h-12" autocomplete="nope"
               placeholder="{{ __('common.header.search') }}"
               value="{{ old('search') ?? $query ?? null }}">

        <button class="button button--primary h-12">
            <svg width="24" height="24" class="fill-current">
                <use xlink:href="#search"></use>
            </svg>
        </button>
    </form>
</header>
