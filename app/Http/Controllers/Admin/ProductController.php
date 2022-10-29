<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchProductQty;
use App\Models\Category;
use App\Models\Language;
use App\Models\Permession;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Traits\File;
use App\Traits\Res;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;
use Mpdf\Mpdf;

class ProductController extends Controller
{
    use File, Res;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('products.index');
        Carbon::setLocale(app()->getLocale());
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin' || Auth::user()->role_type == 'online') {
            $categories = Category::latest()->get();
            $products = Product::latest();
        } else {
            $categories = Category::whereHas('branches', function($query) {
                return $query->where('branch_id', Auth::user()->branch_id);
            })->get();
            $categories_ids = $categories->pluck('id');
            $products = Product::whereHas('categories', function($query) use($categories_ids) {
                return $query->whereIn('category_id', $categories_ids);
            })->latest();
        }
        if($request->name) {
            $products->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->description) {
            $products->where('description', 'like', '%' . $request->description . '%');
        }
        if($request->price) {
            $products->where('price', 'like', '%' . $request->price . '%');
        }

        if($request->category_id) {
            $products = $products->whereHas('categories', function($query) use($request) {
                return $query->where('category_id', $request->category_id);
            });
        }
        if($request->viewed_number) {
            $products->where('viewed_number', 'like', '%' . $request->viewed_number . '%');
        }
        if($request->discount) {
            $products->where('discount', 'like', '%' . $request->discount . '%');
        }
        if($request->active) {
            if($request->active == 'true') {
                $products->where('active', 1);
            } else {
                $products->where('active', 0);
            }
        }
        if($request->price_after_discount) {
            $products->where('price_after_discount', 'like', '%' . $request->price_after_discount . '%');
        }
        if($request->start && $request->end) {
            $start = date('Y-m-d', strtotime($request->start));
            $end = date('Y-m-d', strtotime($request->end));
            $products
            ->whereDate('created_at', '=', $start)
            ->whereDate('created_at', '<=', $end);
        }
        if($request->barcode == 'true') {
            $products = $products->with('variants')->get();

            $currenctLang = Language::where('regional','like', '%' . app()->getLocale() . '%')->first();
            Carbon::setLocale(app()->getLocale());
            $mpdf = new Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            foreach ($products as $product) {
                if($product->price_of_currency) {
                    $mpdf->WriteHTML(view('categories.products.barcodes', ['product' => $product,'rtl' => $currenctLang->rtl])->render());
                } else {
                    if($product->variants) {
                        if($product->variants->count() > 0) {
                            foreach ($product->variants as $variant) {
                                $mpdf->WriteHTML(view('categories.products.barcodes', ['product' => $product,'rtl' => $currenctLang->rtl, 'variant' => $variant])->render());
                            }
                        }
                    }
                }

            }
            $mpdf->Output('invoices/products_barcodes.pdf');
            return redirect()->to(asset('invoices/' . 'products_barcodes' . '.pdf'));
        }
        $products = $products->paginate(10);

        return view('categories.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('products.create');
        $categories = Category::latest()->get();
        if(count($categories) > 0) {
            return view('categories.products.create', compact('categories'));
        } else {
            return redirect()->back()->with('error', translate('you should create category first'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('products.create');
        $validator_array = [
            'name' => 'required',
            'count' => 'integer',
            'category_id' => ['required', 'exists:categories,id'],
            'product_prices.price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'product_prices.discount' => 'regex:/^\d+(\.\d{1,2})?$/',
            'viewed_number' => 'integer',
        ];
        $validator_array_msgs = [
            'name.required' => translate('the name is required'),
            'category_id.required' => translate('the category is required'),
            'category_id.exists' => translate('the category should be exists'),
            'product_prices.price.required' => translate('the price is required'),
            'product_prices.price.regex' => translate('the price should be a number'),
            'product_prices.discount.regex' => translate('the discount should be a number'),
            'viewed_number.integer' => translate('the viewed number should be a number'),
        ];
        if(isset($request->extras_type)) {
            if($request->extras) {
                $validator_array['extras.*.variant'] = 'required';
                $validator_array['extras.*.prices.price'] = 'required';
                $validator_array['extras.*.prices.price'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array_msgs['extras.*.variant.required'] = translate('the extra is required');
                $validator_array_msgs['extras.*.prices.price.required'] = translate('the price is required');
                $validator_array_msgs['extras.*.prices.price.regex'] = translate('the price should be a number');
            }
            if($request->sizes) {
                unset($validator_array['product_prices.price']);
                unset($validator_array['product_prices.discount']);
                $validator_array['sizes.*.variant'] = 'required';
                $validator_array['sizes.*.prices.price'] = 'required';
                $validator_array['sizes.*.prices.price'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array['sizes.*.prices.discount'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array_msgs['sizes.*.variant.required'] = translate('the size is required');
                $validator_array_msgs['sizes.*.prices.price.required'] = translate('the price is required');;
                $validator_array_msgs['sizes.*.prices.price.regex'] = translate('the price should be a number');
                $validator_array_msgs['sizes.*.prices.discount.regex'] = translate('the discount should be a number');
            }
        }
        $validator = Validator::make($request->all(), $validator_array, $validator_array_msgs);
        $creation = [
            'name' => $request->name,
            'count' => $request->count,
            'sku' => $request->sku,
            'description' => $request->description,
            'viewed_number' => $request->viewed_number
        ];
        if($request->has('active') && $request->active == 'on') {
            $creation['active'] = 1;
        } else {
            $updateArray['active'] = 0;
        }

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', translate('there is something error'));
        }
        if($request->has('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photos[] = $this->uploadFiles($photo, $this->productsPath);
            }
            $creation['photos'] = json_encode($photos);
        }
        if($request->sizes) {
            $creation['price'] = 0;
            $creation['discount'] = 0;
            $creation['price_after_discount'] = 0;
        }
        $product = Product::create($creation);

        // Categories to product
        if(is_array($request->category_id)) {
            foreach ($request->category_id as $value) {
                $product->categories()->attach($value);
            }
        } else {
            $product->categories()->attach($request->category_id);
        }
        // Create Product Prices
        if($request->has('product_prices')) {
            $product_price['price'] = doubleval($request->product_prices['price']);
            $product_price['discount'] = doubleval($request->product_prices['discount']);
            ProductPrice::create([
                'product_id' => $product->id,
                'price' => $product_price['price'],
                'discount' => $product_price['discount'],
                'price_after_discount' => ($product_price['price'] - $product_price['discount'])
            ]);
        }
        if($request->extras) {
            foreach ($request->extras as $extra) {
                $productVariant = ProductVariant::create([
                    'product_id' => $product->id,
                    'type' => 'extra',
                    'variant' => $extra['variant']
                ]);
                // Create Product Variactions Price With Currency
                $extraPrice['price'] = doubleval($extra['prices']['price']);
                ProductVariantPrice::create([
                    'product_id' => $product->id,
                    'variant_id' => $productVariant->id,
                    'price' => $extraPrice['price'],
                    'price_after_discount' => $extraPrice['price']
                ]);
            }
        }
        if($request->sizes) {
            foreach ($request->sizes as $size) {
                $productVariant = ProductVariant::create([
                    'product_id' => $product->id,
                    'type' => 'size',
                    'variant' => $size['variant'],
                    'count' => $size['count']
                ]);
                // Create Product Variactions Price With Currency
                $sizePrice['price'] = doubleval($size['prices']['price']);
                $sizePrice['discount'] = doubleval($size['prices']['discount']);
                ProductVariantPrice::create([
                    'product_id' => $product->id,
                    'variant_id' => $productVariant->id,
                    'price' => $sizePrice['price'],
                    'discount' => $sizePrice['discount'],
                    'price_after_discount' => ($sizePrice['price'] - $sizePrice['discount'])
                ]);
            }
        }
        return redirect()->back()->with('success', translate('created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->authorize('products.show');
        return view('categories.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('products.edit');
        $categories = Category::latest()->get();


        if(count($categories) > 0) {
            return view('categories.products.edit', compact('product', 'categories'));
        } else {
            return redirect()->back()->with('error', translate('you should create category first'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('products.edit');
        $updateArray = [
            'name' => $request->name,
            'count' => $request->count,
            'sku' => $request->sku,
            'description' => $request->description,
            'viewed_number' => $request->viewed_number
        ];
        $validator_array = [
            'name' => 'required',
            'count' => 'integer',
            'category_id' => ['required', 'exists:categories,id'],
            'product_prices.price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'product_prices.discount' => 'regex:/^\d+(\.\d{1,2})?$/',
            'viewed_number' => 'integer',
        ];
        $validator_array_msgs = [
            'name.required' => translate('the name is required'),
            'category_id.required' => translate('the category is required'),
            'category_id.exists' => translate('the category should be exists'),
            'product_prices.price.required' => translate('the price is required'),
            'product_prices.price.regex' => translate('the price should be a number'),
            'product_prices.discount.regex' => translate('the discount should be a number'),
            'viewed_number.integer' => translate('the viewed number should be a number'),
        ];
        if(isset($request->extras_type)) {
            if($request->extras) {
                $validator_array['extras.*.variant'] = 'required';
                $validator_array['extras.*.prices.price'] = 'required';
                $validator_array['extras.*.prices.price'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array_msgs['extras.*.variant.required'] = translate('the extra is required');
                $validator_array_msgs['extras.*.prices.price.required'] = translate('the price is required');
                $validator_array_msgs['extras.*.prices.price.regex'] = translate('the price should be a number');
            }
            if($request->sizes) {
                unset($validator_array['product_prices.price']);
                unset($validator_array['product_prices.discount']);
                $validator_array['sizes.*.variant'] = 'required';
                $validator_array['sizes.*.prices.price'] = 'required';
                $validator_array['sizes.*.prices.price'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array['sizes.*.prices.discount'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array_msgs['sizes.*.variant.required'] = translate('the size is required');
                $validator_array_msgs['sizes.*.prices.price.required'] = translate('the price is required');;
                $validator_array_msgs['sizes.*.prices.price.regex'] = translate('the price should be a number');
                $validator_array_msgs['sizes.*.prices.discount.regex'] = translate('the discount should be a number');
            }
        }

        $validator = Validator::make($request->all(), $validator_array, $validator_array_msgs);

        if($request->has('active') && $request->active == 'on') {
            $updateArray['active'] = 1;
        } else {
            $updateArray['active'] = 0;
        }

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', translate('there is something error'));
        }
        if($request->has('photos')) {
            // Remove Current Photo
            $this->removePhotos($product);
            // Upload New Photos
            foreach ($request->file('photos') as $photo) {
                $photos[] = $this->uploadFiles($photo, $this->productsPath);
            }
            $updateArray['photos'] = json_encode($photos);
        }


        $product->update($updateArray);
        $prod_price = ProductPrice::where('product_id', $product->id)->first();
        // Remove Categories
        foreach ($product->categories as $category) {
            $product->categories()->detach($category);
        }
        // Add Categories
        if(is_array($request->category_id)) {
            foreach ($request->category_id as $value) {
                $product->categories()->attach($value);
            }
        } else {
            $product->categories()->attach($request->category_id);
        }
        // Create Product Prices With Currencies
        if($request->has('product_prices')) {
            $product_price['price'] = doubleval($request->product_prices['price']);
            $product_price['discount'] = doubleval($request->product_prices['discount']);
            if($prod_price) {
                $prod_price->update([
                    'price' => $product_price['price'],
                    'discount' => $product_price['discount'],
                    'price_after_discount' => ($product_price['price'] - $product_price['discount'])
                ]);
            }
        }
        if($request->extras) {
            foreach ($request->extras as $extra) {
                $extraPrice['price'] = doubleval($extra['prices']['price']);
                if(isset($extra['variant_id'])) {
                    $productVariant = ProductVariant::find($extra['variant_id']);
                    $productVariant->update([
                        'variant' => $extra['variant'],
                        'count' => $extra['count']
                    ]);
                    $variant_price = ProductVariantPrice::where('variant_id', $extra['variant_id'])->first();
                    if($variant_price) {
                        $variant_price->update([
                            'price' => $extraPrice['price'],
                            'price_after_discount' => $extraPrice['price']
                        ]);
                    }
                } else {
                    $productVariant = ProductVariant::create([
                        'product_id' => $product->id,
                        'type' => 'extra',
                        'variant' => $extra['variant']
                    ]);
                    // Create Product Variactions Price With Currency
                    ProductVariantPrice::create([
                        'product_id' => $product->id,
                        'variant_id' => $productVariant->id,
                        'price' => $extraPrice['price'],
                        'price_after_discount' => $extraPrice['price']
                    ]);
                }
            }
        }
        if($request->sizes) {
            foreach ($request->sizes as $size) {
                $sizePrice['price'] = doubleval($size['prices']['price']);
                $sizePrice['discount'] = doubleval($size['prices']['discount']);
                if(isset($size['variant_id'])) {
                    $productVariant = ProductVariant::find($size['variant_id']);
                    $productVariant->update([
                        'variant' => $size['variant'],
                        'count' => $size['count']
                    ]);
                    // Update Product Variactions Price With Currency
                    $variant_price = ProductVariantPrice::where('variant_id', $size['variant_id'])->first();
                    if($variant_price) {
                        $variant_price->update([
                            'price' => $sizePrice['price'],
                            'discount' => $sizePrice['discount'],
                            'price_after_discount' => ($sizePrice['price'] - $sizePrice['discount'])
                        ]);
                    }
                } else {
                    $productVariant = ProductVariant::create([
                        'product_id' => $product->id,
                        'type' => 'size',
                        'variant' => $size['variant'],
                        'count' => $size['count']
                    ]);
                    // Create Product Variactions Price With Currency
                    ProductVariantPrice::create([
                        'product_id' => $product->id,
                        'variant_id' => $productVariant->id,
                        'price' => $sizePrice['price'],
                        'discount' => $sizePrice['discount'],
                        'price_after_discount' => ($sizePrice['price'] - $sizePrice['discount'])
                    ]);
                }
            }
        }
        return redirect()->back()->with('info', translate('updated successfully'));
    }

    public function removePhotos(Product $product) {
        if($product->photos) {
            foreach (json_decode($product->photos) as $photo) {
                if(file_exists($photo)) {
                    unlink($photo);
                }
            }
        }
    }


    public function all_by_ids(Request $request) {
        $products = Product::with(['price_of_currency' => function($query) use($request) {
            return $query;
        },'variants.currenctPriceOfVariant' => function($variantQuery) use($request) {
            return $variantQuery;
        }])->whereIn('id', $request->ids)->get();
        return $request->json('data', $products);
    }

    public function variant_price(Request $request) {
        $product_price = ProductVariantPrice::where('variant_id', $request->variant_id)->first();
        return $request->json('data', $product_price);
    }

    public function allByBranchId(Request $request) {
        if($request->type == 'inhouse') {
            $products_ids_of_branch = BranchProductQty::where('branch_id', $request->branch_id)->pluck('product_id');
            $products_variants_ids_of_branch = BranchProductQty::
            where('branch_id' , $request->branch_id)
            ->where('qty' , '>', 0)
            ->pluck('variant_id');

            $products = Product::with(['variants' => function($variants) use($products_variants_ids_of_branch) {
                return $variants->whereIn('id', $products_variants_ids_of_branch);
            }, 'price_of_currency'])
            ->whereIn('id', $products_ids_of_branch)
            ->orderBy('name')->get();
        } else if($request->type == null) {
            $products = Product::with('variants', 'price_of_currency')->orderBy('name')->get();
        }
        if(count($products) > 0) {
            return $this->sendRes('', true, $products);
        } else {
            return $this->sendRes(translate('there is no products in the branch yet'), false);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy_variant(Request $request) {
        $variant = ProductVariant::find($request->variant);
        if($variant) {
            $variant->delete();
            if($variant->barcode !== null) {
                if(file_exists('products_barcodes/' . $variant->barcode)) {
                    unlink('products_barcodes/' . $variant->barcode);
                }
            }
            return redirect()->back()->with('success', translate('removed successfully !'));
        }
    }

    public function destroy(Product $product)
    {
        $this->authorize('products.destroy');
        if($product->photos) {
            $this->removePhotos($product);
        }
        Product::destroy($product->id);
        return redirect()->back()->with('error', translate('deleted successfully'));
    }
}
