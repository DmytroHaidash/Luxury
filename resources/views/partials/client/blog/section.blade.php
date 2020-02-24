<section class="pb-5 lg:pb-10">
    <h2 class="text-center text-3xl my-12 relative z-20 relative font-heading title--decorated">
        <span class="title-decoration">{{ __('nav.blog') }}</span>
    </h2>

    <div class="flex flex-wrap">
        @each('partials.client.blog.teaser', $posts, 'blogPost')
    </div>

    <div class="container text-center mt-8">
        <a href="{{ route('client.blog.index') }}"
           class="button button--primary">{{ __('pages.blog.all') }}</a>
    </div>
</section>