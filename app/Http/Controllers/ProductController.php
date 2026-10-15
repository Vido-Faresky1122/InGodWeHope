<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Exit_;

class ProductController extends Controller
{
    private function getProducts()
    {
        //Ambil data
        $products = json_decode(file_get_contents(storage_path('\app\public\products.json')), true);
        $products = collect($products);

        return $products;

        //Balikin data
        file_put_contents(storage_path('\app\public\products.json'), json_encode($products, JSON_PRETTY_PRINT));

        ('Y-m-d H:i:s');
        //• Y = Tahun 4 digit (contoh: 2026)
        //• m = Bulan 2 digit (01-12)
        //• d = Tanggal 2 digit (01-31)
        //• H = Jam format 24-jam dengan nol (00-23)
        //• h = Jam format 12-jam dengan nol (01-12)
        // • i = Menit (00-59)
        // • s = Detik (00-59)
    }
    public function index()
    {
        $products = collect(session('result'));

        return view('index', [
            'products' => $products
        ]);
    }

    public function result()
    {
        $products = collect(session('result', []));

        $products = $products->map(function ($product) {
            $realPrice = $product['category'] == 'makanan' ? $product['price'] * 0.90 : $product['price'] * 0.95;
            $product['realPrice'] = $realPrice;
            return $product;
        });

        return view('result', [
            'products' => $products,

        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'code' => ['required'],
            'category' => ['required', 'string', 'in:makanan,minuman'],
            'name' => ['required', 'string', 'max:80'],
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg'],
            'price' => ['required', 'integer']
        ]);

        // $products = $this->getProducts();
        // $isProductExists = $products->where('code', $request->code);
        // if ($isProductExists) {
        //     abort(404, 'Kode sudah didafarkan');
        // }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('assets'), $fileName);
        }

        $result = collect(session()->get('result', []));

        $result[] = [
            'id' => $result->max('id') + 1 ?? 1,
            'category' => $request['category'],
            'name' => $request['name'],
            'image' => $fileName,
            'price' => $request['price'],
        ];

        session()->put('result', $result);

        return redirect()->route('result');
    }

    public function destroy($id)
    {
        $result = collect(session('result'))->where('id', '!=', $id);

        session()->put('result', $result);

        return redirect()->route('result');
    }


    public function edit(string $id)
    {
        $products = collect(session('result', []));

        $product = $products->firstWhere('id', $id);

        return view('edit', [
            'product' => $product
        ]);
    }

    public function update(Request $request, string $id)
    {
        $result = collect(session('result', []));

        $request->validate([
            'category' => ['required', 'string', 'in:makanan,minuman'],
            'name' => ['required', 'string', 'max:80'],
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg'],
            'price' => ['required', 'integer']
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('assets'), $fileName);
        }

        $result = $result->map(function ($product) use ($id, $request, $fileName) {
            if ($product['id'] == $id) {
                $product = [
                    'id' => $id,
                    'category' => $request['category'],
                    'name' => $request['name'],
                    'image' => $fileName,
                    'price' => $request['price'],
                ];
                return $product;
            }
        });

        session()->put('result', $result);

        return redirect()->route('result');
    }

}
