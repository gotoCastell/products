<?php

namespace App\Http\Controllers\Models;

use Exception;
use App\Models\Product;
use App\Models\Resource;
use Illuminate\Http\Request;
use App\Models\ResourceProduct;
use App\Models\Catalogs\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Classes\Eloquent\Domain\Enum\Constants;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::with('resource_product.resource')->get();
        return view('models.product.product', compact('products'));
    }

    public function create(Request $request)
    {
        $product = $request->query('id') ? Product::find($request->query('id')) : null;
        $category = Category::all();
        return view('models.product.create', compact('category', 'product'));
    }

    public function details(Request $request)
    {
        $product = Product::find($request->query('id'));
        return view('models.product.details', compact('product'));
    }

    public function store(Request $request)
    {
        try {
            $status = Constants::ACTIVE;
            $message = '';

            $rules = [
                Product::NAME => 'required|max:255',
                Product::MODEL_YEAR => 'required|max:4',
                Product::PRICE => 'required|max:4',
                Product::CATEGORIES_ID => 'required',
            ];

            if ($request->{Product::ID}) {
                $rules[Product::STATUS] = 'required';
                $rules[Product::ID] = 'required';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->route('products.create-edit', [Product::ID => $request->{Product::ID}])
                    ->withErrors($validator)
                    ->withInput()->with([
                        'status' => $status,
                        'message' => $message,
                    ]);
            }

            DB::beginTransaction();


            if ($request->{Product::ID}) {
                $message = 'Product updated!';
                $product = Product::find($request->{Product::ID});
                $product->{Product::NAME} = $request->{Product::NAME};
                $product->{Product::MODEL_YEAR} = $request->{Product::MODEL_YEAR};
                $product->{Product::PRICE} = $request->{Product::PRICE};
                $product->{Product::STATUS} = $request->{Product::STATUS};
                $product->{Product::CATEGORIES_ID} = $request->{Product::CATEGORIES_ID};
                $product->save();
            } else {

                $message = 'Product created!';
                $product = Product::create([
                    Product::NAME => $request->{Product::NAME},
                    Product::MODEL_YEAR => $request->{Product::MODEL_YEAR},
                    Product::PRICE => $request->{Product::PRICE},
                    Product::STATUS => Constants::ACTIVE,
                    Product::CATEGORIES_ID => $request->{Product::CATEGORIES_ID},
                ]);
            }


            $photos = [];
            if ($request->file('photos')) {
                foreach ($request->file('photos') as $key => $file) {
                    $file_name = time() . rand(1, 99) . '.' . $file->extension();
                    $file->move(public_path('uploads'), $file_name);
                    $photos[] = [
                        Resource::NAME => $file_name,
                        Resource::URL => '/uploads/',
                        Resource::CAT_RESOURCE_TYPES_ID => Constants::PHOTO,
                    ];
                }
            }

            $videos = [];
            if ($request->file('videos')) {
                foreach ($request->file('videos') as $key => $file) {
                    $file_name = time() . rand(1, 99) . '.' . $file->extension();
                    $file->move(public_path('uploads'), $file_name);
                    $videos[] = [
                        Resource::NAME => $file_name,
                        Resource::URL => '/uploads/',
                        Resource::CAT_RESOURCE_TYPES_ID => Constants::VIDEO,
                    ];
                }
            }

            foreach ($photos as $key => $file) {
                $resource = Resource::create($file);
                ResourceProduct::create([
                    ResourceProduct::PRODUCTS_ID => $product->id,
                    ResourceProduct::RESOURCES_ID => $resource->id,
                ]);
            }

            foreach ($videos as $key => $file) {
                $resource = Resource::create($file);
                ResourceProduct::create([
                    ResourceProduct::PRODUCTS_ID => $product->id,
                    ResourceProduct::RESOURCES_ID => $resource->id,
                ]);
            }

            DB::commit();
            return redirect()->route('products')->with([
                'status' => $status,
                'message' => $message,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $status = Constants::INACTIVE;
            $message = 'Error product!';
            Log::debug($e);
            return redirect()->route('products')->with([
                'status' => $status,
                'message' => $message,
            ]);
        }
    }

    public function delete(Request $request)
    {
        $status = Constants::ACTIVE;
        $message = 'Product deleted!';
        try {
            DB::beginTransaction();

            $product = Product::find($request->{Product::ID});
            $product->delete();
            DB::commit();
            return redirect()->route('products')->with([
                'status' => $status,
                'message' => $message,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $status = Constants::INACTIVE;
            $message = 'Error when deleting product!';
            return redirect()->route('products')->with([
                'status' => $status,
                'message' => $message,
            ]);
        }
    }


    public function deleteResource(Request $request)
    {
        try {
            DB::beginTransaction();
            $status = Constants::SUCCESS;
            $message = 'Resource deleted!';
            $resourceproduct = ResourceProduct::find($request->{Product::ID});

            $product_id = $resourceproduct->{ResourceProduct::PRODUCTS_ID};

            $resource = Resource::find($resourceproduct->{ResourceProduct::RESOURCES_ID});

            $url = public_path($resource->{Resource::URL} . $resource->{Resource::NAME});

            if (file_exists($url)) {
                File::delete($url);
            }

            $resource->delete();
            $resourceproduct->delete();
            DB::commit();
            return redirect()->route('products.details', ['id' => $product_id])->with([
                'status' => $status,
                'message' => $message,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $status = Constants::ERROR;
            $message = 'Error when deleting resource!';
            return redirect()->route('products.details', ['id' => $product_id])->with([
                'status' => $status,
                'message' => $message,
            ]);
        }
    }
}
