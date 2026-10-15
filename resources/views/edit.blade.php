<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Edit Product</title>
    @vite('resources/css/app.css', 'resources/js/app.js')
</head>

<body>
    <div class="flex justify-center items-center h-screen">

        <form action="{{ route('update', ['id' => $product['id']]) }}" method="POST" enctype="multipart/form-data"
    
            class="border border-blue-700 rounded-md bg-blue-200 px-10 py-20 grid gap-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1">
                <label class="font-bold" for="category">Kategori</label>
                <select class="border rounded-sm py-2 bg-white" name="category" id="">
                    <option value="">Pilih Kategori</option>
                    <option @selected($product['category'] === 'makanan')  value="makanan">Makanan</option>
                    <option @selected($product['category'] === 'minuman') value="minuman">Minuman</option>
                </select>
                @error('category')
                    <p class="text-red-500"> {{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-1">
                <label class="font-bold" for="name">Nama Barang</label>
                <input class="border rounded-sm py-2 bg-white" name="name" type="text" value="{{ $product['name'] }}">
                @error('name')
                    <p class="text-red-500"> {{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-1">
                <label class="font-bold" for="image">Gambar</label>
                <input class="border rounded-sm py-2 bg-white" name="image" type="file" accept="image/*" value="{{ $product['image'] }}">
                @error('image')
                    <p class="text-red-500"> {{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-1">
                <label class="font-bold" for="price">Harga</label>
                <input class="border rounded-sm py-2 bg-white" name="price" type="text" value="{{ $product['price'] }}" >
                @error('price')
                    <p class="text-red-500"> {{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="border rounded-sm py-2 bg-white cursor-pointer" >
                Submit
            </button>
        </form>
    </div>
</body>

</html>