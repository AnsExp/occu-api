<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<body>
    {{ request()->ip() }}
</body>

</html>