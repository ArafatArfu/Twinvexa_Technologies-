<footer class="footer">
    @php
        use App\Models\FooterSetting;
        use App\Models\FooterLink;
        $footerSettings = FooterSetting::first();
        $footerLinks = FooterLink::active()->ordered()->get()->groupBy('column_type');
    @endphp

    @include('partials.footer.cta')
    @include('partials.footer.widgets')
    @include('partials.footer.bottom')
</footer>
