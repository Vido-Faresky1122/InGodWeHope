<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    @vite('resources/css/app.css', 'resources/js/app.js')
</head>

<body>

    <div class="grid grid-cols-3 gap-10">
        @foreach ($products as $product)
            @if ($product != null)
                <li>
                    <ul>{{ $product['category'] }}</ul>
                    <ul><img class="w-30" src="{{ asset('assets/' . $product['image']) }}" alt="Foto"></ul>
                    <ul>{{ $product['name'] }}</ul>
                    <ul>{{ $product['realPrice'] }}</ul>
                    <ul>
                        <form action="{{ route('destroy', $product['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </ul>
                    <ul>
                        <a href="{{ route('edit', ['id' => $product['id']]) }}"><button type="submit">Edit</button></a>
                    </ul>
                </li>
            @endif
        @endforeach
    </div>
</body>

</html>