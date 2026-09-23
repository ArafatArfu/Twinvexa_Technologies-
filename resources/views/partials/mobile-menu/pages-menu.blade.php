@php
    $aboutPage = \App\Models\StaticPage::active()->where('slug', 'about')->first();
    $contactPage = \App\Models\StaticPage::active()->where('slug', 'contact')->first();
    $faqPage = \App\Models\StaticPage::active()->where('slug', 'faq')->first();
@endphp

<li>
    <a href="#">Pages</a>
    <ul>
        <li>
            <a href="{{ $aboutPage ? route('pages.show', $aboutPage->slug) : '#' }}">About</a>
        </li>
        <li>
            <a href="{{ $contactPage ? route('pages.show', $contactPage->slug) : '#' }}">Contact</a>
        </li>
        <li><a href="{{ route('login') }}">Login</a></li>
        <li><a href="{{ $faqPage ? route('pages.show', $faqPage->slug) : '#' }}">FAQs</a></li>
        <li><a href="{{ route('errors.404.page') }}">Error 404</a></li>
    </ul>
</li>
