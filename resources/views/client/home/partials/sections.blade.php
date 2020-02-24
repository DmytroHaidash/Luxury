<section>
    @foreach($sections as $section)

    @if ($section->children->count())
            <h2 class="text-center text-3xl my-12 relative z-20 font-heading title--decorated">
                <span>{{ $section->title }}</span>
                {{--<div class="title-decoration inset-x-0 mx-auto w-40 h-16"></div>--}}
            </h2>


            <div class="flex flex-wrap">
                @foreach($section->children as $child)
                    <article class="teaser section-teaser w-full lg:flex-1">
                        <figure class="lozad teaser__thumbnail"
                                data-background-image="{{ $child->getThumb() }}"></figure>

                        <a class="teaser__link p-6 lg:p-10"
                           href="{{ route('client.catalog.index', ['category'=> $child->slug]) }}">
                            <div class="teaser__title">
                                <h4 class="text-3xl title title--striped">
                                    <span>{{ $child->title }}</span>
                                </h4>
                            </div>

                            {{--@if ($child->hasTranslation('description'))
                                <div class="teaser__description mt-3 px-6 lg:px-10">
                                    {{ Str::limit($child->description, 150) }}
                                </div>
                            @endif--}}
                        </a>
                    </article>
                @endforeach
            </div>
        @endif
    @endforeach
</section>