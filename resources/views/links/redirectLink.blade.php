<!DOCTYPE html>
<html>
<head>
    {{-- title yielded here --}}
    <title>Magints QR Menus Scanner</title>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-175216814-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-175216814-1');

    </script>
</head>
<body>
    @if(strlen($link->url) > 0 && strlen($link->file) == 0)
    <script>
        window.location.href = "{{ $link->url }}";

    </script>
    @else
    <script>
        window.location.href = "{{asset('assets/files/uploadedFiles/'). '/'. $link->file}}";

    </script>
    @endif
</body>
</html>
